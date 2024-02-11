  <link rel="stylesheet" href="<?= BF::abs_path("CSS/association.css")?>">
<div style="margin-left: 40px;">
  <img id="logo" src="<?= $logo_path ?>" class="img_asso">

  <label class="titre_asso" for="logo"><?= $prop_all["asso_info"][AttributsTables::ASSO_NOM] ?></label>
  <br>
  

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>


  <br>
  <h4 id="follower"> Il y a <?= $nombre ?> membre(s) dans l'association. </h4>
  <br>
  
 

  <div class="cote_a_cote">

    <div class="rej_bouton" id="Rejoindre" style="background-color: rgb(124, 243, 152);" onclick="join();">
      Rejoindre
    </div>
  </div>

  </div>

  
  
  
<div class="row">
  <div class="col-md-3" id="image_asso">
    <img src="<?= BF::abs_path($prop_all["asso_info"][AttributsTables::ASSO_LOGO]) ?>"  id="logoImg" class="img-responsive img-thumbnail rounded">

  </div>
  
<div class="row infos_asso">
  <div class="col-md-7 description_asso contact_adresse desc_asso_remplir_flex">
  <h4>Description de l'association :</h4>
  <p><?= $prop_all["asso_info"][AttributsTables::ASSO_DESCRIPTION] ?></p>
  </div>
</div>

<div class="row infos_asso">
  <div class="col-md-3 contact_adresse"> 
    <h4> Contact et adresse </h4>

  <p> <span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span> 
  Adresse: <?= $prop_all["lieu"][AttributsTables::LIEU_ADRESSE] ?> 
  <br> 
  <span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>
  Département: <?= $prop_all["lieu"][AttributsTables::LIEU_DEPARTEMENT] ?></p>
  <p> <span class="glyphicon glyphicon-earphone" aria-hidden="true"></span> <?= $prop_all["asso_info"][AttributsTables::ASSO_TELEPHONE] ?></p>
    <p>  <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>  <?= $prop_all["asso_info"][AttributsTables::ASSO_EMAIL] ?></p>

  </div>
  <br> 
  <div class="col-md-4 col-md-offset-4" id="description_asso">
  <h3 id="titre_asso">Description des Missions</h3>

  
  <p><?= $prop_all["asso_info"][AttributsTables::ASSO_DESCRIPTION] ?></p>

  <div class="col-md-4 col-md-offset-4 contact_adresse desc_asso_remplir_flex" id= "desc_missions">
  <h4>Description des Missions</h4>
  <p><?= $prop_all["asso_info"][AttributsTables::ASSO_DESCRIPTION_MISSIONS] ?></p>
  </div>
  </div>
  <br>
  <h4 id="follower"> Il y a <?= $nombre ?> membre(s) dans l'association. </h4>
  <br>
  <br> <br> <br>

  <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> 

  <div class="row">
  <div class="col-md-3" id="description_asso">
    <?php if($est_dans_asso){ ?>
      <label for="followed">Rejoindre</label>
      <input id="followed" type="checkbox" disabled="disabled" checked>
    <?php } else { ?>
      <label for="followed">Rejoindre</label>
      <input id="followed" type="checkbox">
    <?php }?>

    <br> 

    <?php
    
// Si le user est admin de l'asso, il peut administrer son asso
if ($is_admin) { ?>
    <a href="<?= 'admin/association_admin.php?id_asso='.$id_asso ?>" class="btn btn-success">
        Accéder à la page d'administration
    </a>
<?php } ?>

<br> <br> 

<div class="btn btn-success" id="Rejoindre"  onclick="join();">
    Rejoindre
</div>

    </div>
    </div>

    <br> 
<div id="wrapper_all"></div>


  
<style>

  .row{
    margin: auto;
    width : 90%;
   
  }
  .infos_asso{
    display: flex;
  }
  h4{
    font-size: 110%;
    font-weight: bold;
  }
  .desc_asso_remplir{
    width: 100%;
  }
  .desc_asso_remplir_flex{
    flex-grow: 1;
  }
  #description_asso{
    font-family: Corps;
    src: url(fonts/Nexa-Heavy.woff2) format("woff2");
    margin-left: 85px;
    border: 1px solid #000;
    border-radius: 10px;
    box-sizing: border-box; 
    padding: 8px; /* Espace à l'intérieur des cellules */
    padding-left: 35px;
    font-size: 17px;
  }

  #image_asso{
    font-family: Corps;
    src: url(fonts/Nexa-Heavy.woff2) format("woff2");
    margin-left: 70px;
    border: 1px solid #000;
    border-radius: 10px;
    box-sizing: border-box; 
    padding: 8px; /* Espace à l'intérieur des cellules */
    padding-left: 30px;
    font-size: 17px;
    margin-top: 20px;
    width : 100%;
  }

  .contact_adresse{
    font-family: Corps;
    src: url(fonts/Nexa-Heavy.woff2) format("woff2");
    margin-left: 40px;
    margin-top: 20px;
    border: 1px solid #000;
    border-radius: 10px;
    box-sizing: border-box; 
    padding: 8px; /* Espace à l'intérieur des cellules */
    padding-left: 30px;
    font-size: 17px;
  }
  #logoImg{
    width: 88%;
    height: auto;
    display:block;
    margin: auto; /* Ajoutez cette ligne pour centrer horizontalement */

  }
  .titre_asso{
    margin-left: 40px;
    font-weight: bold;
    font-size: 160%;
    font-family: Corps;
    src: url(fonts/Nexa.woff2) format("woff2");
    text-align: center;
  }

  #follower{
    font-family: Corps;
  src: url(fonts/Nexa.woff2) format("woff2");
  text-align: center;
  }
 
  #wrapper_all{
    font-family: Corps;
    src: url(fonts/Nexa.woff2) format("woff2");
    text-align: center;
  }
  #desc_missions{
    margin-left: 20px;
  }

</style>