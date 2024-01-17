var membre_selectionne = -1;
var membre_selectionne_div = null;

// Traque quand un membre est sélectionné
$(".membre_case").click((event) => {
    membre_selectionne = parseInt($(event.target).attr('id_membre'));
    $(event.target).css({
        border: "3px solid black"
    });
    membre_selectionne_div = event.target;
    $(".liste_membres").addClass("mise_en_evidence_missions");
});

// Permet de réinitialiser la sélection
$("body").click((event) => {
    if (!$(event.target).hasClass("membre_case")) {
        if (membre_selectionne_div != null) {
            $(membre_selectionne_div).css({
                border: "0px"
            })
        }
        membre_selectionne = -1;
        membre_selectionne_div = null;
        $(".liste_membres").removeClass("mise_en_evidence_missions");
    }
});

// Gestionnaire d'événement pour le bouton d'aide à la décision
$(".aide_decision_case").click((event) => {
    console.log("Le bouton d'aide à la décision a été cliqué !");

    // Réinitialiser toutes les cases à cocher
    $(".case_membre_mission").prop("checked", false);

    // Cocher aléatoirement les cases selon les missions affectées
    $(".membre_case[id_mission!='-1']").each(function () {
        var idMembre = $(this).attr("id_membre");
        var idMission = $(this).attr("id_mission");

        $(`.case_membre_mission[id_membre='${idMembre}'][id_mission='${idMission}']`).prop("checked", true);
    });
});

// Gestionnaire d'événement pour le changement de l'état de la case à cocher
$(".case_membre_mission").change(function () {
    var idMembre = $(this).attr("id_membre");
    var idMission = $(this).attr("id_mission");

    // Mettez à jour l'affectation du membre à la mission
    $(".membre_case[id_membre='" + idMembre + "']").attr("id_mission", $(this).prop("checked") ? idMission : "-1");
});