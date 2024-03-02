<?php
include '../dbconnection/db_functions.php';



function getAllUser($uuid)
{
    $conn = connectToDatabase();
    if ($uuid != null) {
        $sql = "SELECT * FROM users where uuid = '$uuid'";
    } else {
        $sql = "SELECT * FROM users";
    }
    $result = $conn->query($sql);
    $users = [];
    if ($uuid != null) {
        $users = $result->fetch_assoc();
    } else {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }
    return ['status' => 'success', 'users' => $users];
}


function StatusChange($id, $status)
{
    if (empty($id)) {
        return ['status' => 'error', 'message' => 'Invalid ID for status change.'];
    }

    if ($status == '') {
        return ['status' => 'error', 'message' => 'Status is required.'];
    }

    $newID = base64_decode($id);
    $conn = connectToDatabase();
    $sql = "UPDATE users SET status='$status' WHERE id='$newID'";

    if ($conn->query($sql) === TRUE) {
        return ['status' => 'success', 'message' => 'User updated successfully'];
    } else {
        return ['status' => 'error', 'message' => 'Unable to update user. Please check your data and try again.'];
    }
}
