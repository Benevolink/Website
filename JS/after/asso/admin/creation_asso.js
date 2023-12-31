
function createAsso(){
    console.log("Debut envoie formulaires");
    let formDataTotal = new FormData();
    $("form").toArray().forEach(element => {
        let formData = new FormData(element);
        for (let [key, value] of formData.entries()) {
            formDataTotal.append(key, value);
        }
    });
    formDataTotal.append("missionsProposees",$("#missionsProposees").val());
    formDataTotal.delete("logoAssociation");
    let array = Object.fromEntries(formDataTotal.entries());
    console.log(array);
    console.log("Valeurs du FormData avant envoi :", formDataTotal);
    import(abs_path("JS/classes/Asso.js")).then((module)=>{
        
        module.Asso.insert(array["nomAssociation"],array["descriptionAssociation"],array["missionsProposees"],$("#logoAssociation")[0].files[0],array["localisation"],array["emailAssociation"],array["telAssociation"]).
        done((data)=>{
            if(data["statut"]==0){
                alert("Les informations renseignées sont invalides ou incomplètes. Veuillez vérifier votre saisie.");
            }else{
                console.log("Succès !");
                //window.location.href = abs_path("controller/static/form-merci.php");
            }
        })
    });
}


//Event handler
$(document).ready(function(event){
    $("#bouton_confirm_envoie_asso").click(createAsso);
})

