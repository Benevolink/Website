<script type="text/javascript" src="<?= BF::abs_path("JS/aff_miss.js") ?>"></script>
<script>
    $(document).ready(function(){
      $.ajax({
        url: abs_path("functions/ajax/liste_missions.php"),
        method: "GET",
        dataType: "json",
        
      })
      .done(function(rep){
        console.log(rep);
        afficher_missions("Mes missions",rep);
        ajouter_events_missions();
      })
      .fail(function(error){
        alert("La requête s'est terminée en échec. Infos : " + JSON.stringify(error));
        message_alerte("Impossible d'obtenir la liste de vos missions");
      });
    });
  </script>