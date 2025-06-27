<?php
define('DB_SERVER', 'sql210.infinityfree.com');
define('DB_USERNAME', 'if0_39335616');
define('DB_PASSWORD', 'VWelUBfDrY');
define('DB_NAME', 'if0_39335616_database');

/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>