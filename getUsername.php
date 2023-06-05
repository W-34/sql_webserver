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
$token=str_check($_GET['token']);
$query='select username from token where data=\''.$token.'\'';
if ($conn->connect_error) {
  die("连接失败: " . $conn->connect_error);
}
$result = $conn->query($query);

// 将查询结果转换为关联数组，并作为JSON格式返回
$response = new stdClass();

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    foreach ($row as $key => $value) {
      $response->$key = $value;
    }
    break;
  }
}

echo json_encode($response);
$conn->close();
?>
