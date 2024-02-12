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

    // Simuler l'algorithme de simulation de tableau 3 fois
    var tableau1 = simulerTableau();
    var tableau2 = simulerTableau();
    var tableau3 = simulerTableau();

    // Enregistrer les tableaux dans des variables globales
    window.tableau1 = tableau1;
    window.tableau2 = tableau2;
    window.tableau3 = tableau3;
    
    console.log("Tableau 1 :", tableau1);
    console.log("Tableau 2 :", tableau2);
    console.log("Tableau 3 :", tableau3);

    // Afficher les boutons de solution
    $("#solutions").empty().append("<button id='solution1'>Solution 1</button>");
    $("#solutions").append("<button id='solution2'>Solution 2</button>");
    $("#solutions").append("<button id='solution3'>Solution 3</button>");

    console.log("Affectations aléatoires :", membresAffectations);
});

// Fonction pour simuler le tableau
function simulerTableau() {
    var tableau = {};
    $(".membre_case").each(function () {
        var idMembre = $(this).attr("id_membre");
        var missionsDisponibles = $(".case_membre_mission[id_membre='" + idMembre + "']").toArray();

        console.log("test simulation");

        if (missionsDisponibles.length > 0) {
            var missionAleatoire = missionsDisponibles[Math.floor(Math.random() * missionsDisponibles.length)];
            tableau[idMembre] = $(missionAleatoire).attr("id_mission");
        }
    });
    return tableau;
}

// Appeler la fonction simulerTableau() après affichage de la liste des membres
$(document).ready(function () {
    var tableau1 = simulerTableau();
    console.log("Tableau généré :", tableau1);
});

// Gestionnaire d'événement pour les boutons de solution
$(document).on("click", "#solution1, #solution2, #solution3", function () {
    var solution = $(this).attr("id").substr(-1); // Récupérer le numéro de la solution
    var tableau = window["tableau" + solution]; // Récupérer le tableau correspondant
    if (tableau) {
        $(".case_membre_mission").prop("checked", false); // Décocher toutes les cases
        // Remplir le tableau principal avec la solution sélectionnée
        $.each(tableau, function (idMembre, idMission) {
            $(".membre_case[id_membre='" + idMembre + "']").attr("id_mission", idMission);
            $(".case_membre_mission[id_membre='" + idMembre + "'][id_mission='" + idMission + "']").prop("checked", true);
        });
        console.log("Solution " + solution + " appliquée :", tableau);
    }
});

// Gestionnaire d'événement pour le changement de l'état de la case à cocher
$(".case_membre_mission").change(function () {
    var idMembre = $(this).attr("id_membre");
    var idMission = $(this).attr("id_mission");

    // Mettre à jour le tableau des affectations
    membresAffectations[idMembre] = $(this).prop("checked") ? idMission : "-1";
    console.log("Affectations mises à jour :", membresAffectations);
});

// Gestionnaire d'événement pour le bouton "Valider"
$("#valider").click(function () {
    var membresAffectations = {}; // Créer un objet pour stocker les affectations des membres

    // Parcourir toutes les cases cochées et enregistrer les affectations dans l'objet membresAffectations
    $(".case_membre_mission:checked").each(function () {
        var idMembre = $(this).attr("id_membre");
        var idMission = $(this).attr("id_mission");
        membresAffectations[idMembre] = idMission;
    });

    console.log("Modifications validées :", membresAffectations);
});