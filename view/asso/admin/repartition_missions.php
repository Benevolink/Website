
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

<div class="liste_membres" id="liste_membres_default">
    <div class="bloc_titre">
        Liste des membres non affectés
    </div>
    <?= afficher_liste_benevoles() ?>
</div>
<br>

<div class="liste_membres" id="liste_membres_default">
    <div class="bloc_titre">
        Liste des membres affectés
    </div>
</div>
<br>

<?= afficher_liste_missions() ?>

<script src="<?= BF::abs_path("JS/after/asso/admin/repartition_missions.js") ?>">
</script>