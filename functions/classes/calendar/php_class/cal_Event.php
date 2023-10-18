<?php
/**
 * Cette classe permet de créer des évènements
 * 
 * @since 1.0
 */
class cal_Event{
    protected $date_debut;
    protected $date_fin;
    protected $nom;
    protected $id;
    /**
     * Le constructeur de la classe
     * 
     * @param int $date_debut le format timestamp du début de l'évènement
     * 
     * @param int $date_fin le format timestamp de la fin de l'évènement
     * 
     * @param string $nom le nom de l'évènement
     */
    function __construct($id){
        $array = BF::request("SELECT * FROM evenements WHERE id_event = ?",[$id],true,true,PDO::FETCH_ASSOC);
        $this->id = $id;
        $array_2 = BF::request("SELECT * FROM horaire WHERE id_horaire = ?",[$array['id_horaire']],true,true,PDO::FETCH_ASSOC);
        $this->date_debut = $array_2["date_debut"];
        $this->date_fin = $array_2["date_fin"];
        $this->nom = $array["nom_event"];

    }


    /**
     * Sert à dire si oui ou nom l'évènement se passe ce jour-ci
     * 
     * @param int $date_debut_jour correspond au format timestamp du début de la journée spécifiée
     * 
     * @return boolean vrai ou faux
     */
    public function in_day($date_debut_jour){
        $date_fin_jour = $date_debut_jour + 3600*24;
        if(($date_debut_jour<= $this->date_debut && $this->date_debut<$date_fin_jour)||($date_debut_jour< $this->date_fin && $this->date_fin<=$date_fin_jour)||($this->date_debut<=$date_debut_jour && $date_fin_jour<=$this->date_fin)){
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * Sert à retourner les dates de début et de fin de l'évènement incluses dans le jour spécifié
     * 
     * 
     * 
     * @param int $date_debut_jour spécifie en format timestamp la date du jour donné
     * 
     * @throws false si l'évènement n'a pas lieu ce jour-ci
     * 
     * @return array([int $debut,int $fin]) renvoie les dates de début et de fin
     */

    public function get_start_end_within_day($date_debut_jour){
        $date_fin_jour = $date_debut_jour + 3600*24-1;
        if($this->in_day($date_debut_jour)){
            $debut = max($date_debut_jour,$this->date_debut);
            $fin = min($date_fin_jour,$this->date_fin);
            return array($debut,$fin);
        }else{
            return false;
        }
    }
    function get_name(){
        return $this->nom;
    }

    function get_id(){
        return $this->id;
    }
    /**
     * Renvoie l'id de tous les évènements de l'utilisateur
     * @since 1.1
     * 
     * @return array la liste des ids des events
     */
    public static function get_all_events_id($id_user){
        $liste_assos = BF::get_user_assos($id_user);
        $result = array();
        foreach($liste_assos as $key => $value){
            $liste_events = BF::get_asso_events($value);
            foreach($liste_events as $key2 => $value2){
                $result[] = $value2;
            }
        }
        return $result;
    }
}
?>