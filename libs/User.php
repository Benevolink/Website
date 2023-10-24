<?php
require_once __DIR__."/../functions/basic_functions.php";
require_once BF::abs_path("db.php",true);
class User{
  /*
  Abstraction utilisateurs
  */
  public $id;

  function __construct($id=null){
    /*
    Constructeur utilisateurs
    */
    if($id==null && BF::is_connected()){
      $this->id = $_SESSION["user_id"];
    }else{
      $this->id = $id;
    }
  }

  public function suppr_user(){
    /*
    On supprime l'utilisateur
    */
    BF::request("DELETE FROM users WHERE id = ?",[$this->id]);
  }

  public function statut_asso($id_asso){
    /*
    On renvoie le statut de l'utilisateur dans l'asso
    */
    $statut = BF::request("SELECT statut FROM membres_assos WHERE id_user = ? AND id_asso = ?",[$this->id,$id_asso],true,true);
    return $statut;
  }

  public function est_admin_asso($id_asso){
    /*
    On vérifie que l'utilisateur est admin de l'asso
    */
    $statut = $this->statut_asso($id_asso);
    if($statut >= 3){
      return true;
    }
    return false;
  }

  public function est_membre_asso($id_asso){
    /*
    On vérifie que l'utilisateur est membre
    */
    $statut = $this->statut_asso($id_asso);
    if($statut > 0){
      return true;
    }
    return false;
  }
  
  public function quitter_asso($id_asso){
    /*
    On quitte l'asso
    */
    BF::request("DELETE FROM membres_assos WHERE id_user = ?",[$this->id]);
  }

  public function liste_assos(){
    /*
    On renvoie la liste de toutes les assos de l'utilisateur avec le statut
    */
    $req = "SELECT a.*, m.statut FROM assos a JOIN membres_assos m ON (a.id = m.id_asso AND m.id_user = ?) ORDER BY m.statut ASC";
    $table = BF::request($req,[$this->id],true,false,PDO::FETCH_ASSOC);
    return $table;
  }

  public function liste_missions(){
    $array = BF::request("SELECT e.id_event, e.nom_event, ho.date_debut, ho.date_fin, a.nom, a.id FROM (((evenements e JOIN assos a ON e.id_asso = a.id) JOIN  membres_evenements me ON me.id_event = e.id_event )JOIN horaire ho ON ho.id_horaire = e.id_horaire) WHERE me.id_user = ?",[$this->id],true,false,PDO::FETCH_ASSOC);
    return $array;
  }

  public function logo(){
    /*
    On renvoie le logo de l'utilisateur
    */
    
    $req_filename = "SELECT logo FROM users WHERE id=? ";//on vérifie que le nom n'est pas déjà pris
    $filename_tab = BF::request($req_filename,[$this->id],true,true,PDO::FETCH_ASSOC);
    if(isset($filename_tab["logo"])){
       $filename = "media/img/".$filename_tab["logo"];
    }else{
      $filename = "media/img/user_anonyme.jpg";
    }
    
    
    
    /*
    if(glob("../../media/logo/user/".$this->id.".*")){
      foreach(glob("../../media/logo/user/".$_SESSION["user_id"].".*") as $filename) {
        return BF::abs_path($filename);
      }
    }*/
    return BF::abs_path($filename);
  }

  public static function insert_user($nom,$prenom,$date_naissance,$email,$mdp,$tel,$visu,$departement,$adresse){
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
    return user::user($id_user);
  }

  public function rejoindre_asso($id_asso){
    /*
    On suit l'asso
    */
    $req = "INSERT INTO membres_assos (id_asso,id_user,statut) VALUES (? , ?, ?)";
    BF::request($req,[$id_asso,$this->id,0],false);
  }

  public function liste_event($id_event)
  {   
    /*
    Renvoie la liste d'évènements d'une association
    */
      $id_asso = BF::request("SELECT id_asso FROM evenements WHERE id_event = ?", [$id_event], true, true)[0];
      $id_domaine = BF::request("SELECT id_domaine FROM domaine WHERE nom_domaine = ?", [$id_domaine], true, true)[0];
      $id_association_domaine = BF::request("SELECT id_asso FROM evenements WHERE id_domaine = ?", [$id_domaine], true, true)[0];

      return array(
          'id_asso' => $id_asso,
          'id_domaine' => $id_domaine,
          'id_association_domaine' => $id_association_domaine
      );
  }

  public function suppr_event($id_event)
  {
      $id_asso = BF::request("SELECT id_asso FROM evenements WHERE id_event = ?", [$id_event], true, true)[0];
      $statut = BF::request("SELECT statut FROM membres_assos WHERE id_user = ? AND id_asso = ?", [$this->id, $id_asso], true, true)[0];
      $id_horaire = BF::request("SELECT id_horaire FROM evenements WHERE id_event = ?", [$id_event], true, true)[0];

      // Supprimer l'horaire
      BF::request("DELETE * FROM horaire WHERE id_horaire = ?", [$id_horaire]);

      // Supprimer l'événement
      BF::request("DELETE * FROM event WHERE id_event = ?", [$id_event]);

      // Supprimer les membres de l'événement
      BF::request("DELETE * FROM membres_evenements WHERE id_event = ?", [$id_event]);

      // Supprimer les propositions d'événements
      BF::request("DELETE * FROM prop_evenements WHERE id_event = ?", [$id_event]);
  }

