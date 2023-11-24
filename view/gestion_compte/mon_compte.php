<style>

  #dispo_text{
    font-size: 12px;
  }

  .bordered-table {
      border-collapse: collapse;
      width: 100%; /* Ajustez la largeur selon vos besoins */
  }

  .bordered-table th,
  .bordered-table td {
      border: 1px solid #000; /* Couleur et épaisseur de la bordure */
      padding: 8px; /* Espace à l'intérieur des cellules */
      text-align: left; /* Alignement du texte (gauche) */
  }
  
  </style>


<link rel="stylesheet" href="<?= BF::abs_path("CSS/mon_compte.css")?>">
<script type="text/javascript" src="<?= BF::abs_path("JS/before/gestion_compte/mon_compte.js")?>">
</script>
<div class="liste_prop" style="display: inline-block; margin-left: 100px;">
  

  
  <div style="cursor: pointer;" onclick="confirmer('<?= BF::abs_path('controller/gestion_compte/functions/modif_mdp.php')?>','modifier le mot de passe');">
      Modifier le mot de passe
  </div>
  <div style="cursor: pointer;" onclick="confirmer('<?= BF::abs_path('controller/gestion_compte/functions/deconnexion.php')?>','se déconnecter');">
      Déconnexion
  </div>
  <div style="cursor: pointer;" onclick="confirmer('<?= BF::abs_path('controller/gestion_compte/functions/suppr_compte.php')?>','supprimer le compte');">
      Supprimer le compte
  </div>
      <div style="cursor: pointer;" onclick="confirmer('<?= BF::abs_path('controller/asso/associations_user.php')?>','accéder aux associations');">
      Liste des associations
  </div>
</div>


<div class="col-md-4">
<div class="liste_prop" class="thumbnail" style="display: inline-block; margin-left: 100px;">
    <div>
        <?php afficher_infos_2(); ?>
    </div>
    <!-- Reste de votre code... -->

    <div class="tableau-droite">
        
    </div>

    <script>
        // Fonction pour afficher/masquer les champs d'heure de début et de fin en fonction de la case à cocher
        function toggleHeureInputs(checkbox) {
            var parentRow = checkbox.parentElement.parentElement;
            var heureDebutInput = parentRow.querySelector(".heure-debut");
            var heureFinInput = parentRow.querySelector(".heure-fin");

            if (checkbox.checked) {
                heureDebutInput.style.display = 'inline-block';
                heureFinInput.style.display = 'inline-block';
            } else {
                heureDebutInput.style.display = 'none';
                heureFinInput.style.display = 'none';
            }
        }

        // Attachez un gestionnaire d'événements à toutes les cases à cocher de classe "checkbox-dispo"
        var checkboxes = document.querySelectorAll('.checkbox-dispo');
        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                toggleHeureInputs(this);
            });
        });
    </script>

    </div>
      

    </div>

</div>


    <style>
      .tableau-droite {
        float: right; 
        margin-right: 100px; 
        width: 50%; 
        box-sizing: border-box; 
      }

      #centre_interet{
        position: relative;
      }
    </style>
</div>
      <div class="row">
          <div class="col-md-4">
            <table class="bordered-table">
              <h3> Mes Disponibilités </h3>
                <tr id="dispo_text">
                    <th>Jour de la semaine</th>
                    <th>Disponibilité</th>
                    <th>Heure de début</th>
                    <th>Heure de fin</th>
                </tr>
                <tr>
                    <td>Lundi</td>
                    <td><input type="checkbox" class="checkbox-dispo" onchange="toggleHeureInputs(this)"></td>
                    <td><input type="time" class="heure-debut" style="display: none;"></td>
                    <td><input type="time" class="heure-fin" style="display: none;"></td>
                </tr>
                <tr>
                    <td>Mardi</td>
                    <td><input type="checkbox" class="checkbox-dispo" onchange="toggleHeureInputs(this)"></td>
                    <td><input type="time" class="heure-debut" style="display: none;"></td>
                    <td><input type="time" class "heure-fin" style="display: none;"></td>
                </tr>
                <tr>
                    <td>Mercredi</td>
                    <td><input type="checkbox" class="checkbox-dispo" onchange="toggleHeureInputs(this)"></td>
                    <td><input type="time" class="heure-debut" style="display: none;"></td>
                    <td><input type="time" class="heure-fin" style="display: none;"></td>
                </tr>
                <tr>
                    <td>Jeudi</td>
                    <td><input type="checkbox" class="checkbox-dispo" onchange="toggleHeureInputs(this)"></td>
                    <td><input type="time" class="heure-debut" style="display: none;"></td>
                    <td><input type="time" class="heure-fin" style="display: none;"></td>
                </tr>
                <tr>
                    <td>Vendredi</td>
                    <td><input type="checkbox" class="checkbox-dispo" onchange="toggleHeureInputs(this)"></td>
                    <td><input type="time" class="heure-debut" style="display: none;"></td>
                    <td><input type="time" class="heure-fin" style="display: none;"></td>
                </tr>
                <tr>
                    <td>Samedi</td>
                    <td><input type="checkbox" class="checkbox-dispo" onchange="toggleHeureInputs(this)"></td>
                    <td><input type="time" class="heure-debut" style="display: none;"></td>
                    <td><input type="time" class="heure-fin" style="display: none;"></td>
                </tr>
                <tr>
                    <td>Dimanche</td>
                    <td><input type="checkbox" class="checkbox-dispo" onchange="toggleHeureInputs(this)"></td>
                    <td><input type="time" class="heure-debut" style="display: none;"></td>
                    <td><input type="time" class="heure-fin" style="display: none;"></td>
                </tr>
            </table>
          </div>
          <div class="col-md-4">
              <div class="thumbnail" id="centre_interet">
                  
                  <div class="caption">
                      <h3>Centres d'intérêt</h3>
                      <div class="form-group">
                          <label for="centresInteret">Sélectionnez vos centres d'intérêt :</label>
                          <select id="centresInteret" class="form-control">
                              <option value="education">Éducation</option>
                              <option value="animation">Animation</option>
                              <option value="presentation">Présentation</option>
                              <option value="soutienScolaire">Soutien Scolaire</option>
                              <option value="accompagnementMalades">Accompagnement de personnes malades</option>
                          </select>
                      </div>
                  </div>
              </div>
          </div>
        <div class="col-md-4">

          <img id ="image_logo" src="<?= BF::abs_path("/media/img/user_anonyme.jpg")?>" style="width:200px;border-radius:200px;border: 10px black solid;cursor: pointer;"/>
          <?php afficher_infos_1(); ?>

        </div>
      </div>
      
          </div>
      </div>

</div>

<div class="row">
  <div class="col-md-4">.col-md-4</div>
  <div class="col-md-4">.col-md-4</div>
  <div class="col-md-4">.col-md-4</div>
</div>

<script type="text/javascript" src="<?= BF::abs_path("JS/after/gestion_compte/mon_compte.js")?>">
</script>