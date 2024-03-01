<?php 


function connectToDatabase() {
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);

 

    if ($_SERVER['HTTP_HOST'] == 'localhost') {
        $dbhost = "localhost";
        $dbuser = "root";
        $dbpass = "Brijesh@123";
        $db = "winnerdb";
    }else{
        $dbhost = "localhost";
        $dbuser = "winnerdb_user";
        $dbpass = "&?sDDMm9=7[^";
        $db = "winnerdb";
    }
    

    $con = mysqli_connect($dbhost, $dbuser, $dbpass, $db);

    if (!$con) {
        die("Error connecting to the database: " . mysqli_connect_error());
    }

    return $con;
}
