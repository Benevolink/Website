<?php
require_once __DIR__."/../functions/basic_functions.php";
require_once BF::abs_path("db.php",true);


class image {
    
    private $name;
    private $type;
    private $size;
    private $tmp_name;
    private $error;
    private $fullpath;

    public static function getImage(){}
    public static function setImage(){}
    

  

    
    /**
     * Method placer_image
     *
     * @param $image $image [est "l'image" donc un objet de la classe image]
     * @param $table $table [la table où le chemin de l'asso sera stockée]
     * @param $chemin $chemin [chemin depuis la racine où l'on souhaite que l'image soit stockée]
     *
     * Permet de rentrer de manière sécurisée un image dans la base de donnée 
     * @return void
     */
    
    /*
    *A été modifié : à retester
    */
    /*Deuxième modif : la fonction prends un argument $image qui est un objet de la classe image qui a été créé à partir des données 
    récupérées dans FILE. De ce que j'ai compris après le chargement de l'image pas la méthode POST l'image est stockée quelque part
    et toutes les fonctions permettant de déplacer une image et tout prennent en argument le nom de l'imgage puis vont la chercher. 
    Le champs tmp_nom est le champs contenant le nom de l'image sur le serveur (celui qui nous intéresse) et le champs name contient 
    le nom d'origine de l'image (il ne nous intéresse pas)*/ 

    public function placer_image($image,$table,$chemin){
        

        $unique = 0;
        $ext = pathinfo($image->tmp_name, PATHINFO_EXTENSION);


        while($unique!=1){
            $image_name_num = uniqid();

            $req_noms = "SELECT logo FROM".$table." WHERE basename(logo)=? ";//on vérifie que le nom n'est pas déjà pris
            $req_noms_2 = $db->prepare($req_id);
            $req_noms_2->execute([$image_name_num]);
            $id = $req_noms_2->fetch(PDO::FETCH_ASSOC);

            if (count($id) == 0) {
      //donc si le nom est bien unique on peut juste sortir de la boucle
                $unique = 1;
            }
        }
        //changer le nom
        $image_name=strval($image_name_num);
        rename($image->tmp_name,$image_name);
        $image->tmp_name=$image_name;

        //Mettre l'image dans le fichier logo/user/
        $destinationPath = $chemin.$image_name.".".$ext;
        array_map('unlink', glob($chemin.$image_name.".*")); //On supprime les fichiers résiduels
        if(move_uploaded_file($image->tmp_name, $destinationPath)) { 
            echo "Le fichier ".  basename( $image->name)." a bien été téléversé";
        } //la fonction move_uploaded_file déplace le fichier dans destination et renvoie un si l'opération est un succés 0 sinon
        else{
            echo "Il y a eu une erreur pour poster le fichier, réessayez.";
        }
        
        //rename($destinationPath, $newDestinationPath);
        //UPDATE le chemin vers l'image dans la BDD
        BF::request("UPDATE" .$table. " SET logo = ? WHERE id = ?",[$destinationPath,$id]);
        
 
  
  
}
    public static function verifier_format($image){
        $allowed_extensions = array('jpg', 'jpeg', 'png');
       
        $extension = pathinfo($image->tmp_name, PATHINFO_EXTENSION);
    
    //on vérifie le format de l'image
        if (!in_array($extension, $allowed_extensions)) {
        
        echo "Cette extension n'est pas authorisée";
        }
        //Vérifier qu'il n'y a pas de points autres que celui de l'extension dans le nom de l'image pour éviter une double extension
        
        for ($i=0; $i<strlen($image->tmp_name)-5; $i++) {
          
            if ($nom_image[$i]==".") {
            echo "Il ne peut y avoir d'autres points que celui de l'extension"; 
             }
    }
}

}

?>