<?php
require_once __DIR__."/../functions/basic_functions.php";
require_once BF::abs_path("db.php",true);
class Asso{
  /*
  Abstraction des assos
  */
  public $id;
  function __construct($id){
    $this->id = $id;
  }

  public function liste_missions(){
    /*
    Renvoie la liste des missions de l'asso sous la forme:
    array([
      0 : [
      "id_event" : x
      ],
      1 : [
      "id_event" : y
      ],
      ...
    ])
    */
    $req = "SELECT id_event FROM evenements WHERE id_asso = ?";
    $array = BF::request($req,[$this->id],true,false,PDO::FECTH_ASSOC);
    return $array;
  }

  public function liste_membres_noms(){
    /*
    Renvoie la liste des membres de l'asso, ainsi que leur nom, prénom, statut
      */
    $req  = "SELECT users.nom, users.prenom, membres_assos.*
    FROM membres_assos
    INNER JOIN users ON membres_assos.id_user = users.id
    WHERE membres_assos.id_asso = ?";
    $array = BF::request($req,[$this->id],true,false,PDO::FETCH_ASSOC);
    return $array;
  }

  public function prop_association($id_asso) {
      // Sélectionner les propriétés de l'association
      $propAssos = BF::request("SELECT * FROM prop_assos WHERE id_asso = ?", [$id_asso], true, false, PDO::FETCH_ASSOC);

      // Sélectionner les informations de l'association
      $assoInfo = BF::request("SELECT * FROM assos WHERE id = ?", [$id_asso], true, false, PDO::FETCH_ASSOC);

      // Compter les membres de l'association
      $membresCount = BF::request("SELECT COUNT(*) FROM membres_assos WHERE id_asso = ?", [$id_asso], true, true)[0];

      // Vérifier le statut de l'utilisateur dans l'association
      $statut = BF::request("SELECT statut FROM membres_assos WHERE id_asso = ? AND id_user = ?", [$id_asso, $this->id], true, true)[0];

      return array(
          'prop_assos' => $propAssos,
          'asso_info' => $assoInfo,
          'membres_count' => $membresCount,
          'statut' => $statut
      );
  }
  
  /**
   * Crée une asso
   *
   * @param string $association $association [nom asso]
   * @param string $description $description
   * @param string $description_missions $description_missions
   * @param GdImage $logo $logo
   * @param string $email $email
   * @param string $telephone $telephone
   *
   * @return void
   */
  public static function insert_asso($association,$description,$description_missions,$logo,$email,$telephone){
    global $db, $path;
    
      try{
        // On se connecte à la BDD
        $db->beginTransaction();
        // On insère les données reçues dans la table "assos"
        BF::request("INSERT INTO assos (nom, desc, desc_missions, email, tel, logo) VALUES(?, ?, ?, ?, ?, ?)",[$association,$description,$description_missions,$email,$telephone,$logo]);
      
        // Récupérer l'ID de l'association qui vient d'être créée
        
        $id = $db->lastInsertId();
        $db->commit();

        // on récupère les domaines sélectionnés
        $domainesSelectionnes = BF::XSS($_POST["domaine"]);
    
        // on insère les domaines sélectionnés dans la table "domaine_jonction"
        $query = "INSERT INTO domaine_jonction (id_domaine, id_jonction,type) VALUES (?, ?, 1)";
        $stmt = $db->prepare($query);
    
        foreach ($domainesSelectionnes as $idDomaine) {
            $stmt->execute([$idDomaine, $id]);
        }
      
        // on récupère l'adresse de l'asso
        $adresse = $_POST["adresse"];

        // Insérer l'adresse dans la table "lieu"
        BF::request("INSERT INTO lieu (adresse) VALUES(?)",[$adresse]);
        
        // Récupérer l'ID de l'adresse qui vient d'être créée
        $id_lieu = $db->lastInsertId();
        
        // Mettre à jour l'ID de l'adresse dans la table "assos"
        BF::request("UPDATE assos SET id_lieu = ? WHERE id = ?",[$id_lieu,$id]);
      
        //Mettre l'image dans le fichier logo/asso/
        $destinationPath = $path."media/logo/asso/".basename($_FILES['uploadedfile']['name']); 
        $fileNameParts = explode('.',basename($_FILES['uploadedfile']['name']));
        $ext = end($fileNameParts);
        array_map('unlink', glob($path."media/logo/asso/".$id.".*")); //On supprime les fichiers résiduels
        if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $destinationPath)) {
          echo "Le fichier ".  basename( $_FILES['uploadedfile']['name'])." a bien été téléversé";
        } else{
          echo "Il y a eu une erreur pour poster le fichier, réessayez.";
        }
        $newDestinationPath = "media/logo/asso/".$id.".".$ext;
        rename($destinationPath, $path.$newDestinationPath);
      
        //UPDATE le chemin vers l'image dans la BDD
    
        BF::request("UPDATE assos SET logo = ? WHERE id = ?",[$newDestinationPath,$id]);
      
        // Récupérer l'ID de l'utilisateur qui a créé l'association
        $id_utilisateur = $_SESSION["user_id"];
        // Mettre à jour le statut de l'utilisateur en "admin" pour l'association qu'il a créée      
        BF::request("INSERT INTO membres_assos (id_user, id_asso, statut) VALUES (?, ?, 3)",[$id_utilisateur,$id]);
        
      
        
        //On renvoie l'utilisateur vers la page de remerciement
        header('Location:'+BF::abs_path('controller/static/form-merci.php'));
        exit(0);
    }
    catch(PDOException $e){
        echo 'Impossible de traiter les données. Erreur : '.$e->getMessage();
    }
  }
}
?>