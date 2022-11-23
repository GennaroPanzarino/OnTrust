<?php
session_start();
if (isset($_SESSION['logged']) && $_SESSION['logged'] == true) {
} else {
    $_SESSION['originpage']="add.php";
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
    <div id='one' class='current'>
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


    <a href="profile.php"><div id='four'>
            <i class="material-icons">person</i>
    </div>
    </a>

  </div>
  <div class='heading'>Dettaglio proposta</div>
    <div id='cover'>
      <div id='wrap'>
        <div id="coin-number"><div id='number'></div><i id='coin'>coin</i></div>
      </div>
    </div>
    <h3 id='artTitle'>Titolo</h3>
    <div id='artDate'></div>
    <p id='desc'>descrizione film</p>
    <div class='describe'>Aggiungi note alla candidatura</div>
    <textarea id='notes' placeholder='Aggiungi note alla candidatura, es:
          -luogo
          -Numero di telefono
          -Email di contatto'></textarea>
    <div class="prenota">Candidati</div>




    <script type="text/javascript">
    h = window.innerHeight;
  function displayWindowSize(){
    if(window.innerHeight<h){
      document.getElementById('tabs').style.display='none';
      h = window.innerHeight;
    }else{
      document.getElementById('tabs').style.display='block';
      h = window.innerHeight;
    }
  }
  window.addEventListener("resize", displayWindowSize);

    window.addEventListener('load',fetch,false);
    document.getElementsByClassName('prenota')[0].addEventListener('click',function(){explode(this)},false);


      function feedback()
      {
        if (req.readyState == 4 && req.status == 200) {
          if(req.response=="")
          {
            alert('Nessun contenuto disponibile');
        }else{
          risultati=JSON.parse(req.response);
          cover=document.getElementById('cover');
          titolo=document.getElementsByTagName('h3')[0];
            artBody=document.getElementById('desc');
            //newArt.childNodes[0].childNodes[1].childNodes[0].style.backgroundImage = "url('media/locandinapg1.jpg')";
            titolo.innerHTML=risultati['title'];
            artBody.innerHTML=risultati['body'];
            document.getElementById('number').innerHTML=risultati['price'];
            if(risultati['id']*1!==<?php if(isset($_SESSION['userid'])){echo $_SESSION['userid'];}else{echo $valore="'valore'";}?>){
            document.getElementById('artDate').innerHTML='Pubblicato il '+risultati['data'] + " da "+"<a href='publicProfile.php?id="+risultati['id']+"'>"+risultati['name']+" "+risultati['lastname']+"</a>";
          }else{
            document.getElementById('artDate').innerHTML='Pubblicato il '+risultati['data'] + " da "+"<a href='profile.php'>"+risultati['name']+" "+risultati['lastname']+"</a>";
          }
            cover.style.backgroundImage = "url('"+risultati['imgPath']+"')";
        }
      }
    }

      function fetch()
      {
        req=new XMLHttpRequest();
        req.open("POST","fillArt.php");
        req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        req.send("id="+ <?php echo $_GET['id'] ?>);
        req.onreadystatechange=feedback;
        }


function explode(a){
  a.innerHTML='Invia';
  a.id='enabled';
  document.getElementsByClassName('className')
  notes=document.getElementById('notes');
  notes.style.minHeight='70vw';
  notes.style.opacity=1;
  document.getElementsByClassName('describe')[0].style.opacity=1;
  document.getElementsByClassName('describe')[0].style.display='block';
  a.addEventListener('click',function(){sendAppl(this)},false);
}


function sendAppl(targ){
  if (targ.id='enabled') {
    appl=new XMLHttpRequest();
    appl.open("POST","sendAppl.php");
    appl.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    appl.send("userId="+ <?php echo $_SESSION["userid"]?> +"&idAnnuncio="+<?php echo $_GET['id'] ?>+"&note="+document.getElementById('notes').value);
    appl.onreadystatechange=feedback1;
  }
}



function feedback1()
{
  if (appl.readyState == 4 && appl.status == 200) {
    if(appl.response=="")
    {
      message="Candidatura inviata con successo.<br>Puoi controllare lo stato delle tue candidature dalla sezione attività";
      window.location="success.php?message="+message;
  }else{
    alert(appl.response);
  }
}
}

    </script>
</body>
