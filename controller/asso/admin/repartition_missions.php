<?php
$a_jour = true;
$file_name = "asso/admin/".basename(__FILE__);
require_once "links.php";

if(!isset($_GET["id_asso"]))
    BF::go_home();
$id_asso = $_GET["id_asso"];
require_once BF::abs_path("model/".$file_name,true);
ob_start();
require_once BF::abs_path("view/".$file_name,true);
BF::afficher_template();


?>