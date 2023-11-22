function createAsso(nom, logo, desc, desc_missions, adresse, tel, email){
    rep = this.APICall("asso","insert",
    {nom : nom, logo : logo, desc : desc, desc_missions : desc_missions, adresse : adresse, tel : tel, email : email});
    if(rep["statut"]==0){
        
    }
    else{

    }
}