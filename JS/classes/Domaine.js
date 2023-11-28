import {APIObjet} from './APIObjet.js';


export class Domaine extends APIObjet{
    static get_all(){
        return Domaine
        .APICallStatic("domaine","get_all",{});
    }

    static insert(nom_domaine){
        return Domaine
        .APICallStatic("domaine","insert",{nom_domaine : nom_domaine});
    }
}