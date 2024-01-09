<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div id="Description"></div>
<label for="institutionDescription">Service category</label>

         <input type="text" id="ServiceCategory" placeholder="Enter your name/title">
         <br>
         <div id="Services"></div>
          <label for="institutionServices">Add services in category</label>
         <input type="text" id="institutionServices" placeholder="Enter your services seperate by comma">
         <br>
         <div id="resultAdd" class="result"></div>
         <button onclick="addInstitution()">Add</button>
</body>

<script>
    function addInstitution(){
  const ServiceCategory = document.getElementById('ServiceCategory').value;
  const Services = document.getElementById('institutionServices').value;
  const  resultDescriptin = document.getElementById('Description');
  const  resultServices = document.getElementById('Services');
  const  result = document.getElementById('resultAdd');
  



  if(!ServiceCategory ){
    resultDescriptin.innerHTML="Please enter a valid description."
     
  }else{
    resultDescriptin.innerHTML="";
  }

  if(!Services){
    resultServices.innerHTML="Please enter valid service(s)."
  }else{
    resultServices.innerHTML="";
  }

 

  if(!ServiceCategory || !Services){
    return;
  }else{
    var queryParams = `?Description=${encodeURIComponent(ServiceCategory)}&Services=${encodeURIComponent(Services)}`;

    
    var url = 'services.php';
    const xhr = new XMLHttpRequest();
    xhr.open('GET', url + queryParams, true);
    xhr.onreadystatechange = function () {
      if (xhr.readyState == 4) {
        if (xhr.status == 200) {
         
          try {
            const responseData = JSON.parse(xhr.responseText);
            console.log(responseData.Inerror);       // Output: Hi
            console.log(responseData.inserted);      // Output: []
            console.log(responseData.gsearch);   // Output: null

              result.innerHTML=responseData.inserted;
              resultDescriptin.innerHTML=responseData.Inerror;
            
          } catch (error) {
            console.error('Error parsing JSON:', error);
          }
        } else {
          console.error('Error: ' + xhr.status);
        }
      }
    };
    xhr.send();
   

  }

}
    </script>
</html>