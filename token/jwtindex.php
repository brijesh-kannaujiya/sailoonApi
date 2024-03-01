<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Headers: *");
// Include the file
require 'Token.php';

// Define a key
const KEY = 'winnerthisisaapkey';

// Generate token
//$token = Token::Sign(['id' => 'demoid'], KEY, 60*5);
$token = Token::Sign(['id' => 'demoid'], KEY, 60*700);
$response["status"] = "true";
$response["token"] = $token;
echo json_encode($response); 
exit;

// Vefity token
//$payload = Token::Verify($token, KEY);

