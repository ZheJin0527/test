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
    echo json_encode(["success" => false, "message" => "数据库连接失败：" . $e->getMessage(), "error_details" => $e->getMessage()]);
    exit;
}

// 调试信息
error_log("数据库连接成功 - stockeditapi");
error_log("请求方法: " . $_SERVER['REQUEST_METHOD']);

// 获取请求方法和数据
$method = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents("php://input"), true);

function sendResponse($success, $message = "", $data = null) {
    ob_end_clean();
    echo json_encode([
        "success" => $success,
        "message" => $message,
        "data" => $data
    ]);
    exit;
}

// 路由处理
switch ($method) {
    case 'GET':
        handleGet();
        break;
    case 'POST':
        handlePost();
        break;
    case 'PUT':
        handlePut();
        break;
    case 'DELETE':
        handleDelete();
        break;
    default:
        sendResponse(false, "不支持的请求方法");
}

// 处理 GET 请求 - 获取数据
function handleGet() {
    global $pdo;
    
    $action = $_GET['action'] ?? 'list';

    if ($action === 'approve') {
        handleApprove();
        return;
    }
    
    switch ($action) {
        case 'list':
            // 获取所有进出库数据
            $startDate = $_GET['start_date'] ?? null;
            $endDate = $_GET['end_date'] ?? null;
            $searchDate = $_GET['search_date'] ?? null;
            $receiver = $_GET['receiver'] ?? null;
            $productCode = $_GET['product_code'] ?? null;  // 这行已存在，保持不变
            $productName = $_GET['product_name'] ?? null;

            // 如果没有提供日期范围，默认使用当月
            if (!$startDate && !$endDate && !$searchDate) {
                $currentYear = date('Y');
                $currentMonth = date('m');
                $startDate = "$currentYear-$currentMonth-01";
                $endDate = date('Y-m-t');
            }

            $sql = "SELECT * FROM stockinout_data WHERE 1=1";
            $params = [];
            
            if ($searchDate) {
                $sql .= " AND date = ?";
                $params[] = $searchDate;
            } elseif ($startDate && $endDate) {
                $sql .= " AND date BETWEEN ? AND ?";
                $params[] = $startDate;
                $params[] = $endDate;
            }
            
            if ($receiver) {
                $sql .= " AND receiver LIKE ?";
                $params[] = "%$receiver%";
            }

            if ($productCode) {
                $sql .= " AND code_number LIKE ?";  // 修改这里：从product_code改为code_number
                $params[] = "%$productCode%";
            }

            if ($productName) {
                $sql .= " AND product_name LIKE ?";
                $params[] = "%$productName%";
            }
            
            $sql .= " ORDER BY date ASC, time ASC";
            
            $stmt = $pdo->prepare($sql);
            try {
                $stmt->execute($params);
                $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                // 为每条记录添加计算字段
                foreach ($records as &$record) {
                    // 计算库存余额
                    $inQty = floatval($record['in_quantity'] ?? 0);
                    $outQty = floatval($record['out_quantity'] ?? 0);
                    $record['balance_quantity'] = $inQty - $outQty;
                    
                    // 计算总价值
                    $price = floatval($record['price'] ?? 0);
                    $record['in_value'] = $inQty * $price;
                    $record['out_value'] = $outQty * $price;
                    $record['balance_value'] = $record['balance_quantity'] * $price;
                    
                    // 格式化数字
                    $record['in_quantity'] = number_format($inQty, 2);
                    $record['out_quantity'] = number_format($outQty, 2);
                    $record['balance_quantity'] = number_format($record['balance_quantity'], 2);
                    $record['price'] = number_format($price, 2);
                    $record['in_value'] = number_format($record['in_value'], 2);
                    $record['out_value'] = number_format($record['out_value'], 2);
                    $record['balance_value'] = number_format($record['balance_value'], 2);
                }
                
                sendResponse(true, "进出库数据获取成功，共找到 " . count($records) . " 条记录", $records);
            } catch (PDOException $e) {
                sendResponse(false, "查询数据失败：" . $e->getMessage());
            }
            break;
            
        case 'summary':
            // 获取汇总数据
            $startDate = $_GET['start_date'] ?? null;
            $endDate = $_GET['end_date'] ?? null;
            
            $sql = "SELECT 
                        COUNT(*) as total_records,
                        COUNT(DISTINCT product_code) as total_products,
                        COUNT(DISTINCT supplier) as total_suppliers,
                        SUM(in_quantity * price) as total_in_value,
                        SUM(out_quantity * price) as total_out_value,
                        SUM((in_quantity - out_quantity) * price) as total_balance_value,
                        SUM(in_quantity) as total_in_quantity,
                        SUM(out_quantity) as total_out_quantity,
                        SUM(in_quantity - out_quantity) as total_balance_quantity
                    FROM stockinout_data WHERE 1=1";
            $params = [];
            
            if ($startDate && $endDate) {
                $sql .= " AND date BETWEEN ? AND ?";
                $params[] = $startDate;
                $params[] = $endDate;
            }
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            $summary = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // 格式化数据
            foreach (['total_in_value', 'total_out_value', 'total_balance_value', 'total_in_quantity', 'total_out_quantity', 'total_balance_quantity'] as $field) {
                $summary[$field] = floatval($summary[$field] ?? 0);
            }
            
            sendResponse(true, "汇总数据获取成功", $summary);
            break;
            
        case 'single':
            // 获取单条记录
            $id = $_GET['id'] ?? null;
            if (!$id) {
                sendResponse(false, "缺少记录ID");
            }
            
            $stmt = $pdo->prepare("SELECT * FROM stockinout_data WHERE id = ?");
            $stmt->execute([$id]);
            $record = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($record) {
                sendResponse(true, "记录获取成功", $record);
            } else {
                sendResponse(false, "记录不存在");
            }
            break;
            
        case 'suppliers':
            // 获取所有供应商列表
            $stmt = $pdo->prepare("SELECT DISTINCT supplier FROM stockinout_data ORDER BY supplier");
            $stmt->execute();
            $suppliers = $stmt->fetchAll(PDO::FETCH_COLUMN);
            
            sendResponse(true, "供应商列表获取成功", $suppliers);
            break;
            
        case 'products':
            // 获取所有产品列表
            $stmt = $pdo->prepare("SELECT DISTINCT product_code, product_name FROM stockinout_data ORDER BY product_code");
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            sendResponse(true, "产品列表获取成功", $products);
            break;

        case 'codenumbers':
            // 获取所有唯一的code_number和对应的product_name列表
            $stmt = $pdo->prepare("SELECT DISTINCT product_code as code_number, product_name FROM stock_data WHERE product_code IS NOT NULL AND product_code != '' ORDER BY product_code");
            $stmt->execute();
            $codeNumbers = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            sendResponse(true, "编号列表获取成功", $codeNumbers);
            break;

        case 'product_by_code':
            // 根据code_number获取对应的product_name
            $codeNumber = $_GET['code_number'] ?? null;
            if (!$codeNumber) {
                sendResponse(false, "缺少编号参数");
            }
            
            $stmt = $pdo->prepare("SELECT DISTINCT product_name FROM stock_data WHERE product_code = ? LIMIT 1");
            $stmt->execute([$codeNumber]);
            $productName = $stmt->fetchColumn();
            
            if ($productName) {
                sendResponse(true, "产品名称获取成功", ['product_name' => $productName]);
            } else {
                sendResponse(false, "未找到对应的产品名称");
            }
            break;
        
        case 'products_list':
            // 获取所有唯一的产品名称和对应的product_code列表
            $stmt = $pdo->prepare("SELECT DISTINCT product_name, product_code FROM stock_data WHERE product_name IS NOT NULL AND product_name != '' ORDER BY product_name");
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            sendResponse(true, "产品列表获取成功", $products);
            break;

        case 'code_by_product':
            // 根据product_name获取对应的product_code
            $productName = $_GET['product_name'] ?? null;
            if (!$productName) {
                sendResponse(false, "缺少产品名称参数");
            }
            
            $stmt = $pdo->prepare("SELECT DISTINCT product_code FROM stock_data WHERE product_name = ? LIMIT 1");
            $stmt->execute([$productName]);
            $productCode = $stmt->fetchColumn();
            
            if ($productCode) {
                sendResponse(true, "产品编号获取成功", ['product_code' => $productCode]);
            } else {
                sendResponse(false, "未找到对应的产品编号");
            }
            break;

        case 'available_prices':
            // 获取特定产品的可用价格选项（有库存的）
            $productName = $_GET['product_name'] ?? null;
            if (!$productName) {
                sendResponse(false, "缺少产品名称参数");
            }
            
            // 计算每个价格的库存余额
            $sql = "SELECT 
                        price,
                        SUM(in_quantity) - SUM(out_quantity) as available_stock,
                        specification,
                        COUNT(*) as record_count
                    FROM stockinout_data 
                    WHERE product_name = ? 
                    GROUP BY price, specification
                    HAVING available_stock > 0
                    ORDER BY price ASC";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$productName]);
            $availablePrices = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // 格式化数据
            foreach ($availablePrices as &$item) {
                $item['available_stock'] = floatval($item['available_stock']);
                $item['price'] = floatval($item['price']);
                $item['display_text'] = "RM" . number_format($item['price'], 2) . " (库存: " . number_format($item['available_stock'], 2) . " " . $item['specification'] . ")";
            }
            
            sendResponse(true, "可用价格获取成功", $availablePrices);
            break;

        case 'stock_balance':
            // 获取特定产品特定价格的库存余额
            $productName = $_GET['product_name'] ?? null;
            $price = $_GET['price'] ?? null;
            
            if (!$productName || !$price) {
                sendResponse(false, "缺少产品名称或价格参数");
            }
            
            $sql = "SELECT 
                        SUM(in_quantity) - SUM(out_quantity) as balance
                    FROM stockinout_data 
                    WHERE product_name = ? AND price = ?";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$productName, $price]);
            $balance = $stmt->fetchColumn();
            
            sendResponse(true, "库存余额获取成功", ['balance' => floatval($balance)]);
            break;
            
        default:
            sendResponse(false, "无效的操作");
    }
}

