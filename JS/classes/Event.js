export class Event{

    constructor(id_event){
        this.id_event = id_event;
    }

    afficher_event_court(){
        //ajax pour récupérer infos event puis affichage
        $.ajax({
            url: abs_path("NOMFICHIER.php"),
            method: "POST",
            dataType: "json",
            data: {
                id_event: this.id_event
            }
        }).done(function(rep){
            console.log(rep);
            //détailler l'affichage paramètre par paramètre : nom_event
            var nom_event = rep.nom_event;

            //afficher bien HTML
            main.append(
                $('<div>').css({
                    cursor: "pointer",
                    margin: "10px",
                    backgroundColor: "rgb(245,245,245)",
                    width: "600px",
                    borderRadius: "3px",
                    padding: "10px"
                })
                //ajouter un on click : afficher en grand
            );
        })
        
    }

    afficher_event_long(reponse){
        //affichage dans une page à part on click
        //on part de la rep et on affiche un peu comme details courts avec des trucs en plus/+grand

        //détailler l'affichage paramètre par paramètre : nom_event, desc, visu, id_lieu, nb_personnes, id_horaire, id_domaine
        var nom_event_event = reponse.nom_event;
        var desc_event = reponse.desc_event;
        var visu_event = reponse.visu;
        var id_lieu_event = reponse.lieu_event;
        var nb_personnes_event = reponse.nb_personnes;
        var id_horaire_event = reponse.id_horaire;
        var id_domaine_event = reponse.id_domaine;

        //a partir de id_lieu, id_horaire, id_domaine : déterminer département, date_debut/heure_debut, nom_domaine

        //afficher bien HTML
        main.append(
            $('<div>').css({
                cursor: "pointer",
                margin: "10px",
                backgroundColor: "rgb(245,245,245)",
                width: "600px",
                borderRadius: "3px",
                padding: "10px"
            })
            //ajouter un on click : afficher en grand
        );
    }

}