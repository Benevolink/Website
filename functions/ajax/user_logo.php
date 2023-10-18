<?php
require_once "../basic_functions.php";
BF::sess_start();
header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8" ?>';
?>
<data>
<?php
if(BF::is_connected() && glob("../../media/logo/user/".$_SESSION["user_id"].".*")){
     foreach (glob("../../media/logo/user/".$_SESSION["user_id"].".*") as $filename) {
     ?>
     <response>
       <?= BF::abs_path($filename) ?>
     </response>
     <?php
     }
     /*if(@is_array(getimagesize($mediapath))){
       $image = true;
      } else {
        $image = false;
      }*/
}else{
  ?>
  <response>
    <?= BF::abs_path("media/img/user_anonyme.jpg") ?>
  </response>
  <?php
}

?>
</data>