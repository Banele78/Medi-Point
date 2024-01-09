<?php
header('Content-Type: application/json');
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


$receivedInstitutionDescription=trim($_GET['Description']);
$receivedInstitutionServices=trim($_GET['Services']);


if(isset($receivedInstitutionDescription) 
and isset($receivedInstitutionServices) 
){
    

    $select="SELECT * FROM services WHERE services='$receivedInstitutionDescription' LIMIT 1";
    $search=mysqli_query($conn,$select);
    $user=mysqli_fetch_assoc($search);

    $dataArray = array(
        "Inerror" => "",
        "inserted" => "",
        "gsearch" => null
    );
    
    if ($user) {
        if ($user['services'] == $receivedInstitutionDescription) {
            $dataArray["Inerror"] = "service already exists";
        } else {
            $dataArray["Inerror"] = "Institution with a different name already exists";
        }
    } else {
        $insert = "INSERT INTO hospitalservices (Services) VALUES 
        ('$receivedInstitutionDescription')";
    
        $result = mysqli_query($conn, $insert);
    
        if ($result) {
            $serviceId = mysqli_insert_id($conn);
    
            
            $split = explode(",", $receivedInstitutionServices);
    
            foreach ($split as $word) {
                $insert1 = "INSERT INTO servicesindetail (hospitalServiceId, symptoms	
                ) VALUES ('$serviceId', '$word')";
                $resultInsert1 = mysqli_query($conn, $insert1);
    
                if (!$resultInsert1) {
                    // Handle the error, log it, or set an appropriate message in $dataArray["Inerror"]
                    $dataArray["Inerror"] = "Error inserting services: " . $conn->error;
                    break; // Stop the loop on the first error
                }
            }
    
            $dataArray["inserted"] = "Institution inserted successfully";
        } else {
            $dataArray["Inerror"] = "Error inserting hospital: " . $conn->error;
        }
    }
    
    echo json_encode($dataArray);
  

}else{
    echo json_encode(array("error" => "Data not received"));
};
?>