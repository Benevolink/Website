<?php
$file_name = basename(__FILE__);
if(isset($_GET["iframe"]) ? 1 : 0){
    $iframe = true;
}
require_once __DIR__.'/../links.php';
require_once BF::abs_path("libs/Event.php",true);
$event = new Event($_GET["id_event"]);

?>