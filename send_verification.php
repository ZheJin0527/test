<?php
// 设置响应为 JSON
header("Content-Type: application/json");

// 数据库配置
$host = 'localhost';
$dbname = 'u857194726_kunzzgroup';
$dbuser = 'u857194726_kunzzgroup';
$dbpass = 'Kholdings1688@';

// 连接数据库
$conn = new mysqli($host, $dbuser, $dbpass, $dbname);
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "数据库连接失败"]);
    exit;
}

// 读取请求体中的 email
$data = json_decode(file_get_contents("php://input"), true);
$email = $data['email'] ?? '';

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["success" => false, "message" => "无效的邮箱地址"]);
    exit;
}

// 生成6位验证码
$code = rand(100000, 999999);

// 将验证码保存到数据库（如果 verification_codes 表不存在，请告诉我，我来帮你建）
$stmt = $conn->prepare("REPLACE INTO verification_codes (email, code, created_at) VALUES (?, ?, NOW())");
$stmt->bind_param("ss", $email, $code);
$stmt->execute();
$stmt->close();

// 设置发送邮件参数
$subject = "您的验证码";
$message = "您的验证码是：$code\n有效时间为10分钟。";
$headers = "From: no-reply@kunzzgroup.com\r\nContent-Type: text/plain; charset=UTF-8";

// 发送邮件
if (mail($email, $subject, $message, $headers)) {
    echo json_encode(["success" => true, "message" => "验证码已发送"]);
} else {
    echo json_encode(["success" => false, "message" => "邮件发送失败，请稍后重试"]);
}

$conn->close();
?>
