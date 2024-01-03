
function del_msg(){
  $(".message_alerte").remove();
  $("#fond_message").remove();
}
function remove_boite_auth(){
  $("#boite_auth").remove();
  $("#background_sombre").remove();
}
function message_alerte(msg){
  del_msg();
  
  let div = document.createElement("div");
  div.setAttribute("class","message_alerte");
  
  let croix = document.createElement("img");
  $(croix).attr({
    src: abs_path('media/img/croix.jpg'),
    id: "croix_msg",
    
  })
  $(croix).css({
    width: "20px",
    marginRight: "10px",
    borderRadius: "10px",
    zIndex: "9999",
    position: "relative",
    top: "0px",
    left: "-10px",
    cursor: 'pointer'
  });
  let fond = document.createElement("div");
  $(fond).attr({
    class: "background_sombre",
    id: "fond_message"
  });
  fond.style.zIndex = "9002";
  
  $('body').append([
    $(fond),
    $(div).append([$(croix),msg]).css({
      textJustify: "auto",
      width: "max-content",
      maxWidth: "350px",
      height: "max-content",
      paddingLeft: "13px",
      fontSize: "130%"
    })
  ]);
  
  $("#croix_msg").on("click",function(){del_msg();});
}

function authentification(){
  let xhttp = new XMLHttpRequest();
  xhttp.open("GET", abs_path('functions/ajax/auth.php'));
  xhttp.onload = function() { //On attend la réponse
    const xmlDoc = xhttp.responseXML;
     if(xmlDoc != null){ //On vérifie que la réponse n'est pas nulle
       const x = xmlDoc.getElementsByTagName("response");
       if(x.length ==1){
         if(x[0].innerHTML=="1"){
           
         }else{
          //On ajoute un fond sombre
          let background = document.createElement("div");
          $(background).attr({
            class: "background_sombre",
            id: "background_sombre"
          });

          //On crée une boîte pour s'authentifier
          let boite = document.createElement("div");
          $(boite).attr({
            class: "boite_auth",
            id: "boite_auth"
          }).css({
            transition: '1s ease-in-out',
            height: 'max-content'
          });
          let croix = document.createElement("img");
          $(croix).attr({
            src: abs_path('media/img/croix.jpg'),
            id: "croix_boite",
            onclick: 'remove_boite_auth()'
          }).css({
            position: 'absolute',
            transform: 'translate(50%,0)',
            clear: 'both',
            width: '20px',
            borderRadius: '50%',
            right: '10%',
            cursor: 'pointer'
          });
          let titre = document.createElement("p");
          $(titre).css({
            fontWeight: "bold",
            fontSize: "20px"
          });
          titre.innerText = "Bienvenue sur BenevoLink !";

          let desc = document.createElement("p");
          desc.innerText = "BenevoLink est une plateforme créée par des étudiants qui vise à mettre en relation associations et bénévoles. Afin d'utiliser nos services, veuillez vous identifier ou créer un compte.";
          $(desc).css({
            textAlign: "justify",
            textIndent: "30px",
            padding: "10px"
          });
          
          
          let form =  document.createElement("form");
          $(form).attr({
            class: "form_connexion",
            form: "post",
            action: "javascript:connex()",
            id: "form_connex"
          });
          
          let email = document.createElement("input");
          $(email).attr({
            type: "text",
            name: "email",
            id: "email"
          });
           
          let label_email = document.createElement("label");
          $(label_email).css({
            fontWeight: "bold",
          });
          label_email.setAttribute("for","email");
          label_email.innerText = "Adresse électronique";
           
          let mdp = document.createElement("input");
          $(mdp).attr({
            type: "password",
            name: "mdp",
            id: "mdp"
          });
           
          let label_mdp = document.createElement("label");
          label_mdp.setAttribute("for","mdp");
          label_mdp.style.fontWeight = "bold";
          label_mdp.innerText = "Mot de passe";
           

          
          let aide = document.createElement("p");
          aide.setAttribute("class","aide");
          aide.innerText = "Mot de passe oublié ?";
           let br =document.createElement("br");

          

          let inscr = document.createElement("div");
          $(inscr).attr({
            class: "bouton_inscr",
            onclick: "inscr();",
            id: "valid_inscr"
          });
          inscr.innerText = "S'inscrire";
          
          let connex = document.createElement("div");
          $(connex).attr({
            id: "valid_connex",
            class: "bouton_inscr",
            onclick: "connex();",
            onfocus: "connex();"
          });
          connex.innerText = "Connexion";
          connex.style.backgroundColor ="#055C9E";

          $("body").append([
            $(background),
            $(boite).append([
              $(croix),
              $(titre),
              $(desc),
              $(form).append([
                $(email),
                $(label_email),
                $(br),
                $(mdp),
                $(label_mdp)
                ]),
              $(connex),
              $(inscr)
                            
            ])
          ]);
         
           // Quand l'utilisateur appuie sur entrer, on passe à la case suivante
            jQuery.extend(jQuery.expr[':'], {
                focusable: function (el, index, selector) {
                    return $(el).is('#form_connex>input');
                }
            });
            
            $(document).on('keypress', 'input,select', function (e) {
                if (e.which == 13) {
                    
                    // Get all focusable elements on the page
                    let $canfocus = $(':focusable');
                      
                      let index = $canfocus.index(document.activeElement) + 1;
                      let error_msg = $("#connex_error_msg");
                      if(error_msg != null){
                        error_msg.remove();
                      }
                      e.preventDefault();
                      if (index >= $canfocus.length){//Si l'utilisateur arrive au bout
                        document.getElementById("form_connex").submit();
                      } //index = 0;
                      $canfocus.eq(index).focus();
                    
                }
            });
         }
       }
     }
  }
  xhttp.send();
}

