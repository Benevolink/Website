<?php
$a_jour = true;
$file_name = "asso/admin/".basename(__FILE__);
require_once "links.php";
BF::sess_start();
if(BF::is_connected()){ //Si l'utilisateur est connecté

    //Importation du modèle
    require_once BF::abs_path("model/".$file_name,true);

    require_once BF::abs_path("view/".$file_name,true);
}else{//Sinon on le redirige
    header("Location: ".BF::abs_path("",true));
    //On n'oublie pas d'exit !
    exit();
}
?>