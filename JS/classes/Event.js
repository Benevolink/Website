import { APIObjet } from './APIObjet.js';


export class Event extends APIObjet{

    constructor(id){
        super();
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

    user_join(){
        return this.APICall("event","join",{id_event : this.id});
    }

    user_leave(){
        return this.APICall("event","leave",{id_event : this.id});
    }

    user_statut(){
        return this.APICall("event","user_statut",{id_event : this.id});
    }
    

}