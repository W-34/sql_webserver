<html style="width=140;height=710px;">
	<head>
		<meta charset="utf-8">
		<title>w34's homework</title>
	</head>
    <body>
        <h3 style="text-align:center">登录账号</h1>
        <!-- <div id="none" style="background-color:#FFD700;height:100px;width:800px;float:left;"> -->
        </div>
        <div id='login' style="width=120;height=640px;float:left;">
            <form action="me.php" method="post" style="text-align:start;" width="300" height="200">
            username: 
            <input type="text" name="username" style="height:27px;width:120px;"><br>
            <!-- <div style="height:30px;width:3px;float:left;"></div> -->
            password: 
            <input type="password" name="password" style='height:27px;width:120px;'><br>
            <a href="signup.html" style="color:blue;">注册</a><br>
            <a href="resetpasswd.html" style="color:blue;">忘记密码？</a><br>

            <!-- <div style="height:30px;width:130px;float:left;"></div> -->
            <input type="submit" value="登录" style="align:center">
            </form>
        </div>
        <!-- <div id="none" style="background-color:#FFD700;height:100px;width:670px;float:left;"></div> -->
        <div style="">
            <?php
                if (isset($_GET['error_message'])) {
                    $error_message = $_GET['error_message'];
                    echo '<p style="color: red;text-align:center;">' . $error_message . '</p>';
                }
                ?>
        </div>
    </body>
</html>