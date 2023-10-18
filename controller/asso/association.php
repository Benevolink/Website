<?php
 /*function afficher_event($value){
    global $path;
    ?>
    <div>
      <?= BF::XSS($value["nom_event"]) ?>
      <?php 
        $res = BF::request("SELECT valeur FROM prop_evenements WHERE id_event = ? AND prop_nom = ?",[$value["id"],"logo"],true);
        if(isset($res[0][0]) && BF::equals($res[0][0],"TRUE")){
          foreach (glob($path."media/logo/event/".$value["id"].".*") as $filename){
            ?>
              <img style ="width: 200px;" src="<?= BF::abs_path("media/logo/event/".basename($filename)) ?>">
          <?php
          }
          
        }
      ?>
    </div>
    <?php
  }*/
$file_name = "/asso/".basename(__FILE__);
require_once __DIR__.'/../../links.php';
?>