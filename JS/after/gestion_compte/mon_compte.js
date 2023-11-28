
function modif_image(logo_chemin){
  let image  = document.querySelector("#image_logo");
  image.setAttribute("src",logo_chemin);
  image.addEventListener("click",function(){
  //On ajoute un fond sombre
    
  let background = $("<div>").attr({
    class : "background_sombre",
    id : "background_sombre"
  })
  
  
  
  //On crée une boîte pour s'authentifier

  let boite = $('<div>').attr({
    class: 'boite_auth',
    id: 'boite_auth'
  }).css({
    cursor: 'auto'
  }).append(
    $('<p>').css({
      fontWeight: 'bold',
      fontSize: '20px'
    }).text("Modifier l'avatar")
  );
  let form = $("<form>").attr({
    class : "form_connexion",
    method : "post",
    enctype : "multipart/form-data",
    id : "form_img",
    action : ""
  })
  let img = $("<img>").attr({
    src : logo_chemin,
    id : "img_prev"
  }).css({
    width : "200px",
    borderRadius : "200px",
    border : "10px black solid",
    cursor : "pointer"
  }).on("click",function(event){
    let inp = document.querySelector("#input_upload");
    inp.click();
  })
  let input = $("<input>").attr({
    name : "uploadedfile",
    id : "input_upload",
    type : "file",
  }).css({
    display : "none",
    height : "200px",
    width : "200px",
    margin : "0px",
    zIndex : "9999"
  })
  .on("change",function(){
    if (this.files && this.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#img_prev')
                .attr('src', e.target.result)
                .width(200)
                .height(200);
        };

        reader.readAsDataURL(this.files[0]);
    }else{document.write("f");}
  });
  let input2 = $("<input>").attr({
    name : "uploadedfile",
    type : "hidden"
  });

  form.append([
    input,
    img,
    input2
  ]);
  

  boite.append(form);
    let valid = $("<div>").attr({
      class : "bouton_inscr",
      id : "valid"
    }).click(()=>{
      import(abs_path("JS/classes/User.js")).then((module)=>{
        let file_content = $("#input_upload")[0].files[0];
        module.User.setLogo(file_content).done((data)=>{
          console.log(data);
          location.reload();
        }).fail((err)=>{
          console.log(err);
        });
      });
    }).text("Valider");

    let retour = $("<div>").attr({id : "retour", class : "bouton_inscr"}).text("Retour").css({
      backgroundColor : "red"
    }).click(()=>{
      $("#background_sombre").remove();
    });
  
    
  
    /*valid.addEventListener("click",function(){
      let f = document.querySelector("#form_img");
      f.submit();
    });*/
  
  
  $("body").append(background.append(boite.append([valid,retour])));
});
}
  