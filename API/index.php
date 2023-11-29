<?php
//Redirige la requête vers le bon fichier
require_once __DIR__."/../functions/basic_functions.php";

//Lecture de l'entrée utilisateur
if(!isset($_POST["fonction"]) || empty($_POST["fonction"]))
exit("Veuillez spécifier une fonction");

if(!isset($_POST["type"]) || empty($_POST["fonction"]))
exit("Veuillez spécifier un type");


header('Content-Type: application/json; charset=utf-8');
$fonction = $_POST["fonction"];
$type = $_POST["type"];


/**
 * Method return_json
 *
 * @param array $data $data [explicite description]
 *
 * @return void
 */
function return_json($data) {
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
}

/**
 * Permet de renvoyer un message type de succès/erreur
 *
 * @param bool $statut $statut [explicite description]
 * @param string $msg_erreur $msg_erreur [explicite description]
 *
 * @return void
 */
function return_statut($statut,$msg_erreur = ""){
    if($statut == true)
    $array = array("statut" => 1, "message_erreur" => $msg_erreur);

    else
    $array = array("statut" => 0, "message_erreur" => $msg_erreur);

    echo json_encode($array, JSON_UNESCAPED_UNICODE);
}

//Redirection
switch($type){
    case "user":
        require __DIR__."/controller/User.php";
        break;
    case "asso":
        require __DIR__."/controller/Asso.php";
        break;
    case "event":
        require __DIR__."/controller/Event.php";
        break;
    case "domaine":
        require __DIR__."/controller/Domaine.php";
    default:
        return_statut(false,"user | asso | event | domaine");
    break;
}
?>

