var membresAffectations = {}; // Tableau pour stocker les affectations des membres

// Fonction pour réinitialiser l'état des cases
function reinitialiserCases() {
    $(".case_membre_mission").prop("checked", false);
    membresAffectations = {}; // Réinitialiser le tableau des affectations
}

// Fonction pour cocher aléatoirement une case par membre
function cocherAleatoirement() {
    $(".membre_case").each(function () {
        var idMembre = $(this).attr("id_membre");
        var missionsDisponibles = $(".case_membre_mission[id_membre='" + idMembre + "']").toArray();

        console.log("idMembre:", idMembre);
        console.log("missionsDisponibles:", missionsDisponibles);

        if (missionsDisponibles.length > 0) {
            var missionAleatoire = missionsDisponibles[Math.floor(Math.random() * missionsDisponibles.length)];

            console.log("missionAleatoire:", missionAleatoire);

            $(missionAleatoire).prop("checked", true);

            // Mettez à jour l'affectation du membre à la mission
            $(".membre_case[id_membre='" + idMembre + "']").attr("id_mission", $(missionAleatoire).attr("id_mission"));
        }
    });
}


// Gestionnaire d'événement pour le bouton d'aide à la décision
$(".aide_decision_case").click((event) => {
    console.log("Le bouton d'aide à la décision a été cliqué !");
    reinitialiserCases();

    // Utilisez la variable listeMembres directement
    listeMembres.forEach(function(member) {
        var idMembre = member.id;
        var missionsDisponibles = $(".case_membre_mission[id_membre='" + idMembre + "']").toArray();

        console.log("idMembre:", idMembre);
        console.log("missionsDisponibles:", missionsDisponibles);

        if (missionsDisponibles.length > 0) {
            var missionAleatoire = missionsDisponibles[Math.floor(Math.random() * missionsDisponibles.length)];

            console.log("missionAleatoire:", missionAleatoire);

            $(missionAleatoire).prop("checked", true);

            // Mettez à jour l'affectation du membre à la mission
            $(".membre_case[id_membre='" + idMembre + "']").attr("id_mission", $(missionAleatoire).attr("id_mission"));
        }
    });

    console.log("Affectations aléatoires :", membresAffectations);
});


// Gestionnaire d'événement pour le changement de l'état de la case à cocher
$(".case_membre_mission").change(function () {
    var idMembre = $(this).attr("id_membre");
    var idMission = $(this).attr("id_mission");

    // Mettre à jour le tableau des affectations
    membresAffectations[idMembre] = $(this).prop("checked") ? idMission : "-1";
    console.log("Affectations mises à jour :", membresAffectations);
});
