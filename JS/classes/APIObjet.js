export class APIObjet {
    static APICallStatic(type, fonction, params) {
        let infos = { type: type, fonction: fonction };
        var datas = Object.assign({}, infos, params);
        datas = JSON.stringify(datas);
        // Retourne directement l'objet $.ajax
        return $.ajax({
            url: abs_path("API/index.php"),
            method: "POST",
            dataType: "json",
            contentType: "application/json",
            data: datas
        });
    }

    APICall(type, fonction, params) {
        return APIObjet.APICallStatic(type, fonction, params);
    }
}
