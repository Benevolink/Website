function createAsso(nom, desc, desc_missions, uploadedfile, adresse, email, tel){
    var asso = new Asso();
    var rep = asso.APICall("asso","insert",
    {nom : nom, desc : desc, desc_missions : desc_missions, uploadedfile : uploadedfile, adresse : adresse, email : email, tel : tel});
    if(rep["statut"]==0){
        alert("Les informations renseignées sont invalides ou incomplètes. Veuillez vérifier votre saisie.");
    }
    else{
        window.location.href = abs_path("controller/static/form-merci.php");
    }
}