<?php
ob_start();
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// 处理预检请求
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    ob_end_clean();
    http_response_code(200);
    exit;
}

ini_set('display_errors', 1);
error_reporting(E_ALL);

// 数据库配置
$host = 'localhost';
$dbname = 'u857194726_kunzzgroup';
$dbuser = 'u857194726_kunzzgroup';
$dbpass = 'Kholdings1688@';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    ob_end_clean();
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "数据库连接失败：" . $e->getMessage()]);
    exit;
}

function sendResponse($success, $message = "", $data = null) {
    ob_end_clean();
    echo json_encode([
        "success" => $success,
        "message" => $message,
        "data" => $data
    ]);
    exit;
}

// 获取库存汇总数据
function getStockSummary() {
    global $pdo;
    
    try {
        // 查询汇总数据：按产品名称、规格、价格分组计算库存
        $sql = "SELECT 
                    product_name,
                    specification,
                    price,
                    code_number,
                    SUM(CASE WHEN in_quantity > 0 THEN in_quantity ELSE 0 END) as total_in,
                    SUM(CASE WHEN out_quantity > 0 THEN out_quantity ELSE 0 END) as total_out,
                    (SUM(CASE WHEN in_quantity > 0 THEN in_quantity ELSE 0 END) - 
                     SUM(CASE WHEN out_quantity > 0 THEN out_quantity ELSE 0 END)) as current_stock
                FROM stockinout_data 
                WHERE product_name IS NOT NULL AND product_name != ''
                GROUP BY product_name, specification, price, code_number
                HAVING current_stock > 0
                ORDER BY product_name ASC, price ASC";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $stockData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // 计算总价值
        $totalValue = 0;
        $summaryData = [];
        $counter = 1;
        
        foreach ($stockData as $row) {
            $currentStock = floatval($row['current_stock']);
            $price = floatval($row['price']);
            $totalPrice = $currentStock * $price;
            $totalValue += $totalPrice;
            
            $summaryData[] = [
                'no' => $counter++,
                'product_name' => $row['product_name'],
                'code_number' => $row['code_number'] ?? '',
                'total_stock' => $currentStock,
                'specification' => $row['specification'] ?? '',
                'price' => $price,
                'total_price' => $totalPrice,
                'formatted_stock' => number_format($currentStock, 2),
                'formatted_price' => number_format($price, 2),
                'formatted_total_price' => number_format($totalPrice, 2)
            ];
        }
        
        return [
            'summary' => $summaryData,
            'total_value' => $totalValue,
            'formatted_total_value' => number_format($totalValue, 2),
            'total_products' => count($summaryData)
        ];
        
    } catch (PDOException $e) {
        throw new Exception("查询库存数据失败：" . $e->getMessage());
    }
}

// 检查低库存
function checkLowStock() {
    global $pdo;
    
    try {
        // 获取所有货品的当前库存和最低库存设置
        $sql = "SELECT DISTINCT
                    sd.id,
                    sd.product_name,
                    sd.specification,
                    COALESCE(sd.min_stock, 0) as min_stock,
                    COALESCE(
                        (SELECT 
                            SUM(CASE WHEN in_quantity > 0 THEN in_quantity ELSE 0 END) - 
                            SUM(CASE WHEN out_quantity > 0 THEN out_quantity ELSE 0 END)
                         FROM stockinout_data 
                         WHERE product_name = sd.product_name 
                         AND COALESCE(specification, '') = COALESCE(sd.specification, '')
                        ), 0
                    ) as current_stock
                FROM stock_data sd
                HAVING current_stock <= min_stock AND min_stock > 0
                ORDER BY current_stock ASC, product_name ASC";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $lowStockItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return [
            'low_stock_items' => $lowStockItems,
            'total_low_stock' => count($lowStockItems)
        ];
        
    } catch (PDOException $e) {
        throw new Exception("检查低库存失败：" . $e->getMessage());
    }
}

