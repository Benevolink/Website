<?php
require_once "../../links.php";


$tableau["statut"]=0;
// Etapes : récupérer l'id de l'event et du gars qui demande la suppression au sein de l'asso. Vérifier le niveau d'autorisation du gars. Si supérieur à deux on supprime l'event, sinon non.
//Comment on récupère l'id ?
// On récupère l'id de l'event grâce à la variable $_GET['

$event = $_POST['id_event'];
$user = $_SESSION["user_id"];
//Faire une requête SQL pour avoir l'id de l'assos de l'event puis le niveau d'autorisation du gars dans l'asso
$req_asso = "SELECT id_asso FROM evenements WHERE id_event = ? ";
$req_asso_2 = $db->prepare($req_asso);
$req_asso_2->execute([$event]);
$asso = $req_asso_2->fetch(PDO::FETCH_ASSOC);


$req_auto = "SELECT statut FROM membres_assos WHERE id_user=? AND id_asso = ?";
$req_auto_2 = $db->prepare($req_auto);
$req_auto_2->execute([$user, $asso["id_asso"]]);
$auto = $req_auto_2->fetch(PDO::FETCH_ASSOC);
if(empty($auto)){
  $tableau["erreur"]="Vous n'êtes pas membre de l'association";
  echo json_encode($tableau,JSON_UNESCAPED_UNICODE);
}
if($auto["statut"] >= 2){
  $tableau["statut"]=1; 

  $req_ho = "SELECT id_horaire FROM evenements WHERE id_event=? ";
  $req_ho_2 = $db->prepare($req_auto);
  $req_ho_2->execute([$event]);
  $ho = $req_ho_2->fetch(PDO::FETCH_ASSOC);

  
  $req_del_ho = "DELETE * FROM horaire WHERE id_horaire = ?";
  $req_del_ho_2 = $db->prepare($req_del_ho);
  $req_del_ho_2->execute([$ho["id_horaire"]]);
  
  $req_del_ev = "DELETE * FROM event WHERE id_event = ?";
  $req_del_ev_2 = $db->prepare($req_del_ev);
  $req_del_ev_2->execute([$event]);

  $req_del_mv = "DELETE * FROM membres_evenements WHERE id_event = ?";
  $req_del_mv_2 = $db->prepare($req_del_mv);
  $req_del_mv_2->execute([$event]);

  $req_del_pe = "DELETE * FROM prop_evenements WHERE id_event = ?";
  $req_del_pe_2 = $db->prepare($req_del_pe);
  $req_del_pe_2->execute([$event]);
  
  echo  json_encode($tableau,JSON_UNESCAPED_UNICODE);
}
$tableau["erreur"]="Vous n'avez pas un niveau d'autorisation assez élevé pour effectuer cette action";
echo  json_encode($tableau,JSON_UNESCAPED_UNICODE);
?>