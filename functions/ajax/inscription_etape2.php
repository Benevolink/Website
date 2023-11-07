<?php
require_once "../../links.php";
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $tableau = [];
    
    $required_fields = ["email", "tel", "mdp", "mdp2", "liste_domaine", "visu", "nom", "prenom", "date_de_naissance", "departement", "adresse"];
    
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field]) || empty($_POST[$field])) {
            $tableau['statut'] = 0;
            $tableau['message_erreur'] = "Le champ '$field' est obligatoire.";
            echo json_encode($tableau, JSON_UNESCAPED_UNICODE);
            exit();
        }
    }
    
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $tableau['statut'] = 0;
        $tableau['message_erreur'] = 'Format email invalide.';
        echo json_encode($tableau, JSON_UNESCAPED_UNICODE);
        exit();
    }
    
    if (strcmp($_POST['mdp'], $_POST['mdp2']) !== 0) {
        $tableau['statut'] = 0;
        $tableau['message_erreur'] = 'Les mots de passe sont différents.';
        echo json_encode($tableau, JSON_UNESCAPED_UNICODE);
        exit();
    }

    // Validation supplémentaire du mot de passe
    if (strlen($_POST['mdp']) < 9 ||
        !preg_match("/[A-Z]/", $_POST['mdp']) ||
        !preg_match("/[a-z]/", $_POST['mdp']) ||
        !preg_match("/[0-9]/", $_POST['mdp']) ||
        !preg_match("/[^A-Za-z0-9]/", $_POST['mdp'])) {
        $tableau['statut'] = 0;
        $tableau['message_erreur'] = 'Le mot de passe doit contenir au moins 9 caractères, dont au moins une majuscule, une minuscule, un chiffre et un caractère spécial.';
        echo json_encode($tableau, JSON_UNESCAPED_UNICODE);
        exit();
    }

    // Vérification du numéro de téléphone
    if (isset($_POST['tel']) && (strlen($_POST['tel']) != 10 || substr($_POST['tel'], 0, 1) !== '0')) {
        $tableau['statut'] = 0;
        $tableau['message_erreur'] = 'Le numéro de téléphone n\'est pas au bon format.';
        echo json_encode($tableau, JSON_UNESCAPED_UNICODE);
        exit();
    }
    
    // Vérification du nombre de domaines sélectionnés
    if (isset($_POST['liste_domaine']) && is_array($_POST['liste_domaine']) && count($_POST['liste_domaine']) < 3) {
        $tableau['statut'] = 0;
        $tableau['message_erreur'] = 'Sélectionnez au moins 3 domaines.';
        echo json_encode($tableau, JSON_UNESCAPED_UNICODE);
        exit();
    }

    // Vérification de la case "visu"
    $visu = isset($_POST['visu']) ? 1 : 0;

    // Vérification du format de la date de naissance
    if (!strtotime($_POST['date_de_naissance'])) {
        $tableau['statut'] = 0;
        $tableau['message_erreur'] = 'Format de date de naissance invalide. Utilisez le format AAAA-MM-JJ.';
        echo json_encode($tableau, JSON_UNESCAPED_UNICODE);
        exit();
    }

    // Vérification du format du département
    $departement = $_POST['departement'];
    if (!preg_match("/^\d{2,3}$/", $departement)) {
        $reponse = [
            'statut' => 0,
            'message_erreur' => 'Format de département invalide.'
        ];
        echo json_encode($reponse, JSON_UNESCAPED_UNICODE);
        exit;
    }

    // Enregistrement du département et de l'adresse
    $departement = $_POST['departement'];
    $adresse = $_POST['adresse'];

    // Requête SQL d'insertion pour la table "lieu"
    $insertLieuQuery = "INSERT INTO lieu (departement, adresse) VALUES (:departement, :adresse)";
    $stmt = $db->prepare($insertLieuQuery);
    $stmt->bindParam(':departement', $departement);
    $stmt->bindParam(':adresse', $adresse);
    $stmt->execute();

    // Obtenez l'ID qui a été créé dans la table "lieu"
    $id_lieu = $db->lastInsertId();

    // Enregistrement des données de l'utilisateur
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $date_de_naissance = $_POST['date_de_naissance'];
    $email = $_POST['email'];
    $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT);
    $tel = isset($_POST['tel']) ? $_POST['tel'] : null;
    $liste_domaine = json_decode(stripslashes($_POST['liste_domaine']));
    $est_bloque = false;

    // Requête SQL d'insertion pour la table "users"
    $insertUserQuery = "INSERT INTO users (nom, prenom, date_de_naissance, email, mdp, tel, visu, id_lieu, est_bloque)
                        VALUES (:nom, :prenom, :date_de_naissance, :email, :mdp, :tel, :visu, :id_lieu, :est_bloque)";
    
    $stmt = $db->prepare($insertUserQuery);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':date_de_naissance', $date_de_naissance);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':mdp', $mdp);
    $stmt->bindParam(':tel', $tel);
    $stmt->bindParam(':visu', $visu);
    $stmt->bindParam(':id_lieu', $id_lieu);
    $stmt->bindParam(':est_bloque', $est_bloque);

    try {
        $stmt->execute();
        // Obtenez l'ID de l'utilisateur créé
        $user_id = $db->lastInsertId();
        
        // Insérer les domaines d'intérêt dans la table "domaine_jonction"
        foreach ($liste_domaine as $id_domaine) {
            $insertDomaineJonctionQuery = "INSERT INTO domaine_jonction (id_domaine, id_jonction, type) VALUES (:id_domaine, :id_jonction, :type)";
            $stmt = $db->prepare($insertDomaineJonctionQuery);
            $stmt->bindParam(':id_domaine', $id_domaine);
            $stmt->bindParam(':id_jonction', $user_id);
            $stmt->bindValue(':type', 0); // Type 0 pour un utilisateur
            $stmt->execute();
        }
        session_regenerate_id(true);
        $tableau['statut'] = 1;
          //On affecte les variables de $_SESSION à l'utilisateur
        $_SESSION["auth"]=1;
        $req = "SELECT id FROM users WHERE email =:email";
        $table2 = $db->prepare($req);
        $table2->bindParam(":email",$_POST['email']);
        $table2->execute();
        $table2=$table2->fetchAll();
        $_SESSION["user_id"] = $table2[0][0];
        echo json_encode($tableau, JSON_UNESCAPED_UNICODE);
    } catch (PDOException $e) {
        $tableau['statut'] = 0;
        $tableau['message_erreur'] = 'Erreur lors de l\'insertion : ' . $e->getMessage();
        echo json_encode($tableau, JSON_UNESCAPED_UNICODE);
    }
}
?>
