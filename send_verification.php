<?php
// 获取邮箱
$data = json_decode(file_get_contents("php://input"), true);
$email = $data['email'];

// 检查邮箱格式
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["success" => false, "message" => "无效的邮箱格式"]);
    exit;
}

// 生成验证码
$verification_code = rand(100000, 999999);

// 保存验证码，通常是保存到数据库或者缓存（这里为简单示例，直接存储在 PHP 会话中）
session_start();
$_SESSION['verification_code'] = $verification_code;
$_SESSION['verification_email'] = $email;

// 发送验证码邮件（你可以根据实际需求修改邮件发送方法）
$subject = "您的注册验证码";
$message = "您的验证码是：$verification_code。请在10分钟内输入。";
$headers = "From: no-reply@yourdomain.com";

// 使用 mail() 函数发送邮件
if (mail($email, $subject, $message, $headers)) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "邮件发送失败，请稍后重试。"]);
}
?>
