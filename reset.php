<html>
    <head>
        <title>w34's mysql</title>
        <h2 style="text-align:center">重置密码</h1>
    </head>
    <body style="background-color:#FFD700;">
    <?php        
        function str_check( $str )     
        {     
            if (!get_magic_quotes_gpc()) // 判断magic_quotes_gpc是否打开     
            {     
                $str = addslashes($str); // 进行过滤     
            }     
            $str = str_replace("_", "\_", $str); // 把 '_'过滤掉     
            $str = str_replace("%", "\%", $str); // 把' % '过滤掉     
            return $str;     
        }     
        function generateRandomString($length = 32) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[mt_rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }
    ?>
    <?php
        $servername = "8.130.102.240";
        $username = getenv('ADMIN_USERNAME');
        $password = getenv('ADMIN_PASSWORD');
        $dbname='resetpassword';
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            echo '<p style=\'color:red;\'>网络错误，请与管理员联系</p>';
            die();
        }
        else{
            $query='select username,token from tokens where token=\''.str_check($_GET['token']).'\' and username=\''.str_check($_GET['username']).'\'';
            $result=$conn->query($query);
            if($conn->error){
                echo '<p>token错误，5秒后跳转到登录页面</p>';
                header('refresh:5;url=http://8.130.102.240/index.php');
            }
            else{
                $row = mysqli_fetch_assoc($result);
                if($row==null){
                    echo '<p>token错误，5秒后跳转到登录页面</p>';
                    header('refresh:5;url=http://8.130.102.240/index.php');
                }
            }
        }
    ?>
        <div id="none" style="background-color:#FFD700;height:450px;width:600px;float:left;"></div>
        <div id='signup' style="width:400;height:100px;float:left;">
            <form action="updatepasswd.php" method="post" style="text-align:end;" width="300" height="200">
            新密码: <input id="password" type="text" name="password">
            <p id="passwordFormatError" style="display:none;color:red">密码格式错误，只能包含大小写字母、数字和这些特殊字符：!@#$%^&*</p>
            <p id="passwordLengthError" style="display:none;color:red">密码长度为6到20个字符</p><br>
            确认密码: <input id="passwordDup" type="text" name="passwordDup">
            <p id="passwordDupError" style="display:none;color:red">密码不一致</p><br>
            <!-- <div style="height:30px;width:3px;float:left;"></div> -->
            <div style="height:30px;width:100px;float:left;"></div>
            </form>
            <div id="none" style="background-color:#FFD700;height:30px;width:180px;float:left;"></div>
            <button id="submitForm">提交</button>
        </div>
        <div id="none" style="background-color:#FFD700;height:150px;width:800px;float:left;"></div>
        <script>
            var form = document.querySelector('form');
            // var username = document.getElementById('username');
            // var usernameRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+.[a-zA-Z]+$/;
            // var usernameErrorMessage=document.getElementById('usernameFormatError');
            var password=document.getElementById('password');
            var passwordRegex = /^[a-zA-Z0-9!@#$%^&*]{6,}$/;
            var passwordErrorMessage=document.getElementById('passwordFormatError');
            var passwordLengthErrorMessage=document.getElementById('passwordLengthError');
            var passwordDup=document.getElementById('passwordDup');
            var passwordDupErrorMessage=document.getElementById('passwordDupError');
            var usernameOK=false,passwordOK=false,passwordDupOK=false;
            var buttonSubmit=document.getElementById("submitForm");
            buttonSubmit.addEventListener("click",function(event){
                // if (usernameRegex.test(username.value)) {
                //     usernameOK=true;
                // } else {
                //     usernameErrorMessage.style.display='block';
                //     username.value="";
                // }
                if(password.value.length<6||password.value.length>20){
                    passwordLengthErrorMessage.style.display='block';
                    password.value="";
                    passwordDup.value="";
                }
                else if (!passwordRegex.test(password.value)) {
                    passwordErrorMessage.style.display='block';
                    password.value="";
                    passwordDup.value="";
                } else {
                    passwordOK=true;
                }
                if (password.value==passwordDup.value) {
                    passwordDupOK=true;
                } else {
                    passwordDupErrorMessage.style.display='block';
                    //password.value="";
                    passwordDup.value="";
                }
                if(passwordOK&&passwordDupOK){
                    form.submit();
                }
            });
        </script>
    </body>
</html>