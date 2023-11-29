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
    $req  = "SELECT u.".A::USER_ID.", u.".A::USER_NOM.", u.".A::USER_PRENOM.", ma.*
    FROM ".A::MEMBRESASSOS." ma
    INNER JOIN ".A::USER." u ON ma.".A::MEMBRESASSOS_ID_USER." = u.".A::USER_ID."
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
    $array = BF::request("SELECT * FROM ".A::ASSO." WHERE ".A::ASSO_NOM." LIKE ? ORDER BY ".A::ASSO_NOM." ASC", [$searchQuery], true, false, PDO::FETCH_ASSOC);
    foreach($array as $key => $value){
      if(strcmp($value[A::ASSO_LOGO],"")){
        $array[$key][A::ASSO_LOGO] = "media/logo/asso/".$value[A::ASSO_LOGO];
      }
        
    }
    return $array;
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
    $propAssos = BF::request("SELECT * FROM ".A::PROPASSO." WHERE ".A::PROPASSO_ID_ASSO." = ?", [$id_asso], true, true, PDO::FETCH_ASSOC);

    // Sélectionner les informations de l'association
    $assoInfo = $this->get_all();

    // Compter les membres de l'association
    $membresCount = BF::request("SELECT COUNT(*) FROM ".A::MEMBRESASSOS." WHERE ".A::MEMBRESASSOS_ID_ASSO." = ?", [$id_asso], true, true)[0];

    $array =  array(
        'prop_asso' => $propAssos,
        'asso_info' => $assoInfo,
        'membres_count' => $membresCount
    );
    return $array;
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
    return BF::request("SELECT e.".A::EVENT_ID.", e.".A::EVENT_NOM.", ho.".A::HORAIRE_DATE_DEBUT.", ho.".A::HORAIRE_DATE_FIN.", a.".A::ASSO_NOM.", a.".A::ASSO_ID." FROM ((".A::EVENT." e JOIN ".A::ASSO." a ON e.".A::EVENT_ID_ASSO." = a.".A::ASSO_ID.") JOIN ".A::HORAIRE." ho ON e.".A::EVENT_ID_HORAIRE." = ho.".A::HORAIRE_ID.") WHERE a.".A::ASSO_ID." = ?",[$this->id],true,false,PDO::FETCH_ASSOC);
  }
  
  /**
   * Renvoie toutes les données de l'association
   *
   * @return array
   */
  public function get_all(){
    $array =  BF::request("SELECT * FROM ".A::ASSO." WHERE ".A::ASSO_ID." = ?",[$this->id],true,true,PDO::FETCH_ASSOC);
    if(strcmp($array[A::ASSO_LOGO],"")){
      $array[A::ASSO_LOGO] = "media/logo/asso/".$array[A::ASSO_LOGO];
    }
    return $array;
  }


  /**
   * A faire, crée une asso
   * @todo 
   */
  public static function insert($nom, $description, $description_missions, $logo, $email, $tel, $domaines,$adresse){
    global $db;
    require_once __DIR__."/Domaine.php";
    require_once __DIR__."/Lieu.php";
    require_once __DIR__."/User.php";
    /**
     * Partie logo à ajouter quand Charlotte aura fini
     * @todo
     */
    // On se connecte à la BDD
    $db->beginTransaction();
    
    // On insère les données reçues dans la table "assos"
    $req = "INSERT INTO ".A::ASSO." (".A::ASSO_NOM.", ".A::ASSO_DESCRIPTION.", ".A::ASSO_DESCRIPTION_MISSIONS.", ".A::ASSO_EMAIL.", ".A::ASSO_TELEPHONE.", ".A::ASSO_LOGO.") VALUES(?, ?, ?, ?, ?, ?)";
    BF::request($req,[$nom,$description,$description_missions,$email,$tel,""]);
    // Récupérer l'ID de l'association qui vient d'être créée
    $id = $db->lastInsertId();
    $db->commit();


    //Ajout des centres d'intérêt
    $asso = new Asso($id);
    foreach ($domaines as $idDomaine){
      $domaine = new Domaine($idDomaine);
      $domaine->insert_jonction($asso);
    }

    //Insertion du lieu
    Lieu::insert($adresse);
    $id_lieu = $db->lastInsertId();
    //Ajout du lieu dans l'asso
    BF::request("UPDATE ".A::ASSO." SET ".A::ASSO_ID_LIEU." = ? WHERE ".A::ASSO_ID." = ?",[$id_lieu,$id]);
    
    //Insertion du logo
    $asso->image_set($logo);
    //Ajout de l'utilisateur en tant qu'admin de l'asso crée
    $user = new User();
    $asso->ajouter_membre($user->id,3);
    
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

public function image_get(){
  require_once __DIR__."/image.php";
  global $db;
  $image = new image;
  $test =  $image->getImage($this->id,A::ASSO);
  if($test==false){return BF::abs_path("media/img/user_anonyme.jpg");}
  else{return $test;}
}

public function image_suppr(){
  require_once __DIR__."/image.php";
  global $db;
  $image = new image;
  $image->deleteImage($this->id,A::ASSO);
}

public function image_set($image){
  global $db;
  require_once __DIR__."/image.php";
  $image_asso = new image;
  $image_asso->setImage($image);
  $image_asso->verifier_format();
  $image_asso->deleteImage($this->id,A::ASSO);
  $image_asso->placer_image(A::ASSO,BF::abs_path("media/logo/asso/",true),$this->id);
  $image_asso->modifier_image($image_asso->fullpath);

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

  public function get_role_membre($id_membre){
    try{
      $req = "SELECT ".A::MEMBRESASSOS_STATUT." FROM ".A::MEMBRESASSOS." WHERE ".A::MEMBRESASSOS_ID_ASSO." = ? AND ".A::MEMBRESASSOS_ID_USER." = ?";
    return BF::request($req,[$this->id,$id_membre],true,true,PDO::FETCH_ASSOC)[A::MEMBRESASSOS_STATUT];
  }catch(Exception $e){
      exit($e->getMessage());
    }
  }
}
?>