<?php
include 'DB_connect.php';

$receivedInstitutionDescription=trim($_GET['Description']);
$receivedInstitutionServices=trim($_GET['Services']);
$receivedInstitutionAddress=trim($_GET['Address']);
$receivedInstitutionLatitude=trim($_GET['Latitude']);
$receivedInstitutionLongitude=trim($_GET['Longitude']);
$receivedInstitutionSector=trim($_GET['Sector']);

if(isset($receivedInstitutionDescription) 
and isset($receivedInstitutionServices) 
and isset($receivedInstitutionAddress)
and isset($receivedInstitutionLatitude)
and isset($receivedInstitutionLongitude)
and isset($receivedInstitutionSector)){
    

    $select="SELECT * FROM hospitals WHERE instituition='$receivedInstitutionDescription' LIMIT 1";
    $search=mysqli_query($conn,$select);
    $user=mysqli_fetch_assoc($search);

    $dataArray = array(
        "Inerror" => "",
        "inserted" => "",
        "gsearch" => null
    );
    
    if ($user) {
        if ($user['instituition'] == $receivedInstitutionDescription) {
            $dataArray["Inerror"] = "Institution already exists";
        } else {
            $dataArray["Inerror"] = "Institution with a different name already exists";
        }
    } else {
        $insert = "INSERT INTO hospitals (instituition, address1, latitude, longnitude, Sector) VALUES 
        ('$receivedInstitutionDescription', '$receivedInstitutionAddress', '$receivedInstitutionLatitude',
        '$receivedInstitutionLongitude','$receivedInstitutionSector')";
    
        $result = mysqli_query($conn, $insert);
    
        if ($result) {
            $hospitalId = mysqli_insert_id($conn);
    
            
            $split = explode(",", $receivedInstitutionServices);
    
            foreach ($split as $word) {
                $insert1 = "INSERT INTO services (instituitionid, Services) VALUES ('$hospitalId', '$word')";
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