// 处理 POST 请求 - 添加新记录
function handlePost() {
    global $pdo, $data;
    
    if (!$data) {
        sendResponse(false, "无效的数据格式");
    }
    
    // 验证必填字段
    $required_fields = ['date', 'time', 'product_name', 'receiver'];
    foreach ($required_fields as $field) {
        if (empty($data[$field])) {
            sendResponse(false, "缺少必填字段：$field");
        }
    }

    // 验证产品名称是否存在于数据库中
    if (!empty($data['product_name'])) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM stock_data WHERE product_name = ?");
        $stmt->execute([$data['product_name']]);
        if ($stmt->fetchColumn() == 0) {
            sendResponse(false, "产品名称不存在，请选择有效的产品");
        }
    }

    // 验证产品编号是否存在于数据库中
    if (!empty($data['code_number'])) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM stock_data WHERE product_code = ?");
        $stmt->execute([$data['code_number']]);
        if ($stmt->fetchColumn() == 0) {
            sendResponse(false, "产品编号不存在，请选择有效的编号");
        }
    }
    
    try {
        $sql = "INSERT INTO stockinout_data 
                (date, time, product_name, 
                in_quantity, out_quantity, specification, price, code_number, remark, receiver) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            $data['date'],
            $data['time'],
            $data['product_name'],
            $data['in_quantity'] ?? 0,
            $data['out_quantity'] ?? 0,
            $data['specification'] ?? null,
            $data['price'] ?? 0,
            $data['code_number'] ?? null,
            $data['remark'] ?? null,
            $data['receiver'] ?? null
        ]);
        
        $newId = $pdo->lastInsertId();
        
        // 获取新插入的记录
        $stmt = $pdo->prepare("SELECT * FROM stockinout_data WHERE id = ?");
        $stmt->execute([$newId]);
        $newRecord = $stmt->fetch(PDO::FETCH_ASSOC);
        $newRecord['approval_status'] = (!empty($newRecord['approver'])) ? 'approved' : 'pending';
        
        sendResponse(true, "进出库记录添加成功", $newRecord);
        
    } catch (PDOException $e) {
        sendResponse(false, "添加记录失败：" . $e->getMessage());
    }
}

