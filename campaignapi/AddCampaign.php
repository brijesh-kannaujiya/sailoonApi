<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Headers: *");
include('../dbconnection/dbconn.php');
include('../token/Token.php');
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
include('Function.php');
$campaignHelper = new CampainHelper();
const KEY = 'winnerthisisaapkey';
$token = apache_request_headers()['Authorization'];
$payload = Token::Verify($token, KEY);
if ($payload == false) {
    echo json_encode(array('status' => 'false', 'message' => 'Session expired'));
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $cp_name  =         $_POST['cp_name'];
        $cp_name_ar  =         $_POST['campainname_ar'];
        $dealprice  =  $_POST['cp_price'];
        $shortdiscription  =  $_POST['cp_shortdiscription'];
        $longdiscription  =     $_POST['cp_longdiscription'];
        $cp_product_name  =     $_POST['cp_product_name'];
        $cp_product_price  =     $_POST['cp_product_price'];
        $tagtitle  =    $_POST['cp_tagtitle'];
        $joindeal_count  =      $_POST['cp_joindeal_count'];
        $deal_startdate  =      $_POST['cp_startdate'];
        $deal_enddate  =      $_POST['cp_enddate'];
        $cp_status  =      $_POST['cp_status'];


        if (isset($_FILES["avatar"])) {
            $deal_image_update = $campaignHelper->uploadFile($_FILES["avatar"], 'deal_image/');
            $deal_image_update_url = $deal_image_update['url'];
        } else {
            $deal_image_update_url = null;
        }
        if (isset($_FILES["avatar_product"])) {
            $deal_product_image_update = $campaignHelper->uploadFile($_FILES["avatar_product"], 'deal_image_product/');
            $deal_product_image_update_url = $deal_product_image_update['url'];
        } else {
            $deal_product_image_update_url =   null;
        }


        $sql = "INSERT INTO createcampains (cp_name,cp_name_ar ,image_name, dealprice,shortdiscription,longdiscription,product_name,product_image,product_price,tagtitle,joindeal_count,deal_startdate,deal_enddate,cp_status)
 VALUES ('$cp_name','$cp_name_ar','$deal_image_update_url','$dealprice', '$shortdiscription', '$longdiscription','$cp_product_name','$deal_product_image_update_url','$cp_product_price','$tagtitle','$joindeal_count','$deal_startdate','$deal_enddate','$cp_status')";

        if (mysqli_query($con, $sql)) {
            //echo json_encode(array('status' => 'success', 'message' => 'insert successfully','imageupload'=>$response));
            echo json_encode(array('status' => 'success', 'message' => 'insert successfully', 'name' => $cp_name));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Error in insert'));
        }

        $con->close();
    } else {
        // Invalid request method
        echo json_encode(array('status' => 'error', 'message' => 'Invalid request method'));
    }
}
