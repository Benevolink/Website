function set_event_listeners(liste_membres,asso){
    liste_membres.toArray().forEach(element => {
        let id = $(element).attr('id_user');
        let select = $(element).find("select").get(0);
        $(select).attr({
            id_user : id
        });
        if(id_user == id){
            $(select).css({
                cursor: "not-allowed"
            });
            $(select).prop('disabled','disabled');
            $(element).find(".glyphicon-trash").css({
                cursor: "not-allowed"
            }).off();
        }else{
            $(select).on("change",function(event){
                asso.user_modif_statut(id,$(select).val()).done((rep)=>{
                    console.log("Succès du changement de statut !");
                    if(!rep["statut"]==1)
                        console.log("Erreur lors de la modification du statut user");
                }).fail((erreur)=>{
                    console.error("Erreur lors du changement de statut : ",erreur);
                });
                
            })
        }
        asso.user_get_statut(id).done((rep)=>{
            console.log(rep);
            console.log(id);
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
}

function supp_membre(id_membre){
    import(abs_path("JS/classes/Asso.js")).then((module)=>{
        let asso = new module.Asso(id_asso);
        asso.user_suppr(id_membre).done((data)=>{
            console.log(data);
            if(data["statut"]==1){
                location.reload();
            }
        }).fail((error)=>{
            console.log(error);
        });
    });
}



$(document).ready(()=>{
    import(abs_path("JS/classes/Asso.js")).then((module)=>{
        let asso = new module.Asso(id_asso);
        liste_membres = $("#liste_membres li");
        set_event_listeners(liste_membres,asso);
        set_event_listeners($("#liste_attente li"),asso);
    });
    $(".modal_suppr_conf").each((index,element)=>{
        $(element).click((event)=>{
            supp_membre($(element).attr("id_user"));
        })
    })
    
})
