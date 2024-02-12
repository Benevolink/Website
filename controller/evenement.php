<?php
$a_jour = true;
$file_name = basename(__FILE__);
if(isset($_GET["iframe"]) ? 1 : 0){
    $iframe = true;
}
require_once __DIR__.'/../links.php';
if(!isset($_GET["id_event"]) || !is_numeric($_GET["id_event"])){
    BF::go_home();
}

$id_event = $_GET["id_event"];
$iframe = (isset($_GET["iframe"]) ? 1 : 0);

require_once BF::abs_path("libs/Event.php",true);


$event = new Event($id_event);



require_once BF::abs_path("model/".$file_name,true);

$infos = $event->get_all();
$desc = $event->get_prop_value("desc");
$logo = $event->image_get();

ob_start();
require BF::abs_path("view/".$file_name,true);
BF::afficher_template();

?>