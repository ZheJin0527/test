<?php
session_start();

// 清除session
$_SESSION = [];
session_destroy();

// 删除 rememberme cookie
if (isset($_COOKIE['rememberme'])) {
    setcookie('rememberme', '', time() - 3600, "/");
}

// 跳转登录页
header("Location: login.html");
exit();
?>
