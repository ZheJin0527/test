<?php
header('Content-Type: application/json');

$host = 'localhost';
$dbname = 'u857194726_kunzzgroup';
$dbuser = 'u857194726_kunzzgroup';
$dbpass = 'Kholdings1688@';

$conn = new mysqli($host, $dbuser, $dbpass, $dbname);
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "数据库连接失败"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$email = $data['email'] ?? '';
$code = $data['code'] ?? '';

// 查询验证码
$stmt = $conn->prepare("SELECT code, expires_at FROM email_verification WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    echo json_encode(["success" => false, "message" => "验证码未发送或邮箱错误"]);
    exit;
}

$stmt->bind_result($stored_code, $expires_at);
$stmt->fetch();

// 验证码匹配 + 时间没过期
if ($code === $stored_code && strtotime($expires_at) > time()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "验证码错误或已过期"]);
}

$stmt->close();
$conn->close();
?>
