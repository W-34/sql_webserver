<?php        
    function str_check( $str )     
    {     
        if (!get_magic_quotes_gpc())    
        {     
            $str = addslashes($str);     
        }     
        $str = str_replace("_", "\_", $str);   
        $str = str_replace("%", "\%", $str);    
        return $str;     
    }     
    ?>
<html style="width:300px;height:900px">
    <?php
        // $username = $_POST["username"];
        // $password = $_POST["password"];
        $sql_username = getenv('ADMIN_USERNAME');
        $sql_password = getenv('ADMIN_PASSWORD');
        $dbname='homework';
        $conn = new mysqli($servername, $sql_username, $sql_password, $dbname);
        $videoID=str_check($_GET['videoID']);
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
              .buttonClose{
                position: fixed;
                top: 0;
                right: 0px;
                width: 50px;
                height: 50px;
              }
        </style>
    </head>
    <script>
        document.getElementById("buttonClose").addEventListener("click", function() {
            window.close();
        });
    </script>
    <body>
        <!-- <button class="buttonClose" id="buttonClose">关闭页面</button> -->
        <div id='comment'>
            <?php
            $query='select * from comment where videoID='.$videoID;
            $result=$conn->query($query);
            while ($row = mysqli_fetch_assoc($result)) {
                printf("<hr><p>");
                // foreach ($column_names as $column_name) {
                //   printf("<td>%s</td>",$row[$column_name]);
                // }
                printf("%s at %s ",$row['author'],$row['commentTime']);
                if($row['repto']!=null){
                    printf("回复 %s",$row['repto']);
                }
                printf("\n%s\n",$row['commentText']);
                printf("</p>");
            }
            ?>
        </div>
    </body>
    <?php
        $conn->close();
    ?>
    <script>
        
    </script>
</html>