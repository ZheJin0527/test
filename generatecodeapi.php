<?php

// 设置响应头
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// 处理预检请求
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

// 数据库配置
$host = 'localhost';
$dbname = 'u857194726_kunzzgroup';
$username = 'u857194726_kunzzgroup';
$password = 'Kholdings1688@';

try {
    // 创建PDO连接
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // 设置时区为马来西亚时间 (UTC+8)
    $pdo->exec("SET time_zone = '+08:00'");
} catch(PDOException $e) {
    // 数据库连接失败
    echo json_encode([
        'success' => false,
        'message' => '数据库连接失败: ' . $e->getMessage()
    ]);
    exit;
}

// 获取请求方法和数据
$method = $_SERVER['REQUEST_METHOD'];
$action = '';

if ($method === 'GET') {
    $action = $_GET['action'] ?? '';
} else if ($method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $action = $input['action'] ?? '';
}

try {
    switch ($action) {
        case 'generate':
            // 生成新代码
            generateCode($pdo, $input);
            break;
            
        case 'list':
            // 获取代码和用户列表
            getCodesAndUsers($pdo);
            break;

        case 'update':
            // 更新代码
            updateCode($pdo, $input);
            break;
            
        case 'delete':
            // 删除代码
            deleteCode($pdo, $input);
            break;
            
        default:
            echo json_encode([
                'success' => false,
                'message' => '无效的操作请求'
            ]);
            break;
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => '服务器错误: ' . $e->getMessage()
    ]);
}

/**
 * 生成新的应用代码
 */
function generateCode($pdo, $input) {
    // 验证输入数据
    if (empty($input['account_type'])) {
        echo json_encode([
            'success' => false,
            'message' => '账户类型不能为空'
        ]);
        return;
    }

    $account_type = trim($input['account_type']);
    
    // 生成6位随机代码
    $code = generateRandomCode($pdo);

    // 验证账户类型
    $valid_types = ['admin', 'hr', 'design', 'support', 'IT', 'boss','photograph'];
    if (!in_array($account_type, $valid_types)) {
        echo json_encode([
            'success' => false,
            'message' => '无效的账户类型'
        ]);
        return;
    }

    // 验证代码格式（只允许字母、数字和特定符号）
    if (!preg_match('/^[A-Z0-9_-]+$/', $code)) {
        echo json_encode([
            'success' => false,
            'message' => '代码格式无效，只能包含大写字母、数字、下划线和连字符'
        ]);
        return;
    }

    try {
        // 检查代码是否已存在
        $checkSql = "SELECT id FROM application_codes WHERE code = :code";
        $checkStmt = $pdo->prepare($checkSql);
        $checkStmt->bindParam(':code', $code);
        $checkStmt->execute();

        if ($checkStmt->rowCount() > 0) {
            echo json_encode([
                'success' => false,
                'message' => '代码已存在，请使用其他代码'
            ]);
            return;
        }

        // 插入新代码
        $insertSql = "INSERT INTO application_codes (code, account_type, used, created_at) VALUES (:code, :account_type, 0, NOW())";
        $insertStmt = $pdo->prepare($insertSql);
        $insertStmt->bindParam(':code', $code);
        $insertStmt->bindParam(':account_type', $account_type);
        
        if ($insertStmt->execute()) {
            echo json_encode([
                'success' => true,
                'message' => '代码生成成功',
                'data' => [
                    'code' => $code,
                    'account_type' => $account_type
                ]
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => '代码生成失败，请重试'
            ]);
        }

    } catch (PDOException $e) {
        echo json_encode([
            'success' => false,
            'message' => '数据库操作失败: ' . $e->getMessage()
        ]);
    }
}

/**
 * 获取代码和用户列表
 */
function getCodesAndUsers($pdo) {
    try {
        // 查询所有代码和对应的用户信息
        $sql = "
            SELECT 
                ac.id,
                ac.code,
                ac.account_type,
                ac.used,
                ac.created_at,
                u.username,
                u.email,
                u.gender,
                u.phone_number
            FROM application_codes ac
            LEFT JOIN users u ON ac.code = u.registration_code
            ORDER BY ac.created_at DESC, ac.id DESC
        ";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();

        echo json_encode([
            'success' => true,
            'message' => '数据获取成功',
            'data' => $results
        ]);

    } catch (PDOException $e) {
        echo json_encode([
            'success' => false,
            'message' => '数据查询失败: ' . $e->getMessage()
        ]);
    }
}

/**
 * 验证代码格式
 */
function validateCodeFormat($code) {
    // 代码长度限制：3-50个字符
    if (strlen($code) < 3 || strlen($code) > 50) {
        return false;
    }
    
    // 只允许大写字母、数字、下划线和连字符
    return preg_match('/^[A-Z0-9_-]+$/', $code);
}

/**
 * 记录操作日志（可选功能）
 */
function logOperation($pdo, $action, $details) {
    try {
        // 如果你有日志表，可以在这里记录操作
        // $logSql = "INSERT INTO operation_logs (action, details, ip_address, created_at) VALUES (:action, :details, :ip, NOW())";
        // $logStmt = $pdo->prepare($logSql);
        // $logStmt->bindParam(':action', $action);
        // $logStmt->bindParam(':details', $details);
        // $logStmt->bindParam(':ip', $_SERVER['REMOTE_ADDR']);
        // $logStmt->execute();
    } catch (Exception $e) {
        // 日志记录失败不影响主要功能
        error_log("日志记录失败: " . $e->getMessage());
    }
}

/**
 * 获取统计信息（扩展功能）
 */