function connex(){
  let form = document.getElementById("form_connex");
  let password = document.getElementById("mdp").value;
  let email = document.getElementById("email").value;
  let xhttp = new XMLHttpRequest();
  xhttp.open("GET", abs_path("functions/ajax/auth.php?")+"email="+encodeURIComponent(email)+"&mdp="+encodeURIComponent(password));
  xhttp.onload = function() {
    const xmlDoc = xhttp.responseXML;
    
    if(xmlDoc != null){
      
      const x = xmlDoc.getElementsByTagName("response");
       if(x.length ==1 && x[0].innerHTML==1){
         $("#boite_auth").remove();
         $("#background_sombre").remove();
         location.reload();
          
       }else if(x.length ==1 && x[0].innerHTML==0){
         let error_msg = $("#connex_error_msg");
              if(error_msg != null){
                error_msg.remove();
          }
         let form = document.getElementById("form_connex");
         let div = document.createElement("div");
         div.style.color = "red";
         div.textContent = "Identifiants incorrects !";
         div.setAttribute("id","connex_error_msg");
         form.appendChild(div);
       }
    }
  }
  xhttp.send();
}

function inscr(){
  let form = document.getElementById("form_connex");
  form.setAttribute("action","javascript:inscr_envoie()");
  form.innerHTML = "";

  let tel = document.createElement('input');
  $(tel).attr({
    type: "text",
    name: "tel",
    id: "tel"
  });

  let label_tel = document.createElement('label');
  label_tel.setAttribute("for","tel");
  label_tel.style.fontWeight = "bold";
  label_tel.innerText = "Téléphone";
  
  let email = document.createElement("input");
  $(email).attr({
    type: "text",
    name: "email",
    id: "email"
  });
  
  let label_email = document.createElement("label");
  label_email.setAttribute("for","email");
  label_email.style.fontWeight = "bold";
  label_email.innerText = "Adresse électronique";
  
  let mdp = document.createElement("input");
  $(mdp).attr({
    type: "password",
    name: "mdp",
    id: "mdp"
  });
  let label_mdp = document.createElement("label");
  label_mdp.setAttribute("for","mdp");
  label_mdp.style.fontWeight = "bold";
  label_mdp.innerText = "Mot de passe";

  let mdp_2 = document.createElement("input");
  $(mdp_2).attr({
    type: "password",
    name: "mdp_2",
    id: "mdp_2"
  });
  
  let label_mdp_2 = document.createElement("label");
  label_mdp_2.setAttribute("for","mdp_2");
  label_mdp_2.style.fontWeight = "bold";
  label_mdp_2.innerText = "Mot de passe";
  
  let br = document.createElement("br");
  

  $(form).append([
    $(email),
    $(label_email),
    $('<br>'),
    $(mdp),
    $(label_mdp),
    $('<br>'),
    $(mdp_2),
    $(label_mdp_2),
    $('<br>'),
    $(tel),
    $(label_tel)
  ]);
  $('#valid_connex').attr({"onclick": "switch_connex()"}).empty().append('Se connecter');
  $('#valid_inscr').attr({"onclick": "inscr_envoie()"}).empty().append('Inscription');

   
}

