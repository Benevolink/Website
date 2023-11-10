export class Event{

    constructor(id_event){
        this.id_event = id_event;
    }

    getInfo(info_name){
        return $.ajax({
            url: abs_path("NOMFICHIER.php"),
            method: "POST",
            dataType: "json",
            data: {
                id_asso: this.id_asso
            }
        }).then(function(rep) {
            console.log(rep);
            return rep[info_name];
        });
    }

    getName(){
        return this.getInfo("nom_event");
    }

    getDesc(){
        return this.getInfo("desc_event");
    }

    getVisu(){
        return this.getInfo("visu");
    }

    getIdlieu(){
        return this.getInfo("id_lieu");
    }

    getNbPersonnes(){
        return this.getInfo("nb_personnes");
    }

    getIdHoraire(){
        return this.getInfo("id_horaire");
    }

    getIdDomaine(){
        return this.getInfo("id_domaine");
    }

    //a partir de id_lieu, id_horaire, id_domaine : déterminer département, date_debut/heure_debut, nom_domaine


}