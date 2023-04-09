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
    <button id="showFormButton">添加</button>
    <div id="formContainer" style="display:none;">
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
    <p style="color: red;">
    <?php
      if (isset($_POST['user_insert_error_message'])&&$_POST['user_insert_error_message']!='ok') {
        $user_insert_error_message = $_POST['user_insert_error_message'];
        printf("%s",$user_insert_error_message);
      }
    ?>
    </p>
    <script>
    var showFormButton = document.getElementById("showFormButton");
    var formContainer = document.getElementById("formContainer");
    var form = document.getElementById("myForm");
    var resultDiv = document.getElementById("result");
    showFormButton.addEventListener("click", function() {
      formContainer.style.display = "block";
    });
    监听表单提交事件
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
    $sql = "select * from video limit 10";
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
  </td>
  </tr>
  <tr>
  <td id="Table:staff" style="width:300px;vertical-align:top;">
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
        <col width="100">
        <col width="50">
        <col width="50">
      </colgroup>
    </table>
  </td>
  <td id="Table:comment" style="width:1000px;vertical-align:top;">
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
        <col width="350">
      </colgroup>
    </table>
  </td>
  </tr>
</table>
<?php
$conn->close();
// 清除Session数据
//unset($_SESSION['form_data']);
?>
</html>
