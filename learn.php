<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    body{
	margin: 0;
	padding: 0;
	background: #ccc;
	
}
   /*load onclick*/
.loader {
	z-index: 1000;
	position:fixed;
	top:0;
	left:0;
	width:100vw;
	height:100vh;
	display:flex;
	justify-content: center;
  align-items: center;
  background-color: #f7f9fb;
  transition: opacity 0.75s, visibility 0.75s;

  }

  .loader-hidden{
	opacity: 0;
	visibility: hidden;
  }

  .loader::after{
	content:"";
	width:75px;
	height: 75px;
	border:15px solid #dddddd;
	border-top-color: #7449f5;
	border-radius: 50%;
	animation:loading 1.75s ease infinite;

  }
  
  @keyframes loading {
	from{
		transform: rotate(0turn);
	}
	to{
		transform:rotate(1turn);
	}
  }
  
  </style>
</head>
<body>
<div class="loader"></div>
</body>
</html>