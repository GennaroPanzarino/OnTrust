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




//QUERY PER REPERIRE LE MIE CANDIDATURE
$myCand= mysqli_query($connessione_al_server,"SELECT a.idAnnuncio,b.id,b.imgPath,c.name,c.lastname,b.title,b.body,b.price,b.data,b.completed,b.imgPath,a.note,a.accepted FROM applications AS a INNER JOIN ads as b ON a.idAnnuncio=b.id INNER JOIN userdata as c ON b.userId=c.id WHERE a.userId="."'".$_SESSION["userid"]."'"." AND b.completed='0'")  //per selezionare nel db l'utente e pw che abbiamo appena scritto nel log
or DIE('query non riuscita'.mysqli_error($myCand));

if(mysqli_num_rows($myCand)>0){
  $arrayCand = array();
  while ($risCand = mysqli_fetch_assoc($myCand)) {
    $arrayCand[] = $risCand;
  }
}else{
}



//QUERY PER REPERIRE LE CANDIDATURE AI MIEI ANNUNCI
$myRecCand = mysqli_query($connessione_al_server,"SELECT a.idAnnuncio,b.id,b.imgPath,c.name,c.lastname,b.title,b.body,b.price,b.data,b.imgPath,a.note FROM applications AS a INNER JOIN ads as b ON a.idAnnuncio=b.id INNER JOIN userdata AS c ON b.userId=c.id WHERE b.userId="."'".$_SESSION["userid"]."'"." AND a.accepted='0'")
or DIE('query non riuscita'.mysqli_error($myRecCand));

if(mysqli_num_rows($myRecCand)>0){
  $arrayRecCand = array();
  while ($risRecCand = mysqli_fetch_assoc($myRecCand)) {
    $arrayRecCand[] = $risRecCand;
  }
}else{
}




//QUERY PER REPERIRE LE TRATTATIVE IN CORSO (CANDIDATURE AI MIEI ANNUNCI NON ANCORA PAGATE)
$myAccCand = mysqli_query($connessione_al_server,"SELECT a.userId,a.idAnnuncio,b.id,b.imgPath,c.name,c.lastname,b.title,b.body,b.price,b.data,b.completed,b.imgPath,a.note FROM applications AS a INNER JOIN ads as b ON a.idAnnuncio=b.id INNER JOIN userdata AS c ON a.userId=c.id WHERE b.userId="."'".$_SESSION["userid"]."'"." AND a.accepted='1'")
or DIE('query non riuscita'.mysql_error($myAccCand));

if(mysqli_num_rows($myAccCand)>0){
  $arrayAccCand = array();
  while ($risAccCand = mysqli_fetch_assoc($myAccCand)) {
    $arrayAccCand[] = $risAccCand;
  }
}else{
}


$packItAll = array();
if(ISSET($arrayCand)){
  $packItAll[0]=$arrayCand;
}else{
  $voidArray=array();
  $packItAll[0]=$voidArray;
}

if(ISSET($arrayRecCand)){
  $packItAll[1]=$arrayRecCand;
}else{
  $voidArray1=array();
  $packItAll[1]=$voidArray1;
}

if(ISSET($arrayAccCand)){
  $packItAll[2]=$arrayAccCand;
}else{
  $voidArray2=array();
  $packItAll[2]=$voidArray2;
}

echo JSON_ENCODE($packItAll);
return;
?>
