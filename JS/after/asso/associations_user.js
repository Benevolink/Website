function refresh_assos_integrees(){
    import(abs_path("JS/classes/Asso.js")).then((module)=>{
        module.Asso.getListeAssosIntegrees().done((data)=>{
            var container = $("#list_assos_integrees");
            let i = 0;

            // Fonction récursive pour traiter chaque élément de manière séquentielle
            function processElement(index) {
                if (index < data.length) {
                    let element = data[index];
                    let asso = new module.Asso(element["id"]);
                    asso.get_logo().done((logo) => {
                        container.append(ItemBox(
                            "asso",
                            abs_path("controller/asso/association.php?id=" + element["id"]),
                            element["nom"],
                            logo["logo"],
                            element["desc"],
                            0,
                            0
                        ));
                        // Appel récursif pour traiter l'élément suivant
                        processElement(index + 1);
                    });
                }
            }

            // Démarrer le traitement avec le premier élément
            processElement(0);
        }).fail((error)=>{
            console.log(error);
        });
    });
}

function refresh_assos_en_attente(){
    import(abs_path("JS/classes/Asso.js")).then((module)=>{
        module.Asso.getListeAssosEnAttente().done((data)=>{
            var container = $("#list_assos_en_attentes");
            let i = 0;
            // Fonction récursive pour traiter chaque élément de manière séquentielle
            function processElement(index) {
                if (index < data.length) {
                    let element = data[index];
                    let asso = new module.Asso(element["id"]);
                    asso.get_logo().done((logo) => {
                        container.append(ItemBox(
                            "asso",
                            abs_path("controller/asso/association.php?id=" + element["id"]),
                            element["nom"],
                            logo["logo"],
                            element["desc"],
                            0,
                            0
                        ));
                        // Appel récursif pour traiter l'élément suivant
                        processElement(index + 1);
                    });
                }
            }

            // Démarrer le traitement avec le premier élément
            processElement(0);
        }).fail((error)=>{
            console.log(error);
        });
    });
}

$(document).ready(()=>{
    refresh_assos_en_attente();
    refresh_assos_integrees();
});