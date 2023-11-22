<?php

$a_jour = true;
$file_name = basename(__FILE__);
require_once __DIR__.'/../links.php';


ob_start();

require_once BF::abs_path("libs/User.php",true);
require_once BF::abs_path("libs/Asso.php",true);
require_once BF::abs_path("libs/Domaine.php",true);

$categories = Domaine::get_all();

require $path."functions/classes/calendar/index.php";



require BF::abs_path("view/".$file_name,true);
BF::afficher_template();
?>