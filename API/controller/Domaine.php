<?php
require_once BF::abs_path("libs/Domaine.php",true);
require_once __DIR__."/../model/Domaine.php";

switch($fonction){
    case "":
        exit();
    case "get_all":
        return_json(Domaine::get_all());
        exit();
    case "insert":
        $user = new User();
        if(!$user->is_admin_glob()){
            return_statut(false);
            exit();
        }
        Domaine::insert($_POST["nom_domaine"]);
        exit();
    



}

?>