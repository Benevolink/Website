<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>

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

