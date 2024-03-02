<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Headers: *");
include('../dbconnection/dbconn.php');
include('../token/Token.php');

const KEY = 'winnerthisisaapkey';
$token = apache_request_headers()['Authorization'];
$payload = Token::Verify($token, KEY);
if ($payload == false) {
    echo json_encode(array('status' => 'false', 'message' => 'Session expired'));
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $d_id = base64_decode($_GET["deal_id"]);
        $deactive = '2';
        $sql = "UPDATE campains SET cp_status='$deactive' WHERE deal_id=$d_id";
        if (mysqli_query($con, $sql)) {
            //echo json_encode(array('status' => 'success', 'message' => 'insert successfully','imageupload'=>$response));
            echo json_encode(array('status' => 'success', 'message' => 'Deactive successfully'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Error in insert'));
        }

        $con->close();
    } else {
        // Invalid request method
        echo json_encode(array('status' => 'error', 'message' => 'Invalid request method'));
    }
}
