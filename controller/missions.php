<?php
$a_jour = true;
$file_name = basename(__FILE__);
ob_start();
require_once __DIR__."/../links.php";
require_once BF::abs_path("libs/Domaine.php",true);
$categories = Domaine::get_all();

require_once BF::abs_path("model/".$file_name,true);
require_once BF::abs_path("view/".$file_name,true);
BF::afficher_template();
?>