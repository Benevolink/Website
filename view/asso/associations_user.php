<link rel="stylesheet" href="<?= BF::abs_path("CSS/mes_associations.css")?>">
  <div style="background-color: white; padding: 30px;">
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

