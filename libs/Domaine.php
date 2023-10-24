<?php
require_once __DIR__."/../functions/basic_functions.php";
require_once BF::abs_path("db.php",true);
class Domaine{
    /*
    Abstraction de la table domaine
    */
    private $id;
    public function __construct($id = null){
        /*
        Constructeur de la classe
        */
        $this->id = $id; 
    }
    public function get_nom(){
        $array = BF::request("SELECT nom_domaine FROM domaine WHERE id = ?",[$this->id],true,true,PDO::FETCH_ASSOC);
        return $array["nom_domaine"];
    }
}

?>