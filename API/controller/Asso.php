<?php
require_once BF::abs_path("libs/Asso.php",true);
require_once __DIR__."/../model/Asso.php";

switch($fonction){
    case "":
        break;
    case "search": APIAsso::api_search($_POST["recherche"]); exit();
    case "get_all" :
        if(!isset($_POST["id_asso"])){
            return_statut(false);
            exit();
        }
        $asso = new APIAsso($_POST["id_asso"]);
        return_json($asso->get_all());
        exit();
    case "get_all_events":
        if(!isset($_POST["id_asso"])){
            return_statut(false);
            exit();
        }
        $asso = new APIAsso($_POST["id_asso"]);
        return_json($asso->get_infos_events());
        exit();
}