<?php
// Error Reporting Turn On
ini_set('error_reporting', E_ALL);

// Setting up the time zone
date_default_timezone_set('Asia/Kolkata');


// Host Name
$dbhost = 'localhost';

// Database Name
$dbname = 'u916910749_db_ssnmarket';

// Database Username
$dbuser = 'u916910749_ssnmarket';

// Database Password
$dbpass = '13@Gmail';

// Defining base url
define("BASE_URL", "https://ssnmarket.com/");

// Getting Admin url
define("ADMIN_URL", BASE_URL . "admin" . "/");

try {
	$pdo = new PDO("mysql:host={$dbhost};dbname={$dbname}", $dbuser, $dbpass);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch( PDOException $exception ) {
	echo "Connection error :" . $exception->getMessage();
}