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
        // ✅ 登录成功
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email']; // ✅ 新增

        header("Location: dashboard.php"); // ✅ 登录成功后跳转
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
