<?php
require_once "../../links.php";
header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8" ?>';

echo  json_encode($array,JSON_UNESCAPED_UNICODE);
if(BF::is_posted(["pseudo","email","tel","mdp"])){
  //Si toutes les variables existent
  $email = $_POST["email"];
  $pseudo = $_POST["pseudo"];
  $tel = $_POST["tel"];
  $mdp = $_POST["mdp"];
  //Tout d'abord vérifions que l'email correspond bien à un email
  if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    //Si l'email n'est pas valide on renvoie le code 3
    ?>
    <data>
      <response>
          3
      </response>
    </data>
    <?php
    exit(0);
  }
    
  //On vérifie que l'email n'est pas déjà utilisé-
  $req = "SELECT COUNT(*) FROM users WHERE email= :email";
  $req = $db->prepare($req);
  $req->bindParam(":email",$email);
  $req->execute();
  $table = $req->fetchAll();
  if($table[0][0] == 0){
    //Si l'email n'est pas utilisé
    $mdp_hashed =password_hash($mdp, PASSWORD_DEFAULT);
    $req = "INSERT INTO users (pseudo,email,mdp,tel) VALUES (:pseudo,:email,:mdp_hashed,:tel)";
    $req = $db->prepare($req);
    $req->bindParam(":pseudo",$pseudo);
    $req->bindParam(":email",$email);
    $req->bindParam(":mdp_hashed",$mdp_hashed);
    $req->bindParam(":tel",$tel);

    $req->execute();
    $_SESSION["auth"] = 1;
    $req = "SELECT id FROM users WHERE email='".$_POST["email"]."'";
    $req = $db->prepare($req);
    $req->execute();
    $table = $req->fetchAll();
    $_SESSION["user_id"]=$table[0][0];

    ?>
    <data>
      <response>
          1
      </response>
    </data>
    <?php
    
  }else{ //Si l'email est utilisé
    ?>
    <data>
      <response>
          2
      </response>
    </data>
    <?php
  }
}else{
  ?>
  <data>
    <response>
        0
    </response>
  </data>
  <?php
}
?>
<?php
?>