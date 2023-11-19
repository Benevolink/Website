import { APIObjet } from './APIObjet.js';


export class Event extends APIObjet{

    constructor(id){
        this.id = id;
    }

    getInfos(){
        return this
        .APICall("event","get_all",{id_event : this.id});
    }

    static insert(date_debut,date_fin,heure_debut,heure_fin,id_asso,nom_event,nb_personnes,visu,desc,departement,adresse){
        array = {
            date_debut : date_debut,
            date_fin : date_fin,
            heure_debut : heure_debut,
            heure_fin : heure_fin,
            id_asso : id_asso,
            nom_event : nom_event,
            nb_personnes : nb_personnes,
            visu : visu,
            desc : desc,
            departement : departement,
            adresse : adresse
        };
        return this
        .APICall("event","insert",{array : array});
    }

    //a partir de id_lieu, id_horaire, id_domaine : déterminer département, date_debut/heure_debut, nom_domaine


}