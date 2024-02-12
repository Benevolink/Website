<?php
require_once __DIR__."/../functions/basic_functions.php";
require_once BF::abs_path("db.php",true);
require_once __DIR__."/Ressources/NomsAttributsTables.php";
use AttributsTables as A;
/**
* Abstraction de la table domaine
**/
class Competence{
    
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

    public static function get_all()
    {
        return BF::request("SELECT * FROM competences",[],true,false,PDO::FETCH_ASSOC);
    }
   
    
}

?>