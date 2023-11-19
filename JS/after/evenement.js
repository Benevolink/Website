var bouton_rejoindre = $("#bouton_rejoindre");
var id_event = $("#value_id_event").val();

function quitter_event(){
    import(abs_path('JS/classes/Event.js')).then((module)=>{
        let event = new module.Event(id_event);
        event.user_leave().done(function(data){
            $("#bouton_rejoindre").click((event)=>{
                event.preventDefault();
                rejoindre_event();
            });
            $("#bouton_rejoindre").text("Rejoindre");
        }).fail((error)=>{
            console.log(error);
        });
    }).catch((error)=>{
        console.error("Erreur d'importation :",error);
    });
}

function rejoindre_event(){
    import(abs_path('JS/classes/Event.js')).then((module)=>{
        let event = new module.Event(id_event);
        event.user_join().done(function(data){
            $("#bouton_rejoindre").click((event)=>{
                event.preventDefault();
                quitter_event();
            });
            $("#bouton_rejoindre").text("Quitter");
        }).fail((error)=>{
            console.log(error);
        });
    }).catch((error)=>{
        console.error("Erreur d'importation :",error);
    });
}


$(document).ready((event)=>{
    
    import(abs_path('JS/classes/Event.js')).then((module)=>{
        let event = new module.Event(id_event);
       
        event.user_statut().done(function(data){
            console.log(data);
            if(data["statut"] == 0){console.log("Erreur");}
            if(data["user_statut"] != false){
                $("#bouton_rejoindre").text("Quitter");
                $("#bouton_rejoindre").click((event)=>{
                    event.preventDefault();
                    quitter_event();
                });
            }else{
                $("#bouton_rejoindre").on("click",(event)=>{
                    event.preventDefault();
                    rejoindre_event();
                });
                $("#bouton_rejoindre").text("Rejoindre");
            }
        }).fail((error)=>{
            console.log(error);
        });
    }).catch((error)=>{
        console.error("Erreur d'importation :",error);
    });
});