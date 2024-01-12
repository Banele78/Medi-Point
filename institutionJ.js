const currentDate = document.querySelector(".current-date"),
    daysTag = document.querySelector(".days"),
    prevNextIcon = document.querySelectorAll(".icons span");

let date = new Date(),
    currYear = date.getFullYear(),
    currMonth = date.getMonth();

const months = [
    "January", "February", "March", "April", "May", "June", "July", "August", "September",
    "October", "November", "December"
];

let firstDayOfMonth = new Date(currYear, currMonth, 1).getDay();

const renderCalendar = () => {
    let lastDateOfMonth = new Date(currYear, currMonth + 1, 0).getDate(),
        lastDayOfMonth = new Date(currYear, currMonth, lastDateOfMonth).getDay(),
        lastDateOfLastMonth = new Date(currYear, currMonth, 0).getDate();

    let liTag = "";

    for (let i = firstDayOfMonth; i > 0; i--) {
        liTag += `<li class="inactive">${lastDateOfLastMonth - i + 1}</li>`;
    }

    for (let i = 1; i <= lastDateOfMonth; i++) {
        let isToday = i === date.getDate() && currMonth === new Date().getMonth()
            && currYear === new Date().getFullYear() ? "active" : "";
        liTag += `<li class="${isToday}" onclick="handleDateClick(${i})">${i}</li>`;
    }

    for (let i = lastDayOfMonth; i < 6; i++) {
        liTag += `<li class="inactive">${i - lastDayOfMonth + 1}</li>`;
    }

    currentDate.innerText = `${months[currMonth]} ${currYear}`;
    daysTag.innerHTML = liTag;
}

renderCalendar();


prevNextIcon.forEach(icon => {
    icon.addEventListener("click", () => {
        // if clicked icon is previous icon then decrement current month by 1 else increment it by 1
        currMonth = icon.id === "prev" ? currMonth - 1 : currMonth + 1;

        if (currMonth < 0 || currMonth > 11) {
            // if current month is less than 0 or greater than 11
            // creating a new date of the current year & month and pass it as date value
            date = new Date(currYear, currMonth);
            currYear = date.getFullYear(); // updating current year with new date year
            currMonth = date.getMonth(); // updating current month with new date month
            firstDayOfMonth = new Date(currYear, currMonth, 1).getDay(); // updating firstDayOfMonth
        } else {
            date = new Date();
            firstDayOfMonth = new Date(currYear, currMonth, 1).getDay(); // updating firstDayOfMonth
        }
        renderCalendar();
    });
});


function formatDate(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0'); // Month is zero-based
    const day = String(date.getDate()).padStart(2, '0');
    
    return `${year}-${month}-${day}`;
}
let selected_Data = null; // Initialize the selected data as null
// Attach the click event listener to a parent element (document in this case)

