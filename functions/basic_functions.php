<?php require_once __DIR__.'/../links.php';

class BF{
    /**
     * @author Benevolink
     * 
     * Réuni un recueil de fonctions de base
     * 
     * @version 1.2
     */
    
    public static function sess_start(){
      /**
      * Vérifie que la session est lancée. Si non, la lance.
      * Fonctionne pour les versions PHP 4 et supérieures
      * 
      * @return true
      * @throws false
      * @since 1.1
      */
        try{
            if(version_compare(phpversion(),'5.4.0','<')){
                if(session_id() == '') {
                    session_start();
                }
            }else{
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
            }
            return true;
        }catch(Exception $e){
            return false;
        }
        
    }
    
    public static function is_connected(){
      /**
     * Vérifie que l'utilsateur est connecté
     * @return boolean true si l'utilisateur est connecté, false sinon
     * @throws false
     * @since 1.0
     */
        try{
            if(isset($_SESSION["auth"]) && $_SESSION["auth"]==1 && isset($_SESSION["user_id"])){
                return true;
            }return false;
        }catch(Exception $e){
            return false;
        }
    }

    
    public static function equals($x1,$x2){
      /**
     * Compare n'importes quelles variables
     * @since 1.0
     * @param $x1
     * @param $x2
     * @return boolean
     * @throws false
     */
        try{
            //string case
            if(is_string($x1)&&is_string($x2)){
                return strcmp($x1,$x2)==0;
            }
            //numeric case
            if(is_numeric($x1)&&is_numeric($x2)){
                return $x1==$x2;
            }
            //case if object of any types
            if($x1 === $x2){
                return $x1 == $x2;
            }
        }catch(Exception $e){
            return false;
        }
    }

    
    public static function abs_path($string,$php_mode=false){
      /**
     * Transforme en chemin absolu (à partir du fichier racine)
     * @since 1.0
     * @param string le chemin relatif
     * @param boolean indique si le chemin sert pour du php ou du html
     * @return string le chemin absolu
     * @throws false si le fichier n'existe pas ou une erreur quelconque
     */
        try{
            if($php_mode){
                global $path;
            }else{
                global $path_html;
                $path = $path_html;
            }  
            //On enlève les slashs du début du string
            while(BF::equals(mb_substr($string,0,1),'/') || BF::equals(mb_substr($string,0,1),'.')){
                $string = mb_substr($string,1);
            }
            $value = $path.'/'.$string;
            if(file_exists($value)){
                return $value;
            }
            return $value;
        }catch(Exception $e){
            echo 'erreur';
            return false;
        }
    }

    
    private static function is_posted_intern($string){
        /**
         * Renvoie true si le $_GET ou le $_COOKIE ou le $_POST ou le $_FILES existe
         * @since 1.0
         * 
         * @param string $string
         * 
         * @throws string ""
         * 
         * @return boolean
         */
        if(isset($_GET[$string])){
            return true;
        }
        if(isset($_COOKIE[$string])){
            return true;
        }
        if(isset($_POST[$string])){
            return true;
        }
        if(isset($_FILES[$string])){
            return true;
        }
        return false;
    }
    
