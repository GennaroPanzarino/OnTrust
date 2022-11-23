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

$query = mysqli_query($connessione_al_server,"SELECT * FROM userdata WHERE email='".$_POST["username"]."' AND password ='".$_POST["password"]."'")  //per selezionare nel db l'utente e pw che abbiamo appena scritto nel log
or DIE('query non riuscita'.mysql_error());
// Con il SELECT qua sopra selezione dalla tabella users l utente registrato (se lo è) con i parametri che mi ha passato il form di login, quindi
// Quelli dentro la variabile POST. username e password.
if(mysqli_num_rows($query)>0){        //se c'è una persona con quel nome nel db allora loggati


  $namelastname = mysqli_fetch_assoc($query); //trasformo nome e cognome in un oggetto
  $_SESSION["userid"] = $namelastname['id'];
  $_SESSION["username"]=$_POST["username"]; // con questo associo il parametro username che mi è stato passato dal form alla variabile SESSION username
  $_SESSION["name"]=$namelastname['name'];
  $_SESSION["lastname"]=$namelastname['lastname'];
  $_SESSION["password"]=$_POST["password"]; // con questo associo il parametro username che mi è stato passato dal form alla variabile SESSION password
  $_SESSION["logged"] =true;  // Nella variabile SESSION associo TRUE al valore logge
}else{
echo "non ti sei registrato con successo"; // altrimenti esce scritta a video questa stringa di errore
}
?>
