<html>
	<head>
		<meta charset="utf-8">
		<title>w34's homework</title>
	</head>
	<body style="background-color:#FFD700;">
	<h1 style="text-align:center">登录到用户界面</h1>
	<div id="none" style="background-color:#FFD700;height:100px;width:800px;float:left;">
	</div>
	<div id='user_login' style="background-color:green;width=400;height=100px;float:left;">
		<form action="mainpage.html" method="post" style="text-align:start;" width="300" height="200">
		username: <input type="text" name="username" style="align:center"><a href="signup.html" style="color:blue;">注册</a><br>
		<div style="height:30px;width:3px;float:left;"></div>
		password: <input type="password" name="password"><a href="resetpasswd.html" style="color:blue;">忘记密码？</a><br>

		<div style="height:30px;width:130px;float:left;"></div>
		<input type="submit" value="登录" style="align:center">
		</form>
		<div style="">
			<?php
				if (isset($_GET['error_message_user'])) {
					$error_message_user = $_GET['error_message_user'];
					echo '<p style="color: red;text-align:center;">' . $error_message_user . '</p>';
				}
				?>
		</div>
	</div>
	<div id="none" style="background-color:#FFD700;height:100px;width:700px;float:left;"></div>
	<hr>
	<h1 style="text-align:center">登录到数据表控制台</h1>
	<div id="none" style="background-color:#FFD700;height:100px;width:800px;float:left;">
	</div>
	<div id='login' style="width=400;height=100px;float:left;">
		<form action="sql.php" method="post" style="text-align:start;" width="300" height="200">
		username: <input type="text" name="username" style="align:center"><a href="signup.html" style="color:blue;">注册</a><br>
		<div style="height:30px;width:3px;float:left;"></div>
		password: <input type="password" name="password"><a href="resetpasswd.html" style="color:blue;">忘记密码？</a><br>

		<div style="height:30px;width:130px;float:left;"></div>
		<input type="submit" value="登录" style="align:center">
		</form>
	</div>
	<div id="none" style="background-color:#FFD700;height:100px;width:670px;float:left;"></div>
	<div style="">
		<?php
			if (isset($_GET['error_message'])) {
				$error_message = $_GET['error_message'];
				echo '<p style="color: red;text-align:center;">' . $error_message . '</p>';
			}
			?>
	</div>
	<div id="footer" style="background-color:#FFA500;clear:both;text-align:center;">
	版权所有 © w34</div>
	</body>
</html>
