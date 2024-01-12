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


$receivedName=trim($_GET['name']);
$receivedSurname=trim($_GET['surname']);
$receivedNumber=trim($_GET['number']);
$receivedEmail=trim($_GET['email']);
$receivedDate=trim($_GET['date']);
$receivedTime=trim($_GET['time']);
$id =trim($_GET['id']);
if(isset($receivedName) 
and isset($receivedSurname) 
and isset($receivedNumber)
and isset($receivedEmail)
and isset($receivedDate)
and isset($receivedTime)
and isset($id)){

   

   $select="SELECT * FROM hospitals WHERE id='$id' LIMIT 1";
    $search=mysqli_query($conn,$select);
    $user=mysqli_fetch_assoc($search);
    $institution=$user['instituition'];

    $dataArray = array(
        "Inerror" => "",
        "inserted" => "",
        "gsearch" => null
    );

    $insert="INSERT INTO appointments(name, surname, phoneNo,dateOfBirth, institution, appointment_date, appointment_time) VALUES
    ('$receivedName', '$receivedSurname', '$receivedNumber', '$receivedEmail','$institution', '$receivedDate', '$receivedTime')";
     $result=mysqli_query($conn,$insert);

     if($result){
        $dataArray["inserted"] = "Institution inserted successfully $id";
     }else{
        $dataArray["inserted"] = "Error inserting hospital: " . $conn->error;
     }

     echo json_encode($dataArray);
}else{
    echo json_encode(array("error" => "Data not received"));
};

?>