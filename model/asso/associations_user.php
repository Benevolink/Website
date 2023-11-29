<?php
function afficher_liste_assos(){
    global $liste_assos_util;

    foreach ($liste_assos_util as $association) {
        echo '<div class="col-md-4">';
        echo '  <div class="panel panel-default">';
        echo '    <div class="panel-body">';
        // Insérer ici le code pour afficher le logo de l'association
        echo '      <img src="' . $association['logo'] . '" alt="Logo de l\'association" class="img-responsive">';
        echo '      <h4>' . $association['nom'] . '</h4>';
        echo '    </div>';
        echo '  </div>';
        echo '</div>';
    }
}
?>
