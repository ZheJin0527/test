<?php
session_start();

// 数据库连接参数，替换成你的实际配置
$host = 'localhost';
$dbname = 'u857194726_kunzzgroup';
$dbuser = 'u857194726_kunzzgroup';
$dbpass = 'Kholdings1688@';

// 连接数据库
$conn = new mysqli($host, $dbuser, $dbpass, $dbname);
if ($conn->connect_error) {
    die("数据库连接失败: " . $conn->connect_error);
}

// 如果 session 里没有登录信息，尝试用 cookie 恢复
if (!isset($_SESSION['email']) && isset($_COOKIE['rememberme'])) {
    $token = $_COOKIE['rememberme'];

    // 查询数据库验证 token 和有效期
    $sql = "SELECT * FROM users WHERE remember_token = ? AND remember_expiry > ?";
    $stmt = $conn->prepare($sql);
    $now = time();
    $stmt->bind_param("si", $token, $now);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // 恢复 session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
    }
    $stmt->close();
}

// 最后检查 session 是否有登录信息
if (!isset($_SESSION['email'])) {
    // 关闭数据库连接
    $conn->close();

    // 跳转登录页
    header("Location: login.html");
    exit();
}

// 连接用完关闭
$conn->close();
?>
