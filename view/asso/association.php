<?php 
if(isset($_GET["id"])){
  //On récupère le nom / logo de l'asso

  $table = BF::request("SELECT * FROM assos WHERE id = ?",[$_GET["id"]],true,true,PDO::FETCH_ASSOC);

  //On récupère les propriétés de l'association (description...)

  $prop = BF::request("SELECT * FROM prop_assos WHERE id_asso = ?",[$_GET['id']],true);

  //On veut connaitre le nombre de membres.

  $nombre = BF::request("SELECT COUNT(*) FROM membres_assos WHERE id_asso = ?",[$_GET["id"]],true)[0][0];

  // le -1 permet de gérer les erreurs
  if(!BF::is_connected()){
    $user_id = -1;
  }else{
    $user_id = $_SESSION["user_id"];
  }
  //On veut savoir si l'utilisateur a accès à la page admin de l'asso.
  $table_4 = BF::request("SELECT statut FROM membres_assos WHERE id_asso = ? AND id_user = ?",[$_GET["id"],$user_id],true);
  $statut = $table_4[0][0];
}
  ?>

  <link rel="stylesheet" href="<?= BF::abs_path("CSS/association.css")?>">
<body>
  <img id="logo" src="<?= BF::abs_path($table["logo"]) ?>" class="img_asso">
  <label class="titre_asso" for="logo"><?= BF::XSS($table["nom"]) ?></label>
  <br>
  <?= $nombre ?> followers.
  <br>
  
  <?php if(BF::equals("NULL",$statut)){ ?>
    <label for="followed">Rejointe</label>
    <input id="followed" type="checkbox" disabled="disabled">
  <?php } else { ?>
    <label for="followed">Rejointe</label>
    <input id="followed" type="checkbox" disabled="disabled" checked>
  <?php }?>

  <?php //si le user est admin de l'asso, il peut administrer son asso
  if($statut > 1){ ?>
    <a href="<?= 'admin/association_admin.php?id_asso='.$_GET["id"] ?>">
      Accéder à la page d'administration
    </a>
  <?php } ?>

  <div class="cote_a_cote">

  <div class="rej_bouton" id="Rejoindre" style="background-color: rgb(124, 243, 152);" onclick="join();">
    Rejoindre
  </div>
  </div>


  
<div id="wrapper_all"></div>
  