<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start(); // 启动 session

// 数据库连接配置
$host = 'localhost';
$dbname = 'u857194726_kunzzgroup';
$dbuser = 'u857194726_kunzzgroup';
$dbpass = 'Kholdings1688@';

// 连接数据库
$conn = new mysqli($host, $dbuser, $dbpass, $dbname);
if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "数据库连接失败: " . $conn->connect_error]));
}

// 获取传入数据
$data = json_decode(file_get_contents("php://input"), true);
$email = $data['email'] ?? '';
$code = $data['code'] ?? '';

// 参数检查
if (empty($email) || empty($code)) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "邮箱或验证码不能为空"]);
    exit();
}

// 查找最新验证码
$query = "SELECT * FROM verification_codes WHERE email = ? ORDER BY created_at DESC LIMIT 1";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $storedCode = $row['code'];
    $createdAt = strtotime($row['created_at']);
    $currentTime = time();

    if ((string)$code === (string)$storedCode) {
        if ($currentTime - $createdAt <= 300) {
            echo json_encode(["success" => true, "message" => "验证码验证成功"]);
        } else {
            http_response_code(400);
            echo json_encode(["success" => false, "message" => "验证码已过期，请重新获取"]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["success" => false, "message" => "验证码错误"]);
    }
} else {
    http_response_code(404);
    echo json_encode(["success" => false, "message" => "未找到验证码记录，请重新获取"]);
}

$stmt->close();
$conn->close();
?>
