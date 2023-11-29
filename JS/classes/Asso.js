import { APIObjet } from './APIObjet.js';
import {Event} from './Event.js';
import {User} from './User.js';


export class Asso extends APIObjet{

    constructor(id){
        super();
        this.id = id;
        console.log("OK");
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

    
    user_modif_statut(id_user,nouveau_statut){
        return this.APICall("asso","user_modif_statut",{id_asso : this.id, id_user : id_user, nouveau_statut : nouveau_statut});
    }

    user_get_statut(id_user){
        return this.APICall("asso","user_get_statut",{id_asso : this.id, id_user : id_user});
    }
    
    static insert(nom,desc,desc_missions,file_content,adresse,email,tel){
        let params = {nom : nom, desc : desc, missionsProposees : desc_missions, adresse : adresse, email : email, tel : tel};
        let data = new FormData();
        for(let cle in params){
            data.append(cle,params[cle]);
        }
        console.log(file_content);
        data.append("logoAssociation",file_content);
        data.append("type","asso");
        data.append("fonction","insert");
        return $.ajax({
            url: abs_path("API/index.php"),
            method: "POST",
            dataType: "json",
            data: data,
            contentType: false,
            processData: false,
        });
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