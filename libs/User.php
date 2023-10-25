<?php
require_once __DIR__."/../functions/basic_functions.php";
require_once BF::abs_path("db.php",true);
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
    BF::request("DELETE FROM users WHERE id = ?",[$this->id]);
  }
  
  /**
   * Renvoie le statut de l'utilisateur dans l'asso
   *
   * @param int $id_asso $id_asso [id de l'association]
   *
   * @return int
   */
  public function statut_asso($id_asso){
    $statut = BF::request("SELECT statut FROM membres_assos WHERE id_user = ? AND id_asso = ?",[$this->id,$id_asso],true,true);
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
    BF::request("DELETE FROM membres_assos WHERE id_user = ?",[$this->id]);
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
    $req = "SELECT a.*, m.statut FROM assos a JOIN membres_assos m ON (a.id = m.id_asso AND m.id_user = ? AND m.statut >= 0) ORDER BY m.statut ASC";
    $table = BF::request($req,[$this->id],true,false,PDO::FETCH_ASSOC);
    return $table;
  }
  
  /**
   * Renvoie la liste des missions de l'utilisateur
   *
   * @return array
   */
  public function liste_missions(){
    $array = BF::request("SELECT e.id_event, e.nom_event, ho.date_debut, ho.date_fin, a.nom, a.id FROM (((evenements e JOIN assos a ON e.id_asso = a.id) JOIN  membres_evenements me ON me.id_event = e.id_event )JOIN horaire ho ON ho.id_horaire = e.id_horaire) WHERE me.id_user = ?",[$this->id],true,false,PDO::FETCH_ASSOC);
    return $array;
  }
  
  /**
   * Renvoie le chemin de l'avatar de l'utilisateur
   *
   * @return string
   */
  public function logo(){
    
    $req_filename = "SELECT logo FROM users WHERE id=? ";//on vérifie que le nom n'est pas déjà pris
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
    BF::request("INSERT INTO lieu (departement, adresse) VALUES (?, ?)",[$departement,$adresse]);
    $id_lieu = $db->lastInsertId();
    //On insère l'utilisateur
    $insertUserQuery = "INSERT INTO users (nom, prenom, date_de_naissance, email, mdp, tel, visu, id_lieu, est_bloque)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    BF::request($insertUserQuery,[$nom,$prenom,$date_naissance,$email,$mdp,$tel,$visu,$id_lieu,false],false);
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
    $req = "INSERT INTO membres_assos (id_asso,id_user,statut) VALUES (? , ?, ?)";
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
      $id_asso = BF::request("SELECT id_asso FROM evenements WHERE id_event = ?", [$id_event], true, true)[0];
      $id_domaine = BF::request("SELECT id_domaine FROM domaine WHERE nom_domaine = ?", [$id_domaine], true, true)[0];
      $id_association_domaine = BF::request("SELECT id_asso FROM evenements WHERE id_domaine = ?", [$id_domaine], true, true)[0];

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
      
      $req = "SELECT id_event FROM evenements e WHERE e.visu = 'publique' OR (SELECT COUNT(*) FROM membres_assos m WHERE m.id_asso = e.id_assos AND m.id_user = ?) = 1";
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
      $current_statut = BF::request("SELECT statut FROM membres_assos WHERE id_asso = ? AND id_user = ?", [$id_asso, $this->id], true, true)[0];

      if ($current_statut !== null) {
          BF::request("UPDATE membres_assos SET statut = ? WHERE id_asso = ? AND id_user = ?", [$new_statut, $id_asso, $this->id]);
          return true;
      } else {
          BF::request("INSERT INTO membres_assos (id_asso, id_user, statut) VALUES (?, ?, ?)", [$id_asso, $this->id, $new_statut], false);
      }
    
      return false;
  }

  
  /**
   * Renvoie toutes les infos dans la table user de l'utilisateur
   *
   * @return array
   */
  public function all_infos(){
    return BF::request("SELECT * FROM users WHERE id = ?",[$this->id],true,true,PDO::FETCH_ASSOC);
  }
  
  
  /**
   * Renvoie le nombre total d'utilisateurs inscrits
   *
   * @return int
   */
  public static function nombre_users() {
      $usersCount = BF::request("SELECT COUNT(*) FROM users", [], true, true)[0];

      return $usersCount;
  }
}
?>