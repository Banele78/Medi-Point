const cuurentDate=document.querySelector(".current-date"),
daysTag=document.querySelector(".days"),
prevNextIcon=document.querySelectorAll(".icons span");


let date=new Date(),
currYear=date.getFullYear(),
currMonth=date.getMonth();

const months=["January", "February", "March", "April", "May", "June", "July", "August", "Septemper",
"October", "November", "December"];

let firstDayofMonth=new Date(currYear,currMonth,1).getDay();//getting first day of month

const renderCalendar=()=>{
   
     let lastDateOfMonth=new Date(currYear,currMonth+1,0).getDate(),//getting last date of month
     lastDayOfMonth=new Date(currYear,currMonth,lastDateOfMonth).getDay(),//getting last day of month
     lastDateOfLastMonth=new Date(currYear,currMonth,0).getDate();//getting last date of previos month
   let liTag="";

   for(let i=firstDayofMonth ;i > 0; i--){//Creating li of previos month last days
    liTag +=`<li class="inactive">${lastDateOfLastMonth-i+1}</li>`;

}

    for(let i=1;i<=lastDateOfMonth;i++){//creating li of all days of current month
        console.log(i);
        //adding active class to li if the currentday, month, and year matched.
        let isToday =i ===date.getDate() && currMonth === new Date().getMonth()
                    && currYear === new Date().getFullYear() ? "active" : "";
                    liTag += `<li class="${isToday}" onclick="handleDateClick(${i})">${i}</li>`;

    }

    for(let i=lastDayOfMonth; i < 6 ;i++){//creating li of next month first days
        liTag +=`<li class="inactive">${i - lastDayOfMonth + 1}</li>`;

    }
    cuurentDate.innerText=`${months[currMonth]} ${currYear}`;
    daysTag.innerHTML=liTag

}

renderCalendar();

prevNextIcon.forEach(icon =>{
    icon.addEventListener("click", ()=>{ //adding click event on both icons
        //if clicked icon is previous icon then decrement current month by 1 else increment it by 1
        currMonth=icon.id==="prev" ? currMonth -1 : currMonth +1;

        if(currMonth <0 ||currMonth > 11){//if current month is less than 0 or greater than 11
            //creating a new date of current year & month and pass it as date value
            date=new Date(currYear,currMonth);
            currYear=date.getFullYear();//updating current year with new date year
            currMonth=date.getMonth();//updating current month with new date month
        }else{
            date=new Date();
        }
        renderCalendar();
    })

});

function formatDate(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0'); // Month is zero-based
    const day = String(date.getDate()).padStart(2, '0');
    
    return `${year}-${month}-${day}`;
}


function handleDateClick(day) {
    // Replace this with your desired action when a date is clicked
    const clickedDate = new Date(currYear, currMonth, day);
    
    // Remove existing 'active' class from all dates
    document.querySelectorAll('.days li').forEach(li => li.classList.remove('active'));

    // Find the clicked date's <li> element and add the 'active' class
    const clickedDateElement = document.querySelector(`.days li:nth-child(${day + firstDayofMonth})`);
    clickedDateElement.classList.add('active');

    // Log the formatted date to the console
   console.log("Clicked Date:", formatDate(clickedDate));

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
                    result.innerHTML = "No data found";
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

    selected_Data = null;
}

let selected_Data = null; // Initialize the selected data as null
// Attach the click event listener to a parent element (document in this case)
document.addEventListener('click', function (event) {
    const time_buttons = document.querySelectorAll('.time-button');
const selected_Option = document.getElementById('selected_Option');


    if (event.target.classList.contains('time-button')) {
        if (!event.target.classList.contains('Timeselected')) {
            time_buttons.forEach(btn => btn.classList.remove('Timeselected'));
            event.target.classList.add('Timeselected');
            selected_Data = event.target.textContent;
            
            console.log(selected_Data)
        }
    }
});



