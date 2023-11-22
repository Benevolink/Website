import { APIObjet } from './APIObjet.js';

export class User extends APIObjet{

    constructor(id_user){
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

}