

// la fonction permet d'afficher les différentes catégories en cliquant sur le bouton "sélectionner les catégories", en allant chercher les catégories dans le fichier data/categories_event.php
function toggleCategories() {
    var categoriesContainer = document.getElementById("categoriesContainer");
    if (categoriesContainer.style.display === "none") {
        categoriesContainer.style.display = "block";
    } else {
        categoriesContainer.style.display = "none";
    }
}
// quand l'utilisateur clique sur le bouton "Valider", la fonction permet d'enregistrer les catégories dans l'id "categoriesContrainer" et de les fermer 
function validateCategories() {
    var categoriesContainer = document.getElementById("categoriesContainer");
    categoriesContainer.style.display = "none";
}
document.getElementById('date_debut').valueAsDate = new Date();
document.getElementById('date_fin').valueAsDate = new Date();
document.getElementById('heure_debut').defaultValue="00:00";
document.getElementById('heure_fin').defaultValue="00:00";


//Envoie du formulaire
var form = $("#form_event");
form.on("submit",function(event){
    event.preventDefault();
    array = new FormData(form[0]);
    
    import(abs_path("JS/classes/Event.js")).then((module) => {
        
        module.Event.insert(array).done(function(data){
            if(data["statut"]==1){
                window.location.href = abs_path("controller/static/form-merci.php");
            }else{
                console.log(data);
            }
        }).fail(function(error){
            console.log(error);
        });
    }).catch((error) => {
        console.error('Erreur lors du chargement du module :', error);
  });
  
  
    
});


