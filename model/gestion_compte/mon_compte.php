<?php
require_once BF::abs_path("libs/User.php",true);
function afficher_infos_1(){
  global $table;
  ?>
  <br>
      Nom: <?= $table["pseudo"] ?>
  <br>
      Tel : <?=$table["tel"]?>
  <br>
      email : <?= $table["email"]?>
  <?php
}

function afficher_infos_2(){
  global $table;
  global $user;
  ?>
  <img id="image_logo" src="<?= $user->logo() ?>" style="width: 200px; border-radius: 200px; border: 10px black solid; cursor: pointer;">
  <br>
  Nom: <?= $table["pseudo"] ?>
  <br>
  Tel: <?= $table["tel"] ?>
  <br>
  Email: <?= $table["email"] ?>
  <br>
  Date de naissance: 01/01/2001
  <br>
  Département de résidence: 59
  <br>
  Ville: Lille
  <br>
  Profession: étudiant
  <?php
}

?>