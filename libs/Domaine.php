<?php
require_once __DIR__."/../functions/basic_functions.php";
require_once BF::abs_path("db.php",true);
require_once __DIR__."/Ressources/NomsAttributsTables.php";
use AttributsTables as A;
/**
* Abstraction de la table domaine
**/
class Domaine{
    
    private $id;   
    /**
     * Method __construct
     *
     * @param int $id $id [explicite description]
     *
     * @return void
     */
    public function __construct($id = null){
        
        $this->id = $id; 
        
    }
    /**
    * Renvoie le nom du domaine
    **/
    public function get_nom(){
        
        $array = BF::request("SELECT ".A::DOMAINE_NOM." FROM ".A::DOMAINE." WHERE ".A::DOMAINE_ID." = ?",[$this->id],true,true,PDO::FETCH_ASSOC);
        return $array[A::DOMAINE_NOM];
    }    
    /**
     * Renvoie toutes les infos des domaines
     *
     * @return array
     */
    public static function get_all(){
        return BF::request("SELECT * FROM ".A::DOMAINE,[],true,false,PDO::FETCH_ASSOC);
    }
    
    /**
     * Method create_domaine
     *
     * @param string  $nom_domaine $nom_domaine [Du du domine que l'on veut créer]
     *
     * @return void
     */
    public function create_domaine($nom_domaine){
        //Insertion du domaine
        BF::request("INSERT INTO ".A::DOMAINE." (".A::DOMAINE_NOM.") VALUES (?)",[$nom_domaine],false);
        //Récupération de l'id
        $this->id = BF::request("SELECT ".A::DOMAINE_ID." FROM ".A::DOMAINE." WHERE ".A::DOMAINE_NOM." LIKE ?",[$nom_domaine],true,true)[0];
    }
    
    /**
     * Renvoie le nombre de domaines
     *
     * @return int
     */
    public static function nombre_domaines(){
        return BF::request("SELECT COUNT(*) FROM ".A::DOMAINE,[],true,false)[0];
    }

    /**
     * Vérifie si l'élément a comme domaine le domaine correspondant
     * @todo
     */
    public function detient_domaine($objet){
        if($objet instanceof Asso){

        }elseif($objet instanceof Event){

        }elseif($objet instanceof User){

        }
    }
    
}

?>