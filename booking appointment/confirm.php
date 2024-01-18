<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="index.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="ConfirmInfo">
        <h1>Confirm Information</h1>
       
        <p id="conName" class="confirm"></p>
        <p id="conSurname" class="confirm"></p>
        <p id="conNumber" class="confirm"></p>
        <p id="conEmail" class="confirm"></p>
        <p id="conDate" class="confirm"></p>
        <p id="conTime" class="confirm"></p>

        <button id="submit" onclick="addappointment()">Submit</button>
    </div>
    <script src="index.js" defer></script> 
    <script>
        // Ensure the script.js file is loaded before calling retrieveInputValues
        window.onload = function() {
            retrieveInputValues();
        };
    </script>
</body>
</html>