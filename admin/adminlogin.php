<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Headers: *");
include('../dbconnection/dbconn.php');
include('../token/Token.php');

const KEY = 'winnerthisisaapkey';
$token = apache_request_headers()['Authorization'];
//$token="eyJhbGdvIjoiSFMyNTYiLCJ0eXBlIjoiSldUIiwiZXhwaXJlIjoxNzA3MzE4MzMzfQ==.eyJpZCI6ImRlbW9pZCIsInRpbWUiOjE3MDczMTgwMzN9.OTU5MTdjMzk1NjA3Y2I2ZmMzNGU3NWIzOWY1Y2E4YjJhOGJhNGFjZjQyMDcxY2VjOWQwNWEyYjg5NDIwMGZkNw==";
$payload = Token::Verify($token, KEY);
if($payload==false){
  $response["status"] = "false";
  $response["message"] = "Session expired";
  $response["headerss"]=$token;
}else{
    $json = file_get_contents('php://input');
     // Converts it into a PHP object
    $data = json_decode($json,true);
if (isset($data['username']) && $data['username']!="" && isset($data['password']) && $data['password']!="") {
	$query = "SELECT * FROM `tbl_admin`";
	$result = mysqli_query($con,$query);
	$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
  if($row['admin_username']==$data['username'] && $row['admin_password']==$data['password']){
    $response["status"] = "true";
    $response["message"] = "Admin login successful";
    $response["Admin"] = $row;
    $response['jwt']=$payload;
  }else{
    $response["status"] = "false";
    //$response["post"]=$data['username'];
    $response["message"] = "User name password invailid !";
  }

} else {
	$response["status"] = "false";
	//$response["post"]=$data['username'];
	$response["message"] = "User name password can not emapty !";
}
}
echo json_encode($response); 
exit;
?>