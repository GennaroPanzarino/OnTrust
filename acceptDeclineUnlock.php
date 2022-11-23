<?php
session_start();
$connessione_al_server=mysqli_connect("localhost","root","","fitnesstracking");
if(!$connessione_al_server){
die ('Non riesco a connettermi: errore '.mysqli_error()); // questo apparirà solo se ci sarà un errore
}
$db_selected=mysqli_select_db($connessione_al_server,"fitnesstracking"); // dove io ho scritto "prova" andrà inserito il nome del db
if(!$db_selected){
die ('Errore nella selezione del database: errore '.mysql_error()); // se la connessione non andrà a buon fine apparirà questo messaggio
}

if(isset($_POST['idAnnuncio']) && isset($_POST['operation']) && $_POST['operation']==0){
  $query = mysqli_query($connessione_al_server,"UPDATE applications SET accepted='1' WHERE idAnnuncio="."'" .$_POST['idAnnuncio'] ."'")  //per selezionare nel db l'utente e pw che abbiamo appena scritto nel log
  or DIE('query non riuscita'.mysqli_error());
}elseif (isset($_POST['idAnnuncio']) && isset($_POST['operation']) && $_POST['operation']==1) {
  $query = mysqli_query($connessione_al_server,"UPDATE applications SET accepted='2' WHERE idAnnuncio="."'" .$_POST['idAnnuncio'] ."'")  //per selezionare nel db l'utente e pw che abbiamo appena scritto nel log
  or DIE('query non riuscita'.mysqli_error());
}elseif (isset($_POST['idAnnuncio']) && isset($_POST['userId']) && isset($_POST['price']) && isset($_POST['operation']) && $_POST['operation']==2) {
  $query = mysqli_query($connessione_al_server,"UPDATE ads SET completed='1' WHERE id="."'" .$_POST['idAnnuncio'] ."'")
  or DIE('query non riuscita'.mysqli_error($query));
  $query1 = mysqli_query($connessione_al_server,"UPDATE userdata SET balance=balance+"."'".$_POST['price']."'"." WHERE id="."'" .$_POST['userId'] ."'")
  or DIE('query non riuscita'.mysqli_error($query1));
  echo "executed";
}



?>