function getStatistics($pdo) {
    try {
        $stats = [];
        
        // 总代码数
        $totalStmt = $pdo->query("SELECT COUNT(*) as total FROM application_codes");
        $stats['total_codes'] = $totalStmt->fetch()['total'];
        
        // 已使用代码数
        $usedStmt = $pdo->query("SELECT COUNT(*) as used FROM application_codes WHERE used = 1");
        $stats['used_codes'] = $usedStmt->fetch()['used'];
        
        // 未使用代码数
        $stats['unused_codes'] = $stats['total_codes'] - $stats['used_codes'];
        
        // 各类型账户统计
        $typeStmt = $pdo->query("
            SELECT account_type, COUNT(*) as count 
            FROM application_codes 
            GROUP BY account_type
        ");
        $stats['by_type'] = $typeStmt->fetchAll();
        
        echo json_encode([
            'success' => true,
            'data' => $stats
        ]);
        
    } catch (PDOException $e) {
        echo json_encode([
            'success' => false,
            'message' => '统计数据获取失败: ' . $e->getMessage()
        ]);
    }
}

/**
 * 生成6位随机代码并确保唯一性
 */
function generateRandomCode($pdo) {
    $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $maxAttempts = 100; // 最大尝试次数，避免无限循环
    
    for ($attempt = 0; $attempt < $maxAttempts; $attempt++) {
        $code = '';
        for ($i = 0; $i < 6; $i++) {
            $code .= $chars[rand(0, strlen($chars) - 1)];
        }
        
        // 检查代码是否已存在
        $checkSql = "SELECT id FROM application_codes WHERE code = :code";
        $checkStmt = $pdo->prepare($checkSql);
        $checkStmt->bindParam(':code', $code);
        $checkStmt->execute();
        
        if ($checkStmt->rowCount() == 0) {
            return $code; // 返回唯一的代码
        }
    }
    
    // 如果尝试次数过多仍未找到唯一代码，抛出异常
    throw new Exception('无法生成唯一的申请码，请稍后重试');
}

function updateCode($pdo, $input) {
    // 验证输入数据
    if (empty($input['id']) || empty($input['code']) || empty($input['account_type'])) {
        echo json_encode([
            'success' => false,
            'message' => 'ID、代码和账户类型不能为空'
        ]);
        return;
    }

    $id = intval($input['id']);
    $code = trim($input['code']);
    $account_type = trim($input['account_type']);

    // 验证账户类型
    $valid_types = ['admin', 'hr', 'design', 'support', 'IT', 'boss', 'photograph'];
    if (!in_array($account_type, $valid_types)) {
        echo json_encode([
            'success' => false,
            'message' => '无效的账户类型'
        ]);
        return;
    }

    // 验证代码格式
    if (!preg_match('/^[A-Z0-9_-]+$/', $code)) {
        echo json_encode([
            'success' => false,
            'message' => '代码格式无效，只能包含大写字母、数字、下划线和连字符'
        ]);
        return;
    }

    try {
        // 检查代码是否被其他记录使用
        $checkSql = "SELECT id FROM application_codes WHERE code = :code AND id != :id";
        $checkStmt = $pdo->prepare($checkSql);
        $checkStmt->bindParam(':code', $code);
        $checkStmt->bindParam(':id', $id);
        $checkStmt->execute();

        if ($checkStmt->rowCount() > 0) {
            echo json_encode([
                'success' => false,
                'message' => '代码已存在，请使用其他代码'
            ]);
            return;
        }

        // 更新代码
        $updateSql = "UPDATE application_codes SET code = :code, account_type = :account_type WHERE id = :id";
        $updateStmt = $pdo->prepare($updateSql);
        $updateStmt->bindParam(':code', $code);
        $updateStmt->bindParam(':account_type', $account_type);
        $updateStmt->bindParam(':id', $id);
        
        if ($updateStmt->execute()) {
            echo json_encode([
                'success' => true,
                'message' => '更新成功',
                'data' => [
                    'id' => $id,
                    'code' => $code,
                    'account_type' => $account_type
                ]
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => '更新失败，请重试'
            ]);
        }

    } catch (PDOException $e) {
        echo json_encode([
            'success' => false,
            'message' => '数据库操作失败: ' . $e->getMessage()
        ]);
    }
}

/**
 * 删除申请码
 */
function deleteCode($pdo, $input) {
    // 验证输入数据
    if (empty($input['id'])) {
        echo json_encode([
            'success' => false,
            'message' => 'ID不能为空'
        ]);
        return;
    }

    $id = intval($input['id']);

    try {
        // 检查代码是否已被使用
        $checkSql = "SELECT used FROM application_codes WHERE id = :id";
        $checkStmt = $pdo->prepare($checkSql);
        $checkStmt->bindParam(':id', $id);
        $checkStmt->execute();
        
        $result = $checkStmt->fetch();
        if (!$result) {
            echo json_encode([
                'success' => false,
                'message' => '申请码不存在'
            ]);
            return;
        }

        if ($result['used'] == 1) {
            echo json_encode([
                'success' => false,
                'message' => '已使用的申请码不能删除'
            ]);
            return;
        }

        // 删除代码
        $deleteSql = "DELETE FROM application_codes WHERE id = :id";
        $deleteStmt = $pdo->prepare($deleteSql);
        $deleteStmt->bindParam(':id', $id);
        
        if ($deleteStmt->execute()) {
            echo json_encode([
                'success' => true,
                'message' => '删除成功'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => '删除失败，请重试'
            ]);
        }

    } catch (PDOException $e) {
        echo json_encode([
            'success' => false,
            'message' => '数据库操作失败: ' . $e->getMessage()
        ]);
    }
}

?>