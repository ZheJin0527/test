<?php
header('Content-Type: application/json');

// 数据库配置
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

if (!preg_match('/^[a-zA-Z0-9._%+-]+@gmail\.com$/', $email)) {
    echo json_encode(["success" => false, "message" => "邮箱格式无效"]);
    exit;
}

// 生成6位验证码
$code = rand(100000, 999999);

// 存储到数据库（可选：建表 email_verification）
$conn->query("CREATE TABLE IF NOT EXISTS email_verification (
    email VARCHAR(255) PRIMARY KEY,
    code VARCHAR(6),
    expires_at DATETIME
)");

$expires_at = date("Y-m-d H:i:s", time() + 300); // 有效期5分钟

// 插入或更新验证码
$stmt = $conn->prepare("REPLACE INTO email_verification (email, code, expires_at) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $email, $code, $expires_at);
$stmt->execute();
$stmt->close();

// 发送邮件（你需要配置 Hostinger 的 SMTP 或使用 mail()）
$subject = "您的验证码 - KUNZZ HOLDINGS";
$message = "您的验证码是：$code，有效期为5分钟。请不要泄露给他人。";
$headers = "From: noreply@kunzz.com\r\nContent-Type: text/plain; charset=UTF-8";

if (mail($email, $subject, $message, $headers)) {
    echo json_encode(["success" => true, "message" => "验证码已发送"]);
} else {
    echo json_encode(["success" => false, "message" => "验证码发送失败，请检查邮件配置"]);
}

$conn->close();
?>
