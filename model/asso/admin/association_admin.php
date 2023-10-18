<?php
require_once BF::abs_path("libs/User.php",true);
require_once BF::abs_path("libs/Asso.php",true);
//On a besoin de $id_asso

//fonction graphique pour séparer les types de rôle par couleur
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
      <div class="tag" style=<?php echo '"background-color:'.$color.';"'; ?> onclick=<?php echo "'menu_roles(this,".$id_asso.",".$id_membre.");'";?>> <?php echo $role;?>  </div>
      <?php
  }

function get_liste_membres(){
  $asso = new Asso($id_asso);
  $array = $asso->liste_membres_noms();
  return $array;
}

function affichage_liste_membres(){
  $membres = get_liste_membres();
  foreach ($membres as $membre): ?>
    <li class="liste"><?php
      echo BF::XSS($membre['nom']); 
      echo BF::XSS($membre['prenom']); 
      afficher_role($membre['statut'],$id_asso,$membre['id_user']); ?>
      
    </li>
  <?php endforeach;
}

?>