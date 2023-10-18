<?php
require_once "../../links.php";
header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8" ?>';
?>
<data>
<?php
if(BF::is_posted(["mode","id_asso"])&&isset($_SESSION["user_id"])){
  $mode = $_GET["mode"];
  $id_asso = $_GET["id_asso"];
  $req = "SELECT statut FROM membres_assos WHERE id_asso = :id_asso AND id_user = :id_user";
  $req = $db->prepare($req);
  $req->bindParam(":id_asso",$id_asso);
  $req->bindParam(":id_user",$_SESSION["user_id"]);
  $table = $req->fetchAll();
  
  if($mode == 0){//Cas où on follow / defollow
    //D'abord on vérifie si l'utilisateur a rejoint l'asso.
    if(sizeof($table)==0){ //L'utilisateur ne follow pas donc on follow
      $req = "INSERT INTO membres_assos (id_asso,id_user,statut) VALUES (? , ?, ?)";
      $req = $db->prepare($req);
      $req->execute(array($id_asso,$_SESSION["user_id"],"FOLLOW"));
    }else if(strcmp($table[0][0],"FOLLOW")==0){ //On vérifie si l'utilisateur a juste follow pour le défollow
      $req = "DELETE FROM membres_assos WHERE id_user = ? AND id_asso = ?";
      $req= $db->prepare($req);
      $req->execute(array($_SESSION["user_id"],$id_asso));
    }
    ?>
      <response>
        1
      </response>
    <?php
  }if($mode == 1){
    //Cas où l'utilisateur veut rejoindre l'asso
    //Si il follow on le défollow
    if(sizeof($table)==0 || strcmp($table[0][0],"FOLLOW")==0){
      $req = "DELETE FROM membres_assos WHERE id_user = ? AND id_asso = ?";
      $req= $db->prepare($req);
      $req->execute(array($_SESSION["user_id"],$id_asso));
       $req = "INSERT INTO membres_assos (id_asso,id_user,statut) VALUES (? , ?, ?)";
      $req = $db->prepare($req);
      $req->execute(array($id_asso,$_SESSION["user_id"],"ATTENTE"));
    }else{
      $req = "DELETE membres_assos WHERE id_user = ? AND id_asso = ?";
      $req= $db->prepare($req);
      $req->execute(array($_SESSION["user_id"],$id_asso));
    }
    ?>
      <response>
        1
      </response>
    <?php
  }
}
?>
</data>