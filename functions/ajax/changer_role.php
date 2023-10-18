<?php
require_once "../../links.php";
header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8" ?>';

if(BF::is_connected()){ //On vérifie que toutes les variables existent et que l'utilisateur est bien connecté
  if(BF::is_posted(["id_user","id_asso","role"])&& !BF::equals($_SESSION["user_id"],$_GET["id_user"])){
    //On vérifie d'abord si l'utilisateur est ADMIN

    $statut = BF::request("SELECT statut FROM membres_assos WHERE id_asso = ? AND id_user = ?",[$_GET["id_asso"],$_SESSION["user_id"]],true)[0][0];
    if(BF::is_admin($statut)/*BF::equals($statut,"ADMIN")*/){
      //Si l'utilisateur est ADMIN on vérifie les cas, cela évite qu'en changeant les paramètres de la requête un utilisateur mal intentionné donne un rôle qui n'existe pas à un membre
      if($_GET["role"]>0) /*BF::equals($_GET["role"],"ADMIN")*/){
        $req = "UPDATE membres_assos SET statut = ? WHERE id_asso = ? AND id_user = ?";
        BF::request($req,[$_GET["role"],$_GET["id_asso"],$_GET["id_user"]]);
        $req->execute();
      }else if(BF::equals($_GET["role"],"NONE")){
        $req = "DELETE FROM membres_assos WHERE id_user = ? AND id_asso = ?";
        BF::request($req,[$_GET["id_user"],$_GET["id_asso"]]);
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