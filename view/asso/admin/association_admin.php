  <link rel="stylesheet" href="<?= BF::abs_path("CSS/association_admin.css") ?>"/>
  <a href="<?= 'creer_evenement.php?id_asso='.$_GET["id_asso"] ?>">
      Créer un évènement
  </a>
  <br>
  <a href="<?= BF::abs_path('controller/asso/sondage/creer_sondage.php?id_asso='.$_GET["id_asso"]) ?>">
      Créer un sondage
  </a>
  <div class="cote_a_cote">
    
    <div class="scroller">
      <h1>Liste des membres de l'association</h1>
      <ul>
        <?= affichage_liste_membres();?>
      </ul>
    </div>
    <div class="scroller">
    </div>
  </div>

  <?php  ?>