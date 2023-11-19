import { APIObjet } from './APIObjet.js';


export class Event extends APIObjet{

    constructor(id){
        this.id = id;
    }

    getInfos(){
        return this
        .APICall("event","get_all",{id_event : this.id});
    }

    static getAllEvents(){
        return this
        .APICallStatic("event","user_get_all",{});
    }

    static insert(array){
        return this.APICallStatic("event","insert",{array : array});
    }


    //a partir de id_lieu, id_horaire, id_domaine : déterminer département, date_debut/heure_debut, nom_domaine


}