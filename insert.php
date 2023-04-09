<?php
if (isset($_POST['insert_user'])) {
  // 处理表单提交
  $username = $_POST['username'];
  $password = $_POST["password"];
  $dbname = "homework";
  // 在这里将表单数据插入数据库
  $usernameAdd=$_POST['usernameAdd'];
  $passwordAdd=$_POST['passwordAdd'];
  $nameAdd=$_POST['nameAdd'];
  $isAuthorAdd=$_POST['isAuthorAdd'];
  $mysqli = new mysqli("8.130.102.240",$username,$password,$dbname);
  $sql = "INSERT INTO user (username,passwd,name,isAuthor) VALUES ('$usernameAdd','$passwordAdd','$nameAdd','$isAuthorAdd')";
  $result=$mysqli->query($sql);
  
  $user_insert_error_message='ok';
  if($result==false){
    //echo '<p>$mysqli->error</p>';
    $user_insert_error_message=$mysqli->error;
  }
  else{
    //echo "success";
  }
} else if(){

}else if(){

}else if(){
    
}
else{
    //echo "fail submit";
    header('Location: index.php');
    exit();
}
?>

<form id='form' method="post" action="sql.php">
    <input type="hidden" name="username" value=<?php echo $username;?>>
    <input type="hidden" name="password" value=<?php echo $password;?>>
    <input type="hidden" name="user_insert_error_message" value=<?php printf("%s",$user_insert_error_message);?>>
</form>
<script>
  setTimeout(function() {
    document.getElementById("form").submit();
  }, 500);
</script>
