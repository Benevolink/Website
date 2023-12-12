<?php
require_once __DIR__.'/../../links.php';
require_once __DIR__.'/../../libs/Domaine.php';
require_once __DIR__.'/../../libs/Event.php';

function get_event_by($filter){
    $domaine = new Domaine($filter);
    $lst_events_filter_id = $domaine->get_event_id_by_domain();
    return $lst_events_filter_id;
}

function is_in($elt, $lst){
    $is_in = false;
    foreach($lst as $key => $value){
        if ($value == $elt){
            $is_in = true;
        }
    }
    return $is_in;
}

function get_all_events_by_filter($filters_lst){
    $array = array();
    foreach($filters_lst as $key => $value){
        $lst_events_filter_id = get_event_by($value);
        foreach($lst_events_filter_id as $key2 => $value2){
            if(!is_in($value2, $array)){
                array_push($array, $value2);
            }
        }
    }
    return $array;
}

/**
 * @$_POST['lst_filters'] liste des filtres pour la recherche.
 */
$resp = array();
$status = get_all_events_by_filter($_POST['lst']);
$resp['statut'] = $status;


echo  json_encode($resp,JSON_UNESCAPED_UNICODE);
exit();


?>