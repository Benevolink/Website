
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

    <style>
    /* Ajoutez ces styles CSS */
    .modifier_button {
        margin-top: 20px;
    }

    .modifier_button button {
        background-color: #4caf50;
        color: white;
        border: none;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        cursor: pointer;
        border-radius: 5px;
    }

    .modifier_button button:hover {
        background-color: #45a049;
    }

    /* Ajoutez ces styles CSS */
    .curseur_mission.non_modifiable {
        opacity: 0.5;
        /* Réduire l'opacité pour indiquer qu'il a été validé */
        cursor: not-allowed;
        /* Changer le curseur pour indiquer qu'il est non modifiable */
    }

    /* Ajoutez ces styles CSS */
    .modifier_anciennete_button {
        margin-top: 20px;
    }

    .modifier_anciennete_button button {
        background-color: #4caf50;
        color: white;
        border: none;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        cursor: pointer;
        border-radius: 5px;
    }

    .modifier_anciennete_button button:hover {
        background-color: #45a049;
    }

    /* Ajoutez ces styles CSS */
    .curseur_anciennete.non_modifiable {
        opacity: 0.5;
        /* Réduire l'opacité pour indiquer qu'il a été validé */
        cursor: not-allowed;
        /* Changer le curseur pour indiquer qu'il est non modifiable */
    }

    /* Ajoutez ces styles CSS */
    .modifier_distance_button {
        margin-top: 20px;
    }

    .modifier_distance_button button {
        background-color: #4caf50;
        color: white;
        border: none;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        cursor: pointer;
        border-radius: 5px;
    }

    .modifier_distance_button button:hover {
        background-color: #45a049;
    }

    /* Ajoutez ces styles CSS */
    .curseur_distance.non_modifiable {
        opacity: 0.5;
        /* Réduire l'opacité pour indiquer qu'il a été validé */
        cursor: not-allowed;
        /* Changer le curseur pour indiquer qu'il est non modifiable */
    }

    /* Ajoutez ces styles CSS */
    .modifier_maximisation_button {
        margin-top: 20px;
    }

    .modifier_maximisation_button button {
        background-color: #4caf50;
        color: white;
        border: none;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        cursor: pointer;
        border-radius: 5px;
    }

    .modifier_maximisation_button button:hover {
        background-color: #45a049;
    }

    /* Ajoutez ces styles CSS */
    .curseur_maximisation.non_modifiable {
        opacity: 0.5;
        /* Réduire l'opacité pour indiquer qu'il a été validé */
        cursor: not-allowed;
        /* Changer le curseur pour indiquer qu'il est non modifiable */
    }

</style>

<div class="tableau_repartition" id="tableau_repartition">
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
<script type="text/javascript">
    id_asso = <?= $_GET["id_asso"] ?>;
</script>
<div id="solutions"></div>

<div class="aide_decision_case" id="liste_membres_affectes">
    <div class="aide_decision" id="bouton_aide_decision">
        Aide à la décision
    </div>
</div>
<br>

<button id="valider">Valider</button> 
<br>

<div class="maximisation_cursers">
    <?php afficher_maximisation(); ?>
</div>

<div class="modifier_button">
    <button id="modifierMaximisation" style="display:none;">Modifier le critère de maximisation</button>
</div>
<div class="confirmation_message_maximisation" style="display:none;">
    <p>Voulez-vous valider le critère de maximisation ? Vous aurez la possibilité de remodifier ensuite.</p>
    <button id="accepterConfirmationMaximisation">Accepter</button>
    <button id="annulerConfirmationMaximisation">Annuler</button>
</div>

<br>

<div class="missions_cursers">
    <?php afficher_liste_missions(); ?>
</div>

<div class="modifier_button">
    <button id="modifierPriorites" style="display:none;">Modifier</button>
</div>

<div class="confirmation_message" style="display:none;">
    <p>Voulez-vous valider les priorités des missions ? Vous aurez la possibilité de remodifier ensuite.</p>
    <button id="accepterConfirmation">Accepter</button>
    <button id="annulerConfirmation">Annuler</button>
</div>

<div class="anciennete_cursers">
    <?php afficher_anciennete(); ?>
</div>

<div class="modifier_button">
    <button id="modifierAnciennete" style="display:none;">Modifier l'ancienneté</button>
</div>
<div class="confirmation_message_anciennete" style="display:none;">
    <p>Voulez-vous valider le critère d'ancienneté ? Vous aurez la possibilité de remodifier ensuite.</p>
    <button id="accepterConfirmationAnciennete">Accepter</button>
    <button id="annulerConfirmationAnciennete">Annuler</button>
</div>

<br>

<div class="distance_cursers">
    <?php afficher_distance(); ?>
</div>

<div class="modifier_button">
    <button id="modifierDistance" style="display:none;">Modifier la distance</button>
</div>
<div class="confirmation_message_distance" style="display:none;">
    <p>Voulez-vous valider le critère de distance ? Vous aurez la possibilité de remodifier ensuite.</p>
    <button id="accepterConfirmationDistance">Accepter</button>
    <button id="annulerConfirmationDistance">Annuler</button>
</div>

<br>

<div class="liste_membres">
    <?php
    $liste_membres = afficher_liste_benevoles_data();
    foreach ($liste_membres as $membre) {
        echo '<div class="membre_case" id_membre="' . $membre['id'] . '" role="' . $membre['statut'] . '" id_mission="-1">' . $membre['nom'] . ' ' . $membre['prenom'] . '</div>';
    }
    ?>
</div>

<script>
    var membresAffectations = {}; // Tableau pour stocker les affectations des membres
    var listeMembres = <?= json_encode(afficher_liste_benevoles_data()) ?>;
</script>

<script src="<?= BF::abs_path("JS/after/asso/admin/repartition_missions.js") ?>">
</script>
<input type="submit" id="bouton_ok_aide_decision" value="Aide à la décision"/>
<script>
    $("#bouton_ok_aide_decision").on("click",function(){
    import(abs_path("JS/classes/Asso.js")).then((module)=>{
        let asso = new module.Asso(id_asso);
        asso.aide_decision().done((data)=>{
            $("#tableau_repartition").find("input").attr({
                checked: false
            });
            let liste = $('.case_membre_mission');
            
            data.forEach(element => {
                if(!isNaN(element[0]))
                {
                    liste.each(function(){
                        if($(this).attr("id_membre") == element[1] && $(this).attr("id_mission") == element[0]){
                            $(this).prop("checked","true");
                        }
                    });
                    
                }
            });
        });
    });
    });
    $(document).ready(()=>{$(".liste_membres").hide();});
</script>