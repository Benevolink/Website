<?php
require_once "links.php";
if(BF::is_posted(['uploadedfile'])&&BF::is_connected()){
  $destinationPath = $path."media/logo/user/".basename($_FILES['uploadedfile']['name']); 
    array_map('unlink', glob($path."media/logo/user/".$_SESSION["user_id"].".*"));
    $fileNameParts = explode('.',basename($_FILES['uploadedfile']['name']));
    $ext = end($fileNameParts);
    if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $destinationPath)) {
      //echo "Le fichier ".  basename( $_FILES['uploadedfile']['name'])." a bien été téléversé";
    } else{
      //echo "Il y a eu une erreur pour poster le fichier, réessayez.";
    }
  
    $newDestinationPath = $path."media/logo/user/".$_SESSION["user_id"].".".$ext;
    rename($destinationPath, $newDestinationPath);
  header("Location: ../mon_compte.php");
}else{
  echo "Erreur, vous n'êtes pas authentifié ou le fichier n'est pas upload.";
}
?>