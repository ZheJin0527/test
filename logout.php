<?php
session_start();
require_once 'db_connect.php'; // 你的数据库连接代码

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // 清除数据库token
    $sql = "UPDATE users SET remember_token = NULL, remember_expiry = NULL WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->close();
}

// 清除 session
$_SESSION = [];
session_destroy();

// 清除 cookie
setcookie("rememberme", "", time() - 3600, "/");

header("Location: login.html");
exit();
?>