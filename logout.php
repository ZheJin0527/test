<?php
session_start();

// 清空所有 session 数据
$_SESSION = [];

// 销毁 session
session_destroy();

// 清除可能存在的 session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 重定向回登录页面
header("Location: login.html");
exit();
