<?php
require_once BF::abs_path("libs/Event.php",true);
require_once __DIR__."/../model/Event.php";

switch($fonction){
    case "":
        break;
    case "user_get_all":
        require_once BF::abs_path("libs/User.php",true);
        $user = new User();
        return_json($user->infos_events());
        exit();
    case "join":
        if(!(isset($_POST["id_event"]) && is_numeric($_POST["id_event"]))){
            return_statut(false);
            exit();
        }
        require_once BF::abs_path("libs/User.php",true);
        $user = new User();
        $user->rejoindre_event($_POST["id_event"]);
        return_statut(true);
        exit();
    case "leave":
        if(!(isset($_POST["id_event"]) && is_numeric($_POST["id_event"]))){
            return_statut(false);
            exit();
        }
        require_once BF::abs_path("libs/User.php",true);
        $user = new User();
        $user->quitter_event($_POST["id_event"]);
        return_statut(true);
        exit();
    case "user_statut":
        if(!(isset($_POST["id_event"]) && is_numeric($_POST["id_event"]))){
            return_statut(false);
            exit();
        }
        require_once BF::abs_path("libs/User.php",true);
        $user = new User();
        return_json(array("statut"=>1,"user_statut" => $user->statut_event($_POST["id_event"])));
        exit();
    case "insert":
    
        
        if(!isset($_POST["array"])){
            return_statut(false,"Il manque des champs");
            exit();
        }
        $array = $_POST["array"];
        if(is_string($array))
            $array = json_decode($_POST["array"]); 
        
        require_once BF::abs_path("libs/User.php",true);
        if(!BF::is_connected()){
            return_statut(false,"Vous n'êtes pas connecté");
            exit();
        }

        $user = new User();
        if(!$user->est_admin_asso($array["id_asso"])){
            return_statut(false,"Vous n'êtes pas admin de l'association");
            exit();
        }

        
        APIEvent::insert($array["date_debut"],$array["date_fin"],$array["heure_debut"],$array["heure_fin"],$array["id_asso"],$array["nom"],$array["nb_personnes"],$array["visu"],$array["description"],"",$array["lieu"],$_FILES["logoEvent"]);
        
        return_statut(true);
        exit();
        
    case "search_event":
        require_once BF::abs_path("libs/Event.php",true);

        return_json(Event::search($_POST["distance"],$_POST["recherche"],$_POST["liste_domaines"]));
        exit();
        
     
    
}