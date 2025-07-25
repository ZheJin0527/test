<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

// 获取 JSON 格式的 POST 数据
$data = json_decode(file_get_contents("php://input"), true);

// 简单字段验证
if (
    !isset($data["name"], $data["gender"], $data["ic_number"], $data["email"],
    $data["password"], $data["application_code"], $data["account_type"])
) {
    echo json_encode(["success" => false, "message" => "缺少必要字段。"]);
    exit;
}

// 连接数据库（请根据你的实际情况修改）
$servername = "localhost";
$username = "your_db_username";
$password = "your_db_password";
$dbname = "your_db_name";

$conn = new mysqli($servername, $username, $password, $dbname);

// 检查连接
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "数据库连接失败。"]);
    exit;
}

// 防止重复注册：检查邮箱是否已存在
$email = $conn->real_escape_string($data["email"]);
$checkEmail = $conn->query("SELECT id FROM users WHERE email = '$email'");
if ($checkEmail && $checkEmail->num_rows > 0) {
    echo json_encode(["success" => false, "message" => "该邮箱已被注册。"]);
    $conn->close();
    exit;
}

// 插入新用户
$name = $conn->real_escape_string($data["name"]);
$gender = $conn->real_escape_string($data["gender"]);
$ic_number = $conn->real_escape_string($data["ic_number"]);
$password_hash = password_hash($data["password"], PASSWORD_DEFAULT);
$application_code = $conn->real_escape_string($data["application_code"]);
$account_type = $conn->real_escape_string($data["account_type"]);

$sql = "INSERT INTO users (name, gender, ic_number, email, password, application_code, account_type)
        VALUES ('$name', '$gender', '$ic_number', '$email', '$password_hash', '$application_code', '$account_type')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["success" => true, "message" => "注册成功"]);
} else {
    echo json_encode(["success" => false, "message" => "注册失败: " . $conn->error]);
}

$conn->close();
?>
