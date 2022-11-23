<?php
session_start();
$result=2;
$connessione_al_server;
//calcolo la media dei voti e li conto
readMyAvg();
if(isset($_POST["option"]) && $_POST["option"]==0){
  echo JSON_ENCODE($result);
  return;
}

function readMyAvg(){
  global $connessione_al_server;
  $connessione_al_server=mysqli_connect("localhost","root","","fitnesstracking");
  if(!$connessione_al_server){
  die ('Non riesco a connettermi: errore '.mysqli_error());
  }
  $db_selected=mysqli_select_db($connessione_al_server,"fitnesstracking");
  if(!$db_selected){
  die ('Errore nella selezione del database: errore '.mysqli_error());
  }

$query = mysqli_query($connessione_al_server,"SELECT COUNT(rating) as n,AVG(rating) as avg FROM ratings WHERE reviewedId="."'".$_POST["id"]."'")
or DIE('query non riuscita'.mysqli_error($query));

  global $result;
  $result= mysqli_fetch_assoc($query);
}


//verifico se sto invocando il file con modalità scrittura
if(isset($_POST["option"]) && $_POST["option"]==1){

    //verifico se ho già lasciato una valutazione
    global $connessione_al_server;
    $query2=mysqli_query($connessione_al_server,"SELECT rating FROM ratings WHERE reviewedId="."'".$_POST["id"]."'"."AND reviewerId="."'".$_SESSION["userid"]."'")
    or DIE('query non riuscita'.mysqli_error($query2));
    if(mysqli_num_rows($query2)==0){
          //inserisco in ratings il voto che corrisponde a t, indipendentemente dalla formula della reputazione del recensito
          $query = mysqli_query($connessione_al_server,"INSERT INTO ratings(reviewerId,reviewedId,rating) VALUES("."'".$_SESSION["userid"] . "','". $_POST["id"] . "','" . $_POST["value"] . "')")
          or DIE('query non riuscita'.mysqli_error());
          //NON TOCCARE!!!--SERVE PER LA COSINE SIMILARITY
          $query1 = mysqli_query($connessione_al_server,"UPDATE userratings SET u".$_POST["id"]."=".$_POST["value"]." WHERE userId=".$_SESSION["userid"]."");
          //CODICE CALCOLO REPUTAZIONE
          //IL VALORE RAW t INSERITO DALL'UTENTE OLTRE AD ESSERE STATO SALVATO SOPRA COSI COM'è ORA LO USO PER LA REPUTAZIONE
                    $myQuery3=mysqli_query($connessione_al_server,"SELECT reputation FROM userdata WHERE id=".$_SESSION["userid"]."");
                    $C=mysqli_fetch_assoc($myQuery3)["reputation"];
                    $V=1;
                    $TC=1;
                    $v=2;
                    $myQuery=mysqli_query($connessione_al_server,"SELECT COUNT(*)
                     AS tot FROM ratings WHERE reviewedId=".$_POST["id"]."");
                    $i=mysqli_fetch_assoc($myQuery)["tot"];
                    $myQuery1=mysqli_query($connessione_al_server,"SELECT reputation FROM userdata WHERE id=".$_POST["id"]."");
                    $R=mysqli_fetch_assoc($myQuery)["reputation"];
                    $WC=$C/$TC;
                    $WV=$v/$V;
                    $W=($WC+$WV)/2;
                    $t=$_POST["value"];
                    $r=$t*(1+$W);
                    $rprimo=(1+exp(-1/$i))*$r;
                    $R_new=$R+$rprimo;
                    $myQuery2=mysqli_query($connessione_al_server,"UPDATE userdata SET reputation=".$R_new." WHERE id=".$_POST["id"]."") ;

          //INIZIO CODICE COSINE SIMILARITY
          $userrates =mysqli_query($connessione_al_server,"SELECT * FROM userratings");
          $userRates=Array();
          $cosineDist=Array();
          while($userrates1 = mysqli_fetch_assoc($userrates)) {
            $userRates[] = $userrates1;
          }
          $current=$userRates[$_SESSION["userid"]];


          for($c=0;$c<=(count($userRates)-2);$c++){
                                if($_SESSION["userid"]!==$c){
                                  //calcolo delle norme
                                    //NORMA CURRENT
                                  $sumOfSquares=0;
                                  $a=0;
                                  $count=false;
                                  foreach($current as $a){
                                    if($count==true){
                                      $sumOfSquares=$sumOfSquares+$a*$a;
                                    }
                                    $count=true;
                                  }
                                  $normOfCurrent=sqrt($sumOfSquares);
                                    //NORMA ROW
                                  $sumOfSquares=0;
                                  $a=0;
                                  $count=false;
                                  foreach($userRates[$c] as $a){
                                    if($count==true){
                                      $sumOfSquares+=$a*$a;
                                    }
                                    $count=true;
                                  }
                                  $normOfRow=sqrt($sumOfSquares);
                                    //PRODOTTO SCALARE
                                  $prodScal=0;
                                  if($normOfRow>0 && $normOfCurrent>0){
                                    for($j=0;$j<=(count($current)-2);$j++){
                                      $prodScal=$prodScal+$current["u".$j.""]*$userRates[$c]["u".$j.""];
                                    }
                                    //DISTANZA COSENI
                                  $cosineDist=$prodScal/($normOfCurrent*$normOfRow);
                                  }else{
                                    $cosineDist=0;
                                  }
                                }else{
                                  $cosineDist=0;
                              }
                              $query2=mysqli_query($connessione_al_server,"UPDATE cosdist SET u".$c."=".$cosineDist." WHERE userId=".$_SESSION["userid"]."");
                              $query3=mysqli_query($connessione_al_server,"UPDATE cosdist SET u".$_SESSION["userid"]."=".$cosineDist." WHERE userId=".$c."");
                          }
                          //FINE CODICE COSINE SIMILARITY
          readMyAvg();
          echo JSON_ENCODE($result);
          return;
          }else{ //se ho già lasciato una valutazione allora la modifico e ritorno la media aggiornata
          $query = mysqli_query($connessione_al_server,"UPDATE ratings SET rating='". $_POST['value']."' WHERE reviewedId='".$_POST["id"]."'"." AND reviewerId='".$_SESSION["userid"]."'")
          or DIE('query non riuscita'.mysqli_error());
          $query1 = mysqli_query($connessione_al_server,"UPDATE userratings SET u".$_POST["id"]."=".$_POST["value"]." WHERE userId=".$_SESSION["userid"]."");


          //CODICE CALCOLO REPUTAZIONE
                    $myQuery3=mysqli_query($connessione_al_server,"SELECT reputation FROM userdata WHERE id=".$_SESSION["userid"]."");
                    $C=mysqli_fetch_assoc($myQuery3)["reputation"];
                    $V=1;
                    $TC=1;
                    $v=2;
                    $myQuery=mysqli_query($connessione_al_server,"SELECT COUNT(*) AS tot FROM ratings WHERE reviewedId=".$_POST["id"]."");
                    $i=mysqli_fetch_assoc($myQuery)["tot"];
                    $myQuery1=mysqli_query($connessione_al_server,"SELECT reputation FROM userdata WHERE id=".$_POST["id"]."");
                    $R=mysqli_fetch_assoc($myQuery)["reputation"];
                    $WC=$C/$TC;
                    $WV=$v/$V;
                    $W=($WC+$WV)/2;
                    $t=$_POST["value"];
                    $r=$t*(1+$W);
                    $rprimo=(1+exp(-1/$i))*$r;
                    $R_new=$R+$rprimo;
                    $myQuery2=mysqli_query($connessione_al_server,"UPDATE userdata SET reputation=".$R_new." WHERE id=".$_POST["id"]."");

          //INIZIO CODICE COSINE SIMILARITY
          $userrates =mysqli_query($connessione_al_server,"SELECT * FROM userratings");
          $userRates=Array();
          $cosineDist=Array();
          while($userrates1 = mysqli_fetch_assoc($userrates)) {
            $userRates[] = $userrates1;
          }
          $current=$userRates[$_SESSION["userid"]];


          for($c=0;$c<=(count($userRates)-2);$c++){
                                if($_SESSION["userid"]!==$c){
                                  //calcolo delle norme
                                    //NORMA CURRENT
                                  $sumOfSquares=0;
                                  $a=0;
                                  $count=false;
                                  foreach($current as $a){
                                    if($count==true){
                                      $sumOfSquares=$sumOfSquares+$a*$a;
                                    }
                                    $count=true;
                                  }
                                  $normOfCurrent=sqrt($sumOfSquares);
                                    //NORMA ROW
                                  $sumOfSquares=0;
                                  $a=0;
                                  $count=false;
                                  foreach($userRates[$c] as $a){
                                    if($count==true){
                                      $sumOfSquares+=$a*$a;
                                    }
                                    $count=true;
                                  }
                                  $normOfRow=sqrt($sumOfSquares);
                                    //PRODOTTO SCALARE
                                  $prodScal=0;
                                  if($normOfRow>0 && $normOfCurrent>0){
                                    for($j=0;$j<=(count($current)-2);$j++){
                                      $prodScal=$prodScal+$current["u".$j.""]*$userRates[$c]["u".$j.""];
                                    }
                                    //DISTANZA COSENI
                                  $cosineDist=$prodScal/($normOfCurrent*$normOfRow);
                                  }else{
                                    $cosineDist=0;
                                  }
                                }else{
                                  $cosineDist=0;
                              }
                              $query2=mysqli_query($connessione_al_server,"UPDATE cosdist SET u".$c."=".$cosineDist." WHERE userId=".$_SESSION["userid"]."");
                              $query3=mysqli_query($connessione_al_server,"UPDATE cosdist SET u".$_SESSION["userid"]."=".$cosineDist." WHERE userId=".$c."");
                          }
                          //FINE CODICE COSINE SIMILARITY
          readMyAvg();
          echo JSON_ENCODE($result);
          return;
        }
      }
      ?>
