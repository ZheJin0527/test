<?php
// 1. 数据库连接配置
$host = 'localhost';           // 通常是 localhost
$dbname = 'u857194726_kunzzgroup';        // ← 请改成你在 Hostinger 创建的数据库名
$dbuser = 'u857194726_kunzzgroup';    // ← 改成你的数据库用户名
$dbpass = 'Kholdings1688@';      // ← 改成你的数据库密码

// 2. 连接数据库
$conn = new mysqli($host, $dbuser, $dbpass, $dbname);

// 检查连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

// 3. 获取表单数据
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// 4. 验证两次密码是否一致
if ($password !== $confirm_password) {
    echo "两次输入的密码不一致，请返回修改。";
    exit;
}

// 5. 检查邮箱是否已被注册
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo "该邮箱已被注册，请使用其他 Gmail。";
    $stmt->close();
    $conn->close();
    exit;
}
$stmt->close();

// 6. 加密密码
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// 7. 插入用户数据
$stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $email, $hashed_password);

if ($stmt->execute()) {
    echo "注册成功！现在你可以<a href='login.html'>登录</a>了。";
} else {
    echo "注册失败，请稍后重试。";
}

$stmt->close();
$conn->close();
?>
