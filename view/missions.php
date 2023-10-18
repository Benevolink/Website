<link rel="stylesheet" href="<?= BF::abs_path("CSS/categories.css")?>"/>
  <div id = "wrapper_all" style="display: flex;flex-wrap: wrap; margin-top: 30px;">
  <form id="liste_cate">
    <img src="<?= BF::abs_path("media/img/select.jpg") ?>" onclick="retrecir(this);" style="width: 20px; border-radius: 5px;cursor: pointer;"/>
    <div style="display: inline; font-size: 16px; font-weight: bold; padding-left: 20px; text-overflow: ellipsis; overflow: hidden;white-space: nowrap;">Catégories de missions</div>
    <br>
      <?= afficher_categories()?>
  </form>
    
  </div>
