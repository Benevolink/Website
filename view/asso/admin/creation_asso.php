<style>

  /* body {
  position: relative;
} */

  *{
    font-family: Corps;
  src: url(fonts/Nexa-Heavy.woff2) format("woff2");
  }

  #nav_navbar{
    margin-left: 30 px
  }
  
  /* Styling des formulaires */
  .form-group {
      margin-bottom: 15px;
  }

  /* Couleur du texte */
  h2, label {
      color: #333; /* Couleur de texte principale */
  }

  /* Style de bouton */
  .btn-primary {
      background-color: #337ab7; /* Couleur de bouton */
      color: #fff; /* Couleur de texte du bouton */
      border: none; /* Suppression de la bordure */
  }

  .btn-primary:hover {
      background-color: #23527c; /* Couleur de fond au survol */
  }

  /* Style de la navbar */
  .navbar {
      background-color: #337ab7; /* Couleur d'arrière-plan de la navbar */
      border: none;
  }

  /* Couleur du texte de la navbar */
  .navbar-nav > li > a {
      color: #fff; /* Couleur de texte de la navbar */
  }

  /* Bordures pour les sections */
  #thumbnail_1 {
      /* border: 1px solid #ddd; /* Bordure légère */
      padding: 15px; /* Espacement intérieur */ 
      box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
      /* background-color: #DAFFDC; */
      
  }

  #thumbnail_3{
    display: block;
  }

  #btn_validation{
    display: block;
  }



</style>

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
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

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
                  <label for="nomAssociation" enctype="multipart/form-data" action="creation_asso_sql.php" method="post"  > <span class="glyphicon glyphicon-text-background" aria-hidden="true"></span> Nom de l'association :</label>
                  <input data-toggle="tooltip" data-placement="right" title="Champs obligatoire" type="text" class="form-control" id="nomAssociation" name="nomAssociation" placeholder="Entrez le nom de votre association">
              </div>
              <div class="form-group">
                  <label for="descriptionAssociation"> <span class="glyphicon glyphicon-bullhorn" aria-hidden="true"></span> Description de l'association :</label>
                  <textarea data-toggle="tooltip" data-placement="right" title="Champs obligatoire" class="form-control" id="descriptionAssociation" name="descriptionAssociation" placeholder="Entrez la description de votre association"></textarea>
              </div>
            <div class="form-group">
              <label for="localisation">Votre localisation :</label>
              <div class="input-group">
                <input data-toggle="tooltip" data-placement="right" title="Champs obligatoire" type="text" class="form-control" id="localisation" name="localisation" placeholder="Entrez votre localisation" required>
                <span class="input-group-addon">
                  <i class="glyphicon glyphicon-map-marker"></i> <!-- Icône de marqueur de carte -->
                </span>


              </div>

            

              <!-- Champ pour le logo de l'association -->
              <div class="form-group">
                  <label for="logoAssociation"><span class="glyphicon glyphicon-picture" aria-hidden="true"></span> Logo de l'association :</label>
                  <input type="file" id="logoAssociation" name="logoAssociation">
              </div>

            </div>
              
          </form>
        </div>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="thumbnail text-center bg-success">
        <div class="caption" id="thumbnail_1">
          <h2>Renseignez plus d'information sur le type de mission que vous proposez :</h2>
          <form>
              <div class="form-group">
                  <label for="nomAssociation"> <span class="glyphicon glyphicon-sort-by-alphabet" aria-hidden="true"></span>
                  Domaines souhaités </label>
                <p>
                  <?php
                  
                  ?>
                </p>
               

              </div>
              <div class="form-group">
                  <label for="descriptionAssociation"> <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                    Types de missions proposées </label> <br>
                <textarea name="missions"></textarea>
              </div>
            
          </form>
          
        </div>
      </div>
    </div>

    <div class="col-sm-12">
      <div class="col-sm-12"> <!-- Utilisation de la classe text-center -->
        <div class="caption" id="thumbnail_3">
          <h2>Renseignez vos contacts pour les bénévoles :</h2>
          <form>
            <div class="form-group">
              <label for="emailAssociation">E-mail de l'association :</label>
              <input type="email" class="form-control" id="emailAssociation" name="emailAssociation" placeholder="Entrez l'e-mail de l'association" required>
            </div>
            <div class="form-group">
              <label for="telAssociation">Téléphone de l'association :</label>
              <input type="tel" class="form-control" id="telAssociation" name="telAssociation" placeholder="Entrez le numéro de téléphone de l'association">
            </div>
           
          </form>
        </div>
      </div>
    </div>


    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirmationModal">
        Valider les informations
    </button>

    <!-- Modèle de confirmation -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="confirmationModalLabel">Confirmation</h4>
                </div>
                <div class="modal-body">
                    Attention, une fois les informations enregistrées, vous ne pourrez plus les modifier. Confirmez la création de l'association ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Confirmer</button>
                </div>
            </div>
        </div>
    </div>




  </div>




  
  </body>

