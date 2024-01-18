// script.js
//https://joburg.org.za/about_/regions/Pages/Region%20F%20-%20Inner%20City/REGION%20F%20Clinics/REGION-F-CLINICS.aspx
//add share user location so that you search for closest hospitals

function checkInput() {
  // Get the input field and the button
  var inputField = document.getElementById('searchlocation');
  var submitButton = document.getElementById('submitButton');

  // Check if the input field is empty
  if (inputField.value.trim() === '') {
    // If empty, disable the button
    submitButton.disabled = true;
  } else {
    // If not empty, enable the button
    submitButton.disabled = false;
  }
}
//recieve and send data to the database
function searchNearest() {
  const resultDiv = document.getElementById('result');

  // Get user's location
  if (!navigator.geolocation) {
    console.log("Geolocation is not supported by this browser.");
    return;
  }

  navigator.geolocation.getCurrentPosition(
    function successCallback(position) {
      console.log("Location successfully obtained:", position);
      const latitude = position.coords.latitude;
      const longitude = position.coords.longitude;

      if (latitude !== undefined && longitude !== undefined) {
        // Now you can send these coordinates to the server using AJAX or Fetch.
        sendSearchRequest(latitude, longitude);
      } else {
        console.error("Unable to obtain location coordinates.");
      }
    },
    function errorCallback(error) {
      console.error("Error getting user's location:", error);
    }
  );
}


  
  //get the results from the database
function sendSearchRequest(latitude, longitude) {
  const resultDiv = document.getElementById('result');
  
  const Input = document.getElementById('searchlocation');
  const loader = document.querySelector('.loader');
  var submitButton = document.getElementById('submitButton');
  loader.style.display = 'flex';
  submitButton.style.display = 'none';
  
  const userInput = Input.value.trim();
  var service = '';

  if (!userInput) {
    resultDiv.innerHTML = 'No search keywords were entered.';
    return;
  }

  // Perform AJAX request to server-side script (api.php)
  const xhr = new XMLHttpRequest();

  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4) {
      if (xhr.status == 200) {
        loader.style.display = 'none';
        submitButton.style.display = 'block';
        console.log(xhr.responseText);
        try {
          const data = JSON.parse(xhr.responseText);

          if (data.msg) {
            resultDiv.innerHTML = data.msg;
          } else {
            resultDiv.innerHTML = ''; // Clear previous content
            
            // Calculate distances and store them in a new array
            const locationsWithDistances = data.data.map((location) => {
              const lat2 = parseFloat(location.latitude);
              const lon2 = parseFloat(location.longitude);

              if (!isNaN(lat2) && !isNaN(lon2)) {
                const distance = haversineDistance(
                  latitude,
                  longitude,
                  lat2,
                  lon2
                );
               
                return { ...location, distance }; // Include the distance in the location object
              } else {
                return { ...location, distance: Infinity }; // Assign a large value for invalid coordinates
              }
            });

            // Sort the locations based on distances
            const sortedLocations = locationsWithDistances.sort(
              (a, b) => a.distance - b.distance
            );
            console.log('Sorted Locations:', sortedLocations);

            // Display sorted locations with distances
            //SEARCH THE INPUT TO SEE IF there are keywords that macth from the database
            const userSentence = userInput; // Replace this with the actual user input sentence

            const processedServices = new Set();

            for (let j = 0; j < data.Services.length; j++) {
              // Check if data.Services[j] is defined before accessing its properties
              const service = data.Services[j] && data.Services[j].Service;

              if (
                service &&
                userSentence.includes(service) &&
                !processedServices.has(service)
              ) {
                console.log('Found:', service);

                // audio.src = a_music;
                // audio.play();

                // Display information for locations that match the current service
                for (let i = 0; i < sortedLocations.length; i++) {
                  // Check if the current location matches the service
                  if (sortedLocations[i].Service === service) {
                    if(sortedLocations[i].status=='online'){
                    resultDiv.innerHTML += `Hospital:<a href="booking appointment/index.php?id=${sortedLocations[i].id}"> ${sortedLocations[i].Institution}</a><br> Distance: ${sortedLocations[i].distance.toFixed(
                      2
                    )
                  } km <br>
                                   Service: ${sortedLocations[i].Service}<br> Status:${sortedLocations[i].status} <br><br>`;
                                  
                                
                                   console.log('Result Div Content:', resultDiv.innerHTML);
                                  }
                  }
                  // Inside the loop where you calculate distances

                }

                // Mark the service as processed
                processedServices.add(service);
              } else {
                console.log(
                  'Not found or already processed:',
                  service
                );
              }
            }
          }
        } catch (error) {
          console.error('Error parsing JSON:', error);
        }
      } else {
        console.error('Error: ' + xhr.status);
      }
    }
  };

  var queryParams = `?location=${encodeURIComponent(
    service
  )}&latitude=${encodeURIComponent(latitude)}&longitude=${encodeURIComponent(
    longitude
  )}`;

  var url = 'api.php';
  xhr.open('GET', url + queryParams, true);
  xhr.send();
}

