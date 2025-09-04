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

// 获取库存汇总数据（从stock_data表）
function getStockSummary() {
    global $pdo;
    
    try {
        // 从stock_data表获取所有货品
        $sql = "SELECT 
                    id,
                    product_code,
                    product_name,
                    supplier,
                    date,
                    applicant,
                    approver
                FROM stock_data 
                ORDER BY product_name ASC";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $stockData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $summaryData = [];
        $counter = 1;
        
        foreach ($stockData as $row) {
            $summaryData[] = [
                'no' => $counter++,
                'id' => $row['id'],
                'product_name' => $row['product_name'],
                'code_number' => $row['product_code'],
                'supplier' => $row['supplier'],
                'date' => $row['date'],
                'applicant' => $row['applicant'],
                'approver' => $row['approver'] ?? '未批准',
                'total_stock' => 0, // stock_data表没有库存数量字段，设为0
                'specification' => '',
                'price' => 0,
                'total_price' => 0,
                'formatted_stock' => '0.00',
                'formatted_price' => '0.00',
                'formatted_total_price' => '0.00'
            ];
        }
        
        return [
            'summary' => $summaryData,
            'total_value' => 0,
            'formatted_total_value' => '0.00',
            'total_products' => count($summaryData)
        ];
        
    } catch (PDOException $e) {
        throw new Exception("查询库存数据失败：" . $e->getMessage());
    }
}

// 获取低库存货品（基于stock_data表）
function getLowStockItems() {
    global $pdo;
    
    try {
        $sql = "SELECT 
                    s.id,
                    s.product_name,
                    s.product_code,
                    s.supplier,
                    s.date,
                    COALESCE(t.min_threshold, 10.00) as threshold
                FROM stock_data s
                LEFT JOIN stock_thresholds t ON s.product_name = t.product_name
                WHERE COALESCE(t.min_threshold, 10.00) > 0
                ORDER BY s.product_name ASC";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // 由于stock_data表没有实际库存数量，我们假设所有货品都可能库存不足
        // 实际使用中，您需要根据业务逻辑来判断哪些货品库存不足
        $lowStockItems = [];
        foreach ($results as $row) {
            $lowStockItems[] = [
                'product_name' => $row['product_name'],
                'code_number' => $row['product_code'],
                'specification' => '',
                'current_stock' => 0,
                'formatted_stock' => '0.00',
                'threshold' => floatval($row['threshold'])
            ];
        }
        
        return $lowStockItems;
        
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

// 获取所有货品的阈值设置
function getAllThresholds() {
    global $pdo;
    
    try {
        $sql = "SELECT product_name, min_threshold, updated_at 
                FROM stock_thresholds 
                ORDER BY product_name ASC";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $thresholds = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // 转换为关联数组，方便前端使用
        $result = [];
        foreach ($thresholds as $threshold) {
            $result[$threshold['product_name']] = [
                'threshold' => floatval($threshold['min_threshold']),
                'updated_at' => $threshold['updated_at']
            ];
        }
        
        return $result;
        
    } catch (PDOException $e) {
        throw new Exception("获取阈值数据失败：" . $e->getMessage());
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

        case 'get-thresholds':
            try {
                $thresholds = getAllThresholds();
                sendResponse(true, "阈值数据获取成功", ['thresholds' => $thresholds]);
            } catch (Exception $e) {
                sendResponse(false, $e->getMessage());
            }
            break;

        case 'summary-with-thresholds':
            try {
                $result = getStockSummaryWithThresholds();
                sendResponse(true, "库存阈值汇总数据获取成功", ['products' => $result]);
            } catch (Exception $e) {
                sendResponse(false, $e->getMessage());
            }
            break;
            
        default:
            sendResponse(false, "无效的操作");
    }
} else {
    sendResponse(false, "不支持的请求方法");
}
?>