<?php
require_once __DIR__."/../functions/basic_functions.php";
require_once BF::abs_path("db.php",true);

class Image {

    public static function getImage(){}
    

  

    
    /**
     * Method placer_image
     *
     * @param $image $image [explicite description]
     * @param $table $table [explicite description]
     * @param $chemin $chemin [explicite description]
     *
     * Permet de rentrer de manière sécurisée un image dans la base de donnée 
     * @return void
     */

    
    
    public static function placer_image($image,$table,$chemin){
        $unique = 0;
        $ext = pathinfo($image, PATHINFO_EXTENSION);


        while($unique!=1){
            $image_name = uniqid();

            $req_id = "SELECT logo FROM".$table." WHERE basename(logo)=? ";//on vérifie que le nom n'est pas déjà pris
            $req_id_2 = $db->prepare($req_id);
            $req_id_2->execute([$image_name]);
            $id = $req_id_2->fetch(PDO::FETCH_ASSOC);

            if (count($id) == 0) {
      //donc si le nom est bien unique on peut juste sortir de la boucle
                $unique = 1;
            }
        }

  //Mettre l'image dans le fichier logo/user/
        $destinationPath = $chemin.basename($_FILES['uploadedfile']['name']); 
        array_map('unlink', glob($chemin.$image_name.".*")); //On supprime les fichiers résiduels
        if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $destinationPath)) {
            echo "Le fichier ".  basename( $_FILES['uploadedfile']['name'])." a bien été téléversé";
        } //la fonction move_uploaded_file déplace le fichier dans destination et renvoie un si l'opération est un succés 0 sinon
        else{
            echo "Il y a eu une erreur pour poster le fichier, réessayez.";
        }
        $newDestinationPath = $chemin.$image_name.".".$ext;
        //rename($destinationPath, $newDestinationPath);
        //UPDATE le chemin vers l'image dans la BDD
        BF::request("UPDATE" .$table. " SET logo = ? WHERE id = ?",[$newDestinationPath,$id]);
        
 
  
  
}
    public static function verifier_format($image){
        $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');
        $nom_image=$_FILES['uploadedfile']['name'];
        $extension = pathinfo($nom_image, PATHINFO_EXTENSION);
    
    //on vérifie le format de l'image
        if (!in_array($extension, $allowed_extensions)) {
        
        echo "Cette extension n'est pas authorisée";
        }
        //Vérifier qu'il n'y a pas de points dans le nom de l'image
        
        for ($i=0; $i<strlen($nom_image)-5; $i++) {
          
            if ($nom_image[$i]==".") {
            echo "Il ne peut y avoir d'autres points que celui de l'extension"; 
             }
    }
}
    /*public static function corriger_extension($image){
        $ext = pathinfo($image, PATHINFO_EXTENSION);

    }*/

}

?>