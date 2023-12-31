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
    public static function insert($date_debut, $date_fin, $heure_debut, $heure_fin, $id_asso, $nom_event, $nb_personnes, $visu, $desc, $departement, $adresse) {
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
  
        return new Event($id_event);
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
     * @todo
     */
    public function get_all_membres(){

    }

    /**
     * Enlève le membre de l'évènement
     * @todo
     */
    public function supprimer_membre($user){

    }

    /**
     * Ajoute un membre, et spécifie son rôle
     */
    public function ajouter_membre($user, $role = null){

    }

    /**
     * Simplement utiliser les fonction ci-dessus
     * @todo
     */
    public function modifier_role_membre($user, $role){

    }

    /**
   * Ajoute un logo à l'event
   * @
   * @todo
   */
  public function image_set($image){
    
  }

  /**
   * Renvoie le chemin du logo pour l'implémenter en HTML
   * @todo
   */
  public function image_get(){

  }
  /**
   * Supprime le logo
   * @todo
   */
  public function image_suppr(){
    
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

    public function asso_get_id(){
        return BF::request("SELECT ".A::EVENT_ID_ASSO." FROM ".A::EVENT." WHERE ".A::EVENT_ID." = ?",[$this->id],true,true)[0];
    }
}

?>