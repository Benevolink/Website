function createAsso(nom, logo, desc, desc_missions, adresse, tel, email){
    asso = new Asso();
    rep = asso.APICall("asso","insert",
    {nom : nom, logo : logo, desc : desc, desc_missions : desc_missions, adresse : adresse, tel : tel, email : email});
    if(rep["status"]==0){
        
    }
    else{
        window.location.href = abs_path("controller/static/form-merci.php");
    }
}