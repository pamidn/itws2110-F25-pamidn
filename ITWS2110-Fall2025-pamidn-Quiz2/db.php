<?php
$servername = "localhost";
$username = "root";
$password = "MyNewPassword"; // use your MySQL root password
$dbname = "ITWS2110_Fall2025_pamidn_Quiz2";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
