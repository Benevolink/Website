

<link rel="stylesheet" href="<?= BF::abs_path("CSS/mon_compte.css")?>">

<div class="liste_prop" style="display: inline-block; margin-left: 100px;">
  <div>
      <img id ="image_logo" src="<?= BF::abs_path("/media/img/user_anonyme.jpg")?>" style="width:200px;border-radius:200px;border: 10px black solid;cursor: pointer;"/>
      <?php afficher_infos_1(); ?>
      
  
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

<div class="liste_prop" style="display: inline-block; margin-left: 100px;">
    <div>
        <?php afficher_infos_2(); echo "Bonjour"; ?>
    </div>
    <!-- Reste de votre code... -->

    <!-- Tableau des disponibilités -->
    <div class="tableau-droite">
        <table>
            <tr>
                <th>Jour de la semaine</th>
                <th>Disponibilité</th>
            </tr>
            <tr>
                <td>Lundi</td>
                <td><input type="checkbox"></td>
            </tr>
            <tr>
                <td>Mardi</td>
                <td><input type="checkbox"></td>
            </tr>
            <tr>
                <td>Mercredi</td>
                <td><input type="checkbox"></td>
            </tr>
            <tr>
                <td>Jeudi</td>
                <td><input type="checkbox"></td>
            </tr>
            <tr>
                <td>Vendredi</td>
                <td><input type="checkbox"></td>
            </tr>
            <tr>
                <td>Samedi</td>
                <td><input type="checkbox"></td>
            </tr>
            <tr>
                <td>Dimanche</td>
                <td><input type="checkbox"></td>
            </tr>
        </table>
    </div>
    <style>
      .tableau-droite {
        float: right; 
        margin-right: 100px; 
        width: 50%; 
        box-sizing: border-box; 
      }
    </style>
</div>
