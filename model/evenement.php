

<?php

/**
 * Affiche les éléments pour la date
 *
 * @return void
 */
function afficher_dates(){
    global $infos;
    if(ctype_digit($infos["date_debut"]))
    {
        $date_debut_h = date(" H:i",$infos["date_debut"]);
        $date_fin_h = date(" H:i",$infos["date_fin"]);
        $date_debut = date("Y/m/d  ",$infos["date_debut"]);
        $date_fin = date("Y/m/d  ",$infos["date_fin"]);
    }else{
        $date_debut = $infos["date_debut"];
        $date_fin = $infos["date_fin"];
        $date_debut_h = $infos["heure_debut"];
        $date_fin_h = $infos["heure_fin"];
    }
    ?>
    <div class="titre_rubrique_event">
        Date
    </div>
    De : <div style="float: right;"><img src="<?= BF::abs_path("media/img/calendar.png") ?>" style="width: 10px; display: inline-block;"> <?= $date_debut ?><img src="<?= BF::abs_path("media/img/clock.png") ?>" style="height: 12px; display: inline-block; margin-left: 10px;"><?= $date_debut_h ?></div>
    <div style="clear:both;"></div>
    A : <div style="float: right;"><img src="<?= BF::abs_path("media/img/calendar.png") ?>" style="width: 10px; display: inline-block;"> <?= $date_fin ?><img src="<?= BF::abs_path("media/img/clock.png") ?>" style="height: 12px; display: inline-block; margin-left: 10px;"><?= $date_fin_h ?></div>
    <div style="clear: both"></div>
    <?php
}


/**
 * Récupère la fréquence de l'évènement et l'affiche
 *
 * @return void
 */
function afficher_frequence(){
    global $event;
    $frequence = "";
    $freq = $event->get_prop_value("freq");
    if(BF::equals($freq,"annu")? 1 : 0){
        $frequence = "Annuelle";
    }elseif(BF::equals($freq,"mens")? 1 : 0){
        $frequence = "Mensuelle";
    }
    elseif(BF::equals($freq,"hebd")? 1 : 0){
        $frequence = "Hebdomadaire";
    }
    elseif(BF::equals($freq,"quot")? 1 : 0){
        $frequence = "Quotidienne";
    }
    echo "Fréquence : ".$frequence."<br>";
}

function afficher_visu(){
    global $event;
    $vis = "";
    $visu = $event->get_prop_value("visu");

    if($visu? 1 : 0){
        $vis = $visu;
    }
    echo " Visibilité : ".$vis;
}






/** 
* Récupère la description d'un événement
* @return $desc
**/
function get_desc($id_event){
    global $event;
    return $event->get_prop_value("desc");
}

?>