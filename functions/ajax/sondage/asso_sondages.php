<?php

/**
 * Ce code est périmé, mes sondages ne sont plus supportés :(
 */
require_once __DIR__."/../../../links.php";
BF::sess_start();
$array = array();
if(BF::is_connected() && isset($_POST["id_asso"])){
    $id_asso = $_POST["id_asso"];
    $req = "SELECT s.* FROM sondage s JOIN assos a ON s.id_asso = a.id WHERE id_asso = ?";
    $array = BF::request($req,[$id_asso],true,false,PDO::FETCH_ASSOC);
}
echo  json_encode($array,JSON_UNESCAPED_UNICODE);
?>