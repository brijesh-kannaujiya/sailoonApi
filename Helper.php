<?php
include('../token/Token.php');

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


function TokenVerify()
{
    $KEY = 'winnerthisisaapkey';
    if (isset(apache_request_headers()['Authorization'])) {
        $token = apache_request_headers()['Authorization'];
        $payload = Token::Verify($token, $KEY);
        if ($payload == false) {
            echo json_encode(array('status' => 'false', 'message' => 'Session expired'));
            exit();
        }
    } else {
        echo json_encode(array('status' => 'false', 'message' => 'Session expired'));
        exit();
    }
}
