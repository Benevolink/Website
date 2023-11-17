<style>

  *{
    font-family: Corps;
  src: url(fonts/Nexa-Heavy.woff2) format("woff2");
  }

  
</style>


<link rel="stylesheet" href="<?= BF::abs_path("CSS/mes_associations.css")?>">
  <div style="background-color: white; padding: 30px;">

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">

    
    <button onclick="location.href = 'admin/creation_asso.php';" type="button" class="btn btn-default btn-lg">
      <span class="glyphicon glyphicon-star" aria-hidden="true"></span> Je veux créer mon association
    </button>
    
  <div id="list_assos"> 
  
    <!--
    Essai 1 pour séparer les assos si elles sont en attentes ou intégrées
    <div class="titre_1"> Vos associations </div>
  <div classe="titre_1"> Vos associations en attente </div> -->
  </div>

 
  <div id="list_assos_integrees">
    Vos associations
    <?php
    require "C:\\Program Files (x86)\\EasyPHP-Devserver-17\\eds-www\\Website\\libs\\User.php";
    $user = new User();
    $liste_assos_util = $user->liste_assos();
    
    foreach ($liste_assos_util as $association) {
        echo '<p>' . $association['nom'] . '</p>';
    }
    ?>
</div>

  <div id="list_assos_en_attentes"> Vos associations en attente </div>

  </div>

 
  <div class="ajouter_asso" onclick="location.href = 'admin/creation_asso.php';" style="border: 0.5px solid #E5EB99;"> 
</div>

