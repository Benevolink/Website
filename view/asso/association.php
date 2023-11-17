  <link rel="stylesheet" href="<?= BF::abs_path("CSS/association.css")?>">
<body>
  <img id="logo" src="<?= BF::abs_path($prop_all["asso_info"][AttributsTables::ASSO_LOGO]) ?>" class="img_asso">
  <label class="titre_asso" for="logo"><?= BF::XSS($prop_all["asso_info"][AttributsTables::ASSO_NOM]) ?></label>
  <br>
  <?= $nombre ?> followers.
  <br>
  
  <?php if($est_dans_asso){ ?>
    <label for="followed">Rejointe</label>
    <input id="followed" type="checkbox" disabled="disabled" checked>
  <?php } else { ?>
    <label for="followed">Rejoindre</label>
    <input id="followed" type="checkbox">
  <?php }?>

  <?php //si le user est admin de l'asso, il peut administrer son asso
  if($is_admin){ ?>
    <a href="<?= 'admin/association_admin.php?id_asso='.$id_asso ?>">
      Accéder à la page d'administration
    </a>
  <?php } ?>

  <div class="cote_a_cote">

  <div class="rej_bouton" id="Rejoindre" style="background-color: rgb(124, 243, 152);" onclick="join();">
    Rejoindre
  </div>
  </div>


  
<div id="wrapper_all"></div>
  