<?php
require_once __DIR__."/../functions/basic_functions.php";
require_once BF::abs_path("db.php",true);
require_once __DIR__."/Ressources/NomsAttributsTables.php";
require_once __DIR__."/Ressources/LibsInterfaces.php";
use AttributsTables as A;
  

class image {
    
    private $name;
    private $type;
    private $size;
    private $tmp_name;
    private $error;
    public $fullpath;

    public $chemin;

    /**
     * Method getImage
     * 
     * @param $table [table dans laquelle se trouve l'image que l'on cherche. Est une chaine de charactère]
     * @param $id [id de l'utilisateur/asso/... dont on cherche l'image]
     * 
     * Permet d'obtenir le lien (contenu dans le champs 'logo' de la table de donnée) menant vers l'image
     * 
     * @return string
     */

    public function getImage($id,$table){
        
        global $db;
        switch($table){
            case A::USER:
                $id_table = A::USER_ID;
                $dir = "media/logo/user/";
                break;  
            case A::ASSO:
                $id_table = A::ASSO_ID;
                $dir = "media/logo/asso/";
                break;
            case A::EVENT:
                $id_table = A::EVENT_ID;
                $dir = "media/logo/event/";
                break;
        }
        if(BF::equals($table,A::EVENT))
            $req_logo = "SELECT logo FROM ".A::PROPEVENT." WHERE ".A::PROPASSO_NOM." like 'logo' AND $id_table = ? ";
        else
            $req_logo = "SELECT logo FROM $table WHERE $id_table = ? ";//on vérifie que le nom n'est pas déjà pris
        $req_logo_2 = $db->prepare($req_logo);
        $req_logo_2->execute(array($id));
        $logo = $req_logo_2->fetch(PDO::FETCH_NUM);
        if(count($logo)==1&&strlen($logo[0])){
            $file = BF::abs_path($dir.strval($logo[0]));
            $file_php = BF::abs_path($dir.strval($logo[0]),true);
        }
            

        if(count($logo)== 1 &&strlen($logo[0])>0 && file_exists($file_php))
            return $file;
        else return false;
    }

    

    /**
     *  Method setImage
     * 
     * Permet de saisir les informations de l'image téléchargée via $_POST dans une variable que sera ensuite utilisée 
     * 
     * @return image
     */

    public function setImage($file){
        if($file['error'] != UPLOAD_ERR_OK)
            exit("Erreur d'upload");
        $this->name=$file['name'];
        $this->type=$file['type'];
        $this->size=$file['size'];
        $this->tmp_name=$file['tmp_name'];
        $this->error=$file['error'];
        $this->fullpath="";
        $this->chemin = "";
        return $this;
    }
    public function deleteImage($id,$table){
        global $db;
        switch($table){
            case A::USER:
                $id_table = A::USER_ID;
                $dir = BF::abs_path("media/logo/user/",true);
                break;
            case A::ASSO:
                $id_table = A::ASSO_ID;
                $dir = BF::abs_path("media/logo/asso/",true);
                break;
            case A::EVENT:
                $id_table = A::EVENT_ID;
                $dir = BF::abs_path("media/logo/event/",true);
                break;
        }
        //supprimer l'image puis le lien dans la table
        if(BF::equals($table,A::EVENT))
            $req_logo = "SELECT ".A::PROPEVENT_VALEUR." FROM ".A::PROPEVENT." WHERE ".A::PROPEVENT_NOM." = 'logo' AND $id_table = ? ";
        else
            $req_logo = "SELECT logo FROM ".$table." WHERE $id_table =? ";//on vérifie que le nom n'est pas déjà pris
        $req_logo_2 = $db->prepare($req_logo);
        $req_logo_2->execute(array($id));
        $logo = $req_logo_2->fetch(PDO::FETCH_NUM);
        if(count($logo)== 0){return 0;}
        if(count($logo)!= 0){
            //on supprime l'image situé à l'emplacement $logo
            try {
                if (file_exists($dir.$logo[0]) && strlen($logo[0])>0 && unlink($dir.$logo[0]) == false) {
                    if(BF::equals($table,A::EVENT)){
                        $req_logo = "DELETE FROM ".A::PROPEVENT." WHERE ".A::PROPEVENT_NOM." = 'logo' AND $id_table = ? ";
                    }else{
                        $req_logo = "UPDATE $table SET logo = NULL WHERE $id_table =? ";//on vérifie que le nom n'est pas déjà pris
                    }
                    BF::request($req_logo,[$id]);
                    return 0;
                }
            } catch (Exception $e) {
                return 0;
            }
            
                   
        }
        if(BF::equals($table,A::EVENT))
            $req_suppr = "DELETE FROM ".A::PROPEVENT." WHERE ".A::PROPEVENT_NOM." = 'logo' AND ".$id."=? ";
        else
            $req_suppr = "UPDATE $table
            SET logo = NULL
            WHERE $id = ?;
            ";
        $req_suppr_2 = $db->prepare($req_suppr);
        $req_suppr_2->execute(array($id));
    }
    

  

    
    /**
     * Method placer_image
     *
     * 
     * @param $table $table [la table où le chemin de l'asso sera stockée]
     * @param $chemin $chemin [chemin depuis la racine où l'on souhaite que l'image soit stockée]
     *
     * Permet de rentrer de manière sécurisée l'image $this dans la base de donnée 
     * @return void
     */
    
