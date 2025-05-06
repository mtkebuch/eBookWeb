<?php
// db.php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ebooklibrary"; // Updated to match your database name

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
