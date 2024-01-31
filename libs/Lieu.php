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
 *
 * @return bool
 */
public function suppr(){
  $id_lieu = $this->id;

  // Vérifie si des événements sont liés à ce lieu
  $evenementsAssocies = BF::request("SELECT COUNT(*) FROM ".A::EVENT." WHERE ".A::EVENT_ID_LIEU." = ?", [$id_lieu], true, true)[0];

  if ($evenementsAssocies > 0) {
      // Il y a des événements associés, gérer ce cas selon les besoins
      return false;
  } else {
      // Aucun événement associé, on peut supprimer le lieu

      // Supprimer le lieu
      BF::request("DELETE FROM ".A::LIEU." WHERE ".A::LIEU_ID." = ?", [$id_lieu], false, false);

      // Retourne un statut ou un message indiquant le résultat de l'opération
      return true;
  }
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
    
  /**
   * Method calc_distance
   *
   * @param int $id_lieu_1 $id_lieu_1 [explicite description]
   * @param int $id_lieu_2 $id_lieu_2 [explicite description]
   *
   * @return float la distance
   */
  public static function calc_distance($id_lieu_1, $id_lieu_2)
  {
    $table1 = BF::request("SELECT coordonee_x, coordonee_y FROM ".A::LIEU." WHERE ".A::LIEU_ID." = ?",[$id_lieu_1],true,true)[0];
    $x1 = $table1[0];
    $y1 = $table1[1];
    $table2 = BF::request("SELECT coordonee_x, coordonee_y FROM ".A::LIEU." WHERE ".A::LIEU_ID." = ?",[$id_lieu_2],true,true)[0];
    $x2 = $table2[0];
    $y2 = $table2[1];
    return sqrt(($x1-$x2)**2 + ($y1-$y2)**2);
    
  }

}
