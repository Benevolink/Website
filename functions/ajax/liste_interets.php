<?php
require_once "../../links.php";
header('Content-Type: application/json; charset=utf-8');

$req = "SELECT * FROM domaine";
$result = BF::request($req,[],true,false,PDO::FETCH_ASSOC);
if(isset($result)&&is_array($result)){
  echo json_encode($result,JSON_UNESCAPED_UNICODE);
}
?>