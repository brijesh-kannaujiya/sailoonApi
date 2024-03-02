<?php
include('../../dbconnection/dbconn.php');
include('../user/otp.php');
include('../../token/Token.php');
$json = file_get_contents('php://input');
const KEY = 'winnerthisisaapkey';
$token = apache_request_headers()['Authorization'];
$payload = Token::Verify($token, KEY);
// decoding the received JSON and store into $obj variable.
$obj = json_decode($json, true);
$finalResult = array();
$queryresult = array();
if ($payload == false) {
	$queryresult['status'] = 'fail';
	$queryresult['error'] = 'Invailid authorization token';
} else {
	$fName  =        $obj['fName'];
	$lastname  =     $obj['lastname'];
	$mobilenumber  = $obj['mobilenumber'];
	$emailId  =      $obj['emailId'];
	$password  =     $obj['password'];
	$device_id  =    $obj['device_id'];
	$push_id  =      $obj['push_id'];
	$iemi_no  =      $obj['iemi_no'];
	$n = 4;
	echo $firstnam;

	$otp = generateNumericOTP($n);

	if ($con->connect_error) {
		die("Connection failed: " . $con->connect_error);
	}
	//echo $firstnam;
	$query = "INSERT INTO `users`(`fName`, `lName`, `emailId`, `password`, `otpVerified`, `otpval`, `imei`, `push_id`, `device_id`, `mobile`, `dob`, `college_name`, `address`, `city`, `country`) VALUES ('$fName', '$lastname', '$emailId', MD5('$password'),'no','$otp', '$iemi_no', '$push_id','$device_id','$mobilenumber', '3453534', 'sdfafasf', 'sdvsf', 'sdfsf', 'sdfsfs');";
	$result = mysqli_query($con, $query);
	if ($query) {
		$querydata = "SELECT * FROM users order by id desc";
		$querydataresult = mysqli_query($con, $querydata);
		$resultRow =     mysqli_fetch_array($querydataresult);
		$queryresult['status'] = 'success';
		$queryresult['otp'] = $otp;
		$queryresult['msg'] = 'register successfully';
		$queryresult['userdata'] = $resultRow;
	} else {
		$queryresult['status'] = 'fail';
		$queryresult['error'] = 'No record found.';
	}
}

$finalResult['data'] = $queryresult;
echo json_encode($finalResult['data']);

$con->close();
