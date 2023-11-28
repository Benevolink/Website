
function confirmer(lien,texte){
  let div = document.createElement("div");
  let background = document.createElement("div");
  background.setAttribute("class","background_sombre");
  div.setAttribute("class","message_alerte");
  div.style.height = "150px";
  div.style.width = "300px";
  div.style.left = "calc(50% - 150px);"
  div.innerHTML = "Voulez-vous vraiment poursuivre l'action: "+texte+" ?";
  let div2 = document.createElement("div");
  
  let valider = document.createElement("div");
  valider.setAttribute("class","bouton_inscr");
  valider.innerHTML = "Valider";
  valider.addEventListener("click",function(){
    window.location.href = lien;
  });
  valider.style.backgroundColor = "green";
  valider.style.display = "inline";

  let annuler = document.createElement("div");
  annuler.setAttribute("class","bouton_inscr");
  annuler.innerHTML = "Annuler";
  annuler.addEventListener("click",function(){
    let liste = document.querySelectorAll(".message_alerte");
    liste.forEach(function(elt){
      elt.remove();
    });
    let liste2 = document.querySelectorAll(".background_sombre");
    liste2.forEach(function(elt){
      elt.remove();
    });
  });
  annuler.style.backgroundColor = "red";
  annuler.style.display = "inline";
  div2.style.marginTop = "30px";
  div2.style.marginLeft = "20px";
  div2.appendChild(valider);
  div2.appendChild(annuler);
  div.appendChild(div2);
  document.body.appendChild(background);
  document.body.appendChild(div);
}
//On récupère le logo de l'utilisateur
  var logo_chemin= "";
function logo_chemin_f(string){
    logo_chemin = string;
    
}
import(abs_path("JS/classes/User.js")).then((module)=>{
  let user = new module.User();
  user.getLogo().done((data)=>{
    logo_chemin_f(data["lien_image"]);
    modif_image(data["lien_image"]);
  }).fail((error)=>{
    console.error("Erreur dans la requête AJAX :",error);
  });
});

