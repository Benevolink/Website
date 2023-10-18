<?php
require_once "../../links.php";
header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8" ?>';

if(isset($_GET["id_cate"])){
  //L'objectif est de prendre les évenements publics pour lesquels l'utilisateur suit l'asso et les events privés pour les assos dans lesquelles l'utilisateur est membre.
  $req = "SELECT e.* FROM categorie_event c WHERE c.categorie = :id_cate JOIN (SELECT * FROM evenements e WHERE e.status = 1 OR (SELECT COUNT(*) FROM membres_assos m WHERE m.id_asso = e.id_assos AND m.id_user = :id_user)=1) ON c.id_event = e.id";
  $req = $db->prepare($req);
  $req->bindParam(":id_cate",$_GET["id_cate"]);
  //Si l'utilisateur est connecté
  if(isset($_SESSION["user_id"])&&$_SESSION["auth"]==1){
      $req->bindParam(":id_user",$_SESSION["user_id"]);
  }else{
    //Sinon pour éviyter une erreur, on lui affecte - qui n'existe pas
    $req->bindParam(":id_user","-1");
  }
  $req->execute();
  $table = $req->fetchAll(PDO::FETCH_ASSOC);
  ?>
<data>
  <?php
  //On affiche les résultats
  foreach($table as $key => $value){
    ?>
    <response>
      <?php echo $value["id"].";".$value["id_asso"].";".$value["nom_event"].";".$value["date_debut"].";".$value["date_fin"] ?>
    </response>
    <?php
  }
}
?></data>