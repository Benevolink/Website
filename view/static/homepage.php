
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
    <?= nb_utilisateurs() ?>utilisateurs nous ont déjà rejoint
  </div>
</div>

