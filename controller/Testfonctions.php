<?php
// Inclure les fichiers nécessaires
require_once 'C:\Program Files (x86)\EasyPHP-Devserver-17\eds-www\Site\Website\libs\Asso.php';
require_once 'C:\Program Files (x86)\EasyPHP-Devserver-17\eds-www\Site\Website\libs\Ressources\NomsAttributsTables.php';
require_once 'C:\Program Files (x86)\EasyPHP-Devserver-17\eds-www\Site\Website\libs\Event.php';
require_once 'C:\Program Files (x86)\EasyPHP-Devserver-17\eds-www\Site\Website\libs\Lieu.php';

// Créer une instance de l'association avec un ID existant dans votre base de données
$assoIdToTest = 3; // Remplacez cela par l'ID réel de l'association à tester
$associationToTest = new Asso($assoIdToTest);

// Appeler la fonction get_all
$associationInfo = $associationToTest->get_all();

// Afficher les informations récupérées
echo "Informations de l'association avec l'ID $assoIdToTest :\n";
print_r($associationInfo);

/*
// Test de la suppression d'une association
function testSuppressionAssociation() {
    // Créer une instance de l'association à supprimer (remplacez l'ID avec un ID existant dans votre base de données)
    $associationIdToDelete = 2; // Remplacez cela par l'ID réel de l'association à supprimer
    $associationToDelete = new Asso($associationIdToDelete);

    // Appel de la fonction de suppression
    $associationToDelete->suppr();

    // Vérification si l'association a été supprimée
    // Vous pouvez ajouter ici des assertions ou des vérifications supplémentaires
    echo "Suppression de l'association réussie.\n";
}

// Appeler la fonction de test
testSuppressionAssociation();*/

/*
// Test de la fonction get_all_membres
function testGetAllMembres() {
    // Remplacez l'ID de l'association par l'ID réel dans votre base de données
    $associationId = 3; // Remplacez cela par l'ID réel de l'association à tester

    // Créer une instance de l'association
    $association = new Asso($associationId);

    // Appel de la fonction get_all_membres
    $membres = $association->get_all_membres();

    // Affichage des résultats
    if (!empty($membres)) {
        echo "Membres de l'association:\n";
        foreach ($membres as $membre) {
            echo "ID: " . $membre[AttributsTables::USER_ID] . "\n";
            echo "Nom: " . $membre[AttributsTables::USER_NOM] . "\n";
            echo "Prénom: " . $membre[AttributsTables::USER_PRENOM] . "\n";
            echo "Statut: " . $membre[AttributsTables::MEMBRESASSOS_STATUT] . "\n";
            echo "------------------------\n";
        }
    } else {
        echo "Aucun membre trouvé pour cette association.\n";
    }
}

// Appel du test
testGetAllMembres();
*/


/*

// Remplacez ces valeurs par les données réelles que vous souhaitez tester
$nom = "Nom de l'association";
$description = "Description de l'association";
$description_missions = "Description des missions de l'association";
$logo = "chemin/vers/le/logo.jpg"; // Remplacez cela par le chemin réel de votre logo
$email = "contact@association.com";
$tel = "0123456789";
$adresse = "Adresse de l'association"; // Ajoutez cette ligne avec une valeur appropriée pour $adresse
$domaines = [1, 2, 3]; // Remplacez ces valeurs par les ID de domaines réels

try {
    // Appel de la fonction insert pour créer une nouvelle association
    Asso::insert($nom, $description, $description_missions, $logo, $email, $tel, $adresse, $domaines);

    // Affichage d'un message si l'insertion a réussi
    echo "Association créée avec succès.\n";
} catch (Exception $e) {
    // Affichage de l'erreur si quelque chose ne va pas
    echo "Erreur lors de la création de l'association : " . $e->getMessage() . "\n";
}
*/

/*
// Test de la fonction ajouter_membre
function testAjoutMembre() {
    // Remplacez cela par l'ID réel de l'utilisateur à ajouter en tant que membre
    $userIdToAdd = 2;

    // Remplacez cela par l'ID réel de l'association à laquelle ajouter le membre
    $assoId = 3;

    // Créer une instance de l'association
    $association = new Asso($assoId);

    // Appeler la fonction ajouter_membre
    $result = $association->ajouter_membre($userIdToAdd);

    // Afficher le résultat du test
    echo $result . "\n";
}

// Appeler la fonction de test
testAjoutMembre();

*/

/*
// Test de la fonction supprimer_membre
function testSupprimerMembre() {
    // Remplacez cela par l'ID réel de l'utilisateur à supprimer
    $userIdToRemove = 3;

    // Remplacez cela par l'ID réel de l'association de laquelle supprimer le membre
    $assoId = 3;

    // Créer une instance de l'association
    $association = new Asso($assoId);

    // Appeler la fonction supprimer_membre
    $result = $association->supprimer_membre($userIdToRemove);

    // Afficher le résultat du test
    echo $result . "\n";
}

// Appeler la fonction de test
testSupprimerMembre();
*/

/*
// Test de la fonction modifier_role_membre
function testModifierRoleMembre() {
    // Remplacez cela par l'ID réel de l'utilisateur à modifier
    $userIdToModify = 2;

    // Remplacez cela par l'ID réel de l'association à laquelle l'utilisateur est membre
    $assoId = 3;

    // Remplacez cela par le nouveau rôle que vous souhaitez attribuer à l'utilisateur
    $newRole = "Président";

    // Créer une instance de l'association
    $association = new Asso($assoId);

    // Appeler la fonction modifier_role_membre
    $result = $association->modifier_role_membre($userIdToModify, $newRole);

    // Afficher le résultat du test
    echo $result . "\n";
}

// Appeler la fonction de test
testModifierRoleMembre();
*/

// Test de la fonction liste_missions
function testListeMissions() {
    // Remplacez cela par l'ID réel de l'association pour laquelle vous souhaitez obtenir la liste des missions
    $assoId = 2;

    // Créer une instance de l'association
    $association = new Asso($assoId);

    // Appeler la fonction liste_missions
    $missions = $association->liste_missions();

    // Afficher le résultat du test
    echo "Liste des missions pour l'association $assoId : \n";
    print_r($missions);
}

// Appeler la fonction de test
testListeMissions();

?>
