function ItemBox(type,lien,titre,image,description,nombre_benevoles,nombre_max){
    let elt = $("<div>").attr({
        class : "ItemBox"
    }).click(()=>{
        window.location.href = lien;
    }).append([
        $("<p>").attr({
            class: "ItemBoxTitre"
        }).text(titre),
        $("<img>").attr({
            src : image
        }),
        $("<p>").attr({
            class: "ItemBoxDesc"
        }).text(description),
        $("<p>").text(nombre_benevoles+"/"+nombre_max)
    ]);
    return elt;
    
}



