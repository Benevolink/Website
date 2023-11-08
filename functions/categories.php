<?php
require_once __DIR__."/basic_functions.php";
require_once BF::abs_path("libs/Domaine.php",true);
$categories = $req = Domaine::get_all();
?>
