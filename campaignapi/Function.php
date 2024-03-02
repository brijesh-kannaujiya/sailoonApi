<?php

include('../dbconnection/db_functions.php');

class CampainHelper
{

    public function GetSingleCampain($id = null)
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

    public function uploadFile($file, $uploadDir)
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
}
