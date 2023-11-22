<?php
function afficher_liste_assos(){
    global $liste_assos_util;
    foreach ($liste_assos_util as $association) {
        echo '<p>' . $association['nom'] . '</p>';
    }
}


?>