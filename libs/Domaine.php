<?php
class Domaine{
    /*
    Abstraction de la classe domaine
    */
    public $id;
    public function __construct($id){
        $this->id = $id;
    }

    public function get_name(){
        /*
        Retourne le nom du domaine
        */
        try{
            return BF::request("SELECT nom_domaine FROM domaine WHERE id_domaine = ?",[$this->id],true,true)[0];
        }catch(Exception $e){
            echo "".$e->getMessage()."";
            return false;
        }
    }

    public static function get_all(){
        /*
        Renvoie toute la table
        */
        return BF::request("SELECT * FROM domaine",[],true,false,PDO::FETCH_ASSOC);
    }
}
?>