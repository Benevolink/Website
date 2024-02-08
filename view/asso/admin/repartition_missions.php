
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
    width: 200px;
    text-overflow: ellipsis;
    text-align: center;
    cursor: pointer;
    background-color: white;
    height: 40px;
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
    }

    .aide_decision{
        font-family: Corps;
        src: url(fonts/Nexa-Heavy.woff2) format("woff2");
        font-size: 15px;
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
</style>

<div class="tableau_repartition">
    <table>
        <thead>
            <tr>
                <th> <span class="glyphicon glyphicon-user" aria-hidden="true"></span> Membres</th>
                <?php afficher_liste_missions_tableau(); ?>
            </tr>
        </thead>
        <tbody>
            <?php afficher_tableau_repartition(); ?>
        </tbody>
    </table>
</div>
<br>

<div class="aide_decision_case" id="liste_membres_affectes">
    <div class="aide_decision">
       <button> Appliquer l'algorithme d'aide à la décision <button>
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