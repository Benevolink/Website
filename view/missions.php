<script type="text/javascript" src="<?= BF::abs_path("JS/before/missions.js")?>">
</script>
<script type="text/javascript" src="<?= BF::abs_path("JS/aff_miss.js")?>">
</script>

<div id="bandeau_recherche">
    <div class="titre_bandeau">
        Domaines des missions :
    </div>
    <div id="liste_domaines">
        <?= afficher_categories() ?>
    </div>

    <label for="progressBar">Distance maximale : <div style="display:inline" id="distance_input"> Aucune </div></label>
    <input type="range" id="progressBar" min="0" max="100" value="100" step="1">
    <input type="text" name="recherche" id="recherche_mission_type" placeholder="Rechercher une mission..."/>
    <br>
    <input type="submit" value="Appliquer" id="submit_recherche_mission"/>
</div>
<div id="wrapper_all" style="display: inline">
</div>
<script type="text/javascript" src="<?= BF::abs_path("JS/after/missions.js")?>">
</script>
<script>
    $("#progressBar").on("input",function(event){
        let distance = $(progressBar).val();
        if(distance == 100){
            distance = "Aucune"
        }else{
            distance += " km"
        }
        $("#distance_input").text(distance);
    });

    $("#submit_recherche_mission").on("click",send_recherche);

    $("#recherche_mission_type").on('keydown', function(event) {
    // Vérifier si la touche appuyée est la touche "Entrée" (code 13)
    if (event.key === 'Enter' || event.keyCode === 13) {
      // Effectuer l'action souhaitée lors de l'appui sur Entrée
        $("#submit_recherche_mission").trigger("click");
    }
  });
    function send_recherche()
    {
        let form = $("#bandeau_recherche");
        $("#liste_domaines");
        let sel_cate = form.find(".cate_missions_checkbox:checked");
        let liste_domaines = {};
        $.each(sel_cate,function(index,value){
            liste_domaines[$(value).attr("numero")] = true;
        });
        let distance = $("#progressBar").val();
        if(distance == 100)
        {
            distance = false;
        }
        let recherche = $("#recherche_mission_type").val();
        if(!recherche)
        {
            recherche = false;
        }
        import(abs_path("JS/classes/Event.js")).then((module)=>{
            $("#wrapper_all").empty();
            module.Event.search(distance,recherche,liste_domaines).done((data)=>{
                console.log(data);
                afficher_missions("Resultats de la recherche :",data);
            }).fail((error)=>{
                console.log(error);
            });
        });
        console.log(liste_domaines);
    }
</script>

<style>
    #bandeau_recherche{
        background-color: rgb(245,245,245);
        padding: 10px;
        width: fit-content;
        border-radius: 10px;
        margin: 10px;
    }
    #liste_domaines{
        width:fit-content;
        padding: 10px;
        border-radius: 10px;
    }
    .titre_bandeau{
        font-size: 130%;
        font-weight: bold;
    }
    #progressBar{
        width: 200px;
    }
</style>