function change_month(elt,increment){
    let input = document.querySelector("#current_month");
    input.setAttribute("value",parseInt(input.value)+increment);
    elt.parentElement.submit();
}

function afficher_event(e, id){
    let c = document.createElement("div");
    c.setAttribute("class","Iframe_container");
    let iframe = document.createElement("iframe");
    $(iframe).css({width: "0px", height: "0px", transition: "0.5s"});
    iframe.onload = function(){
        var iFrame = document.querySelectorAll(".Iframe");
        iFrame.forEach((e)=>{
            const h = e.contentWindow.document.body.getAttribute("h_height");
            const w = e.contentWindow.document.body.getAttribute("h_width");
            e.style.height = h+"px";
            e.style.width= w+"px";
        }
        );
        
    }
    $(iframe).attr({
      class: "Iframe",
      frameborder: "0",
      scrolling: "no",
      id: "Iframe",
      src: abs_path("/controller/evenement.php?id_event="+id+"&iframe=true")
    });
    let X = e.pageX;
    let Y = e.pageY;
    c.style.top = Y+"px";
    c.style.left = X+"px";
    c.appendChild(iframe);
    document.body.appendChild(c);
    
    iframe.contentWindow.location.reload();
    
}
function cacher_iframe(elt){
    let iframe = document.querySelector("#Iframe");
    if(iframe.matches(':hover')){
        iframe.addEventListener("mouseleave",(evenement)=>{cacher_iframe(iframe);});
    }else{
        let c = document.querySelectorAll(".Iframe_container");
        c.forEach((e)=>{
            e.remove();
        })
    }
    
}

let liste_event = document.querySelectorAll(".calendar_event");
liste_event.forEach((e) => {
    let id = e.getAttribute("id_event");
    e.addEventListener("mouseenter",(evenement)=>{afficher_event(evenement,id);});
    e.addEventListener("mouseleave",(evenement)=>{cacher_iframe(evenement);});
});

