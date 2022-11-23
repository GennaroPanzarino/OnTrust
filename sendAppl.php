<?php
session_start();
if (isset($_SESSION['logged']) && $_SESSION['logged'] == true) {
} else {
}

$connessione_al_server=mysqli_connect("localhost","root","","fitnesstracking");
if(!$connessione_al_server){
die ('Non riesco a connettermi: errore '.mysqli_error()); // questo apparirà solo se ci sarà un errore
}
$db_selected=mysqli_select_db($connessione_al_server,"fitnesstracking"); // dove io ho scritto "prova" andrà inserito il nome del db
if(!$db_selected){
die ('Errore nella selezione del database: errore '.mysql_error()); // se la connessione non andrà a buon fine apparirà questo messaggio
}
date_default_timezone_set('Europe/Vatican');

//INVIO LA CANDIDATURA SOLO SE L'ANNUNCIO NON E' MIO
$idValue="SELECT userId FROM ads WHERE id="."'".$_POST['idAnnuncio']."'";
$idCheckValue = mysqli_query($connessione_al_server,$idValue);
if (mysqli_fetch_assoc($idCheckValue)['userId']*1 !== $_SESSION["userid"]*1){
  $richiesta="INSERT INTO applications (userId,idAnnuncio,note,dataCandidatura) VALUES ("."'".   $_POST['userId']  ."','".     $_POST['idAnnuncio']  ."','".  $_POST['note']  ."','".    date("d/m/Y H:i") ."'".")";
  $query = mysqli_query($connessione_al_server,$richiesta)  //per selezionare nel db l'utente e pw che abbiamo appena scritto nel log
  or DIE('query non riuscita'.mysqli_error($connessione_al_server));
}else{
  $msg="Non puoi candidarti ai tuoi annunci";
  echo $msg;
}

?>
