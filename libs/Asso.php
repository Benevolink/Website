<?php
require_once __DIR__."/../functions/basic_functions.php";
require_once BF::abs_path("db.php",true);
/**
 * Abstraction table asso
 */
class Asso{  
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
    $req = "SELECT id_event FROM evenements WHERE id_asso = ?";
    $array = BF::request($req,[$this->id],true,false,PDO::FECTH_ASSOC);
    return $array;
  }
  
  /**
   * Renvoie la liste des membres de l'asso, ainsi que leur nom, prénom, statut
   *
   * @return array
   */
  public function liste_membres_noms(){
    $req  = "SELECT users.nom, users.prenom, membres_assos.*
    FROM membres_assos
    INNER JOIN users ON membres_assos.id_user = users.id
    WHERE membres_assos.id_asso = ?";
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
    return BF::request("SELECT id, nom FROM assos WHERE nom LIKE ?", [$searchQuery], true, false, PDO::FETCH_ASSOC);
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
    $propAssos = BF::request("SELECT * FROM prop_assos WHERE id_asso = ?", [$id_asso], true, false, PDO::FETCH_ASSOC);

    // Sélectionner les informations de l'association
    $assoInfo = BF::request("SELECT * FROM assos WHERE id = ?", [$id_asso], true, false, PDO::FETCH_ASSOC);

    // Compter les membres de l'association
    $membresCount = BF::request("SELECT COUNT(*) FROM membres_assos WHERE id_asso = ?", [$id_asso], true, true)[0];

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
    return BF::request("SELECT e.id_event, e.nom_event, ho.date_debut, ho.date_fin, a.nom, a.id FROM ((evenements e JOIN assos a ON e.id_asso = a.id) JOIN horaire ho ON e.id_horaire = ho.id_horaire) WHERE a.id = ?",[$this->id],true,false,PDO::FETCH_ASSOC);
  }

}
?>