<?php
require_once __DIR__."/functions/basic_functions.php";
require_once BF::abs_path("db.php",true);
require_once __DIR__."/libs/Ressources/NomsAttributsTables.php";
require_once __DIR__."/libs/Ressources/LibsInterfaces.php";
require_once __DIR__."/libs/User.php";
$dispo=[[2,"12:30","15:30"],[4,"13:30","15:37"]];
$user_test= new User;
$user_test->id=1;
$user_test->disponibilite($dispo);

?>