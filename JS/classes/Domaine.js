import { APIObjet } from "./APIObjet";


export class Domaine extends APIObjet{
    get_all(){
        return this
        .APICall("domaine","get_all",{});
    }

    insert(nom_domaine){
        return this
        .APICall("domaine","insert",{nom_domaine : nom_domaine});
    }
}