// 处理批准请求
function handleApprove() {
    global $pdo, $data;
    
    // 检查用户权限
    session_start();
    if (!isset($_SESSION['user_id'])) {
        sendResponse(false, "用户未登录");
    }
    
    // 检查用户是否使用了允许的注册码
    $allowedCodes = ['SUPPORT88', 'IT4567', 'DESIGN77'];
    $userId = $_SESSION['user_id'];

    $stmt = $pdo->prepare("SELECT registration_code FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $userCode = $stmt->fetchColumn();

    if (!$userCode || !in_array($userCode, $allowedCodes)) {
        sendResponse(false, "您没有权限执行此操作");
    }
    
    if (!$data || !isset($data['id'])) {
        sendResponse(false, "缺少记录ID");
    }
    
    $id = $data['id'];
    $approver = $_SESSION['username'] ?? 'System';
    
    try {
        $sql = "UPDATE stockinout_data SET approver = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([$approver, $id]);
        
        if ($stmt->rowCount() > 0) {
            // 获取更新后的记录
            $stmt = $pdo->prepare("SELECT * FROM stockinout_data WHERE id = ?");
            $stmt->execute([$id]);
            $updatedRecord = $stmt->fetch(PDO::FETCH_ASSOC);
            $updatedRecord['approval_status'] = 'approved';
            
            sendResponse(true, "记录批准成功", $updatedRecord);
        } else {
            sendResponse(false, "记录不存在");
        }
        
    } catch (PDOException $e) {
        sendResponse(false, "批准失败：" . $e->getMessage());
    }
}

// 处理 PUT 请求 - 更新记录
function handlePut() {
    global $pdo, $data;
    
    if (!$data || !isset($data['id'])) {
        sendResponse(false, "缺少记录ID");
    }
    
    // 验证必填字段
    $required_fields = ['date', 'time', 'product_name', 'receiver'];
    foreach ($required_fields as $field) {
        if (empty($data[$field])) {
            sendResponse(false, "缺少必填字段：$field");
        }
    }

    // 验证产品名称是否存在于数据库中
    if (!empty($data['product_name'])) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM stock_data WHERE product_name = ?");
        $stmt->execute([$data['product_name']]);
        if ($stmt->fetchColumn() == 0) {
            sendResponse(false, "产品名称不存在，请选择有效的产品");
        }
    }

    // 验证产品编号是否存在于数据库中
    if (!empty($data['code_number'])) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM stock_data WHERE product_code = ?");
        $stmt->execute([$data['code_number']]);
        if ($stmt->fetchColumn() == 0) {
            sendResponse(false, "产品编号不存在，请选择有效的编号");
        }
    }
    
    try {
        $sql = "UPDATE stockinout_data 
                SET date = ?, time = ?, product_name = ?, 
                    in_quantity = ?, out_quantity = ?, 
                    specification = ?, price = ?, code_number = ?, remark = ?, receiver = ?
                WHERE id = ?";

        $stmt = $pdo->prepare($sql);

        $result = $stmt->execute([
                $data['date'],
                $data['time'],
                $data['product_name'],
                $data['in_quantity'] ?? 0,
                $data['out_quantity'] ?? 0,
                $data['specification'] ?? null,
                $data['price'] ?? 0,
                $data['code_number'] ?? null,
                $data['remark'] ?? null,
                $data['receiver'] ?? null,
                $data['id']
            ]);
        
        // 检查记录是否存在
        $checkStmt = $pdo->prepare("SELECT * FROM stockinout_data WHERE id = ?");
        $checkStmt->execute([$data['id']]);
        $existingRecord = $checkStmt->fetch(PDO::FETCH_ASSOC);

        if ($existingRecord) {
            // 记录存在，获取更新后的记录
            $stmt = $pdo->prepare("SELECT * FROM stockinout_data WHERE id = ?");
            $stmt->execute([$data['id']]);
            $updatedRecord = $stmt->fetch(PDO::FETCH_ASSOC);
            
            sendResponse(true, "进出库记录更新成功", $updatedRecord);
        } else {
            sendResponse(false, "记录不存在");
        }
        
    } catch (PDOException $e) {
        sendResponse(false, "更新记录失败：" . $e->getMessage());
    }
}

// 处理 DELETE 请求 - 删除记录
function handleDelete() {
    global $pdo;
    
    $id = $_GET['id'] ?? null;
    
    if (!$id) {
        sendResponse(false, "缺少记录ID");
    }
    
    try {
        $stmt = $pdo->prepare("DELETE FROM stockinout_data WHERE id = ?");
        $result = $stmt->execute([$id]);
        
        if ($stmt->rowCount() > 0) {
            sendResponse(true, "进出库记录删除成功");
        } else {
            sendResponse(false, "记录不存在");
        }
        
    } catch (PDOException $e) {
        sendResponse(false, "删除记录失败：" . $e->getMessage());
    }
}
?>