    public static function is_posted($string){
      /**
       * Même fonction que is_posted_intern mais qui fonctionne aussi pour des listes d'éléments
       */
        if(is_array($string)){
            foreach($string as $key => $value){
                if(!BF::is_posted_intern($value)){
                    return false;
                }
            }
            return true;
        }return BF::is_posted_intern($string);
    }

    
    public static function request($request,$params,$fetch=false,$fetch_one=false,$pdo_fetch_mode=false){
        /**
       * Permet de faire des requêtes paramétrées de manière simple.
       * @since 1.0
       * ab
       * @param string $request la requête (mettre des ? à la place des paramètres)
       * @param array $params les paramètres de la requête. /!\ il faut les mettre dans l'ordre
       * @param boolean $fetch true si il faut faire un fetch pour retourner un tableau
       * @param boolean $fetch_one true si on execute fetch() à la place de fetchAll()
       * @param PDO::FETCH_MODE $pdo_fetch_mode le mode du fetch.
       * 
       * @return boolean (ou array si le mode fetch est activé)
       * 
       * @throws false
       */
        //On récupère la base de données
        global $db;
        if(isset($db)&& ($db instanceof PDO)){
            try{
                $req = $db->prepare($request);
                foreach($params as $key => $value){ //On échape les arguments
                  $params[$key] = BF::XSS($params[$key]); 
                }
                $req->execute($params);
                if($fetch){
                    if($fetch_one){
                        return $req->fetch();
                    }
                    if($pdo_fetch_mode != false){
                        return $req->fetchAll($pdo_fetch_mode);
                    }
                    return $req->fetchAll();
                    
                }
                return true;
            }catch(Exception $e){
                echo "<br>Erreur dans l'exécution de la requête ".$request.": ".$e->getMessage();
                echo "<br>Les paramètres sont :";
                foreach($params as $key => $value){
                    echo '<br>'.$value;
                }
                return false;
            }
        }else{
            echo "Erreur dans l'importation de la base de données";
            return false;
        }
    }

    
    public static function XSS($strin,$safe_mode=false){
      /**
      *Empêche les injections XSS
      *@since 1.0
      *
      *@param string $string
      *@param boolean $safemode Détermine si il faut modifier tous les caractères qui ne sont pas des lettres.
      *@return string
      */
      $strout = null;
      
      //vérifier si le paramètre de est une chaine de caractère ou non. Si ce n'est pas une chaine de caractère renvoyer $strin  
      if(strcmp(gettype($strin),"string")!=0){
        $strout = $strin;
        return $strin;
      }
      for ($i = 0; $i < strlen($strin); $i++) {
              $ord = ord($strin[$i]);
        

              if ($safe_mode && (($ord > 0 && $ord < 32) || ($ord >= 127))) {
                      $strout .= "&amp;#{$ord};";
              }
              else {
                      switch ($strin[$i]) {
                              case '<':
                                      $strout .= '&lt;';
                                      break;
                              case '>':
                                      $strout .= '&gt;';
                                      break;
                              case '&':
                                      $strout .= '&amp;';
                                      break;
                              case '"':
                                      $strout .= '&quot;';
                                      break;
                              default:
                                      $strout .= $strin[$i];
                      }
              }
      }

        return $strout;
    }
    
    public static function is_admin($id_user,$id_asso){
        /**
       * Vérifie que l'utilisateur est admin de l'asso
       * @since 1.1
       * 
       * @param int id_user
       * @param int id_asso
       * 
       * @return bool
       */
        $req = "SELECT statut FROM membres_assos WHERE id_user = ? AND id_asso = ?";
        $result = BF::request($req,[$id_user,$id_asso],true,true)[0];
        /*return BF::equals($result,"ADMIN");*/
        return ($result==3);
    }
    
    public static function role_user($id_user,$id_asso){
        /**
       * Vérifie que l'utilisateur est admin de l'asso
       * @since 1.2
       * 
       * @param int id_user
       * @param int id_asso
       * 
       * @return bool
       */
        $req = "SELECT statut FROM membres_assos WHERE id_user = ? AND id_asso = ?";
        $result = BF::request($req,[$id_user,$id_asso],true,true)[0];
        /*return BF::equals($result,"ADMIN");*/
        return $result;
    }
    
    public static function get_user_assos($id_user){
        /**
       * Renvoie l'id de toutes les assos de l'utilisateur
       * @since 1.1
       * 
       * @param int id_user
       * 
       * @return array la liste des ids des assos
       */
        $req = "SELECT id_asso FROM membres_assos WHERE id_user = ?";
        $result = BF::request($req,[$id_user],true);
        $return = array();
        foreach($result as $key => $value){
            $return[] = $value[0];
        }
        return $return;
    }

    
    public static function get_asso_events($id_asso){
        /**
       * Renvoie l'id de tous les évènements de l'asso
       * @since 1.1
       * 
       * @param int id_asso
       * 
       * @return array la liste des ids des events
       */
        $req = "SELECT id_event FROM evenements WHERE id_asso = ?";
        $result = BF::request($req,[$id_asso],true);
        $return = array();
        foreach($result as $key => $value){
            $return[] = $value[0];
        }
        return $return;
    }


    public static function afficher_template($content){
      /*
      Permet d'afficher tout le contenu de la page qui a été capturé dans le template
      */
      require_once BF::abs_path("view/template.php",true);
    }

  public static function go_home(){
    /*
    Permet de revenir à la page d'accueil
    */
    header("Location: ".BF::abs_path("",true));
    exit();
  }
}
?>