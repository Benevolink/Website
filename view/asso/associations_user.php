

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?= BF::abs_path("CSS/mes_associations.css")?>">
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
            </input>
          </div>
        </div>

        <div class="col-md-6 custom-border">
          <div id="list_assos_integrees">
            <h4 id="sous_titre asso_integrees">Vos associations intégrées</h4>
            <div id = "test"></div>
          </div>
        </div>

        <div class="col-md-6">
          <div id="list_assos_en_attentes">
            <h4 id="sous_titre asso_en_attente" >Vos associations en attente</h4>
            <!-- Liste des associations en attente -->
          </div>
        </div>
      </div>

  </div>
</div>

<script src ="<?= BF::abs_path("JS/after/asso/associations_user.js")?>">
</script>
