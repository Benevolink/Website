<link rel="stylesheet" href="<?= BF::abs_path("CSS/categories.css")?>"/>

<script>

    function apply_filters() {
        let formFilters = new FormData($("#liste_cate")[0]);
        let array = Object.fromEntries(formFilters.entries());
        console.log(Object.keys(array).length);
        let lst_filters = Array(Object.keys(array).length);
        for(let i = 0; i < Object.keys(array).length; i++){
          lst_filters[i] = document.getElementById(Object.keys(array)[i]).getAttribute('id_domaine');
        }
        console.log(lst_filters);

        import(abs_path('JS/classes/Event.js')).then((module) => {
          module.Event.filter_search(lst_filters).done(function(rep){
          status = rep['statut'];
          console.log(status);
          for (const event in status){
            results = document.getElementById("results");
            new_event = document.createElement("div");
            event_title =document.createElement("h3");
            event_title.innerText = event;

            new_event.appendChild(event_title);
            results.appendChild(new_event);
          }
          }).fail(function(error){
          console.log(error);
          })
        })
    
    }
</script>

  <div id = "wrapper_all" style="display: flex;flex-wrap: wrap; margin-top: 30px;">
  <form id="liste_cate">
    <img src="<?= BF::abs_path("media/img/select.jpg") ?>" onclick="retrecir(this);" style="width: 20px; border-radius: 5px;cursor: pointer;"/>
    <div style="display: inline; font-size: 16px; font-weight: bold; padding-left: 20px; text-overflow: ellipsis; overflow: hidden;white-space: nowrap;">Catégories de missions</div>
    <br>
      <?= afficher_categories()?>
    <input type="submit" value="Appliquer" onclick="apply_filters()">
  </form>

  </div>

  <div id="results">

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