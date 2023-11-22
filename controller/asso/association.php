<?php
$a_jour = true;
$file_name = "/asso/".basename(__FILE__);
require_once __DIR__.'/../../links.php';

if(!isset($_GET["id"])){
    BF::go_home();
}

require_once BF::abs_path("libs/Asso.php",true);
require_once BF::abs_path("libs/User.php",true);

$id_asso = $_GET["id"];
$asso = new Asso($id_asso);

$prop_all = $asso->prop_association();
$nombre = $prop_all["membres_count"][0];

$user = new User();
$is_admin = $user->est_admin_asso($id_asso);
$est_dans_asso = $user->suit_asso($id_asso);
ob_start();
require_once BF::abs_path("view/".$file_name,true);
require_once BF::abs_path("JS/after".$file_name,true);
BF::afficher_template();
?>