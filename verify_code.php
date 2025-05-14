<?php
session_start();

// 获取传入的请求数据
$data = json_decode(file_get_contents("php://input"), true);
$email = $data['email'] ?? '';
$code = $data['code'] ?? '';

// 验证参数
if (empty($email) || empty($code)) {
    echo json_encode(["success" => false, "message" => "邮箱或验证码不能为空"]);
    exit();
}

// 从 session 获取验证码和邮箱
if ($_SESSION['verification_email'] === $email) {
    $storedCode = $_SESSION['verification_code'];
    $createdAt = $_SESSION['code_expiry'];

    // 验证验证码
    if ($code == $storedCode) {
        $currentTime = time();
        if ($currentTime <= $createdAt) {
            echo json_encode(["success" => true, "message" => "验证码验证成功"]);
        } else {
            echo json_encode(["success" => false, "message" => "验证码已过期，请重新获取"]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "验证码错误"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "邮箱不匹配，请重新获取验证码"]);
}
?>
