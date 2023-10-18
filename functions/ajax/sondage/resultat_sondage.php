<?php
require_once __DIR__."/../../../links.php";
BF::sess_start();
$array = array();
if(BF::is_posted("id_sondage")){
    $id_sondage = $_GET["id_sondage"];
    $req = "SELECT COUNT(*) AS nombre, reponse FROM reponse_sondage r WHERE id_sondage = ? GROUP BY r.reponse ORDER BY r.reponse ASC";
    $result_1 = BF::request($req,[$id_sondage],true,false,PDO::FETCH_ASSOC);
    
    $req = "SELECT * FROM sondage WHERE id = ?";
    $result = BF::request($req,[$id_sondage],true,false,PDO::FETCH_ASSOC);
    if($result != null && is_array($result) && sizeof($result)>0){
        $array[0]=$result[0];
        $taille = sizeof(explode(";",$result[0]["reponses"]));
        for($i = 0; $i<$taille;$i++){
            $array[$i+1]=0;
            foreach($result_1 as $key=>$value){
                if($value["reponse"]==$i){
                    $array[$i+1]= $value["nombre"];
                }
            }
        }
    }
    $req = "SELECT * FROM reponse_sondage WHERE id_sondage = ? and id_user = ?";
    $rep = BF::request($req,[$id_sondage,$_SESSION["user_id"]],true,true,PDO::FETCH_ASSOC);
    if(isset($rep)&&is_array($rep) && sizeof($rep)>0){
        $array[sizeof($array)]=$rep["reponse"];
    }
}
echo  json_encode($array,JSON_UNESCAPED_UNICODE);
?>
