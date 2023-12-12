<script type="text/javascript" src="<?= BF::abs_path("JS/aff_miss.js") ?>"></script>
<script type="text/javascript" src="<?= BF::abs_path("JS/aff_sondages.js") ?>"></script>
<script>
  // le JS permet ici de suivre si l'utilisateur a bien coché la case pour suivre ou rejoindre l'asso
  //le ajax permet de réactualiser la case cochée par l'utilisateur
  id_asso = <?= $_GET["id"] ?>;
  /*function follow(){
    let xhttp = new XMLHttpRequest();
    xhttp.open("GET", "functions/ajax/follow_join.php?id_asso="+id_asso+"&mode=0");
    xhttp.onload = function() {
      document.getElementById("followed").checked = !document.getElementById("followed").checked;
    }
    xhttp.send();
  }*/
  function join(){
    import(abs_path("JS/classes/Asso.js")).then((module)=>{
      let asso = new module.Asso(id_asso);
      asso.user_join().done((rep)=>{
        console.log(rep);
      }).fail((err)=>{
        console.log(err);
      })
    });
  }



  $(document).ready(function(){


    import(abs_path('JS/classes/Asso.js')).then((module)=>{
      let asso = new module.Asso(id_asso);
      asso.getListeEvents().done(function(data){
        console.log(data);
        afficher_missions("Missions en cours ou à venir :",data);
        ajouter_events_missions();
      }).fail(function(error){
        alert("La requête s'est terminée en échec. Infos : " + JSON.stringify(error));
        message_alerte("Impossible d'obtenir la liste de vos missions");
      });
    });
        
      
  });
</script>
