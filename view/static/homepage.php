
<link rel="stylesheet" href="<?= BF::abs_path("CSS/index.css") ?>"/>
  <div class="index_corps">
    <div class="index_titre">
      <div>
      Bienvenue sur Benevolink !
      </div>
    </div>
    <div class="index_desc">
    Benevolink est une plateforme de mise en relation de bénévoles et d'associations. <br>Avec Benevolink :

    <!-- Section: Trouvez la mission qui vous correspond -->
    <div class="index_wrapper">
            <img src="<?= BF::abs_path("media/img/mission.jpeg") ?>" class="mission_image" alt="Mission Image">
            <div class="mission_text">
                Trouvez la mission qui vous correspond
        </div>
    </div>

    <!-- Section: Gérez votre planning -->
    <div class="index_wrapper">
        
            <img src="<?= BF::abs_path("media/img/planning.jpg") ?>" class="mission_image" alt="Mission Image">
            <div class="mission_text">
              Gérez votre planning
            
        </div>
    </div>

    <!-- Section: Découvrez de nouvelles associations -->
    <div class="index_wrapper">
      
          <img src="<?= BF::abs_path("media/img/association.png") ?>" class="mission_image" alt="Mission Image">
            <div class="mission_text">
              Découvrez de nouvelles associations
            
        </div>
    </div>

    <!-- Section: Rencontrez d'autres bénévoles -->
    <div class="index_wrapper">
        
        <img src="<?= BF::abs_path("media/img/benevole.jpeg") ?>" class="mission_image" alt="Mission Image">
            <div class="mission_text">
               Rencontrez d'autres bénévoles
           
        </div>
    </div>

    <!-- Section: Cherchez les missions par zone géographique -->
    <div class="index_wrapper">
        
        <img src="<?= BF::abs_path("media/img/carte.webp") ?>" class="mission_image" alt="Mission Image">
            <div class="mission_text">
                Cherchez les missions par zone géographique
            
        </div>
    </div>

    <!-- Section: Ne manquez aucun évènement de vos associations préférées -->
    <div class="index_wrapper">
        
        <img src="<?= BF::abs_path("media/img/coeur.jpg") ?>" class="mission_image" alt="Mission Image">
            <div class="mission_text">
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
    <?= nb_utilisateurs() ?> utilisateurs nous ont déjà rejoint
  </div>
</div>



<style>
    

    .mission_image {
        max-width: 60%; /* Assurez-vous que l'image ne dépasse pas la largeur du conteneur */
        height: auto; /* Maintenez le ratio hauteur/largeur pour éviter la distorsion */
        margin-bottom: 10px; /* Ajoutez une marge en bas pour l'espace entre l'image et le texte */
    }

    .mission_text {
        font-size: 18px; /* Ajustez la taille du texte selon vos préférences */
    } 
</style>


