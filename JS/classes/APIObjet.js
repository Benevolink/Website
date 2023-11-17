

export class APIObjet{
    APICall(type,fonction,params){
        let infos = {type: type, fonction: fonction};
        let datas = Object.assign({},infos,params);
        return $.ajax({
            url: abs_path("NOMFICHIER.php"),
            method: "POST",
            dataType: "json",
            data: datas
        });
    }
}