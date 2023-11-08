<?php
require_once __DIR__."/../functions/basic_functions.php";
require_once BF::abs_path("db.php",true);
require_once __DIR__."/Ressources/NomsAttributsTables.php";
require_once __DIR__."/Ressources/LibsInterfaces.php";
use AttributsTables as A;
/**
 * Abstraction table asso
 */
class Asso implements Suppression, GestionMembres, GestionLogo{  
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
   * Renvoie la liste des missions de l'asso sous la forme:
   * array([
   *   0 : [
   *   "id_event" : x
   *  ],
   *   1 : [
   *   "id_event" : y
   *   ],
   *   ...
   * ])
   *
   * @return array
   */
  public function liste_missions(){
    $req = "SELECT ".A::EVENT_ID." FROM ".A::EVENT." WHERE ".A::EVENT_ID_ASSO." = ?";
    $array = BF::request($req,[$this->id],true,false,PDO::FETCH_ASSOC);
    return $array;
  }
  
  /**
   * Renvoie la liste des membres de l'asso, ainsi que leur nom, prénom, statut
   *
   * @return array
   */
  public function get_all_membres(){
    $req  = "SELECT u.".A::USER_NOM.", u.".A::USER_PRENOM.", ma.*
    FROM ".A::MEMBRESASSOS."
    INNER JOIN ".A::USER." u ON membres_assos ma.".A::MEMBRESASSOS_ID_USER." = u.".A::USER_ID."
    WHERE ma.".A::MEMBRESASSOS_ID_ASSO." = ?";
    $array = BF::request($req,[$this->id],true,false,PDO::FETCH_ASSOC);
    return $array;
  }
    
  /**
   * Renvoie le nom et l'id des assos dont le nom commence par $searchQuery
   *
   * @param string $searchQuery $searchQuery [explicite description]
   *
   * @return array
   */  
  public function recherche_asso($searchQuery) {
    $searchQuery = "%" . $searchQuery . "%";
    return BF::request("SELECT ".A::ASSO_ID.", ".A::ASSO_NOM." FROM ".A::ASSO." WHERE ".A::ASSO_NOM." LIKE ?", [$searchQuery], true, false, PDO::FETCH_ASSOC);
  }
  
  /**
   * Renvoie toutes les propriétés de l'association sous la forme: array(
   *     'prop_assos' => $propAssos,      (array)
   *     'asso_info' => $assoInfo,        (array)
   *     'membres_count' => $membresCount,(int)
   * );
   *
   * @return array
   */
  public function prop_association() {
    $id_asso = $this->id;
    // Sélectionner les propriétés de l'association
    $propAssos = BF::request("SELECT * FROM ".A::PROPASSO." WHERE ".A::PROPASSO_ID_ASSO." = ?", [$id_asso], true, false, PDO::FETCH_ASSOC);

    // Sélectionner les informations de l'association
    $assoInfo = BF::request("SELECT * FROM ".A::ASSO." WHERE ".A::ASSO_ID." = ?", [$id_asso], true, false, PDO::FETCH_ASSOC);

    // Compter les membres de l'association
    $membresCount = BF::request("SELECT COUNT(*) FROM ".A::MEMBRESASSOS." WHERE ".A::MEMBRESASSOS_ID_ASSO." = ?", [$id_asso], true, true)[0];

    return array(
        'prop_assos' => $propAssos,
        'asso_info' => $assoInfo,
        'membres_count' => $membresCount
    );
  }
  
  /**
   * Renvoie des infos sur les events (heure début/fin) + des infos sur l'asso
   * 
   * Concrètement, renvoie une array avec les champs id_event, nom_event, date_debut, date_fin, nom, id
   * 
   * Où nom et id concernent l'asso
   *
   * @return array
   */
  public function get_infos_events(){
    return BF::request("SELECT e.".A::EVENT_ID.", e.".A::EVENT_NOM.", ho.".A::HORAIRE_DATE_DEBUT.", ho.".A::HORAIRE_DATE_FIN.", a.".A::ASSO_NOM.", a.".A::ASSO_ID." FROM ((".A::EVENT." e JOIN ".A::ASSO." a ON e.".A::EVENT_ID." = a.".A::ASSO_ID.") JOIN ".A::HORAIRE." ho ON e.".A::EVENT_ID_HORAIRE." = ho.".A::HORAIRE_ID.") WHERE a.".A::ASSO_ID." = ?",[$this->id],true,false,PDO::FETCH_ASSOC);
  }

  /**
   * A faire, crée une asso
   * @todo 
   */
  public static function insert($nom, $description, $domaines, $missions, $lieu, $email, $telephone) {

    //On insère d'abord le lieu
    BF::request("INSERT INTO ".A::LIEU." (".A::LIEU_DEPARTEMENT.", ".A::LIEU_ADRESSE.") VALUES (?, ?)",[$departement,$adresse]);
    $id_lieu = $db->lastInsertId();

    // On insère les données de l'association dans la base de données
    $assoInsertQuery = "INSERT INTO " . A::ASSO . " (" . A::ASSO_NOM . ", " . A::ASSO_DESCRIPTION . ", " . A::ASSO_DOMAINES . ", " . A::ASSO_DESCRIPTION_MISSIONS . ", " . A::ASSO_ID_LIEU . ", " . A::ASSO_EMAIL . ", " . A::ASSO_TELEPHONE . ") VALUES (?, ?, ?, ?, ?, ?, ?)";
    BF::request($evenementInsertQuery,[$nom, $description, $domaines, $missions, $id_lieu, $email, $telephone], false);

    $id_asso = $db->lastInsertId();

    return new Asso($id_asso);
}


  /**
   * A faire
   * @todo permet de supprimer toutes les données relatives à l'association
   */
  public function suppr(){

  }

  /**
   * Ajoute un membre
   * @todo 
   */
  public function ajouter_membre($user, $role = null){

  }

  /**
   * Supprime un membre
   * @todo
   */
  public function supprimer_membre($user){

  }
  /**
   * Faire simplement appel aux 2 fonctions ci-dessus
   * @todo
   */
  public function modifier_role_membre($user, $role){

  }

  /**
   * Ajoute un logo à l'asso
   * @todo
   */
  public function ajouter_logo(){
    
  }

  /**
   * Renvoie le chemin du logo pour l'implémenter en HTML
   * @todo
   */
  public function get_logo(){

  }
  /**
   * Supprime le logo
   */
  public function suppr_logo(){

  }

  /**
   * @todo
   */
  public function get_prop_value($prop_name){

  }

  /**
   * @todo
   */
  public function insert_prop($prop_name,$prop_value){

  }

  /**
   * @todo
   */
  public function suppr_prop($prop_name){
    
  }

}
?>