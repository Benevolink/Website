<?php

        
    /**
     * Method afficher_liste_benevoles
     *
     * Affiche la liste des membres de l'asso pour qu'on puisse ensuite les affecter
     * @return void
     */

    
    function afficher_liste_benevoles()
    {
        global $id_asso;
        require_once BF::abs_path("libs/Asso.php",true);
        $asso = new Asso($id_asso);
        $liste_membres = $asso->get_all_membres();

        foreach($liste_membres as $value)
        {
            ?>
            <div class = "membre_case" id_membre="<?= $value['id'] ?>" role="<?= $value['statut'] ?>" id_mission = "-1" >
                <?= $value["nom"]." ".$value["prenom"] ?>
            </div>
            <?php
        }
    }

    function afficher_liste_benevoles_data()
    {
        global $id_asso;
        require_once BF::abs_path("libs/Asso.php", true);
        $asso = new Asso($id_asso);
        $liste_membres = $asso->get_all_membres();

        $data = array();

        foreach($liste_membres as $value)
        {
            $data[] = array(
                'id' => $value['id'],
                'nom' => $value['nom'],
                'prenom' => $value['prenom'],
                'statut' => $value['statut']
            );
        }

        return $data;
    }
    
    /*
    function afficher_liste_missions()
    {
        global $id_asso;
        require_once BF::abs_path("libs/Asso.php",true);
        $asso = new Asso($id_asso);
        $liste_missions = $asso->liste_missions();
        require_once BF::abs_path("libs/Event.php",true);
        foreach($liste_missions as $mission)
        {
            $event = new Event($mission['id_event']);
            $liste_props = $event->get_all();
            $logo = $event->image_get();
            ?>
            <div class = "liste_membres mission_a_remplir" id_mission="<?= $mission['id_event'] ?>">
                <div class="bloc_titre"> <?= $liste_props["nom_event"] ?> </div>
            </div>
            <?php
        }
    }
    */
    /*
    function afficher_liste_membres_vide()
    {
        global $id_asso;
        require_once BF::abs_path("libs/Asso.php", true);
        $asso = new Asso($id_asso);

        $liste_membres = $asso->get_all_membres(); // Utilisez la même liste que pour la fonction afficher_liste_benevoles

        foreach ($liste_membres as $value) {
            ?>
            <div class="aide_decision_case" id_membre="aide_decision_<?= $value['id'] ?>" role="<?= $value['statut'] ?>" id_mission="-1">
                <?= $value["nom"] . " " . $value["prenom"] ?>
            </div>
            <?php
        }
    }
    */

    function afficher_liste_missions_tableau()
    {
        global $id_asso;
        require_once BF::abs_path("libs/Asso.php", true);
        $asso = new Asso($id_asso);
        $liste_missions = $asso->liste_missions();
        require_once BF::abs_path("libs/Event.php", true);

        foreach ($liste_missions as $mission) {
            $event = new Event($mission['id_event']);
            $liste_props = $event->get_all();
            ?>
            <th><?= $liste_props["nom_event"] ?></th>
            <?php
        }
    }

    function afficher_tableau_repartition()
    {
        global $id_asso;
        require_once BF::abs_path("libs/Asso.php", true);
        $asso = new Asso($id_asso);
        $liste_membres = $asso->get_all_membres(); // Utilisez la même liste que pour la fonction afficher_liste_benevoles

        foreach ($liste_membres as $membre) {
            ?>
            <tr>
                <td><?= $membre["nom"] . " " . $membre["prenom"] ?></td>
                <?php afficher_cases_mission($membre["id"]); ?>
            </tr>
            <?php
        }
    }

    function afficher_cases_mission($idMembre)
    {
        global $id_asso;
        require_once BF::abs_path("libs/Asso.php", true);
        $asso = new Asso($id_asso);
        $liste_missions = $asso->liste_missions();
        require_once BF::abs_path("libs/Event.php", true);

        foreach ($liste_missions as $mission) {
            $event = new Event($mission['id_event']);
            $liste_props = $event->get_all();
            ?>
            <td>
                <input type="checkbox" class="case_membre_mission" id_membre="<?= $idMembre ?>" id_mission="<?= $mission['id_event'] ?>">
            </td>
            <?php
        }
    }   

    function afficher_maximisation()
    {
        ?>
        <div class="maximisation_cursers">
            <br>
            <p>Maximisation du nombre de missions remplies :</p>
            <br>
            <input type="range" min="1" max="5" value="1" class="curseur_maximisation" id="curseurMaximisation">
            <span class="valeur_curseur_maximisation">1</span>
        </div>

        <div class="valider_button_maximisation">
            <button id="validerMaximisation">Valider le critère de la maximisation</button>
        </div>

        <div class="modifier_button">
            <button id="modifierMaximisation" style="display:none;">Modifier le critère de la maximisation</button>
        </div>
        <?php
    }

    function afficher_liste_missions()
{
    global $id_asso;
    require_once BF::abs_path("libs/Asso.php",true);
    $asso = new Asso($id_asso);
    $liste_missions = $asso->liste_missions();
    require_once BF::abs_path("libs/Event.php",true);

    ?>
    <div class="priorite_message">
        <br>
        <p>Priorité des missions</p>
        <p>Echelle :</p>
        <p>1 : pas prioritaire</p>
        <p>3 : moyennement prioritaire</p>
        <p>5 : très prioritaire</p>
        <br>
    </div>

    <?php
    
    foreach($liste_missions as $mission)
        {
            $event = new Event($mission['id_event']);
            $liste_props = $event->get_all();
            $logo = $event->image_get();
            ?>
            <div class="mission_a_remplir">
                <?= $liste_props["nom_event"] ?>
                <input type="range" min="1" max="5" value="1" class="curseur_mission non_valide" id_mission="<?= $mission['id_event'] ?>">
                <span class="valeur_curseur">1</span>
            </div>
            <?php
        }
    ?>
        <div class="valider_button">
            <button id="validerPriorites">Valider</button>
        </div>
    <?php
        // Bouton Modifier (initialement caché)
        ?>
        <div class="modifier_button">
            <button id="modifierPriorites" style="display:none;">Modifier</button>
        </div>
    <?php
    }

    function afficher_anciennete()
    {
        ?>
        <div class="anciennete_cursers">
            <br>
            <p>Ancienneté :</p>
            <br>
            <input type="range" min="1" max="5" value="1" class="curseur_anciennete" id="curseurAnciennete">
            <span class="valeur_curseur_anciennete">1</span>
        </div>

        <div class="valider_button_anciennete">
            <button id="validerAnciennete">Valider le critère d'ancienneté</button>
        </div>

        <div class="modifier_button">
            <button id="modifierAnciennete" style="display:none;">Modifier le critère d'ancienneté</button>
        </div>
        <?php
    }

    function afficher_distance()
    {
        ?>
        <div class="distance_cursers">
            <br>
            <p>Distance :</p>
            <br>
            <input type="range" min="1" max="5" value="1" class="curseur_distance" id="curseurDistance">
            <span class="valeur_curseur_distance">1</span>
        </div>

        <div class="valider_button_distance">
            <button id="validerDistance">Valider le critère de la distance</button>
        </div>

        <div class="modifier_button">
            <button id="modifierDistance" style="display:none;">Modifier le critère de la distance</button>
        </div>
        <?php
    }




?>