function haversineDistance(lat1, lon1, lat2, lon2, unit = 'km') {
  // Radius of the Earth in different units
  const earthRadius = unit === 'mi' ? 3959 : 6371; // mi or km

  // Convert degrees to radians
  const toRadians = (degree) => degree * (Math.PI / 180);
  const radLat1 = toRadians(lat1);
  const radLon1 = toRadians(lon1);
  const radLat2 = toRadians(lat2);
  const radLon2 = toRadians(lon2);

  // Calculate the differences between latitude and longitude
  const latDiff = radLat2 - radLat1;
  const lonDiff = radLon2 - radLon1;

  // Log intermediate values
  console.log('lat1:', lat1, 'lon1:', lon1);
  console.log('lat2:', lat2, 'lon2:', lon2);
  console.log('latDiff:', latDiff, 'lonDiff:', lonDiff);

  // Haversine formula
  const a =
    Math.sin(latDiff / 2) ** 2 +
    Math.cos(radLat1) * Math.cos(radLat2) * Math.sin(lonDiff / 2) ** 2;
  const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

  // Log additional intermediate values
  console.log('a:', a, 'c:', c);

  const distance = earthRadius * c;
  console.log('Distance:', distance);

  return distance;
}


function addInstitution(){
  const Descriptin = document.getElementById('institutionDescription').value;
  const Services = document.getElementById('institutionServices').value;
  const Address = document.getElementById('institutionAddress').value;
  const Latitude = document.getElementById('institutionLatitude').value;
  const Longitude = document.getElementById('institutionLongitude').value;
  const  resultDescriptin = document.getElementById('Description');
  const  resultServices = document.getElementById('Services');
  const  resultAddress = document.getElementById('Address');
  const  resultLatitude = document.getElementById('latitude');
  const  resultLongitude = document.getElementById('Longitude');
  const  result = document.getElementById('resultAdd');
  const  sector = document.getElementById('Sector').value;



  if(!Descriptin){
    resultDescriptin.innerHTML="Please enter a valid description."
     
  }else{
    resultDescriptin.innerHTML="";
  }

  if(!Services){
    resultServices.innerHTML="Please enter valid service(s)."
  }else{
    resultServices.innerHTML="";
  }

  if(!Address){
    resultAddress.innerHTML="Please enter a valid Address."
  
  }else{
    resultAddress.innerHTML="";
    
  }

  if(!Latitude){
    resultLatitude.innerHTML="Please enter a valid Address latitude."
  
  }else{
    resultLatitude.innerHTML="";
    
  }

  if(!Longitude){
    resultLongitude.innerHTML="Please enter a valid longitude."
  
  }else{
    resultLongitude.innerHTML="";
    
  }

  if(!Descriptin || !Services || !Address || !Latitude || !Longitude){
    return;
  }else{
    var queryParams = `?Description=${encodeURIComponent(Descriptin)}
    &Services=${encodeURIComponent(Services)}
    &Address=${encodeURIComponent(Address)}
    &Latitude=${encodeURIComponent(Latitude)}
    &Longitude=${encodeURIComponent(Longitude)}
    &Sector=${encodeURIComponent(sector)}`;
    
    var url = 'addInstitution.php';
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

function backHome() {
    //
    let getInfoElem = document.getElementById("getInfo");
    let addInfoElem = document.getElementById("addInfo");
    getInfoElem.style.display = "block";
    addInfoElem.style.display = "none";
    let addIcon = document.getElementById("addServiceIcon");
    let backIcon = document.getElementById("backIcon");
    addIcon.style.display = "block";
    backIcon.style.display = "none";
}

function showAddInfo() {
    let getInfoElem = document.getElementById("getInfo");
    let addInfoElem = document.getElementById("addInfo");
    getInfoElem.style.display = "none";
    addInfoElem.style.display = "block";
    let addIcon = document.getElementById("addServiceIcon");
    let backIcon = document.getElementById("backIcon");
    addIcon.style.display = "none";
    backIcon.style.display = "block";
}

const x = document.getElementById("demo");


function senRequest(){
  var queryParams = `?Description=${encodeURIComponent(Descriptin)}
    &Services=${encodeURIComponent(Services)}
    &Address=${encodeURIComponent(Address)}
    &Latitude=${encodeURIComponent(Latitude)}
    &Longitude=${encodeURIComponent(Longitude)}
    &Sector=${encodeURIComponent(sector)}`;
    
    var url = 'addInstitution.php';
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


  