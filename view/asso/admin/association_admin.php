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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

  <a href="<?= 'creer_evenement.php?id_asso='.$_GET["id_asso"] ?>">

      Créer un évènement
  </a>
  <br>
  <a href="<?= BF::abs_path('controller/asso/sondage/creer_sondage.php?id_asso='.$_GET["id_asso"]) ?>">
      Créer un sondage
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


<?php //VERSION DU POLE CSS ?>
  <!DOCTYPE html>
<html lang="en">
<head>
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
</head>

</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Membres de l'Association</title>
  <script>
    $(document).ready(function() {
      $('body').scrollspy({ target: '.navbar' });
    });
  </script>


  <body data-spy="scroll" data-target=".navbar" data-offset="50">


   <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
      <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
      <!-- Include all compiled plugins (below), or include individual files as needed -->
      <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous">
      </script> -->


  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

  <!-- Optional theme -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">


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


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-VE4wUyZRJqB8M6wOhEMDp2Fzpkw2qUxy6Wt8zQV32l+qHRZeZJ/x5QJ5tgXC9KzS" crossorigin="anonymous">
</head>
<body>

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

    <input type="submit" value="Aidedecision" id="aide_decision"/>

    <script>
      $("#aide_decision").on("click",function(){
        import(abs_path("JS/classes/Asso.js")).then((module)=>{
          let asso = new module.Asso(id_asso);
          asso.aide_decision().done((data)=>{
            console.log(data);
          });
        });
      });
    </script>
    <!-- Aj

    