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
$query = mysqli_query($connessione_al_server,"INSERT INTO ads (userId,title,body,price) VALUES ("."'".$_SESSION['userid']."'".","."'".$body=$_POST['title']."'". ",'".$body=$_POST['body']."'". ",'".$body=$_POST['price']."'".")")  //per selezionare nel db l'utente e pw che abbiamo appena scritto nel log
or DIE('query non riuscita'.mysqli_error($connessione_al_server));
?>
