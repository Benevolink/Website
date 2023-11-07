<?php
require_once "../../links.php";
header('Content-Type: application/json; charset=utf-8');
$array = array();
BF::sess_start();
if(!isset($_GET["id_asso"]) && BF::is_connected()){
  //Importation des libraires
  require_once BF::abs_path("libs/User.php",true);
  require_once BF::abs_path("libs/Event.php",true);
  $user = new User();
  $array = $user->infos_events();
  

  //Logo à modifier
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
    $event = new Event($array[$key]["id"]);
    //On essaie d'obtenir si elle existe la description
    $rep = $event->get_prop_evenement('desc');
    if(sizeof($rep)==1){
      $array[$key]["desc"] = substr($rep[0][0],0,100);
    }else{
      $array[$key]["desc"] = "Pas de description pour cet évènement";
    }
  }
}elseif(isset($_GET["id_asso"])){
  //Importation des libraires
  require_once BF::abs_path("libs/User.php",true);
  require_once BF::abs_path("libs/Event.php",true);

  $user = new User();
  $asso = new Asso($_GET["id_asso"]);

  $array = $asso->get_infos_events();
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
    $event = new Event($array[$key]["id"]);
    $rep = $event->get_prop_evenement('desc');
    if(sizeof($rep)==1){
      $array[$key]["desc"] = substr($rep[0][0],0,100);
    }else{
      $array[$key]["desc"] = "Pas de description pour cet évènement";
    }
  }
}

echo  json_encode($array,JSON_UNESCAPED_UNICODE);
?>