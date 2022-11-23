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
<meta name="viewport" content="user-scalable=no">
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
    <div id='three' class='current'>
            <i class="material-icons">book</i>
    </div>
    </a>


    <a href="profile.php"><div id='four'>
            <i class="material-icons">person</i>
    </div>
    </a>

  </div>
  <div class='heading'>La tua attività</div>

  <a href="" class='film_wrap'><div id='hidden'><div class='author_cont'><div class='artPropic'></div><div class='author'></div><div class='date'></div><div class='filler'></div><div class="priceTag"></div><div id='artCoin'></div></div><div class='content'><div class='thumbnail'></div><div class='textualContent'><h3>Titolo</h3><p>Body</p></div></div><div id='candNotes'>Note alla candidatura</div><div id='candNotesBox'>Sample Notes</div></div></a>

<div class='title'>Le tue candidature</div>
<div id='candidatureInviate'></div>
<div class='title'>Candidature Ricevute</div>
<div id='candidatureRicevute'></div>
<div class='title'>Trattative in corso</div>
<div id='trattative'></div>
  <script type="text/javascript">
    //document.getElementById('search-button').addEventListener('click',
    //function(){
    //document.getElementsByClassName('find')[0].classList.toggle("find-active");
  //});

    window.addEventListener('load',fetch,false);


    function feedback()
    {
      if (req.readyState == 4 && req.status == 200) {
        if(req.response=="")
        {
          alert('Non ci sono annunci');
      }else{
        document.body.style.paddingTop='15vh';
        risultati=JSON.parse(req.response);
        lunghezza=Object.keys(risultati[0]).length;
        for(let i=0;i<lunghezza;i++){
          newArt=document.getElementsByClassName('film_wrap')[0].cloneNode(true);
          document.getElementById('candidatureInviate').appendChild(newArt);
          newArt.className='film_wrap';
          newArt.childNodes[0].id='film';
          newArt.href='article.php'+'?id='+risultati[i]['id'];
          newArt.childNodes[0].childNodes[0].childNodes[1].innerHTML=risultati[i]['name']+" "+risultati[i]['lastname'];
          newArt.childNodes[0].childNodes[0].childNodes[2].innerHTML=risultati[i]['data'];
          newArt.childNodes[0].childNodes[0].childNodes[4].innerHTML=risultati[i]['price'];
          newArt.childNodes[0].childNodes[1].childNodes[0].style.backgroundImage = "url('media/locandinapg1.jpg')";
          newArt.childNodes[0].childNodes[1].childNodes[1].childNodes[0].innerHTML=risultati[i]['title'];
          newArt.childNodes[0].childNodes[1].childNodes[1].childNodes[1].innerHTML=risultati[i]['body'];
          newArt.childNodes[0].childNodes[3].innerHTML=risultati[i]['note'];
      }
      }
    }
  }

    function fetch()
    {
      req=new XMLHttpRequest();
      req.open("POST","fetchMyData.php");
      req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      req.send("tipoRichiesta="+ 1);
      req.onreadystatechange=feedback;
      }

window.addEventListener('load',setTimeout(ad, 30000000),false);
function ad(){
  adPane=document.createElement('div');
  adPane.id='adPane';
  document.body.appendChild(adPane);
  adPopup=document.createElement('div');
  adPopup.id='adPopup';
  adPane.appendChild(adPopup);
  document.body.style.overflow='hidden';
  adClose=document.createElement('div');
  adClose.id='adClose';
  adClose.innerHTML='Chiudi annunci';
  adPane.appendChild(adClose);
  adClose.addEventListener('click',function(){hide(adPane,adPopup,adClose)},false);
}

function hide(a,b,c){
a.style.opacity=0;
a.style.display='none';
document.body.style.overflow='visible';
setTimeout(function(){a.style.display='flex';a.style.opacity=1;document.body.style.overflow='hidden';}, 20000);

}

  </script>
</body>
