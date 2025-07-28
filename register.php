<?php
ob_start();
header("Content-Type: application/json");

ini_set('display_errors', 0);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

// 数据库配置
$host = 'localhost';
$dbname = 'u857194726_kunzzgroup';
$dbuser = 'u857194726_kunzzgroup';
$dbpass = 'Kholdings1688@';

// 数据库连接
$conn = new mysqli($host, $dbuser, $dbpass, $dbname);
if ($conn->connect_error) {
    ob_end_clean();
    echo json_encode(["success" => false, "message" => "数据库连接失败：" . $conn->connect_error]);
    exit;
}

// 获取 JSON 数据
$data = json_decode(file_get_contents("php://input"), true);

// 获取字段
$name = trim($data['name'] ?? '');
$email = trim($data['email'] ?? '');
$gender = trim($data['gender'] ?? '');
$application_code = trim($data['application_code'] ?? '');
$password = $data['password'] ?? '';

$ic_number = $data['ic_number'] ?? null;
$position = $data['position'] ?? null;
$bank_name = $data['bank_name'] ?? null;
$bank_account = $data['bank_account'] ?? null;
$phone_number = $data['phone_number'] ?? null;
$bank_account_holder_en = $data['bank_account_holder_en'] ?? null;

// 必填字段校验
if (empty($name) || empty($email) || empty($gender) || empty($application_code) || empty($password)) {
    ob_end_clean();
    echo json_encode(["success" => false, "message" => "请填写所有字段"]);
    exit;
}

// 邮箱唯一性检查
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

// ✅ 验证申请码是否存在，并包含 id 字段
$stmt = $conn->prepare("SELECT id, used, account_type FROM application_codes WHERE code = ?");
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
$stmt->close();

if ($codeData['used']) {
    $conn->close();
    ob_end_clean();
    echo json_encode(["success" => false, "message" => "申请码已被使用"]);
    exit;
}

$account_type = $codeData['account_type'];
$codeId = $codeData['id'];

// 加密密码
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// 插入用户信息
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
    // ✅ 更新申请码为已使用
    $updateStmt = $conn->prepare("UPDATE application_codes SET used = 1 WHERE id = ?");
    $updateStmt->bind_param("i", $codeId);
    $updateStmt->execute();
    $updateStmt->close();

    $stmt->close();
    $conn->close();
    ob_end_clean();
    echo json_encode(["success" => true, "message" => "注册成功！"]);
    exit;
} else {
    $errorMsg = $stmt->error;
    $stmt->close();
    $conn->close();
    ob_end_clean();
    echo json_encode(["success" => false, "message" => "注册失败：" . $errorMsg]);
    exit;
}
?>
