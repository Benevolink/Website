<?php
$a_jour = true;
$file_name = basename(__FILE__);
require_once __DIR__.'/../links.php';
if(BF::is_posted("Recherche"))
    $r = $_GET["Recherche"];
else
    $r = "";

require_once BF::abs_path("libs/Asso.php",true);
$table = Asso::recherche_asso($r);
ob_start();
require_once BF::abs_path("functions/categories.php",true);
require_once BF::abs_path("view/".$file_name,true);
BF::afficher_template();
?>