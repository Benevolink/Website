<?php require_once __DIR__.'/../links.php';


//on va commencer par altérer les tables déjà existantes (User et Event) puis on créera JoinHoraire

//Modification User
$sql_user_1 = "ALTER TABLE users ADD dist_max_accepte INTEGER";

try {
    $sql_user_1_prep = $db->prepare($sql_user_1);
    $sql_user_1_prep->execute();
    echo "Modification de la table réussie.";
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

$sql_user_2 = "ALTER TABLE users ADD duree_max_accepte INTEGER";

try {
    $sql_user_2_prep = $db->prepare($sql_user_2);
    $sql_user_2_prep->execute();
    echo "Modification de la table réussie.";
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}


//Modification table lieu

$sql_lieu_1 = "ALTER TABLE lieu ADD coordonee_x INTEGER";
$sql_lieu_2 = "ALTER TABLE lieu ADD coordonee_y INTEGER";
try {
    $sql_lieu_1_prep = $db->prepare($sql_lieu_1);
    $sql_lieu_1_prep->execute();
    echo "Modification de la table réussie.";
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
try {
    $sql_lieu_2_prep = $db->prepare($sql_lieu_2);
    $sql_lieu_2_prep->execute();
    echo "Modification de la table réussie.";
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}


//Modification evenement

$sql_event_1 = "ALTER TABLE evenements
              ADD duree_mission INTEGER";

try {
    $sql_event_1_prep = $db->prepare($sql_event_1);
    $sql_event_1_prep->execute();
    echo "Modification de la table réussie.";
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

$sql_event_2 = "ALTER TABLE evenements  ADD indice_prio_mission INTEGER";
try {
    $sql_event_2_prep = $db->prepare($sql_event_2);
    $sql_event_2_prep->execute();
    echo "Modification de la table réussie.";
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

//Création join_horaire

$sql_joinhoraire = "CREATE TABLE join_horaire (id_horaire INTEGER, num_type INTEGER, id_join INTEGER)";

try {
    $sql_joinhoraire_prep = $db->prepare($sql_joinhoraire);
    $sql_joinhoraire_prep->execute();
    echo "Modification de la table réussie.";
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}



?>