import { APIObjet } from './APIObjet.js';
import {Event} from './Event.js';
import {User} from './User.js';

export class Asso extends APIObjet{

    constructor(id){
        super();
        this.id = id;
    }

    getInfos(){
        return this
        .APICall("asso","get_all",{id_asso : this.id});
    }

    getListeEvents(){
        return this
        .APICall("asso","get_all_events",{id_asso : this.id});
    }

    /**
     * Utilisé pour les recherches d'assos
     */
    static getListeAssos(searchEntry){
        return this
        .APICall("asso","search",{recherche : searchEntry});
    }

    

    
    














    //bouger ça ailleurs
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