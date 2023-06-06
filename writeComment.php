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
$servername = "8.130.102.240";
$username = getenv('ADMIN_USERNAME');;
$password = getenv('ADMIN_PASSWORD');
$dbname = "homework";
$conn = new mysqli($servername, $username, $password, $dbname);
$token=str_check($_POST['token']);
$videoID=str_check($_POST['videoID']);
$commentText=$_POST['commentText'];

$query='select name from token where data=\''.$token.'\'';
// echo $query;
$result = $conn->query($query);
while ($row = $result->fetch_assoc()) {
    $author=$row['name'];
    break;
}
// echo $author;
// echo $conn->error;
$query2='insert into comment (videoID,author,commentTime,commentText)values('.$videoID.',\''.$author.'\',now(),\''.$commentText.'\')';
// echo $query2;
if ($conn->connect_error) {
  die("连接失败: " . $conn->connect_error);
}
$conn->query($query2);
//echo $conn->error;
$conn->close();
?>
