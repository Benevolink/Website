<script>
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
        document.getElementById('event_date_debut').valueAsDate = new Date();
        document.getElementById('event_date_fin').valueAsDate = new Date();
        document.getElementById('event_heure_debut').defaultValue="00:00";
        document.getElementById('event_heure_fin').defaultValue="00:00";

    </script>