<?php
// 设置数据库连接参数（根据你的 Hostinger 信息修改）
$host = 'localhost';
$dbname = 'u857194726_tokyo'; // 你的餐厅数据库名
$user = 'u857194726_tokyo'; // 数据库用户名
$pass = 'Kholdings1688@';       // 数据库密码

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("数据库连接失败: " . $e->getMessage());
}

// 获取表单数据
$username = $_POST['username'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

// 验证密码一致
if ($password !== $confirm_password) {
    echo "两次密码不一致，请返回重新输入。";
    exit;
}

// 检查邮箱是否已注册
$stmt = $pdo->prepare("SELECT id FROM tokyo_users WHERE email = ?");
$stmt->execute([$email]);

if ($stmt->rowCount() > 0) {
    echo "该邮箱已注册，请直接登录或使用其他邮箱。";
    exit;
}

// 密码加密
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// 插入用户数据
$stmt = $pdo->prepare("INSERT INTO tokyo_users (username, email, password) VALUES (?, ?, ?)");

if ($stmt->execute([$username, $email, $hashed_password])) {
    echo "注册成功！<a href='tokyologin.html'>点击这里登录</a>";
} else {
    echo "注册失败，请稍后再试。";
}
?>
