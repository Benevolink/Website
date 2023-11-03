<?php
require_once __DIR__."/../functions/basic_functions.php";
require_once BF::abs_path("db.php",true);
require_once __DIR__."/Ressources/NomsAttributsTables.php";
use AttributsTables as A;

/**
 * Abstraction table users
 */
class User{
  public $id;  
  /**
   * Method __construct
   *
   * @param int $id=null $id [id de l'utilisateur | si non spécifié, l'utilisateur de la session active est sélectionné]
   *
   * @return void
   */
  function __construct($id=null){
    //Cas où l'utilisateur est connecté et l'id est non spécifié
    if($id==null && BF::is_connected()){
      $this->id = $_SESSION["user_id"];
    }else{
      $this->id = $id;
    }
  }
  
  /**
   * Supprime l'utilisateur de la bdd
   *
   * @return void
   */
  public function suppr_user(){
    BF::request("DELETE FROM ".A::USER." WHERE ".A::USER_ID." = ?",[$this->id]);
  }
  
  /**
   * Renvoie le statut de l'utilisateur dans l'asso
   *
   * @param int $id_asso $id_asso [id de l'association]
   *
   * @return int
   */
  public function statut_asso($id_asso){
    $statut = BF::request("SELECT ".A::MEMBRESASSOS_STATUT." FROM ".A::MEMBRESASSOS." WHERE ".A::MEMBRESASSOS_ID_USER." = ? AND ".A::MEMBRESASSOS_ID_ASSO." = ?",[$this->id,$id_asso],true,true);
    return $statut;
  }
  
  /**
   * Vérifie que l'utilisateur est admin de l'asso (statut >=3)
   *
   * @param int $id_asso $id_asso [id association]
   *
   * @return bool
   */
  public function est_admin_asso($id_asso){
    $statut = $this->statut_asso($id_asso);
    if($statut >= 3){
      return true;
    }
    return false;
  }
  
  /**
   * Vérifie que l'utilisateur est membre de l'asso (statut > 0)
   *
   * @param int $id_asso $id_asso [id association]
   *
   * @return bool
   */
  public function est_membre_asso($id_asso){
    $statut = $this->statut_asso($id_asso);
    if($statut > 0){
      return true;
    }
    return false;
  }
    
  /**
   * Quitte l'association
   *
   * @param int $id_asso $id_asso [id association]
   *
   * @return void
   */
  public function quitter_asso($id_asso){
    BF::request("DELETE FROM ".A::MEMBRESASSOS." WHERE ".A::MEMBRESASSOS_ID_USER." = ?",[$this->id]);
  }
  
  /**
   * Renvoie la liste des assos de l'utilisateur sous la forme d'une liste contenant :
   *  •  toutes les infos de chaque asso
   *  •  le statut de l'utilisateur dans l'asso
   *
   * @return array
   */
  public function liste_assos(){
    /*
    On renvoie la liste de toutes les assos de l'utilisateur avec le statut
    */
    $req = "SELECT a.*, m.".A::MEMBRESASSOS_STATUT." FROM ".A::ASSO." a JOIN ".A::MEMBRESASSOS." m ON (a.".A::ASSO_ID." = m.".A::MEMBRESASSOS_ID_ASSO." AND m.".A::MEMBRESASSOS_ID_USER." = ? AND m.".A::MEMBRESASSOS_STATUT." >= 0) ORDER BY m.".A::MEMBRESASSOS_STATUT." ASC";
    $table = BF::request($req,[$this->id],true,false,PDO::FETCH_ASSOC);
    return $table;
  }
  
  /**
   * Renvoie la liste des missions de l'utilisateur
   *
   * @return array
   */
  public function liste_missions(){
    $array = BF::request("SELECT e.".A::EVENT_ID.", e.".A::EVENT_NOM.", ho.".A::HORAIRE_DATE_DEBUT.", ho.".A::HORAIRE_DATE_FIN.", a.".A::ASSO_NOM.", a.".A::ASSO_ID." FROM (((".A::EVENT." e JOIN ".A::ASSO." a ON e.".A::EVENT_ID_ASSO." = a.".A::ASSO_ID.") JOIN  ".A::MEMBRESEVENTS." me ON me.".A::MEMBRESEVENTS_ID_EVENT." = e.".A::EVENT_ID." )JOIN ".A::HORAIRE." ho ON ho.".A::HORAIRE_ID." = e.".A::EVENT_ID_HORAIRE.") WHERE me.".A::MEMBRESEVENTS_ID_USER." = ?",[$this->id],true,false,PDO::FETCH_ASSOC);
    return $array;
  }
  
