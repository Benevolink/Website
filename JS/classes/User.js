export class User{

    constructor(id_user){
        this.id_user = id_user;
    }

    getInfo(info_name){
        return $.ajax({
            url: abs_path("NOMFICHIER.php"),
            method: "POST",
            dataType: "json",
            data: {
                id_asso: this.id_asso
            }
        }).then(function(rep) {
            console.log(rep);
            return rep[info_name];
        });
    }
        
    getNom(){
        this.getInfo("nom");
    }    

    getPrenom(){
        this.getInfo("prenom");
    }    

    getLogo(){
        this.getInfo("logo");
    }    

    getDateNaissance(){
        this.getInfo("date_de_naissance");
    }    

    getEmail(){
        this.getInfo("email");
    }    

    getTel(){
        this.getInfo("tel");
    }    

    getIdLieu(){
        this.getInfo("id_lieu");
    }    

    getAccountStatus(){
        this.getInfo("account_status");
    }       
        
        //a partir de id_lieu : déterminer département
             
}