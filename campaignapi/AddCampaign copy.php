<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Headers: *");
include('../dbconnection/dbconn.php');
//include('../token/Token.php');

//const KEY = 'winnerthisisaapkey';
//$token = apache_request_headers()['Authorization'];
//$finalResult = array();
//$queryresult = array();
//$payload = Token::Verify($token, KEY);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  =         $_POST['cp_name'];
    $dealprice  =  $_POST['cp_price'];
    $shortdiscription  =  $_POST['cp_shortdiscription'];
    $longdiscription  =     $_POST['cp_longdiscription'];
    $tagtitle  =    $_POST['cp_tagtitle'];
    $joindeal_count  =      $_POST['cp_joindeal_count'];
    $deal_startdate  =      $_POST['cp_startdate'];
    $deal_enddate  =      $_POST['cp_enddate'];
    $status  =      $_POST['cp_status'];
    echo json_encode(array('status' => 'success', 'message' => $name));
    // Check if an image file is uploaded
    // if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    //     $image_path = 'uploads/' . basename($_FILES['image']['name']);
    //     move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
    // } else {
    //     $image_path = null;
    // }

    // Insert user data into the database
    $sql = "INSERT INTO campains (name, image, dealprice,shortdiscription,longdiscription,tagtitle,joindeal_count,deal_startdate,deal_enddate,status) VALUES (?, ?, ?,?,?,?,?,?,?,?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param($name, 'iiiiii', $dealprice, $shortdiscription, $longdiscription, $tagtitle, $joindeal_count, $deal_startdate, $deal_enddate, $status);

    if ($stmt->execute()) {
        // User insertion successful
        echo json_encode(array('status' => 'success', 'message' => 'insert successfully'));
    } else {
        // User insertion failed
        echo json_encode(array('status' => 'error', 'message' => 'Error in insert'));
    }

    // Close statement and connection
    $stmt->close();
    $con->close();
} else {
    // Invalid request method
    echo json_encode(array('status' => 'error', 'message' => 'Invalid request method'));
}
