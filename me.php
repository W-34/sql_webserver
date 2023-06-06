<html style="width:134;height:690px;">
    <head>
        <style>
            * {
                box-sizing: border-box;
              }

        </style>
    </head>
<?php
    function generateRandomString($length = 32) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[mt_rand(0, $charactersLength - 1)];
    }
    return $randomString;
}?>
    <body>
        <?php
            $servername='8.130.102.240';
            $username = $_POST["username"];
            $password = $_POST["password"];
            $sql_username = getenv('ADMIN_USERNAME');
            $sql_password = getenv('ADMIN_PASSWORD');
            $dbname='homework';
            $conn = new mysqli($servername, $username, $password, $dbname);
            // mysqli_set_charset($conn, "utf8mb4");
            if ($conn->connect_error) {
                $login=0;
                // $error_message = $conn->connect_error;
            }
            else{
                $login=1;
            }
        ?>
        <div id='myname' style="width:130px;height:680px">
            <?php
                $conn2 = new mysqli($servername, $sql_username, $sql_password, $dbname);
                if($login==1){
                    $myname='w34';
                    echo '<h3>我的个人页</h3><hr>';
                    $query='select username,name from user where username=\''.$username.'\'';
                    $result= $conn2->query($query);
                    if ($conn2->error){
                        echo $conn2->error;
                    }
                    while ($row = mysqli_fetch_assoc($result)) {
                        $username0=$row['username'];
                        $randomStr=generateRandomString();
                        $query2='insert into token(username,name,data) value(\''.$username0.'\',\''.$row['name'].'\',\''.$randomStr.'\')';
                        $conn2->query($query2);
                        printf("<p style=\"width:100px\">昵称：%s</p>",$row['name']);
                        // printf('<p>更多信息..</p>');
                        break;
                    }
                    // echo '';
                    // printf("<p>昵称：%s</p>",$result);
                    // printf('<p>更多信息..</p>');
                }
                else{
                    echo '<p>用户未登录</p>';
                }
            ?>
            <div style="">
			<?php
				// if ($error_message!=null) {
				// 	// $error_message_user = $_GET['error_message_user'];
				// 	echo '<p style="color: red;text-align:center;">' . $error_message . '</p>';
				// }
				?>
		    </div>
            <hr>
            <div>
                <p class="token" id="token" style="display:none"><?php
                echo $randomStr;
                ?></p>
            </div>
        </div>
        <?php
            $conn->close();
            $conn2->close();
        ?>
    </body>
    <script>
        
    </script>
</html>