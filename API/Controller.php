<?php
//Redirige la requête vers le bon fichier
require_once __DIR__."/../../functions/basic_functions.php";

//Lecture de l'entrée utilisateur
if(!isset($_POST["fonction"]) || empty($_POST["fonction"]))
exit("Veuillez spécifier une fonction");

if(!isset($_POST["type"]) || empty($_POST["fonction"]))
exit("Veuillez spécifier un type");

$fonction = $_POST["fonction"];
$type = $_POST["type"];


/**
 * Method return_json
 *
 * @param array $data $data [explicite description]
 *
 * @return string|bool
 */
function return_json($data) {
    return json_encode($data, JSON_UNESCAPED_UNICODE);
}

/**
 * Permet de renvoyer un message type de succès/erreur
 *
 * @param bool $statut $statut [explicite description]
 * @param string $msg_erreur $msg_erreur [explicite description]
 *
 * @return bool|string
 */
function return_statut($statut,$msg_erreur = ""){
    if($statut == true)
    $array = array("statut" => 1, "message_erreur" => $msg_erreur);

    else
    $array = array("statut" => 0, "message_erreur" => $msg_erreur);

    return json_encode($array, JSON_UNESCAPED_UNICODE);
}

//Redirection
switch($type){
    case "user":
        require __DIR__."/controller/User.php";
        break;
    default:
    break;
}
?>

