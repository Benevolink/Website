function afficher_sondages(id_asso,main){
    $.ajax({
        url: abs_path("functions/ajax/sondage/asso_sondages.php"),
        method: "POST",
        dataType: "json",
        data: {
            id_asso: id_asso
        }
    }).done(function(rep){
        console.log(rep);
        rep.forEach((element)=>{
            main.append(
                $('<div>').css({
                    cursor: "pointer",
                    margin: "10px",
                    backgroundColor: "rgb(245,245,245)",
                    width: "600px",
                    borderRadius: "3px",
                    padding: "10px"
                }).on("click",function(event){
                    event.preventDefault();
                    window.location.href=abs_path("controller/asso/sondage/sondage.php?id_sondage="+element.id);
                }).append(element.question)
            );
        });    
    })
}
