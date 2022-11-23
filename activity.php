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

  <div href="" class='film_wrap'><div id='hidden'><div class='author_cont'><div class='artPropic'></div><div class='author'></div><div class='date'></div><div class='filler'></div><div class="priceTag"></div><div id='artCoin'></div></div><div class='content'><div class='thumbnail'></div><div class='textualContent'><h3>Titolo</h3><p>Body</p></div></div><a id="openOut" href="">Vedi annuncio completo</a><div id='candNotes'>Note alla candidatura</div><div id='candNotesBox'>Sample Notes</div></div></div>
  <div href="" class='film_wrap1'><div id='hidden'><div class='author_cont'><div class='artPropic'></div><div class='author'></div><div class='date'></div><div class='filler'></div><div class="priceTag"></div><div id='artCoin'></div></div><div class='content'><div class='thumbnail'></div><div class='textualContent'><h3>Titolo</h3><p>Body</p></div></div><a id="openOut" href="">Vedi annuncio completo</a><div id='candNotes'>Note alla candidatura</div><div id='candNotesBox'>Sample Notes</div><div id='actionPanel'><a href="javascript:void(0);"><i class="material-icons" id='accept'>handshake</i><i class="material-icons" id='decline'>close</i></a></div></div></div>
  <div href="" class='film_wrap2'><div id='hidden'><div class='author_cont'><div class='artPropic'></div><div class='author'></div><div class='date'></div><div class='filler'></div><div class="priceTag"></div><div id='artCoin'></div></div><div class='content'><div class='thumbnail'></div><div class='textualContent'><h3>Titolo</h3><p>Body</p></div></div><a href="" id="openOut">Vedi annuncio completo</a><div id='candNotes'>Note alla candidatura</div><div id='candNotesBox'>Sample Notes</div><div id='actionPanel'><a href="javascript:void(0);"><i class="material-icons" id='unlock'>credit_score</i></a></div></div></div>
<div class='title'>Le tue candidature</div>
<div id='candidatureInviate'>Non hai inviato candidature</div>
<div class='title'>Candidature Ricevute</div>
<div id='candidatureRicevute'>Non hai ricevuto candidature</div>
<div class='title'>Trattative</div>
<div id='trattative'>Non ci sono trattative in corso</div>
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
        lunghezza1=Object.keys(risultati[0]).length;
        lunghezza2=Object.keys(risultati[1]).length;
        lunghezza3=Object.keys(risultati[2]).length;




