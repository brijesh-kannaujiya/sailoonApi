<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");
include 'users.php';
include('../Helper.php');


TokenVerify();


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $uuid = isset($_GET['uuid']) ? $_GET['uuid'] : null;
    $result = getAllUser($uuid);
    header('Content-Type: application/json');
    echo json_encode($result);
    exit;
}

// Handle requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $put_data = file_get_contents("php://input");
    $put_vars = json_decode($put_data, true);
    $id = isset($put_vars['id']) ? $put_vars['id'] : null;
    $status = isset($put_vars['status']) ? $put_vars['status'] : null;
    $result = StatusChange($id, $status);
    header('Content-Type: application/json');
    echo json_encode($result);
    exit;
}
