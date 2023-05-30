<html style="width:130px;height:700px">
    <?php
        $username = $_POST["username"];
        $password = $_POST["password"];
        $dbname='homework';
        $conn = new mysqli($servername, $username, $password, $dbname);
        mysqli_set_charset($conn, "utf8mb4");
        if ($conn->connect_error) {
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
                $myname='用户未登录';
                if($login==1){
                    $myname='w34';
                }
                echo $myname;
            ?></p><hr>
            <div>

            </div>
        </div>
    </body>
    <script>
        
    </script>
</html>