// 获取库存设置
function getStockSettings() {
    global $pdo;
    
    try {
        $sql = "SELECT 
                    id,
                    product_name,
                    specification,
                    COALESCE(min_stock, 0) as min_stock,
                    COALESCE(
                        (SELECT 
                            SUM(CASE WHEN in_quantity > 0 THEN in_quantity ELSE 0 END) - 
                            SUM(CASE WHEN out_quantity > 0 THEN out_quantity ELSE 0 END)
                         FROM stockinout_data 
                         WHERE product_name = stock_data.product_name 
                         AND COALESCE(specification, '') = COALESCE(stock_data.specification, '')
                        ), 0
                    ) as current_stock
                FROM stock_data 
                ORDER BY product_name ASC";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return [
            'products' => $products,
            'total_products' => count($products)
        ];
        
    } catch (PDOException $e) {
        throw new Exception("获取设置失败：" . $e->getMessage());
    }
}

// 保存库存设置
function saveStockSettings($settings) {
    global $pdo;
    
    try {
        $pdo->beginTransaction();
        
        $sql = "UPDATE stock_data SET min_stock = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        
        $updated = 0;
        foreach ($settings as $setting) {
            $stmt->execute([
                floatval($setting['min_stock']),
                intval($setting['product_id'])
            ]);
            if ($stmt->rowCount() > 0) {
                $updated++;
            }
        }
        
        $pdo->commit();
        
        return [
            'updated_count' => $updated,
            'total_settings' => count($settings)
        ];
        
    } catch (PDOException $e) {
        $pdo->rollback();
        throw new Exception("保存设置失败：" . $e->getMessage());
    }
}

// 主要路由处理
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $action = $_GET['action'] ?? 'summary';
    
    switch ($action) {
        case 'summary':
            try {
                $result = getStockSummary();
                sendResponse(true, "库存汇总数据获取成功", $result);
            } catch (Exception $e) {
                sendResponse(false, $e->getMessage());
            }
            break;
            
        case 'export':
            // 导出功能（可选实现）
            try {
                $result = getStockSummary();
                
                // 设置CSV头信息
                header('Content-Type: text/csv; charset=utf-8');
                header('Content-Disposition: attachment; filename="stock_summary_' . date('Y-m-d') . '.csv"');
                
                ob_end_clean();
                
                // 创建CSV输出
                $output = fopen('php://output', 'w');
                
                // 写入BOM以支持中文
                fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
                
                // 写入表头
                fputcsv($output, ['No', 'Product Name', 'Code Number', 'Total Stock', 'Specification', 'Unit Price (RM)', 'Total Price (RM)']);
                
                // 写入数据
                foreach ($result['summary'] as $row) {
                    fputcsv($output, [
                        $row['no'],
                        $row['product_name'],
                        $row['code_number'],
                        $row['formatted_stock'],
                        $row['specification'],
                        $row['formatted_price'],
                        $row['formatted_total_price']
                    ]);
                }
                
                // 写入总计
                fputcsv($output, ['', '', '', '', '', 'Total Value:', $result['formatted_total_value']]);
                
                fclose($output);
                exit;
                
            } catch (Exception $e) {
                sendResponse(false, "导出失败：" . $e->getMessage());
            }
            break;

        case 'check_low_stock':
            try {
                $result = checkLowStock();
                sendResponse(true, "低库存检查完成", $result);
            } catch (Exception $e) {
                sendResponse(false, $e->getMessage());
            }
            break;
            
        case 'get_stock_settings':
            try {
                $result = getStockSettings();
                sendResponse(true, "获取设置成功", $result);
            } catch (Exception $e) {
                sendResponse(false, $e->getMessage());
            }
            break;
            
        default:
            sendResponse(false, "无效的操作");
    }
} elseif ($method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $action = $input['action'] ?? '';
    
    switch ($action) {
        case 'save_stock_settings':
            try {
                $settings = $input['settings'] ?? [];
                $result = saveStockSettings($settings);
                sendResponse(true, "设置保存成功", $result);
            } catch (Exception $e) {
                sendResponse(false, $e->getMessage());
            }
            break;
            
        default:
            sendResponse(false, "无效的POST操作");
    }
} else {
    sendResponse(false, "不支持的请求方法");
}
?>