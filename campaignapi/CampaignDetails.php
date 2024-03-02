<?php

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Headers: *");


include('../dbconnection/dbconn.php');
include('../token/Token.php');

const KEY = 'winnerthisisaapkey';
$token = apache_request_headers()['Authorization'];
$finalResult = array();
$queryresult = array();
$payload = Token::Verify($token, KEY);
$d_id = base64_decode($_GET["deal_id"]);
if ($payload == false) {
	$queryresult["status"] = "false";
	$queryresult["message"] = "Session expired";
	$queryresult["headerss"] = $payload;
} else {
	$query = "SELECT * FROM campains where deal_id=$d_id";
	if ($result = mysqli_query($con, $query)) {
		$rowcount = mysqli_num_rows($result);
		if ($rowcount > 0) {
			while ($resultRow = mysqli_fetch_assoc($result)) {
				$queryresult['result'] = $resultRow;
				$queryresult['status'] = 'success';
			}
		} else {
			$queryresult['status'] = 'fail';
			$queryresult['error'] = 'No record found.';
		}
		mysqli_free_result($result);
	}
}


$finalResult['data'] = $queryresult;
echo json_encode($finalResult['data']);

exit;
