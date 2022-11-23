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
if(isset($_POST['option']) && $_POST['option']==0){
  $query = mysqli_query($connessione_al_server,"SELECT a.id,a.imgPath,b.name,b.lastname,a.title,a.body,a.price,a.data FROM ads AS a INNER JOIN userdata as b ON a.userId=b.id ORDER BY b.id DESC")  //per selezionare nel db l'utente e pw che abbiamo appena scritto nel log
  or DIE('query non riuscita'.mysql_error());
}
if(isset($_POST['option']) && $_POST['option']==2){
  $query = mysqli_query($connessione_al_server,"SELECT a.id,a.imgPath,b.name,b.lastname,a.title,a.body,a.price,a.data FROM ads AS a INNER JOIN userdata as b ON a.userId=b.id WHERE category="."'".$_POST["category"]."'"."ORDER BY b.id DESC")  //per selezionare nel db l'utente e pw che abbiamo appena scritto nel log
  or DIE('query non riuscita'.mysql_error());
}
// Con il SELECT qua sopra selezione dalla tabella users l utente registrato (se lo è) con i parametri che mi ha passato il form di login, quindi
// Quelli dentro la variabile POST. username e password.
if(mysqli_num_rows($query)>0){        //se c'è una persona con quel nome nel db allora loggati
  $resultSet = array();
  while ($result = mysqli_fetch_assoc($query)) {
    $resultSet[] = $result;
  }
  echo JSON_ENCODE($resultSet);
  return;
}else{
echo "fail"; // altrimenti esce scritta a video questa stringa di errore
}
?>
