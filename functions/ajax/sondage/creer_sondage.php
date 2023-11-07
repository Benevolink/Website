<?php

/**
 * Ce code est périmé, mes sondages ne sont plus supportés :(
 */
require_once __DIR__."/../../../links.php";
BF::sess_start();
$array = array();
if(BF::is_connected() && BF::is_posted("id_asso") && BF::is_admin($_SESSION["user_id"],$_POST["id_asso"])){
    if(BF::is_posted(["question","reponses"])){
        $req = "INSERT INTO sondage (id_asso, question, reponses) VALUES (?,?,?)";
        if(BF::request($req,[$_POST["id_asso"],$_POST["question"],$_POST["reponses"]])){
            $array[0]=true;
        }else{
            $array[0]=false;
        }
    }else{
        $array[0]=false;
        $array[1]="Erreur, certaines données sont manquantes";
    }
}else{
    $array[0]=false;
    $array[1] = "Erreur, vous n'avez pas les droits pour cette association";
}
echo  json_encode($array,JSON_UNESCAPED_UNICODE);
?>