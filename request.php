<?php
include 'DB_coonect';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

resultHospital.innerHTML += `Hospital: ${sortedLocations[i].Institution}, Distance: ${sortedLocations[i].distance.toFixed(
    2
  )
} km <br>
                 Service: ${sortedLocations[i].Service}<br>`;

?>