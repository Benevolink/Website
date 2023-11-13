<?php
require_once __DIR__."/../functions/basic_functions.php";
require_once BF::abs_path("db.php",true);
require_once __DIR__."/Ressources/NomsAttributsTables.php";
require_once __DIR__."/Ressources/LibsInterfaces.php";
use AttributsTables as A;
/**
 * Abstraction table asso
 */
class Lieu implements Suppression{  
  /**
   * id : l'id de l'utilisateur
   *
   * @var int
   */
  public $id;
  /**
   * Constructeur
   *
   * @param int $id $id [id association]
   *
   * @return void
   */
  function __construct($id){
    $this->id = $id;
  }
  
  /**
   * @todo
   * Supprime le lieu
   */
  public function suppr(){

  }

  public static function insert($adresse = null,$departement = null){
    if(is_null($departement)&&is_null($adresse)) return false;
    if(is_null($departement)){
        BF::request("INSERT INTO ".A::LIEU." (".A::LIEU_ADRESSE.") VALUES (?)",[$adresse],false);
        return true;
    }
    if(is_null($adresse)){
        BF::request("INSERT INTO ".A::LIEU." (".A::LIEU_DEPARTEMENT.") VALUES (?)",[$departement],false);
        return true;
    }
    BF::request("INSERT INTO ".A::LIEU." (".A::LIEU_DEPARTEMENT.",".A::LIEU_ADRESSE.") VALUES (?)",[$departement, $adresse],false);
    return true;
       
  }  
  
}