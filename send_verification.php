<?php
header("Content-Type: application/json");

// 解析 JSON 数据
$data = json_decode(file_get_contents("php://input"), true);
$email = $data['email'] ?? '';

// 邮箱格式验证
if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/@gmail\.com$/', $email)) {
    echo json_encode(["success" => false, "message" => "无效的邮箱地址"]);
    exit;
}

// 生成 6 位数验证码
$code = rand(100000, 999999);

// 发送邮件（注意：生产环境建议使用 PHPMailer）
$subject = "KUNZZ HOLDINGS 注册验证码";
$message = "您的验证码是：$code\n请在 5 分钟内完成验证。";
$headers = "From: no-reply@kunzz.com";

if (mail($email, $subject, $message, $headers)) {
    // 存入 Session 用于后续验证（或存数据库）
    session_start();
    $_SESSION['verification_code'] = $code;
    $_SESSION['verification_email'] = $email;
    $_SESSION['code_expiry'] = time() + 300; // 有效期 5 分钟

    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "邮件发送失败"]);
}
?>
