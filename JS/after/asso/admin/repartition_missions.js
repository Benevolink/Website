

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

// gestionnaire d'événement pour le bouton d'aide à la décision
$(".aide_decision_case").click((event) => {
    console.log("Le bouton d'aide à la décision a été cliqué omg !");

    // Déplacer tous les membres de la liste des membres non affectés vers des événements de manière aléatoire
    var membresNonAffectes = $("#liste_membres_default .membre_case");
    var listeMembresAffectes = $("#liste_membres_affectes");

    membresNonAffectes.each(function () {
        // Obtenez une liste des événements disponibles
        var evenementsDisponibles = $(".liste_membres:not(.liste_membres_affectes)");
        if (evenementsDisponibles.length > 0) {
            // Choisissez un événement de manière aléatoire
            var evenementAleatoire = evenementsDisponibles.eq(Math.floor(Math.random() * evenementsDisponibles.length));

            // Mettez à jour l'ID du membre pour refléter l'affectation à l'événement
            var idMission = evenementAleatoire.attr("id_mission");
            $(this).attr("id_mission", idMission);

            // Ajoutez le membre à la liste des membres affectés
            listeMembresAffectes.append($(this));

            console.log("Membre associé à id_mission :", idMission);
        }
    });

    // Réinitialiser la sélection et le style des membres
    membresNonAffectes.css({ border: "0px" });
    $(".liste_membres").removeClass("mise_en_evidence_missions");

    // Mettez à jour les membres dans la liste des missions
    $(".liste_membres_affectes .membre_case").each(function () {
        var idMembre = $(this).attr("id_membre");
        var idMission = $(this).attr("id_mission");

        // Mettez à jour l'affichage des membres dans la liste des missions
        var missionList = $(".liste_membres[id_mission='" + idMission + "']");
        missionList.append($(this));

        console.log("Membre déplacé dans la mission avec id_mission :", idMission);
    });
});
