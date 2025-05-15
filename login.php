<?php
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

// 检查连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

// 获取表单提交的数据
$email = $_POST['username']; // 实际上是邮箱
$password = $_POST['password'];
$remember = isset($_POST['remember_me']); // 是否勾选“记住我”

// 检查邮箱是否存在
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// 如果找到了这个邮箱
if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // 验证密码
    if (password_verify($password, $user['password'])) {
        // ✅ 登录成功，设置 session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];

        // ✅ 如果勾选了“记住我”，设置 cookie（30 天有效）
        if ($remember) {
            setcookie("user_id", $user['id'], time() + (30 * 24 * 60 * 60), "/");
            setcookie("username", $user['username'], time() + (30 * 24 * 60 * 60), "/");
            setcookie("email", $user['email'], time() + (30 * 24 * 60 * 60), "/");
        }

        header("Location: dashboard.php");
        exit();
    } else {
        // 密码错误
        echo "<script>alert('密码错误'); window.location.href='login.html';</script>";
    }
} else {
    // 邮箱不存在
    echo "<script>alert('该账号不存在'); window.location.href='login.html';</script>";
}

// 关闭连接
$stmt->close();
$conn->close();
?>
