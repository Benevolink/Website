

export class APIObjet{
    static APICallStatic(type,fonction,params){
        let infos = {type: type, fonction: fonction};
        let datas = Object.assign({},infos,params);
        return $.ajax({
            url: abs_path("NOMFICHIER.php"),
            method: "POST",
            dataType: "json",
            data: datas
        });
    }
    APICall(type,fonction,params){
        return APIObjet.APICallStatic(type,fonction,params);
    }
    
}