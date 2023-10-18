
<script>
var roles = ["ADMIN","MEMBRE","ATTENTE","EXCLURE"];
//document.body.setAttribute("onclick","suppr_menu();");
function suppr_menu(){
  let liste =document.body.getElementsByClassName("menu_roles");
  if(liste != null){
    for(i=0;i<liste.length;i++){
      liste[i].remove();
    }
    document.body.setAttribute("onclick","");
  }
  
}
function menu_roles(elt,id_asso,id_membre){
  suppr_menu();
  
  let ul = document.createElement("ul");
  let temp = "";
  roles.forEach(function(element){
    let li = document.createElement("li");
    li.innerHTML = element;
    temp = element;
    if(element=="EXCLURE"){
      temp = "NONE";
    }
    li.setAttribute("onclick","affecterRole("+id_asso+","+id_membre+",'"+temp+"')");
    
    ul.appendChild(li);
  })
  mousePos = { x: event.clientX, y: event.clientY };
  
  ul.style.left = mousePos.x+"px";
  ul.style.top = mousePos.y+"px";
  ul.style.position = "absolute";
  ul.setAttribute("class","menu_roles");
  //document.body.setAttribute("onclick","suppr_menu();");
  document.body.appendChild(ul);
  
}

function affecterRole(id_asso,id_membre,role){
  suppr_menu();
  let xhttp = new XMLHttpRequest();
  xhttp.open("GET", "<?= BF::abs_path("functions/ajax/changer_role.php?")?>"+"id_asso="+encodeURIComponent(id_asso)+"&id_user="+encodeURIComponent(id_membre)+"&role="+encodeURIComponent(role));
  xhttp.onload = function() { //On attend la réponse
    const xmlDoc = xhttp.responseXML;
     if(xmlDoc != null){ //On vérifie que la réponse n'est pas nulle
       window.location.href= window.location.href;
     }
  }
  xhttp.send();
}
</script>