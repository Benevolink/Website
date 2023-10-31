<?php
require_once __DIR__."/../functions/basic_functions.php";
require_once BF::abs_path("db.php",true);

class image {
    private $image;
    private $emplacement;
    public function __construct($i,$em){
        $this->image=$i;
        $this->emplacement=$em;
    }

    public function getNom(){
        return $this->image;
    }
    public function getEmplacement(){
        return $this->emplacement;
    }


    /**
     * Obsolète (mettre à jour avec des BF::request et utiliser noms_tables.php)
     */
    public function placer_image($image,$table,$chemin){
        global $path;
        global $db;
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
        } 
        else{
            echo "Il y a eu une erreur pour poster le fichier, réessayez.";
        }
        $newDestinationPath = $chemin.$image_name.".".$ext;
        rename($destinationPath, $path.$newDestinationPath);
        //UPDATE le chemin vers l'image dans la BDD
        BF::request("UPDATE assos SET logo = ? WHERE id = ?",[$newDestinationPath,$id]);
        //Créer l'objet id avec l'image et le lien
 
  
  
}

    }

?>