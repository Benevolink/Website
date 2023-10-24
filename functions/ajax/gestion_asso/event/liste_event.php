<?php
require_once "../../links.php";
$req_events = "Select id_asso FROM evenements";
$req_events_2 = $db ->prepare($req_events);
$req_events_2 -> execute();
$events = $req_events_2 -> fetchAll(PDO::FETCH_ASSOC);

if(isset($_POST['id_asso'])){
  $req_events_asso = "SELECT id_asso FROM evenements WHERE id_event = ? ";
  $req_events_asso_2 = $db->prepare($req_events_asso);
  $req_events_asso_2->execute([$_POST['id_asso']]);
  $events_asso = $req_events_asso_2->fetch(PDO::FETCH_ASSOC);
  for($i = 0; $i < count($events); $i++){
    if(not($events[i]["id_asso"], $events_asso["id_asso"])){
      unset($events[i]);
    }
  }
}
if(isset($_POST['domaines'])){
  $req_id_domaine = "SELECT id_domaine FROM domaine WHERE nom_domaine = ?";
  $req_id_domaine_2 = $db->prepare($req_id_domaine);
  $req_id_domaine_2->execute([$_POST['domaines']]);
  $id_domaine = $req_id_domaine_2->fetch(PDO::FETCH_ASSOC);
  for($i = 0; $i < count($id_domaine); $i++){
    if(not($events[i]["id_domaine"], $events_asso["id_domaine"])){
      unset($events[i]);
    }
  }
}

  
  $req_events_domaines = "SELECT id_asso FROM evenements WHERE id_domaine = ? ";
  $req_events_domaines_2 = $db->prepare($req_events_domaines);
  $req_events_domaines_2->execute([$id_domaine]);
  $events_domaines = $req_events_domaines_2->fetch(PDO::FETCH_ASSOC);
  for($i = 0; $i < count($events); $i++){
    if(not($events[i]["id_asso"], $events_domaines["id_asso"])){
       unset($event[i]);
    }
}

?>