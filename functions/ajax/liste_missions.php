<?php
require_once "../../links.php";
header('Content-Type: application/json; charset=utf-8');
$array = array();
BF::sess_start();

if(!isset($_GET["id_asso"]) && BF::is_connected()){
  $array = BF::request("SELECT e.id_event, e.nom_event, ho.date_debut, ho.date_fin, a.nom, a.id FROM (((evenements e JOIN assos a ON e.id_asso = a.id) JOIN  membres_evenements me ON me.id_event = e.id_event )JOIN horaire ho ON ho.id_horaire = e.id_horaire) WHERE me.id_user = ?",[$_SESSION["user_id"]],true,false,PDO::FETCH_ASSOC);
  
  foreach($array as $key=>$value){
    foreach($value as $key1 => $value1){
      if(BF::equals($key1,"id")){
        if(glob("../../media/logo/event/".$value1.".*")){
          foreach (glob("../../media/logo/event/".$value1.".*") as $filename) {
            $array[$key]["logo"]= basename($filename);
          }
        }else{
          $array[$key]["logo"]="default.jpg";
        }
      }
      $array[$key][$key1] = BF::XSS($value1);
    }
    //On essaie d'obtenir si elle existe la description
    $req = "SELECT valeur FROM prop_evenements WHERE prop_nom = 'desc' AND id_event = ?";
    $rep = BF::request($req,[$array[$key]["id"]],true);
    if(sizeof($rep)==1){
      $array[$key]["desc"] = substr($rep[0][0],0,100);
    }else{
      $array[$key]["desc"] = "Pas de description pour cet évènement";
    }
  }
}elseif(isset($_GET["id_asso"])){
  $id_asso = $_GET["id_asso"];
  $array = BF::request("SELECT e.id_event, e.nom_event, ho.date_debut, ho.date_fin, a.nom, a.id FROM ((evenements e JOIN assos a ON e.id_asso = a.id) JOIN horaire ho ON e.id_horaire = ho.id_horaire) WHERE a.id = ?",[$id_asso],true,false,PDO::FETCH_ASSOC);
  foreach($array as $key=>$value){
    foreach($value as $key1 => $value1){
      if(BF::equals($key1,"id_event")){
        if(glob("../../media/logo/event/".$value1.".*")){
          foreach (glob("../../media/logo/event/".$value1.".*") as $filename) {
            $array[$key]["logo"]= basename($filename);
          }
        }else{
          $array[$key]["logo"]="default.jpg";
        }
      }
      $array[$key][$key1] = BF::XSS($value1);
    }
    //On essaie d'obtenir si elle existe la description
    $req = "SELECT valeur FROM prop_evenements WHERE prop_nom = 'desc' AND id_event = ?";
    $rep = BF::request($req,[$array[$key]["id"]],true);
    if(sizeof($rep)==1){
      $array[$key]["desc"] = substr($rep[0][0],0,100);
    }else{
      $array[$key]["desc"] = "Pas de description pour cet évènement";
    }
  }
}

echo  json_encode($array,JSON_UNESCAPED_UNICODE);
?>