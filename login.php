<?php
session_start();

// 数据库连接
$host = 'localhost';
$dbname = 'u857194726_kunzzgroup';
$dbuser = 'u857194726_kunzzgroup';
$dbpass = 'Kholdings1688@';

$conn = new mysqli($host, $dbuser, $dbpass, $dbname);
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

$email = $_POST['username'];
$password = $_POST['password'];
$remember = isset($_POST['remember_me']);

// 检查邮箱是否存在
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];

        if ($remember) {
            // 生成随机 token
            $token = bin2hex(random_bytes(16));
            $expiry = date('Y-m-d H:i:s', time() + 30*24*60*60); // 30天有效期

            // 更新数据库token和过期时间
            $update_sql = "UPDATE users SET remember_token = ?, remember_expiry = ? WHERE id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("ssi", $token, $expiry, $user['id']);
            $update_stmt->execute();
            $update_stmt->close();

            // 设置 cookie
            setcookie("rememberme", $token, time() + 30*24*60*60, "/");
        } else {
            // 如果没勾选，确保数据库清空 token
            $update_sql = "UPDATE users SET remember_token = NULL, remember_expiry = NULL WHERE id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("i", $user['id']);
            $update_stmt->execute();
            $update_stmt->close();

            // 清除 cookie
            setcookie("rememberme", "", time() - 3600, "/");
        }

        header("Location: dashboard.php");
        exit();
    } else {
        echo "<script>alert('密码错误'); window.location.href='login.html';</script>";
    }
} else {
    echo "<script>alert('该账号不存在'); window.location.href='login.html';</script>";
}

$stmt->close();
$conn->close();
?>
