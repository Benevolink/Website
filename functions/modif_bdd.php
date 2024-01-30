<?php require_once __DIR__.'/../links.php';

//on va commencer par altérer les tables déjà existantes (User et Event) puis on créera JoinHoraire

//Modification User
global $db;

$sql_user = "ALTER TABLE users 
             ADD dist_max_accepte INT
             ADD duree_max_accepte INT";

$sql_user_prep = $db->prepare($sql_user);
$sql_user_prep->execute();

//Modification table lieu

$sql_lieu = "ALTER TABLE lieu
            ADD coordonee_x INT
            ADD coordonee_y INT";

$sql_lieu_prep = $db->prepare($sql_lieu);
$sql_lieu_prep->execute();

//Modification evenement

$sql_event = "ALTER TABLE evenements
              ADD duree_mission INT
              ADD indice_prio_mission INT";

$sql_event_prep = $db->prepare($sql_event);
$sql_event_prep->execute();
//Création join_horaire

$sql_joinhoraire = "CREATE TABLE join_horaire (
    id_horaire INT
    num_type INT
    id_join INT
)";

$sql_joinhoraire_prep = $db->prepare($sql_joinhoraire);
$sql_joinhoraire_prep->execute();


?>