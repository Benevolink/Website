import { APIObjet } from './APIObjet.js';

export class User extends APIObjet{

    constructor(id_user){
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

    static setLogo(file_content){
        let data = new FormData();
        data.append("id_user",this.id);
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