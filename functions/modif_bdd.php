<?php require_once __DIR__.'/../links.php';



//on va commencer par altérer les tables déjà existantes (User et Event) puis on créera JoinHoraire

//Modification User
//Première modification, décommenter si pas déjà réaliser

/*$sql_user_1 = "ALTER TABLE users ADD dist_max_accepte INTEGER";

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
*/
//Modif 2 rajouter si pas déjà fait

/*
$sql_joincompetence = "CREATE TABLE join_competence (id_competence INTEGER, num_type INTEGER, id_join INTEGER)";

try {
    $sql_joincompetence_prep = $db->prepare($sql_joincompetence);
    $sql_joincompetence_prep->execute();
    echo "Modification de la table réussie.";
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}*/
$sql_disponibilites = "CREATE TABLE disponibilites (id_user INTEGER, jour INTEGER, h_deb TIME, h_fin TIME)";

try {
    $sql_disponibilites_prep = $db->prepare($sql_disponibilites);
    $sql_disponibilites_prep->execute();
    echo "Modification de la table réussie.";
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

$sql_horaire="ALTER TABLE horaire ADD id_event  INTEGER";

try {
    $sql_horaire_prep = $db->prepare($sql_horaire);
    $sql_horaire_prep->execute();
    echo "Modification de la table réussie.";
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

$sql_suppress="DROP TABLE join_horaire";

try {
    $sql_suppress = $db->prepare($sql_suppress);
    $sql_suppress->execute();
    echo "Modification de la table réussie.";
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

?>