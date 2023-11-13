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
     * Method insert
     *
     * @param string  $nom_domaine $nom_domaine [Du du domaine que l'on veut créer]
     *
     * @return Domaine
     */
    public static function insert($nom_domaine){
        //Insertion du domaine
        BF::request("INSERT INTO ".A::DOMAINE." (".A::DOMAINE_NOM.") VALUES (?)",[$nom_domaine],false);
        //Récupération de l'id
        $id = BF::request("SELECT ".A::DOMAINE_ID." FROM ".A::DOMAINE." WHERE ".A::DOMAINE_NOM." LIKE ?",[$nom_domaine],true,true)[0];
        return new Domaine($id);
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
        
    /**
     * Ajoute une jonction avec la cible. Définis automatiquement le type de jonction
     * selon la classe de la cible
     *
     * @param $cible $cible [Instance de la cible (user / asso / event)]
     *
     * @return void
     */
    public function insert_jonction($cible){
        if($cible instanceof User)
            $type = 0;
        else if($cible instanceof Asso)
            $type = 1;
        else if($cible instanceof Event)
            $type = 2;
        BF::request("INSERT INTO ".A::DOMAINEJONCTION." (".A::DOMAINEJONCTION_ID_DOMAINE.",".A::DOMAINEJONCTION_ID_JONCTION.",".A::DOMAINEJONCTION_TYPE.") VALUES (?,?,?)",[$this->id,$cible->id,$type],false);
    }


    
}

?>