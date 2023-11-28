<?php
function creer_select_categorie($key,$value){
  ?>
  <input type="checkbox" name="<?= "sel_cate_{$key}"?>" id="<?= "sel_cate_{$key}" ?>" class="cate_missions_checkbox"/>
  <div class="label_cate"> <?= $value['nom_domaine'] ?> </div>
  <?php
}

function afficher_categories(){
  global $categories;
  foreach($categories as $key => $value){
    creer_select_categorie($key,$value);
  }
}
?>
