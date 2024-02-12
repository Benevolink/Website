
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


//Affichage des centres d'intérêts
$(document).ready(()=>{
import(abs_path("JS/classes/Domaine.js")).then((module)=>{
  import(abs_path("JS/classes/User.js")).then((UserClass)=>{
      let user = new UserClass.User;
      user.get_all_interets().done((data_user)=>{
        console.log(data_user);
        module.Domaine.get_all().done((data)=>{
        data.forEach(element => {
          let est_select = false;
          data_user.forEach((value)=>{
            if(element['id_domaine']==value["id_domaine"])
            {
              est_select = true;
            }
          });
          if(!est_select)
          {
            $("#centresInteret").append(
              $('<option>').text(element['nom_domaine'])
              .val(element["id_domaine"])
            );
          }else{
            $("#centresInteretSuppr").append(
              $('<option>').text(element['nom_domaine'])
              .val(element["id_domaine"])
            );
          }
          
        });  
      });
    });

  }); 
  
});
});

  $(document).on('change','#centresInteret',"change",function(){
    $("#centresInteret").find(":selected").appendTo("#centresInteretSuppr");
    $("#centresInteret").prop("selectedIndex",0);
    $("#centresInteretSuppr").prop("selectedIndex",0);
  });
  $(document).on('change','#centresInteretSuppr',"change",function(){
    $("#centresInteretSuppr").find(":selected").appendTo("#centresInteret");
    $("#centresInteret").prop("selectedIndex",0);
    $("#centresInteretSuppr").prop("selectedIndex",0);
  });

$("#interets_sub").on("click",()=>{
  let liste_indexs = [];
  $("#centresInteretSuppr").children("option").each(function(){
    if($(this).val()){
      liste_indexs.push($(this).val());
      console.log($(this).val());
    }
  });
  import(abs_path("JS/classes/User.js")).then((module)=>{
    let user = new module.User;
    user.send_interets(liste_indexs).done((data)=>{
      console.log(data);
    });
  });
});
function get_disponibilites()
{
  var disponibilites = {}
  let liste_boutons = $(".checkbox-dispo:checked");
  $.each(liste_boutons, function (index,record) { 
     let parent = $(record).parent().parent();
     let jour = parent.attr("jour");
     let horaire_debut = parent.find(".heure-debut").first().val();
     let horaire_fin = parent.find(".heure-fin").first().val();
      if(!horaire_debut || ! horaire_fin || horaire_debut>=horaire_fin)
      {

      }else{
        disponibilites[jour] = {"heure_debut" : horaire_debut, "heure_fin":horaire_fin};
      }
  });
  return disponibilites;

}

function send_disponibilites()
{
  let disponibilites = get_disponibilites();
  import(abs_path("JS/classes/User.js")).then((UserModule)=>{
    let user = new UserModule.User;
    user.sendDisponibilites(disponibilites).done(function(data){
      if(data["statut"]==1)
      {
        console.log("succes");
      }else{
        console.log(data);
      }
    }).fail(function(error){
      console.log(error);
    });
  });
}


$(document).ready(function(){
  $("#valider_horaires").on("click",send_disponibilites);
})




import(abs_path("JS/classes/User.js")).then((module)=>{
  let user = new module.User();
  user.getLogo().done((data)=>{
    logo_chemin_f(data["lien_image"]);
    modif_image(data["lien_image"]);
  }).fail((error)=>{
    console.error("Erreur dans la requête AJAX :",error);
  });
});


//Partie pour les horaires à l'actualisation

$(document).ready(function(){
import(abs_path("JS/classes/User.js")).then((moduleUser)=>{
  let user = new moduleUser.User;
  user.get_disponibilites().done((data)=>{
    console.log(data);
    data.forEach((element)=>{
      let elt = $("#table_dispos").find("tr").filter(function(){
        return $(this).attr("jour")==parseInt(element["jour"])-1;
      }).first();
      console.log(elt);
      elt.children().eq(1).children().eq(0).attr("checked","checked");
      elt.children().eq(2).children().eq(0).attr("value",element["h_deb"]).show();
      elt.children().eq(3).children().eq(0).attr("value",element["h_fin"]).show();
    });
  });
});
});