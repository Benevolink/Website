<?php
$a_jour = true;
ob_start();
$file_name = "gestion_compte/".basename(__FILE__);
require_once __DIR__.'/../../links.php';
if(BF::is_connected()){
  require_once BF::abs_path("libs/User.php",true);
  require_once BF::abs_path("JS/abs_path.php",true);
  require_once BF::abs_path("JS/before/".$file_name,true);
  $user = new User();
  $table = $user->all_infos();
  
  require_once BF::abs_path("model/".$file_name,true);
  require_once BF::abs_path("view/".$file_name,true);
  require_once BF::abs_path("JS/after/".$file_name,true);
  $content = ob_get_clean();
  require_once BF::abs_path("view/template.php",true);
}
?>