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
     * @param int $priority [Event priority (1 to 5)]
     *
     * @return Event
     */

     /**
 * Validates time in 24-hour format (HH:MM)
 *
 * @param string $time Time to validate
 *
 * @return bool True if valid, false otherwise
 */
private static function validateTimeFormat($time) {
    return preg_match("/^(?:[01][0-9]|2[0-3]):[0-5][0-9]$/", $time);
}
public static function insert($date_debut, $date_fin, $heure_debut, $heure_fin, $id_asso, $nom_event, $nb_personnes, $visu, $desc, $departement, $adresse, $priority) {
    
    // Validate heure_debut and heure_fin
    if (!self::validateTimeFormat($heure_debut) || !self::validateTimeFormat($heure_fin)) {
        throw new Exception("Invalid time format. Time must be in HH:MM format.");
    }
    global $db;
        $priority = max(1, min(5, $priority));
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
        $evenementInsertQuery = "INSERT INTO ".A::EVENT." (".A::EVENT_ID_ASSO.", ".A::EVENT_NOM.", ".A::EVENT_ID_HORAIRE.", ".A::EVENT_NB_MAX_PERSONNES.", ".A::EVENT_VISIBILITE.", ".A::EVENT_DESCRIPTION.", ".A::EVENT_ID_LIEU.", ".A::EVENT_PRIORITY.") VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        BF::request($evenementInsertQuery, [$id_asso, $nom_event, $id_horaire, $nb_personnes, $visu, $desc, $id_lieu, $priority], false);
        
        $id_event = $db->lastInsertId();
  
        return new Event($id_event);
    }


/**
     * Renvoie la priorité de l'évènement
     *
     * @param int $id_event [Event ID]
     *
     * @return int
     */
    public static function getEventPriority($id_event) {
        return BF::request("SELECT ".A::EVENT_PRIORITY." FROM ".A::EVENT." WHERE ".A::EVENT_ID." = ?", [$id_event], true, true)[0];
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
     * Calcule et récupère la durée de l'événement en heures en se basant sur l'ID de l'événement
     * 
     * @param int $id_event ID de l'événement
     * 
     * @return int Durée de l'événement en heures
     * @throws Exception si l'événement n'est pas trouvé ou si le format des heures est invalide
     */
    public static function calculerDureeEvenement($id_event) {
        // Récupérer les heures de début et de fin de l'événement depuis la base de données
        $eventData = BF::request("SELECT ".A::HORAIRE_HEURE_DEBUT.", ".A::HORAIRE_HEURE_FIN." FROM ".A::HORAIRE." WHERE ".A::HORAIRE_ID." = ?", [$id_event], true, true);
        
        if (!$eventData) {
            throw new Exception("Événement non trouvé.");
        }

        list($heure_debut, $heure_fin) = $eventData;

        // Validation des formats d'heure
        if (!self::validateTimeFormat($heure_debut) || !self::validateTimeFormat($heure_fin)) {
            throw new Exception("Format de l'heure invalide. L'heure doit être au format HH:MM.");
        }

        // Convertit les heures en objets DateTime pour faciliter le calcul de la durée
        $debut = DateTime::createFromFormat('H:i', $heure_debut);
        $fin = DateTime::createFromFormat('H:i', $heure_fin);

        // Vérifie si l'heure de début est postérieure à l'heure de fin
        if ($debut > $fin) {
            throw new Exception("L'heure de début est postérieure à l'heure de fin.");
        }

        // Calcul de la différence entre les deux heures
        $interval = $debut->diff($fin);

        // Renvoie la durée totale en heures, arrondie à l'heure la plus proche
        return (int) $interval->format("%h");
    }

/**
     * Génère un vecteur de créneaux horaires pour l'événement basé sur son ID.
     * 
     * @param int $id_event ID de l'événement
     * 
     * @return array Vecteur de créneaux horaires de l'événement
     */
    public static function genererVecteurCreneaux($id_event) {
        // Initialiser le vecteur à 0 pour chaque heure de chaque jour de la semaine (168 heures)
        $vecteur = array_fill(0, 168, 0);
        
        // Récupérer les détails de l'événement de la base de données
        $detailsEvent = BF::request("SELECT * FROM ".A::EVENT." INNER JOIN ".A::HORAIRE." ON ".A::EVENT.".".A::EVENT_ID_HORAIRE." = ".A::HORAIRE.".".A::HORAIRE_ID." WHERE ".A::EVENT.".".A::EVENT_ID." = ?", [$id_event], true, true);
        
        if (!$detailsEvent) {
            throw new Exception("Événement non trouvé.");
        }

        // Convertir les heures de début et de fin en indices de vecteur
        // Suppose que $detailsEvent contient 'heure_debut', 'heure_fin', et 'jour_semaine'
        $indexDebut = self::convertirHeureEnIndice($detailsEvent['heure_debut'], $detailsEvent['jour_semaine']);
        $indexFin = self::convertirHeureEnIndice($detailsEvent['heure_fin'], $detailsEvent['jour_semaine']);

        // Mettre à jour le vecteur pour les créneaux actifs
        for ($i = $indexDebut; $i <= $indexFin; $i++) {
            $vecteur[$i] = 1;
        }

        return $vecteur;
    }

    /**
     * Convertit une heure et un jour de semaine en un indice de vecteur.
     * 
     * @param string $heure Heure au format HH:MM
     * @param string $jour Jour de la semaine
     * 
     * @return int Indice de vecteur
     */
    private static function convertirHeureEnIndice($heure, $jour) {
        $jours = ['L', 'Ma', 'Me', 'J', 'V', 'S', 'D']; // Lundi à Dimanche
        $heureSansMinutes = intval(substr($heure, 0, 2)); // Convertir en nombre entier
        $indexJour = array_search($jour, $jours) * 24; // Trouver l'index de début du jour
        return $indexJour + $heureSansMinutes; // Index du jour + heure
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
 * @return string Message indiquant le résultat de l'opération
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
        return "Membre supprimé avec succès de l'événement.";
    } else {
        // L'utilisateur n'est pas membre
        return "L'utilisateur n'est pas membre de l'événement.";
    }
}

/**
 * Ajoute un membre, et spécifie son rôle
 *
 * @param int $user L'ID de l'utilisateur à ajouter en tant que membre
 * @param string $role Le rôle du membre 
 *
 * @return string Message indiquant le résultat de l'opération
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
        return "Membre ajouté avec succès à l'événement.";
    } else {
        // L'utilisateur est déjà membre
        return "L'utilisateur est déjà membre de l'événement.";
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
 * @return string Message indiquant le résultat de l'opération
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
        return "Le rôle du membre a été modifié avec succès.";
    } else {
        // L'utilisateur n'est pas membre
        return "L'utilisateur n'est pas membre de l'événement.";
    }
}


    /**
   * Ajoute un logo à l'event
   * @
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
   * @todo
   */
  public function suppr_logo(){
    
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