function afficher_interets(div){
  import(abs_path("JS/classes/Domaine.js")).then((module)=>{
    module.Domaine.get_all().done(function(rep){
      rep.forEach((e)=>{
        div.append([
          $('<label>').attr({
            for: e['nom_domaine']
          }).css({
          }).append(e['nom_domaine']),
          $('<input>').attr({
            type: 'checkbox',
            name: e['nom_domaine'],
            id: e['nom_domaine'],
            id_domaine: e['id_domaine']
          }).css({
            marginRight: '20px'
          })
        ])
      });
  });
  

  });
  /*.fail(function(error){
    console.log(error);
  })*/
}



function resize(boite,repete){
  let height = $(window).height();;
  let boite_bottom = boite.position().top + boite.offset().top + boite.outerHeight(true);
  if((boite.height() + 100 < height && boite.css("columnCount")=='') || (boite.height()*2 + 100 < height && boite.css("columnCount")=='2')){
    boite.css({
      column: '',
      columnCount: '',
      minWidth: '400px',
      width: 'auto'
    });
  }else{
     boite.css({
      columnCount: '2',
      columnWidth: '40%',
      width: 'auto'
    });
  }
  let top = Math.max(($(window).height()-(boite.height()))/2,0);
  let left = Math.max(($(window).width()-(boite.width()))/2,0);
  boite.css({
    top: top+'px',
    left: left+'px'
  });
  if(repete){
    resize(boite,false)
  }
}


