
$(document).ready(()=>{
    import(abs_path("JS/classes/Asso.js")).then((module)=>{
        let asso = new module.Asso(id_asso);
        liste_membres = $("#liste_membres li");
        liste_membres.toArray().forEach(element => {
            id = $(element).attr('id_user');
            select = $(element).children("select").get(0);
            $(select).attr({
                id_user : id
            });
            if(id_user == id){
                $(select).css({
                    cursor: "not-allowed"
                });
                $(select).prop('disabled','disabled');
            }else{
                $(select).on("change",function(event){
                    let id_l =  $(this).attr('id_user');
                    asso.user_modif_statut(id_l,$(select).val()).done((rep)=>{
                        if(!rep["statut"]==1)
                            console.log("Erreur lors de la modification du statut user");
                    }).fail((erreur)=>{
                        console.error("",erreur);
                    });
                    
                })
            }
            asso.user_get_statut(id).done((rep)=>{
                console.log(rep);
                if(rep["statut"]==1){
                    let statut = rep["user_statut"];
                    $(select).val(statut);
                }else{
                    console.log("Erreur");
                }
                
            }).fail((err)=>{
                console.error("",err);
            });
           
        });
    });
})