  public static function auth($email)
  {
      $mdp = BF::request("SELECT mdp FROM users WHERE email = :email", [':email' => $email], true, true)[0];
      $id = BF::request("SELECT id FROM users WHERE email = :email", [':email' => $email], true, true)[0];

      return array(
          'mdp' => $mdp,
          'id' => $id
      );
  }

  public function categories_events($id_cate)
  {
      $req = "SELECT e.* FROM categorie_event c JOIN (SELECT * FROM evenements e WHERE e.status = 1 OR (SELECT COUNT(*) FROM membres_assos m WHERE m.id_asso = e.id_assos AND m.id_user = :id_user) = 1) ON c.id_event = e.id";
      $events = BF::request($req, [':id_user' => $this->id], true, false, PDO::FETCH_ASSOC);

      return $events;
  }

  public function changer_role($id_asso, $new_statut)
  {
      $current_statut = BF::request("SELECT statut FROM membres_assos WHERE id_asso = ? AND id_user = ?", [$id_asso, $this->id], true, true)[0];

      if ($current_statut !== null) {
          BF::request("UPDATE membres_assos SET statut = ? WHERE id_asso = ? AND id_user = ?", [$new_statut, $id_asso, $this->id]);
          return true;
      } else {
          BF::request("INSERT INTO membres_assos (id_asso, id_user, statut) VALUES (?, ?, ?)", [$id_asso, $this->id, $statut], false);
      }
    
      return false;
  }

  public function supprimer_membre($id_asso)
  {
      // on supprime un membre d'une asso
      BF::request("DELETE FROM membres_assos WHERE id_user = ? AND id_asso = ?", [$this->id, $id_asso]);
  }


  public function liste_interets() {
      // on renvoie la liste des intérêts
      return BF::request("SELECT * FROM domaine", [], true, false, PDO::FETCH_ASSOC);
  }

  public function recherche_asso($searchQuery) {
      $searchQuery = "%" . $searchQuery . "%";
      return BF::request("SELECT nom FROM asso WHERE nom LIKE ?", [$searchQuery], true, false, PDO::FETCH_ASSOC);
  }

  public function all_infos(){
    /*
    Renvoie le select * from user
    */
    return BF::request("SELECT * FROM users WHERE id = ?",[$this->id],true,true,PDO::FETCH_ASSOC);
  }
  

  public function creation_asso() {
      // Sélectionner la liste des domaines
      return BF::request("SELECT id_domaine, nom_domaine FROM domaine", [], true, false, PDO::FETCH_ASSOC);
  }

  public function creer_evenement($date_debut, $date_fin, $heure_debut, $heure_fin, $id_asso, $nom_event, $nb_personnes, $visu, $desc, $departement, $adresse) {
      /*
      permet de créer un évènement
      */
    
      //On insère d'abord le lieu
      BF::request("INSERT INTO lieu (departement, adresse) VALUES (?, ?)",[$departement,$adresse]);
      $id_lieu = $db->lastInsertId();
      // Insérer un nouvel horaire
      $horaireInsertQuery = "INSERT INTO horaire (date_debut, date_fin, heure_debut, heure_fin) VALUES (?, ?, ?, ?)";
      BF::request($horaireInsertQuery, [$date_debut, $date_fin, $heure_debut, $heure_fin], false);

      $id_horaire = $db->lastInsertId();

      // Insérer un nouvel événement
      $evenementInsertQuery = "INSERT INTO evenements (id_asso, nom_event, id_horaire, nb_personnes, visu, desc, id_lieu) VALUES (?, ?, ?, ?, ?, ?, ?)";
      BF::request($evenementInsertQuery, [$id_asso, $nom_event, $id_horaire, $nb_personnes, $visu, $desc, $id_lieu], false);

      $id_event = $db->lastInsertId();

      return $id_event;
  }

  

  public function nombre_users() {
      // Compter le nombre d'utilisateurs
      $usersCount = BF::request("SELECT COUNT(*) FROM users", [], true, true)[0];

      return $usersCount;
  }

  public function domaines_et_nombre() {
    /*
    renvoie les noms de domaines et le nombre de domaines associés.
    */
      // Compter le nombre d'intérêts
      $interestsCount = BF::request("SELECT COUNT(*) FROM domaine", [], true, true)[0];

      // Sélectionner les noms des domaines
      $domaineNoms = BF::request("SELECT nom_domaine FROM domaine", [], true, false, PDO::FETCH_ASSOC);

      return array(
          'interests_count' => $interestsCount,
          'domaine_noms' => $domaineNoms
      );
  }

  public function prop_evenement($id_event) {
      // Sélectionner toutes les informations de l'événement
      $eventInfo = BF::request("SELECT * FROM evenements WHERE id_event = ?", [$id_event], true, false, PDO::FETCH_ASSOC);

      // Sélectionner la valeur de la propriété de l'événement
      $propNom = 'prop_nom'; // Remplacez 'prop_nom' par le nom de la propriété recherchée
      $propValeur = BF::request("SELECT valeur FROM prop_evenements WHERE id_event = ? AND prop_nom = ?", [$id_event, $propNom], true, true)[0];

      return array(
          'event_info' => $eventInfo,
          'prop_valeur' => $propValeur
      );
  }

  

}
?>