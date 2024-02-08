
<style>
    .liste_membres{
        margin: 10px;
        display: inline-block;
        border-radius: 20px;
        background-color: rgb(240, 240, 240);
        padding: 20px;
        min-width: 400px;
        min-height: 100px;
       
    }

    #liste_membre2{
        background-color: #fff3e0; /* Orange très clair */
    }
    

    .liste_membres > .aide_decision
    {
        font-weight: bolder;
        font-size: 150%;
        margin-bottom: 10px;
    }

    .membre_case{
        padding: 10px;
        font-weight: bold;
        width: 200px;
        text-overflow: ellipsis;
        text-align: center;
        cursor: pointer;
        background-color: white;
        height: 40px;
    }

    .membre_case:hover{
        font-size: 105%;
    }

    .aide_decision_case {
    padding: 10px;
    font-weight: bold;
    cursor: pointer;
    background-color: white;
    display: flex; /* Utiliser le modèle de boîte flexible */
    justify-content: center; /* Centrer horizontalement le contenu */
    margin-top: 20px; /* Ajouter un espace en haut */
    
    }

    @keyframes clignoter{
        0% {
            background-color: rgb(240, 240, 240);
        }
        50% {
            background-color: rgb(210, 210, 210);
        }
        100% {
            background-color: rgb(240, 240, 240);
        }
    }

    .mise_en_evidence_missions
    {
        cursor: pointer;
        animation: clignoter 1s  infinite ease-in-out;
    }

    .tableau_repartition{
        font-family: Corps;
        src: url(fonts/Nexa-Heavy.woff2) format("woff2");
        font-size: 20px;
        margin: 30px;
    }

    .aide_decision{
        font-family: Corps;
        src: url(fonts/Nexa-Heavy.woff2) format("woff2");
        font-size: 20px;
        background-color: #fff3e0;
        
    }

    .tableau_repartition table {
    border-collapse: collapse; /* Fusionne les bordures des cellules */
    width: 100%; /* Utilise toute la largeur disponible */
}

.tableau_repartition th, .tableau_repartition td {
    border: 1px solid black; /* Bordure de chaque cellule */
    padding: 8px; /* Ajoute un espacement autour du contenu */
    text-align: center; /* Centre le contenu dans chaque cellule */
}

.tableau_repartition th {
    background-color: #f2f2f2; /* Couleur de fond pour les cellules d'en-tête */
}

#intro_aide{
    font-family: Corps;
    src: url(fonts/Nexa-Heavy.woff2) format("woff2");
    margin: 15px;    
}

#titre{
    font-weight: bold;
    text-align: center;
}

#info_aide{
    font-size: 16px;
    background-color: #d9f7d6; /* Couleur de fond vert clair */
    border-radius: 10px; /* Coins arrondis */
    padding: 20px; /* Espacement intérieur */
    line-height: 1.5; /* Hauteur de ligne pour un espacement confortable */
    margin: 10px;
}

#photo_decision{
    width: 180px;
    height: auto;
    float: left; /* Pour positionner l'image à gauche du paragraphe */
    border: 1px solid rgba(255, 165, 0, 0.5); /* Bordure orange très clair */
    margin-right: 10px; /* Pour ajouter un peu d'espace entre l'image et le paragraphe */
}


</style>
<div id="intro_aide">
<h2 id="titre" > <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span> 
 Interface d'aide à la décision pour les bénévoles et associations </h2>

 <div id="container">
    <img id="photo_decision" src="<?= BF::abs_path("media/img/aide_decision.jpg") ?>" alt="Image d'aide à la décision">
    <p id="info_aide"> Afin de répartir convenablement vos bénévoles à vos missions, Benevolink vous propose d'utiliser notre algorithme d'aide à la décision ! <br> Celui-ci prend en compte les critères individuels des bénévoles (disponibilité, distance, compétences, etc) et les besoins spécifiques des associations (priorité des missions, ancienneté des bénévoles, etc). </p>
</div>

</div> 
<div class="tableau_repartition">
    <table>
        <thead>
            <tr>
                <th> <span class="glyphicon glyphicon-user" aria-hidden="true"></span> Membres</th>
                <?php afficher_liste_missions_tableau(); ?>
            </tr>
        </thead>
        <tbody id="liste_membre2">
            <?php afficher_tableau_repartition(); ?>
        </tbody>
    </table>
</div>
<br>

<div class="aide_decision_case" id="liste_membres_affectes">
    <div class="aide_decision">
       <button> <span class="glyphicon glyphicon-flash" aria-hidden="true"></span> Appliquer l'algorithme d'aide à la décision </button>
    </div>
</div>

<br>
<br>

<script>
    var membresAffectations = {}; // Tableau pour stocker les affectations des membres
    var listeMembres = <?= json_encode(afficher_liste_benevoles_data()) ?>;
</script>

<script src="<?= BF::abs_path("JS/after/asso/admin/repartition_missions.js") ?>">
</script>