function inscr_envoie(){
  let form = document.getElementById("form_connex");
  let password = document.getElementById("mdp").value;
  let password_2 = document.getElementById("mdp_2").value;
  let email = document.getElementById("email").value;
  let tel = document.getElementById("tel").value;
  if(password_2 != password){
    document.getElementById("mdp_2").style.border = "1px solid red";
    message_alerte("Les deux mots de passe ne correspondent pas");
  
  }else{
    $.ajax({
      url: abs_path('functions/ajax/inscription_etape1.php'),
      method: 'POST',
      dataType: 'json',
      data: {
        mdp: password,
        mdp2: password_2,
        email: email,
        tel: tel
      }
    }).done(function(rep){
      console.log(rep)
      if(rep['statut']==1){//La première étape est un succès.
        var boite = $('.boite_auth').first();
        boite.empty();
        boite.css({
          minHeight: '300px',
          height: 'max-content',
          minWidth: '600px',
          maxWidth: '80vw',
          top: '0',
          left: '0'
        });
        setTimeout(()=>{resize((".boite_auth").first())},500);
        $(window).on("resize",function (event){
          let boite_2 = $(".boite_auth").first();
          resize(boite_2);
        });
        let croix = document.createElement("img");
        $(croix).attr({
          src: abs_path('media/img/croix.jpg'),
          id: "croix_boite",
          onclick: 'remove_boite_auth()'
        }).css({
          position: 'absolute',
          transform: 'translate(50%,0)',
          clear: 'both',
          width: '20px',
          borderRadius: '50%',
          right: '10%',
          cursor: 'pointer'
        });
        boite.append($(croix));
        boite.append($('<p>').css({
          fontWeight: 'bold',
          fontSize: '20px'
        }).append("Plus qu'une étape !"));
        let form = $('<form>');
        let div = $('<div>').css({
          width : '70%',
          marginLeft: '10%'
        }).attr({
          id: 'liste_interets'
        });
        afficher_interets(div);
        boite.append(form.append([
          $('<p>').css({
            fontWeight: 'bold'
          }).append("Vos centres d'intérêt"),
          div,

          
          $('<p>').css({
            fontWeight: 'bold',
            fontSize: '20px'
          }).append("Informations personnelles"),
          $('<div>').append([
            $('<div>').append([
              $('<label>').attr({
                for: 'nom'
              }).append('Nom'),
              $('<input>').attr({
                type: 'text',
                name: 'nom',
                id: 'nom'
              })
            ]),
            $('<div>').append([
              $('<label>').attr({
                for: 'prenom'
              }).append('Prénom'),
              $('<input>').attr({
                type: 'text',
                name: 'prenom',
                id: 'prenom'
              })
            ]),
            $('<div>').append([
              $('<label>').attr({
                for: 'visu'
              }).append('Visibilité publique du compte'),
              $('<input>').attr({
                type: 'checkbox',
                checked: true,
                name: 'visu',
                id: 'visu',
              })
            ]),
            $('<div>').append([
              $('<label>').attr({
               for: 'date_de_naissance'
              }).append('Date de naissance'),
              $('<input>').attr({
                type: 'date',
                name: 'date_de_naissance',
                id: 'date_de_naissance'
              })
            ]),
            $('<div>').append([
              $('<label>').attr({
                for: 'departement'
              }).append('Numéro de département'),
              $('<input>').attr({
                type: 'number',
                name: 'departement',
                id: 'departement'
              }).css({
                width: '3em',
                clear: 'both'
              })
            ]),
            $('<div>').append([
              $('<label>').attr({
                for: 'adresse'
              }).append('Adresse'),
              $('<input>').attr({
                type: 'text',
                name: 'adresse',
                id: 'adresse'
              }).css({
                clear: 'both'
              })
            ]),   
          ]).css({
            marginTop: '20px',
            marginBottom: '20px',
            width: '150px'
          })
        ]));
        $('#boite_auth label').css({
          display: 'inline-block',
          margin: '10px',
          fontSize: '110%',
          width: '200px'
        });
        $('#boite_auth > form > div > div').css({
          marginBottom: '10px',
          width: 'max-content'
        });
        let inscr = document.createElement("div");
        $(inscr).attr({
          class: "bouton_inscr",
          id: "valid_inscr"
        });
        inscr.innerText = "Inscription";
        
        let connex = document.createElement("div");
        $(connex).attr({
          id: "valid_connex",
          class: "bouton_inscr",
          onclick: "connex();",
          onfocus: "connex();"
        });
        connex.innerText = "Se connecter";
        connex.style.backgroundColor ="#055C9E";
        $(boite).append([
          $(connex),
          $(inscr)
        ])
        $(inscr).on('click',function(){
          let date_de_naissance = $('#date_de_naissance').val();
          let departement = $('#departement').val();
          let adresse = $('#adresse').val();
          let liste_interets = new Array();
          let liste_interets_buttons = $('#liste_interets > input');
          let visu = $('#visu').val();
          let nom = $('#nom').val();
          let prenom = $('#prenom').val();
          liste_interets_buttons.each(function(){
            if($(this).is(':checked')){
              liste_interets.push($(this).attr('id_domaine'));
            }
            console.log($(this).attr('name'));
          });
          if(liste_interets.length<3){
            message_alerte("Veuillez sélectionner au moins 3 centres d'intérêt");
          }else{
            liste_interets = JSON.stringify(liste_interets);
            $.ajax({
              url: abs_path('functions/ajax/inscription_etape2.php'),
              dataType: 'json',
              type: 'POST',
              data: {
                visu: visu,
                date_de_naissance: date_de_naissance,
                departement: departement,
                adresse: adresse,
                liste_domaine: liste_interets,
                mdp: password,
                mdp2: password_2,
                tel: tel,
                email: email,
                nom: nom,
                prenom: prenom
              }
            }).done(function(rep){
              console.log(rep);
              if(rep['statut']==1){
                window.location.reload();
              }else if(rep['statut']==0){
                message_alerte(rep['message_erreur']);
              }
            }).fail(function(error){
              console.log(error);
            })
          }
         
        });
        
      }else{
        message_alerte(rep['message_erreur']);
      }
    }).fail(function(error){
      console.log(error);
    });
  }
}
  
function switch_connex(){
  remove_boite_auth();
  authentification();
}

//AJAX - Liste des associations
function get_list_assos(){
  let xhttp = new XMLHttpRequest();
  xhttp.onload = function(){
    const xmlDoc = xhttp.responseXML;
    let list_assos = xmlDoc.getElementsByTagName("response"); //chaque asso dans un tableau
    let n = list_assos.length;

    //On "crée" la page asso apr asso
    var assos =  document.getElementById("list_assos");
  
    for (let index = 0; index < n; index++) {
      assos.appendChild(affichage_asso(list_assos[index].innerHTML.trim()));
    };
  }
  xhttp.open("GET", "abs_path('functions/ajax/user_asso.php')");
  xhttp.send(); 
}

