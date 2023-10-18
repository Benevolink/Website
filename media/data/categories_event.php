<?php
//Répertorie les catégories de missions
$categories = array(
  array("nom"=>"lutte contre l’isolement , aide psychologique","logo"=>"","id"=>0),
  array("nom"=>"assurer un cadre sécurisant et respectueux","logo"=>"","id"=>1),
  array("nom"=>"prévention, action de sensibilisation","logo"=>"","id"=>2),
  array("nom"=>"éducation, soutien scolaire, formation, alphabétisation","logo"=>"","id"=>3),
  /*array("nom"=>"création d’outils de communication","logo"=>""),
  array("nom"=>"administratif, gestion financière, comptabilité","logo"=>""),
  array("nom"=>"animer des activités, evenementiel","logo"=>""),
  array("nom"=>"mentorat et parrainage","logo"=>""),
  array("nom"=>"distribution, collecte de produits","logo"=>""),
  array("nom"=>"travaux manuels","logo"=>""),
  array("nom"=>"service à la personne","logo"=>""),
  array("nom"=>"médiation culturelle","logo"=>""),
  array("nom"=>"recherche de partenariat, collecte de fond","logo"=>""),
  array("nom"=>"Médical, secourisme, sécurité civile","logo"=>""),
  array("nom"=>"Vie citoyenne","logo"=>""),
  array("nom"=>"informatique","logo"=>""),
  array("nom"=>"gestion de projet, gouvernance, gestion des ressources humaines","logo"=>""),
  array("nom"=>"aménagement espaces naturels","logo"=>""),
  array("nom"=>"logistique","logo"=>""),
  array("nom"=>"ramassage de déchets","logo"=>""),
  array("nom"=>"soins aux animaux","logo"=>""),
  array("nom"=>"maraude","logo"=>"")*/
);
/*
// Récupérer les catégories sélectionnées
$categoriesSelectionnees = isset($_POST['categories']) ? $_POST['categories'] : array();

// Convertir les noms de catégorie en identifiants si nécessaire
$categoriesIds = array();
foreach ($categoriesSelectionnees as $categorieSelectionnee) {
    foreach ($categories as $categorie) {
        if ($categorie['nom'] === $categorieSelectionnee) {
            $categoriesIds[] = $categorie['id'];
            break;
        }
    }
}

// Insérer les catégories sélectionnées dans la table categories_evenements
if (!empty($categoriesIds)) {
    foreach ($categoriesIds as $categorieId) {
        $insertionCategorieReq = "INSERT INTO categorie_event (id_event, categorie) VALUES (:id_event, :categorie)";
        $insertionCategorieReq_p = $db->prepare($insertionCategorieReq);
        $insertionCategorieReq_p->bindParam(':id_event', $id_event);
        $insertionCategorieReq_p->bindParam(':categorie', $categorieId);
        $insertionCategorieReq_p->execute();
    }
}

?>*/