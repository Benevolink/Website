<?php
require_once "../../links.php";
header('Content-Type: application/json; charset=utf-8');
BF::abs_path("libs/Domaine.php",true);
$result = Domaine::get_all();
if(isset($result)&&is_array($result)){
  echo json_encode($result,JSON_UNESCAPED_UNICODE);
}
?>