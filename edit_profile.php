<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$host = 'localhost';
$dbname = 'u857194726_kunzzgroup';
$dbuser = 'u857194726_kunzzgroup';
$dbpass = 'Kholdings1688@';

// 创建连接
$conn = new mysqli($host, $dbuser, $dbpass, $dbname);
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];
$error = '';
$success = '';

// 处理表单提交
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $phone = trim($_POST['phone']);

    if ($username === '') {
        $error = '用户名不能为空';
    } else {
        // 更新用户名和电话
        $stmt = $conn->prepare("UPDATE users SET username = ?, phone_number = ? WHERE id = ?");
        $stmt->bind_param("ssi", $username, $phone, $user_id);
        if ($stmt->execute()) {
            $success = "更新成功！";
            $_SESSION['username'] = $username;  // 同步更新 session 里的用户名
        } else {
            $error = "更新失败，请稍后再试。";
        }
        $stmt->close();
    }
}

// 读取用户当前资料
$stmt = $conn->prepare("SELECT username, email, phone_number FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
$conn->close();

?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>编辑个人资料 - KUNZZ HOLDINGS</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
  <h2>编辑个人资料</h2>

  <?php if ($error): ?>
    <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
  <?php endif; ?>

  <?php if ($success): ?>
    <p style="color: green;"><?php echo htmlspecialchars($success); ?></p>
  <?php endif; ?>

  <form method="POST" action="edit_profile.php">
    <label>用户名:</label><br>
    <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required><br><br>

    <label>联络号码:</label><br>
    <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone_number']); ?>"><br><br>

    <label>邮箱（不可修改）:</label><br>
    <input type="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly><br><br>

    <button type="submit">保存修改</button>
    <a href="dashboard.php" style="margin-left: 15px;">返回</a>
  </form>
</body>
</html>