    /*
    *A été modifié : à retester
    */
    /*Deuxième modif : la fonction prends un argument $image qui est un objet de la classe image qui a été créé à partir des données 
    récupérées dans FILE. De ce que j'ai compris après le chargement de l'image pas la méthode POST l'image est stockée quelque part
    et toutes les fonctions permettant de déplacer une image et tout prennent en argument le nom de l'imgage puis vont la chercher. 
    Le champs tmp_nom est le champs contenant le nom de l'image sur le serveur (celui qui nous intéresse) et le champs name contient 
    le nom d'origine de l'image (il ne nous intéresse pas)
    */ 

    public function placer_image($table,$chemin,$id){
        global $db;
        switch($table){
            case A::USER:
                $id_table = A::USER_ID;
                break;
            case A::ASSO:
                $id_table = A::ASSO_ID;
                break;
            case A::EVENT:
                $id_table = A::EVENT_ID;
                break;
        }

        $unique = false;
        $ext = pathinfo($this->name, PATHINFO_EXTENSION);


        while(!$unique){
            $image_name_num =  str_replace(" ","",sha1(str_replace(" ","",uniqid("",true))));   
            if ($this->getImage($image_name_num,$table) == false) {
      //donc si le nom est bien unique on peut juste sortir de la boucle
                $unique = true;
            }
        }
        //changer le nom
        $image_name=$image_name_num;
        
        //Mettre l'image dans le fichier logo/user/
        $destinationPath = $chemin.$image_name.".".$ext;
        $this->chemin = $chemin;
        array_map('unlink', glob($chemin.$image_name.".*")); //On supprime les fichiers résiduels
        if(move_uploaded_file($this->tmp_name, $destinationPath)) { 
        } //la fonction move_uploaded_file déplace le fichier dans destination et renvoie un si l'opération est un succés 0 sinon
        else{
            echo "Il y a eu une erreur pour poster le fichier, réessayez.\n";
            echo $destinationPath;
        }
        $this->fullpath=$destinationPath;
        //rename($destinationPath, $newDestinationPath);
        //UPDATE le chemin vers l'image dans la BDD
        if(BF::equals($table,A::EVENT))
        {
            require_once BF::abs_path("libs/Event.php",true);
            $event = new Event($id);
            $event->insert_prop("logo",$destinationPath);
        }
            
        else
            BF::request("UPDATE $table SET logo = ? WHERE $id_table = ?",[basename($destinationPath),$id]);
        
 
  
  
}
    public function verifier_format(){
        $allowed_extensions = array('jpg', 'jpeg', 'png');
       
        $extension = pathinfo($this->name, PATHINFO_EXTENSION);
    
    //on vérifie le format de l'image
        if (!in_array($extension, $allowed_extensions)) {
        echo "Cette extension n'est pas authorisée. Les authorisations authorisées sont jpg, jpeg et png";
        }
        //Vérifier qu'il n'y a pas de points autres que celui de l'extension dans le nom de l'image pour éviter une double extension
        $taille = count(explode(".",$this->name));
        if($taille>2)
            exit("Nom de fichier invalide : vous essayez d'insérer plusieurs extensions");
        
    }
    /**
     * Method modifier_image
     * 
     * @param $lien_image [Un lien vers l'image à modifier. L'image doit DEJA être mise dans la base de donnée]
     * 
     * @return int
     * Permet de modifier et de mettre aux normes une image DEJA dans la base de donnée. Retourne 1 si l'opération a réussi et 0 sinon.
     */

    public function modifier_image($lien_image){
        $name=basename($lien_image);

        $ext=pathinfo($name,PATHINFO_EXTENSION);
        if(strcmp($ext,"jpg")==0 ||strcmp($ext,"jpeg")==0){
            $im_php = imagecreatefromjpeg($this->fullpath);
            if($im_php==false){return 0;}
        }

        elseif(strcmp($ext,"png")==0){
            $im_php = imagecreatefrompng($this->fullpath);
            if($im_php==false){return 0;}
        }
        else{return 0;}

        //mettre les modifications souhaitées
        list($width, $height) = getimagesize($this->fullpath);
        if($width== 0|| $height== 0){return 0;}

        $image_p = imagescale($im_php,600,600, IMG_BICUBIC);
          
       
        //on redimentionne l'image et on vérifie qu'il n'y a pas d'erreur
        if($image_p==false){return 0;}

        
        if(imagejpeg($image_p, $lien_image)==false){return 0;} //même lien que l'image originale, donc normalement écrase l'image originale (il faudra néanmoins vérifier dans la doc)
        //revoir les messages d'erreur en fonction des fonctions de modification

        return 1;
    }


}

?>