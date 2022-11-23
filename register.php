<?php
session_start();
?>
<html>
<head>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<meta name="viewport" content="user-scalable=no"/>
<style>@import url("style.css");</style>
<style>
html,body
{
width:100vw;
height:100vh;
overflow:hidden;
background:url("coding.jpeg");
background-size:230%;
text-align:center;
margin:0;
font-family:Arial;
}
#email::before
{
content:"E-mail";
}
#password::before
{
content:"Password";
}
form
{
position:absolute;
width:100vw;
padding:2rem 0 0 0;
top: 50%;
left:50%;
transform:translate3d(-50%,-50%,0);
background:#88c783;
border-radius:.2rem .2rem .3rem .3rem;
user-select:none;
overflow:hidden;
}
form:before
{
content:"Accedi al tuo account";
font:3.5em Arial;
color: whitesmoke;
margin-bottom:1em;
}
form input
{
outline:none;
height:6rem;
width:80%;
font:normal normal lighter 3rem "Arial";
padding:0 2% 0 2%;
border:none;
box-shadow:0px 0px 2px 0px rgba(128, 128, 128, 0.25);
}
form input:-webkit-autofill
{
border:1px solid grey;
background:red;
}
form input:first-child
{
margin:2rem 0 3rem 0;
}
#submit
{
-webkit-appearance:none;
border:none;
background:#50a050;
color:white;
margin-top:2rem;
cursor:pointer;
color:white;
outline:none;
height:7rem;
width:80%;
font:normal normal lighter 3rem "Arial";
padding:0 2% 0 2%;
border-radius:999px;
transition:all .1s;
}
#submit:active
{
background:#438243;
}
::placeholder
{
text-align: center;
user-select:none;
}
input::placeholder:active
{
display:none;
}
#quest{
  font-size:2.3em;
}
</style>




</head>
<body>
<form id='auth'>
<input type="text" placeholder="Nome" spellcheck="false" id="name" value=''>
<input type="text" placeholder="Cognome" spellcheck="false" id="surname" value=''>
<input type="tel" placeholder="Numero di telefono" spellcheck="false" id="tel" value=''>
<input type="number" placeholder="Età" spellcheck="false" id="age" value=''>
<input type="email" placeholder="Email" spellcheck="false" id="email" value=''>
<input type="password" placeholder="password" spellcheck="false" id="password" value=''>

<input type="button" value="Registrati" id="submit">
<p id="quest">Hai già un account? <a href="login.php">Accedi</a></p>
</form>



<div id='tabs'>

  <a href="index.php">
  <div id='one'>
    <i class="material-icons">theaters</i>
  </div>
  </a>


  <a href="seats.php">
  <div id='two'>
          <i class="material-icons">explore</i>
  </div>


  </a>
  <a href="Profile.html">
  <div id='three'>
          <i class="material-icons">book</i>
  </div>
  </a>


  <a href="#"><div id='four'>
          <i class="material-icons">person</i>
  </div>
  </a>

</div>
<script>
var lastname=document.getElementById('surname');
var firstname=document.getElementById('name');
var tel=document.querySelector("input[type=tel]");
var age=document.querySelector("input[type=number]")
var username=document.querySelector("input[type=email]");
var password=document.querySelector("input[type=password]");
var bottone=document.getElementById("submit");
bottone.addEventListener("click",invia,false);

function feedback()
{
  if (req.readyState == 4 && req.status == 200) {
    if(req.response=="")
    {
      message="Utente registrato con successo.<br>Puoi fare login per iniziare a usare l'app!";
      window.location="success.php?message="+message;
  }else {
  alert(req.response);
  }
  }
}

function invia()
{
  if (username.value !== "" && password.value !== "") {
  req=new XMLHttpRequest();
  req.open("POST","addUser.php");
  req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  req.send("username="+ username.value+"&password="+password.value+"&tel="+tel.value+"&name="+firstname.value+"&lastname="+lastname.value+"&age="+age.value);
  req.onreadystatechange=feedback;
  }
  else
  {
    alert("I campi non possono essere lasciati vuoti");
  }
}

</script>
</body>
</html>
