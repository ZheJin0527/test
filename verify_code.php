<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start(); // 启动 session

// 数据库连接配置
$host = 'localhost';
$dbname = 'u857194726_kunzzgroup';     // 数据库名
$dbuser = 'u857194726_kunzzgroup';     // 数据库用户名
$dbpass = 'Kholdings1688@';            // 数据库密码

// 正确顺序：host, user, password, dbname
$conn = new mysqli($host, $dbuser, $dbpass, $dbname);

// 检查连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

// 获取传入的请求数据
$data = json_decode(file_get_contents("php://input"), true);

// 调试日志（可删除）
error_log(print_r($data, true));

$email = $data['email'] ?? '';
$code = $data['code'] ?? '';

// 验证参数
if (empty($email) || empty($code)) {
    echo json_encode(["success" => false, "message" => "邮箱或验证码不能为空"]);
    exit();
}

// 查询数据库中的验证码记录
$query = "SELECT * FROM verification_codes WHERE email = ? ORDER BY created_at DESC LIMIT 1";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// 验证逻辑
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $storedCode = $row['code'];
    $createdAt = strtotime($row['created_at']);

    if ($code == $storedCode) {
        $currentTime = time();
        if ($currentTime - $createdAt <= 300) {
            echo json_encode(["success" => true, "message" => "验证码验证成功"]);
        } else {
            echo json_encode(["success" => false, "message" => "验证码已过期，请重新获取"]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "验证码错误"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "未找到验证码记录，请重新获取"]);
}

// 关闭连接
$stmt->close();
$conn->close();
?>
