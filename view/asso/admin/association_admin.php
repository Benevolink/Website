<script type="text/javascript">
    id_asso = <?= $_GET["id_asso"] ?>;
    id_user = <?php $user = new User(); echo $user->id; ?>;
</script>
<script type="text/javascript" src="<?= BF::abs_path("JS/after/asso/admin/association_admin.js") ?>">
</script>
  <script type="text/javascript" src="<?= BF::abs_path("JS/after/asso/admin/association_admin.js")?>"></script>
  
  <link rel="stylesheet" href="<?= BF::abs_path("CSS/association_admin.css") ?>"/>

  <link rel ="stylesheet" href="<?= BF::abs_path("CSS/main.css")?>">
  <link rel="icon" type="image/x-icon" sizes="16x16" href="<?= BF::abs_path("media/img/Logo_3.png") ?>"/>

  <a href="<?= 'creer_evenement.php?id_asso='.$_GET["id_asso"] ?>">

      Créer un évènement
  </a>
  <br>
  <a href="<?= BF::abs_path('controller/asso/sondage/creer_sondage.php?id_asso='.$_GET["id_asso"]) ?>">
      Créer un sondage
  </a>
  <br>
  <a href="<?= BF::abs_path('controller/asso/admin/repartition_missions.php?id_asso='.$_GET["id_asso"]) ?>">
      Affecter les bénévoles aux missions
  </a>

  
  <div class="row">
    <div id="colonne1" class="col-md-6">
      <div id="liste_membres">
        <h1 id="titre_membre"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Liste des membres de l'association</h1>
        <ul>
          <?= affichage_liste_membres();?>
        </ul>
      </div>
    </div>

    <div id="division"> </div>
    
    <div class="col-md-6">
      <div>
      <h1 id="titre_membre"><span class="glyphicon glyphicon-hourglass" aria-hidden="true"></span> Liste des membres <br> en attente</h1>     

    </div>
  </div>
</div>


  <style>
  .liste {
    border-bottom: 1px solid #ccc; /* Ajoute une bordure inférieure de couleur grise */
    padding-bottom: 5px; /* Ajoute un espacement en bas de chaque élément de la liste */
    margin-bottom: 10px; /* Ajoute une marge en bas de chaque élément de la liste */
    display: flex; /* Utilise Flexbox pour aligner le texte et le statut horizontalement */
    justify-content: space-between; /* Espace équitablement les éléments à l'intérieur de la liste */
    background-color: #ffffff;
    font-family: Corps;
    src: url(fonts/Nexa.woff2) format("woff2");
    font-size: 17px;
  }

  .role {
    color: #555; /* Couleur du texte pour le statut du membre */
    background-color: #ffffff;
    font-family: Corps;
    src: url(fonts/Nexa.woff2) format("woff2");
    font-size: 17px;
  }

  #titre_membre{
    font-family: Corps;
    src: url(fonts/Nexa.woff2) format("woff2");
    font-weight: bold;
    text-align: center;
  }

  #colonne1{
    
    border-right: 1px solid #ccc; /* Ajoute une bordure droite de couleur grise entre les colonnes */
    padding-right: 15px; /* Ajoute une marge à droite pour séparer le contenu de la bordure */
  }
</style>


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Membres de l'Association</title>
    <style>
        table {
            border-collapse: collapse;
            width: 50%;
            margin: 20px auto;
        }

        table, th, td {
            border: 1px solid #000;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Membres de l'Association</title>
  <script>
    $(document).ready(function() {
      $('body').scrollspy({ target: '.navbar' });
    });
  </script>


  <body data-spy="scroll" data-target=".navbar" data-offset="50">


  <script>
    $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })
    $('#myModal').on('shown.bs.modal', function () {
    $('#myInput').focus()
  })
  //   var bootstrapButton = $.fn.button.noConflict() // return $.fn.button to previously assigned value
  // $.fn.bootstrapBtn = bootstrapButton            // give $().bootstrapBtn the Bootstrap functionality



      </script>


    <!-- Modale pour la suppression -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Supprimer Membre</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Êtes-vous sûr de vouloir supprimer ce membre ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-danger">Supprimer</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modale pour le signalement -->
    <div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="reportModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reportModalLabel">Signaler Membre</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Voulez-vous signaler ce membre ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-warning">Signaler</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Aj