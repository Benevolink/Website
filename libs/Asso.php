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
  public static function recherche_asso($searchQuery) {
    $searchQuery = "%" . $searchQuery . "%";
    return BF::request("SELECT ".A::ASSO_ID.", ".A::ASSO_NOM." FROM ".A::ASSO." WHERE ".A::ASSO_NOM." LIKE ? ORDER BY ".A::ASSO_NOM." ASC", [$searchQuery], true, false, PDO::FETCH_ASSOC);
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
public static function insert($nom, $description, $lieu, $email, $telephone, $logo = null){
  // Vérifier que le nom de l'association n'existe pas déjà
  $existingAssociation = BF::request("SELECT COUNT(*) FROM ".A::ASSO." WHERE ".A::ASSO_NOM." = ?", [$nom], true, true)[0];

  if ($existingAssociation == 0) {
      // Le nom de l'association n'existe pas encore, nous pouvons créer l'association
      
      // Préparer la déclaration INSERT
      $insertSQL = "INSERT INTO ".A::ASSO." (".A::ASSO_NOM.", ".A::ASSO_DESCRIPTION.", ".A::ASSO_ID_LIEU.", ".A::ASSO_EMAIL.", ".A::ASSO_TELEPHONE.", ".A::ASSO_LOGO.") VALUES (?, ?, ?, ?, ?, ?)";
      
      // Valeurs à insérer
      $insertValues = [$nom, $description, $lieu, $email, $telephone, $logo];

      // Exécuter la déclaration INSERT
      BF::request($insertSQL, $insertValues, false, false);
      
      // Retourner un statut ou un message indiquant le résultat de l'opération
      return "Association créée avec succès.";
  } else {
      // Le nom de l'association existe déjà, gérer ce cas selon les besoins
      return "Une association avec ce nom existe déjà.";
  }
}

  /**
   * A faire
   * @todo permet de supprimer toutes les données relatives à l'association
   */
  public function suppr(){
    $id_asso = $this->id;
      
    BF::request("DELETE FROM ".A::EVENT." WHERE ".A::EVENT_ID_ASSO." = ?", [$id_asso], false, false);
    BF::request("DELETE FROM ".A::MEMBRESASSOS." WHERE ".A::MEMBRESASSOS_ID_ASSO." = ?", [$id_asso], false, false);
    BF::request("DELETE FROM ".A::PROPASSO." WHERE ".A::PROPASSO_ID_ASSO." = ?", [$id_asso], false, false);
    BF::request("DELETE FROM ".A::ASSO." WHERE ".A::ASSO_ID." = ?", [$id_asso], false, false);
    
    // Ajouter un commit pour le changements
    // Peut etre PDO::commit()
    return "Données d'association supprimés";

  }

  /**
   * Ajoute un membre
   * @todo 
   */
  public function ajouter_membre($user, $role = null){
/**
 * Ajoute un membre
 * @param int $user L'ID de l'utilisateur à ajouter en tant que membre
 * @param string $role Le rôle du membre (facultatif)
 */
  $id_asso = $this->id;
  
  // Vérifie si l'utilisateur est déjà membre de l'association
  $estMembre = BF::request("SELECT COUNT(*) FROM ".A::MEMBRESASSOS." WHERE ".A::MEMBRESASSOS_ID_USER." = ? AND ".A::MEMBRESASSOS_ID_ASSO." = ?", [$user, $id_asso], true, true)[0];
  
  if ($estMembre == 0) {
      // L'utilisateur n'est pas encore membre, nous pouvons donc l'ajouter
      
      // Prépare la déclaration INSERT pour ajouter l'utilisateur en tant que membre
      $insertSQL = "INSERT INTO ".A::MEMBRESASSOS." (".A::MEMBRESASSOS_ID_USER.", ".A::MEMBRESASSOS_ID_ASSO;
      $insertValues = [$user, $id_asso];
      
      // Ajoute le rôle s'il est fourni
      if ($role !== null) {
          $insertSQL .= ", ".A::MEMBRESASSOS_STATUT;
          $insertValues[] = $role;
      }
      
      $insertSQL .= ") VALUES (";
      $insertSQL .= implode(", ", array_fill(0, count($insertValues), "?"));
      $insertSQL .= ")";
      
      // Exécute la déclaration INSERT
      BF::request($insertSQL, $insertValues, false, false);
      
      // Retourne un statut ou un message indiquant le résultat de l'opération
      return "Membre ajouté avec succès.";
  } else {
      // L'utilisateur est déjà membre, gérer ce cas selon les besoins
      return "L'utilisateur est déjà membre de l'association.";
  }
}



/**
 * Supprime un membre
 * @param int $user L'ID de l'utilisateur à supprimer
 * @todo
 */
public function supprimer_membre($user){
  $id_asso = $this->id;

  // Vérifier si l'utilisateur est membre de l'association
  $isMember = BF::request("SELECT COUNT(*) FROM ".A::MEMBRESASSOS." WHERE ".A::MEMBRESASSOS_ID_USER." = ? AND ".A::MEMBRESASSOS_ID_ASSO." = ?", [$user, $id_asso], true, true)[0];

  if ($isMember > 0) {
      // L'utilisateur est membre, nous pouvons le supprimer
      
      // Préparer la déclaration DELETE
      $deleteSQL = "DELETE FROM ".A::MEMBRESASSOS." WHERE ".A::MEMBRESASSOS_ID_USER." = ? AND ".A::MEMBRESASSOS_ID_ASSO." = ?";
      
      // Valeurs à supprimer
      $deleteValues = [$user, $id_asso];

      // Exécuter la déclaration DELETE
      BF::request($deleteSQL, $deleteValues, false, false);
      
      // Retourner un statut ou un message indiquant le résultat de l'opération
      return "Membre supprimé avec succès.";
  } else {
      // L'utilisateur n'est pas membre, gérer ce cas selon les besoins
      return "L'utilisateur n'est pas membre de l'association.";
  }
}

  
  
 /**
 * Faire simplement appel aux 2 fonctions ci-dessus
 * @param int $user L'ID de l'utilisateur à modifier
 * @param string $role Le nouveau rôle du membre
 * @return string Statut ou message indiquant le résultat de l'opération
 * @todo
 */
public function modifier_role_membre($user, $role){
  // Appeler la fonction supprimer_membre pour supprimer l'utilisateur actuel
  $resultSuppression = $this->supprimer_membre($user);

  // Appeler la fonction ajouter_membre pour réajouter l'utilisateur avec le nouveau rôle
  $resultAjout = $this->ajouter_membre($user, $role);

  // Retourner un statut ou un message combinant les résultats des deux opérations
  return "Modification de rôle : Suppression - $resultSuppression | Ajout - $resultAjout";
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