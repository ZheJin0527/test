<?php
session_start();            // 启动 session
session_unset();            // 清空所有 session 变量
session_destroy();          // 销毁 session
header("Location: index.html"); // 注销后跳转回首页
exit();
?>
