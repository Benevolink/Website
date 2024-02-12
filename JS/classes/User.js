import { APIObjet } from './APIObjet.js';

export class User extends APIObjet{

    constructor(id_user=null){
        super();
        this.id_user = id_user;
    }

    getInfos(){
        return this
        .APICall("user","get_all",{id_user : this.id});
    }

        //a partir de id_lieu : déterminer département
      
    getEvents(){
        return this
        .APICall("event","user_get_all",{id_user : this.id});
    }

    getLogo(){
        return this.
        APICall("user","get_pp",{});
    }

    getListeInvitationsMissions(){
        return this.
        APICall("user","liste_invitations_missions",{});
    }

    sendReponseInvitMission(id_event, reponse){
        return this.
        APICall("user","reponse_invit_mission",{id_event: id_event, reponse: reponse});
    }

    get_disponibilites()
    {
        return this.
        APICall("user","get_all_horaires",{});
        
    }

    sendDisponibilites(disponibilites)
    {
        return this.
        APICall("user","set_disponibilites",{"disponibilites" :  disponibilites});
    }

    get_all_competences()
    {
        return this.
        APICall("user","get_all_comp",{});
    }

    get_all_interets()
    {
        return this.
        APICall("user","get_all_interets",{});
    }

    send_interets(liste_ids)
    {
        return this.
        APICall("user","ajouter_interets",{liste_interets: liste_ids});
    }

    get_all_liste_competences()
    {
        return this.
        APICall("user","get_all_liste_comp",{});
    }

    send_comp(liste_id_comp_ajout)
    {
        return this.
        APICall("user","ajouter_competences",{liste_competences_ajout: liste_id_comp_ajout});
    }

    static setLogo(file_content){
        let data = new FormData();
        data.append("photo_profil",file_content);
        data.append("type","user");
        data.append("fonction","set_pp");
        return $.ajax({
            url: abs_path("API/index.php"),
            method: "POST",
            dataType: "json",
            data: data,
            contentType: false,
            processData: false,
        });
        
    }




}