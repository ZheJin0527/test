<?php
session_start();

// 直接写数据库连接信息
$host = 'localhost';
$dbname = 'u857194726_kunzzgroup';
$dbuser = 'u857194726_kunzzgroup';
$dbpass = 'Kholdings1688@';

$conn = new mysqli($host, $dbuser, $dbpass, $dbname);
if ($conn->connect_error) {
    die("数据库连接失败: " . $conn->connect_error);
}

// 如果 session 中没有 email，尝试用 cookie 恢复登录（记住我功能）
if (!isset($_SESSION['email']) && isset($_COOKIE['rememberme'])) {
    $token = $_COOKIE['rememberme'];

    // 查询数据库，确认 token 是否有效且未过期
    $sql = "SELECT id, email FROM users WHERE remember_token = ? AND remember_expiry > NOW() LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();
        // 恢复 session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
    }

    $stmt->close();
}

if (!isset($_SESSION['email'])) {
    header("Location: login.html");
    exit();
}
?>
