<html>
<head>
<meta charset="utf-8">
<title>w34's homework</title>
<h1 style="text-align:center">登录到mysql服务器</h1>
</head>
<body style="background-color:#FFD700;">
<form action="sql.php" method="post" style="text-align:center" width="300" height="200">
username: <input type="text" name="username" style="align:center"><br>
password: <input type="password" name="password"><br>

<input type="submit" value="登录" style="align:center">
</form>
<?php
	// 检查是否有错误消息传递
	if (isset($_GET['error_message'])) {
		$error_message = $_GET['error_message'];
		echo '<p style="color: red;text-align:center;">' . $error_message . '</p>';
	}
	?>
<div id="footer" style="background-color:#FFA500;clear:both;text-align:center;">
版权所有 © w34</div>
</body>
</html>
