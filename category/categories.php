<?php
include '../dbconnection/db_functions.php';
include('../token/Token.php');

const KEY = 'winnerthisisaapkey';
$token = apache_request_headers()['Authorization'];
$payload = Token::Verify($token, KEY);
if ($payload == false) {
    echo json_encode(array('status' => 'false', 'message' => 'Session expired'));
}

function gen_uuid()
{
    return strtolower(sprintf(
        '%04x%04x-%04x-%04x-%04x1%0X-%04x%04x%04x',
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        time(),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff)
    ) . '-' . time());
}

// Create category
function createCategory($name, $status, $name_ar)
{
    if (empty($name)) {
        return ['status' => 'error', 'message' => 'Name is required.'];
    }
    if (empty($status)) {
        return ['status' => 'error', 'message' => 'Status is required.'];
    }
    if (empty($name_ar)) {
        return ['status' => 'error', 'message' => 'Name (Arabic) is required.'];
    }
    $conn = connectToDatabase();
    $uuid = gen_uuid();
    $sql = "INSERT INTO categories (uuid, name, status, name_ar) VALUES ('$uuid', '$name', '$status', '$name_ar')";
    if ($conn->query($sql) === TRUE) {
        return ['status' => 'success', 'message' => 'Category created successfully'];
    } else {
        return ['status' => 'error', 'message' => 'Unable to create category. Please check your data and try again.'];
    }
}

// Read all categories
function getAllCategories($uuid)
{
    $conn = connectToDatabase();
    if ($uuid != null) {
        $sql = "SELECT * FROM categories where uuid = '$uuid'";
    } else {
        $sql = "SELECT * FROM categories";
    }
    $result = $conn->query($sql);

    $categories = [];
    if ($uuid != null) {
        $categories = $result->fetch_assoc();
    } else {
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }
    }
    return ['status' => 'success', 'categories' => $categories];
}

// Update category
function updateCategory($uuid, $name, $status, $name_ar)
{

    // Basic validation for UUID
    if (empty($uuid)) {
        return ['status' => 'error', 'message' => 'UUID is required for update.'];
    }

    // Validation for the 'name' field
    if (empty($name)) {
        return ['status' => 'error', 'message' => 'Name is required for update.'];
    }

    // Validation for the 'status' field
    if ($status == '') {
        return ['status' => 'error', 'message' => 'Status is required for update.'];
    }

    // Validation for the 'name_ar' field
    if (empty($name_ar)) {
        return ['status' => 'error', 'message' => 'Name (Arabic) is required for update.'];
    }

    $conn = connectToDatabase();
    $sql = "UPDATE categories SET name='$name', status='$status', name_ar='$name_ar' WHERE uuid='$uuid'";

    if ($conn->query($sql) === TRUE) {
        return ['status' => 'success', 'message' => 'Category updated successfully'];
    } else {
        return ['status' => 'error', 'message' => 'Unable to update category. Please check your data and try again.'];
    }
}

// Delete category
function deleteCategory($uuid)
{
    if (empty($uuid)) {
        return ['status' => 'error', 'message' => 'Invalid UUID for deletion.'];
    }
    $conn = connectToDatabase();
    $sql = "DELETE FROM categories WHERE uuid='$uuid'";
    if ($conn->query($sql) === TRUE) {
        return ['status' => 'success', 'message' => 'Category deleted successfully'];
    } else {
        return ['status' => 'error', 'message' => 'Error deleting category: ' . $conn->error];
    }
}
