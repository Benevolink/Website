
<link rel="stylesheet" href="<?= BF::abs_path("CSS/categories.css")?>"/>
  <div class="col-md-4" id = "wrapper_all" style="display: flex;flex-wrap: wrap; margin-top: 30px; border: 1px solid #000; box-sizing: border-box; ">
  <form id="liste_cate">
    <img src="<?= BF::abs_path("media/img/select.jpg") ?>" onclick="retrecir(this);" style="width: 20px; border-radius: 5px;cursor: pointer;"/>
    <div id="cat_mission" style="display: inline; font-size: 18px; font-weight: bold; padding-left: 20px; text-overflow: ellipsis; overflow: hidden;white-space: nowrap; ">Catégories de missions</div>
    <br>
    <br>
      <?= afficher_categories()?>
  </form>

  
    
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

<style>

    #cat_mission{

    font-family: Corps;
      font-weight: bold;
      src: url(fonts/Nexa-Heavy.woff2) format("woff2");
    }

    #liste_cate{
        font-family: Corps;
      src: url(fonts/Nexa-Heavy.woff2) format("woff2");
    }

