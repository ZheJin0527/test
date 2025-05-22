<?php
ob_start();
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 数据库连接信息
$host = 'localhost';
$dbname = 'u857194726_kunzzgroup';
$dbuser = 'u857194726_kunzzgroup';
$dbpass = 'Kholdings1688@';

// 创建连接
$conn = new mysqli($host, $dbuser, $dbpass, $dbname);
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

// 获取提交数据
$email = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$remember = isset($_POST['remember']); // true/false

// 检查邮箱是否存在
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        // 登录成功，写入 session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        if ($remember) {
            // 记住我，设置30天有效Cookie
            $expire = time() + (86400 * 30);
            setcookie('user_id', $user['id'], $expire, "/");
            setcookie('username', $user['username'], $expire, "/");
        } else {
            // 没勾选记住我，删除旧的Cookie（防止误用）
            setcookie('user_id', '', time() - 3600, "/");
            setcookie('username', '', time() - 3600, "/");
        }

        header("Location: dashboard.php");
        exit();
    } else {
        echo "<script>alert('密码错误'); window.location.href='login.html';</script>";
        exit();
    }
} else {
    echo "<script>alert('该账号不存在'); window.location.href='login.html';</script>";
    exit();
}

$stmt->close();
$conn->close();
ob_end_flush();
