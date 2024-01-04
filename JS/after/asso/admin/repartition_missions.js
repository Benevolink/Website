

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
        $(".mission_a_remplir").addClass("mise_en_evidence_missions");
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
            $(".mission_a_remplir").removeClass("mise_en_evidence_missions");
        }
    }
);