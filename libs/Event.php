<?php
require_once __DIR__."/../functions/basic_functions.php";
require_once BF::abs_path("db.php",true);
require_once __DIR__."/Ressources/NomsAttributsTables.php";
require_once __DIR__."/Ressources/LibsInterfaces.php";
use AttributsTables as A;
class Event implements Suppression, GestionMembres, GestionLogo, GestionProprietesAdditionnelles{    
    
    /**
     * id event
     *
     * @var int
     */
    public $id;
        
    /**
     * Method __construct
     *
     * @param int $id $id [id évènement]
     *
     * @return void
     */
    public function __construct($id){
        $this->id = $id;
    }

    
    /**
     * Supprime l'évènement
     *
     * @return void
     */
    public function suppr()
    {
        $id_event = $this->id;
        $id_horaire = BF::request("SELECT ".A::EVENT_ID_HORAIRE." FROM ".A::EVENT." WHERE ".A::EVENT_ID." = ?", [$id_event], true, true)[0];
  
        // Supprimer l'horaire
        BF::request("DELETE * FROM ".A::HORAIRE." WHERE ".A::HORAIRE_ID." = ?", [$id_horaire]);
  
        // Supprimer l'événement
        BF::request("DELETE * FROM ".A::EVENT." WHERE ".A::EVENT_ID." = ?", [$id_event]);
  
        // Supprimer les membres de l'événement
        BF::request("DELETE * FROM ".A::MEMBRESEVENTS." WHERE ".A::MEMBRESEVENTS_ID_EVENT." = ?", [$id_event]);
  
        // Supprimer les propositions d'événements
        BF::request("DELETE * FROM ".A::PROPEVENT." WHERE ".A::PROPEVENT_ID_EVENT." = ?", [$id_event]);
    }
    
    /**
     * Crée un évènement
     *
     * @param int $date_debut $date_debut
     * @param int $date_fin $date_fin
     * @param int $heure_debut $heure_debut
     * @param int $heure_fin $heure_fin
     * @param int $id_asso $id_asso
     * @param string $nom_event $nom_event
     * @param int $nb_personnes $nb_personnes
     * @param string $visu $visu
     * @param string $desc $desc
     * @param string $departement $departement
     * @param string $adresse $adresse
     *
     * @return Event
     */
    public static function insert($date_debut, $date_fin, $heure_debut, $heure_fin, $id_asso, $nom_event, $nb_personnes, $visu, $desc, $departement, $adresse,$logo) {
        global $db;
        /*
        permet de créer un évènement
        */
      
        //On insère d'abord le lieu
        BF::request("INSERT INTO ".A::LIEU." (".A::LIEU_DEPARTEMENT.", ".A::LIEU_ADRESSE.") VALUES (?, ?)",[$departement,$adresse]);
        $id_lieu = $db->lastInsertId();
        // Insérer un nouvel horaire
        $horaireInsertQuery = "INSERT INTO ".A::HORAIRE." (".A::HORAIRE_DATE_DEBUT.", ".A::HORAIRE_DATE_FIN.", ".A::HORAIRE_HEURE_DEBUT.", ".A::HORAIRE_HEURE_FIN.") VALUES (?, ?, ?, ?)";
        BF::request($horaireInsertQuery, [$date_debut, $date_fin, $heure_debut, $heure_fin], false);
  
        $id_horaire = $db->lastInsertId();
  
        // Insérer un nouvel événement
        $evenementInsertQuery = "INSERT INTO ".A::EVENT." (".A::EVENT_ID_ASSO.", ".A::EVENT_NOM.", ".A::EVENT_ID_HORAIRE.", ".A::EVENT_NB_MAX_PERSONNES.", ".A::EVENT_VISIBILITE.", ".A::EVENT_DESCRIPTION.", ".A::EVENT_ID_LIEU.") VALUES (?, ?, ?, ?, ?, ?, ?)";
        BF::request($evenementInsertQuery, [$id_asso, $nom_event, $id_horaire, $nb_personnes, $visu, $desc, $id_lieu], false);
  
        $id_event = $db->lastInsertId();
  
        //Insertion du logo
        $event = new Event($id_event);
        $event->image_set($logo);

        
        return $event;
    }
    
