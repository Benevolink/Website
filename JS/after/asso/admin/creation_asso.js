
function createAsso(){

    let formDataTotal = new FormData();
    $("form").toArray().forEach(element => {
        let formData = new FormData(element);
        for (let [key, value] of formData.entries()) {
            formDataTotal.append(key, value);
        }
    });
    let array = Object.fromEntries(formDataTotal.entries());
    console.log(array);
    import(abs_path("JS/classes/Asso.js")).then((module)=>{
        let asso = new module.Asso();
        asso.insert(array["nomAssociation"],array["descriptionAssociation"],array["missions"],array["logoAssociation"],array["localisation"],array["emailAssociation"],array["telAssociation"]).
        done((data)=>{
            if(data["statut"]==0){
                alert("Les informations renseignées sont invalides ou incomplètes. Veuillez vérifier votre saisie.");
            }else{
                
                //window.location.href = abs_path("controller/static/form-merci.php");
            }
        })
    });
}

