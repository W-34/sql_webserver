<?php
// 获取表单数据
$username = $_POST['username'];
$password = $_POST['password'];

// 在这里进行用户名和密码的验证，判断登录是否成功

$servername = "8.130.102.240";
$dbname = "homework";

// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);

// 检查连接是否成功
if($conn->connect_error) {
    // 如果登录失败，将用户重定向到登录页面，并显示错误消息
    $error_message = $conn->connect_error;
    header('Location: index.php?error_message=' . urlencode($error_message));
}
// else{
    
//     header('Location: sql.php?username=' . urlencode($username).'?password='.urlencode($password));
// }
?>
<form action="login.php" method="post">
username: <input type='' name="username"><br>
password: <input type="text" name="password"><hr>

<input type="submit" value="提交">
</form>
