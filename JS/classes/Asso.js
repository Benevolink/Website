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
        .APICallStatic("asso","search",{recherche : searchEntry});
    }

    static getListeAssosIntegrees(searchEntry){
        return this
        .APICallStatic("asso","get_assos_integrees",{recherche : searchEntry});
    }

    static getListeAssosEnAttente(searchEntry){
        return this
        .APICallStatic("asso","get_assos_en_attente",{recherche : searchEntry});
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


    get_logo(){
        return this.APICall("asso","get_logo",{id_asso: this.id});
    }




    user_join(){
        return this.APICall("asso","user_join",{id_asso: this.id});
    }

    user_leave(){
        return this.APICall("asso","user_leave",{id_asso: this.id});
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