<script src="https://www.gstatic.com/charts/loader.js"></script>
<script>
    var user_rep = -1;
    google.charts.load('current',{packages:['corechart']});
   
    function afficher_reponse(index_r){
        let liste = $('.reponse_select').get();
        liste.forEach((element,index)=>{
            if(index==index_r){
                $(element).css({
                    color: "white",
                    backgroundColor: "var(--couleur-vert-valid)"
                });
            }else{
                $(element).css({
                    color: "black",
                    backgroundColor: "rgb(245,245,245)"
                });
            }
        });
    }
    function refresh_graph(table,variables,titre){
        let reponses = variables.split(';');
            
            var data = new google.visualization.DataTable();
            data.addColumn('string','Reponse');
            data.addColumn('number','occurence');
            reponses.forEach((element,index)=>{
                data.addRow([element,parseInt(table[index])]);
            });
            //Set Options
            const options = {
            title: titre
            };
            const chart = new google.visualization.PieChart(document.getElementById('myChart'));
            chart.draw(data, options);
    }
    $(document).ready(function(){
        $.ajax({
            url: abs_path('functions/ajax/sondage/resultat_sondage.php'),
            method: "GET",
            dataType:"json",
            data: {
                id_sondage: "<?= $_GET["id_sondage"] ?>"
            }
        }).done(function(rep){
            console.log(rep);
             // Set Data
            var variables = rep[0]["reponses"];
            var titre = rep[0]["question"];
            let reponses = variables.split(';');
            let table = [];
            var data = new google.visualization.DataTable();
            data.addColumn('string','Reponse');
            data.addColumn('number','occurence');
            $('#select_response').append("Réponses :");
            reponses.forEach((element,index)=>{
                data.addRow([element,parseInt(rep[index+1])]);
                table.push(rep[index+1]);
                $('#select_response').append(
                    $('<div>').append([
                        element
                    ]).css({
                        padding: "10px",
                        fontSize: "110%",
                        fontWeight: "bold",
                        borderRadius: "4px",
                        backgroundColor: "rgb(245,245,245)",
                        margin: "10px",
                        width: "auto",
                        cursor: "pointer"
                    }).attr({
                        class: "reponse_select"
                    }).on("click",(event)=>{
                        $.ajax({
                            url: abs_path("functions/ajax/sondage/repondre_sondage.php"),
                            method: "POST",
                            dataType: "json",
                            data:{
                                id_sondage: "<?= $_GET["id_sondage"] ?>",
                                reponse: index
                            }
                        }).done(function(rep){
                            if(rep[0]){
                                if(user_rep>-1){
                                    table[user_rep]--;
                                }
                                user_rep = index;
                                table[user_rep]++;
                                afficher_reponse(index);
                                refresh_graph(table,variables,titre);
                            }else if(!rep[0]){
                                message_alerte("Une erreur est survenue, veuillez réessayer.");
                            }
                        }).fail(function(error){
                            console.log(error);
                        });
                    })
                )
            });
            $('#select_response').css({
                width: "max-content",
                minWidth: "300px",
                maxWidth: "80svw",
                margin: "20px",
                padding: "20px",
                backgroundColor:"rgb(252,252,252)",
                fontSize: "120%",
                fontWeight: "bolder"
            });
            //On regarde si oui ou non l'utilisateur a déjà voté
            if(reponses.length+2==rep.length){
                user_rep = rep.pop();
                afficher_reponse(user_rep);
            }
            //Set Options
            const options = {
            title: titre
            };
            const chart = new google.visualization.PieChart(document.getElementById('myChart'));
            chart.draw(data, options);


        }).fail(function(error){

        })
    });
</script>