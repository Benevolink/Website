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
        $user->image_set($_FILES["photo_profil"]);
        return_statut(true);
        exit();
    case "change_pp":
        $user = new APIUser();
        $user->change_user_image($_POST["photo_profil"]);
        return_statut(true);
        exit();
    case "suppr_pp":
        $user = new APIUser();
        $user->image_suppr();
        return_statut(true);
        exit();
    case "get_pp":
        $user = new APIUser();
        $array = array("statut" => 1,"lien_image" => $user->image_get());
        return_json($array);
        exit();
    case "suppr_compte":
        if(BF::is_connected()){
            $user = new APIUser();
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
    case "liste_invitations_missions":
        if(!(BF::is_connected())){
            return_statut(false);
            exit();
        }
        $user = new APIUser();
        $mission_en_attentes_draft=$user->liste_missions_en_attente();
        //remise en forme de la liste
        if(count($mission_en_attentes_draft) == 0){ return_json(array()); exit();}
        $len=count($mission_en_attentes_draft[0]);
        $mission_en_attente=array();
        for($i=0;$i<$len;$i++){
            $mission_en_attente[$i]=[$mission_en_attentes_draft[0][$i],$mission_en_attentes_draft[1][$i]];
        }
        return_json($mission_en_attente);
        exit();
    case "reponse_invit_mission":
        if(!(BF::is_connected())){
            return_statut(false);
            exit();
        }
        if(!isset($_POST["id_event"])){
            return_statut(false);
            exit();
        }
        if(!isset($_POST["reponse"])){
            return_statut(false);
            exit();
        }
        $user = new APIUser();
        if($_POST["reponse"]==false){
            $user->quitter_event($_POST["id_event"]);
            return_statut(true);
        }else{
            require_once BF::abs_path("libs/Event.php",true);
            $event = new Event($_POST["id_event"]);
            $event->modifier_role_membre($user->id,1); //Mettre à membre
            return_statut(true);
        }
        exit();
        
    case "modif_mdp":
        BF::sess_start();
        if(!BF::sess_start()){
            return_statut(false,"Vous n'êtes pas connecté !");
            exit();
        }
        if(!isset($_POST["ancien_mdp"])){
            return_statut(false,"Veuillez spécifier votre ancien mot de passe");
            exit();
        }
        if(!isset($_POST["nouveau_mdp"])){
            return_statut(false,"Veuillez spécifier votre nouveau mot de passe");
            exit();
        }
        $user = new User();
        require_once BF::abs_path("libs/Auth.php",true);
        if(!Auth::verif_pw_id($user->id,$_POST["ancien_mdp"])){
            return_statut(false,"Mot de passe incorrect");
            exit();
        }
        //@todo
        //logique pour vérifier si le mot de passe respecte des règles en vigueur et si oui, le modifie
    
    case "ajouter_competences":
        BF::sess_start();
        if(!BF::sess_start()){
            return_statut(false,"Vous n'êtes pas connecté !");
            exit();
        }
        try{
            $user = new User();
            $liste_competences = $_POST["liste_competences_ajout"];
            $liste_competences_retrait =  $_POST["liste_competences_retrait"];
            foreach($liste_competences as $key => $value)
            {
                $user->ajouter_competence($value);
            }
            foreach($liste_competences_retrait as $key => $value)
            {
                $user->retirer_competence($value);
            }
            return_statut(true);
        }
        catch (Exception $e){
            return_statut(false,$e->getMessage());
        }
        break;
    case "get_all_comp":
        BF::sess_start();
        if(!BF::sess_start()){
            return_statut(false,"Vous n'êtes pas connecté !");
            exit();
        }
        $user = new User();
        try{
            return_json($user->get_all_competences());
        }catch(Exception $e){
            return_statut(false,$e->getMessage());
        }
    default:
        echo "Veuillez spécifier une fonction";
        exit();
    
}
?>