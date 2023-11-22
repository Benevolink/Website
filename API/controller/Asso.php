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
    case "join":
        if(!(isset($_POST["id_asso"]) && is_numeric($_POST["id_asso"]))){
            return_statut(false);
            exit();
        }
        require_once BF::abs_path("libs/User.php",true);
        $user = new User();
        $user->rejoindre_asso($_POST["id_asso"]);
        return_statut(true);
        exit();
    case "leave":
        if(!(isset($_POST["id_asso"]) && is_numeric($_POST["id_asso"]))){
            return_statut(false);
            exit();
        }
        require_once BF::abs_path("libs/User.php",true);
        $user = new User();
        $user->quitter_asso($_POST["id_asso"]);
        return_statut(true);
        exit();
    case "insert":
        
        $expected_parameters = ["nom", "desc", "desc_missions", "uploadedfile", "email", "tel"];

        $status_array = []; // Initialisation du tableau vide
        $parametres_enregistres = true; // Booléen pour suivre l'enregistrement des paramètres

        foreach ($expected_parameters as $param) {
            if (!isset($_POST[$param])) {
                $status_array[$param] = ["statut" => 0];
                $parametres_enregistres = false; // Si au moins un paramètre est manquant, le booléen est mis à false
            } else {
                $status_array[$param] = ["statut" => 1];
            }
        }

        // Si on arrive ici, tous les paramètres sont présents
        if ($parametres_enregistres==0) {
            $status_array["statut"] = 0;
            return_json($status_array);
            exit();
        }
        $association = $_POST["nom"];
        $description = $_POST["desc"];
        $description_missions = $_POST["desc_missions"];
        $logo = $_FILES["uploadedfile"]["name"];
        $email = $_POST["email"];
        $telephone = $_POST["tel"];

        Asso::insert($association, $description, $description_missions, $logo, $email, $telephone, []);

        return_statut(true, "L'association a été insérée avec succès");
        exit();
            
}



    
}