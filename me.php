<html style="width:140px;height:710px">
    <?php
        $servername='8.130.102.240';
        $username = $_POST["username"];
        $password = $_POST["password"];
        $sql_username = getenv('ADMIN_USERNAME');
        $sql_password = getenv('ADMIN_PASSWORD');
        $dbname='homework';
        $conn = new mysqli($servername, $username, $password, $dbname);
        $conn2 = new mysqli($servername, $sql_username, $sql_password, $dbname);
        mysqli_set_charset($conn, "utf8mb4");
        if ($conn->connect_error||$conn2->connect_error) {
            $login=0;
        }
        else{
            $login=1;
        }
    ?>
    <head>
        <style>
            * {
                box-sizing: border-box;
              }

        </style>
    </head>
    <body>
        <div id='myname'>
            <p><?php
                // $myname='用户未登录';
                if($login==1){
                    $myname='w34';
                    echo '<h2>这是我!</h2><hr>';
                    // $query='call queryUser(?,?)';
                    // $stmt = $conn2->prepare($query);
                    // $result='xxx';
                    // $stmt->bind_param('ss',$username,$result);
                    $query='select name from user where username=\''.$username.'\'';
                    $result= $conn2->query($query);
                    if ($conn2->error){
                        echo $conn2->error;
                    }
                    // $stmt->execute();
                    // $stmt->store_result();
                    while ($row = mysqli_fetch_assoc($result)) {
                        printf("<p>昵称：%s</p>",$row['name']);
                        printf('<p>更多信息..</p>');
                        break;
                    }
                    // echo '';
                    // printf("<p>昵称：%s</p>",$result);
                    // printf('<p>更多信息..</p>');
                }
                else{
                    echo '用户未登录';
                }
                // echo $myname;
            ?></p><hr>
            <div>

            </div>
        </div>
    </body>
    <script>
        
    </script>
</html>