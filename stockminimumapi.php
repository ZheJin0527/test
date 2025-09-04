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

// 获取所有货品和设置列表
function getProductsWithSettings() {
    global $pdo;
    
    try {
        // 获取所有货品的当前库存
        $sql = "SELECT 
                    product_name,
                    SUM(CASE WHEN in_quantity > 0 THEN in_quantity ELSE 0 END) - 
                    SUM(CASE WHEN out_quantity > 0 THEN out_quantity ELSE 0 END) as current_stock
                FROM stockinout_data 
                WHERE product_name IS NOT NULL AND product_name != ''
                GROUP BY product_name
                ORDER BY product_name ASC";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $stockData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // 获取最低库存设置
        $settingsSQL = "SELECT product_name, minimum_quantity, is_active 
                       FROM stock_minimum_settings";
        $settingsStmt = $pdo->prepare($settingsSQL);
        $settingsStmt->execute();
        $settingsData = $settingsStmt->fetchAll(PDO::FETCH_ASSOC);
        
        // 创建设置映射
        $settingsMap = [];
        foreach ($settingsData as $setting) {
            $settingsMap[$setting['product_name']] = $setting;
        }
        
        // 组合数据
        $result = [];
        foreach ($stockData as $stock) {
            $productName = $stock['product_name'];
            $currentStock = floatval($stock['current_stock']);
            $setting = $settingsMap[$productName] ?? null;
            
            $result[] = [
                'product_name' => $productName,
                'current_stock' => $currentStock,
                'formatted_current_stock' => number_format($currentStock, 2),
                'minimum_quantity' => $setting ? floatval($setting['minimum_quantity']) : 0.00,
                'is_active' => $setting ? (bool)$setting['is_active'] : false
            ];
        }
        
        return $result;
        
    } catch (PDOException $e) {
        throw new Exception("查询货品数据失败：" . $e->getMessage());
    }
}

// 保存单个货品设置
function saveSingleSetting($productName, $minimumQuantity, $isActive) {
    global $pdo;
    
    try {
        $sql = "INSERT INTO stock_minimum_settings (product_name, minimum_quantity, is_active) 
                VALUES (?, ?, ?) 
                ON DUPLICATE KEY UPDATE 
                minimum_quantity = VALUES(minimum_quantity), 
                is_active = VALUES(is_active),
                updated_at = CURRENT_TIMESTAMP";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$productName, $minimumQuantity, $isActive ? 1 : 0]);
        
        return true;
        
    } catch (PDOException $e) {
        throw new Exception("保存设置失败：" . $e->getMessage());
    }
}

// 批量保存设置
function saveBatchSettings($products) {
    global $pdo;
    
    try {
        $pdo->beginTransaction();
        
        $sql = "INSERT INTO stock_minimum_settings (product_name, minimum_quantity, is_active) 
                VALUES (?, ?, ?) 
                ON DUPLICATE KEY UPDATE 
                minimum_quantity = VALUES(minimum_quantity), 
                is_active = VALUES(is_active),
                updated_at = CURRENT_TIMESTAMP";
        
        $stmt = $pdo->prepare($sql);
        
        foreach ($products as $product) {
            $stmt->execute([
                $product['product_name'],
                $product['minimum_quantity'],
                $product['is_active'] ? 1 : 0
            ]);
        }
        
        $pdo->commit();
        return true;
        
    } catch (PDOException $e) {
        $pdo->rollback();
        throw new Exception("批量保存失败：" . $e->getMessage());
    }
}

// 主要路由处理
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $action = $_GET['action'] ?? 'list';
    
    switch ($action) {
        case 'list':
            try {
                $result = getProductsWithSettings();
                sendResponse(true, "货品设置数据获取成功", $result);
            } catch (Exception $e) {
                sendResponse(false, $e->getMessage());
            }
            break;
            
        default:
            sendResponse(false, "无效的操作");
    }
    
} elseif ($method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input) {
        sendResponse(false, "无效的JSON数据");
    }
    
    $action = $input['action'] ?? '';
    
    switch ($action) {
        case 'save_single':
            try {
                $productName = $input['product_name'] ?? '';
                $minimumQuantity = floatval($input['minimum_quantity'] ?? 0);
                
                if (empty($productName)) {
                    sendResponse(false, "货品名称不能为空");
                }
                
                saveSingleSetting($productName, $minimumQuantity);
                sendResponse(true, "设置保存成功");
                
            } catch (Exception $e) {
                sendResponse(false, $e->getMessage());
            }
            break;
            
        case 'save_batch':
            try {
                $products = $input['products'] ?? [];
                
                if (empty($products)) {
                    sendResponse(false, "没有要保存的数据");
                }
                
                // 验证数据格式
                foreach ($products as $product) {
                    if (empty($product['product_name'])) {
                        sendResponse(false, "货品名称不能为空");
                    }
                }
                
                saveBatchSettings($products);
                sendResponse(true, "批量保存成功");
                
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