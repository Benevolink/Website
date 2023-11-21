

import(abs_path("JS/classes/Asso.js")).then((module)=>{
    let asso = new module.Asso(id_event);
    liste_membres = $("#liste_membres li");
    liste_membres.toArray().forEach(element => {
        select = 
        $(element).on({
            id = $(element).attr('id_user');
            asso.user_modif_statut(id,)
        })
    });
})