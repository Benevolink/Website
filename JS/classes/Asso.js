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
            rep.forEach((element)=>{
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
            });    
        })
        //remplacer le forEach en fct de la tête du json
    }

    afficher_details_long(){
        //affichage dans une page à part
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