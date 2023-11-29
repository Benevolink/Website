<?php
  $a_jour = true;
  require_once 'links.php';
  
  BF::sess_start();
  ob_start();
  $file_name = "asso/admin/".basename(__FILE__);
  if(isset($_GET["id_asso"]) && BF::is_connected()){
    $id_asso = $_GET["id_asso"];
    require_once BF::abs_path("libs/User.php",true);
    $user = new User();
    if($user->est_admin_asso($id_asso)){
      require_once BF::abs_path("model/".$file_name,true);
      require BF::abs_path("view/".$file_name,true);
    }else{
      header("Location: ".BF::abs_path("",true));
      BF::go_home();
    }
  }else{
    BF::go_home();
  }
  BF::afficher_template(ob_get_clean());
  
?>



