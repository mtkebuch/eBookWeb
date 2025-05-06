<?php
$host = 'localhost';
$dbname = 'ebooklibrary';
$username = 'root';
$password = '';

$conn = mysql_connect($host, $username, $password);

if (!$conn) {
    die('Connection failed: ' . mysql_error());
}

mysql_select_db($dbname);
?>