//AJAX - Liste des associations - fonction d'affichage asso par asso
function affichage_asso(infos_asso) {
  var asso_info_list = infos_asso.split(';'); //on sépare les info contenues (id;nom;logo)

  let asso = document.createElement("div"); //le div de l'asso
  $(asso).attr({
    id: asso_info_list[0],
    class: "association",
    onclick: "window.location.href = 'association.php?id="+encodeURIComponent(asso_info_list[0])+"';"
  });
  

  let image_asso = document.createElement("img");
  $(image_asso).attr({
    src: asso_info_list[2],
    class: "../img_association"
  });
  

  let nom_asso = document.createElement("h2");
  nom_asso.setAttribute("class", "nom_association");
  nom_asso.innerHTML = asso_info_list[1];
  

  let statut_asso = document.createElement("h2");
  statut_asso.setAttribute("class", "statut_association");
  statut_asso.innerHTML = asso_info_list[3];
  
  $(asso).append([
    $(image_asso),
    $(nom_asso),
    $(statut_asso)
  ]);
  return asso;
}


//Cloche de notification
var liste_invitations_missions;
$(document).ready(()=>{

  //Importation de l'API
  import(abs_path("JS/classes/User.js")).then((UserModule)=>{
    let user = new UserModule.User();

    //On récupère la liste des missions
    user.getListeInvitationsMissions().done((data)=>{

      //On enregistre la liste reçue dans une variable globale
      liste_invitations_missions = data;

      //Affichage du compteur de notifs
      $("#notif_bell_nb").text(liste_invitations_missions.length);
      if($("#notif_bell_nb").text()==0)
      {
        $("#notif_bell_nb").append(
          $('<div>').text("Aucune invitation à afficher")
        );
      }
      //Div pouvant afficher la liste de nos invits
      let liste_inv = $("<div>");

      //On agrandie le div avec les missions reçues
      liste_invitations_missions.forEach((elt)=>{

        //Contenu à ajouter
        let div = $("<div>").append([
          $('<div>').text(elt[0]), //Nom de la missions
          
          //Bouton pour accepter
          $('<div>').text('Accepter').attr({class: "miss_bout acc"}).click(function(event){
            let user = new UserModule.User();
            event.preventDefault(); //Empeche le defocus

            //Envoie de la requête
            user.sendReponseInvitMission(elt[1],true).done((data)=>{
              //Suppression des éléments si succès
              if(data["statut"]==1){
                div.remove(); //On suppprime la rangée
                $("#notif_bell_nb").text($("#notif_bell_nb").text()-1);
                if($("#notif_bell_nb").text()==0)
                {
                  $("#notif_bell_nb").append(
                    $('<div>').text("Aucune invitation à afficher")
                  );
                }
              }
            });
          }),

          //Bouton pour refuser
          $('<div>').text('Refuser').attr({class: "miss_bout ref"}).click(function(event){
            let user = new UserModule.User();
            event.preventDefault(); //Empeche le defocus

            //Envoie de la requête
            user.sendReponseInvitMission(elt[1],false).done((data)=>{
              //Suppression des éléments si succès
              if(data["statut"]==1){
                $("#notif_bell_liste_miss").focus();//Permet de ne pas perdre le focus
                div.remove(); //On supprime la rangée
                $("#notif_bell_nb").text($("#notif_bell_nb").text()-1);
                if($("#notif_bell_nb").text()==0)
                {
                  $("#notif_bell_nb").append(
                    $('<div>').text("Aucune invitation à afficher")
                  );
                }
              }
            });
          })
        ]);

        //On ajoute toute la rangée à la liste
        liste_inv.append(div);
      });

      //Ajout de cette liste à la barre des notifs
      liste_inv.attr({
        id: "notif_bell_liste_miss"
      }).on("blur",function(){
        $(this).fadeOut();
        console.log("fadeout");
      });
      $("#notif_bell_glob").append(liste_inv);
    }).fail((err)=>{
      console.log(err);
        });
  });

  $(document).on("click", function(event) {
    if (!$(event.target).closest("#notif_bell").length) {
      $("#notif_bell_liste_miss").fadeOut();
    }
  });

  //Gestion des clicks
  $("#notif_bell").click(function(){

    //Permet de masquer le menu quand on clique ailleurs
    
    $("#notif_bell_liste_miss").focus();
   



    if($("#notif_bell_liste_miss").is(":visible"))
    {
      $("#notif_bell_liste_miss").fadeOut();
    }else{
      $("#notif_bell_liste_miss").fadeIn();
    }
    
  });
});

