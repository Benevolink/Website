  <link rel="stylesheet" href="<?= BF::abs_path("CSS/association.css")?>">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
<body>

  <img src="<?= BF::abs_path($prop_all["asso_info"][AttributsTables::ASSO_LOGO]) ?>"  id="logoImg" class="img-responsive img-thumbnail rounded">
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
  <h4 id="follower"> Il y a <?= $nombre ?> membre(s) dans l'association. </h4>
  <br>
  
  <?php if($est_dans_asso){ ?>
    <label for="followed">Rejoindre</label>
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
  
<style>
  #logoImg{
    width: 18%;
    height: auto;
    display:block;
    margin: auto; /* Ajoutez cette ligne pour centrer horizontalement */

  }
  #titre_asso{
    font-weight: bold;
    font-family: Corps;
    src: url(fonts/Nexa.woff2) format("woff2");
    font-size: 40px;
    text-align: center;
  }

  #follower{
    font-family: Corps;
  src: url(fonts/Nexa.woff2) format("woff2");
  text-align: center;
  }
 

</style>