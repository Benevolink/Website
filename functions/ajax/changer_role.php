<?php
require_once "../../links.php";
header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8" ?>';
require_once BF::abs_path("libs/User.php",true);
require_once BF::abs_path("libs/Asso.php",true);
//L'utilisateur actif
$user = new User();
if(BF::is_connected()){ //On vérifie que toutes les variables existent et que l'utilisateur est bien connecté
  if(BF::is_posted(["id_user","id_asso","role"])&& !BF::equals($user->id,$_GET["id_user"])){
    /*
            On vérifie d'abord si l'utilisateur est ADMIN
    */
    //L'asso cible
    $asso = new Asso($_GET["id_asso"]);
    //L'utilisateur dont on veut changer le rôle
    $user_cible = new User($_GET["id_user"]);
    if($user->est_admin_asso($asso->id)){
      //Si l'utilisateur est ADMIN on vérifie les cas, cela évite qu'en changeant les paramètres de la requête un utilisateur mal intentionné donne un rôle qui n'existe pas à un membre
      if(is_int($_GET["role"])) /*BF::equals($_GET["role"],"ADMIN")*/{
        $user_cible->asso_changer_role($asso->id,$_GET["role"]);
      }else if(BF::equals($_GET["role"],"NONE")){
        $user_cible->quitter_asso($asso->id);
      }
    }
  }
}
?>
<data>
  <response>
    1
  </response>
</data>