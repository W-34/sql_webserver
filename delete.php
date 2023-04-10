<?php        
    function str_check( $str )     
    {     
        // if (!get_magic_quotes_gpc()) // 判断magic_quotes_gpc是否打开     
        // {     
        //     $str = addslashes($str); // 进行过滤     
        // }     
        // $str = str_replace("_", "\_", $str); // 把 '_'过滤掉     
        // $str = str_replace("%", "\%", $str); // 把' % '过滤掉     
        return $str;     
    }     
    ?>
<?php
if(!isset($_POST['username'])||!isset($_POST['password'])){
    //echo "fail submit";
    header('Location: index.php');
    exit();
}
else{
    // 处理表单提交
    $username = $_POST['username'];
    $password = $_POST["password"];
    $dbname = "homework";
}
if (isset($_POST['delete_user'])) {
    // 在这里将表单数据插入数据库
    $userToDel=str_check($_POST['userToDel']);
    $mysqli = new mysqli("8.130.102.240",$username,$password,$dbname);
    $sql = "DELETE FROM user where $userToDel;";
    $result=$mysqli->query($sql);

    $user_delete_error_message='ok';
    if($result==false){
        $user_delete_error_message=urlencode($mysqli->error);
    }
    else{
        $user_delete_info_message=urlencode($mysqli->affected_rows);
    }
}else if(isset($_POST['delete_video'])){
    // 在这里将表单数据插入数据库
    $videoToDel=str_check($_POST['videoToDel']);
    $mysqli = new mysqli("8.130.102.240",$username,$password,$dbname);
    $sql = "DELETE FROM video where $videoToDel;";
    $result=$mysqli->query($sql);

    $video_delete_error_message='ok';
    if($result==false){
        $video_delete_error_message=urlencode($mysqli->error);
    }
    else{
    }
}else if(isset($_POST['delete_comment'])){
    // 在这里将表单数据插入数据库
    $commentToDel=str_check($_POST['commentToDel']);
    $mysqli = new mysqli("8.130.102.240",$username,$password,$dbname);
    $sql = "DELETE FROM comment where $commentToDel;";
    $result=$mysqli->query($sql);
    $comment_delete_error_message='ok';
    if($result==false){
        $comment_delete_error_message=urlencode($mysqli->error);
    }
    else{
    }
}else if(isset($_POST['delete_staff'])){
    // 在这里将表单数据插入数据库
    $staffToDel=str_check($_POST['staffToDel']);
    $mysqli = new mysqli("8.130.102.240",$username,$password,$dbname);
    $sql = "DELETE FROM staff where $staffToDel;";
    $result=$mysqli->query($sql);

    $staff_delete_error_message='ok';
    if($result==false){
        $staff_delete_error_message=urlencode($mysqli->error);
    }
    else{
    }
}
?>
<form id='form' method="post" action="sql.php">
    <input type="hidden" name="username" value=<?php echo $username;?>>
    <input type="hidden" name="password" value=<?php echo $password;?>>
    <input type="hidden" name="user_delete_error_message" value=<?php printf("%s",$user_delete_error_message);?>>
    <input type="hidden" name="video_delete_error_message" value=<?php printf("%s",$video_delete_error_message);?>>
    <input type="hidden" name="comment_delete_error_message" value=<?php printf("%s",$comment_delete_error_message);?>>
    <input type="hidden" name="staff_delete_error_message" value=<?php printf("%s",$staff_delete_error_message);?>>
    <input type="hidden" name="user_delete_info_message" value=<?php printf("%s",$user_delete_info_message);?>>
    <input type="hidden" name="video_delete_info_message" value=<?php printf("%s",$video_delete_info_message);?>>
    <input type="hidden" name="comment_delete_info_message" value=<?php printf("%s",$comment_delete_info_message);?>>
    <input type="hidden" name="staff_delete_info_message" value=<?php printf("%s",$staff_delete_info_message);?>>
</form>
<script>
  setTimeout(function() {
    document.getElementById("form").submit();
  }, 500);
</script>
