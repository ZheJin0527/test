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

// 获取低库存货品
function getLowStockItems() {
    global $pdo;
    
    try {
        $sql = "SELECT 
                    s.product_name,
                    s.specification,
                    s.code_number,
                    s.current_stock,
                    s.formatted_stock,
                    COALESCE(t.min_threshold, 10.00) as threshold
                FROM (
                    SELECT 
                        product_name,
                        specification,
                        code_number,
                        (SUM(CASE WHEN in_quantity > 0 THEN in_quantity ELSE 0 END) - 
                         SUM(CASE WHEN out_quantity > 0 THEN out_quantity ELSE 0 END)) as current_stock,
                        CONCAT(FORMAT((SUM(CASE WHEN in_quantity > 0 THEN in_quantity ELSE 0 END) - 
                                     SUM(CASE WHEN out_quantity > 0 THEN out_quantity ELSE 0 END)), 2)) as formatted_stock
                    FROM stockinout_data 
                    WHERE product_name IS NOT NULL AND product_name != ''
                    GROUP BY product_name, specification, code_number
                    HAVING current_stock > 0
                ) s
                LEFT JOIN stock_thresholds t ON s.product_name = t.product_name
                WHERE s.current_stock <= COALESCE(t.min_threshold, 10.00)
                ORDER BY s.current_stock ASC";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    } catch (PDOException $e) {
        throw new Exception("查询低库存数据失败：" . $e->getMessage());
    }
}

// 设置货品库存阈值
function setStockThreshold($productName, $threshold) {
    global $pdo;
    
    try {
        $sql = "INSERT INTO stock_thresholds (product_name, min_threshold) 
                VALUES (?, ?) 
                ON DUPLICATE KEY UPDATE 
                min_threshold = VALUES(min_threshold), 
                updated_at = CURRENT_TIMESTAMP";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$productName, $threshold]);
        
        return true;
    } catch (PDOException $e) {
        throw new Exception("设置库存阈值失败：" . $e->getMessage());
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

        case 'low-stock':
            try {
                $lowStockItems = getLowStockItems();
                sendResponse(true, "低库存数据获取成功", ['items' => $lowStockItems]);
            } catch (Exception $e) {
                sendResponse(false, $e->getMessage());
            }
            break;

        case 'set-threshold':
            if ($method === 'POST') {
                $input = json_decode(file_get_contents('php://input'), true);
                $productName = $input['product_name'] ?? '';
                $threshold = $input['threshold'] ?? 0;
                
                if (empty($productName) || $threshold < 0) {
                    sendResponse(false, "产品名称和阈值不能为空且阈值不能为负数");
                }
                
                try {
                    setStockThreshold($productName, $threshold);
                    sendResponse(true, "库存阈值设置成功");
                } catch (Exception $e) {
                    sendResponse(false, $e->getMessage());
                }
            } else {
                sendResponse(false, "只支持POST请求");
            }
            break;
            
        default:
            sendResponse(false, "无效的操作");
    }
} else {
    sendResponse(false, "不支持的请求方法");
}
?>