<?php
if(!isset($_POST['username'])||!isset($_POST['password'])){
    header('Location:signup.html');
}

function generateRandomString($length = 16) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[mt_rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

$username = $_POST["username"];
$password = $_POST["password"];
$passwordDup =$_POST['passwordDup'];
$isAuthor =$_POST['becomeAuthor'];
$token=generateRandomString();
$to = $username;
$subject = "请验证您的邮箱";
$verification_link = "https://8.130.102.240/verify-email?token=<User$token>";
$message = "请点击以下链接验证您的邮箱： $verification_link";
$headers = "From: testMail@w34.com" . "\r\n" .
           "Reply-To: $to" . "\r\n" .
           "X-Mailer: PHP/" . phpversion();

if (mail($to, $subject, $message, $headers)) {
    echo "邮件已经成功发送到SMTP服务器！";
} else {
    echo "邮件发送失败：" . print_r(error_get_last(), true);
}
        
?>