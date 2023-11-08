import {Event} from './Event.js';
import {User} from './User.js';

export class Asso{

    constructor(id_asso){
        this.id_asso = id_asso;
    }

    afficher_details_court(){
        //ajax pour récupérer le tableau puis affichage
        $.ajax({
            url: abs_path("NOMFICHIER.php"),
            method: "POST",
            dataType: "json",
            data: {
                id_asso: this.id_asso
            }
        }).done(function(rep){
            console.log(rep);
            //détailler l'affichage paramètre par paramètre : nom, logo
            var nom_asso = rep.nom;
            var logo_asso = rep.logo;
            //ajouter bien au HTML
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

    afficher_details_long(reponse){
        //affichage dans une page à part on click
        //on part de la rep et on affiche un peu comme details courts avec des trucs en plus/+grand

        //détailler l'affichage paramètre par paramètre : nom, desc, desc_missions, id_lieu, email, tel, logo
        var nom_asso = reponse.nom;
        var logo_asso = reponse.logo;
        var desc_asso = reponse.desc;
        var desc_missions_asso = reponse.desc_missions;
        var email_asso = reponse.email;
        var tel_asso = reponse.tel;
        var id_lieu_asso = reponse.id_lieu;
        //a partir de id_lieu : déterminer département

        //ajouter bien au HTML
        main.append(
            $('<div>').css({
                cursor: "pointer",
                margin: "10px",
                backgroundColor: "rgb(245,245,245)",
                width: "600px",
                borderRadius: "3px",
                padding: "10px"
            })
        );

    }

    afficher_liste_events(){
        //ajax pour récupérer liste events puis appel à la classe Event pour afficher
        $.ajax({
            url: abs_path("NOMFICHIER.php"),
            method: "POST",
            dataType: "json",
            data: {
                id_asso: this.id_asso
            }
        }).done(function(rep){
            console.log(rep);
            rep.forEach((element)=>{
            element.afficher_event_court();
        });    
        })
    }

    afficher_liste_membres(){
        //ajax pour récupérer liste membres puis appel à la classe User pour afficher
        $.ajax({
            url: abs_path("NOMFICHIER.php"),
            method: "POST",
            dataType: "json",
            data: {
                id_asso: this.id_asso
            }
        }).done(function(rep){
            console.log(rep);
            rep.forEach((element)=>{
            element.afficher_profil_court();
        });    
        })
    }


}