  /**
   * Renvoie le chemin de l'avatar de l'utilisateur
   *
   * @return string
   */
  public function logo(){
    
    $req_filename = "SELECT ".A::USER_LOGO." FROM ".A::USER." WHERE ".A::USER_ID."=? ";//on vérifie que le nom n'est pas déjà pris
    $filename_tab = BF::request($req_filename,[$this->id],true,true,PDO::FETCH_ASSOC);
    if(isset($filename_tab["logo"])){
       $filename = "media/img/".$filename_tab["logo"];
    }else{
      $filename = "media/img/user_anonyme.jpg";
    }
    return BF::abs_path($filename);
  }
  
  /**
   * Ajoute un utilisateur dans la bdd
   *
   * @param string $nom $nom 
   * @param string $prenom $prenom 
   * @param int $date_naissance $date_naissance 
   * @param string $email $email 
   * @param string $mdp $mdp [mot de passe crypté]
   * @param string $tel $tel
   * @param int $visu $visu
   * @param string $departement
   * @param string $adresse
   *
   * @return User
   */
  public static function insert_user($nom,$prenom,$date_naissance,$email,$mdp,$tel,$visu,$departement,$adresse){
    global $db;
    /*
    Permet de créer un utilisateur
    */
    //On insère d'abord le lieu
    BF::request("INSERT INTO ".A::LIEU." (".A::LIEU_DEPARTEMENT.", ".A::LIEU_ADRESSE.") VALUES (?, ?)",[$departement,$adresse]);
    $id_lieu = $db->lastInsertId();
    //On insère l'utilisateur
    $insertUserQuery = "INSERT INTO ".A::USER." (".A::USER_NOM.", ".A::USER_PRENOM.", ".A::USER_DATE_NAISSANCE.", ".A::USER_EMAIL.", ".A::USER_MDP.", ".A::USER_TEL.", ".A::USER_VISIBILITE.", ".A::USER_ID_LIEU.", ".A::USER_ETAT_COMPTE.")
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    BF::request($insertUserQuery,[$nom,$prenom,$date_naissance,$email,$mdp,$tel,$visu,$id_lieu,0],false);
    $id_user = $db->lastInsertId();
    return new User($id_user);
  }
  
  /**
   * Affecte le statut en_attente à l'utilisateur (statut = 0)
   *
   * @param int $id_asso $id_asso [id association]
   *
   * @return void
   */
  public function rejoindre_asso($id_asso){
    $req = "INSERT INTO ".A::MEMBRESASSOS." (".A::MEMBRESASSOS_ID_ASSO.",".A::MEMBRESASSOS_ID_USER.",".A::MEMBRESASSOS_STATUT.") VALUES (? , ?, ?)";
    BF::request($req,[$id_asso,$this->id,0],false);
  }
  
