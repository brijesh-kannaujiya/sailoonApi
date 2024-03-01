
<?php

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
 $con = mysqli_connect($dbhost, $dbuser, $dbpass , $db) or die($con);
?>
