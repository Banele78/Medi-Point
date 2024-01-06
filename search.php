 
        $url = 'https://www.googleapis.com/customsearch/v1?key=[MY API KEY]&cx=[MY CX KEY]&q=lecture';

$body = file_get_contents($url);

$dataArray['gsearch'] = $body;

//chatgpt 2

//$openai = new OpenAI('YOUR_API_KEY');
//https://www.educative.io/answers/how-to-use-chatgpt-api-in-php

$response = $openai->complete([
 'model' => 'gpt-3.5-turbo',
 'messages' => [
   ['role' => 'system', 'content' => 'You are a helpful assistant.'],
   ['role' => 'user', 'content' => 'Who won the world series in 2020?']
 ],
 'temperature' => 0.6
]);
}

echo json_encode($dataArray);
}
//https://joburg.org.za/about_/regions/Pages/Region%20F%20-%20Inner%20City/REGION%20F%20Clinics/REGION-F-CLINICS.aspx

<?php
// Connect to your MySQL database
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "hospital_finder";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user's location from the request
$location = $_GET['location'];

// Perform a simple query to find the nearest hospital
$sql = "SELECT id, name, latitude, longitude, 
        SQRT(POW(69.1 * (latitude - user_latitude), 2) + POW(69.1 * (user_longitude - longitude) * COS(latitude / 57.3), 2)) AS distance
        FROM hospitals
        ORDER BY distance
        LIMIT 1";

// Replace 'user_latitude' and 'user_longitude' with the actual latitude and longitude of the user
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "<p>Nearest Hospital: " . $row['name'] . "</p>";
    echo "<p>Distance: " . round($row['distance'], 2) . " miles</p>";
} else {
    echo "<p>No hospitals found.</p>";
}

$conn->close();


require __DIR__ .'/vendor/autoload.php';
 use Orhanerday\OpenAi\OpenAi;

 $open_ai=new OpenAi('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');
 //get prompt pra
 $prompt=$_GET['prompt'];
 //set api data
 $complete=$open_ai->completion([
     'model'=>'text-davinci-003',
     'prompt'=>$prompt,
     'temperature'=>0.7,
     'max_tokens'=>256,
     'top_p'=>1,
     'frequency_penalty'=>0,
     'presence_penalty'=>0
 ]);
 var_dump($complete);

 <script async src="https://cse.google.com/cse.js?cx=f305de39e2823457e">
</script>
<div class="gcse-search"></div>
?>