    /**
     * Renvoie la valeur de la propriété associée
     *
     * @param string $propNom $propNom [la propriété]
     *
     * @return string valeur de la propriété
     */
    public function get_prop_value($propNom) {
        return BF::request("SELECT ".A::PROPEVENT_VALEUR." FROM ".A::PROPEVENT." WHERE ".A::PROPEVENT_ID_EVENT." = ? AND ".A::PROPEVENT_NOM." = ?", [$this->id, $propNom], true, true)[0];
    }

        
    /**
     * Renvoie toutes les infos de l'évènement associé
     *
     * @return array
     */
    public function get_all(){
        return BF::request("SELECT * FROM ".A::EVENT." WHERE ".A::EVENT_ID." = ?",[$this->id],true,true,PDO::FETCH_ASSOC);
    }
    /**
     * Renvoie la liste de tous les membres (id, nom et role)
     * se référer à l'interface pour plus d'infos
     * @todo @return array
     */
    public function get_all_membres(){
        $req = "SELECT u.".A::USER_ID.", u.".A::USER_NOM.", u.".A::USER_PRENOM.", me.".A::MEMBRESEVENTS_STATUT."
        FROM ".A::MEMBRESEVENTS." me
        INNER JOIN ".A::USER." u ON me.".A::MEMBRESEVENTS_ID_USER." = u.".A::USER_ID."
        WHERE me.".A::MEMBRESEVENTS_ID_EVENT." = ?";
        return BF::request($req, [$this->id], true, false, PDO::FETCH_ASSOC);    
    }

/**
 * Enlève le membre de l'évènement
 *
 * @param int $user L'ID de l'utilisateur à supprimer de l'évènement
 *
 * @return bool true si le membre a été supprimé, false sinon
 * @todo
 */
public function supprimer_membre($user){
    $id_event = $this->id;

    // Vérifie si l'utilisateur est membre de l'événement
    $estMembre = BF::request("SELECT COUNT(*) FROM ".A::MEMBRESEVENTS." WHERE ".A::MEMBRESEVENTS_ID_USER." = ? AND ".A::MEMBRESEVENTS_ID_EVENT." = ?", [$user, $id_event], true, true)[0];

    if ($estMembre > 0) {
        // L'utilisateur est membre, nous pouvons le supprimer
        BF::request("DELETE FROM ".A::MEMBRESEVENTS." WHERE ".A::MEMBRESEVENTS_ID_USER." = ? AND ".A::MEMBRESEVENTS_ID_EVENT." = ?", [$user, $id_event], false, false);

        // Retourne un statut ou un message indiquant le résultat de l'opération
        return true;
    } else {
        // L'utilisateur n'est pas membre
        return false;
    }
}

/**
 * Ajoute un membre, et spécifie son rôle
 *
 * @param int $user L'ID de l'utilisateur à ajouter en tant que membre
 * @param string $role Le rôle du membre 
 *
 * @return bool true si ça a fonctionné, false sinon
 */
public function ajouter_membre($user, $role = null){
    $id_event = $this->id;

    // Vérifie si l'utilisateur est déjà membre de l'événement
    $estMembre = BF::request("SELECT COUNT(*) FROM ".A::MEMBRESEVENTS." WHERE ".A::MEMBRESEVENTS_ID_USER." = ? AND ".A::MEMBRESEVENTS_ID_EVENT." = ?", [$user, $id_event], true, true)[0];

    if ($estMembre == 0) {
        // L'utilisateur n'est pas encore membre, nous pouvons donc l'ajouter

        // Prépare la déclaration INSERT pour ajouter l'utilisateur en tant que membre
        $insertSQL = "INSERT INTO ".A::MEMBRESEVENTS." (".A::MEMBRESEVENTS_ID_USER.", ".A::MEMBRESEVENTS_ID_EVENT;
        $insertValues = [$user, $id_event];

        // Ajoute le rôle s'il est fourni
        if ($role !== null) {
            $insertSQL .= ", ".A::MEMBRESEVENTS_STATUT;
            $insertValues[] = $role;
        }

        $insertSQL .= ") VALUES (";
        $insertSQL .= implode(", ", array_fill(0, count($insertValues), "?"));
        $insertSQL .= ")";

        // INSERT
        BF::request($insertSQL, $insertValues, false, false);

        // Retourne un statut ou un message indiquant le résultat de l'opération
        return true;
    } else {
        // L'utilisateur est déjà membre
        return false;
    }
}

