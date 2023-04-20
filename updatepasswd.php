<?php        
    function str_check( $str )     
    {     
        if (!get_magic_quotes_gpc()) // 判断magic_quotes_gpc是否打开     
        {     
            $str = addslashes($str); // 进行过滤     
        }     
        $str = str_replace("_", "\_", $str); // 把 '_'过滤掉     
        $str = str_replace("%", "\%", $str); // 把' % '过滤掉     
        return $str;     
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
?>
<?php
$servername = "8.130.102.240";
$username = getenv('ADMIN_USERNAME');
$password = getenv('ADMIN_PASSWORD');
$resetpassword = "resetpassword";
$homework='homework';
$mysql ='mysql';
$conn = new mysqli($servername, $username, $password, $resetpassword);
$conn1 = new mysqli($servername, $username, $password, $mysql);
$conn2 = new mysqli($servername, $username, $password, $homework);
if ($conn->connect_error||$conn1->connect_error||$conn2->connect_error) {
    echo '<p style=\'color:red;\'>网络错误，请与管理员联系</p>';
}
else{
    $query='select username,token from tokens where token=\''.str_check($_POST['token']).'\' and username=\''.str_check($_POST['username']).'\'';
    $result=$conn->query($query);
    if($conn->error){
        echo '<p>token错误，5秒后跳转到注册页面</p>';
        header('refresh:5;url=http://8.130.102.240/signup.html');
    }
    else{
        $row = mysqli_fetch_assoc($result);
        if($row) {
            $register='alter user \''.$row['username'].'\'@\'%\' identified with caching_sha2_password by \''.$_POST['password'].'\'';
            $conn1->query($register);
            if($conn1->error){
                echo '<p>内部错误，请与管理员联系</p>';
                echo '<p style=\'color:red;\'>'.$conn1->error.'</p>';
            }
            else{
                $addUser='update user set passwdEncrypted=sha2(\''.$_POST['password'].'\',256)'.'where username =\''.$_POST['username'].'\'';
                $conn2->query($addUser);
                if($conn2->error){
                    echo '<p style=\'color:red;\'>更新密码失败：</p>';
                    echo '<p style=\'color:red;\'>'.$conn2->error.'</p>';
                }
                else{
                    echo '<p>重置密码成功</p>';
                    echo '<p>5秒后返回登录页面</p>';
                    header('refresh:5;url=http://8.130.102.240/index.php');
                }
            }
        }
        else{
            echo '<p>token错误，5秒后跳转到注册页面</p>';
            header('refresh:5;url=http://8.130.102.240/signup.html');
        }
    }
}
?>