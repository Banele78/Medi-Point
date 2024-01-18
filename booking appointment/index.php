<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="index.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:wght@100..700&family=Material+Symbols+Rounded:opsz@20..48&family=Material+Symbols+Rounded:FILL,GRAD@0..1,-50..200">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
     integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
      crossorigin="anonymous" referrerpolicy="no-referrer" />
   

</head>
<body>
    <div class="book" >
    <div class="wrapper">
        <header>
            <p class="current-date"></p>
            <div class="icons">
                <span id="prev" class="material-symbols-rounded">chevron_left</span>
                <span id="next" class="material-symbols-rounded">chevron_right</span>

            </div>
        </header>
        <div class="calendar">
            <ul class="weeks">
                <li>Sun</li>
                <li>Mon</li>
                <li>Tue</li>
                <li>Wed</li>
                <li>Thu</li>
                <li>Fri</li>
                <li>Sat</li>
            </ul>
            <ul class="days">
               
                
                
            </ul>

        </div>
    </div>
    
    <div class="wrapper2">
    
    <div class="TimeHeader">
    <div class="toggle_btn">
 <i class="fa-solid fa-xmark" id="close" onclick="setVariableToNull()"></i>
</div>

        <p>Please select date and time</p>
    </div>
        <div id="SelectedDate"></div>
        <div id="SelectedTime"></div>
       
        <br>
        <div class="time" id="searchresult" >
        
        
</div>

<button class="SelectedDayTime" onclick="submitDayTime()">Done</button>
    </div>
</div>

<div class="form">
    
        <div class="formInput">
            <div id="ValidName"></div>
            <label for="name">Name</label>
            <input type="text" name="name" placeholder="Please enter name" id="name">
        </div>
        <div class="formInput">
        <div id="ValidSurname"></div>
            <label for="surname">Surname</label>
            <input type="text" name="surname" placeholder="Please enter surname" id="surname">
        </div>
        <div class="formInput">
        <div id="ValidNumber"></div>
            <label for="number">Number</label>
            <input type="text" name="number" placeholder="Please enter mobile number" id="number">
        </div>
        <div class="formInput">
        <div id="ValidEmail"></div>
            <label for="email">Email</label>
            <input type="text" name="email" placeholder="Please enter email" id="email">
        </div>
        <div class="formInput">
        <div id="ValidDate"></div>
    <button id="DateTime" >Select date and time</button>
    </div>
    
        <div class="formInput">
        <div id="SelectedDate1"></div>
        <div id="SelectedTime1"></div>
      
    </div>

    <img src="image.png" class="image">
        

    <div class="formInput">
    <button id="submit" onclick="Next()">Next</button>
    </div>

</div>


    <script src="index.js" defer></script> 
</body>

</html>