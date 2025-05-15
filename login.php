<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

$host = 'localhost';
$dbname = 'u857194726_kunzzgroup';
$dbuser = 'u857194726_kunzzgroup';
$dbpass = 'Kholdings1688@';

$conn = new mysqli($host, $dbuser, $dbpass, $dbname);
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

$email = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$remember = isset($_POST['remember_me']);

if (!$email || !$password) {
    echo "<script>alert('请填写邮箱和密码'); window.location.href='login.html';</script>";
    exit();
}

// 查找用户
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];

        if ($remember) {
            // 生成随机 token
            $token = bin2hex(random_bytes(16));
            $expiry = time() + (30 * 24 * 60 * 60);

            // 这里你可以选择将 token 存数据库，配合失效时间
            // 简单示例：在 users 表新增两字段：remember_token, remember_expiry
            $updateSql = "UPDATE users SET remember_token = ?, remember_expiry = ? WHERE id = ?";
            $stmt2 = $conn->prepare($updateSql);
            $stmt2->bind_param("sii", $token, $expiry, $user['id']);
            $stmt2->execute();
            $stmt2->close();

            // 设置 cookie
            setcookie("rememberme", $token, $expiry, "/", "", false, true); // httponly=true 防XSS
        }

        header("Location: dashboard.php");
        exit();
    } else {
        echo "<script>alert('密码错误'); window.location.href='login.html';</script>";
    }
} else {
    echo "<script>alert('该账号不存在'); window.location.href='login.html';</script>";
}

$stmt->close();
$conn->close();
?>
