<script src="<?= BF::abs_path("JS/iframe_mission.js") ?>"></script>
<script>
    //Permet de créer une case d'event
    function creer_wrapper(lien_img,desc,wrapper){
      $(wrapper).append(
        $("<div>").attr({class: "wrapper_enfant"}).append([
          $("<img>").attr({src: lien_img}),
          $("<div>").append(desc)
        ])
      )
    }

  
    //Permet de créer une rubrique catégorie
    function creer_categorie_wrapper(nom){
      
      
      let cate = $("<div>");
      cate.attr({class: "cate"});
      //----------  Création du titre
      cate.append(
        $("<div>").attr({class: "case_titre"}).append(nom)
      );
      //----------  Création du wrapper
      let wrapper = document.createElement("div");
      
      wrapper.setAttribute("class","wrapper");
      creer_wrapper("<?= BF::abs_path("media/img/img3.jpg") ?>","Ecoute, soutien des personnes et accompagnement :  lutte contre l’isolement , aide psychologique ",wrapper);
      cate.append($(wrapper));
      wrapper.setAttribute("class","wrapper");
      creer_wrapper("<?= BF::abs_path("media/img/img3.jpg") ?>","Ecoute, soutien des personnes et accompagnement :  lutte contre l’isolement , aide psychologique ",wrapper);
      cate.append($(wrapper));
      
      $("#wrapper_all").append(cate);
    }

    //Permet de rétrécir le menu des catégories
    function retrecir(element){
      $("#liste_cate").css({width: "50px"});
      $(".cate_missions_checkbox").css({transform: "translate(-400px)"});
      element.setAttribute("onclick","expand(this);");
    }
    
    //Permet d'agrandir le menu des catégories
    function expand(element){
      $("#liste_cate").css({width: "800px"});
      $(".cate_missions_checkbox").css({transform: "translate(-15px)"});
      element.setAttribute("onclick","retrecir(this);");
    }
  </script>