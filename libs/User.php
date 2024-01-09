<?php
require_once __DIR__."/../functions/basic_functions.php";
require_once BF::abs_path("db.php",true);
require_once __DIR__."/Ressources/NomsAttributsTables.php";
require_once __DIR__."/Ressources/LibsInterfaces.php";
use AttributsTables as A;

/**
 * Abstraction table users
 */

class User implements Suppression, GestionLogo{

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
  public function suppr(){
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
   * Vérifie que l'utilisateur suit l'asso (statut > -1)
   *
   * @param int $id_asso $id_asso [id association]
   *
   * @return bool
   */
  public function suit_asso($id_asso){
    $statut = $this->statut_asso($id_asso);
    if($statut > -1){
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
   * Renvoie la liste des assos de l'utilisateur (statut >=0) sous la forme d'une liste contenant :
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
   * Renvoie la liste des assos de l'utilisateur (statut >=1) sous la forme d'une liste contenant :
   *  •  toutes les infos de chaque asso
   *  •  le statut de l'utilisateur dans l'asso
   *
   * @return array
   */
  public function liste_assos_integrees(){
  
    /*
    On renvoie la liste de toutes les assos de l'utilisateur avec le statut
    */
    $req = "SELECT a.*, m.".A::MEMBRESASSOS_STATUT.", COUNT(me.".A::MEMBRESASSOS_ID_USER.") AS nombre_membres FROM ".A::ASSO." a JOIN ".A::MEMBRESASSOS." m ON (a.".A::ASSO_ID." = m.".A::MEMBRESASSOS_ID_ASSO." AND m.".A::MEMBRESASSOS_ID_USER." = ? AND m.".A::MEMBRESASSOS_STATUT." >= 1) JOIN  ".A::MEMBRESASSOS." me ON me.".A::MEMBRESASSOS_ID_ASSO." = a.".A::ASSO_ID." GROUP BY a.".A::ASSO_ID." ORDER BY m.".A::MEMBRESASSOS_STATUT." ASC";
    $table = BF::request($req,[$this->id],true,false,PDO::FETCH_ASSOC);
    return $table;
  
  }

  /**
   * Renvoie la liste des assos de l'utilisateur (statut ==0) sous la forme d'une liste contenant :
   *  •  toutes les infos de chaque asso
   *  •  le statut de l'utilisateur dans l'asso
   *
   * @return array
   */
  public function liste_assos_en_attente(){
  
    /*
    On renvoie la liste de toutes les assos de l'utilisateur avec le statut
    */
    $req = "SELECT a.*, m.".A::MEMBRESASSOS_STATUT.", COUNT(me.".A::MEMBRESASSOS_ID_USER.") AS nombre_membres FROM ".A::ASSO." a JOIN ".A::MEMBRESASSOS." m ON (a.".A::ASSO_ID." = m.".A::MEMBRESASSOS_ID_ASSO." AND m.".A::MEMBRESASSOS_ID_USER." = ? AND m.".A::MEMBRESASSOS_STATUT." = 0) JOIN  ".A::MEMBRESASSOS." me ON me.".A::MEMBRESASSOS_ID_ASSO." = a.".A::ASSO_ID." GROUP BY a.".A::ASSO_ID." ORDER BY m.".A::MEMBRESASSOS_STATUT." ASC";
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
       $filename = BF::abs_path("media/logo/user/",true).$filename_tab["logo"];
    }else{
      $filename = BF::abs_path("media/img/user_anonyme.jpg");
    }
    return BF::abs_path($filename);
  }

  public function image_get(){
    require_once __DIR__."/image.php";
    global $db;
    $image = new image;
    $test =  $image->getImage($this->id,A::USER);
    if($test==false){return BF::abs_path("media/img/user_anonyme.jpg");}
    else{return $test;}
  }

  public function image_suppr(){
    require_once __DIR__."/image.php";
    global $db;
    $image = new image;
    $image->deleteImage($this->id,A::USER);
  }

  public function image_set($image){
    global $db;
    require_once __DIR__."/image.php";
    $image_user = new image;
    $image_user->setImage($image);
    $image_user->verifier_format();
    $image_user->deleteImage($this->id,A::USER);
    $image_user->placer_image(A::USER,BF::abs_path("media/logo/user/",true),$this->id);
    $image_user->modifier_image($image_user->fullpath);

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
    $statut = 0; //En attente
    if(BF::is_connected()){
      $user = new User();
      if($user->est_admin_asso($id_asso))
        $statut = 3; //Si l'utilisateur est admin de l'asso, il est directement admin de l'event
    }
    BF::request($req,[$id_asso,$this->id,$statut],false);
  }

  

  public function change_user_image($image){
    global $db;
    require_once __DIR__."/image.php";
    $image_user = new image;
    $image_user->deleteImage($this->id,A::USER);
    $image_user->setImage($image);
    $image_user->verifier_format();
    $image_user->placer_image(A::USER,BF::abs_path("media/logo/user/",true)
    ,$this->id);
    $image_user->modifier_image($image_user->fullpath);


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
      //Utiliser domaine->detient_domaine($asso)
      $id_association_domaine = BF::request("SELECT ".A::EVENT_ID_ASSO." FROM ".A::EVENT." WHERE ".A::DOMAINE_ID." = ?", [$id_domaine], true, true)[0];

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

  public function get_pseudo(){
    return BF::request("SELECT ".A::USER_PRENOM." FROM ".A::USER." WHERE ".A::USER_ID." = ?",[$this->id],true,true)[0];
  }

  /**
   * Ajoute un logo à l'utilisateur
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
   * Method user_exists
   *
   * @param string $email $email [explicite description]
   * @param string $tel $tel [explicite description]
   *
   * @return bool
   */
  public static function user_exists($email,$tel){
    $count =BF::request("SELECT COUNT(*) FROM ".A::USER." WHERE (".A::USER_EMAIL." = ? OR ".A::USER_TEL." = ?)",[$email,$tel]);
    return $count> 0?true:false;
  }
  
  /**
   * Method user_email_exists
   *
   * @param string $email $email [explicite description]
   *
   * @return bool
   */
  public static function user_email_exists($email){
    $count =BF::request("SELECT COUNT(*) FROM ".A::USER." WHERE ".A::USER_EMAIL." = ?",[$email]);
    return $count> 0?true:false;
  }
  
  /**
   * Method user_tel_exists
   *
   * @param string $tel $tel [explicite description]
   *
   * @return bool
   */
  public static function user_tel_exists($tel){
    $count =BF::request("SELECT COUNT(*) FROM ".A::USER." WHERE ".A::USER_TEL." = ?",[$tel]);
    return $count> 0?true:false;
  }
  
  /**
   * Vrai si l'utilisateur est superadmin
   *
   * @return bool
   */
  public function is_admin_glob(){
    $i = BF::request("SELECT ".A::USER_ACCOUNT_STATUS." FROM ".A::USER." WHERE ".A::USER_ID." = ?",[$this->id]);
    return $i > 0?true:false;
  }
  
  /**
   * Method rejoindre_event
   * Mets le statut à 0 si le membre n'est pas admin de l'asso
   * Sinon, mets le statut à 3
   *
   * 
   * @param $id_event $id_event [explicite description]
   *
   * @return void|bool
   */
  public function rejoindre_event($id_event){


    //Si l'utilisateur est déjà membre, on ne réitère pas l'opération
    $statut_event = $this->statut_event($id_event);
    if($statut_event != false){
      return false;
    }

    //Vérification du rôle du membre dans l'asso
    require_once BF::abs_path("libs/Event.php",true);
    $event = new Event($id_event);
    $id_asso = $event->asso_get_id();
    if($this->est_admin_asso($id_asso)){
      $statut = 3;
    }
    else{
      $statut = 0;
    }

    
    BF::request("INSERT INTO ".A::MEMBRESEVENTS."(".A::MEMBRESEVENTS_ID_EVENT.",".A::MEMBRESEVENTS_ID_USER.",".A::MEMBRESASSOS_STATUT.") VALUES (?,?,?)",[$id_event,$this->id,$statut]);
    
  }
  
  /**
   * Method quitter_event
   *
   * @param $id_event $id_event [explicite description]
   *
   * @return void
   */
  public function quitter_event($id_event){
    BF::request("DELETE FROM ".A::MEMBRESEVENTS." WHERE ".A::MEMBRESASSOS_ID_USER." = ? AND ".A::MEMBRESEVENTS_ID_EVENT." = ?",[$this->id,$id_event],false);
  }
  
  /**
   * Method event_statut
   *
   * @param $id_event $id_event [explicite description]
   *
   * @return int|bool
   */
  public function statut_event($id_event){
    $statut = BF::request("SELECT ".A::MEMBRESEVENTS_STATUT." FROM ".A::MEMBRESEVENTS." WHERE ".A::MEMBRESEVENTS_ID_USER." = ? AND ".A::MEMBRESEVENTS_ID_EVENT." = ?",[$this->id,$id_event],true,true);
    if(is_array($statut) && !empty($statut)){
      return $statut[0];
    }else{
      return false;
    }
  }
    
  /**
   * Method est_admin_event
   *
   * @param $id_event $id_event [explicite description]
   *
   * @return bool
   */
  public function est_admin_event($id_event){
    return ($this->statut_event($id_event)>2) ? true : false;
  }
  
  /**
   * Donne la liste des missions en attente (statut de la mission = -2) du bénévole
   *
   * @return array 
   */
  public function liste_missions_en_attente(){
    
    $id_event = BF::request("SELECT ".A::MEMBRESEVENTS_ID_EVENT." FROM ".A::MEMBRESEVENTS." WHERE ".A::MEMBRESEVENTS_ID_USER." = ? AND ".A::MEMBRESEVENTS_STATUT."= ?" , [$this->id,-2], true, false,PDO::FETCH_NUM);
    $id_event = array_filter($id_event);
    if(count($id_event)==0) return[];
    $taille = count($id_event);
    
    $nom_event = array();
    for($i=0 ; $i<$taille ; $i++){
      $nom_event[$i]=BF::request("SELECT ".A::EVENT_NOM." FROM ".A::EVENT." WHERE ".A::EVENT_ID." = ?" , [$id_event[$i][0]], true, true,PDO::FETCH_NUM)[0];
      $id_event[$i] = $id_event[$i][0];
    }
    return [$nom_event,$id_event];

  }
  public function disponibilite(){
    //on récupère les données
    global $db;
    
   

    
    $dispo=$_POST['dispo_user']; // On suppose recevoir les données sous la forme [[jour1,h_debut1,h_fin1],[jour2,h_debut2,h_fin2]]
    //on modifie la base de donnée pour que ça correspondent : on créé des "horaires" et on créé une liste avec les id de tout les horaires
    $nbdispo=count($dispo);
    $id_dispo=array();
    for($i=0; $i++; $i< $nbdispo){
      //creer un horaire et récupérer son id
      BF::request("INSERT INTO ".A::HORAIRE." (".A::HORAIRE_DATE_DEBUT.", ".A::HORAIRE_DATE_FIN.",".A::HORAIRE_HEURE_DEBUT.",".A::HORAIRE_HEURE_FIN.") VALUES (?, ?, ?, ?)" , [$dispo[$i][0],$dispo[$i][0],$dispo[$i][1],$dispo[$i][2]]);
      //voir comment est donné la fréquence
      $id_dispo[$i] = $db->lastInsertId();
    }
    //mettre à jour les dispos : enlever les anciennes dispo et mettre à jours les nouvelles
    BF::request("UPDATE".A::USER."SET".A::USER_ID_DISPO."=? WHERE".A::USER_ID."=?",[$id_dispo,$this->id]);

     
  }
}
?>