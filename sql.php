<html>
<meta charset="utf-8">
<head> 
  <title>w34's MySQL</title> 
  <style>
  .root_query{
    text-align: center;
    background-color:#FFD700;
  }
  .text_query{
    width:600px;
    padding: 20px;
    border: 5px;
    border-style: groove;
    border-color: #FFA500;
  }
  .root_query_submit{
    width: 75px;
    height: 50px;
  }
  td{
    padding: 5px;
  }
  </style>
</head>
<div id="header" style="background-color:#FFA500;">
<h1 style="text-align:center">数据表控制台</h1>
<h2 style="text-align:center;margin-bottom:0;">当前mysql登录用户：<?php echo $_POST["username"]; ?></h2></div>
<hr>

<?php
//header("content-type:text/html;charset=utf-8");
$servername = "8.130.102.240";
$username = $_POST["username"];
$password = $_POST["password"];
$dbname = "homework";

// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn, "utf8mb4");
// 检查连接是否成功
if ($conn->connect_error) {
  $error_message = $conn->connect_error;
  header('Location: index.php?error_message=' . urlencode($error_message));
}
?>
<div class="root_query">
  <div style="width:500px"></div>
  <div id="root_query" style="">
    <form method="post" action="sql.php">
      <input type="hidden" name="root_query" value=1>
      <input type="hidden" name="username" value=<?php echo $username;?>>
      <input type="hidden" name="password" value=<?php echo $password;?>>
      <input class="text_query" type="text" name="text_query" placeholder="从数据库homework中查询">
      <input class="root_query_submit" type="submit" name="submit_root_query" value="查询">
    </form>
  </div>
  <div class="result">
    <?php
      if (isset($_POST['root_query'])) {
        if($_POST['username']!='root'){
          printf("<p style=\"color: red;width=500;\">非root用户</p>");
        }
        else{
          $sql = $_POST['text_query'];
          if(substr($_POST['text_query'],0,6)!='SELECT'&&substr($_POST['text_query'],0,6)!='select'){
            printf("<p style=\"color: red;width=500;\">非SELECT语句</p>");
          }
          else{
            $result = $conn->query($sql);
            printf("<div style=\"width=400\"></div>");
            printf("<table border=\"1\" style=\"margin-left: 100px;\">");
            printf("<tbody>");
            $fields = mysqli_fetch_fields($result);
            $column_names = array();
            foreach ($fields as $field) {
                $column_names[] = $field->name;
            }
            echo "<tr>";
            foreach ($column_names as $column_name) {
                echo "<th>" . $column_name . "</th>";
            }
            echo "</tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                printf("<tr>");
                foreach ($column_names as $column_name) {
                  printf("<td>%s</td>",$row[$column_name]);
                }
                printf("</tr>");
            }
            // printf("<colgroup>");
            // printf("<col >");
            // printf("<col >");
            // printf("<col >");
            // printf("</colgroup>");
            printf("</tbody></table>");
          }
        }
      }
    ?>
  </div>
