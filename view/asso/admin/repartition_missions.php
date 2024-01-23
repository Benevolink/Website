
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
    .liste_membres > .bloc_titre
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
    /* Ajoutez ici d'autres styles spécifiques à la classe aide_decision_case si nécessaire */
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
</style>



<div class="tableau_repartition">
    <table>
        <thead>
            <tr>
                <th>Membres</th>
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
    <div class="bloc_titre">
        Aide à la décision
    </div>
</div>
<br>

<script src="<?= BF::abs_path("JS/after/asso/admin/repartition_missions.js") ?>">
</script>