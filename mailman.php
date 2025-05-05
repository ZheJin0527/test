<?php
// 显示所有错误，便于调试
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 引入 PHPMailer 类
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// 确保正确加载 PHPMailer
require '/home/u857194726/domains/kunzzgroup.com/public_html/vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "✅ 已进入 POST 块<br>";

    // 创建 PHPMailer 实例
    $mail = new PHPMailer(true);

    try {
        // 邮件服务器设置
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'zjwu0407@gmail.com'; // 你的 Gmail 地址
        $mail->Password = 'tzvm eyht krpg ujyc'; // 16 位应用密码
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        echo "✅ 邮件服务器设置完成<br>";

        // 收件人设置
        $mail->setFrom('zjwu0407@gmail.com', 'Job Application');
        $mail->addAddress('zjwu0407@gmail.com'); // 收件人，可以是同一个邮箱

        // 附件处理
        if (isset($_FILES['resume']) && $_FILES['resume']['error'] == 0) {
            // 上传的文件有效，添加附件
            $mail->addAttachment($_FILES['resume']['tmp_name'], $_FILES['resume']['name']);
            echo "✅ 附件添加成功<br>";
        } else {
            echo "⚠️ 附件未上传或上传出错<br>";
        }

        // 邮件内容设置
        $mail->isHTML(true); // 设置邮件为 HTML 格式
        $mail->Subject = '新的求职申请';

        // 邮件正文内容（包含表单数据）
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

        echo "✅ 邮件内容准备完成<br>";

        // 发送邮件
        $mail->send();
        echo "🎉 提交成功，邮件已发送，我们会尽快联系您。";
    } catch (Exception $e) {
        // 如果邮件发送失败，显示错误信息
        echo "❌ 提交失败，错误信息: {$mail->ErrorInfo}";
    }
} else {
    // 如果请求方式不是 POST，显示错误信息
    echo "❌ 错误：不是 POST 请求";
}
?>
