<?php
function creer_select_categorie($key,$value){
  $id = $value["id_domaine"];
  ?>
  <input type="checkbox" name="<?= "sel_cate_{$id}"?>" id="<?= "sel_cate_{$id}" ?>" class="cate_missions_checkbox" checked="checked" numero="<?= $id ?>"/>
  <div class="label_cate" style="display : inline"> <?= $value['nom_domaine'] ?> </div>
  <br>
  <?php
}

function afficher_categories(){
  global $categories;
  foreach($categories as $key => $value){
    creer_select_categorie($key,$value);
  }
}
?>
