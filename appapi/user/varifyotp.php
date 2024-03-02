<?php
include('../../dbconnection/dbconn.php');
//include('../user/otp.php');
include('../../token/Token.php');

const KEY = 'winnerthisisaapkey';
$token = apache_request_headers()['Authorization'];
$payload = Token::Verify($token, KEY);
$json = file_get_contents('php://input');

if ($payload == false) {
	$queryresult['status'] = 'fail';
	$queryresult['error'] = 'Invailid authorization token';
} else {
	$obj = json_decode($json, true);
	$finalResult = array();
	$queryresult = array();
	$otp  =     $obj['otp'];
	$user_id = base64_decode($obj["id"]);
	if ($con->connect_error) {
		die("Connection failed: " . $con->connect_error);
	}
	$query = "SELECT otpval FROM users WHERE id='$user_id'";
	$result = mysqli_query($con, $query);
	$resultRow = mysqli_fetch_assoc($result);
	//echo $resultRow['otpval'];die;
	if ($resultRow['otpval'] == $otp) {
		if ($query) {
			$queryresult['status'] = 'success';
			$queryresult['msg'] = 'Otp verification successfully';
			$query = "UPDATE `users` SET `otpVerified` = 'yes' WHERE id = '$user_id'";
			mysqli_query($con, $query);
			$query = "SELECT * FROM users WHERE id='$user_id'";
			$resultopstatus = mysqli_query($con, $query);
			$resultRowstatus = mysqli_fetch_assoc($resultopstatus);
			$queryresult['otpstatus'][] = $resultRowstatus;
		} else {
			$queryresult['status'] = 'fail';
			$queryresult['error'] = 'No record found.';
		}
	} else {
		$queryresult['status'] = 'fail';
		$queryresult['error'] = 'Worng otp';
	}
}
$finalResult['data'] = $queryresult;
echo json_encode($finalResult['data']);

$con->close();
