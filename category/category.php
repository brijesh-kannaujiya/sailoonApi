<?php

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Headers: *");
include 'categories.php';
// Handle requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? $_POST['name'] : null;
    $status = isset($_POST['status']) ? $_POST['status'] : null;
    $name_ar = isset($_POST['name_ar']) ? $_POST['name_ar'] : null;
    $result = createCategory($name, $status, $name_ar);
    header('Content-Type: application/json');
    echo json_encode($result);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $uuid = isset($_GET['uuid']) ? $_GET['uuid'] : null;
    $result = getAllCategories($uuid);
    header('Content-Type: application/json');
    echo json_encode($result);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {

    $put_data = file_get_contents("php://input");
    $put_vars = json_decode($put_data, true);
    if ($put_vars === null && json_last_error() !== JSON_ERROR_NONE) {
        $result = ['status' => 'error', 'message' => 'Invalid JSON data'];
    } else {
        $uuid = isset($put_vars['uuid']) ? $put_vars['uuid'] : null;
        $name = isset($put_vars['name']) ? $put_vars['name'] : null;
        $status = isset($put_vars['status']) ? $put_vars['status'] : null;
        $name_ar = isset($put_vars['name_ar']) ? $put_vars['name_ar'] : null;
        $result = updateCategory($uuid, $name, $status, $name_ar);
    }
    header('Content-Type: application/json');
    echo json_encode($result);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $id = isset($_GET['uuid']) ? $_GET['uuid'] : null;
    $result = deleteCategory($id);
    header('Content-Type: application/json');
    echo json_encode($result);
    exit;
}
