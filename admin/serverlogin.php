<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Medi-point";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
session_start();
$get_user="SELECT * FROM hospitals";
$result=mysqli_query($conn,$get_user);

?>