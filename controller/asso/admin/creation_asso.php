<?php
$a_jour = true;
$file_name = "asso/admin/".basename(__FILE__);
require_once "links.php";
ob_start();
BF::sess_start();
if(BF::is_connected()){ //Si l'utilisateur est connecté

    //Importation du modèle
    require_once BF::abs_path("model/".$file_name,true);

    require_once BF::abs_path("view/".$file_name,true);
    BF::afficher_template(ob_get_clean());

}else{//Sinon on le redirige
    BF::go_home();
}
?>