  <link rel="stylesheet" href="<?= BF::abs_path("CSS/association.css")?>">

  <img id="logo" src="<?= BF::abs_path($logo_path) ?>" class="img_asso">

  <label class="titre_asso" for="logo"><?= $prop_all["asso_info"][AttributsTables::ASSO_NOM] ?></label>
  <br>
  
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

  
  
  
<div class="row">
  <div class="col-md-7" id="description_asso">
  <p><?= $prop_all["asso_info"][AttributsTables::ASSO_DESCRIPTION] ?></p>
  </div>
</div>

<div class="row">
  <div class="col-md-3" id="contact_adresse"> 
    <h3 id="titre_asso"> Contact et adresse </h3>

  <p> <span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span> 
  Adresse: <?= $prop_all["lieu"][AttributsTables::LIEU_ADRESSE] ?> 
  <br> 
  <span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>
  Département: <?= $prop_all["lieu"][AttributsTables::LIEU_DEPARTEMENT] ?></p>
  <p> <span class="glyphicon glyphicon-earphone" aria-hidden="true"></span> <?= $prop_all["asso_info"][AttributsTables::ASSO_TELEPHONE] ?></p>
    <p>  <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>  <?= $prop_all["asso_info"][AttributsTables::ASSO_EMAIL] ?></p>

  </div>

  <div class="col-md-4 col-md-offset-4" id="description_asso">
  <h3 id="titre_asso">Description des Missions</h3>
  <p><?= $prop_all["asso_info"][AttributsTables::ASSO_DESCRIPTION_MISSIONS] ?></p>

  </div>
</div>

  <br> <br> <br> <br> <br> <br> <br> 

<div id="wrapper_all"></div>


  
<style>

  #description_asso{
    font-family: Corps;
    src: url(fonts/Nexa-Heavy.woff2) format("woff2");
    margin-left: 40px;
    border: 1px solid #000;
    border-radius: 10px;
    box-sizing: border-box; 
    padding: 8px; /* Espace à l'intérieur des cellules */
    padding-left: 55px;
    font-size: 17px;
  }

  #contact_adresse{
    font-family: Corps;
    src: url(fonts/Nexa-Heavy.woff2) format("woff2");
    margin-left: 70px;
    margin-top: 20px;
    border: 1px solid #000;
    border-radius: 10px;
    box-sizing: border-box; 
    padding: 8px; /* Espace à l'intérieur des cellules */
    padding-left: 55px;
    font-size: 17px;
  }
  #logoImg{
    width: 88%;
    height: auto;
    display:block;
    margin: auto; /* Ajoutez cette ligne pour centrer horizontalement */

  }
  #titre_asso{
    font-weight: bold;
    font-family: Corps;
    src: url(fonts/Nexa.woff2) format("woff2");
    font-size: 30px;
    text-align: center;
  }

  #follower{
    font-family: Corps;
  src: url(fonts/Nexa.woff2) format("woff2");
  text-align: center;
  }
 
  #wrapper_all{
    font-weight: bold;
    font-family: Corps;
    src: url(fonts/Nexa.woff2) format("woff2");
    font-size: 30px;
    text-align: center;
  }


</style>