function afficher_missions(titre,liste){
    let main = $("<div>");
    main.attr({
      class: "cate"
    })
    main.append(
      $('<div>').attr({class: "case_titre"}).css({
        fontWeight: "bold",
        fontSize: "120%"
      }).append(titre)
    );
    let wrapper = $('<div>').attr({class: "wrapper"}).css({
      cursor: "pointer"
    });
    liste.forEach((e)=>{
      let div = $("<div>").attr({class: "wrapper_enfant", id_event: e.id_event});
      div.append([
        $("<div>").append([
          $("<div>").append(e.nom_event).css({
            fontWeight: "bold",
            fontSize: "110%"
          }),
          $("<img>").attr({src: e.logo}).css({
            width: "80%",
            margin: "auto",
            transition: "0.5s",
            scale: "1"
          }),
          $("<div>").append(e.nom).css({
            fontWeight: "bold",
            fontSize: "100%"
          }).hover(function(){
            $(this).css({
              scale: "1.3"
            })
          }).on("mouseout",function(){
            $(this).css({
              scale:"1"
            })
          }).on("click",function(event){
            event.preventDefault();
            window.location.href = abs_path("controller/asso/association.php?id="+id_asso);
          }).attr({
            class: "priority_target"
          }),
          $("<div>").append(e.desc).css({
            maxHeight: "60px",
            overflow: "hidden",
            textOverflow: "ellipsis"
          })
        ])
      ]);
      //
      div.click(function(event){
        if(!(event.target.getAttribute("class")=="priority_target")){
          window.location.href = abs_path("controller/evenement.php?id_event="+$(this).attr('id_event'));
        }
      
      });
      wrapper.append(div);
      main.append(wrapper);
    });
    
    
    $("#wrapper_all").append(main);
    

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
  var taille=window.location.href.split('/').len - abs_path("").split('/').len;
  var str_slash = "";
  for(var i=0; i<taille-2; i++){
    str_slash += "..";
  }
  if(str_slash.length>0){
    str_slash += "/";
  }
  
  $(iframe).attr({
    class: "Iframe",
    frameborder: "0",
    scrolling: "no",
    id: "Iframe",
    src: str_slash+"evenement.php?id_event="+id+"&iframe=true"
  });
  let X = e.pageX;
  let Y = e.pageY;
  c.style.top = Y+"px";
  c.style.left = X+"px";
  //c.appendChild(iframe);
  //document.body.appendChild(c);
  
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
function ajouter_events_missions(){
  $("body").append(
      $('<div>').attr({class: "Iframe_container"}).append(
          $('<iframe>').attr({
              id: "iframe",
              title: "test",
              frameborder: "0",
              scrolling: "no",
              style: "display: none;"
          })
      )
  )
  let events = $(".wrapper_enfant").get();
  events.forEach((e)=>{
      $(e).on("mouseenter",(evenement)=>{
          afficher_event(evenement,$(e).attr('id_event'));
      });
      $(e).on("mouseleave",(evenement)=>{
          cacher_iframe(evenement);
      });
  });
}

