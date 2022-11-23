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
date_default_timezone_set('Europe/Vatican');


$query="SELECT balance FROM userdata WHERE id="."'".$_SESSION['userid']."'";
$balanceCheck = mysqli_query($connessione_al_server,$query);

  if(mysqli_fetch_assoc($balanceCheck)['balance']*1 >= $_POST['price'])
  {
    $query1="INSERT INTO ads (userId,title,body,price,data,imgPath,category) VALUES ("."'".$_SESSION['userid']."'".","."'".$body=$_POST['title']."'". ",'".$body=$_POST['body']."'". ",'".$body=$_POST['price']."',"."'".date("d/m/Y H:i")."'".",'".$body=$_POST['imgUrl']."'".",'".$body=$_POST['category']."'".")";
    $query2="UPDATE userdata SET balance=balance-"  .  $body=$_POST['price']  .  " WHERE id="."'".$_SESSION['userid']."'";
    $query1Enacted = mysqli_query($connessione_al_server,$query1)
  or DIE('query non riuscita'.mysqli_error($query1));
    $query2Enacted = mysqli_query($connessione_al_server,$query2)
  or DIE('query non riuscita'.mysqli_error($query2));
}else{echo 2;}
?>
