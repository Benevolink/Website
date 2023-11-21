```html
<!DOCTYPE html>
<html lang="fr">

<head>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css"
    integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap-theme.min.css"
    integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">

  <style>
    * {
      font-family: Corps;
      src: url(fonts/Nexa-Heavy.woff2) format("woff2");
    }

    #nav_navbar {
      margin-left: 30 px
    }

    .form-group {
      margin-bottom: 15px;
    }

    h2,
    label {
      color: #333;
    }

    .btn-primary {
      background-color: #337ab7;
      color: #fff;
      border: none;
    }

    .btn-primary:hover {
      background-color: #23527c;
    }

    .navbar {
      background-color: #337ab7;
      border: none;
    }

    .navbar-nav > li > a {
      color: #fff;
    }

    #thumbnail_1 {
      padding: 15px;
      box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
    }

    #thumbnail_3 {
      display: block;
    }

    #btn_validation {
      display: block;
    }
  </style>

  <script src="https://code.jquery.com/jquery-1.12.4.min.js"
    integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ"
    crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js"
    integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd"
    crossorigin="anonymous"></script>

  <script>
    $(document).ready(function () {
      $('body').scrollspy({
        target: '.navbar'
      });
    });
  </script>

</head>

<body data-spy="scroll" data-target=".navbar" data-offset="50">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css"
    integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap-theme.min.css"
    integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">

  <div class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Modal title</h4>
        </div>
        <div class="modal-body">
          <p>One fine body&hellip;</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>

  <nav class="navbar navbar-default">
    <ul class="nav navbar-nav" id="nav_navbar">
      <li><a href="#nom_association"> Nom de l'association</a></li>
      <li><a href="#description_association">Description de l'association</a></li>
      <li><a href="#domaines_souhaites">Domaines souhaités</a></li>
      <li><a href="#missions_proposees">Types de missions proposées</a></li>
      <li><a href="#localisation">Votre localisation</a></li>
    </ul>
  </nav>

  <div class="row">
    <div class="col-sm-12">
      <h1 class="text-center">Formulaire de demande de création d'une association</h1>
    </div>
  </div>

  <div class="row">
    <div class="col-sm-6">
      <div class="thumbnail text-center">
        <div class="caption" id="thumbnail_1">
          <h2>Entrez les informations principales de votre association :</h2>
          <form>
            <div class="form-group">
              <label for="nomAssociation" enctype="multipart/form-data" action="creation_asso_sql.php" method="post"> <span
                  class="glyphicon glyphicon-text-background" aria-hidden="true"></span> Nom de l'association :</label>
              <input data-toggle="tooltip" data-placement="right" title="Champs obligatoire" type="text" class="form-control"
                id="nomAssociation" name="nomAssociation" placeholder="Entrez le nom de votre association">
            </div>
            <div class="form-group">
              <label for="descriptionAssociation"> <span class="glyphicon glyphicon-bullhorn" aria-hidden="true"></span>
                Description de l'association :</label>
              <textarea data-toggle="tooltip" data-placement="right" title="Champs obligatoire" class="form-control"
                id="descriptionAssociation" name="descriptionAssociation"
                placeholder="Entrez la description de votre association"></textarea>
            </div>
            <div class="form-group">
              <label for="localisation">Votre localisation :</label>
              <div class="input-group">
                <input data-toggle="tooltip" data-placement="right" title="Champs obligatoire" type="text" class="form-control"
                  id="localisation" name="localisation" placeholder="Entrez votre localisation" required>
                <span class="input-group-addon">
                  <i

 class="glyphicon glyphicon-map-marker"></i>
                </span>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="thumbnail text-center">
        <div class="caption" id="thumbnail_3">
          <h2>Entrez les domaines d'action souhaités :</h2>
          <form action="/action_page.php">
            <div class="checkbox">
              <label><input type="checkbox" value="" name="sante">Santé</label>
            </div>
            <div class="checkbox">
              <label><input type="checkbox" value="" name="education">Éducation</label>
            </div>
            <div class="checkbox">
              <label><input type="checkbox" value="" name="environnement">Environnement</label>
            </div>
            <div class="checkbox">
              <label><input type="checkbox" value="" name="social">Social</label>
            </div>
            <div class="checkbox">
              <label><input type="checkbox" value="" name="culture">Culture</label>
            </div>
            <div class="checkbox">
              <label><input type="checkbox" value="" name="autre">Autre</label>
            </div>
          </form>
          <br>
          <h2>Quels types de missions proposez-vous ?</h2>
          <form>
            <div class="checkbox">
              <label><input type="checkbox" value="" name="ponctuelle">Ponctuelle</label>
            </div>
            <div class="checkbox">
              <label><input type="checkbox" value="" name="duree">Durée</label>
            </div>
            <div class="checkbox">
              <label><input type="checkbox" value="" name="longue_duree">Longue durée</label>
            </div>
          </form>
          <br>
          <div id="btn_validation">
            <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target=".modal">Valider</button>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>

</html>
```