</div>
<hr>
<table cellspacing="100" style="background-color:#FFD700;">
  <tr>
  <td id="Table:user" style="width:500px;vertical-align:top;">
    <?php
    $sql = "select * from user_fromweb limit 20";
    $result = $conn->query($sql);
    ?>
    <table border="1" style="background-color:#EEEEEE;float:left;">
      <caption style="color:red">user表</caption>
      <tbody>
        <tr>
          <th>id</th>
          <th>username</th>
          <th>name</th>
        </tr>
        <?php
            while($row = mysqli_fetch_assoc($result)) {
                printf("<tr> <td>%s   </td> <td>%s   </td> <td>%s   </td> </tr>", $row["id"],$row["username"], $row["name"]);
            }
        ?>
      </tbody>
      <colgroup>
        <col width="50">
        <col width="200">
        <col width="200">
      </colgroup>
    </table>
    <button id="add_user">添加</button>
    <div id="add_user_formContainer" style="display:none;">
      <form method="post" action="insert.php">
        <input type="hidden" name="insert_user" value=1>
        <input type="hidden" name="username" value=<?php echo $username;?>>
        <input type="hidden" name="password" value=<?php echo $password;?>>
        <input type="text" name="usernameAdd" placeholder="username" style="width=250;"><br>
        <input type="password" name="passwordAdd" placeholder="password" style="width=250;"><br>
        <input type="text" name="nameAdd" placeholder="name" style="width=200;"><br>
        <input type="radio" name="isAuthorAdd" value=1>视频作者
        <input type="radio" name="isAuthorAdd" value=0>普通用户<br>
        <input type="submit" name="submit" value="提交">
      </form>
    </div>
    <button id="delete_user">删除</button>
    <div id="delete_user_formContainer" style="display:none;">
      <form method="post" action="delete.php">
        <input type="hidden" name="delete_user" value=1>
        <input type="hidden" name="username" value=<?php echo $username;?>>
        <input type="hidden" name="password" value=<?php echo $password;?>>
        delete from user where <input type="text" name="userToDel" placeholder="删除条件" style="width=300;"><br>
        <input type="submit" name="submit" value="提交">
      </form>
    </div>
    <script>
    var delete_user = document.getElementById("delete_user");
    var delete_user_formContainer = document.getElementById("delete_user_formContainer");
    var delete_user_show=0;
    delete_user.addEventListener("click", function() {
      if(delete_user_show%2==0){
        delete_user_formContainer.style.display = "block";
        delete_user.innerHTML='隐藏';
      }
      else{
        delete_user_formContainer.style.display='none';
        delete_user.innerHTML='删除';
      }
      delete_user_show++;
    });
    </script>
    <button id="update_user">修改</button>
    <div id="update_user_formContainer" style="display:none;">
      <form method="post" action="update.php">
        <input type="hidden" name="update_user" value=1>
        <input type="hidden" name="username" value=<?php echo $username;?>>
        <input type="hidden" name="password" value=<?php echo $password;?>>
        update user set <input type="text" name="userToUpdate" placeholder="修改的内容" style="width=150;"><br>
         where <input type="text" name="userToUpdateCondition" placeholder="true" style="width=150;"><br>
        <input type="submit" name="submit" value="提交">
      </form>
    </div>
    <script>
    var update_user = document.getElementById("update_user");
    var update_user_formContainer = document.getElementById("update_user_formContainer");
    var update_user_show=0;
    update_user.addEventListener("click", function() {
      if(update_user_show%2==0){
        update_user_formContainer.style.display = "block";
        update_user.innerHTML='隐藏';
      }
      else{
        update_user_formContainer.style.display='none';
        update_user.innerHTML='修改';
      }
      update_user_show++;
    });
    </script>
    <p style="color: red;width=500;">
    <?php
      if (isset($_POST['user_insert_error_message'])&&$_POST['user_insert_error_message']!='ok') {
        $user_insert_error_message = $_POST['user_insert_error_message'];
        printf("%s<br>",urldecode($user_insert_error_message));
        if(substr(urldecode($user_insert_error_message),0,21)=='INSERT command denied'){
          printf("账号%s不具有该表的插入权限",$username);
        }
      }
    ?>
    </p>
    <p style="color: red;width=500;">
    <?php
      if (isset($_POST['user_delete_error_message'])&&$_POST['user_delete_error_message']!='ok') {
        $user_delete_error_message = $_POST['user_delete_error_message'];
        printf("%s<br>",urldecode($user_delete_error_message));
        if(substr(urldecode($user_delete_error_message),0,21)=='DELETE command denied'){
          printf("账号%s不具有该表的删除权限",$username);
        }
      }
    ?>
    </p>
    <p style="color: green;width=500;">
    <?php
      if (isset($_POST['user_delete_info_message'])&&$_POST['user_delete_info_message']!='') {
        $user_delete_info_message = $_POST['user_delete_info_message'];
        printf("%s条数据被删除<br>",urldecode($user_delete_info_message));
      }
    ?>
    </p>
    <p style="color: red;width=500;">
    <?php
      if (isset($_POST['user_update_error_message'])&&$_POST['user_update_error_message']!='ok') {
        $user_update_error_message = $_POST['user_update_error_message'];
        printf("%s<br>",urldecode($user_update_error_message));
        if(substr(urldecode($user_delete_error_message),0,21)=='UPDATE command denied'){
          printf("账号%s不具有该表的修改权限",$username);
        }
      }
    ?>
    </p>
    </p>
    <p style="color: green;width=500;">
    <?php
      if (isset($_POST['user_update_info_message'])&&$_POST['user_update_info_message']!='') {
        $user_update_info_message = $_POST['user_update_info_message'];
        printf("%s条数据被修改<br>",urldecode($user_update_info_message));
      }
    ?>
    </p>
    <script>
    var add_user = document.getElementById("add_user");
    var add_user_formContainer = document.getElementById("add_user_formContainer");
    var add_user_show=0;
    add_user.addEventListener("click", function() {
      if(add_user_show%2==0){
        add_user_formContainer.style.display = "block";
        add_user.innerHTML='隐藏';
      }
      else{
        add_user_formContainer.style.display='none';
        add_user.innerHTML='添加';
      }
      add_user_show++;
    });
    // var form = document.querySelector('form');
    // form.addEventListener('submit', function(event) {
    //   event.preventDefault();
    //   var formData = new FormData(form);
    //   var xhr = new XMLHttpRequest();
    //   xhr.open('POST', 'insert.php');
    //   xhr.send(formData);
    //   location.reload();
    // });
    </script>
  </td>

  <td id="Table:video" style="width:1100px;vertical-align:top;">
    <?php
    $sql = "select * from video_fromweb limit 20";
    $result = $conn->query($sql);
    ?>
    <table border="1" style="background-color:#EEEEEE;float:left;">
      <caption style="color:red">video表</caption>
      <tbody>
        <tr>
          <th>id</th>
          <th>title</th>
          <th>author</th>
          <th>date</th>
          <th>channel</th>
          <th>likes</th>
        </tr>
        <?php
            while($row = mysqli_fetch_assoc($result)) {
                printf("<tr> <td>%d</td> <td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td> <td>%d</td></tr>",
                $row["id"],$row["title"], $row["author"], $row["date"],$row["channel"],$row['likes']);
            }
        ?>
      </tbody>
      <colgroup>
        <col width="50">
        <col width="200">
        <col width="200">
        <col width="200">
        <col width="250">
        <col width="100">
      </colgroup>
    </table>
    <button id="add_video">添加</button>
    <div id="add_video_formContainer" style="display:none;">
      <form method="post" action="insert.php">
        <input type="hidden" name="insert_video" value=1>
        <input type="hidden" name="username" value=<?php echo $username;?>>
        <input type="hidden" name="password" value=<?php echo $password;?>>
        <input type="text" name="titleAdd" placeholder="title" style="width=300;"><br>
        <input type="text" name="authorAdd" placeholder="author" style="width=300;"><br>
        <input type="text" name="channelAdd" placeholder="channel" style="width=300;"><br>
        <input type="text" name="urlAdd" placeholder="url" style="width=300;"><br>
        <input type="submit" name="submit" value="提交">
      </form>
    </div>
    <button id="delete_video">删除</button>
    <div id="delete_video_formContainer" style="display:none;">
      <form method="post" action="delete.php">
        <input type="hidden" name="delete_video" value=1>
        <input type="hidden" name="username" value=<?php echo $username;?>>
        <input type="hidden" name="password" value=<?php echo $password;?>>
        delete from video where <input type="text" name="videoToDel" placeholder="删除条件" style="width=300;"><br>
        <input type="submit" name="submit" value="提交">
      </form>
    </div>
    <script>
    var delete_video = document.getElementById("delete_video");
    var delete_video_formContainer = document.getElementById("delete_video_formContainer");
    var delete_video_show=0;
    delete_video.addEventListener("click", function() {
      if(delete_video_show%2==0){
        delete_video_formContainer.style.display = "block";
        delete_video.innerHTML='隐藏';
      }
      else{
        delete_video_formContainer.style.display='none';
        delete_video.innerHTML='删除';
      }
      delete_video_show++;
    });
    </script>
    <button id="update_video">修改</button>
    <div id="update_video_formContainer" style="display:none;">
      <form method="post" action="update.php">
        <input type="hidden" name="update_video" value=1>
        <input type="hidden" name="username" value=<?php echo $username;?>>
        <input type="hidden" name="password" value=<?php echo $password;?>>
        update video set <input type="text" name="videoToUpdate" placeholder="修改的内容" style="width=300;">
        <br>where <input type="text" name="videoToUpdateCondition" placeholder="true" style="width=300;"><br>
        <input type="submit" name="submit" value="提交">
      </form>
    </div>
    <script>
    var update_video = document.getElementById("update_video");
    var update_video_formContainer = document.getElementById("update_video_formContainer");
    var update_video_show=0;
    update_video.addEventListener("click", function() {
      if(update_video_show%2==0){
        update_video_formContainer.style.display = "block";
        update_video.innerHTML='隐藏';
      }
      else{
        update_video_formContainer.style.display='none';
        update_video.innerHTML='修改';
      }
      update_video_show++;
    });
    </script>
    <p style="color: red;width=500;">
    <?php
      if (isset($_POST['video_insert_error_message'])&&$_POST['video_insert_error_message']!='ok') {
        $video_insert_error_message = $_POST['video_insert_error_message'];
        printf("%s<br>",urldecode($video_insert_error_message));
        if(substr(urldecode($video_insert_error_message),0,21)=='INSERT command denied'){
          printf("账号%s不具有该表的插入权限",$username);
        }
      }
    ?>
    </p>
    <p style="color: red;width=500;">
    <?php
      if (isset($_POST['video_delete_error_message'])&&$_POST['video_delete_error_message']!='ok') {
        $video_delete_error_message = $_POST['video_delete_error_message'];
        printf("%s<br>",urldecode($video_delete_error_message));
        if(substr(urldecode($video_delete_error_message),0,21)=='DELETE command denied'){
          printf("账号%s不具有该表的删除权限",$username);
        }
      }
    ?>
    </p>
    <p style="color: green;width=500;">
    <?php
      if (isset($_POST['video_delete_info_message'])&&$_POST['video_delete_info_message']!='') {
        $video_delete_info_message = $_POST['video_delete_info_message'];
        printf("%s条数据被删除<br>",urldecode($video_delete_info_message));
      }
    ?>
    </p>
    </p>
    <p style="color: red;width=500;">
    <?php
      if (isset($_POST['video_update_error_message'])&&$_POST['video_update_error_message']!='ok') {
        $video_update_error_message = $_POST['video_update_error_message'];
        printf("%s<br>",urldecode($video_update_error_message));
        if(substr(urldecode($video_update_error_message),0,21)=='UPDATE command denied'){
          printf("账号%s不具有该表的修改权限",$username);
        }
      }
    ?>
    </p>
    <p style="color: green;width=500;">
    <?php
      if (isset($_POST['video_update_info_message'])&&$_POST['video_update_info_message']!='') {
        $video_update_info_message = $_POST['video_update_info_message'];
        printf("%s条数据被修改<br>",urldecode($video_update_info_message));
      }
    ?>
    </p>
    <script>
    var add_video = document.getElementById("add_video");
    var add_video_formContainer = document.getElementById("add_video_formContainer");
    var add_video_show=0;
    add_video.addEventListener("click", function() {
      if(add_video_show%2==0){
        add_video_formContainer.style.display = "block";
        add_video.innerHTML='隐藏';
      }
      else{
        add_video_formContainer.style.display='none';
        add_video.innerHTML='添加';
      }
      add_video_show++;
    });
    // var form = document.querySelector('form');
    // form.addEventListener('submit', function(event) {
    //   event.preventDefault();
    //   var formData = new FormData(form);
    //   var xhr = new XMLHttpRequest();
    //   xhr.open('POST', 'insert.php');
    //   xhr.send(formData);
    //   location.reload();
    // });
    </script>
  </td>
  </tr>
  <tr>
  <td id="Table:staff" style="width:500px;vertical-align:top;">
    <?php
    $sql = "select * from staff limit 20";
    $result = $conn->query($sql);
    ?>
    <table border="1" style="background-color:#EEEEEE;float:left;">
      <caption style="color:red">staff表</caption>
      <tbody>
        <tr>
          <th>account</th>
          <th>name</th>
          <!-- <th>isRunner</th> -->
        </tr>
        <?php
            while($row = mysqli_fetch_assoc($result)) {
                printf("<tr> <td>%d</td> <td>%s</td> </tr>",
                $row["account"], $row["name"]);
            }
        ?>
      </tbody>
      <colgroup>
        <col width="300">
        <col width="200">
        <!-- <col width="100"> -->
      </colgroup>
    </table>
    <button id="add_staff">添加</button>
    <div id="add_staff_formContainer" style="display:none;">
      <form method="post" action="insert.php">
        <input type="hidden" name="insert_staff" value=1>
        <input type="hidden" name="username" value=<?php echo $username;?>>
        <input type="hidden" name="password" value=<?php echo $password;?>>
        <input type="text" name="passwdAdd" placeholder="passwd" style="width=300;"><br>
        <input type="radio" name="isDeveloperAdd" value=1>开发者
        <input type="radio" name="isDeveloperAdd" value=0>非开发者<br>
        <input type="radio" name="isRunnerAdd" value=1>运营者
        <input type="radio" name="isRunnerAdd" value=0>非运营者<br>
        <input type="submit" name="submit" value="提交">
      </form>
    </div>
    <button id="delete_staff">删除</button>
    <div id="delete_staff_formContainer" style="display:none;">
      <form method="post" action="delete.php">
        <input type="hidden" name="delete_staff" value=1>
        <input type="hidden" name="username" value=<?php echo $username;?>>
        <input type="hidden" name="password" value=<?php echo $password;?>>
        delete from staff where <input type="text" name="staffToDel" placeholder="删除条件" style="width=300;"><br>
        <input type="submit" name="submit" value="提交">
      </form>
    </div>
    <script>
    var delete_staff = document.getElementById("delete_staff");
    var delete_staff_formContainer = document.getElementById("delete_staff_formContainer");
    var delete_staff_show=0;
    delete_staff.addEventListener("click", function() {
      if(delete_staff_show%2==0){
        delete_staff_formContainer.style.display = "block";
        delete_staff.innerHTML='隐藏';
      }
      else{
        delete_staff_formContainer.style.display='none';
        delete_staff.innerHTML='删除';
      }
      delete_staff_show++;
    });
    </script>
    <button id="update_staff">修改</button>
    <div id="update_staff_formContainer" style="display:none;">
      <form method="post" action="update.php">
        <input type="hidden" name="update_staff" value=1>
        <input type="hidden" name="username" value=<?php echo $username;?>>
        <input type="hidden" name="password" value=<?php echo $password;?>>
        update staff set <input type="text" name="staffToUpdate" placeholder="修改的内容" style="width=300;"><br>
        where<input type="text" name="staffToUpdateCondition" placeholder="true" style="width=300;"><br>
        <input type="submit" name="submit" value="提交">
      </form>
    </div>
    <script>
    var update_staff = document.getElementById("update_staff");
    var update_staff_formContainer = document.getElementById("update_staff_formContainer");
    var update_staff_show=0;
    update_staff.addEventListener("click", function() {
      if(update_staff_show%2==0){
        update_staff_formContainer.style.display = "block";
        update_staff.innerHTML='隐藏';
      }
      else{
        update_staff_formContainer.style.display='none';
        update_staff.innerHTML='修改';
      }
      update_staff_show++;
    });
    </script>
    <p style="color: red;width=500;">
    <?php
      if (isset($_POST['staff_insert_error_message'])&&$_POST['staff_insert_error_message']!='ok') {
        $staff_insert_error_message = $_POST['staff_insert_error_message'];
        printf("%s<br>",urldecode($staff_insert_error_message));
        if(substr(urldecode($staff_insert_error_message),0,21)=='INSERT command denied'){
          printf("账号%s不具有该表的插入权限",$username);
        }
      }
    ?>
    </p>
    <p style="color: red;width=500;">
    <?php
      if (isset($_POST['staff_delete_error_message'])&&$_POST['staff_delete_error_message']!='ok') {
        $staff_delete_error_message = $_POST['staff_delete_error_message'];
        printf("%s<br>",urldecode($staff_delete_error_message));
        if(substr(urldecode($staff_delete_error_message),0,21)=='DELETE command denied'){
          printf("账号%s不具有该表的删除权限",$username);
        }
      }
    ?>
    </p>
    <p style="color: green;width=500;">
    <?php
      if (isset($_POST['staff_delete_info_message'])&&$_POST['staff_delete_info_message']!='') {
        $staff_delete_info_message = $_POST['staff_delete_info_message'];
        printf("%s条数据被删除<br>",urldecode($staff_delete_info_message));
      }
    ?>
    </p>
    <p style="color: red;width=500;">
    <?php
      if (isset($_POST['staff_update_error_message'])&&$_POST['staff_update_error_message']!='ok') {
        $staff_update_error_message = $_POST['staff_update_error_message'];
        printf("%s<br>",urldecode($staff_update_error_message));
        if(substr(urldecode($staff_update_error_message),0,21)=='UPDATE command denied'){
          printf("账号%s不具有该表的修改权限",$username);
        }
      }
    ?>
    </p>
    <p style="color: green;width=500;">
    <?php
      if (isset($_POST['staff_update_info_message'])&&$_POST['staff_update_info_message']!='') {
        $staff_update_info_message = $_POST['staff_update_info_message'];
        printf("%s条数据被修改<br>",urldecode($staff_update_info_message));
      }
    ?>
    </p>
    <script>
    var add_staff = document.getElementById("add_staff");
    var add_staff_formContainer = document.getElementById("add_staff_formContainer");
    var add_staff_show=0;
    add_staff.addEventListener("click", function() {
      if(add_staff_show%2==0){
        add_staff_formContainer.style.display = "block";
        add_staff.innerHTML='隐藏';
      }
      else{
        add_staff_formContainer.style.display='none';
        add_staff.innerHTML='添加';
      }
      add_staff_show++;
    });
    // var form = document.querySelector('form');
    // form.addEventListener('submit', function(event) {
    //   event.preventDefault();
    //   var formData = new FormData(form);
    //   var xhr = new XMLHttpRequest();
    //   xhr.open('POST', 'insert.php');
    //   xhr.send(formData);
    //   location.reload();
    // });
    </script>
  </td>
  <td id="Table:comment" style="width:1100px;vertical-align:top;">
    <?php
    $sql = "select * from comment_fromweb limit 20";
    $result = $conn->query($sql);
    ?>
    <table border="1" style="background-color:#EEEEEE;float:left;">
      <caption style="color:red">comment表</caption>
      <tbody>
        <tr>
          <th>id</th>
          <th>videoID</th>
          <th>author</th>
          <th>time</th>
          <th>repto</th>
          <th>commentText</th>
        </tr>
        <?php
            while($row = mysqli_fetch_assoc($result)) {
                printf("<tr> <td>%d</td> <td>%d</td> <td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td> </tr>",
                $row["id"],$row["videoID"], $row["author"],$row['commentTime'],$row["repto"],$row["commentText"]);
            }
        ?>
      </tbody>
      <colgroup>
        <col width="50">
        <col width="100">
        <col width="200">
        <col width="100">
        <col width="200">
        <col width="450">
      </colgroup>
    </table>
    <button id="add_comment">添加</button>
    <div id="add_comment_formContainer" style="display:none;">
      <form method="post" action="insert.php">
        <input type="hidden" name="insert_comment" value=1>
        <input type="hidden" name="username" value=<?php echo $username;?>>
        <input type="hidden" name="password" value=<?php echo $password;?>>
        <input type="text" name="videoIDAdd" placeholder="videoID" style="width=300;"><br>
        <input type="text" name="authorAdd" placeholder="author" style="width=300;"><br>
        <input type="text" name="reptoAdd" placeholder="repto" style="width=300;"><br>
        <!-- <input type="text" name="repAdd" placeholder="rep" style="width=300;"><br> -->
        <input type="text" name="commentTextAdd" placeholder="commentText" style="width=300;"><br>
        <input type="submit" name="submit" value="提交">
      </form>
    </div>
    <button id="delete_comment">删除</button>
    <div id="delete_comment_formContainer" style="display:none;">
      <form method="post" action="delete.php">
        <input type="hidden" name="delete_comment" value=1>
        <input type="hidden" name="username" value=<?php echo $username;?>>
        <input type="hidden" name="password" value=<?php echo $password;?>>
        delete from comment where <input type="text" name="commentToDel" placeholder="删除条件" style="width=300;"><br>
        <input type="submit" name="submit" value="提交">
      </form>
    </div>
    <script>
    var delete_comment = document.getElementById("delete_comment");
    var delete_comment_formContainer = document.getElementById("delete_comment_formContainer");
    var delete_comment_show=0;
    delete_comment.addEventListener("click", function() {
      if(delete_comment_show%2==0){
        delete_comment_formContainer.style.display = "block";
        delete_comment.innerHTML='隐藏';
      }
      else{
        delete_comment_formContainer.style.display='none';
        delete_comment.innerHTML='删除';
      }
      delete_comment_show++;
    });
    </script>
    <button id="update_comment">修改</button>
    <div id="update_comment_formContainer" style="display:none;">
      <form method="post" action="update.php">
        <input type="hidden" name="update_comment" value=1>
        <input type="hidden" name="username" value=<?php echo $username;?>>
        <input type="hidden" name="password" value=<?php echo $password;?>>
        update comment set <input type="text" name="commentToUpdate" placeholder="修改的内容" style="width=300;"><br>
        where <input type="text" name="commentToUpdateCondition" placeholder="true" style="width=300;"><br>
        <input type="submit" name="submit" value="提交">
      </form>
    </div>
    <script>
    var update_comment = document.getElementById("update_comment");
    var update_comment_formContainer = document.getElementById("update_comment_formContainer");
    var update_comment_show=0;
    update_comment.addEventListener("click", function() {
      if(update_comment_show%2==0){
        update_comment_formContainer.style.display = "block";
        update_comment.innerHTML='隐藏';
      }
      else{
        update_comment_formContainer.style.display='none';
        update_comment.innerHTML='修改';
      }
      update_comment_show++;
    });
    </script>
    <p style="color: red;width=500;">
    <?php
      if (isset($_POST['comment_insert_error_message'])&&$_POST['comment_insert_error_message']!='ok') {
        $comment_insert_error_message = $_POST['comment_insert_error_message'];
        printf("%s<br>",urldecode($comment_insert_error_message));
        if(substr(urldecode($comment_insert_error_message),0,21)=='INSERT command denied'){
          printf("账号%s不具有该表的插入权限",$username);
        }
      }
    ?>
    </p>
    <p style="color: red;width=500;">
    <?php
      if (isset($_POST['comment_delete_error_message'])&&$_POST['comment_delete_error_message']!='ok') {
        $comment_delete_error_message = $_POST['comment_delete_error_message'];
        printf("%s<br>",urldecode($comment_delete_error_message));
        if(substr(urldecode($comment_delete_error_message),0,21)=='DELETE command denied'){
          printf("账号%s不具有该表的删除权限",$username);
        }
      }
    ?>
    </p>
    <p style="color: green;width=500;">
    <?php
      if (isset($_POST['comment_delete_info_message'])&&$_POST['comment_delete_info_message']!='') {
        $comment_delete_info_message = $_POST['comment_delete_info_message'];
        printf("%s条数据被删除<br>",urldecode($comment_delete_info_message));
      }
    ?>
    </p>
    <p style="color: red;width=500;">
    <?php
      if (isset($_POST['comment_update_error_message'])&&$_POST['comment_update_error_message']!='ok') {
        $comment_update_error_message = $_POST['comment_update_error_message'];
        printf("%s<br>",urldecode($comment_update_error_message));
        if(substr(urldecode($comment_update_error_message),0,21)=='UPDATE command denied'){
          printf("账号%s不具有该表的修改权限",$username);
        }
      }
    ?>
    </p>
    <p style="color: green;width=500;">
    <?php
      if (isset($_POST['comment_update_info_message'])&&$_POST['comment_update_info_message']!='') {
        $comment_update_info_message = $_POST['comment_update_info_message'];
        printf("%s条数据被修改<br>",urldecode($comment_update_info_message));
      }
    ?>
    </p>
    <script>
    var add_comment = document.getElementById("add_comment");
    var add_comment_formContainer = document.getElementById("add_comment_formContainer");
    var add_comment_show=0;
    add_comment.addEventListener("click", function() {
      if(add_comment_show%2==0){
        add_comment_formContainer.style.display = "block";
        add_comment.innerHTML='隐藏';
      }
      else{
        add_comment_formContainer.style.display='none';
        add_comment.innerHTML='添加';
      }
      add_comment_show++;
    });
    // var form = document.querySelector('form');
    // form.addEventListener('submit', function(event) {
    //   event.preventDefault();
    //   var formData = new FormData(form);
    //   var xhr = new XMLHttpRequest();
    //   xhr.open('POST', 'insert.php');
    //   xhr.send(formData);
    //   location.reload();
    // });
    </script>
  </td>
  </tr>
</table>
<?php
$conn->close();
?>
</html>
