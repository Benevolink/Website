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
    case "set_image":
        $user = new APIUser();
        $user->id=$_POST["id_user"];
        $user->set_user_image($_POST["photo_profil"]);
        exit();
    
    default:
        echo "Veuillez spécifier une fonction";
        exit();
    
}


?>