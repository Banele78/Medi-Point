<?php
include 'DB_connect.php';


$receivedData = trim($_GET['location']);
$latitude = trim($_GET["latitude"]);
$longitude = trim($_GET["longitude"]);


if (isset($receivedData)) {
  

    //retrive data
    $input = $receivedData;
    $la=$latitude;
    $ln=$longitude;


$GETSERVICES="SELECT * FROM services WHERE Services";

$resultSer=mysqli_query($conn,$GETSERVICES);


    $get = "SELECT * FROM services 
                   JOIN hospitals ON services.instituitionId = hospitals.id
                  WHERE services.Services LIKE '{$input}%'";
    
    $result = mysqli_query($conn, $get);

    $dataArray = array("msg" => "", "data" => array(), "Services"=>array(),"gsearch" => null);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            while ($t = mysqli_fetch_assoc($result)) {
                $data = array('id'=>$t['id'],'Institution' => $t['instituition'], 'Service' => $t['Services']
                , 'latitude' => $t['latitude'] , 'longitude' => $t['longnitude'], 'status'=>$t['InstitutionStatus']);
                $dataArray["data"][] = $data;
                $services=array('Service'=>$t['Services']);
                $dataArray["Services"][]=$services;
            }
        } else {
            $api_key='AIzaSyBNrLQYJYK3G0iS7w8Xb1X1cdA0y_-SO7c';
            $search_engine_id='f305de39e2823457e';
         
            $search_query=urlencode($_GET['location']);
         
            $api_endpoint_url="https://www.googleapis.com/ustomsearch/v1?key={$api_key}&cx={$search_engine_id}&q={$search_query}";
         
            $response_json=file_get_contents($api_endpoint_url);
            $response=json_decode($response_json,true);
         
             echo $response;
            //$dataArray["msg"] = "No results found for '{$receivedData}'";
        }
    } else {
        $dataArray["msg"] = "Error in SQL query: " . mysqli_error($conn);
    }
   
    echo json_encode($dataArray);
} else {
   
  

    echo json_encode(array("msg" => "Did not receive data from client"));
}

// Close connection
$conn->close();
?>
