  <link rel="stylesheet" href="<?= BF::abs_path("CSS/association.css")?>">
<body>
  <img id="logo" src="<?= BF::abs_path($prop_all["asso_info"][AttributsTables::ASSO_LOGO]) ?>" class="img_asso">
  <label class="titre_asso" for="logo"><?= $prop_all["asso_info"][AttributsTables::ASSO_NOM] ?></label>
  <br>
  <p><?= $prop_all["asso_info"][AttributsTables::ASSO_DESCRIPTION] ?></p>
  <br>
  <div style="background-color: rgba(200, 200, 200, 0.5);">
    <p><?= $prop_all["lieu"][AttributsTables::LIEU_ADRESSE] ?>, Département <?= $prop_all["lieu"][AttributsTables::LIEU_DEPARTEMENT] ?></p>
    <h4>Contact</h4>
    <p><?= $prop_all["asso_info"][AttributsTables::ASSO_TELEPHONE] ?></p>
    <p><?= $prop_all["asso_info"][AttributsTables::ASSO_EMAIL] ?></p>
  </div>
  <div style="background-color : rgba(100, 255, 100, 0.5);">
    <h3>Description des Missions</h3>
    <p><?= $prop_all["asso_info"][AttributsTables::ASSO_DESCRIPTION_MISSIONS] ?></p>
  </div>
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
  