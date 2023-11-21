<script type="text/javascript">
    id_asso = <?= $_GET["id_asso"] ?>;
</script>
  <script type="text/javascript" src="<?= BF::abs_path("JS/after/asso/admin/association_admin.js")?>"></script>
  
  <link rel="stylesheet" href="<?= BF::abs_path("CSS/association_admin.css") ?>"/>
    <a href="<?= 'creer_evenement.php?id_asso='.$_GET["id_asso"] ?>">
      Créer un évènement
  </a>
  <br>
  <a href="<?= BF::abs_path('controller/asso/sondage/creer_sondage.php?id_asso='.$_GET["id_asso"]) ?>">
      Créer un sondage
  </a>
  <div class="cote_a_cote">
    
    <div class="scroller" id ="liste_membres">
      <h1>Liste des membres de l'association</h1>
      <ul>
        <?= affichage_liste_membres();?>
      </ul>
    </div>
    <div class="scroller">
    </div>
  </div>

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
<body>
    <h1>Liste des Membres de l'Association</h1>
    <table>
        <tr>
            <th>Nom</th>
            <th>Statut</th>
        </tr>
        <tr>
            <td>Test 1</td>
            <td>Admin</td>
        </tr>
        <tr>
            <td>Test 2</td>
            <td>Membre</td>
        </tr>
        <tr>
            <td>Test 3</td>
            <td>Membre</td>
        </tr>
        <tr>
            <td>Test 4</td>
            <td>Admin</td>
        </tr>
        <tr>
            <td>Test 5</td>
            <td>En attente</td>
        </tr>
        <tr>
            <td>Test 6</td>
            <td>Membre</td>
        </tr>
        <tr>
            <td>Test 7</td>
            <td>En attente</td>
        </tr>
        <tr>
            <td>Test 8</td>
            <td>Membre</td>
        </tr>
        <tr>
            <td>Test 9</td>
            <td>Admin</td>
        </tr>
        <tr>
            <td>Test 10</td>
            <td>Admin</td>
        </tr>
    </table>
</body>
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
    <h1 class="text-center">Liste des Membres de l'Association</h1>
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-md-4">
                <div class="thumbnail">
                    <img src="..." alt="Image Membre">
                    <div class="caption">
                        <h3>Nom Membre 1</h3>
                        <p>Statut : Admin</p>
                        <!-- Ajoutez d'autres détails du membre ici -->
                        <p>
                            <a href="#" class="btn btn-primary" role="button">Voir profil</a>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">
                                <span class="glyphicon glyphicon-trash"></span> Supprimer
                            </button>
                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#reportModal">
                                Signaler
                            </button>
                        </p>
                    </div>
                </div>
            </div>
            <!-- Répétez ce bloc pour chaque membre -->
        </div>
    </div>

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