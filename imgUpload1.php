<?php
if(isset($_FILES)){
   $name = $_FILES['myFile']['name'];
   $targetDir = "media/";
   $targetFile = $targetDir.basename($_FILES['myFile']['name']);
   $fileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));
   //valid file extensions we will allow
   $extensions_arr= array("jpg","jpeg","png");
   //checking the extension of our uploaded file
   if(in_array($fileType,$extensions_arr)){
   move_uploaded_file($_FILES['myFile']['tmp_name'],$targetDir.$name);
   echo $targetFile;
} else echo " wrong file type ";
}
?>
