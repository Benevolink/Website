<?php
require_once "../../links.php";
header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8" ?>';



if(BF::is_posted(["email","mdp"])){//On vérifie que les variables sont bien définies
  //On récupère le mdp de l'utilisateur dans la bdd
  $email = $_GET["email"];
  $mdp = $_GET["mdp"];
  $req = "SELECT mdp FROM users WHERE email=:email";
  $req_temp = $db->prepare($req);
  $req_temp->bindParam(":email",$email);
  $req_temp->execute();
  $table = $req_temp->fetchAll();
  if(isset($table[0][0]) && password_verify($mdp,$table[0][0])){
    //Si l'email et le mdp correspondent, on affecte les variables de $_SESSION à l'utilisateur
    session_regenerate_id(true);//Ne pas oublier de renvoyer une id pour éviter les attaques par id statique
    $_SESSION["auth"]=1;
    $req = "SELECT id FROM users WHERE email =:email";
    $table2 = $db->prepare($req);
    $table2->bindParam(":email",$email);
    $table2->execute();
    $table2=$table2->fetchAll();
    $_SESSION["user_id"] = $table2[0][0];
    
  }else{
    //Sinon on met la variable à  pour montrer qu'il est déconnecté
    $_SESSION["auth"] = 0;
  }
  ?>
  <data>
      <response>
          <?= $_SESSION["auth"] ?>
      </response>
  </data>
  <?php
}else{
  ?>
  <data>
      <response>
      <?php
  
        if(isset($_SESSION["auth"])){
         echo $_SESSION["auth"];
        }else{
          echo 0;
        }?>
      </response>
  </data>
  <?php
}
?>