<?php require_once __DIR__.'/../links.php';

//on va commencer par altérer les tables déjà existantes (User et Event) puis on créera JoinHoraire

//Modification User

$sql_user = "ALTER TABLE users 
             ADD dist_max_accepte INT
             ADD duree_max_accepte INT";

$exec_sql_user->exec($sql_user);

//Modification table lieu

$sql_lieu = "ALTER TABLE lieu
            ADD coordonee_x INT
            ADD coordonee_y INT";

$exec_sql_lieu->exec($sql_lieu);

//Modification evenement

$sql_event = "ALTER TABLE evenements
              ADD duree_mission INT
              ADD indice_prio_mission INT";

$exec_sql_event->exec($sql_event);
//Création join_horaire

$sql_joinhoraire = "CREATE TABLE join_horaire (
    id_horaire INT
    num_type INT
    id_join INT
)";

$exec_sql_joinhoraire->exec($sql_joinhoraire);


?>