<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>


<style>

  #myModalLabel{
    text-align:center;
    font-weight:bold;
  }
  </style>
<?php
require_once BF::abs_path("libs/User.php",true);
require_once BF::abs_path("libs/Asso.php",true);
//On a besoin de $id_asso


/**
 * fonction graphique pour séparer les types de rôle par couleur
 *
 * @param int $role $role
 * @param int $id_asso $id_asso
 * @param int $id_membre $id_membre
 *
 * @return void
 */
function afficher_role($role,$id_asso,$id_membre){
    $color = "black";
    switch ($role){
      case 3://"ADMIN":
        $color = "red";
        break;
      case 2:
        $color = "orange";
        break;
      case 1://"MEMBRE":
        $color = "green";
        break;
      case 0://"ATTENTE":
        $color = "blue";
        break;
    }
    ?>
      <select>
        <option value="-1">Banni</option>
        <option value="0">Exclu</option>
        <option value="1">Membre</option>
        <option value="2">Modérateur</option>
        <option value="3">Administrateur</option>
      </select>


      <?php
  }

/**
 * Renvoie la liste des membres
 *
 * @return array
 */
function get_liste_membres(){
  global $id_asso;
  $asso = new Asso($id_asso);
  $array = $asso->get_all_membres();
  return $array;
}

/**
 * Affiche la liste de tous les membres
 *
 * @return void
 */
function affichage_liste_membres(){
  global $id_asso;
  $membres = get_liste_membres();

  foreach ($membres as $membre): ?>
    <li class="liste" id_user="<?= $membre[AttributsTables::USER_ID]?>">
      <span class="nom"><?php echo $membre['nom'] . ' ' . $membre['prenom']; ?></span>
      <span class="role"><?php afficher_role($membre['statut'], $id_asso, $membre['id_user']); ?></span>
      <button type="button" class="label label-danger" data-toggle="modal" data-target="#myModal">
      <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
</button>
<button type="button" class="label label-warning" data-toggle="modal" data-target="#myModal2">
      <span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
</button>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Voulez-vous supprimer ce membre de l'association ? <br> Cette action est définitive</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
        <button type="button" class="btn btn-primary">Confirmer</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal 2 -->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Souhaitez-vous signaler ce membre ? <br> Cette action est définitive</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal3">Confirmer</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="myModal3" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      L'équipe de Benevolink se charge de traiter votre signalement. Merci de votre compréhension.
    </div>
  </div>
</div>

    </li>
  <?php } endforeach;
}

function affichage_liste_en_attente(){
  global $id_asso;
  $membres = get_liste_membres();
  foreach ($membres as $membre): 
    if($membre[AttributsTables::MEMBRESASSOS_STATUT] <= 0){?>
    <li class="liste" id_user="<?= $membre[AttributsTables::USER_ID]?>"><?php
      echo $membre['nom']." "; 
      echo $membre['prenom']; 
      afficher_role($membre['statut'],$id_asso,$membre['id_user']); ?>
      
    </li>
  <?php } endforeach;
}

?>

<script>
  $(document).ready(function(){
    // Lorsque le bouton "Confirmer" du Modal 2 est cliqué
    $('#myModal2 button.btn-primary').click(function(){
      // Fermer le Modal 2
      $('#myModal2').modal('hide');
      
      // Afficher le Modal 3
      $('#myModal3').modal('show');
    });
  });
</script>
