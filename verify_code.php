<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 包含数据库连接
include('db_connection.php'); // 确保路径正确

// 获取传入的请求数据
$data = json_decode(file_get_contents("php://input"), true);

// 调试输出
error_log(print_r($data, true));

$email = $data['email'];
$code = $data['code'];

// 确保提供了邮箱和验证码
if (empty($email) || empty($code)) {
    echo json_encode(["success" => false, "message" => "邮箱或验证码不能为空"]);
    exit();
}

// 连接数据库，查询验证码
$query = "SELECT * FROM verification_codes WHERE email = ? ORDER BY created_at DESC LIMIT 1";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// 调试输出
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $storedCode = $row['code'];
    $createdAt = strtotime($row['created_at']);
    
    // 检查验证码是否匹配
    if ($code == $storedCode) {
        $currentTime = time();
        
        // 检查验证码是否过期
        if ($currentTime - $createdAt <= 300) { // 5分钟有效期
            echo json_encode(["success" => true, "message" => "验证码验证成功"]);
        } else {
            echo json_encode(["success" => false, "message" => "验证码已过期，请重新获取"]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "验证码错误"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "未找到验证码记录，请重新获取"]);
}

// 关闭数据库连接
$stmt->close();
$conn->close();
?>
