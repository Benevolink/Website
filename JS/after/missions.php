<script type="text/javascript" src="<?= BF::abs_path("JS/aff_miss.js") ?>"></script>
<script>
    $(document).ready(function(){
      import(abs_path('JS/classes/Event.js')).then((module) =>{
        module.Event.getAllEvents().done(function(rep){
          console.log(rep);
        });
      }).catch(function(error){
        console.error("Erreur lors de l'importation du module :",error);
      });
    });
  </script>