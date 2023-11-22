
function modif_image(logo_chemin){
  let image  = document.querySelector("#image_logo");
  image.setAttribute("src",logo_chemin);
  image.addEventListener("click",function(){
  //On ajoute un fond sombre
  $('body').append(
    $('<div>').attr({
      class: "background_sombre",
      id: 'background_sombre'
    })
  );
    
  let background = document.createElement("div");
  background.setAttribute("class","background_sombre");
  background.setAttribute("id","background_sombre");
  document.body.appendChild(background);
  
  
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
  /*
  let boite = document.createElement("div");
  boite.setAttribute("class","boite_auth");
  boite.setAttribute("id","boite_auth");
  boite.style.cursor= "auto";
  let titre = document.createElement("p");
  titre.style.fontWeight = "bold";
  titre.style.fontSize = "20px";
  titre.innerText = "Modifier l'avatar";

  boite.appendChild(titre);
  */
    let form =  document.createElement("form");
      form.setAttribute("class","form_connexion");
      form.setAttribute("method","post");
    form.setAttribute("enctype","multipart/form-data");
  form.setAttribute("id","form_img");
  form.setAttribute("action","functions/modif_logo.php");

  let img = document.createElement("img");
  img.setAttribute("src",logo_chemin);
  img.setAttribute("style","width:200px;border-radius:200px;border: 10px black solid;cursor: pointer;");
  img.setAttribute("id","img_prev");
  img.addEventListener("click",function(){
    let inp = document.querySelector("#input_upload");
    inp.click();
  });
  
  let input = document.createElement("input");
  input.setAttribute("name","uploadedfile");
  input.setAttribute("id","input_upload");
  input.setAttribute("type","file");
  input.addEventListener("change",function(){
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
  input.style.display = "none";
  input.style.height ="200px";
  input.style.width ="200px";
  input.style.margin = "0px";
  input.style.zIndex = "9999";

  let input2 = document.createElement("input");
  input2.setAttribute("name","uploadedfile");
  input2.setAttribute("type","hidden");
  form.appendChild(input);
  form.appendChild(img);
  form.appendChild(input2);

  boite.append($(form));
    let valid = document.createElement("div");
    valid.setAttribute("class","bouton_inscr");
    valid.innerText = "Valider";
    valid.setAttribute("onclick","modif_avatar();");
    valid.setAttribute("id","valid");
  
    let retour = document.createElement("div");
    retour.setAttribute("id","retour");
    retour.setAttribute("class","bouton_inscr");
    retour.innerText = "Retour";
    retour.style.backgroundColor ="red";
  
    valid.addEventListener("click",function(){
      let f = document.querySelector("#form_img");
      f.submit();
    });

  retour.addEventListener("click",function(){
    let bg = document.querySelector("#background_sombre");
    bg.remove();
      
  });
  boite.append($(valid));
    boite.append($(retour));
  $(background).append(boite);
  document.body.appendChild(background);
});
}
  