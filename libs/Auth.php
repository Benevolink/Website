<?php
require_once __DIR__."/../functions/basic_fonctions.php";
require_once BF::abs_path("db.php");
class Auth{
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