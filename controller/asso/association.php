<?php
$a_jour = true;
$file_name = "/asso/".basename(__FILE__);
require_once __DIR__.'/../../links.php';

if(!isset($_GET["id"])){
    BF::go_home();
}

require_once BF::abs_path("libs/Asso.php",true);
$id_asso = $_GET["id"];
$asso = new Asso($id_asso);
$table = $asso->get_all();
?>