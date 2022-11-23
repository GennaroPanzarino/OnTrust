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
$richiesta="INSERT INTO userdata (name,lastname,email,password,tel,age) VALUES ("."'".   $_POST['name']  ."','".     $_POST['lastname']  ."','".       $_POST['username']   ."','".       $_POST['password']      ."','".    $_POST['tel']   ."','".  $_POST['age']."'".")";
$query = mysqli_query($connessione_al_server,$richiesta)  //per selezionare nel db l'utente e pw che abbiamo appena scritto nel log
or DIE('query non riuscita'.mysqli_error($connessione_al_server));

?>
