<?php
require_once $path_rel."/php_class/cal_Event.php";
require_once $path_rel."/dict.php";
require_once $path_rel."/config.php";

/**
 * Cette classe permet de créer des journées, ces journées peuvent regrouper des évènements pour ensuite
 * pouvoir les afficher sur le calendrier.
 * 
 * @since 1.0
 */
class cal_Day{
    protected $date_debut;
    protected $list_events;
    protected $X;
    protected $Y;
    protected $day_string;
    /**
     * Constructeur de la classe
     * 
     * @param int $date_debut la date de début du jour en format timestamp
     */
    function __construct($date_debut){
        $this->date_debut = $date_debut;
        $this->list_events = array();
        $this->X = 0;
        $this->Y = 0;
        $this->day_string = "";
    }


    /**
    * Ajoute un évènement au jour si ce dernier convient
    *
    * @param cal_Event $e Instance de cal_Event
    *
    * @throws boolean
    *
    * @return boolean
    */
    public function add_event(cal_Event $e){
        
        if($e->in_day($this->date_debut)){
            $this->list_events[]=$e;
            return true;
        }
        return false;
        
    }
    /**
     * Affecte X et Y
     * 
     * @param int $X
     * 
     * @param int $Y
     * 
     */
    public function set_XY($X, $Y){
        $this->X = $X;
        $this->Y = $Y;
    }

    /**
     * Affecte day_string
     * 
     * @param string $string
     */
    public function set_day_string($string){
        $this->day_string = $string;
    }


    protected function afficher_events(){
        foreach($this->list_events as $key=>$value){
            $array = $value->get_start_end_within_day($this->date_debut);
            ?>
            <div class="calendar_event" id_event="<?= $value->get_id()?>">
                <div style="text-weight: bold; padding-bottom: 2px;">
                    <?= $value->get_name() ?>
                </div>
                <img src="<?= BF::abs_path("../media/img/calendar.png") ?>" style="width: 15px;display: inline-block;">
                <?= date("H:i",$array[0]). " à " .date("H:i",$array[1])?>
            </div>
            <?php
        }
    }

    /**
     * Affiche le jour dans le calendrier
     * 
     * @param int $date_debut_mois
     * 
     * @param int $date_fin_mois
     * 
     */
    public function creer_case_jour($date_debut_mois,$date_fin_mois){
        $dans_mois = true;
        $timestamp = $this->date_debut;
        $day = $this->day_string;
        $X = $this->X;
        $Y = $this->Y;
        if($timestamp<$date_debut_mois || $timestamp > $date_fin_mois){
            $dans_mois = false;
        }
        ?>
        <div class= "calendar_jour" style= "grid-column:<?=($X+1)?>;grid-row:<?=($Y+1)?>;<?php if(!$dans_mois)echo "background-color: var(--couleur_case_hors_mois);"; ?>">
            <div class="calendar_jour_titre">
                <?= ucfirst($day)." ". date("d",$timestamp) ?>
            </div>
        
            <div class="calendar_jour_events">
                <?php $this->afficher_events();?>
            </div>
            <input type="hidden" value="<?= $timestamp ?>"/>
        </div>
        <?php
    }

}
?>