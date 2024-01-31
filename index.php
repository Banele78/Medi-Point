
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Medi Point</title>
      <link rel="stylesheet" href="style.css">
   </head>
   <body>
   <div class="loader"></div>
      <div class="container">
      <span id="addServiceIcon" class="icon"  onclick="showAddInfo()">[+]</span>
      <span id="backIcon" class="icon" style="display:none;" onclick="backHome()">[<-]</span>
      <h1>Medi-Point</h1>
      <div id="getInfo">
         <label for="location">How can we help you:</label>
         <input type="text" id="searchlocation" placeholder="How can we help you"  oninput="checkInput()" >
         <button onclick="searchNearest()" id="submitButton" disabled>Search</button>
         <div id="result" class="result" onclick="senRequest()">
            
      </div><br>
      </div>
      <div id="addInfo" style="display:none;">
      <div id="Description"></div>
         <label for="institutionDescription">Add institution</label>
         <input type="text" id="institutionDescription" placeholder="Enter your name/title">
         <br>
         <div id="Services"></div>
          <label for="institutionServices">Add services</label>
         <input type="text" id="institutionServices" placeholder="Enter your services seperate by comma">
         <br>
         <label for="catagory">Choose a car:</label>


         
      <div class="Sector">
         <label for="Sector">Select Sector:</label>

<select name="sector" id="Sector">
  <option value="Private">Private</option>
  <option value="Public">Public</option>
  
</select>
</div>
<br>
         <div id="Address"></div>
          <label for="institutionAddress">Add address</label>
         <input type="text" id="institutionAddress" placeholder="Enter your Address">
         <br>
        
         <div id="latitude"></div>
          <label for="institutionlatitude">Add Latitude</label>
         <input type="text" id="institutionLatitude" placeholder="Enter your latitude">
         <br>
         <div id="Longitude"></div>
          <label for="institutionLongitude">Add Longitude</label>
         <input type="text" id="institutionLongitude" placeholder="Enter your Latitude">
         
         <button onclick="addInstitution()">Add</button>
         <div id="resultAdd" class="result"></div>
         
 
      </div>
     <!-- <script async src="https://cse.google.com/cse.js?cx=f305de39e2823457e">
</script>
<div class="gcse-search"></div>-->
      <script src="script.js"></script>
   </body>
</html>