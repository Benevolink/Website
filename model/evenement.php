

<?php
//TOUTES LES REQUETES BDD SERONT DANS libs
$req = "SELECT valeur FROM prop_evenements WHERE id_event = ? AND prop_nom = ?"; //requete SQL utilisée en masse sur la page

/**
 * Affiche les éléments pour la date
 *
 * @return void
 */
function afficher_dates(){
    global $infos;
    ?>
    <div class="titre_rubrique_event">
        Date
    </div>
    De : <div style="float: right;"><img src="<?= BF::abs_path("media/img/calendar.png") ?>" style="width: 10px; display: inline-block;"> <?= date("Y/m/d  ",$infos["date_event_debut"]) ?><img src="<?= BF::abs_path("media/img/clock.png") ?>" style="height: 12px; display: inline-block;"><?= date(" H:i",$infos["date_event_debut"]) ?></div>
    <div style="clear:both;"></div>
    A : <div style="float: right;"><img src="<?= BF::abs_path("media/img/calendar.png") ?>" style="width: 10px; display: inline-block;"> <?= date("Y/m/d  ",$infos["date_event_fin"]) ?><img src="<?= BF::abs_path("media/img/clock.png") ?>" style="height: 12px; display: inline-block;"><?= date(" H:i",$infos["date_event_fin"]) ?></div>
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
    $freq = $event->get_prop_evenement("freq");
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
    $visu = $event->get_prop_evenement("visu");

    if($visu? 1 : 0){
        $vis = $visu;
    }
    echo " Visibilité : ".$vis;
}


/** 
* Récupère les infos d'un événement
*
* @return $infos
**/
function get_infos($id_event){
    global $infos;
    $infos = BF::request("SELECT * FROM evenements WHERE id_event = ?",[$id_event],true,false,PDO::FETCH_ASSOC)[0];
    return $infos;
}


/** 
* Récupère le logo d'un événement
*
* @return $logo
**/
function get_logo($id_event){
    global $req;
    $logo = BF::request($req, [$id_event,"logo"],true,true);
    return $logo;
}


/** 
* Récupère la description d'un événement
*
* @return $desc
**/
function get_desc($id_event){
    global $req;
    $desc = BF::request($req, [$id_event,"desc"],true,true);
    return $desc;
}

?>