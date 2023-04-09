<?php
if (isset($_POST['username'])&& isset($_POST['password'])) {
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
  if($result==false){
    //echo '<p>insert fail: '.$mysqli->error.'</p>';
    header('Location: sql.php?user_insert_error_message=' . urlencode($mysqli->error));
  }
  else{
    //echo "success";
  }
} else {
    echo "fail submit";
  header('Location: index.php');
  exit();
}
?>