function handleDateClick(day) {
    // Replace this with your desired action when a date is clicked
    const clickedDate = new Date(currYear, currMonth, day);
    const SelectedDate = document.getElementById('SelectedDate');
    const SelectedTime = document.getElementById('SelectedTime');
    const SelectedDate1 = document.getElementById('SelectedDate1');
    const SelectedTime1 = document.getElementById('SelectedTime1');
    
    
    // Remove existing 'active' class from all dates
    document.querySelectorAll('.days li').forEach(li => li.classList.remove('active'));

    // Find the clicked date's <li> element and add the 'active' class
    const clickedDateElement = document.querySelector(`.days li:nth-child(${day + firstDayOfMonth})`);
    clickedDateElement.classList.add('active');


    // Log the formatted date to the console
   console.log("Clicked Date:", formatDate(clickedDate));
   SelectedDate.innerHTML=formatDate(clickedDate);
   SelectedDate1.innerHTML=`Date: ${formatDate(clickedDate)}`;
   SelectedTime.innerHTML='';
   SelectedTime1.innerHTML='';
   selected_Data = null;

    const  result = document.getElementById('searchresult');
    var queryParams = `?Date=${encodeURIComponent(formatDate(clickedDate))}`;
    
    var url = 'institutionServer.php';
    const xhr = new XMLHttpRequest();
    xhr.open('GET', url + queryParams, true);
    xhr.onreadystatechange = function () {
      if (xhr.readyState == 4) {
        if (xhr.status == 200) {
         
            try {
                const responseData = JSON.parse(xhr.responseText);
                if (responseData.times && responseData.times.length > 0) {
                    console.log(responseData.times);
                    console.log(responseData.msg);
                    console.log(responseData.gsearch);

                    // Assuming responseData is the parsed JSON response from the server
                    const timesArray = responseData.times;
                    let htmlContent = "";

                    timesArray.forEach(item => {
                        const appointmentTime = item.time;
                        console.log(appointmentTime);
                        // Do something with the appointmentTime
                        htmlContent += `<button value="${appointmentTime}" class="time-button">${appointmentTime}</button><br>`;
                    });

                    result.innerHTML = htmlContent;

                    
                   
                } else {
                    console.log('No data found');
                    // Handle the case when there's no data to display
                    result.innerHTML = "No time slots found for this day";
                }
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

function setVariableToNull() {
    selected_Data = null;
    
  }


document.addEventListener('click', function (event) {
    const time_buttons = document.querySelectorAll('.time-button');
const selected_Option = document.getElementById('selected_Option');
const SelectedTime = document.getElementById('SelectedTime');
const SelectedTime1 = document.getElementById('SelectedTime1');


    if (event.target.classList.contains('time-button')) {
        if (!event.target.classList.contains('Timeselected')) {
            time_buttons.forEach(btn => btn.classList.remove('Timeselected'));
            event.target.classList.add('Timeselected');
            selected_Data = event.target.textContent;
            SelectedTime.style.fontSize = '21px';
        SelectedTime.style.left = '65%';
            
            console.log(selected_Data)
            SelectedTime.innerHTML=selected_Data;
            SelectedTime1.innerHTML=`Time: ${selected_Data}`;
        }
    }
});

const popup = document.querySelector(".book");
document.addEventListener('DOMContentLoaded', function() {
    var showPopupButton = document.getElementById('DateTime');
    var closePopupButton = document.getElementById('close');
    const SelectedTime = document.getElementById('SelectedTime');
    const SelectedDate = document.getElementById('SelectedDate');
   
    

    showPopupButton.addEventListener('click', function() {
        popup.style.display = 'flex';
    });

    closePopupButton.addEventListener('click', function() {
        popup.style.display = 'none';
        SelectedTime.innerHTML="";
        SelectedDate.innerHTML="";
        
       
    });
});

function submitDayTime() {
    const SelectedTime = document.getElementById('SelectedTime');

    if (selected_Data === null) {
        SelectedTime.style.fontSize = '17px';
        SelectedTime.style.left = '63%';
        SelectedTime.innerHTML = "Please select time";
       
    } else {
        // Assuming you have a variable 'popup' declared elsewhere
        // to toggle the display of a pop-up
        
        popup.style.display = 'none';
    }
}

function addappointment(){
    const name = document.getElementById('name').value;
    const surname = document.getElementById('surname').value;
    const number = document.getElementById('number').value;
    const email = document.getElementById('email').value;
    const SelectedDate = document.getElementById('SelectedDate').innerHTML;
    const name2 = document.getElementById('name');
    const surname2 = document.getElementById('surname');
    const number2 = document.getElementById('number');
    const email2 = document.getElementById('email');
    const DateTime = document.getElementById('DateTime');
    
   
   
    const  ValidName = document.getElementById('ValidName');
    const  ValidSurame= document.getElementById('ValidSurname');
    const ValidNumber = document.getElementById('ValidNumber');
    const  ValidEmail = document.getElementById('ValidEmail');
    const  ValidDate = document.getElementById('ValidDate');
    const  result = document.getElementById('resultAdd');

    var id = new URLSearchParams(window.location.search).get('id');
   
  
  
  
    if(! name){
       name2.style.borderColor="rgb(170, 23, 23)";
       ValidName.innerHTML="*Please ensure all fields highlighed in red are filled"
       
    }else{
        name2.style.borderColor = "rgb(2, 2, 2)";
    }
  
    if(! surname){
        surname2.style.borderColor="rgb(170, 23, 23)";
        ValidName.innerHTML="*Please ensure all fields highlighed in red are filled"
    }else{
        surname2.style.borderColor = "rgb(2, 2, 2)";
    }
  
    if(!number){
        number2.style.borderColor="rgb(170, 23, 23)";
        ValidName.innerHTML="*Please ensure all fields highlighed in red are filled"
    
    }else{
        number2.style.borderColor = "rgb(2, 2, 2)";
       
    }
  
    if(!email){
        email2.style.borderColor="rgb(170, 23, 23)";
        ValidName.innerHTML="*Please ensure all fields highlighed in red are filled"
    
    }else{
        email2.style.borderColor = "rgb(2, 2, 2)";
      
    }
  
    if(selected_Data===null){
        DateTime.style.borderColor="rgb(170, 23, 23)";
        ValidName.innerHTML="*Please ensure all fields highlighed in red are filled"
    
    }else{
        DateTime.style.borderColor="rgb(2, 2, 2)";
      
    }

    

  
    if(!name || !surname || !number || !email || selected_Data===null){
      return;
    }else{
      var queryParams = `?name=${encodeURIComponent(name)}
      &surname=${encodeURIComponent(surname)}
      &number=${encodeURIComponent(number)}
      &email=${encodeURIComponent(email)}
      &date=${encodeURIComponent(SelectedDate)}
      &time=${encodeURIComponent(selected_Data)}
      &id=${encodeURIComponent(id)}`;
      
      var url = 'addappointment.php';
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

  function validateSouthAfricanPhoneNumber(phoneNumber) {
    // Define a regular expression for South African phone numbers
    var phoneRegex = /^(?:\+27|0)(?:(10|11|12|13|14|15|16|17|18|19|21|22|23|24|25|26|27|28|29|31|32|33|34|35|36|37|38|39|41|42|43|44|45|46|47|48|49|51|52|53|54|56|57|58|59|61|62|63|64|65|66|67|68|69|71|72|73|74|75|76|77|78|79|81|82|83|84|85|86|87|88|89|91|92|93|94|95|96|97|98|99)\d{7})$/;

    // Test the phone number against the regular expression
    return phoneRegex.test(phoneNumber);
}

function validateEmail(email) {
    // Define a regular expression for a basic email format
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    // Test the email against the regular expression
    return emailRegex.test(email);
}



  function Next(){

    const name = document.getElementById('name').value;
    const surname = document.getElementById('surname').value;
    const number = document.getElementById('number').value;
    const email = document.getElementById('email').value;
    const SelectedDate = document.getElementById('SelectedDate').innerHTML;
    const name2 = document.getElementById('name');
    const surname2 = document.getElementById('surname');
    const number2 = document.getElementById('number');
    const email2 = document.getElementById('email');
    const DateTime = document.getElementById('DateTime');
   
   
    const  ValidName = document.getElementById('ValidName');
    const  ValidNumber = document.getElementById('ValidNumber');
    const ValidEmail = document.getElementById('ValidEmail');
    const  conName= document.getElementById('conName');
    const conSurname = document.getElementById('conSurname');
    const conNumber = document.getElementById('conNumber');
    const  conEmail = document.getElementById('conEmail');
    const  conDate = document.getElementById('conDate');
    const  conTime = document.getElementById('conTime');
    const form= document.querySelector(".form");
    const ConfirmInfo= document.querySelector(".ConfirmInfo");

    var id = new URLSearchParams(window.location.search).get('id');
   
  
  
  
    if(! name){
       name2.style.borderColor="rgb(170, 23, 23)";
       ValidName.innerHTML="*Please ensure all fields highlighed in red are filled"
       
    }else{
        name2.style.borderColor = "rgb(2, 2, 2)";
    }
  
    if(! surname){
        surname2.style.borderColor="rgb(170, 23, 23)";
        ValidName.innerHTML="*Please ensure all fields highlighed in red are filled"
    }else{
        surname2.style.borderColor = "rgb(2, 2, 2)";
    }
  
    if(!number){
        number2.style.borderColor="rgb(170, 23, 23)";
        ValidName.innerHTML="*Please ensure all fields highlighed in red are filled"
    
    }else{
        number2.style.borderColor = "rgb(2, 2, 2)";
       
    }
  
    if(!email){
        email2.style.borderColor="rgb(170, 23, 23)";
        ValidName.innerHTML="*Please ensure all fields highlighed in red are filled"
    
    }else{
        email2.style.borderColor = "rgb(2, 2, 2)";
      
    }
  
    if(selected_Data===null){
        DateTime.style.borderColor="rgb(170, 23, 23)";
        ValidName.innerHTML="*Please ensure all fields highlighed in red are filled"
    
    }else{
        DateTime.style.borderColor="rgb(2, 2, 2)";
      
    }

    if (validateSouthAfricanPhoneNumber(number)) {
        console.log("South African phone number is valid");
        ValidNumber.innerHTML="";
    } else {
        ValidNumber.innerHTML="*Please enter a valid phone number"
        number2.style.borderColor="rgb(170, 23, 23)";
    }

    if (validateEmail(email)) {
        console.log("South African phone number is valid");
        ValidEmail.innerHTML="";
    } else {
        ValidEmail.innerHTML="*Please enter a valid email address"
         email2.style.borderColor="rgb(170, 23, 23)";
    }

    if(!name || !surname || !number || !email || selected_Data===null || !validateEmail(email) || !validateSouthAfricanPhoneNumber(number)){
        return;
      }else{
form.style.display="none";
ConfirmInfo.style.display="block";

conName.innerHTML=`Name: ${name}`;
conSurname.innerHTML=`Surname: ${surname}`;
conNumber.innerHTML=`PhoneNo: ${number}`;
conEmail.innerHTML=`Email: ${email}`;
conDate.innerHTML=`Date: ${SelectedDate}`;
conTime.innerHTML=`Time: ${selected_Data}`;
      }

  }


