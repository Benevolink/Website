<?php
//On importe la BDD
require_once __DIR__."/../db.php";
//Importation de la bibliothèque BF
require_once __DIR__.'/../functions/basic_functions.php';

BF::sess_start();
ob_start();
require_once __DIR__.'/../model/superadmin.php';
include_once __DIR__.'/../view/superadmin.php';
$content = ob_get_clean();

include_once __DIR__.'/../view/template.php';
?>

