<?php
require_once __DIR__."/../functions/basic_functions.php";
require_once BF::abs_path("db.php",true);

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
        
        $array = BF::request("SELECT nom_domaine FROM domaine WHERE id = ?",[$this->id],true,true,PDO::FETCH_ASSOC);
        return $array["nom_domaine"];
    }    
    /**
     * Renvoie toutes les infos des domaines
     *
     * @return void
     */
    public static function get_all(){
        $array = BF::request("SELECT * FROM domaine",[],true,false,PDO::FETCH_ASSOC);
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
        BF::request("INSERT INTO domaine (nom_domaine) VALUES (?)",[$nom_domaine],false);
        //Récupération de l'id
        $this->id = BF::request("SELECT id_domaine FROM domaine WHERE nom_domaine LIKE ?",[$nom_domaine],true,true)[0];
    }
    
    /**
     * Renvoie le nombre de domaines
     *
     * @return int
     */
    public static function nombre_domaines(){
        return BF::request("SELECT COUNT(*) FROM domaine",[],true,false)[0];
    }
}

?>