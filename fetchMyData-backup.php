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

$myCand= mysqli_query($connessione_al_server,"SELECT b.id,c.name,c.lastname,b.title,b.body,b.price,b.data,a.note FROM applications AS a INNER JOIN ads as b ON a.idAnnuncio=b.id INNER JOIN userdata as c ON b.userId=c.id WHERE a.userId="."'".$_SESSION["userid"]."'")  //per selezionare nel db l'utente e pw che abbiamo appena scritto nel log
or DIE('query non riuscita'.mysqli_error($myCand));

if(mysqli_num_rows($myCand)>0){
  $arrayCand = array();
  while ($risCand = mysqli_fetch_assoc($myCand)) {
    $arrayCand[] = $risCand;
  }
  echo JSON_ENCODE($arrayCand);
  return;
}else{
echo "fail";
}
?>
