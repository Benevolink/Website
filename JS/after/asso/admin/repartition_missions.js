

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

// gestionnaire d'événement pour le bouton d'aide à la décision
$(".aide_decision_case").click((event) => {
    console.log("Le bouton d'aide à la décision a été cliqué !");

        // Déplacer tous les membres de la liste des membres non affectés vers la liste des membres affectés
    var listeMembresAffectes = $("#liste_membres_affectes");
    var membresNonAffectes = $("#liste_membres_default .membre_case");

    // Afficher le contenu de membresNonAffectes avant le déplacement
    console.log("Contenu de membresNonAffectes avant le déplacement :", membresNonAffectes.html());

    // Ajouter tous les membres à la liste des membres affectés
    listeMembresAffectes.append(membresNonAffectes.children());

    // Réinitialiser la sélection et le style des membres
    membresNonAffectes.css({ border: "0px" });
    $(".liste_membres").removeClass("mise_en_evidence_missions");

    // Afficher le contenu individuel de chaque membre dans la listeMembresAffectes dans la console
    console.log("Contenu de listeMembresAffectes après le déplacement :");
    listeMembresAffectes.children().each(function() {
        console.log($(this).html());
    });

});

