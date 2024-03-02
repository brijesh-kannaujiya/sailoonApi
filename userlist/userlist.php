<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");
include 'users.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $uuid = isset($_GET['uuid']) ? $_GET['uuid'] : null;
    $result = getAllUser($uuid);
    header('Content-Type: application/json');
    echo json_encode($result);
    exit;
}


// Handle requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? $_POST['name'] : null;
    $status = isset($_POST['status']) ? $_POST['status'] : null;
    $name_ar = isset($_POST['name_ar']) ? $_POST['name_ar'] : null;
    //$result = createCategory($name, $status, $name_ar);
    //header('Content-Type: application/json');
    //echo json_encode($result);
    exit;
}


