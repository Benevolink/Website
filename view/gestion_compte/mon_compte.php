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

    .tableau-droite {
    float: right; 
    margin-right: 100px; 
    width: 50%; 
    box-sizing: border-box; 
    }

    #centre_interet{
    position: relative;
    }
  
    #titre_asso {
      text-align: center;
      font-family: Corps;
      font-weight: bold;
      src: url(fonts/Nexa-Heavy.woff2) format("woff2");
    }
  </style>


<link rel="stylesheet" href="<?= BF::abs_path("CSS/mon_compte.css")?>">
<script type="text/javascript" src="<?= BF::abs_path("JS/before/gestion_compte/mon_compte.js")?>">
</script>

<h1 id="titre_asso">Mon profil</h1>
<br>

<div class="col-md-4">
<div class="liste_prop" class="thumbnail" style="display: inline-block; margin-left: 100px;">
    <div>
    <img id ="image_logo" src="<?= BF::abs_path("/media/img/user_anonyme.jpg")?>" style="width:200px;border-radius:200px;border: 10px black solid;cursor: pointer;"/>
          
        <?php afficher_infos_2(); ?>
    </div>
    
  

  
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


   
</div>

      <div class="row">
          <div class="col-md-5 col-md-offset-1">
            <table class="bordered-table">
              <h3> Mes Disponibilités </h3>
                <tr id="dispo_text">
                    <th>Jour de la semaine</th>
                    <th>Disponibilité</th>
                    <th>Heure de début</th>
                    <th>Heure de fin</th>
                </tr>
                <tr jour="0">
                    <td>Lundi</td>
                    <td><input type="checkbox" class="checkbox-dispo" onchange="toggleHeureInputs(this)"></td>
                    <td><input type="time" class="heure-debut" style="display: none;"></td>
                    <td><input type="time" class="heure-fin" style="display: none;"></td>
                </tr>
                <tr jour="1">
                    <td>Mardi</td>
                    <td><input type="checkbox" class="checkbox-dispo" onchange="toggleHeureInputs(this)"></td>
                    <td><input type="time" class="heure-debut" style="display: none;"></td>
                    <td><input type="time" class="heure-fin" style="display: none;"></td>
                </tr>
                <tr jour="2">
                    <td>Mercredi</td>
                    <td><input type="checkbox" class="checkbox-dispo" onchange="toggleHeureInputs(this)"></td>
                    <td><input type="time" class="heure-debut" style="display: none;"></td>
                    <td><input type="time" class="heure-fin" style="display: none;"></td>
                </tr>
                <tr jour="3">
                    <td>Jeudi</td>
                    <td><input type="checkbox" class="checkbox-dispo" onchange="toggleHeureInputs(this)"></td>
                    <td><input type="time" class="heure-debut" style="display: none;"></td>
                    <td><input type="time" class="heure-fin" style="display: none;"></td>
                </tr>
                <tr jour="4">
                    <td>Vendredi</td>
                    <td><input type="checkbox" class="checkbox-dispo" onchange="toggleHeureInputs(this)"></td>
                    <td><input type="time" class="heure-debut" style="display: none;"></td>
                    <td><input type="time" class="heure-fin" style="display: none;"></td>
                </tr>
                <tr jour="5">
                    <td>Samedi</td>
                    <td><input type="checkbox" class="checkbox-dispo" onchange="toggleHeureInputs(this)"></td>
                    <td><input type="time" class="heure-debut" style="display: none;"></td>
                    <td><input type="time" class="heure-fin" style="display: none;"></td>
                </tr>
                <tr jour="6">
                    <td>Dimanche</td>
                    <td><input type="checkbox" class="checkbox-dispo" onchange="toggleHeureInputs(this)"></td>
                    <td><input type="time" class="heure-debut" style="display: none;"></td>
                    <td><input type="time" class="heure-fin" style="display: none;"></td>
                </tr>
            </table>
            <input type="submit" value="Valider" id="valider_horaires"/>
          </div>
          <div class="col-md-5 col-md-offset-1">
              <div class="thumbnail" id="centre_interet">
                  
                  <div class="caption">
                      <h3>Centres d'intérêt</h3>
                      <div class="form-group">
                          <label for="centresInteret">Sélectionnez vos centres d'intérêt :</label>
                          <select id="centresInteret" class="form-control">
                          </select>
                      </div>
                  </div>
              </div>
              <input type="submit" id="competences" value="Gérer les competences"/>
          </div>
          
      </div>
      

</div>


<script>
$("#competences").on("click",function(){
    import(abs_path("JS/classes/User.js")).then((UserClass)=>{
        let user = new UserClass.User;
        user.get_all_competences().done((liste_comp_user)=>{
            user.get_all_liste_competences().done((data)=>{
                let bg = $("<div>").attr({
                    id: "bg_comp",
                    class: "background_sombre"
                });
                let fenetre = $("<div>").attr({
                    id : "fenetre_comp"
                }).css({
                    position: "fixed",
                    zIndex: "9990",
                    width: "300px",
                    height: "fit-content",
                    top: "20%",
                    left: "calc(50% - 150px)",
                    backgroundColor: "white",
                    borderRadius: "20px",
                    cursor: "default"
                });
                let liste_comp = $("<div>").attr({
                    id : "liste_comp"
                }).css({
                    marginLeft: "20px"
                });
                data.forEach((value)=>{
                    liste_comp.append([
                        $("<div>").attr({
                            class: "item_comp",
                            id_comp: value["id_comp"]
                        }).text(value["nom_comp"]).css({
                            
                            display: "inline-block"
                        })
                    ]);
                    let input = $("<input>").attr({
                            id_comp: value["id_comp"],
                            type: "checkbox",
                            class: "comp_case"
                        }).css({
                            float: "right",
                            marginRight: "50px"
                        });
                    liste_comp_user.forEach((value_2)=>{
                        if(value_2["id_competence"]==value["id_comp"])
                        {
                            input.attr({
                                checked: "checked"
                            });
                        }
                    });
                    liste_comp.append([input,$("<br>")]);
                });
                let croix = $("<img>").attr({
                    src: abs_path("media/img/croix.jpg")
                }).css({
                    width: "20px",
                    borderRadius: "50%",
                    cursor: "pointer",
                    margin: "20px"
                }).on("click",function(){
                    $("#bg_comp").remove();
                });
                let submit = $("<input>").attr({
                    type: "submit",
                    id: "submit_comp"
                }).css({
                    margin: "30px"
                }).on("click",function(){
                    let liste = $(".comp_case");
                    let liste_id= [];
                    $.each(liste, function (indexInArray, valueOfElement) { 
                        if($(valueOfElement).is(":checked")){
                            liste_id.push($(valueOfElement).attr("id_comp"));
                        }
                    });
                    let user = new UserClass.User;
                    user.send_comp(liste_id).done((data)=>{
                        console.log(data);
                    });
                    $("#bg_comp").remove();
                });
                fenetre.append([croix,liste_comp,submit]);
                $("body").append(bg.append(fenetre));
            });
        });
        
    });
});
</script>
<script type="text/javascript" src="<?= BF::abs_path("JS/after/gestion_compte/mon_compte.js")?>">
</script>