newArt=0;
newArt1=0;
newArt2=0;
        for(let i=0;i<lunghezza1;i++){
          newArt=document.getElementsByClassName('film_wrap')[0].cloneNode(true);
          document.getElementById('candidatureInviate').appendChild(newArt);
          newArt.className='film_wrap';
          newArt.childNodes[0].id='film1';
          newArt.childNodes[0].childNodes[2].href='article.php'+'?id='+risultati[0][i]['id'];
          newArt.childNodes[0].childNodes[0].childNodes[1].innerHTML=risultati[0][i]['name']+" "+risultati[0][i]['lastname'];
          newArt.childNodes[0].childNodes[0].childNodes[2].innerHTML=risultati[0][i]['data'];
          newArt.childNodes[0].childNodes[0].childNodes[4].innerHTML=risultati[0][i]['price'];
          newArt.childNodes[0].childNodes[1].childNodes[0].style.backgroundImage ="url('"+risultati[0][i]['imgPath']+"')";
          newArt.childNodes[0].childNodes[1].childNodes[1].childNodes[0].innerHTML=risultati[0][i]['title'];
          newArt.childNodes[0].childNodes[1].childNodes[1].childNodes[1].innerHTML=risultati[0][i]['body'];
          newArt.childNodes[0].childNodes[4].innerHTML=risultati[0][i]['note']+"<br>"+accepted();
          function accepted(){
            if(risultati[0][i]['accepted']==1 && risultati[0][i]['completed']==0){
              return "<strong>Stato</strong>: accettata";
            }else if(risultati[0][i]['accepted']==0 && risultati[0][i]['completed']==0){
              return "<strong>Stato</strong>: in attesa";
          }else if(risultati[0][i]['accepted']==2 && risultati[0][i]['completed']==0){
            return "<strong>Stato</strong>: rifiutata";
        }else if(risultati[0][i]['completed']==1){
          return "Candidiatura rifiutata dal sistema perchè l'autore dell'annuncio ha scelto un'altra candidatura";
        }
        }
      }

      for(let j=0;j<lunghezza2;j++){
        newArt1=document.getElementsByClassName('film_wrap1')[0].cloneNode(true);
        document.getElementById('candidatureRicevute').appendChild(newArt1);
        newArt1.className='film_wrap';
        newArt1.childNodes[0].id='film1';
        newArt1.childNodes[0].childNodes[2].href='article.php'+'?id='+risultati[1][j]['id'];
        newArt1.childNodes[0].childNodes[0].childNodes[1].innerHTML=risultati[1][j]['name']+" "+risultati[1][j]['lastname'];
        newArt1.childNodes[0].childNodes[0].childNodes[2].innerHTML=risultati[1][j]['data'];
        newArt1.childNodes[0].childNodes[0].childNodes[4].innerHTML=risultati[1][j]['price'];
        newArt1.childNodes[0].childNodes[1].childNodes[0].style.backgroundImage = "url('"+risultati[1][j]['imgPath']+"')";
        newArt1.childNodes[0].childNodes[1].childNodes[1].childNodes[0].innerHTML=risultati[1][j]['title'];
        newArt1.childNodes[0].childNodes[1].childNodes[1].childNodes[1].innerHTML=risultati[1][j]['body'];
        newArt1.childNodes[0].childNodes[3].innerHTML=risultati[1][j]['note'];
        //codice per aggiungere il listener dei click sui bottoni di azione rispetto all'annuncio
        newArt1.childNodes[0].childNodes[5].childNodes[0].childNodes[0].addEventListener('click',function(){accept(this.parentNode,risultati[1][j]['idAnnuncio'])},false);
        newArt1.childNodes[0].childNodes[5].childNodes[0].childNodes[1].addEventListener('click',function(){decline(this.parentNode.parentNode.parentNode,risultati[1][j]['idAnnuncio'])},false);
    }


    for(let k=0;k<lunghezza3;k++){
      newArt2=document.getElementsByClassName('film_wrap2')[0].cloneNode(true);
      document.getElementById('trattative').appendChild(newArt2);
      newArt2.className='film_wrap';
      newArt2.childNodes[0].id='film1';
      newArt2.childNodes[0].childNodes[2].href='article.php'+'?id='+risultati[2][k]['id'];
      newArt2.childNodes[0].childNodes[0].childNodes[1].innerHTML=risultati[2][k]['name']+" "+risultati[2][k]['lastname'];
      newArt2.childNodes[0].childNodes[0].childNodes[2].innerHTML=risultati[2][k]['data'];
      newArt2.childNodes[0].childNodes[0].childNodes[4].innerHTML=risultati[2][k]['price'];
      newArt2.childNodes[0].childNodes[1].childNodes[0].style.backgroundImage = "url('"+risultati[2][k]['imgPath']+"')";
      newArt2.childNodes[0].childNodes[1].childNodes[1].childNodes[0].innerHTML=risultati[2][k]['title'];
      newArt2.childNodes[0].childNodes[1].childNodes[1].childNodes[1].innerHTML=risultati[2][k]['body'];
      newArt2.childNodes[0].childNodes[4].innerHTML=risultati[2][k]['note'];
      if(risultati[2][k]['completed']==1){
        newArt2.childNodes[0].childNodes[5].childNodes[0].innerHTML='Trattativa completata';
      }
      newArt2.childNodes[0].childNodes[5].childNodes[0].childNodes[0].addEventListener('click',function(){unlock(this,risultati[2][k]['idAnnuncio'],risultati[2][k]['userId'],risultati[2][k]['price'])},false);
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

window.addEventListener('load',function(){setTimeout(ad, 30000000)},false);
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
function accept(parent,a){

  parent.innerHTML='Status: Hai accettato la proposta';
  areq=new XMLHttpRequest();
  areq.open("POST","acceptDeclineUnlock.php");
  areq.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  areq.send("operation="+0+"&idAnnuncio="+a);
}
function decline(a,b){
    a.parentNode.removeChild(a);
    dreq=new XMLHttpRequest();
    dreq.open("POST","acceptDeclineUnlock.php");
    dreq.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    dreq.send("operation="+1+"&idAnnuncio="+b);
}
function unlock(a,b,c,d){
    unreq=new XMLHttpRequest();
    unreq.open("POST","acceptDeclineUnlock.php");
    unreq.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    unreq.send("operation="+2+"&idAnnuncio="+b+"&userId="+c+"&price="+d);
    unreq.onreadystatechange=unreqFeedback;
    a.parentNode.innerHTML='Hai erogato il pagamento';
}
function unreqFeedback()
{
  if (unreq.readyState == 4 && unreq.status == 200) {
    if(unreq.response=="")
    {
  }else{
    alert(unreq.response);
}}}
  </script>
</body>
