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
$gender = trim($data['gender'] ?? '');
$application_code = trim($data['application_code'] ?? '');
$password = $data['password'] ?? '';
$account_type = trim($data['account_type'] ?? 'user'); // 新字段，默认 user

// 6. 校验字段是否填写完整
if (empty($name) || empty($email) || empty($gender) || empty($application_code) || empty($password)) {
    echo json_encode(["success" => false, "message" => "请填写所有字段"]);
    exit;
}

// 7. 检查邮箱是否已注册
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

// 8. 检查申请码是否有效并未使用
$stmt = $conn->prepare("SELECT id, used FROM application_codes WHERE code = ?");
$stmt->bind_param("s", $application_code);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["success" => false, "message" => "申请码无效"]);
    $stmt->close();
    $conn->close();
    exit;
}

$codeData = $result->fetch_assoc();
if ($codeData['used']) {
    echo json_encode(["success" => false, "message" => "申请码已被使用"]);
    $stmt->close();
    $conn->close();
    exit;
}
$stmt->close();

// 9. 加密密码
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// 10. 插入用户信息（插入 account_type 字段）
$stmt = $conn->prepare("INSERT INTO users (username, email, gender, password, account_type, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
$stmt->bind_param("sssss", $name, $email, $gender, $hashed_password, $account_type);

if ($stmt->execute()) {
    // 11. 更新申请码为“已使用”
    $codeId = $codeData['id'];
    $updateStmt = $conn->prepare("UPDATE application_codes SET used = 1, used_at = NOW() WHERE id = ?");
    $updateStmt->bind_param("i", $codeId);
    $updateStmt->execute();
    $updateStmt->close();

    echo json_encode(["success" => true, "message" => "注册成功！"]);
} else {
    echo json_encode(["success" => false, "message" => "注册失败：" . $stmt->error]);
}

// 12. 关闭连接
$stmt->close();
$conn->close();
?>
