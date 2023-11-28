<?php
$file_name = "asso/admin/" . basename(__FILE__);
require_once 'links.php';
require_once BF::abs_path("functions/security_functions.php", true);
require_once BF::abs_path("libs/Asso.php", true);

if (BF::is_posted(["nom", "uploadedfile", "desc", "desc_missions", "adresse", "domaine", "email", "tel"])) {
    $association = $_POST["nom"];
    $description = $_POST["desc"];
    $description_missions = $_POST["desc_missions"];
    $logo = $_FILES["uploadedfile"]["name"]; // Utilisation de $_FILES pour les fichiers uploadés
    $email = $_POST["email"];
    $telephone = $_POST["tel"];
    Asso::insert($association, $description, $description_missions, $logo, $email, $telephone, []);
    header("Location: " . BF::abs_path("controller/static/form-merci.php", true));
    exit();
} else {
    echo "Il manque des données dans le formulaire envoyé.";
    if (!isset($_POST["nom"])) {
        echo "nom:";
    }
    if (!isset($_POST["uploadedfile"])) {
        echo "logo:";
    }
    if (!isset($_POST["desc"])) {
        echo "desc:";
    }
    if (!isset($_POST["desc_missions"])) {
        echo "desc_missions:";
    }
    if (!isset($_POST["adresse"])) {
        echo "adresse:";
    }
    if (!isset($_POST["tel"])) {
        echo "tel:";
    }
    if (!isset($_POST["email"])) {
        echo "email:";
    }
    if (!isset($_POST["domaine"])) {
        echo "domaine:";
    }
}

$this_directory = __DIR__;
$file_to_include = $this_directory."\creation_asso.php";
require_once $file_to_include;

?>
