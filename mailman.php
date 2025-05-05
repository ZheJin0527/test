<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // 确保你已经用 Composer 安装 PHPMailer

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mail = new PHPMailer(true);

    try {
        // 邮件服务器设置
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'zjwu0407@gmail.com'; // 你的 Gmail 地址
        $mail->Password = 'tzvm eyht krpg ujyc'; // 16位应用密码
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // 收件人设置
        $mail->setFrom('zjwu0407@gmail.com', 'Job Application');
        $mail->addAddress('zjwu0407@gmail.com'); // 收件人，可用同一个邮箱

        // 附件
        if (isset($_FILES['resume']) && $_FILES['resume']['error'] == 0) {
            $mail->addAttachment($_FILES['resume']['tmp_name'], $_FILES['resume']['name']);
        }

        // 邮件内容
        $mail->isHTML(true);
        $mail->Subject = '新的求职申请';

        $body = "
            <h3>求职者信息：</h3>
            <p><strong>中文姓名：</strong> {$_POST['chineseName']}</p>
            <p><strong>英文姓名：</strong> {$_POST['englishName']}</p>
            <p><strong>性别：</strong> {$_POST['gender']}</p>
            <p><strong>职位类别：</strong> {$_POST['jobCategory']}</p>
            <p><strong>电话号码：</strong> {$_POST['countryCode']} {$_POST['phoneNumber']}</p>
            <p><strong>邮箱：</strong> {$_POST['email']}</p>
            <p><strong>信息：</strong> {$_POST['message']}</p>
        ";

        $mail->Body = $body;

        $mail->send();
        echo "提交成功，我们会尽快联系您。";
    } catch (Exception $e) {
        echo "提交失败，错误信息: {$mail->ErrorInfo}";
    }
}
?>
