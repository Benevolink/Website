<?php
require_once $path_rel.'/../../basic_functions.php';
require_once $path_rel."/php_class/cal_Day.php";


/**
 * Cette classe permet de créer un calendrier, puis de pouvoir lui ajouter des évènements.
 * C'est la classe qui est censée être utilisée pour implémenter le planning dans le site.
 * 
 * @author Emeric Braud
 * @package calendar
 * @version 1.0
 * @since 1.0
 * @license PHP 5.6.3 et supérieur
 * 
 */
class cal_Calendar{

    /**
     * Ajoute le jour spécifié au calendrier
     */
    protected function remplir_jour($timestamp){
        global $lex;
        $day = date("N",$timestamp)-1;
        $date_a = new DateTimeImmutable(date("Y-m-d",$this->date_debut));
        $date_b = new DateTimeImmutable(date("Y-m-d",$timestamp));
        $week = date_diff($date_a,$date_b);

        $week = intval((intval($week->format("%a"))/7));
        $day_string = $lex["day"][$day];
        $cal_day = new cal_Day($timestamp);
        $cal_day->set_XY($day,$week);
        $cal_day->set_day_string($day_string);
        $this->list_day[]=$cal_day;

    }
    /**
     * Crée tous les jours pour le calendrier
     */
    protected function remplir_les_jours(){
        for($compteur = $this->date_debut;$compteur < $this->date_fin +1;   $compteur = strtotime("+1 day",$compteur)){
            $this->remplir_jour($compteur);
        }
    }
    /**
     * Affiche le calendrier
     */
    public function afficher_calendrier(){
        foreach($this->list_day as $key => $value){
            $value->creer_case_jour($this->date_debut_mois,$this->date_fin_mois);
        }
    }

    public function add_event(cal_Event $e){
        foreach($this->list_day as $key => $value){
            $value->add_event($e);
        }
    }
    private $date_debut;
    private $date_fin;
    private $date_debut_mois;
    private $date_fin_mois;
    private $list_day;

    /**
     * Class constructor
     * 
     * @param int $date_debut_mois
     * 
     * @param int $date_fin_mois
     */
    function __construct($date_debut_mois, $date_fin_mois){
        $this->date_debut_mois = $date_debut_mois;
        $this->date_fin_mois = $date_fin_mois;
        $this->date_debut = strtotime("monday this week",$date_debut_mois);
        $this->date_fin = strtotime("sunday this week",$date_fin_mois);
        $this->list_day = array();
        $this->remplir_les_jours();

    }


}
?>