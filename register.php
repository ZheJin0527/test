<?php
// 启用输出缓冲，防止任何非 JSON 输出
ob_start();
header("Content-Type: application/json");

// 可选：关闭警告、Notice，避免破坏 JSON
ini_set('display_errors', 0);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

// 1. 数据库连接配置
$host = 'localhost';
$dbname = 'u857194726_kunzzgroup';
$dbuser = 'u857194726_kunzzgroup';
$dbpass = 'Kholdings1688@';

// 2. 建立数据库连接
$conn = new mysqli($host, $dbuser, $dbpass, $dbname);

// 3. 检查连接是否成功
if ($conn->connect_error) {
    ob_end_clean();
    echo json_encode(["success" => false, "message" => "数据库连接失败：" . $conn->connect_error]);
    exit;
}

// 4. 获取 JSON 数据
$data = json_decode(file_get_contents("php://input"), true);

// 5. 获取字段（未提供的可以为 null）
$name = trim($data['name'] ?? '');
$email = trim($data['email'] ?? '');
$gender = trim($data['gender'] ?? '');
$application_code = trim($data['application_code'] ?? '');
$password = $data['password'] ?? '';
$account_type = trim($data['account_type'] ?? 'user');

$ic_number = $data['ic_number'] ?? null;
$position = $data['position'] ?? null;
$bank_name = $data['bank_name'] ?? null;
$bank_account = $data['bank_account'] ?? null;
$phone_number = $data['phone_number'] ?? null;
$bank_account_holder_en = $data['bank_account_holder_en'] ?? null;

// 6. 校验字段是否填写完整
if (empty($name) || empty($email) || empty($gender) || empty($application_code) || empty($password)) {
    ob_end_clean();
    echo json_encode(["success" => false, "message" => "请填写所有字段"]);
    exit;
}

// 7. 检查邮箱是否已注册
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->close();
    $conn->close();
    ob_end_clean();
    echo json_encode(["success" => false, "message" => "该邮箱已被注册，请使用其他 Gmail"]);
    exit;
}
$stmt->close();

// 8. 检查申请码是否有效并未使用
$stmt = $conn->prepare("SELECT id, used FROM application_codes WHERE code = ?");
$stmt->bind_param("s", $application_code);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $stmt->close();
    $conn->close();
    ob_end_clean();
    echo json_encode(["success" => false, "message" => "申请码无效"]);
    exit;
}

$codeData = $result->fetch_assoc();
if ($codeData['used']) {
    $stmt->close();
    $conn->close();
    ob_end_clean();
    echo json_encode(["success" => false, "message" => "申请码已被使用"]);
    exit;
}
$stmt->close();

// 9. 加密密码
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// 10. 插入用户信息（允许部分字段为 null）
$stmt = $conn->prepare("
    INSERT INTO users 
    (username, email, gender, password, account_type, ic_number, position, bank_name, bank_account, phone_number, bank_account_holder_en, created_at) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
");
$stmt->bind_param("sssssssssss", 
    $name, $email, $gender, $hashed_password, $account_type, 
    $ic_number, $position, $bank_name, $bank_account, $phone_number, $bank_account_holder_en
);

if ($stmt->execute()) {
    // 11. 更新申请码为“已使用”
    $codeId = $codeData['id'];
    $updateStmt = $conn->prepare("UPDATE application_codes SET used = 1, used_at = NOW() WHERE id = ?");
    $updateStmt->bind_param("i", $codeId);
    $updateStmt->execute();
    $updateStmt->close();

    $stmt->close();
    $conn->close();
    ob_end_clean();
    echo json_encode(["success" => true, "message" => "注册成功！"]);
    exit;
} else {
    $stmt->close();
    $conn->close();
    ob_end_clean();
    echo json_encode(["success" => false, "message" => "注册失败：" . $stmt->error]);
    exit;
}
