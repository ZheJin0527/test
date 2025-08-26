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
        // 首先获取所有有库存的产品及其价格变体
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
                ORDER BY product_name ASC, price DESC";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $stockData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // 按产品名称分组并找出有多个价格的产品
        $productGroups = [];
        $stats = [
            'total_products' => 0,
            'total_variants' => 0,
            'max_price_difference' => 0,
            'avg_variants' => 0
        ];
        
        foreach ($stockData as $row) {
            $productName = $row['product_name'];
            
            if (!isset($productGroups[$productName])) {
                $productGroups[$productName] = [];
            }
            
            $currentStock = floatval($row['current_stock']);
            $price = floatval($row['price']);
            $totalPrice = $currentStock * $price;
            
            $productGroups[$productName][] = [
                'product_name' => $productName,
                'code_number' => $row['code_number'] ?? '',
                'specification' => $row['specification'] ?? '',
                'current_stock' => $currentStock,
                'price' => $price,
                'total_price' => $totalPrice,
                'formatted_stock' => number_format($currentStock, 2),
                'formatted_price' => number_format($price, 2),
                'formatted_total_price' => number_format($totalPrice, 2)
            ];
        }
        
        // 过滤出有多个价格的产品并按价格排序
        $multiPriceProducts = [];
        $totalVariants = 0;
        $maxPriceDifference = 0;
        
        foreach ($productGroups as $productName => $variants) {
            if (count($variants) > 1) {
                // 按价格降序排序（最高价格在前）
                usort($variants, function($a, $b) {
                    return $b['price'] <=> $a['price'];
                });
                
                $maxPrice = $variants[0]['price'];
                $minPrice = end($variants)['price'];
                $priceDifference = $maxPrice - $minPrice;
                
                if ($priceDifference > $maxPriceDifference) {
                    $maxPriceDifference = $priceDifference;
                }
                
                // 获取最常见的产品编号（如果有的话）
                $codeNumbers = array_filter(array_column($variants, 'code_number'));
                $commonCodeNumber = !empty($codeNumbers) ? array_values(array_count_values($codeNumbers))[0] : '';
                
                $multiPriceProducts[] = [
                    'product_name' => $productName,
                    'code_number' => $commonCodeNumber,
                    'variants' => $variants,
                    'variant_count' => count($variants),
                    'max_price' => $maxPrice,
                    'min_price' => $minPrice,
                    'price_difference' => $priceDifference,
                    'formatted_price_difference' => number_format($priceDifference, 2)
                ];
                
                $totalVariants += count($variants);
            }
        }
        
        // 计算统计信息
        $totalProducts = count($multiPriceProducts);
        $avgVariants = $totalProducts > 0 ? round($totalVariants / $totalProducts, 1) : 0;
        
        $stats = [
            'total_products' => $totalProducts,
            'total_variants' => $totalVariants,
            'max_price_difference' => number_format($maxPriceDifference, 2),
            'avg_variants' => $avgVariants
        ];
        
        return [
            'products' => $multiPriceProducts,
            'stats' => $stats
        ];
        
    } catch (PDOException $e) {
        throw new Exception("查询多价格产品数据失败：" . $e->getMessage());
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
            'Specification', 
            'Stock Quantity', 
            'Unit Price (RM)', 
            'Total Value (RM)', 
            'Price Difference (RM)',
            'Price Rank'
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
                    $variant['specification'],
                    $variant['formatted_stock'],
                    $variant['formatted_price'],
                    $variant['formatted_total_price'],
                    $priceDiff > 0 ? '-' . number_format($priceDiff, 2) : 'Highest',
                    $priceRank === 1 ? 'Highest' : 'Lower'
                ]);
            }
        }
        
        // 写入统计摘要
        fputcsv($output, []);
        fputcsv($output, ['=== SUMMARY ===']);
        fputcsv($output, ['Total Multi-Price Products:', $result['stats']['total_products']]);
        fputcsv($output, ['Total Price Variants:', $result['stats']['total_variants']]);
        fputcsv($output, ['Average Variants per Product:', $result['stats']['avg_variants']]);
        fputcsv($output, ['Maximum Price Difference:', 'RM ' . $result['stats']['max_price_difference']]);
        
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