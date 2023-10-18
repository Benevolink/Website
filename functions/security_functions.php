<?php require_once __DIR__.'/../links.php';

//sécuriser le téléchargement d'images
//ici image est le nom de l'image
function secure_image($image) {
  //Vérifier l'extension
  $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');
  $extension = pathinfo($image, PATHINFO_EXTENSION);
  if (!in_array($extension, $allowed_extensions)) {
    
    return 1;
  }
  //Vérifier qu'il n'y a pas de points dans le nom de l'image
  
  for ($i=0; $i<strlen($image)-5; $i++) {
    
    if ($image[$i]==".") {
      return 2;
    }
  }
  return 0;
}

//Donner un nom aléatoire à une image. Il faut donc créer un nom aléatoire composé de caractère de tout types lettres, chiffres, caractères spéciaux...
function secure_image_name($image,$table,$chemin) {
  //modèle fait pour la table user. La modifier avant de la mettre dans les autres
  $unique = 0;
  $ext = pathinfo($image, PATHINFO_EXTENSION);
  while($unique!=1){
    $image_name = uniqid();

    $req_id = "SELECT logo FROM".$table."WHERE basename(logo)=? ";//on vérifie que le nom n'est pas déjà pris
    $req_id_2 = $db->prepare($req_id);
    $req_id_2->execute([$image_name]);
    $id = $req_id_2->fetch(PDO::FETCH_ASSOC);
    if (count($id) == 0) {
      //donc si le nom est bien unique on peut juste sortir de la boucle
      $unique = 1;
    }
  }
  //Mettre l'image dans le fichier logo/user/
  $destinationPath = $path.$chemin.basename($_FILES['uploadedfile']['name']); 
  array_map('unlink', glob($path.$chemin.$image_name.".*")); //On supprime les fichiers résiduels
  if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $destinationPath)) {
    echo "Le fichier ".  basename( $_FILES['uploadedfile']['name'])." a bien été téléversé";
  } else{
    echo "Il y a eu une erreur pour poster le fichier, réessayez.";
  }
  $newDestinationPath = $chemin.$image_name.".".$ext;
  rename($destinationPath, $path.$newDestinationPath);
  //UPDATE le chemin vers l'image dans la BDD

  BF::request("UPDATE assos SET logo = ? WHERE id = ?",[$newDestinationPath,$id]);
 
  
  
}



?>