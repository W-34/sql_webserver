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
// $servername = "8.130.102.240";
$homework ='homework';
$sql_servername="MailVerify";
$sql_username = getenv('ADMIN_USERNAME');
$sql_password = getenv('ADMIN_PASSWORD');
$conn=odbc_connect($sql_servername,$sql_username,$sql_password);
$conn2=odbc_connect($homework,$sql_username,$sql_password);
if (!$conn||!$conn2) {
    odbc_close($conn);
    odbc_close($conn2);
    echo '<p style=\'color:red;\'>网络错误，请与管理员联系</p>';
}
else{
    // $query='select username,password,isAuthor from token where token=\''.str_check($_GET['token']).'\'';
    $token=$_GET['token'];
    $query='{call querytoken(?,?,?)}';
    $stmt=odbc_prepare($conn,$query);
    $username=null;
    $password=null;
    $isAuthor=null;
    odbc_execute($stmt,array($token,$username,$password,$isAuthor));
    if($username==null||$password==null){
        echo '<p>token错误，5秒后跳转到注册页面</p>';
        header('refresh:5;url=http://8.130.102.240/signup.html');
    }
    else{
        $register='create user \''.'?'.'\'@\'%\' identified by \''.'?'.'\'';
        $stmt1=odbc_prepare($conn,$register);
        odbc_execute($stmt1,array($username,$password));
        $op='{call insertUser(?,?,?,?)}';
        $stmt2=odbc_prepare($conn,$op);
        $randomName='USER_'+generateRandomString(12);
        odbc_execute($stmt2,array($username,$password,$randomName,$isAuthor));
        echo '<p>注册成功</p>';
        echo '<p>5秒后返回登录页面</p>';
        header('refresh:5;url=http://8.130.102.240/index.php');
    }
    odbc_close($conn);
    odbc_close($conn2);
}
?>