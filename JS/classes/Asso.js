import {Event} from './Event.js';
import {User} from './User.js';

export class Asso{

    constructor(id_asso){
        this.id_asso = id_asso;
    }

    getInfo(info_name){
        return $.ajax({
            url: abs_path("NOMFICHIER.php"),
            method: "POST",
            dataType: "json",
            data: {
                id_asso: this.id_asso
            }
        }).then(function(rep) {
            console.log(rep);
            return rep[info_name];
        });
    }

    getName(){
        return this.getInfo("nom");
        }
    

    getLogo(){
        return this.getInfo("logo");
        }
    

    getDesc(){
        return this.getInfo("desc");
        }
    

    getDescMissions(){
        return this.getInfo("desc_missions");
        }
    
    
    getEmail(){
        return this.getInfo("email");
        }
    

    getTel(){
        return this.getInfo("tel");
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