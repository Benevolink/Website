

var membre_selectionne = -1;
var membre_selectionne_div = null;
//Traque quand un membre est selectionné
$(".membre_case").click(
    (event)=>{
        membre_selectionne = parseInt($(event.target).attr('id_membre'));
        $(event.target).css({
            border: "3px solid black"
        });
        membre_selectionne_div = event.target;
        $(".liste_membres").addClass("mise_en_evidence_missions");
    }
);


//Permet de réinitialiser la sélection
$("body").click(
    (event)=>{
        if(!$(event.target).hasClass("membre_case"))
        {
            if(membre_selectionne_div != null)
            {
                $(membre_selectionne_div).css({
                    border: "0px"
                })
            }
            membre_selectionne = -1;
            membre_selectionne_div = null;
            $(".liste_membres").removeClass("mise_en_evidence_missions");
        }
    }
);

$(".liste_membres").click((event)=>{
    
    if($(event.target).hasClass("mise_en_evidence_missions"))
    { 
        if($(event.target).hasClass("mission_a_remplir "))
        {
            $(membre_selectionne_div).attr({
                id_mission: $(event.target).attr('id_mission')
            });
        }else{
            $(membre_selectionne_div).attr({
                id_mission: -1//Aucune mission affectée
            });
        }
        
        $(event.target).append($(membre_selectionne_div));
        
    }
});