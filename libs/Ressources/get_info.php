<?php

require_once 'NomsAttributsTables.php'; 

// Autres inclusions ou configurations nécessaires

// Votre code pour récupérer et formater les informations

// Renvoyer le résultat au format JSON
header('Content-Type: application/json');

// Vérifier le paramètre d'entrée (par exemple, "type" pour spécifier association, volontaire ou événement)
if (isset($_GET['type'])) {
    $type = $_GET['type'];
    $id = isset($_GET['id']) ? $_GET['id'] : null;

    // Initialiser le tableau de données
    $data = [];

    if ($id !== null) {
        // En fonction du "type", récupérer des informations à partir de la table correspondante
        if ($type === 'association') {
                //requete; nom, etc

        } elseif ($type === 'volontaire') {


        } elseif ($type === 'événement') {


        } else {
            $data['erreur'] = 'Paramètre "type" invalide.';
        }
    } else {
        $data['erreur'] = 'Paramètre "id" manquant ou invalide.';
    }

    // Encodez le tableau de données au format JSON et affichez-le
    echo json_encode($data);
} else {
    echo json_encode(['erreur' => 'Paramètre "type" manquant.']);
}
