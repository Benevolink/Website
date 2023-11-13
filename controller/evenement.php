<?php
$file_name = basename(__FILE__);
if(isset($_GET["iframe"]) ? 1 : 0){
    $iframe = true;
}
require_once __DIR__.'/../links.php';
if(!isset($_GET["id_event"]) || !is_int($_GET["id_event"])){
    BF::go_home();
}

require_once BF::abs_path("libs/Event.php",true);
$event = new Event($_GET["id_event"]);

?>