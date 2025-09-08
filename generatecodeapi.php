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
            // 更新代码和用户信息
            updateCodeAndUser($pdo, $input);
            break;
            
        case 'delete':
            // 删除代码
            deleteCode($pdo, $input);
            break;

        case 'add_user':
            // 添加新用户
            addNewUser($pdo, $input);
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

/**
 * 更新申请码和用户信息
 */
function updateCodeAndUser($pdo, $input) {
    // 验证输入数据
    if (empty($input['id']) || empty($input['code']) || empty($input['account_type'])) {
        echo json_encode([
            'success' => false,
            'message' => 'ID、申请码和账户类型不能为空'
        ]);
        return;
    }

    $id = intval($input['id']);
    $code = trim($input['code']);
    $account_type = trim($input['account_type']);
    $username = trim($input['username'] ?? '');
    $email = trim($input['email'] ?? '');
    $gender = trim($input['gender'] ?? '');
    $phone_number = trim($input['phone_number'] ?? '');

    // 验证账户类型
    $valid_types = ['admin', 'hr', 'design', 'support', 'IT', 'boss', 'photograph'];
    if (!in_array($account_type, $valid_types)) {
        echo json_encode([
            'success' => false,
            'message' => '无效的账户类型'
        ]);
        return;
    }

    // 验证申请码格式
    if (!preg_match('/^[A-Z0-9_-]+$/', $code)) {
        echo json_encode([
            'success' => false,
            'message' => '申请码格式无效，只能包含大写字母、数字、下划线和连字符'
        ]);
        return;
    }

    // 验证邮箱格式
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode([
            'success' => false,
            'message' => '邮箱格式不正确'
        ]);
        return;
    }

    // 验证性别
    if (!empty($gender) && !in_array($gender, ['male', 'female', 'other'])) {
        echo json_encode([
            'success' => false,
            'message' => '无效的性别选项'
        ]);
        return;
    }

    try {
        // 开始事务
        $pdo->beginTransaction();

        // 检查申请码是否被其他记录使用
        $checkSql = "SELECT id FROM application_codes WHERE code = :code AND id != :id";
        $checkStmt = $pdo->prepare($checkSql);
        $checkStmt->bindParam(':code', $code);
        $checkStmt->bindParam(':id', $id);
        $checkStmt->execute();

        if ($checkStmt->rowCount() > 0) {
            $pdo->rollBack();
            echo json_encode([
                'success' => false,
                'message' => '申请码已存在，请使用其他申请码'
            ]);
            return;
        }

        // 检查邮箱是否被其他用户使用
        if (!empty($email)) {
            $checkEmailSql = "SELECT id FROM users WHERE email = :email AND registration_code != :code";
            $checkEmailStmt = $pdo->prepare($checkEmailSql);
            $checkEmailStmt->bindParam(':email', $email);
            $checkEmailStmt->bindParam(':code', $code);
            $checkEmailStmt->execute();

            if ($checkEmailStmt->rowCount() > 0) {
                $pdo->rollBack();
                echo json_encode([
                    'success' => false,
                    'message' => '邮箱已被其他用户使用'
                ]);
                return;
            }
        }

        // 获取原来的申请码（用于更新用户表）
        $getOldCodeSql = "SELECT code FROM application_codes WHERE id = :id";
        $getOldCodeStmt = $pdo->prepare($getOldCodeSql);
        $getOldCodeStmt->bindParam(':id', $id);
        $getOldCodeStmt->execute();
        $oldCodeResult = $getOldCodeStmt->fetch();
        
        if (!$oldCodeResult) {
            $pdo->rollBack();
            echo json_encode([
                'success' => false,
                'message' => '申请码不存在'
            ]);
            return;
        }

        $oldCode = $oldCodeResult['code'];

        // 更新申请码表
        $updateCodeSql = "UPDATE application_codes SET code = :code, account_type = :account_type WHERE id = :id";
        $updateCodeStmt = $pdo->prepare($updateCodeSql);
        $updateCodeStmt->bindParam(':code', $code);
        $updateCodeStmt->bindParam(':account_type', $account_type);
        $updateCodeStmt->bindParam(':id', $id);
        
        if (!$updateCodeStmt->execute()) {
            $pdo->rollBack();
            echo json_encode([
                'success' => false,
                'message' => '更新申请码失败'
            ]);
            return;
        }

        // 如果有关联的用户，更新用户信息
        $checkUserSql = "SELECT id FROM users WHERE registration_code = :old_code";
        $checkUserStmt = $pdo->prepare($checkUserSql);
        $checkUserStmt->bindParam(':old_code', $oldCode);
        $checkUserStmt->execute();

        if ($checkUserStmt->rowCount() > 0) {
            // 更新用户信息
            $updateUserSql = "UPDATE users SET 
                registration_code = :new_code,
                account_type = :account_type";
            
            $params = [
                ':new_code' => $code,
                ':account_type' => $account_type
            ];

            // 只有当字段有值时才更新
            if (!empty($username)) {
                $updateUserSql .= ", username = :username";
                $params[':username'] = $username;
            }
            if (!empty($email)) {
                $updateUserSql .= ", email = :email";
                $params[':email'] = $email;
            }
            if (!empty($gender)) {
                $updateUserSql .= ", gender = :gender";
                $params[':gender'] = $gender;
            }
            if (!empty($phone_number)) {
                $updateUserSql .= ", phone_number = :phone_number";
                $params[':phone_number'] = $phone_number;
            }

            $updateUserSql .= " WHERE registration_code = :old_code";
            $params[':old_code'] = $oldCode;

            $updateUserStmt = $pdo->prepare($updateUserSql);
            
            if (!$updateUserStmt->execute($params)) {
                $pdo->rollBack();
                echo json_encode([
                    'success' => false,
                    'message' => '更新用户信息失败'
                ]);
                return;
            }
        }

        // 提交事务
        $pdo->commit();

        echo json_encode([
            'success' => true,
            'message' => '更新成功',
            'data' => [
                'id' => $id,
                'code' => $code,
                'account_type' => $account_type,
                'username' => $username,
                'email' => $email,
                'gender' => $gender,
                'phone_number' => $phone_number
            ]
        ]);

    } catch (PDOException $e) {
        $pdo->rollBack();
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
        // 开始事务
        $pdo->beginTransaction();

        // 检查申请码是否存在以及是否已被使用
        $checkSql = "SELECT code, used FROM application_codes WHERE id = :id";
        $checkStmt = $pdo->prepare($checkSql);
        $checkStmt->bindParam(':id', $id);
        $checkStmt->execute();
        
        $result = $checkStmt->fetch();
        if (!$result) {
            $pdo->rollBack();
            echo json_encode([
                'success' => false,
                'message' => '申请码不存在'
            ]);
            return;
        }

        if ($result['used'] == 1) {
            $pdo->rollBack();
            echo json_encode([
                'success' => false,
                'message' => '已使用的申请码不能删除'
            ]);
            return;
        }

        $code = $result['code'];

        // 删除申请码（由于外键约束，如果有关联的用户记录，删除会失败）
        $deleteSql = "DELETE FROM application_codes WHERE id = :id";
        $deleteStmt = $pdo->prepare($deleteSql);
        $deleteStmt->bindParam(':id', $id);
        
        if (!$deleteStmt->execute()) {
            $pdo->rollBack();
            echo json_encode([
                'success' => false,
                'message' => '删除失败，可能存在关联的用户数据'
            ]);
            return;
        }

        // 提交事务
        $pdo->commit();

        echo json_encode([
            'success' => true,
            'message' => '删除成功',
            'data' => [
                'id' => $id,
                'code' => $code
            ]
        ]);

    } catch (PDOException $e) {
        $pdo->rollBack();
        echo json_encode([
            'success' => false,
            'message' => '数据库操作失败: ' . $e->getMessage()
        ]);
    }
}

