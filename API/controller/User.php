<?php
require_once BF::abs_path("libs/User.php",true);
require_once __DIR__."/../model/User.php";

switch($fonction){
    case "":
        break;
    case "auth":
        APIUser::api_auth($_POST["email"],$_POST["mdp"]);
        break;
    case "changer_role_asso":
        $user = new APIUser();
        $user->api_asso_changer_role_membre($_POST["id_asso"],$_POST["id_user"],$_POST["role"]);
        break;
    case "rejoindre_asso":
        $user = new APIUser();
        $user->api_rejoindre_asso($_POST["id_asso"]);
        break;
    case "inscription_etape1":
        APIUser::api_inscription_etape1($_POST["email"],$_POST["tel"],$_POST["mdp"],$_POST["mdp2"]);
        break;
    case "liste_asso":
        $user = new APIUser();
        $user->api_liste_asso();
        exit();
    case "set_pp":
        $user = new APIUser();
        $user->id=$_POST["id_user"];
        $user->set_user_image($_POST["photo_profil"]);
        return_statut(true);
        exit();
    case "change_pp":
        $user = new APIUser();
        $user->id=$_POST["id_user"];
        $user->change_user_image($_POST["photo_profil"]);
        return_statut(true);
        exit();
    case "suppr_pp":
        $user = new APIUser();
        $user->id=$_POST["id_user"];
        $user->suppr_image_user();
        return_statut(true);
        exit();
    case "get_pp":
        $user = new APIUser();
        $user->id=$_POST["id_user"];
        $array = array("statut" => 1,"lien_image" => $user->get_image_user());
        return_json($array);
        exit();
    case "suppr_compte":
        if(BF::is_connected()){
            $id = $_SESSION["user_id"];
            $user = new APIUser();
            $user->id = $id;
            $user->suppr();
            return_statut(true);
            }
        else{return_statut(false);}
    case "deconnexion":
        
        $_SESSION["auth"] = 0;
        $_SESSION["user_id"]=null;

        header("Location: ../../../index.php");
        session_destroy();
        exit();
        
    default:
        echo "Veuillez spécifier une fonction";
        exit();
    
}


?>