<html>
<head>
<meta charset="utf-8">
<title>w34's homework</title>
<h1>login mysql</h1>
</head>
<body>
<form action="sql.php" method="post">
username: <input type="text" name="username"><br>
password: <input type="password" name="password"><hr>

<input type="submit" value="提交">
</form>
<?php
	// 检查是否有错误消息传递
	if (isset($_GET['error_message'])) {
		$error_message = $_GET['error_message'];
		echo '<p style="color: red;">' . $error_message . '</p>';
	}
	?>
</body>
</html>