/**
 * 添加新用户
 */
function addNewUser($pdo, $input) {
    // 验证必填字段
    if (empty($input['username']) || empty($input['email']) || empty($input['account_type'])) {
        echo json_encode([
            'success' => false,
            'message' => '英文姓名、邮箱和账号类型为必填项'
        ]);
        return;
    }

    // 验证账户类型
    $valid_types = ['admin', 'hr', 'design', 'support', 'IT', 'boss', 'photograph'];
    if (!in_array($input['account_type'], $valid_types)) {
        echo json_encode([
            'success' => false,
            'message' => '无效的账户类型'
        ]);
        return;
    }

    // 验证邮箱格式
    if (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
        echo json_encode([
            'success' => false,
            'message' => '邮箱格式不正确'
        ]);
        return;
    }

    // 验证性别
    if (!empty($input['gender']) && !in_array($input['gender'], ['male', 'female', 'other'])) {
        echo json_encode([
            'success' => false,
            'message' => '无效的性别选项'
        ]);
        return;
    }

    try {
        // 开始事务
        $pdo->beginTransaction();

        // 检查邮箱是否已存在
        $checkEmailSql = "SELECT id FROM users WHERE email = :email";
        $checkEmailStmt = $pdo->prepare($checkEmailSql);
        $checkEmailStmt->bindParam(':email', $input['email']);
        $checkEmailStmt->execute();

        if ($checkEmailStmt->rowCount() > 0) {
            $pdo->rollBack();
            echo json_encode([
                'success' => false,
                'message' => '该邮箱已被注册'
            ]);
            return;
        }

        // 生成唯一的申请码
        $code = generateRandomCode($pdo);

        // 插入申请码
        $insertCodeSql = "INSERT INTO application_codes (code, account_type, used, created_at) VALUES (:code, :account_type, 1, NOW())";
        $insertCodeStmt = $pdo->prepare($insertCodeSql);
        $insertCodeStmt->bindParam(':code', $code);
        $insertCodeStmt->bindParam(':account_type', $input['account_type']);
        
        if (!$insertCodeStmt->execute()) {
            $pdo->rollBack();
            echo json_encode([
                'success' => false,
                'message' => '申请码生成失败'
            ]);
            return;
        }

        // 生成默认密码（可以让用户后续修改）
        $defaultPassword = 'kunzz123'; // 或者可以生成随机密码
        $hashedPassword = password_hash($defaultPassword, PASSWORD_DEFAULT);

        // 插入用户数据
        $insertUserSql = "INSERT INTO users (
            username, username_cn, nickname, email, password, ic_number, 
            date_of_birth, nationality, gender, race, phone_number, 
            home_address, bank_account_holder_en, bank_account, bank_name, 
            position, emergency_contact_name, emergency_phone_number, 
            account_type, registration_code, created_at
        ) VALUES (
            :username, :username_cn, :nickname, :email, :password, :ic_number,
            :date_of_birth, :nationality, :gender, :race, :phone_number,
            :home_address, :bank_account_holder_en, :bank_account, :bank_name,
            :position, :emergency_contact_name, :emergency_phone_number,
            :account_type, :registration_code, NOW()
        )";

        $insertUserStmt = $pdo->prepare($insertUserSql);
        $insertUserStmt->bindParam(':username', $input['username']);
        $insertUserStmt->bindParam(':username_cn', $input['username_cn'] ?? null);
        $insertUserStmt->bindParam(':nickname', $input['nickname'] ?? null);
        $insertUserStmt->bindParam(':email', $input['email']);
        $insertUserStmt->bindParam(':password', $hashedPassword);
        $insertUserStmt->bindParam(':ic_number', $input['ic_number'] ?? null);
        $insertUserStmt->bindParam(':date_of_birth', $input['date_of_birth'] ?? null);
        $insertUserStmt->bindParam(':nationality', $input['nationality'] ?? null);
        $insertUserStmt->bindParam(':gender', $input['gender'] ?? null);
        $insertUserStmt->bindParam(':race', $input['race'] ?? null);
        $insertUserStmt->bindParam(':phone_number', $input['phone_number'] ?? null);
        $insertUserStmt->bindParam(':home_address', $input['home_address'] ?? null);
        $insertUserStmt->bindParam(':bank_account_holder_en', $input['bank_account_holder_en'] ?? null);
        $insertUserStmt->bindParam(':bank_account', $input['bank_account'] ?? null);
        $insertUserStmt->bindParam(':bank_name', $input['bank_name'] ?? null);
        $insertUserStmt->bindParam(':position', $input['position'] ?? null);
        $insertUserStmt->bindParam(':emergency_contact_name', $input['emergency_contact_name'] ?? null);
        $insertUserStmt->bindParam(':emergency_phone_number', $input['emergency_phone_number'] ?? null);
        $insertUserStmt->bindParam(':account_type', $input['account_type']);
        $insertUserStmt->bindParam(':registration_code', $code);

        if (!$insertUserStmt->execute()) {
            $pdo->rollBack();
            echo json_encode([
                'success' => false,
                'message' => '用户创建失败'
            ]);
            return;
        }

        // 提交事务
        $pdo->commit();

        echo json_encode([
            'success' => true,
            'message' => '用户添加成功',
            'data' => [
                'username' => $input['username'],
                'email' => $input['email'],
                'code' => $code,
                'account_type' => $input['account_type'],
                'default_password' => $defaultPassword
            ]
        ]);

    } catch (PDOException $e) {
        $pdo->rollBack();
        echo json_encode([
            'success' => false,
            'message' => '数据库操作失败: ' . $e->getMessage()
        ]);
    }
}
?>