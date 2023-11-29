<link rel="stylesheet" href="<?= BF::abs_path("CSS/categories.css")?>"/>
  <div id = "wrapper_all" style="display: flex;flex-wrap: wrap; margin-top: 30px;">
  <form id="liste_cate">
    <img src="<?= BF::abs_path("media/img/select.jpg") ?>" onclick="retrecir(this);" style="width: 20px; border-radius: 5px;cursor: pointer;"/>
    <div style="display: inline; font-size: 16px; font-weight: bold; padding-left: 20px; text-overflow: ellipsis; overflow: hidden;white-space: nowrap;">Catégories de missions</div>
    <br>
      <?= afficher_categories()?>
  </form>

  <div id="wrapper_all">
    <form id="liste_cate">
        <img src="<?= BF::abs_path("media/img/select.jpg") ?>" onclick="toggleCategories();" style="width: 20px; border-radius: 5px; cursor: pointer;"/>
        <div class="label_cate" onclick="toggleCategories();">Catégories de missions</div>
        <div class="container categories-container" id="categories-container">
            <div class="row">
                <?= afficher_categories() ?>
            </div>
        </div>
    </form>
</div>
    
  </div>

  <script>
    function creer_select_categorie(key, value) {
        return `
            <div class="col-md-3">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input cate_missions_checkbox" id="sel_cate_${key}" name="sel_cate_${key}">
                    <label class="custom-control-label label_cate" for="sel_cate_${key}">${value['nom_domaine']}</label>
                </div>
            </div>
        `;
    }

    function afficher_categories() {
        global $categories;
        $output = "";
        foreach ($categories as $key => $value) {
            $output .= creer_select_categorie($key, $value);
        }
        return $output;
    }

    function toggleCategories() {
        var categoriesContainer = document.getElementById("categories-container");
        categoriesContainer.style.display = (categoriesContainer.style.display === "none" || categoriesContainer.style.display === "") ? "flex" : "none";
    }
</script>