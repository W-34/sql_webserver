<html>
<meta charset="utf-8">
<head> 
  <title>w34's MySQL</title> 
</head>
<div id="header" style="background-color:#FFA500;">
<h1 style="margin-bottom:0;">以<?php echo $_POST["username"]; ?>登录到mysql</h1></div>
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
<table cellspacing="100" style="background-color:#FFD700;">
  <tr>
  <td id="Table:user" style="width:500px;vertical-align:top;">
    <?php
    $sql = "select * from user limit 20";
    $result = $conn->query($sql);
    ?>
    <table border="1" style="background-color:#EEEEEE;float:left;">
      <caption style="color:red">user表</caption>
      <tbody>
        <tr>
          <th>id</th>
          <th>username</th>
          <th>name</th>
          <th>isAuthor</th>
        </tr>
        <?php
            while($row = mysqli_fetch_assoc($result)) {
                printf("<tr> <td>%8s   </td> <td>%20s   </td> <td>%s   </td> <td>%b   </td> </tr>", $row["id"],$row["username"], $row["name"], $row["isAuthor"]);
            }
        ?>
      </tbody>
      <colgroup>
        <col width="50">
        <col width="200">
        <col width="200">
        <col width="50">
      </colgroup>
    </table>
    <button id="add_user">添加</button>
    <div id="add_user_formContainer" style="display:none;">
      <form method="post" action="insert.php">
        <input type="hidden" name="insert_user" value=1>
        <input type="hidden" name="username" value=<?php echo $username;?>>
        <input type="hidden" name="password" value=<?php echo $password;?>>
        <input type="text" name="usernameAdd" placeholder="username" style="width=250;"><br>
        <input type="text" name="passwordAdd" placeholder="password" style="width=250;"><br>
        <input type="text" name="nameAdd" placeholder="name" style="width=200;"><br>
        <input type="radio" name="isAuthorAdd" value=1>视频作者
        <input type="radio" name="isAuthorAdd" value=0>普通用户<br>
        <input type="submit" name="submit" value="提交">
      </form>
    </div>
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
    <script>
    var add_user = document.getElementById("add_user");
    var add_user_formContainer = document.getElementById("add_user_formContainer");
    add_user.addEventListener("click", function() {
      add_user_formContainer.style.display = "block";
    });
    var form = document.querySelector('form');
    form.addEventListener('submit', function(event) {
      event.preventDefault(); // 阻止表单默认提交事件
      // 获取表单数据
      var formData = new FormData(form);
      // 发送 AJAX 请求将表单数据提交到服务器端
      var xhr = new XMLHttpRequest();
      xhr.open('POST', 'insert.php');
      xhr.send(formData);
      // 刷新页面
      location.reload();
    });
    </script>
  </td>

  <td id="Table:video" style="width:1100px;vertical-align:top;">
    <?php
    $sql = "select * from video limit 20";
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
          <th>url</th>
          <th>likes</th>
        </tr>
        <?php
            while($row = mysqli_fetch_assoc($result)) {
                printf("<tr> <td>%d</td> <td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td> <td>%d</td></tr>",
                $row["id"],$row["title"], $row["author"], $row["date"],$row["channel"],$row["url"],$row['likes']);
            }
        ?>
      </tbody>
      <colgroup>
        <col width="50">
        <col width="200">
        <col width="200">
        <col width="200">
        <col width="150">
        <col width="200">
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
    <script>
    var add_video = document.getElementById("add_video");
    var add_video_formContainer = document.getElementById("add_video_formContainer");
    add_video.addEventListener("click", function() {
      add_video_formContainer.style.display = "block";
    });
    var form = document.querySelector('form');
    form.addEventListener('submit', function(event) {
      event.preventDefault(); // 阻止表单默认提交事件
      // 获取表单数据
      var formData = new FormData(form);
      // 发送 AJAX 请求将表单数据提交到服务器端
      var xhr = new XMLHttpRequest();
      xhr.open('POST', 'insert.php');
      xhr.send(formData);
      // 刷新页面
      location.reload();
    });
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
          <th>isDeveloper</th>
          <th>isRunner</th>
        </tr>
        <?php
            while($row = mysqli_fetch_assoc($result)) {
                printf("<tr> <td>%d</td> <td>%b</td> <td>%b</td> </tr>",
                $row["account"],$row["isDeveloper"], $row["isRunner"]);
            }
        ?>
      </tbody>
      <colgroup>
        <col width="300">
        <col width="100">
        <col width="100">
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
    <script>
    var add_staff = document.getElementById("add_staff");
    var add_staff_formContainer = document.getElementById("add_staff_formContainer");
    add_staff.addEventListener("click", function() {
      add_staff_formContainer.style.display = "block";
    });
    var form = document.querySelector('form');
    form.addEventListener('submit', function(event) {
      event.preventDefault(); // 阻止表单默认提交事件
      // 获取表单数据
      var formData = new FormData(form);
      // 发送 AJAX 请求将表单数据提交到服务器端
      var xhr = new XMLHttpRequest();
      xhr.open('POST', 'insert.php');
      xhr.send(formData);
      // 刷新页面
      location.reload();
    });
    </script>
  </td>
  <td id="Table:comment" style="width:1100px;vertical-align:top;">
    <?php
    $sql = "select * from comment limit 20";
    $result = $conn->query($sql);
    ?>
    <table border="1" style="background-color:#EEEEEE;float:left;">
      <caption style="color:red">comment表</caption>
      <tbody>
        <tr>
          <th>id</th>
          <th>videoID</th>
          <th>author</th>
          <th>repid</th>
          <th>rep</th>
          <th>commentText</th>
        </tr>
        <?php
            while($row = mysqli_fetch_assoc($result)) {
                printf("<tr> <td>%d</td> <td>%d</td> <td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td> </tr>",
                $row["id"],$row["videoID"], $row["author"], $row["repid"],$row["rep"],$row["commentText"]);
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
        <input type="text" name="repidAdd" placeholder="repid" style="width=300;"><br>
        <input type="text" name="repAdd" placeholder="rep" style="width=300;"><br>
        <input type="text" name="commentTextAdd" placeholder="commentText" style="width=300;"><br>
        <input type="submit" name="submit" value="提交">
      </form>
    </div>
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
    <script>
    var add_comment = document.getElementById("add_comment");
    var add_comment_formContainer = document.getElementById("add_comment_formContainer");
    add_comment.addEventListener("click", function() {
      add_comment_formContainer.style.display = "block";
    });
    var form = document.querySelector('form');
    form.addEventListener('submit', function(event) {
      event.preventDefault(); // 阻止表单默认提交事件
      // 获取表单数据
      var formData = new FormData(form);
      // 发送 AJAX 请求将表单数据提交到服务器端
      var xhr = new XMLHttpRequest();
      xhr.open('POST', 'insert.php');
      xhr.send(formData);
      // 刷新页面
      location.reload();
    });
    </script>
  </td>
  </tr>
</table>
<?php
$conn->close();
?>
</html>
