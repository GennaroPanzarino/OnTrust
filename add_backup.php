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
    <div id='one'>
      <i class="material-icons">explore</i>
    </div>
    </a>


    <a href="#">
    <div id='two' class='current'>
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
  <div class='heading'>Fai una proposta</div>
    <input type="text" id='offer-title' placeholder="Titolo della tua proposta"/>
    <textarea id='offer-body' placeholder="Descrizione della tua proposta"></textarea/>
      <div class='container'>
        <input type="text" id='price' placeholder="0"/>
        <button id='file-upload'><i class="material-icons" id='camera'>add_a_photo</i></button>
        <div id='imgPrev'></div>
        <input type="file" accept="image/jpeg" onchange="" id='file' placeholder="Aggiungi un'immagine"/>
      </div>
    <button id='invia'>Pubblica annuncio</button>




    <script>
    var title=document.querySelector("input[type=text]");
    var body=document.getElementsByTagName('textarea')[0];
    var price=document.getElementById("price");
    var bottone=document.getElementById("invia");
    bottone.addEventListener("click",invia,false);

    function feedback()
    {
      if (req.readyState == 4 && req.status == 200) {
        if(req.response=="")
        {
          message="Annuncio pubblicato con successo.<br>Puoi controllare i tuoi annunci dalla sezione attività";
          window.location="success.php?message="+message;
      }else if(req.response==1){
        window.location="login.php";
      }
      else if(req.response==2){
      alert("Per pubblicare l'annuncio devi disporre di un credito coin almeno pari al numero di coin richiesti");
      }
      }
    }

    function invia()
    {
      if (title.value !== "" && body.value !== "") {
      req=new XMLHttpRequest();
      req.open("POST","addArt.php");
      req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      req.send("title="+ title.value+"&body="+body.value+"&price="+price.value);
      req.onreadystatechange=feedback;
      }
      else
      {
        alert("I campi non possono essere lasciati vuoti");
      }
    }


document.getElementById("file-upload").addEventListener('click',function(){
  document.getElementById('file').click();
},false);



function previewFile() {
var preview = document.getElementById('imgPrev');
var file    = document.querySelector('input[type=file]').files[0];
var reader  = new FileReader();

reader.onloadend = function () {
  preview.style.backgroundImage  = "url('"+reader.result+"')";
}

if (file) {
  preview.classList.add('imgPrev');
  reader.readAsDataURL(file);
} else {
  preview.src = "";
}
}



//window.oncontextmenu = function() { return false; }
    </script>

</body>
