<?php
session_start();
$connessione_al_server=mysqli_connect("localhost","root","","fitnesstracking");
if(!$connessione_al_server){
die ('Non riesco a connettermi: errore '.mysqli_error()); // questo apparirà solo se ci sarà un errore
}
$db_selected=mysqli_select_db($connessione_al_server,"fitnesstracking"); // dove io ho scritto "prova" andrà inserito il nome del db
if(!$db_selected){
die ('Errore nella selezione del database: errore '.mysqli_error()); // se la connessione non andrà a buon fine apparirà questo messaggio
}

$query = mysqli_query($connessione_al_server,"SELECT a.id,a.imgPath,b.name,b.lastname,a.title,a.body,a.price,a.data FROM ads AS a INNER JOIN userdata as b ON a.userId=b.id WHERE MATCH (body) AGAINST ('" . $_POST['searchQuery'] . "' IN NATURAL LANGUAGE MODE)
UNION (SELECT a.id,a.imgPath,b.name,b.lastname,a.title,a.body,a.price,a.data FROM ads AS a INNER JOIN userdata as b ON a.userId=b.id WHERE MATCH (title) AGAINST ('" . $_POST['searchQuery'] . "' IN NATURAL LANGUAGE MODE))")
or DIE('query non riuscita'.mysqli_error($query));

if(mysqli_num_rows($query)>0){

  $resultSet = array();
  while ($result = mysqli_fetch_assoc($query)) {
    $resultSet[] = $result;
  }

  echo JSON_ENCODE($resultSet);
  return;
}else{
return;
}
?>
