<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
if(!isset($_POST['username'])||!isset($_POST['password'])){
    header('Location:signup.html');
}

function generateRandomString($length = 32) {
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
$verification_link = "http://8.130.102.240/verify-email.php?token=$token";
$message = "请点击以下链接验证您的邮箱： <a href='$verification_link'>确认注册</a>";
// $headers = "From: testMail@w34.com" . "\r\n" .
//            "Reply-To: $to" . "\r\n" .
//            "X-Mailer: PHP/" . phpversion();

$mail=new PHPMailer(true);
try {
    // 配置SMTP服务器地址和端口号
    $mail->isSMTP();
    $mail->Host       = 'smtp.qq.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = getenv('SMTP_USERNAME');
    $mail->Password   = getenv('SMTP_PASSWORD');
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;
    $mail->CharSet = 'UTF-8';
    // 设置收件人、主题和内容
    $mail->setFrom('1405663018@qq.com', 'W-34 数据库作业_注册认证');
    $mail->addAddress($to, 'Recipient Name');
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body    = $message;

    // 发送邮件
    $mail->send();
    echo '<p>邮件发送成功！</p>';
} catch (Exception $e) {
    echo '邮件发送失败：', $mail->ErrorInfo;
}


$sql_servername="MailVerify";
$sql_username = getenv('ADMIN_USERNAME');
$sql_password = getenv('ADMIN_PASSWORD');
$sql_dbname = "MailVerify";
$sql_conn=odbc_connect($sql_servername,$sql_username,$sql_password);
if (!$sql_conn) {
    echo '<p style=\'color:red;\'>内部错误，请与管理员联系</p>';
}
else{
    $error_message=null;
    if($isAuthor!=1)$isAuthor=0;
    $query='{call addUser(?,?,?,?,?)}';
    $stmt=odbc_prepare($sql_conn,$query);

    odbc_execute($stmt,array($token,$username,$password,$isAuthor,$error_message));
    // odbc_fetch_into($stmt,$row);
    // $error_message= $row[0];
    odbc_close($sql_conn);
    if($error_message!=null){
        echo '<p style=\'color:red;\'>'.$error_message.'</p><br>';
        echo '<p style=\'color:red;\'>创建token失败，请与管理员联系</p>';
    }
    else{
        echo'<p>请查看邮箱，点击验证链接完成注册</p>';
    }
    return $error_message;
}
?>