  /**
   * /!\Fonction non fonctionnelle. Il y a une erreur dedans
   *
   * @param int $id_event $id_event [explicite description]
   *
   * @return array
   */
  public function liste_event($id_event)
  {   
    /*
    Renvoie la liste d'évènements d'une association
    */
    $id_domaine = null;
      $id_asso = BF::request("SELECT ".A::EVENT_ID_ASSO." FROM ".A::EVENT." WHERE ".A::EVENT_ID." = ?", [$id_event], true, true)[0];
      $id_domaine = BF::request("SELECT ".A::DOMAINE_ID." FROM ".A::DOMAINE." WHERE ".A::DOMAINE_NOM." = ?", [$id_domaine], true, true)[0];

      //Erreur ici
      $id_association_domaine = BF::request("SELECT ".A::EVENT_ID_ASSO." FROM ".A::EVENT." WHERE ".A::EVENT_ID_DOMAINE." = ?", [$id_domaine], true, true)[0];

      return array(
          'id_asso' => $id_asso,
          'id_domaine' => $id_domaine,
          'id_association_domaine' => $id_association_domaine
      );
  }

  
  /**
   * Renvoie la liste des évènements de l'utilisateur sous forme d'une liste d'objets Event
   *
   * @return array
   */
  public function events_user()
  {
      
      $req = "SELECT ".A::EVENT_ID." FROM ".A::EVENT." e WHERE e.".A::EVENT_VISIBILITE." = 'publique' OR (SELECT COUNT(*) FROM ".A::MEMBRESASSOS." m WHERE m.".A::MEMBRESASSOS_ID_ASSO." = e.".A::EVENT_ID_ASSO." AND m.".A::MEMBRESASSOS_ID_USER." = ?) = 1";
      $id_events = BF::request($req, [$this->id], true, false, PDO::FETCH_ASSOC);
      $array = array();
      require_once "Event.php"; //Importation de la classe Event
      foreach ($id_events as $key=>$id_event) {
        $array[$key] = new Event($id_event);
      }
      return $array;
  }

    
  /**
   * Assigner un nouveau rôle à un utilisateur dans une association
   *
   * @param int $id_asso $id_asso [id association]
   * @param int $new_statut $new_statut [nouveau statut (-1:banni/0:en_attente/1:membre/2:modérateur/3:admin)]
   *
   * @return bool
   */
  public function asso_changer_role($id_asso, $new_statut)
  {
      $current_statut = BF::request("SELECT ".A::MEMBRESASSOS_STATUT." FROM ".A::MEMBRESASSOS." WHERE ".A::MEMBRESASSOS_ID_ASSO." = ? AND ".A::MEMBRESASSOS_ID_USER." = ?", [$id_asso, $this->id], true, true)[0];

      if ($current_statut !== null) {
          BF::request("UPDATE ".A::MEMBRESASSOS." SET ".A::MEMBRESASSOS_STATUT." = ? WHERE ".A::MEMBRESASSOS_ID_ASSO." = ? AND ".A::MEMBRESASSOS_ID_USER." = ?", [$new_statut, $id_asso, $this->id]);
          return true;
      } else {
          BF::request("INSERT INTO ".A::MEMBRESASSOS." (".A::MEMBRESASSOS_ID_ASSO.", ".A::MEMBRESASSOS_ID_USER.", ".A::MEMBRESASSOS_STATUT.") VALUES (?, ?, ?)", [$id_asso, $this->id, $new_statut], false);
      }
    
      return false;
  }

  
  /**
   * Renvoie toutes les infos dans la table user de l'utilisateur
   *
   * @return array
   */
  public function all_infos(){
    return BF::request("SELECT * FROM ".A::USER." WHERE ".A::USER_ID." = ?",[$this->id],true,true,PDO::FETCH_ASSOC);
  }
  
  
  /**
   * Renvoie le nombre total d'utilisateurs inscrits
   *
   * @return int
   */
  public static function nombre_users() {
      $usersCount = BF::request("SELECT COUNT(*) FROM ".A::USER."", [], true, true)[0];

      return $usersCount;
  }
  
  /**
   * Renvoie les infos des évènements dans lesquels est l'utilisateur sous forme d'une array
   * 
   * Les indexes de l'array sont: id_event, nom_event, date_debut, date_fin, nom, id
   * 
   * où nom et id concernent l'asso de l'event
   *
   * @return array
   */
  public function infos_events(){
    return BF::request("SELECT e.".A::EVENT_ID.", e.".A::EVENT_NOM.", ho.".A::HORAIRE_DATE_DEBUT.", ho.".A::HORAIRE_DATE_FIN.", a.".A::ASSO_NOM.", a.".A::ASSO_ID." FROM (((".A::EVENT." e JOIN ".A::ASSO." a ON e.".A::EVENT_ID_ASSO." = a.".A::ASSO_ID.") JOIN  ".A::MEMBRESEVENTS." me ON me.".A::MEMBRESEVENTS_ID_EVENT." = e.".A::EVENT_ID." )JOIN ".A::HORAIRE." ho ON ho.".A::HORAIRE_ID." = e.".A::EVENT_ID_HORAIRE.") WHERE me.".A::MEMBRESEVENTS_ID_USER." = ?",[$this->id],true,false,PDO::FETCH_ASSOC);
  }
}
?>