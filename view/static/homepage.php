<head>
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
</head>
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>

<link rel="stylesheet" href="<?= BF::abs_path("CSS/index.css") ?>"/>
  <div class="index_corps">
    <div class="index_titre">
      <div>
      Bienvenue sur Benevolink !
      </div>
    </div>
    <div class="index_desc">
      Benevolink est une plateforme de mise en relation de bénévoles et d'associations. <br>Avec Benevolink :
    </div>
    <div class="index_wrapper">
      <div>
        Trouvez la mission qui vous correspond
      </div>
      <div>
        Gérez votre planning
      </div>
      <div>
        Découvrez de nouvelles associations
      </div>
      <div>
        Rencontrez d'autres bénévoles
      </div>
      <div>
        Cherchez les missions par zone géographique
      </div>
      <div>
        Ne manquez aucun évènement de vos associations préférées
      </div>
    </div>
    <?php
    //Si l'utilisateur est connecté on lui propose de trouver des assos
  //Sinon on lui propose de se connecter
  if(!BF::is_connected()){
    ?>
    <div class="index_rejoindre" onclick="authentification();">
      Nous rejoindre
    </div>
    <?php
  }else{
    ?>
    <div class="index_rejoindre" onclick="window.location.href='missions.php';">
      Accéder aux missions
    </div>
  <?php
  }
  ?>
  
  
  <div id="index_compteur">
    <span class="glyphicon glyphicon-heart-empty"> </span>
    <?= BF::request("SELECT COUNT(*) FROM users",[],true)[0][0]." ";?>utilisateurs nous ont déjà rejoint
  </div>
</div>

