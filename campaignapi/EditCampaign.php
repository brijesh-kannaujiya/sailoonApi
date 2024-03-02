<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Headers: *");
include('../dbconnection/dbconn.php');
include('../token/Token.php');
include('Function.php');


$server_url = "http";
if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
    $currentUrl .= "s";
}
$server_url .= "://";

if ($_SERVER["SERVER_PORT"] != "80") {
    $server_url .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
} else {
    $server_url .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
}


const KEY = 'winnerthisisaapkey';
$token = apache_request_headers()['Authorization'];
$payload = Token::Verify($token, KEY);
if ($payload == false) {
    echo json_encode(array('status' => 'false', 'message' => 'Session expired'));
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $d_id = base64_decode($_POST["deal_id"]);
        $cp_name  =         $_POST['cp_name'];
        $cp_name_ar  =         $_POST['cp_name_ar'];
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
        $upatedDateAt = date("Y-m-d H:i:s");
        $campaignHelper = new CampainHelper();
        $campaignData = $campaignHelper->GetSingleCampain($d_id);
        if (isset($_FILES["avatar"])) {
            $deal_image_update = $campaignHelper->uploadFile($_FILES["avatar"], 'deal_image/');
            $deal_image_update_url = $deal_image_update['url'];
        } else {
            $deal_image_update_url = $campaignData['image_name'];
        }
        if (isset($_FILES["avatar_product"])) {
            $deal_product_image_update = $campaignHelper->uploadFile($_FILES["avatar_product"], 'deal_image_product/');
            $deal_product_image_update_url = $deal_product_image_update['url'];
        } else {
            $deal_product_image_update_url =   $campaignData['product_image'];
        }
        $sql = "UPDATE campains SET cp_name='$cp_name', cp_name_ar='$cp_name_ar', image_name='$deal_image_update_url', dealprice='$dealprice'
            , shortdiscription='$shortdiscription', longdiscription='$longdiscription', product_name='$cp_product_name',product_image='$deal_product_image_update_url',product_price='$cp_product_price',
              tagtitle='$tagtitle'
            , joindeal_count='$joindeal_count', deal_startdate='$deal_startdate', deal_enddate='$deal_enddate',upatedDateAt='$upatedDateAt'
                WHERE deal_id=$d_id";


        if (mysqli_query($con, $sql)) {
            //echo json_encode(array('status' => 'success', 'message' => 'insert successfully','imageupload'=>$response));
            echo json_encode(array('status' => 'success', 'message' => 'Update successfully', 'name' => $cp_name));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Error in insert'));
        }

        $con->close();
    } else {
        // Invalid request method
        echo json_encode(array('status' => 'error', 'message' => 'Invalid request method'));
    }
}
