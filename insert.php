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
if (isset($_POST['insert_user'])) {
    // 在这里将表单数据插入数据库
    $usernameAdd=str_check($_POST['usernameAdd']);
    $passwordAdd=str_check($_POST['passwordAdd']);
    $nameAdd=str_check($_POST['nameAdd']);
    $isAuthorAdd=str_check($_POST['isAuthorAdd']);
    $mysqli = new mysqli("8.130.102.240",$username,$password,$dbname);
    // $sql = "INSERT INTO user (username,passwd,name,isAuthor) VALUES ('$usernameAdd','$passwordAdd','$nameAdd','$isAuthorAdd')";
    $sql = "INSERT INTO user (username,passwdEncrypted,name) VALUES ('$usernameAdd',SHA2('$passwordAdd',256),'$nameAdd')";
    
    $result=$mysqli->query($sql);

    $user_insert_error_message='ok';
    if($result==false){
        $user_insert_error_message=urlencode($mysqli->error);
    }
    else{
        if($isAuthorAdd==1){
            $sql2 ="INSERT INTO videoCreator (name) VALUES ('$nameAdd')";
            $result=$mysqli->query($sql2);
            if($result==false){
                $user_insert_error_message=urlencode($mysqli->error);
            }
            else{
            //echo "success";
            }
        }
    }
}else if(isset($_POST['insert_video'])){
    // 在这里将表单数据插入数据库
    $titleAdd=str_check($_POST['titleAdd']);
    $authorAdd=str_check($_POST['authorAdd']);
    $channelAdd=str_check($_POST['channelAdd']);
    $urlAdd=str_check($_POST['urlAdd']);
    $mysqli = new mysqli("8.130.102.240",$username,$password,$dbname);
    $sql = "INSERT INTO video (title,author,date,channel,url,likes) VALUES ('$titleAdd','$authorAdd',now(),'$channelAdd','$urlAdd',0)";
    $result=$mysqli->query($sql);

    $video_insert_error_message='ok';
    if($result==false){
        $video_insert_error_message=urlencode($mysqli->error);
    }
    else{
    //echo "success";
    }
}else if(isset($_POST['insert_comment'])){
    // 在这里将表单数据插入数据库
    $videoIDAdd=str_check($_POST['videoIDAdd']);
    $authorAdd=str_check($_POST['authorAdd']);
    $repidAdd=str_check($_POST['repidAdd']);
    $repAdd=str_check($_POST['repAdd']);
    $commentTextAdd=str_check($_POST['commentTextAdd']);
    $mysqli = new mysqli("8.130.102.240",$username,$password,$dbname);
    if($repidAdd==''&&$repAdd==''){
        $sql = "INSERT INTO comment (videoID,author,commentText) VALUES ('$videoIDAdd','$authorAdd','$commentTextAdd')";
    }
    else{
        $sql = "INSERT INTO comment (videoID,author,repid,rep,commentText) VALUES ('$videoIDAdd','$authorAdd','$repidAdd','$repAdd','$commentTextAdd')";
    }
    $result=$mysqli->query($sql);
    $comment_insert_error_message='ok';
    if($result==false){
    //echo '<p>$mysqli->error</p>';
    $comment_insert_error_message=urlencode($mysqli->error);
    }
    else{
    //echo "success";
    }
}else if(isset($_POST['insert_staff'])){
    // 在这里将表单数据插入数据库
    $passwdAdd=str_check($_POST['passwdAdd']);
    $isDeveloperAdd=str_check($_POST['isDeveloperAdd']);
    $isRunnerAdd=str_check($_POST['isRunnerAdd']);
    $mysqli = new mysqli("8.130.102.240",$username,$password,$dbname);
    $sql = "INSERT INTO staff (passwd,isDeveloper,isRunner) VALUES ('$passwdAdd','$isDeveloperAdd','$isRunnerAdd')";
    $result=$mysqli->query($sql);

    $staff_insert_error_message='ok';
    if($result==false){
    //echo '<p>$mysqli->error</p>';
    $staff_insert_error_message=urlencode($mysqli->error);
    }
    else{
    //echo "success";
    }
}
?>

<form id='form' method="post" action="sql.php">
    <input type="hidden" name="username" value=<?php echo $username;?>>
    <input type="hidden" name="password" value=<?php echo $password;?>>
    <input type="hidden" name="user_insert_error_message" value=<?php printf("%s",$user_insert_error_message);?>>
    <input type="hidden" name="video_insert_error_message" value=<?php printf("%s",$video_insert_error_message);?>>
    <input type="hidden" name="comment_insert_error_message" value=<?php printf("%s",$comment_insert_error_message);?>>
    <input type="hidden" name="staff_insert_error_message" value=<?php printf("%s",$staff_insert_error_message);?>>
</form>
<script>
  setTimeout(function() {
    document.getElementById("form").submit();
  }, 500);
</script>
