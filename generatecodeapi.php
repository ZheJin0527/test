function generateCode($pdo) {
    try {
        // 验证输入
        if (empty($_POST['code']) || empty($_POST['account_type'])) {
            echo json_encode(['success' => false, 'message' => '代码和账户类型为必填项']);
            return;
        }

        $code = trim($_POST['code']);
        $account_type = $_POST['account_type'];

        // 验证账户类型
        $valid_types = ['admin', 'hr', 'design', 'support', 'IT', 'photograph'];
        if (!in_array($account_type, $valid_types)) {
            echo json_encode(['success' => false, 'message' => '无效的账户类型']);
            return;
        }

        //<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Database configuration - update these with your actual database credentials
$host = '127.0.0.1:3306';
$dbname = 'u857194726_kunzzgroup';
$username = 'your_username'; // Replace with your actual username
$password = 'your_password'; // Replace with your actual password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $e->getMessage()]);
    exit;
}

// Handle different actions
$action = $_GET['action'] ?? $_POST['action'] ?? 'generateCode';

switch ($action) {
    case 'generateCode':
        generateCode($pdo);
        break;
    case 'getCodesAndUsers':
        getCodesAndUsers($pdo);
        break;
    case 'getStatistics':
        getStatistics($pdo);
        break;
    case 'deleteCode':
        deleteCode($pdo);
        break;
    default:
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
        break;
}

function generateCode($pdo) {
    try {
        // Validate input
        if (empty($_POST['code']) || empty($_POST['account_type'])) {
            echo json_encode(['success' => false, 'message' => 'Code and account type are required']);
            return;
        }

        $code = trim($_POST['code']);
        $account_type = $_POST['account_type'];

        // Validate account type
        $valid_types = ['admin', 'hr', 'design', 'support', 'IT', 'photograph'];
        if (!in_array($account_type, $valid_types)) {
            echo json_encode(['success' => false, 'message' => 'Invalid account type']);
            return;
        }

        // Check if code already exists
        $stmt = $pdo->prepare("SELECT id FROM application_codes WHERE code = ?");
        $stmt->execute([$code]);
        
        if ($stmt->fetch()) {
            echo json_encode(['success' => false, 'message' => 'Code already exists']);
            return;
        }

        // Insert new code
        $stmt = $pdo->prepare("
            INSERT INTO application_codes (code, account_type, used, created_at) 
            VALUES (?, ?, 0, NOW())
        ");
        $stmt->execute([$code, $account_type]);

        echo json_encode([
            'success' => true, 
            'message' => 'Code generated successfully',
            'data' => [
                'id' => $pdo->lastInsertId(),
                'code' => $code,
                'account_type' => $account_type
            ]
        ]);

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Server error: ' . $e->getMessage()]);
    }
}

function getCodesAndUsers($pdo) {
    try {
        $stmt = $pdo->prepare("
            SELECT 
                ac.id as code_id,
                ac.code,
                ac.account_type,
                ac.used,
                ac.created_at as code_created_at,
                u.id as user_id,
                u.username,
                u.email,
                u.gender,
                u.phone_number,
                u.created_at as user_created_at
            FROM application_codes ac
            LEFT JOIN users u ON ac.code = u.registration_code
            ORDER BY ac.created_at DESC, ac.code ASC
        ");
        $stmt->execute();
        $results = $stmt->fetchAll();

        $data = [];
        foreach ($results as $row) {
            $data[] = [
                'code_id' => $row['code_id'],
                'code' => $row['code'],
                'account_type' => $row['account_type'],
                'used' => (int)$row['used'],
                'username' => $row['username'],
                'email' => $row['email'],
                'gender' => $row['gender'],
                'phone_number' => $row['phone_number'],
                'created_at' => $row['code_created_at'],
                'user_created_at' => $row['user_created_at']
            ];
        }

        echo json_encode([
            'success' => true,
            'data' => $data
        ]);

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Server error: ' . $e->getMessage()]);
    }
}

function getStatistics($pdo) {
    try {
        // Get total codes
        $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM application_codes");
        $stmt->execute();
        $total_codes = $stmt->fetch()['total'];

        // Get used codes
        $stmt = $pdo->prepare("SELECT COUNT(*) as used FROM application_codes WHERE used = 1");
        $stmt->execute();
        $used_codes = $stmt->fetch()['used'];

        // Get available codes
        $available_codes = $total_codes - $used_codes;

        // Get total users
        $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM users");
        $stmt->execute();
        $total_users = $stmt->fetch()['total'];

        // Get codes by type
        $stmt = $pdo->prepare("
            SELECT 
                account_type, 
                COUNT(*) as count,
                SUM(CASE WHEN used = 1 THEN 1 ELSE 0 END) as used_count
            FROM application_codes 
            GROUP BY account_type
        ");
        $stmt->execute();
        $codes_by_type = $stmt->fetchAll();

        echo json_encode([
            'success' => true,
            'data' => [
                'total_codes' => (int)$total_codes,
                'used_codes' => (int)$used_codes,
                'available_codes' => (int)$available_codes,
                'total_users' => (int)$total_users,
                'codes_by_type' => $codes_by_type
            ]
        ]);

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Server error: ' . $e->getMessage()]);
    }
}

function deleteCode($pdo) {
    try {
        if (empty($_POST['code'])) {
            echo json_encode(['success' => false, 'message' => '代码为必填项']);
            return;
        }

        $code = $_POST['code'];

        // 检查代码是否存在且未被使用
        $stmt = $pdo->prepare("SELECT used FROM application_codes WHERE code = ?");
        $stmt->execute([$code]);
        $result = $stmt->fetch();

        if (!$result) {
            echo json_encode(['success' => false, 'message' => '代码不存在']);
            return;
        }

        if ($result['used'] == 1) {
            echo json_encode(['success' => false, 'message' => '无法删除已使用的代码']);
            return;
        }

        // 删除代码
        $stmt = $pdo->prepare("DELETE FROM application_codes WHERE code = ? AND used = 0");
        $stmt->execute([$code]);

        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => true, 'message' => '代码删除成功']);
        } else {
            echo json_encode(['success' => false, 'message' => '删除代码失败']);
        }

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => '数据库错误: ' . $e->getMessage()]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => '服务器错误: ' . $e->getMessage()]);
    }
}

// 辅助函数：验证和清理输入
function sanitizeInput($input) {
    return htmlspecialchars(strip_tags(trim($input)));
}

// 辅助函数：记录操作日志（可选）
function logAction($pdo, $action, $details) {
    try {
        // 可以在这里实现日志记录功能
        // $stmt = $pdo->prepare("INSERT INTO activity_log (action, details, created_at) VALUES (?, ?, NOW())");
        // $stmt->execute([$action, $details]);
    } catch (Exception $e) {
        // 日志记录失败时静默处理
    }
}
?>