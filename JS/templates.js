function ItemBox(type,lien,titre,image,description,nombre_benevoles,nombre_max){
    let end_cont = nombre_benevoles;
    if(type == "mission"){
        end_cont = nombre_benevoles+"/"+nombre_max;
    }
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
        }).text(description).css({
            maxHeight : "30%",
            overflow: "hidden",
            textOverflow: "ellipsis"
        }),
        $("<p>").text(end_cont).css({
            position: "absolute",
            bottom: "0"
        })
    ]).css({
        position: "relative"
    });
    return elt;
    
}



