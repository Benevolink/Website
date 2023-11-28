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
  foreach ($membres as $membre): 
    if($membre[AttributsTables::MEMBRESASSOS_STATUT] > 0){?>
    <li class="liste" id_user="<?= $membre[AttributsTables::USER_ID]?>"><?php
      echo $membre['nom']." "; 
      echo $membre['prenom']; 
      afficher_role($membre['statut'],$id_asso,$membre['id_user']); ?>
      
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