<?php
header("Content-Type: application/json");

// 1. 数据库连接配置
$host = 'localhost';
$dbname = 'u857194726_kunzzgroup';
$dbuser = 'u857194726_kunzzgroup';
$dbpass = 'Kholdings1688@';

// 2. 建立数据库连接
$conn = new mysqli($host, $dbuser, $dbpass, $dbname);

// 3. 检查连接是否成功
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "数据库连接失败：" . $conn->connect_error]);
    exit;
}

// 4. 获取 JSON 数据
$data = json_decode(file_get_contents("php://input"), true);

// 5. 获取字段
$name = trim($data['name'] ?? '');
$email = trim($data['email'] ?? '');
$phone = trim($data['phone_number'] ?? '');
$ic = trim($data['ic_number'] ?? '');
$position = trim($data['position'] ?? '');
$bank_name = trim($data['bank_name'] ?? '');
$bank_account_holder_en = trim($data['bank_account_holder_en'] ?? '');
$bank_account = trim($data['bank_account'] ?? '');
$password = $data['password'] ?? '';
$confirm_password = $data['confirm_password'] ?? '';

// 6. 校验字段是否填写完整
if (
    empty($name) || empty($email) || empty($phone) || empty($ic) ||
    empty($position) || empty($bank_name) || empty($bank_account_holder_en) ||
    empty($bank_account) || empty($password) || empty($confirm_password)
) {
    echo json_encode(["success" => false, "message" => "请填写所有字段"]);
    exit;
}

// 7. 检查两次密码是否一致
if ($password !== $confirm_password) {
    echo json_encode(["success" => false, "message" => "两次输入的密码不一致"]);
    exit;
}

// 8. 检查邮箱是否已经存在
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo json_encode(["success" => false, "message" => "该邮箱已被注册，请使用其他 Gmail"]);
    $stmt->close();
    $conn->close();
    exit;
}
$stmt->close();

// 9. 加密密码
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// 10. 插入用户信息（✅ 添加 bank_account_holder_en 字段）
$stmt = $conn->prepare("INSERT INTO users (username, email, phone_number, ic_number, position, bank_name, bank_account_holder_en, bank_account, password, created_at)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
$stmt->bind_param("sssssssss", $name, $email, $phone, $ic, $position, $bank_name, $bank_account_holder_en, $bank_account, $hashed_password);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "注册成功！"]);
} else {
    echo json_encode(["success" => false, "message" => "注册失败：" . $stmt->error]);
}

// 11. 关闭连接
$stmt->close();
$conn->close();
?>
