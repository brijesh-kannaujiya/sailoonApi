<?php

include('../dbconnection/db_functions.php');

function GetSingleCampain($id = null)
{
    $con = connectToDatabase();

    $query = "SELECT * FROM campains where deal_id=$id";
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
    return $queryresult['result'];
}

function uploadFile($file, $uploadDir)
{
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return array(
            'status' => 'error',
            'message' => 'File upload failed with error code ' . $file['error']
        );
    }
    $randomName = uniqid() . "-" . $file['name'];
    $uploadPath = $uploadDir . strtolower($randomName);
    $uploadPath = preg_replace('/\s+/', '-', $uploadPath);
    if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
        return array(
            'status' => 'success',
            'message' => 'File uploaded successfully',
            'url' => $uploadPath
        );
    } else {
        return array(
            'status' => 'error',
            'message' => 'Error moving the uploaded file to the destination',
            'url' => '',
        );
    }
}


function createCategory($cp_name, $cp_name_ar, $dealprice, $shortdiscription, $longdiscription, $shortdiscription_ar, $longdiscription_ar, $cp_product_name, $cp_product_name_ar, $tagtitle, $joindeal_count, $deal_startdate, $deal_enddate, $cp_status, $product_image, $deal_image, $cp_product_price)
{
    if (empty($cp_name)) {
        return ['status' => 'error', 'message' => 'Campaign name is required.'];
    }

    if (empty($cp_name_ar)) {
        return ['status' => 'error', 'message' => 'Campaign name (Arabic) is required.'];
    }

    if (empty($dealprice)) {
        return ['status' => 'error', 'message' => 'Deal price is required.'];
    }

    if (empty($shortdiscription)) {
        return ['status' => 'error', 'message' => 'Short Discription is required.'];
    }

    if (empty($longdiscription)) {
        return ['status' => 'error', 'message' => 'Long Discription is required.'];
    }

    if (empty($shortdiscription_ar)) {
        return ['status' => 'error', 'message' => 'Short Discription (Arabic)  is required.'];
    }

    if (empty($longdiscription_ar)) {
        return ['status' => 'error', 'message' => 'Long Discription (Arabic)  is required.'];
    }

    if (empty($cp_product_name)) {
        return ['status' => 'error', 'message' => 'Product Name is required.'];
    }

    if (empty($cp_product_name_ar)) {
        return ['status' => 'error', 'message' => 'Product Name (Arabic)  is required.'];
    }

    if (empty($tagtitle)) {
        return ['status' => 'error', 'message' => 'Tag Title is required.'];
    }

    if (empty($joindeal_count)) {
        return ['status' => 'error', 'message' => 'Join Deal Count is required.'];
    }

    if (empty($deal_startdate)) {
        return ['status' => 'error', 'message' => 'Deal Start Date is required.'];
    }

    if (empty($deal_enddate)) {
        return ['status' => 'error', 'message' => 'Deal End Date is required.'];
    }

    if (empty($cp_status)) {
        return ['status' => 'error', 'message' => 'Status is required.'];
    }

    if (empty($product_image) || $product_image['name'] == '') {
        return ['status' => 'error', 'message' => 'Product Image is required.'];
    }

    if (empty($deal_image) || $deal_image['name'] == '') {
        return ['status' => 'error', 'message' => 'Deal Image is required.'];
    }

    if (empty($cp_product_price)) {
        return ['status' => 'error', 'message' => 'Product Price is required.'];
    }

    $deal_image = uploadFile($_FILES["avatar"], 'deal_image/')['url'];
    $product_image = uploadFile($_FILES["avatar_product"], 'deal_image_product/')['url'];

    $sql = "INSERT INTO campains (cp_name,cp_name_ar ,image_name, dealprice,shortdiscription,longdiscription,product_name,product_image,product_price,tagtitle,joindeal_count,deal_startdate,deal_enddate,cp_status,shortdiscription_ar,longdiscription_ar,cp_product_name_ar)
    VALUES ('$cp_name','$cp_name_ar','$deal_image','$dealprice', '$shortdiscription', '$longdiscription','$cp_product_name','$product_image','$cp_product_price','$tagtitle','$joindeal_count','$deal_startdate','$deal_enddate','$cp_status','$shortdiscription_ar','$longdiscription_ar','$cp_product_name_ar')";
    $conn = connectToDatabase();
    if ($conn->query($sql) === TRUE) {
        return ['status' => 'success', 'message' => 'Campains Create successfully'];
    } else {
        return ['status' => 'error', 'message' => 'Unable to Create Campains. Please check your data and try again.'];
    }
}
