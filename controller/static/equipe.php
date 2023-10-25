<?php
$a_jour = true;
ob_start();
$file_name = "static/".basename(__FILE__);
require_once __DIR__.'/../../links.php';
require_once BF::abs_path("view/".$file_name,true);
BF::afficher_template(ob_get_clean())
?>