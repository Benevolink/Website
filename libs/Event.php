<?php
require_once __DIR__."/../functions/basic_functions.php";
require_once BF::abs_path("db.php",true);
class Event{    
    
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
     * Method suppr_event
     *
     * @return void
     */
    public function suppr_event()
    {
        $id_event = $this->id;
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
    public function insert_evenement($date_debut, $date_fin, $heure_debut, $heure_fin, $id_asso, $nom_event, $nb_personnes, $visu, $desc, $departement, $adresse) {
        global $db;
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
  
        return new Event($id_event);
    }
    
    /**
     * Renvoie la valeur de la propriété associée
     *
     * @param string $propNom $propNom [la propriété]
     *
     * @return string valeur de la propriété
     */
    public function get_prop_evenement($propNom) {
        return BF::request("SELECT valeur FROM prop_evenements WHERE id_event = ? AND prop_nom = ?", [$this->id, $propNom], true, true)[0];
    }

        
    /**
     * Renvoie toutes les infos de l'évènement associé
     *
     * @return array
     */
    public function all_infos(){
        return BF::request("SELECT * FROM evenements WHERE id = ?",[$this->id],true,false,PDO::FETCH_ASSOC);
    }
}

?>