<?php
session_start();
if (isset($_SESSION['logged']) && $_SESSION['logged'] == true) {
} else {
    $_SESSION['originpage']="activity.php";
    header('location:login.php');
}
?>
<head>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<meta name="viewport" content="user-scalable=no"/>
<style>@import url("style.css");</style>
</head>
<body>
  <div id='tabs'>

    <a href="index.php">
    <div id='one'>
      <i class="material-icons">explore</i>
    </div>
    </a>


    <a href="add.php">
    <div id='two'>
            <i class="material-icons">add_circle_outline</i>
    </div>


    </a>
    <a href="activity.php">
    <div id='three'>
            <i class="material-icons">book</i>
    </div>
    </a>


    <a href="profile.php"><div id='four' class='current'>
            <i class="material-icons">person</i>
    </div>
    </a>

  </div>
  <div id='pane'>
<div id='propic' style="background-image: url('media/account.svg');"></div>
<div id='username'>
</div>

  <div id='leaveReview'>
</div>
</div>
</div>
<div class='flex'><div class='reputation-title'>Reputazione:</div><div id='reputation-label'></div></div>
<div id='reputation'><div id='reputation-grow'></div></div>
<div id='reputation2'></div>
<div class='title'>Lascia una valutazione</div>
<input id="range" min="-5" max="5" type="range" value="0" />
<div class='title'>Problemi con l'utente?</div>
<a href="https://t.me/onTrust_bot"><div class='telegram'>Assistenza telegram</div></a>

<script type="text/javascript">

//REPERIMENTO NOME E COGNOME UTENTE
req=new XMLHttpRequest();
req.open("POST","profData.php");
req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
req.send("id="+<?php echo $_GET["id"] ?>+"&value="+this.value+"&option="+0);
req.onreadystatechange=feedback;

function feedback()
{
  if (req.readyState == 4 && req.status == 200) {
    if(req.response=="")
    {
      alert('Nessuna info disponibile');
  }else{
    risultati=JSON.parse(req.response);
      document.getElementById('username').innerHTML=risultati['name']+" "+risultati["lastname"];
  }
}
}

//CHIAMO REPUTATION CON OPZIONE 0 AL CARICAMENTO DELLA PAGINA
window.addEventListener('load',function(){reputation(0);reputation1(0)},false);


//CODICE RATING
document.getElementById("range").addEventListener('input',function(){
var value = (this.value-this.min)/(this.max-this.min)*100;
this.style.background = 'linear-gradient(to right, green 0%, green ' + value + '%, #c5c5c5 ' + value + '%, #c5c5c5 100%)';},false);
document.getElementById("range").addEventListener('touchend',function(){reputation(this,1);},false);
document.getElementById("range").addEventListener('mouseup',function(){reputation(this,1);},false);


function reputation(a,opt){
//reputation calcolata con media
req1=new XMLHttpRequest();
req1.open("POST","reputation.php");
req1.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
req1.send("id="+<?php echo $_GET["id"] ?>+"&value="+a.value+"&option="+opt);
req1.onreadystatechange=feedback1;
//reputation calcolata con algoritmo speciale
req2=new XMLHttpRequest();
req2.open("POST","reputation2.php");
req2.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
req2.send("id="+<?php echo $_GET["id"] ?>);
req2.onreadystatechange=feedback2;
}


function reputation1(opt){
//reputation calcolata con media
req3=new XMLHttpRequest();
req3.open("POST","reputation2.php");
req3.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
req3.send("id="+<?php echo $_GET["id"] ?>+"&option="+opt);
req3.onreadystatechange=feedback0;
}
function feedback0()
{
  if (req3.readyState == 4 && req3.status == 200) {
    if(req3.response=="")
    {
  }else {
    risultati=JSON.parse(req3.response);
    element=document.getElementById("range");
    element.setAttribute("value",risultati["currentRating"]);
    var value = (element.value-element.min)/(element.max-element.min)*100;
    document.getElementById("range").style.background= 'linear-gradient(to right, green 0%, green ' + value + '%, #c5c5c5 ' + value + '%, #c5c5c5 100%)';
    }
  }
}

function feedback1()
{
  if (req1.readyState == 4 && req1.status == 200) {
    if(req1.response=="")
    {
  }else {
    risultati=JSON.parse(req1.response);
    if(risultati["avg"]== null){risultati["avg"]=100};
    document.getElementById('reputation-grow').style.width=Math.round(risultati["avg"]*10)+50+"%";
    document.getElementById('reputation-label').innerHTML=Math.round(risultati["avg"]);
    }
  }
}


function feedback2()
{
  if (req2.readyState == 4 && req2.status == 200) {
    if(req2.response=="")
    {
  }else {
    risultati=JSON.parse(req2.response);

    if(risultati["reputation"]== null){risultati["reputation"]=100}
    document.getElementById('reputation2').innerHTML="Reputazione con algoritmo ponderato: "+Math.round(risultati["reputation"]);
    }
  }
}

</script>
</body>
