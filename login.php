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

// 查询用户
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        // ✅ 登录成功，设置 Session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['last_activity'] = time(); // ➤ 当前登录时间（用于 1 分钟自动登出）

        if ($remember) {
            // ✅ 勾选了“记住我”，设置 cookie（30天）
            $expire = time() + (86400 * 30);
            setcookie('user_id', $user['id'], $expire, "/");
            setcookie('username', $user['username'], $expire, "/");
            setcookie('remember_token', '1', $expire, "/");
        } else {
            // ❌ 没勾选记住我，清除残留 cookie
            setcookie('user_id', '', time() - 3600, "/");
            setcookie('username', '', time() - 3600, "/");
            setcookie('remember_token', '', time() - 3600, "/");
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
