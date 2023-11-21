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
        if(!$user->est_admin_asso($id_asso))
        {
            return_statut(false,"Vous n'avez pas les droits pour effectuer cette action.");
            exit();
        }
        $user_cible = new User($id_user_cible);
        $asso = new Asso($id_asso);
        $asso->modifier_role_membre($user_cible,$nouveau_statut);
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
}