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
}
?>