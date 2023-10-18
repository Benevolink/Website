<?php
require_once __DIR__."/../../../links.php";
BF::sess_start();
$array = array();
if(BF::is_connected()&&isset($_POST["reponse"])&&isset($_POST["id_sondage"])&&is_int(intval($_POST["reponse"]))){
    $r = $_POST["reponse"];
    $req = "SELECT * FROM sondage WHERE id = ?";
    $rep = BF::request($req,[$_POST["id_sondage"]],true,true,PDO::FETCH_ASSOC);
    if($rep !=null && sizeof($rep)>0){
        $taille = sizeof(explode(";",$rep["reponses"]));
        if(0<=$r && $r<$taille){
            BF::request("DELETE FROM reponse_sondage WHERE id_sondage = ? AND id_user = ?",[$_POST["id_sondage"],$_SESSION["user_id"]]);
            $req = "INSERT INTO reponse_sondage (id_sondage, id_user, reponse) VALUES (?,?,?)";
            if(BF::request($req,[$_POST["id_sondage"],$_SESSION["user_id"],$r])){
                $array[0]=true;
            }
        }
    }
    
}
if(sizeof($array)==0){
    $array[0]=false;
}
echo  json_encode($array,JSON_UNESCAPED_UNICODE);
?>