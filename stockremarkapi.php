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

// 获取多价格产品分析数据
function getMultiPriceAnalysis() {
    global $pdo;
    
    try {
        // 获取所有product_remark_checked=1的记录
        $sql = "SELECT 
                    product_name,
                    specification,
                    price,
                    code_number,
                    remark_number,
                    in_quantity,
                    out_quantity,
                    date,
                    time,
                    receiver
                FROM stockinout_data 
                WHERE product_remark_checked = 1 
                AND product_name IS NOT NULL 
                AND product_name != ''
                AND remark_number IS NOT NULL 
                AND remark_number != ''
                ORDER BY product_name ASC, remark_number ASC, date DESC";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $remarkData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // 按产品名称分组
        $productGroups = [];

        foreach ($remarkData as $row) {
            $productName = $row['product_name'];
            $remarkNumber = $row['remark_number'];
            
            // 只使用产品名称作为分组标识
            $groupKey = $productName;
            
            if (!isset($productGroups[$groupKey])) {
                $productGroups[$groupKey] = [
                    'product_name' => $productName,
                    'variants' => []
                ];
            }
            
            // 创建备注编号的唯一标识
            $remarkKey = $remarkNumber;
            
            if (!isset($productGroups[$groupKey]['variants'][$remarkKey])) {
                $productGroups[$groupKey]['variants'][$remarkKey] = [
                    'code_number' => $row['code_number'] ?? '',
                    'specification' => $row['specification'] ?? '',
                    'remark_number' => $remarkNumber,
                    'in_quantity' => 0,
                    'price' => floatval($row['price'])
                ];
            }
            
            // 累计进货数量（只累计进货，不计出货）
            $inQty = floatval($row['in_quantity']);
            if ($inQty > 0) {
                $productGroups[$groupKey]['variants'][$remarkKey]['in_quantity'] += $inQty;
            }
        }
        
        // 转换为最终格式
        $remarkProducts = [];
        foreach ($productGroups as $group) {
            $variants = [];
            foreach ($group['variants'] as $variant) {
                $variants[] = [
                    'code_number' => $variant['code_number'],
                    'specification' => $variant['specification'],
                    'in_quantity' => $variant['in_quantity'],
                    'formatted_quantity' => number_format($variant['in_quantity'], 2),
                    'price' => $variant['price'],
                    'formatted_price' => number_format($variant['price'], 2),
                    'remark_number' => $variant['remark_number']
                ];
            }
            
            $remarkProducts[] = [
                'product_name' => $group['product_name'],
                'variants' => $variants
            ];
        }
        
        return [
            'products' => $remarkProducts
        ];
        
    } catch (PDOException $e) {
        throw new Exception("查询货品备注数据失败：" . $e->getMessage());
    }
}

// 获取产品详细信息（可选功能）
function getProductDetails($productName) {
    global $pdo;
    
    try {
        $sql = "SELECT 
                    product_name,
                    specification,
                    price,
                    code_number,
                    in_quantity,
                    out_quantity,
                    date_created,
                    SUM(CASE WHEN in_quantity > 0 THEN in_quantity ELSE 0 END) as total_in,
                    SUM(CASE WHEN out_quantity > 0 THEN out_quantity ELSE 0 END) as total_out
                FROM stockinout_data 
                WHERE product_name = :product_name
                GROUP BY product_name, specification, price, code_number
                ORDER BY price DESC, date_created DESC";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':product_name', $productName, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    } catch (PDOException $e) {
        throw new Exception("查询产品详细信息失败：" . $e->getMessage());
    }
}

// 导出CSV数据
function exportMultiPriceData() {
    try {
        $result = getMultiPriceAnalysis();
        
        // 设置CSV头信息
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="multi_price_analysis_' . date('Y-m-d') . '.csv"');
        
        ob_end_clean();
        
        // 创建CSV输出
        $output = fopen('php://output', 'w');
        
        // 写入BOM以支持中文
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        // 写入表头
        fputcsv($output, [
            'Product Name', 
            'Rank', 
            'Code Number', 
            'Stock Quantity', 
            'Unit Price (RM)'
        ]);
        
        // 写入数据
        foreach ($result['products'] as $product) {
            foreach ($product['variants'] as $index => $variant) {
                $priceDiff = $product['max_price'] - $variant['price'];
                $priceRank = $index + 1;
                
                fputcsv($output, [
                    $product['product_name'],
                    $priceRank,
                    $variant['code_number'],
                    $variant['formatted_stock'],
                    $variant['formatted_price']
                ]);
            }
        }
        
        fclose($output);
        exit;
        
    } catch (Exception $e) {
        ob_end_clean();
        sendResponse(false, "导出失败：" . $e->getMessage());
    }
}

// 主要路由处理
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $action = $_GET['action'] ?? 'analysis';
    
    switch ($action) {
        case 'analysis':
            try {
                $result = getMultiPriceAnalysis();
                sendResponse(true, "多价格产品分析数据获取成功", $result);
            } catch (Exception $e) {
                sendResponse(false, $e->getMessage());
            }
            break;
            
        case 'details':
            $productName = $_GET['product'] ?? '';
            if (empty($productName)) {
                sendResponse(false, "产品名称不能为空");
            }
            
            try {
                $result = getProductDetails($productName);
                sendResponse(true, "产品详细信息获取成功", $result);
            } catch (Exception $e) {
                sendResponse(false, $e->getMessage());
            }
            break;
            
        case 'export':
            exportMultiPriceData();
            break;
            
        default:
            sendResponse(false, "无效的操作");
    }
} else {
    sendResponse(false, "不支持的请求方法");
}
?>