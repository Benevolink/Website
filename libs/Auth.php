<?php
require_once __DIR__."/../functions/basic_fonctions.php";
require_once BF::abs_path("db.php");
/**
 * Classe qui gère l'authentification.
 */
class Auth{  
  /**
   * Vérifie que le mot de passe est bon
   *
   * @param string $email $email [email utilisateur]
   * @param string $pw $pw [mot de passe (en clair)]
   *
   * @return bool
   */
  public static function verif_pw($email,$pw){
    $req = "SELECT mdp FROM users WHERE email = ?";
    $mdp = BF::request($req,[$email],true,true);
    if(isset($mdp[0]) && password_verify($pw,$mdp[0])){
      return true;
    }
    return false;
  }
}
?>