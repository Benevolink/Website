<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?= BF::abs_path("CSS/mes_associations.css")?>">
  <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <style>
    * {
      font-family: Corps;
      src: url(fonts/Nexa-Heavy.woff2) format("woff2");
    }

    #titre_asso {
      font-weight: bold;
      text-align: center;
    }

    .search-bar {
      margin-bottom: 20px;
    }

    /* Ajout de la classe custom-border */
    .custom-border {
      border-right: 1px solid #ccc; /* Bordure droite pour séparer les colonnes */
      padding-right: 15px; /* Marge à droite pour l'espace entre la bordure et le contenu */
    }

    #sous_titre{
      text-align: center;
    }

    #bouton_creation_asso{
      text-align: center;
    }
  </style>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
</head>
<body style="background-color: white; padding: 30px;">


  <div class="container">


    <div class="row">
      <h2 id="titre_asso">Mes associations</h3>
<br>
      <div class="row">
  <div class="col-md-6 col-md-offset-1">
    <button onclick="location.href = 'admin/creation_asso.php';" type="button" class="btn btn-default btn-lg" id="bouton_creation_asso">
      <span class="glyphicon glyphicon-star" aria-hidden="true"></span> Je veux créer mon association
    </button>
  </div>
</div>

<br>
<br>


      <div class="row search-bar">
      <div class="col-md-6 col-md-offset-3">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Rechercher une association">
          <span class="input-group-btn">
            <button class="btn btn-default" type="button">
              <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
            </button>
          </span>
        </div>
      </div>
    </div>

      <div class="col-md-6 custom-border">
        <div id="list_assos_integrees">
          <h4 id="sous_titre">Vos associations intégrées</h4>
          <?= afficher_liste_assos() ?>
        </div>
      </div>

      <div class="col-md-6">
        <div id="list_assos_en_attentes">
          <h4 id="sous_titre" >Vos associations en attente</h4>
          <!-- Liste des associations en attente -->
        </div>
      </div>
    </div>

  </div>

  
</body>
</html>
