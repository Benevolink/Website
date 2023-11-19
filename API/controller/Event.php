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
    case "insert":
        try{
            $array = json_decode($_POST["array"]); 
            APIEvent::insert($array["date_debut"],$array["date_fin"],$array["heure_debut"],$array["heure_fin"],$array["id_asso"],$array["nom_event"],$array["nb_personnes"],$array["visu"],$array["desc"],$array["departement"],$array["adresse"]);
            return_statut(true);
        }
        catch(Exception $e){
            return_statut(false,$e->getMessage());  
        }
        exit();
        
        


}