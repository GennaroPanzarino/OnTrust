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
<select required id="category">
  <option value="" disabled selected >Categoria</option>
  <option value="0">Illustrazioni / Arti figurative</option>
  <option value="1">Lavori domestici</option>
  <option value="2">Condivisione tragitto</option>
  <option value="3">Pagamento bollette (su commissione)</option>
  <option value="4">Lezioni</option>
  <option value="5">Delivery</option>
  <option value="6">Attività turistica</option>
</select>

    <input type="text" id='offer-title' placeholder="Titolo della tua proposta"/>
    <textarea id='offer-body' placeholder="Descrizione della tua proposta"></textarea/>
      <div class='container'>
        <input type="text" id='price' placeholder="0"/>
        <button id='file-upload'><i class="material-icons" id='camera'>add_a_photo</i></button>
        <div id='imgPrev'></div>
        <input type="file" name="myFile" accept="image/jpeg" onchange="previewFile()" id='file' placeholder="Aggiungi un'immagine"/>
      </div>
    <button id='invia'>Pubblica annuncio</button>




    <script>
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
  
    function waiter(){
      loader=document.createElement('div');
      loader.id='loader';
      document.body.appendChild(loader);
    }

    var title=document.querySelector("input[type=text]");
    var body=document.getElementsByTagName('textarea')[0];
    var price=document.getElementById("price");
    var category=document.getElementById("category");
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

    //definisco imgUrl per renderla accessibile
    imgUrl="media/defaultPic.jpg";
    async function invia()
    {
      if (title.value !== "" && body.value !== "" &&category.value!=="") {
        if(document.querySelector('input[type=file]').files[0]){ //se ho scelto un file
          var file= document.querySelector('input[type=file]').files[0];
          var fd = new FormData();
          fd.append("myFile", file);
          xmlHTTP = new XMLHttpRequest();
          xmlHTTP.open("POST", "imgUpload1.php", true);
          xmlHTTP.send(fd);
          xmlHTTP.onreadystatechange=uploadFeedback;

            function delayMe(){
              waiter();
              if(imgUrl!=="media/defaultPic.jpg"){
              req=new XMLHttpRequest();
              req.open("POST","addArt.php");
              req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
              req.send("title="+ title.value+"&body="+body.value+"&price="+price.value+"&imgUrl="+imgUrl+"&category="+category.value);
              req.onreadystatechange=feedback;
              document.body.removeChild(document.getElementById('loader'));

            }else{
              setTimeout(delayMe,3000);
            }
          }
        delayMe();

      }else{      //se non ho scelto un file procedo normalmente
        req=new XMLHttpRequest();
        req.open("POST","addArt.php");
        req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        req.send("title="+ title.value+"&body="+body.value+"&price="+price.value+"&imgUrl="+imgUrl+"&category="+category.value);
        req.onreadystatechange=feedback;
      }

    }else{
  alert("I campi non possono essere lasciati vuoti");
}
  }

    function uploadFeedback()
    {
      if (xmlHTTP.readyState == 4 && xmlHTTP.status == 200) {
        if(xmlHTTP.response=="")
        {
          alert("not uploaded");
      }else{
        imgUrl=xmlHTTP.response;
      }
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
    </script>

</body>
