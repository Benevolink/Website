<?php
$a_jour = true;
$file_name = "asso/".basename(__FILE__);
require_once __DIR__.'/../../links.php';
require BF::abs_path("libs/User.php",true);
$user = new User();
$liste_assos_util = $user->liste_assos();


require_once BF::abs_path("model/".$file_name,true);
BF::afficher_template();
// j'ai mis ce BF Ici pour afficher correctement le template, mais le bas de page s'affiche en haut c'est biz
require_once BF::abs_path("view/".$file_name,true);


?>
