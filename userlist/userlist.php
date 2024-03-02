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
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $status = isset($_POST['status']) ? $_POST['status'] : null;
    $result = StatusChange($id, $status);
    header('Content-Type: application/json');
    echo json_encode($result);
    exit;
}
