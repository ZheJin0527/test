
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
    $date_of_birth = trim($_POST['date_of_birth']);
    $gender = trim($_POST['gender']);

    if ($username === '') {
        $error = '用户名不能为空';
    } else {
        $stmt = $conn->prepare("UPDATE users SET username=?, phone_number=?, bank_name=?, bank_account=?, home_address=?, current_address=?, city=?, state=?, postcode=?, date_of_birth=?, gender=? WHERE id=?");
        $stmt->bind_param("sssssssssssi", $username, $phone, $bank_name, $bank_account, $home_address, $current_address, $city, $state, $postcode, $date_of_birth, $gender, $user_id);
        if ($stmt->execute()) {
            $success = "更新成功！";
            $_SESSION['username'] = $username;
        } else {
            $error = "更新失败，请稍后再试。";
        }
        $stmt->close();
    }
}

$stmt = $conn->prepare("SELECT username, email, phone_number, bank_name, bank_account, home_address, current_address, city, state, postcode, position, date_of_birth, gender FROM users WHERE id = ?");
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
    <meta charset="UTF-8">
    <title>编辑个人资料 - KUNZZ HOLDINGS</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
<div class="edit-section">
    <h2>编辑个人资料</h2>

    <?php if ($error): ?>
        <p style="color: red;"><?= htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <?php if ($success): ?>
        <p style="color: green;"><?= htmlspecialchars($success); ?></p>
    <?php endif; ?>

    <form method="POST" action="edit_profile.php">
        <div class="section-title">联系资料</div>

        <label>用户名:</label>
        <input type="text" name="username" value="<?= htmlspecialchars($user['username']); ?>" required>

        <label>邮箱（不可修改）:</label>
        <input type="email" value="<?= htmlspecialchars($user['email']); ?>" readonly>

        <label>联络号码:</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($user['phone_number']); ?>">

        <label>银行名称:</label>
        <input type="text" name="bank_name" value="<?= htmlspecialchars($user['bank_name']); ?>">

        <label>银行账号:</label>
        <input type="text" name="bank_account" value="<?= htmlspecialchars($user['bank_account']); ?>">

        <label>家庭地址:</label>
        <input type="text" name="home_address" value="<?= htmlspecialchars($user['home_address']); ?>">

        <label>现居地址:</label>
        <input type="text" name="current_address" value="<?= htmlspecialchars($user['current_address']); ?>">

        <label>城市:</label>
        <input type="text" name="city" value="<?= htmlspecialchars($user['city']); ?>">

        <label>州属:</label>
        <input type="text" name="state" value="<?= htmlspecialchars($user['state']); ?>">

        <label>邮编:</label>
        <input type="text" name="postcode" value="<?= htmlspecialchars($user['postcode']); ?>">

        <div class="section-title">个人资料</div>

        <label>职位（不可修改）:</label>
        <input type="text" value="<?= htmlspecialchars($user['position']); ?>" readonly>

        <label>出生日期:</label>
        <input type="date" name="date_of_birth" value="<?= htmlspecialchars($user['date_of_birth']); ?>">

        <label>性别:</label>
        <select name="gender">
            <option value="">请选择</option>
            <option value="男" <?= $user['gender'] === '男' ? 'selected' : '' ?>>男</option>
            <option value="女" <?= $user['gender'] === '女' ? 'selected' : '' ?>>女</option>
            <option value="其他" <?= $user['gender'] === '其他' ? 'selected' : '' ?>>其他</option>
        </select>

        <button type="submit">保存修改</button>
        <a href="dashboard.php">返回</a>
    </form>
</div>
</body>
</html>
