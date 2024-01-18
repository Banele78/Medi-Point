<?php
include 'DB_connect.php';

$receivedData = trim($_GET['Date']);


if(isset($receivedData)){
    
    $input=$receivedData;

   
	$get_times = "SELECT * FROM time_slots WHERE appointment_date LIKE '{$input}%'";
	$result_time=mysqli_query($conn,$get_times);
    $dataArray = array("msg" => "data found", "times"=>array(),"gsearch" => $receivedData);
	if(mysqli_num_rows($result_time)>0){
    
		while($t=mysqli_fetch_assoc($result_time)){
			
                $time=array('time'=>$t['appointment_time']);
                $dataArray["times"][]=$time;
		
			
			}
		
    }else{
        $dataArray["msg"]="No data found";
       
    }

    echo json_encode($dataArray);

}


?>