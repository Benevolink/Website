<?php
$file_name = "asso/admin/".basename(__FILE__);
require_once 'links.php';
require_once BF::abs_path("functions/security_functions.php",true);
require_once BF::abs_path("libs/Asso;php",true);
if(BF::is_posted(["nom","uploadedfile","desc", "desc_missions", "adresse", "domaine", "email", "tel"])){
    $association = $_POST["nom"];
    $description = $_POST["desc"];
    $description_missions = $_POST["desc_missions"];
    $logo = $_POST["uploadedfile"];
    $email = $_POST["email"];
    $telephone = $_POST["tel"];
    if(secure_image($_FILES['uploadedfile']['name'])==1){
        echo "Le fichier n'est pas au bon format";
        exit(0);
    }
    if(secure_image( $_FILES['uploadedfile']['name'])==2){
        echo "Le nom du fichier ne doit pas contenir de point sauf pour l'extention";
        exit(0);
    }
    //Mise au bon format de l'image (jpg et la bonne taille)
    $extension = pathinfo($_FILES['uploadedfile']['name'], PATHINFO_EXTENSION);
    if($extension=="php"){
        $logo=imagecreatefrompng($logo);
    }
    if($extension=="gif"){
        $logo=imagecreatefromgif($logo);
    }
    if($extension=="jpeg"){
        $logo=imagecreatefromjpeg($logo);
    }
    $size_w=304;
    $size_h=166;
    $logo=imagecrop($logo,['x'=>0,'y'=>0,'width'=>$size_w,'height'=>$size_h]);
    Asso::insert_asso($association,$description,$description_missions,$logo,$email,$telephone);

}else{
    echo "Il manque des données dans le formulaire envoyé.";
    if(!isset($_POST["nom"])){
        echo "nom:";
    }
    if(!isset($_POST["uploadedfile"])){
        echo "logo:";
    }
    if(!isset($_POST["desc"])){
        echo "desc:";
    }
    if(!isset($_POST["desc_missions"])){
        echo "desc_missions:";
    }
    if(!isset($_POST["adresse"])){
        echo "adresse:";
    }
    if(!isset($_POST["tel"])){
        echo "tel:";
    }
    if(!isset($_POST["email"])){
        echo "email:";
    }
    if(!isset($_POST["domaine"])){
        echo "domaine:";
    }
}
require_once BF::abs_path("model/".$file_name);
?>