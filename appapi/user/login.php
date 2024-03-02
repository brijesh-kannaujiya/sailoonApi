<?php
include('../../dbconnection/dbconn.php');
include('../user/otp.php');
include('../../token/Token.php');

const KEY = 'winnerthisisaapkey';
$token = apache_request_headers()['Authorization'];
$payload = Token::Verify($token, KEY);


// decoding the received JSON and store into $obj variable.

$finalResult = array();
$queryresult = array();
if ($payload == false) {
	$queryresult['status'] = 'fail';
	$queryresult['error'] = 'Invailid authorization token';
} else {
	$json = file_get_contents('php://input');
	$obj = json_decode($json, true);
	$user_mobile  = $obj['mobile'];
	$device_id  =   $obj['device_id'];

	$n = 4;
	$otp = generateNumericOTP($n);

	$query = "SELECT otpVerified,device_id FROM users WHERE mobile='$user_mobile'";
	$result = mysqli_query($con, $query);
	$resultRow = mysqli_fetch_assoc($result);

	$query2 = "SELECT mobile FROM users WHERE mobile='$user_mobile'";
	$result2 = mysqli_query($con, $query2);
	$resultRow2 = mysqli_fetch_assoc($result2);
	//print_r($resultRow['otpVerified']);die;
	if ($resultRow2['mobile'] != null) {
		if ($resultRow['otpVerified'] == "yes" && $resultRow['device_id'] == $device_id) {

			if ($query) {
				$queryresult['status'] = 'success';
				$queryresult['msg'] = 'Verified user';
				$query = "SELECT * FROM users WHERE mobile='$user_mobile'";
				$resultopstatus = mysqli_query($con, $query);
				$resultRowstatus = mysqli_fetch_assoc($resultopstatus);
				$queryresult['otpstatus'][] = $resultRowstatus;
			} else {
				$queryresult['status'] = 'fail';
				$queryresult['error'] = 'User not exist';
			}
		} else {
			$query_up = "UPDATE `users` SET `otpval` = '$otp' WHERE mobile='$user_mobile'";
			mysqli_query($con, $query_up);
			$query = "SELECT * FROM users WHERE mobile='$user_mobile'";
			$resultopstatus = mysqli_query($con, $query);
			$resultRowstatus = mysqli_fetch_assoc($resultopstatus);
			$queryresult['otpstatus'][] = $resultRowstatus;
			$queryresult['status'] = 'fail';
			$queryresult['msg'] = 'User not verified';
			//$queryresult[userdata]=$resultRowstatus;
		}
	} else {
		$queryresult['status'] = 'fail';
		$queryresult['msg'] = 'User not exist';
	}
}
$finalResult['data'] = $queryresult;
echo json_encode($finalResult['data']);

$con->close();
