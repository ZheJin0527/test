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

$conn = new mysqli($host, $dbuser, $dbpass, $dbname);
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];
$error = '';
$success = '';

// 表单提交
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $phone = trim($_POST['phone']);
    $bank_name = trim($_POST['bank_name']);
    $bank_account = trim($_POST['bank_account']);
    $home_address = trim($_POST['home_address']);
    $current_address = trim($_POST['current_address']);
    $city = trim($_POST['city']);
    $state = trim($_POST['state']);
    $postcode = trim($_POST['postcode']);

    if ($username === '') {
        $error = '用户名不能为空';
    } else {
        $stmt = $conn->prepare("UPDATE users SET 
            username = ?, phone_number = ?, bank_name = ?, bank_account = ?,
            home_address = ?, current_address = ?, city = ?, state = ?, postcode = ?
            WHERE id = ?");
        $stmt->bind_param("sssssssssi", 
            $username, $phone, $bank_name, $bank_account, 
            $home_address, $current_address, $city, $state, $postcode,
            $user_id
        );
        if ($stmt->execute()) {
            $success = "更新成功！";
            $_SESSION['username'] = $username;
        } else {
            $error = "更新失败，请稍后再试。";
        }
        $stmt->close();
    }
}

// 获取用户信息
$stmt = $conn->prepare("SELECT username, email, phone_number, bank_name, bank_account, position,
                        home_address, current_address, city, state, postcode
                        FROM users WHERE id = ?");
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

    <label>邮箱（不可修改）:</label><br>
    <input type="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly><br><br>

    <label>联络号码:</label><br>
    <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone_number']); ?>"><br><br>

    <label>银行名称:</label><br>
    <input type="text" name="bank_name" value="<?php echo htmlspecialchars($user['bank_name']); ?>"><br><br>

    <label>银行账号:</label><br>
    <input type="text" name="bank_account" value="<?php echo htmlspecialchars($user['bank_account']); ?>"><br><br>

    <label>家庭地址:</label><br>
    <input type="text" name="home_address" value="<?php echo htmlspecialchars($user['home_address']); ?>"><br><br>

    <label>当前地址:</label><br>
    <input type="text" name="current_address" value="<?php echo htmlspecialchars($user['current_address']); ?>"><br><br>

    <label>城市:</label><br>
    <input type="text" name="city" value="<?php echo htmlspecialchars($user['city']); ?>"><br><br>

    <label>州属:</label><br>
    <input type="text" name="state" value="<?php echo htmlspecialchars($user['state']); ?>"><br><br>

    <label>邮政编码:</label><br>
    <input type="text" name="postcode" value="<?php echo htmlspecialchars($user['postcode']); ?>"><br><br>

    <label>职位（不可修改）:</label><br>
    <input type="text" value="<?php echo htmlspecialchars($user['position']); ?>" readonly><br><br>

    <button type="submit">保存修改</button>
    <a href="dashboard.php" style="margin-left: 15px;">返回</a>
  </form>
</body>
</html>
