<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Headers: *");
include('../dbconnection/dbconn.php');
// include('../token/Token.php');
include('Function.php');
include('../Helper.php');

TokenVerify();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cp_name = isset($_POST['cp_name']) ? $_POST['cp_name'] : null;
    $cp_name_ar = isset($_POST['campainname_ar']) ? $_POST['campainname_ar'] : null;
    $dealprice = isset($_POST['cp_price']) ? $_POST['cp_price'] : null;
    $shortdiscription = isset($_POST['cp_shortdiscription']) ? $_POST['cp_shortdiscription'] : null;
    $longdiscription = isset($_POST['cp_longdiscription']) ? $_POST['cp_longdiscription'] : null;
    $cp_product_name = isset($_POST['cp_product_name']) ? $_POST['cp_product_name'] : null;
    $cp_product_price = isset($_POST['cp_product_price']) ? $_POST['cp_product_price'] : null;
    $tagtitle = isset($_POST['cp_tagtitle']) ? $_POST['cp_tagtitle'] : null;
    $joindeal_count = isset($_POST['cp_joindeal_count']) ? $_POST['cp_joindeal_count'] : null;
    $deal_startdate = isset($_POST['cp_startdate']) ? $_POST['cp_startdate'] : null;
    $deal_enddate = isset($_POST['cp_enddate']) ? $_POST['cp_enddate'] : null;
    $cp_status = isset($_POST['cp_status']) ? $_POST['cp_status'] : null;
    $shortdiscription_ar = isset($_POST['shortdiscription_ar']) ? $_POST['shortdiscription_ar'] : null;
    $longdiscription_ar = isset($_POST['longdiscription_ar']) ? $_POST['longdiscription_ar'] : null;
    $cp_product_name_ar = isset($_POST['cp_product_name_ar']) ? $_POST['cp_product_name_ar'] : null;
    $product_image = isset($_FILES["avatar_product"]) ? $_FILES["avatar_product"] : null;
    $deal_image = isset($_FILES["avatar"]) ? $_FILES["avatar"] : null;
    // $cp_product_price = isset($_POST['cp_product_price']) ? $_POST['cp_product_price'] : null;

    $result = createCategory($cp_name, $cp_name_ar, $dealprice, $shortdiscription, $longdiscription, $shortdiscription_ar, $longdiscription_ar, $cp_product_name, $cp_product_name_ar, $tagtitle, $joindeal_count, $deal_startdate, $deal_enddate, $cp_status, $product_image, $deal_image, $cp_product_price);

    header('Content-Type: application/json');
    echo json_encode($result);
    exit;

    // if (isset($_FILES["avatar"])) {
    //     $deal_image_update = $campaignHelper->uploadFile($_FILES["avatar"], 'deal_image/');
    //     $deal_image_update_url = $deal_image_update['url'];
    // } else {
    //     $deal_image_update_url = null;
    // }
    // if (isset($_FILES["avatar_product"])) {
    //     $deal_product_image_update = $campaignHelper->uploadFile($_FILES["avatar_product"], 'deal_image_product/');
    //     $deal_product_image_update_url = $deal_product_image_update['url'];
    // } else {
    //     $deal_product_image_update_url =   null;
    // }
    // $sql = "INSERT INTO campains (cp_name,cp_name_ar ,image_name, dealprice,shortdiscription,longdiscription,product_name,product_image,product_price,tagtitle,joindeal_count,deal_startdate,deal_enddate,cp_status)
    //     VALUES ('$cp_name','$cp_name_ar','$deal_image_update_url','$dealprice', '$shortdiscription', '$longdiscription','$cp_product_name','$deal_product_image_update_url','$cp_product_price','$tagtitle','$joindeal_count','$deal_startdate','$deal_enddate','$cp_status')";

    // if (mysqli_query($con, $sql)) {
    //     //echo json_encode(array('status' => 'success', 'message' => 'insert successfully','imageupload'=>$response));
    //     echo json_encode(array('status' => 'success', 'message' => 'insert successfully', 'name' => $cp_name));
    // } else {
    //     echo json_encode(array('status' => 'error', 'message' => 'Error in insert'));
    // }

    // $con->close();
} else {
    // Invalid request method
    echo json_encode(array('status' => 'error', 'message' => 'Invalid request method'));
}