    /**
     * Simplement utiliser les fonction ci-dessus
     * @todo
 * Modifie le rôle d'un membre dans l'événement
 *
 * @param int $user L'ID de l'utilisateur dont le rôle doit être modifié
 * @param string $role Le nouveau rôle du membre
 *
 * @return bool
 */
public function modifier_role_membre($user, $role){
    $id_event = $this->id;

    // Vérifie si l'utilisateur est membre de l'événement
    $estMembre = BF::request("SELECT COUNT(*) FROM ".A::MEMBRESEVENTS." WHERE ".A::MEMBRESEVENTS_ID_USER." = ? AND ".A::MEMBRESEVENTS_ID_EVENT." = ?", [$user, $id_event], true, true)[0];

    if ($estMembre > 0) {
        // L'utilisateur est membre, met à jour son rôle

        // Prépare la déclaration UPDATE pour modifier le rôle de l'utilisateur dans l'événement
        $updateSQL = "UPDATE ".A::MEMBRESEVENTS." SET ".A::MEMBRESEVENTS_STATUT." = ? WHERE ".A::MEMBRESEVENTS_ID_USER." = ? AND ".A::MEMBRESEVENTS_ID_EVENT." = ?";
        BF::request($updateSQL, [$role, $user, $id_event], false, false);

        // Retourne un statut ou un message indiquant le résultat de l'opération
        return true;
    } else {
        // L'utilisateur n'est pas membre
        return false;
    }
}


public function image_get(){
    require_once __DIR__."/image.php";
    global $db;
    $image = new image;
    $test =  $image->getImage($this->id,A::EVENT);
    if($test==false){return BF::abs_path("media/img/user_anonyme.jpg");}
    else{return $test;}
  }
  
  public function image_suppr(){
    require_once __DIR__."/image.php";
    global $db;
    $image = new image;
    $image->deleteImage($this->id,A::EVENT);
  }
  
  public function image_set($image){
    global $db;
    require_once __DIR__."/image.php";
    $image_asso = new image;
    $image_asso->setImage($image);
    $image_asso->verifier_format();
    $image_asso->deleteImage($this->id,A::EVENT);
    $image_asso->placer_image(A::EVENT,BF::abs_path("media/logo/event/",true),$this->id);
    $image_asso->modifier_image($image_asso->fullpath);
  
  }

  /**
   * @todo
   */
  public function insert_prop($prop_name,$prop_value){
    BF::request("DELETE FROM ".A::PROPEVENT." WHERE ".A::PROPEVENT_ID_EVENT." = ? AND ".A::PROPEVENT_NOM." LIKE ?",[$this->id,$prop_value]);
    $req = "INSERT INTO ".A::PROPEVENT." (".A::PROPEVENT_ID_EVENT.",".A::PROPEVENT_NOM.",".A::PROPEVENT_VALEUR.") VALUES (?,?,?)";
    BF::request($req,[$this->id,$prop_name,$prop_value]);
  }
  /**
   * @todo
   */
    public function suppr_prop($prop_name){
        
    }

    public function asso_get_id(){
        return BF::request("SELECT ".A::EVENT_ID_ASSO." FROM ".A::EVENT." WHERE ".A::EVENT_ID." = ?",[$this->id],true,true)[0];
    }

    public function description_get(){
        return BF::request("SELECT ".A::EVENT_DESCRIPTION." FROM ".A::EVENT." WHERE ".A::EVENT_ID." = ?",[$this->id],true,true)[0];
    }
}

?>
