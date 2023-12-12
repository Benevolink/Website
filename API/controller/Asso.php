<?php
require_once BF::abs_path("libs/Asso.php",true);
require_once __DIR__."/../model/Asso.php";

switch($fonction){
    case "":
        break;
    case "search":
        if(isset($_POST["recherche"]))
            APIAsso::api_search($_POST["recherche"]); 
        else
            APIAsso::api_search(""); 
        exit();
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
        
        $expected_parameters = ["nom", "desc", "missionsProposees", "adresse", "email", "tel"];

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
        if(!isset($_FILES["logoAssociation"])){
            $status_array["logoAssociation"] = ["statut" => 0];
            $parametres_enregistres = false;
        }else{
            $status_array["logoAssociation"] = ["statut" => 1];
        }

        // Si on arrive ici, tous les paramètres sont présents
        if ($parametres_enregistres==0) {
            $status_array["statut"] = 0;
            return_json($status_array);
            exit();
        }
        $association = $_POST["nom"];
        $description = $_POST["desc"];
        $description_missions = $_POST["missionsProposees"];
        $logo = $_FILES["logoAssociation"];
        $adresse = $_POST["adresse"];
        $email = $_POST["email"];
        $telephone = $_POST["tel"];
        Asso::insert($association, $description, $description_missions, $logo, $email, $telephone,[],$adresse);

        return_statut(true, "L'association a été insérée avec succès");
        exit();
            

    case "user_modif_statut":  
        if(!(isset($_POST["id_user"]) && isset($_POST["id_asso"]) && isset($_POST["nouveau_statut"]) && is_numeric($_POST["nouveau_statut"]))){
            return_statut(false,"Formulaire incomplet");
            exit();
        }
        $nouveau_statut = $_POST["nouveau_statut"];
        $id_user_cible = $_POST["id_user"];
        $id_asso = $_POST["id_asso"];
        require_once BF::abs_path("libs/User.php",true);
        $user = new User();
        if($user->id == $id_user_cible){
            return_statut(false,"Vous ne pouvez pas modifier votre propre rôle.");
            exit();
        }
        if(!$user->est_admin_asso($id_asso))
        {
            return_statut(false,"Vous n'avez pas les droits pour effectuer cette action.");
            exit();
        }
        $user_cible = new User($id_user_cible);
        $asso = new Asso($id_asso);
        $asso->modifier_role_membre($id_user_cible,$nouveau_statut);
        return_statut(true);
        exit();
    case "user_get_statut":
        if(!(isset($_POST["id_user"]) && isset($_POST["id_asso"]))){
            return_statut(false,"Formulaire incomplet");
            exit();
        }
        $id_user_cible = $_POST["id_user"];
        $id_asso = $_POST["id_asso"];
        require_once BF::abs_path("libs/User.php",true);
        $user = new User();
        if(!$user->est_admin_asso($id_asso))
        {
            return_statut(false,"Vous n'avez pas les droits pour effectuer cette action.");
            exit();
        }
        $asso = new Asso($id_asso);
        $role = $asso->get_role_membre($id_user_cible);
        return_json(array("statut"=>1, "user_statut"=>$role));
        exit();
    case "get_logo":
        if(!isset($_POST["id_asso"])){
            return_statut(false,"Veuillez spécifier un id_asso");
            exit();
        }
        $id_asso = $_POST["id_asso"];
        $asso = new Asso($id_asso);
        return_json(array("logo" => $asso->image_get()));
        exit();
    case "get_assos_integrees":
        BF::sess_start();
        if(!BF::is_connected()){
            return_statut(false,"Vous n'êtes pas connecté !");
            exit();
        }
        require_once BF::abs_path("libs/User.php",true);
        $user = new User();

        return_json($user->liste_assos_integrees());
        exit();
    case "get_assos_en_attente":
        BF::sess_start();
        if(!BF::is_connected()){
            return_statut(false,"Vous n'êtes pas connecté !");
            exit();
        }
        require_once BF::abs_path("libs/User.php",true);
        $user = new User();

        return_json($user->liste_assos_en_attente());
        exit();
    case "user_join":
        BF::sess_start();
        if(!BF::sess_start()){
            return_statut(false,"Vous n'êtes pas connecté !");
            exit();
        }
        if(!isset($_POST["id_asso"])){
            return_statut(false,"Veuillez spécifier un id_asso");
            exit();
        }
        $id_asso = $_POST["id_asso"];
        require_once BF::abs_path("libs/User.php",true);
        $user = new User();

        $user->rejoindre_asso($id_asso);
        return_statut(true);
        exit();
    case "user_leave":
        BF::sess_start();
        if(!BF::sess_start()){
            return_statut(false,"Vous n'êtes pas connecté !");
            exit();
        }
        if(!isset($_POST["id_asso"])){
            return_statut(false,"Veuillez spécifier un id_asso");
            exit();
        }
        $id_asso = $_POST["id_asso"];
        require_once BF::abs_path("libs/User.php",true);
        $user = new User();

        $user->quitter_asso($id_asso);
        return_statut(true);
        exit();
}

