<?php
require_once "../../../links.php";
require_once "../../../functions/security_functions.php";
//on récupère les données de l'asso créée, si elles existent, par la méthode post
if(BF::is_posted(["nom","uploadedfile","desc", "desc_missions", "adresse", "domaine", "email", "tel"])){
    $association = $_POST["nom"];
    $description = $_POST["desc"];
    $description_missions = $_POST["desc_missions"];
    $logo = $_POST["uploadedfile"];
    $email = $_POST["email"];
    $telephone = $_POST["tel"];
   //On vérifie que le fichier du logo est bien une image grâce aux fonctions créées
    
    if(secure_image($_FILES['uploadedfile']['name'])==1){
      echo "Le fichier n'est pas au bon format";
      return 0;
    }
    if(secure_image( $_FILES['uploadedfile']['name'])==2){
      echo "Le nom du fichier ne doit pas contenir de point sauf pour l'extention";
      return 0;
    }
  //Mise au bon format de l'image (jpg et la bonne taille)
  $extension = pathinfo($_FILES['uploadedfile']['name'], PATHINFO_EXTENSION);
  if($extension=="php"){
     $logo=imagecreatefrompng($logo);
  }
  if($extension=="gif"){
  $logo=imagecreatefromgif($logo);
     }
  if($extension=="jpeg"){
     $logo=imagecreatefromjpeg($logo);
     }
  $size_w=304;
  $size_h=166;
  $logo=imagecrop($logo,['x'=>0,'y'=>0,'width'=>$size_w,'height'=>$size_h]);
  
  
    
    try{
        // On se connecte à la BDD
        $db->beginTransaction();
        // On insère les données reçues dans la table "assos"
        $sth = $db->prepare("INSERT INTO assos (nom, desc, desc_missions, email, tel, logo) VALUES(:nom, :desc, :desc_missions, :email, :tel, :logo)");
        $sth->bindParam(':nom', $association);
        $sth->bindParam(':desc', $description);
        $sth->bindParam(':desc_missions', $description_missions);
        $sth->bindParam(':email', $email);
        $sth->bindParam(':tel', $telephone);
        $sth->bindParam(':logo', $logo);
        $sth->execute();
      
        // Récupérer l'ID de l'association qui vient d'être créée
        
        $id = $db->lastInsertId();
        $db->commit();

        // on récupère les domaines sélectionnés
        $domainesSelectionnes = $_POST["domaine"];
    
        // on insère les domaines sélectionnés dans la table "domaine_jonction"
        $query = "INSERT INTO domaine_jonction (id_domaine, id_jonction,type) VALUES (?, ?, 1)";
        $stmt = $db->prepare($query);
    
        foreach ($domainesSelectionnes as $idDomaine) {
            $stmt->execute([$idDomaine, $id]);
        }
      
        // on récupère l'adresse de l'asso
        $adresse = $_POST["adresse"];

        // Insérer l'adresse dans la table "lieu"
        $sth = $db->prepare("INSERT INTO lieu (adresse) VALUES(:adresse)");
        $sth->bindParam(':adresse', $adresse);
        $sth->execute();
        
        // Récupérer l'ID de l'adresse qui vient d'être créée
        $id_lieu = $db->lastInsertId();
        
        // Mettre à jour l'ID de l'adresse dans la table "assos"
        $sth = $db->prepare("UPDATE assos SET id_lieu = :id_lieu WHERE id = :id");
        $sth->bindParam(':id_lieu', $id_lieu);
        $sth->bindParam(':id', $id);
        $sth->execute();
      
        //Mettre l'image dans le fichier logo/asso/
        $destinationPath = $path."media/logo/asso/".basename($_FILES['uploadedfile']['name']); 
        $fileNameParts = explode('.',basename($_FILES['uploadedfile']['name']));
        $ext = end($fileNameParts);
        array_map('unlink', glob($path."media/logo/asso/".$id.".*")); //On supprime les fichiers résiduels
        if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $destinationPath)) {
          echo "Le fichier ".  basename( $_FILES['uploadedfile']['name'])." a bien été téléversé";
        } else{
          echo "Il y a eu une erreur pour poster le fichier, réessayez.";
        }
        $newDestinationPath = "media/logo/asso/".$id.".".$ext;
        rename($destinationPath, $path.$newDestinationPath);
      
        //UPDATE le chemin vers l'image dans la BDD
     
        BF::request("UPDATE assos SET logo = ? WHERE id = ?",[$newDestinationPath,$id]);
      
        // Récupérer l'ID de l'utilisateur qui a créé l'association
        $id_utilisateur = $_SESSION["user_id"];
        // Mettre à jour le statut de l'utilisateur en "admin" pour l'association qu'il a créée      
        BF::request("INSERT INTO membres_assos (id_user, id_asso, statut) VALUES (?, ?, 3)",[$id_utilisateur,$id]);
        
      
        
        //On renvoie l'utilisateur vers la page de remerciement
        header('Location:'+BF::abs_path('controller/static/form-merci.php'));
        exit(0);
    }
    catch(PDOException $e){
        echo 'Impossible de traiter les données. Erreur : '.$e->getMessage();
    }
}else{
  echo "Il manque des données dans le formulaire envoyé.";
  if(!isset($_POST["nom"])){
    echo "nom:";
  }
  if(!isset($_POST["uploadedfile"])){
    echo "logo:";
  }
  if(!isset($_POST["desc"])){
    echo "desc:";
  }
  if(!isset($_POST["desc_missions"])){
    echo "desc_missions:";
  }
  if(!isset($_POST["adresse"])){
    echo "adresse:";
  }
  if(!isset($_POST["tel"])){
    echo "tel:";
  }
  if(!isset($_POST["email"])){
    echo "email:";
  }
  if(!isset($_POST["domaine"])){
    echo "domaine:";
  }
  
}
?>
<a href="<?= BF::abs_path("index.php") ?>">Retour au menu</a>