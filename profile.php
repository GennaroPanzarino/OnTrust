<?php
session_start();
if (isset($_SESSION['logged']) && $_SESSION['logged'] == true) {
} else {
    $_SESSION['originpage']="profile.php";
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


    <a href="#"><div id='four' class='current'>
            <i class="material-icons">person</i>
    </div>
    </a>

  </div>
  <div id='pane'>
<div id='propic' style="background-image: url('https://cdn.britannica.com/55/174255-050-526314B6/brown-Guernsey-cow.jpg');"></div>
<div id='username'>
  <?php
    echo $_SESSION['name'].'  '.$_SESSION['lastname'];
  ?>
</div>
  <div id='logout'>
        Logout
</div>
</div>
<div class='title'>Portafogli</div>
<div class='flex0'>
<div id='coinPic'></div>
<div id='coinDesc'>

<?php
$connessione_al_server=mysqli_connect("localhost","root","","fitnesstracking");
if(!$connessione_al_server){
die ('Non riesco a connettermi: errore '.mysqli_error()); // questo apparirà solo se ci sarà un errore
}
$db_selected=mysqli_select_db($connessione_al_server,"fitnesstracking"); // dove io ho scritto "prova" andrà inserito il nome del db
if(!$db_selected){
die ('Errore nella selezione del database: errore '.mysql_error()); // se la connessione non andrà a buon fine apparirà questo messaggio
}

$balance= mysqli_query($connessione_al_server,"SELECT balance FROM userdata WHERE id="."'".$_SESSION["userid"]."'")  //per selezionare nel db l'utente e pw che abbiamo appena scritto nel log
or DIE('query non riuscita'.mysqli_error($balance));
echo mysqli_fetch_assoc($balance)['balance'];
?>





</div>
</div>
<div class='flex'><div class='reputation-title'>Reputazione:</div><div id='reputation-label'>0%</div></div>
<div id='reputation'><div id='reputation-grow'></div></div>

<div class='title'>Problemi con l'app?</div>
<a href="https://t.me/onTrust_bot"><div class='telegram'>Assistenza telegram</div></a>
<script type="text/javascript">
var logmeout=document.getElementById("logout");
logmeout.addEventListener("click",logout,false);


function logout()
{
    var cnfrm = confirm("Vuoi uscire dall'account?");
    if(cnfrm) {
        // here redirect to `logout.php`
        window.location.href = 'logmeout.php';
    }
}




window.addEventListener("load",function(){reputation(0)},false);
function reputation(opt){
req1=new XMLHttpRequest();
req1.open("POST","reputation.php");
req1.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
req1.send("id="+<?php echo $_SESSION["userid"] ?>+"&option="+opt);
req1.onreadystatechange=feedback1;
}
function feedback1()
{
  if (req1.readyState == 4 && req1.status == 200) {
    if(req1.response=="")
    {
  }else {
    risultati=JSON.parse(req1.response);
    if(risultati["avg"]== null){risultati["avg"]=100}
    document.getElementById('reputation-grow').style.width=Math.round(risultati["avg"])+"%";
    document.getElementById('reputation-label').innerHTML=Math.round(risultati["avg"])+"%";
    }
  }
}
</script>
</body>
