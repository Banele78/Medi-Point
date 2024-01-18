<?php
include 'DB_connect.php';

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

     $get_times = "SELECT number FROM time_slots WHERE appointment_date='$receivedDate' and appointment_time='$receivedTime'";
$result_time=mysqli_query($conn,$get_times);

if ($result_time) {
$t = mysqli_fetch_assoc($result_time);

if ($t['number'] > 0) {
    $add = $t['number'] - 1;

    $Update="UPDATE time_slots SET number= $add WHERE appointment_date='$receivedDate' and appointment_time='$receivedTime'" ;
    mysqli_query($conn, $Update);
    
     "Subtraction successful. New value: $add";
} else {
    echo "No records found for the specified date.";
}
} else {
echo "Error: " . mysqli_error($db);

}

     echo json_encode($dataArray);
}else{
    echo json_encode(array("error" => "Data not received"));
};

?>