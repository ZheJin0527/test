<?php
// 1. 连接到数据库（确保数据库有一个表来存储验证码及其相关信息）
// 这里假设你已经有一个 "verification_codes" 表，包含 `email`, `code`, `created_at` 字段

include('db_connection.php'); // 你的数据库连接文件

// 获取传入的请求数据
$data = json_decode(file_get_contents("php://input"), true);
$email = $data['email'];
$code = $data['code'];

// 确保提供了邮箱和验证码
if (empty($email) || empty($code)) {
    echo json_encode(["success" => false, "message" => "邮箱或验证码不能为空"]);
    exit();
}

// 2. 从数据库查询验证码
$query = "SELECT * FROM verification_codes WHERE email = ? ORDER BY created_at DESC LIMIT 1";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // 获取最新的验证码记录
    $row = $result->fetch_assoc();
    $storedCode = $row['code'];
    $createdAt = strtotime($row['created_at']);
    
    // 检查验证码是否匹配以及是否过期（假设验证码有效期为5分钟）
    if ($code == $storedCode) {
        $currentTime = time();
        
        // 验证码是否在有效期内
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
