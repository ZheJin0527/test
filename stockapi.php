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
error_log("数据库连接成功");
error_log("请求方法: " . $method);

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
        // 检查是否是批准请求
        if (($_GET['action'] ?? '') === 'approve') {
            handleApprove();
        } else {
            handleGet();
        }
        break;
    case 'POST':
        handlePost();
        break;
    case 'PUT':
        // 检查是否是批准请求
        if (($_GET['action'] ?? '') === 'approve') {
            handleApprove();
        } else {
            handlePut();
        }
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
        // 这是PUT请求，重定向到批准处理
        handleApprove();
        return;
    }
    
    switch ($action) {
        case 'list':
            // 获取所有库存数据
            $startDate = $_GET['start_date'] ?? null;
            $endDate = $_GET['end_date'] ?? null;
            $searchDate = $_GET['search_date'] ?? null;
            $supplier = $_GET['supplier'] ?? null;
            $approvalStatus = $_GET['approval_status'] ?? null;

            // 如果没有提供日期范围，默认显示一年内的数据
            if (!$startDate && !$endDate && !$searchDate) {
                $startDate = date('Y-m-d', strtotime('-1 year')); // 一年前的今天
                $endDate = date('Y-m-d'); // 今天
            }

            $sql = "SELECT * FROM stock_data WHERE 1=1";
            $params = [];
            
            if ($searchDate) {
                $sql .= " AND date = ?";
                $params[] = $searchDate;
            } elseif ($startDate && $endDate) {
                $sql .= " AND date BETWEEN ? AND ?";
                $params[] = $startDate;
                $params[] = $endDate;
            }
            
            if ($supplier) {
                $sql .= " AND supplier LIKE ?";
                $params[] = "%$supplier%";
            }

            if ($productCode) {
                $sql .= " AND product_code LIKE ?";
                $params[] = "%$productCode%";
            }

            // 添加产品名称搜索支持
            $productName = $_GET['product_name'] ?? null;
            if ($productName) {
                $sql .= " AND product_name LIKE ?";
                $params[] = "%$productName%";
            }

            // 确保产品代码搜索也是模糊匹配
            if ($productCode) {
                $sql .= " AND product_code LIKE ?";
                $params[] = "%$productCode%";
            }
            
            if ($approvalStatus) {
                if ($approvalStatus === 'approved') {
                    $sql .= " AND approver IS NOT NULL AND approver != ''";
                } elseif ($approvalStatus === 'pending') {
                    $sql .= " AND (approver IS NULL OR approver = '')";
                }
            }
            
            $sql .= " ORDER BY date DESC, time DESC";
            
            $stmt = $pdo->prepare($sql);
            try {
            $stmt->execute($params);
            $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // 为每条记录添加批准状态
            foreach ($records as &$record) {
                $record['approval_status'] = (!empty($record['approver'])) ? 'approved' : 'pending';
            }
            
            sendResponse(true, "库存数据获取成功", $records);
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
                        COUNT(CASE WHEN approver IS NOT NULL AND approver != '' THEN 1 END) as approved_count,
                        COUNT(CASE WHEN approver IS NULL OR approver = '' THEN 1 END) as pending_count
                    FROM stock_data WHERE 1=1";
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
            $summary['total_value'] = floatval($summary['total_value']);
            $summary['avg_price'] = floatval($summary['avg_price']);
            
            sendResponse(true, "汇总数据获取成功", $summary);
            break;
            
        case 'single':
            // 获取单条记录
            $id = $_GET['id'] ?? null;
            if (!$id) {
                sendResponse(false, "缺少记录ID");
            }
            
            $stmt = $pdo->prepare("SELECT * FROM stock_data WHERE id = ?");
            $stmt->execute([$id]);
            $record = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($record) {
                $record['approval_status'] = (!empty($record['approver'])) ? 'approved' : 'pending';
                sendResponse(true, "记录获取成功", $record);
            } else {
                sendResponse(false, "记录不存在");
            }
            break;
            
        case 'suppliers':
            // 获取所有供应商列表
            $stmt = $pdo->prepare("SELECT DISTINCT supplier FROM stock_data ORDER BY supplier");
            $stmt->execute();
            $suppliers = $stmt->fetchAll(PDO::FETCH_COLUMN);
            
            sendResponse(true, "供应商列表获取成功", $suppliers);
            break;
            
        case 'products':
            // 获取所有产品列表
            $stmt = $pdo->prepare("SELECT DISTINCT product_code, product_name FROM stock_data ORDER BY product_code");
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            sendResponse(true, "产品列表获取成功", $products);
            break;

        case 'summary':
            // 获取汇总数据
            $startDate = $_GET['start_date'] ?? null;
            $endDate = $_GET['end_date'] ?? null;
            
            $sql = "SELECT 
                        COUNT(*) as total_records,
                        COUNT(DISTINCT product_code) as total_products,
                        COUNT(DISTINCT supplier) as total_suppliers,
                        COUNT(CASE WHEN approver IS NOT NULL AND approver != '' THEN 1 END) as approved_count,
                        COUNT(CASE WHEN approver IS NULL OR approver = '' THEN 1 END) as pending_count,
                        SUM(CASE WHEN in_quantity > 0 THEN (in_quantity * price) ELSE 0 END) as total_in_value,
                        SUM(CASE WHEN out_quantity > 0 THEN (out_quantity * price) ELSE 0 END) as total_out_value,
                        SUM((in_quantity - out_quantity) * price) as net_value
                    FROM stock_data WHERE 1=1";
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
            foreach (['total_in_value', 'total_out_value', 'net_value'] as $field) {
                $summary[$field] = floatval($summary[$field]);
            }
            
            sendResponse(true, "汇总数据获取成功", $summary);
            break;

        // 在现有的switch语句中添加以下case：
        case 'get_min_stock':
            // 获取最低库存设置
            try {
                $stmt = $pdo->prepare("SELECT * FROM min_stock_settings");
                $stmt->execute();
                $settings = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                $result = [];
                foreach ($settings as $setting) {
                    $key = $setting['product_name'] . '_' . $setting['product_code'];
                    $result[$key] = floatval($setting['min_quantity']);
                }
                
                sendResponse(true, "最低库存设置获取成功", $result);
            } catch (PDOException $e) {
                sendResponse(false, "获取最低库存设置失败：" . $e->getMessage());
            }
            break;

        case 'save_min_stock':
            try {
                $input = json_decode(file_get_contents('php://input'), true);
                $settings = $input['settings'] ?? [];
                
                // 清空现有设置
                $pdo->prepare("DELETE FROM min_stock_settings")->execute();
                
                // 插入新设置
                $stmt = $pdo->prepare("INSERT INTO min_stock_settings (product_key, min_stock) VALUES (?, ?)");
                
                foreach ($settings as $key => $value) {
                    if ($value > 0) { // 只保存大于0的设置
                        $stmt->execute([$key, $value]);
                    }
                }
                
                sendResponse(true, "最低库存设置保存成功");
            } catch (Exception $e) {
                sendResponse(false, $e->getMessage());
            }
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

    // 检查是否是保存最低库存设置
    if (isset($data['action']) && $data['action'] === 'save_min_stock') {
        handleSaveMinStock();
        return;
    }
    
    // 验证必填字段
    $required_fields = ['date', 'time', 'product_code', 'product_name', 'supplier', 'applicant'];
    foreach ($required_fields as $field) {
        if (empty($data[$field])) {
            sendResponse(false, "缺少必填字段：$field");
        }
    }
    
    try {
        $sql = "INSERT INTO stock_data 
                (date, time, product_code, product_name, supplier, applicant, approver) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            $data['date'],
            $data['time'],
            $data['product_code'],
            $data['product_name'],
            $data['supplier'],
            $data['applicant'],
            $data['approver'] ?? null
        ]);
        
        $newId = $pdo->lastInsertId();
        
        // 获取新插入的记录
        $stmt = $pdo->prepare("SELECT * FROM stock_data WHERE id = ?");
        $stmt->execute([$newId]);
        $newRecord = $stmt->fetch(PDO::FETCH_ASSOC);
        $newRecord['approval_status'] = (!empty($newRecord['approver'])) ? 'approved' : 'pending';
        
        sendResponse(true, "库存记录添加成功", $newRecord);
        
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
    $allowedCodes = ['SUPPORT88', 'IT4567', 'QX0EQP'];
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
    $approver = $_SESSION['username'] ?? 'System'; // 使用登录用户的用户名
    
    try {
        $sql = "UPDATE stock_data SET approver = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([$approver, $id]);
        
        if ($stmt->rowCount() > 0) {
            // 获取更新后的记录
            $stmt = $pdo->prepare("SELECT * FROM stock_data WHERE id = ?");
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
    $required_fields = ['date', 'time', 'product_code', 'product_name', 'supplier', 'applicant'];
    foreach ($required_fields as $field) {
        if (empty($data[$field])) {
            sendResponse(false, "缺少必填字段：$field");
        }
    }
    
    try {
        $sql = "UPDATE stock_data 
                SET date = ?, time = ?, product_code = ?, product_name = ?, supplier = ?, 
                    applicant = ?, approver = ?
                WHERE id = ?";

        $stmt = $pdo->prepare($sql);

        $result = $stmt->execute([
            $data['date'],
            $data['time'],
            $data['product_code'],
            $data['product_name'],
            $data['supplier'],
            $data['applicant'],
            $data['approver'] ?? null,
            $data['id']
        ]);
        
        // 检查记录是否存在
        $checkStmt = $pdo->prepare("SELECT * FROM stock_data WHERE id = ?");
        $checkStmt->execute([$data['id']]);
        $existingRecord = $checkStmt->fetch(PDO::FETCH_ASSOC);

        if ($existingRecord) {
            // 记录存在，获取更新后的记录
            $stmt = $pdo->prepare("SELECT * FROM stock_data WHERE id = ?");
            $stmt->execute([$data['id']]);
            $updatedRecord = $stmt->fetch(PDO::FETCH_ASSOC);
            $updatedRecord['approval_status'] = (!empty($updatedRecord['approver'])) ? 'approved' : 'pending';
            
            sendResponse(true, "库存记录更新成功", $updatedRecord);
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
        $stmt = $pdo->prepare("DELETE FROM stock_data WHERE id = ?");
        $result = $stmt->execute([$id]);
        
        if ($stmt->rowCount() > 0) {
            sendResponse(true, "库存记录删除成功");
        } else {
            sendResponse(false, "记录不存在");
        }
        
    } catch (PDOException $e) {
        sendResponse(false, "删除记录失败：" . $e->getMessage());
    }
}

// 批量批准功能（可选）
function handleBatchApprove() {
    global $pdo, $data;
    
    if (!$data || !isset($data['ids']) || !isset($data['approver'])) {
        sendResponse(false, "缺少必要参数");
    }
    
    $ids = $data['ids'];
    $approver = $data['approver'];
    
    if (!is_array($ids) || empty($ids)) {
        sendResponse(false, "无效的ID列表");
    }
    
    try {
        $pdo->beginTransaction();
        
        $placeholders = str_repeat('?,', count($ids) - 1) . '?';
        $sql = "UPDATE stock_data SET approver = ? WHERE id IN ($placeholders)";
        
        $params = array_merge([$approver], $ids);
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        
        $pdo->commit();
        
        sendResponse(true, "批量批准成功", ["affected_rows" => $stmt->rowCount()]);
        
    } catch (PDOException $e) {
        $pdo->rollback();
        sendResponse(false, "批量批准失败：" . $e->getMessage());
    }
}

// 处理保存最低库存设置
function handleSaveMinStock() {
    global $pdo, $data;
    
    if (!isset($data['settings'])) {
        sendResponse(false, "缺少设置数据");
    }
    
    $settings = $data['settings'];
    
    try {
        $pdo->beginTransaction();
        
        // 先删除所有现有设置
        $stmt = $pdo->prepare("DELETE FROM min_stock_settings");
        $stmt->execute();
        
        // 插入新设置
        $stmt = $pdo->prepare("INSERT INTO min_stock_settings (product_name, product_code, min_quantity) VALUES (?, ?, ?)");
        
        foreach ($settings as $key => $minQuantity) {
            if ($minQuantity > 0) { // 只保存大于0的设置
                $parts = explode('_', $key);
                if (count($parts) >= 2) {
                    $productCode = array_pop($parts);
                    $productName = implode('_', $parts);
                    $stmt->execute([$productName, $productCode, $minQuantity]);
                }
            }
        }
        
        $pdo->commit();
        sendResponse(true, "最低库存设置保存成功");
        
    } catch (PDOException $e) {
        $pdo->rollback();
        sendResponse(false, "保存最低库存设置失败：" . $e->getMessage());
    }
}
?>