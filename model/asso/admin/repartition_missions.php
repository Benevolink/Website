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

    function afficher_liste_membres_vide()
    {
        global $id_asso;
        require_once BF::abs_path("libs/Asso.php", true);
        $asso = new Asso($id_asso);

        $liste_membres = $asso->get_all_membres(); // Utilisez la même liste que pour la fonction afficher_liste_benevoles

        foreach ($liste_membres as $value) {
            ?>
            <div class="aide_decision_case" id_membre="<?= $value['id'] ?>" role="<?= $value['statut'] ?>" id_mission="-1">
                <?= $value["nom"] . " " . $value["prenom"] ?>
            </div>
            <?php
        }
    }



?>