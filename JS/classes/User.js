export class User{

    constructor(id_user){
        this.id_user = id_user;
    }

    afficher_profil_court(){
        //ajax pour récupérer le user à partir de l'id puis affichage
        $.ajax({
            url: abs_path("NOMFICHIER.php"),
            method: "POST",
            dataType: "json",
            data: {
                id_user: this.id_user
            }
        }).done(function(rep){
            console.log(rep);
            //détailler l'affichage paramètre par paramètre :
            //nom, prenom, logo
            var nom_user = rep.nom;
            var prenom_user = rep.prenom;
            var logo_user = rep.logo;

            //afficher bien HTML
            main.append(
                $('<div>').css({
                    cursor: "pointer",
                    margin: "10px",
                    backgroundColor: "rgb(245,245,245)",
                    width: "600px",
                    borderRadius: "3px",
                    padding: "10px"
                })
                //ajouter un on click : afficher en grand
            );

        })
        
    }

    afficher_profil_long(reponse){
        //affichage dans une page à part on click
        //on part de la rep et on affiche un peu comme details courts avec des trucs en plus/+grand

        //détailler l'affichage paramètre par paramètre : nom, prenom, date_de_naissance, email, tel, logo, id_lieu, account_status
        var nom_user = reponse.nom;
        var prenom_user = reponse.prenom;
        var logo_user = reponse.logo;
        var date_de_naissance_user = reponse.date_de_naissance;
        var email_user = reponse.email;
        var tel_user = reponse.tel;
        var id_lieu_user = reponse.id_lieu;
        var account_status = reponse.account_status;
        
        //a partir de id_lieu : déterminer département
              

        //afficher bien HTML
        main.append(
            $('<div>').css({
                cursor: "pointer",
                margin: "10px",
                backgroundColor: "rgb(245,245,245)",
                width: "600px",
                borderRadius: "3px",
                padding: "10px"
            })
            //ajouter un on click : afficher en grand
        );
    }

}