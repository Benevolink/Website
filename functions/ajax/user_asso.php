<?php
require_once "../../links.php";

header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8" ?>';


if(BF::is_connected()){
  $req = "SELECT a.*, m.statut FROM assos a JOIN membres_assos m ON (a.id = m.id_asso AND m.id_user = :id) ORDER BY m.statut ASC";
  $req = $db->prepare($req);
  $req->bindParam(":id",$_SESSION["user_id"]);
  $req->execute();
  $table = $req->fetchAll();
  ?>
  <data>
  <?php
  foreach($table as $key => $value){
    ?>
    <response>
      <?php 
      $i = 0;
      for($i = 0; $i<sizeof($value);$i++){
        if($i==0){
          echo $value[$i].";"; //l'id
        }elseif($i==1){
          echo $value[$i].";";//le nom
        }elseif($i==2){
          echo $value[$i].";";; //le logo
        }else{
          echo $value[$i]; //le statut
        }
      }
      ?>
    </response>
    <?php
  }
  ?>
  </data>
  <?php
}
?>