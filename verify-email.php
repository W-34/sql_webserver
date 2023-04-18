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
$MailVerify = "MailVerify";
$homework ='homework';
$conn = new mysqli($servername, $username, $password, $MailVerify);
if ($conn->connect_error) {
    echo '<p style=\'color:red;\'>网络错误，请与管理员联系</p>';
}
else{
    $query='select username,password from token where token=\''.str_check($_GET['token']).'\'';
    $result=$conn->query($query);
    if($conn->error){
        echo '<p>token错误，5秒后跳转到注册页面</p>';
        header('refresh:5;url=http://8.130.102.240/signup.html');
    }
    else{
        if($row = mysqli_fetch_assoc($result)) {
            $register='create user \''.$row['username'].'\'@\'%\' identified by \''.$row['password'].'\'';
            $conn->query($register);
            if($conn->error){
                echo '<p>注册失败，请与管理员联系</p>';
                echo '<p style=\'color:red;\'>'.$conn->error.'</p>';
            }
            else{
                $conn1=new mysqli($servername,$username,$password,$homework);
                if ($conn1->connect_error) {
                    echo '<p style=\'color:red;\'>网络错误，请与管理员联系</p>';
                }
                else{
                    $addUser='insert into user(username,passwdEncrypted,name)values(\''.$row['username'].'\',SHA2(\''.$row['password'].'\',256),\''.'USER'.generateRandomString(16).'\')';
                    $conn1->query($addUser);
                    if($conn1->error){
                        echo '<p style=\'color:red;\'>创建用户失败：</p>';
                        echo '<p style=\'color:red;\'>'.$conn->error.'</p>';
                    }
                    else{
                        echo '<p>注册成功</p>';
                        echo '<p>10秒后返回登录页面</p>';
                        header('refresh:10;url=http://8.130.102.240/index.php');
                    }
                }
            }
        }
    }
}
?>