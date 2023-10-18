<script>
    let id_asso = "<?= $_GET["id_asso"] ?>";
    function reset_compteurs(){
        let compteurs = $('.compteur_reponse').get();
        for(i=0;i<compteurs.length;i++){
            $(compteurs[i]).empty();
            $(compteurs[i]).append(i+" :");
        }
    }
    $('#add_reponse').on("click",(event)=>{
        event.preventDefault();
        $('#reponse_cont').append(
            $('<div>').append([
                $('<div>').css({
                    verticlAligne: "middle",
                    fontWeight: "bold",
                    fontSize: "110%",
                    marginLeft: "10px",
                    marginRight: "10px",
                    width: "30px"
                }).attr({
                    class: "compteur_reponse"
                })
                ,
                $('<input>').css({
                    width: "70%",
                    height: "25px",
                    fontSize: "120%",
                    display: "inline-block",
                    verticalAlign: "middle"
                }).attr({
                    class: "reponse_container"
                }),
                $('<img>').attr({
                    src: abs_path('media/img/croix.jpg')
                }).css({
                    height: "25px",
                    borderRadius: "50%",
                    marginLeft: "10px",
                    verticalAlign: "middle"
                }).on("click",(evenement)=>{
                    $(evenement.target).parent().remove();
                    reset_compteurs();
                })
                
            ]).css({
                marginTop: "10px",
                display: "flex"
            })
        );
        reset_compteurs();
    });
    $('#submit_button').on('click',(event)=>{
        event.preventDefault();
        let list_rep = $('.reponse_container').get();
        if(list_rep.length<2){
            message_alerte("Veuillez proposer au moins 2 choix");
        }else{
            var reponse = "";
            list_rep.forEach((e)=>{
                reponse += $(e).val()+";";
            });
            reponse = reponse.slice(0,-1);

            $('#reponses').attr({
                value: reponse
            });
            console.log("Reponse : "+ reponse);
            $.ajax({
                url: abs_path("functions/ajax/sondage/creer_sondage.php"),
                method: "POST",
                dataType: "json",
                data: {
                    id_asso: id_asso,
                    question: $('#question').val(),
                    reponses: reponse
                }
                
            })
            .done(function(rep){
                console.log(rep);
                if(rep[0]){
                    console.log("Succès !");
                    window.location.href = abs_path("controller/static/form-merci.php");
                }else if(!rep[0]){
                    console.log("Echec");
                    message_alerte("Erreur, veuillez vérifier le contenu du formulaire puis réessayer. Message d'erreur : "+rep[1]);
                }
                
            })
            .fail(function(error){
                alert("La requête s'est terminée en échec. Infos : " + JSON.stringify(error));
                message_alerte("Impossible d'obtenir la liste de vos missions");
            });
        }
    });


</script>