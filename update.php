<?php        
    function str_check( $str )     
    {     
        // if (!get_magic_quotes_gpc())    
        // {     
        //     $str = addslashes($str);     
        // }     
        // $str = str_replace("_", "\_", $str);   
        // $str = str_replace("%", "\%", $str);    
        return $str;     
    }     
    ?>
<?php
if(!isset($_POST['username'])||!isset($_POST['password'])){
    header('Location: index.php');
    exit();
}
else{
    $username = $_POST['username'];
    $password = $_POST["password"];
    $dbname = "homework";
}
if (isset($_POST['update_user'])) {
    $userToUpdate=str_check($_POST['userToUpdate']);
    $userToUpdateCondition=str_check($_POST['userToUpdateCondition']);
    $mysqli = new mysqli("8.130.102.240",$username,$password,$dbname);
    $sql = "update user set $userToUpdate where $userToUpdateCondition;";
    $result=$mysqli->query($sql);

    $user_update_error_message='ok';
    if($result==false){
        $user_update_error_message=urlencode($mysqli->error);
    }
    else{
        $user_update_info_message=urlencode($mysqli->affected_rows);
    }
}else if(isset($_POST['update_video'])){
    $videoToUpdate=str_check($_POST['videoToUpdate']);
    $videoToUpdateCondition=str_check($_POST['videoToUpdateCondition']);
    $mysqli = new mysqli("8.130.102.240",$username,$password,$dbname);
    $sql = "update video set $videoToUpdate where $videoToUpdateCondition;";
    $result=$mysqli->query($sql);

    $video_update_error_message='ok';
    if($result==false){
        $video_update_error_message=urlencode($mysqli->error);
    }
    else{
        $video_update_info_message=urlencode($mysqli->affected_rows);
    }
}else if(isset($_POST['update_comment'])){
    $commentToUpdate=str_check($_POST['commentToUpdate']);
    $commentToUpdateCondition=str_check($_POST['commentToUpdateCondition']);
    $mysqli = new mysqli("8.130.102.240",$username,$password,$dbname);
    $sql = "update comment set $commentToUpdate where $commentToUpdateCondition;";
    $result=$mysqli->query($sql);
    $comment_update_error_message='ok';
    if($result==false){
        $comment_update_error_message=urlencode($mysqli->error);
    }
    else{
        $comment_update_info_message=urlencode($mysqli->affected_rows);
    }
}else if(isset($_POST['update_staff'])){
    $staffToUpdate=str_check($_POST['staffToUpdate']);
    $staffToUpdateCondition=str_check($_POST['staffToUpdateCondition']);
    $mysqli = new mysqli("8.130.102.240",$username,$password,$dbname);
    $sql = "update staff set $staffToUpdate where $staffToUpdateCondition;";
    $result=$mysqli->query($sql);

    $staff_update_error_message='ok';
    if($result==false){
        $staff_update_error_message=urlencode($mysqli->error);
    }
    else{
        $staff_update_info_message=urlencode($mysqli->affected_rows);
    }
}
?>
<form id='form' method="post" action="sql.php">
    <input type="hidden" name="username" value=<?php echo $username;?>>
    <input type="hidden" name="password" value=<?php echo $password;?>>
    <input type="hidden" name="user_update_error_message" value=<?php printf("%s",$user_update_error_message);?>>
    <input type="hidden" name="video_update_error_message" value=<?php printf("%s",$video_update_error_message);?>>
    <input type="hidden" name="comment_update_error_message" value=<?php printf("%s",$comment_update_error_message);?>>
    <input type="hidden" name="staff_update_error_message" value=<?php printf("%s",$staff_update_error_message);?>>
    <input type="hidden" name="user_update_info_message" value=<?php printf("%s",$user_update_info_message);?>>
    <input type="hidden" name="video_update_info_message" value=<?php printf("%s",$video_update_info_message);?>>
    <input type="hidden" name="comment_update_info_message" value=<?php printf("%s",$comment_update_info_message);?>>
    <input type="hidden" name="staff_update_info_message" value=<?php printf("%s",$staff_delete_info_message);?>>
</form>
<script>
  setTimeout(function() {
    document.getElementById("form").submit();
  }, 500);
</script>
