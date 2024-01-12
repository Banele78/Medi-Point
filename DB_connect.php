<?php
    header('Content-Type: application/json');
    $servername = "localhost";
    $username = "root";
    $password = "1234";
    $dbname = "Medi-point";
    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>