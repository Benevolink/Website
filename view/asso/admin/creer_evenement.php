<?php
include $path."/media/data/phpliteadmin.config.sample.php";
include $path."/media/data/categories_event.php";

if($_SERVER["REQUEST_METHOD"] === "POST" && BF::is_connected() && BF::is_posted('id_asso') && BF::is_admin($_SESSION["user_id"], $_GET['id_asso'])) {
    try {
        // On vérifie qu'on s'est bien connecté à la BDD
        $db->beginTransaction();

        try {
            $id_asso = $_GET['id_asso'];
            $nomEvenement = $_POST["nom"];
            $heureDebutStr = $_POST["heure_debut"];
            $dateDebut = $_POST["date_debut"];
            $heureFinStr = $_POST["heure_fin"];
            $dateFin = $_POST["date_fin"];

            // Valider l'heure de début
            if (!preg_match('/^([01]?[0-9]|2[0-3])\:+[0-5][0-9]$/', $heureDebutStr)) {
                // Gérer l'erreur si l'heure de début n'est pas au bon format
                echo "L'heure de début n'est pas valide (utilisez le format HH:MM).";
                exit;
            }
            
            $heureDebut = strtotime($dateDebut . ' ' . $heureDebutStr);
            
            // Valider l'heure de fin
            if (!preg_match('/^([01]?[0-9]|2[0-3])\:+[0-5][0-9]$/', $heureFinStr)) {
                // Gérer l'erreur si l'heure de fin n'est pas au bon format
                echo "L'heure de fin n'est pas valide (utilisez le format HH:MM).";
                exit;
            }
            
            $heureFin = strtotime($dateFin . ' ' . $heureFinStr);

            // Insertion des données horaires
            $insertHoraireQuery = "INSERT INTO horaire (date_debut, date_fin, heure_debut, heure_fin) VALUES (?, ?, ?, ?)";
            BF::request($insertHoraireQuery,[strtotime($dateDebut), strtotime($dateFin), $heureDebut, $heureFin]);
            $id_horaire = $db->lastInsertId();
            $db->commit();
            $db->beginTransaction();
          
            $description = $_POST["description"];
            
            $org = $_POST["coorg"];
            $visu = $_POST["visu"];

            if($description != null){
                BF::request($insertionReq,[$id_event, "desc", $description]);
            }
                        
            $nb_personnes = isset($_POST["nb_personnes"]) ? intval($_POST["nb_personnes"]) : 0;
            $adresse = $_POST["adresse"];

            $insertLieuQuery = "INSERT INTO lieu (adresse) VALUES (?)";
            BF::request($insertLieuQuery, [$adresse]);
            $id_lieu = $db->lastInsertId();
            
            $insertionReq = "INSERT INTO evenements (id_asso, nom_event, id_horaire,nb_personnes, visu, desc, id_lieu) 
                             VALUES (?, ?, ?, ?, ?, ?, ?)";
            $db->commit();
            $db->beginTransaction();
            BF::request($insertionReq,[$id_asso,$nomEvenement,$id_horaire, $nb_personnes, $visu, $description, $id_lieu]);
          
            $id_event = $db->lastInsertId();
            $req = "INSERT INTO prop_evenements (id_event, prop_nom, valeur) VALUES (?, ?, ?)";
            BF::request($req,[$id_event, "visu", $visu]);
            
            if($description != null){
                BF::request($req,[$id_event, "desc", $description]);
            }
            //Si l'évènement est récurrent
            $eventRecurrent = isset($_POST["event_recurrent"]) ? 1 : 0;
            if($eventRecurrent == 1){
                $Frequence = $_POST["frequence"];
                BF::request($req,[$id_event, "freq", $Frequence]);
                BF::request($insertHoraireQuery,[$id_horaire, "frequence", $Frequence]);
            }
            if($org != null && !BF::equals($org,"")){
                BF::request($req,[$id_event, "coorg", $org]);
            }
            BF::request("INSERT INTO membres_evenements (id_event, id_membre, statut) VALUES (?, ?, ?)",[$id_event, $_SESSION["user_id"],3],false);
            $db->commit();
            //Si on a upload une image

            if(isset($_FILES["uploadedfile"])){
                
                $destinationPath = $path."media/logo/event/".basename($_FILES['uploadedfile']['name']);
                $fileNameParts = explode('.',basename($_FILES['uploadedfile']['name']));
                $ext = end($fileNameParts);
                array_map('unlink', glob($path."media/logo/event/".$id_event.".*")); //On supprime les fichiers résiduels
                if(copy($_FILES['uploadedfile']['tmp_name'], $destinationPath)) {
                echo "Le fichier ".  basename( $_FILES['uploadedfile']['name'])." a bien été téléversé";
                $newDestinationPath = "media/logo/event/".$id_event.".".$ext;
                rename($destinationPath, $path.$newDestinationPath);
                } else{
                echo "Il y a eu une erreur pour poster le fichier, réessayez.";
                }
                
                //UPDATE le chemin vers l'image dans la BDD
     
                BF::request($req,[$id_event,"logo","TRUE"]);
            }


            // Redirection vers une page de succès
            header("Location: ../../static/form-merci.php");
            exit();
        }catch(Exception $e){
            echo "Erreur : ".$e->getMessage();
        }
    } catch (PDOException $e) {
        $db->rollBack();
        echo "Erreur : " . $e->getMessage();
    }
}
?>
<link rel="stylesheet" href= "<?= BF::abs_path("CSS/creation_event.css") ?>">
<div class= "case" style="width: min-content; min-width: 600px; margin: 10px;">
    <h2 style="margin: auto;width: max-content;">Créer un évènement</h2>

    <form action="creer_evenement.php?id_asso=<?= $_GET['id_asso'] ?>" method="POST" enctype="multipart/form-data">
        <div class="case" style= "margin: auto; text-align: center;">
            <label for="nom" style="font-weight: bold;">Nom de l'évènement :</label>
            <input type="text" name="nom" id="nom" required>
        </div>
        
        <div class="case">
            
            <div style="margin: 5px; border-bottom: 0.1px solid grey; padding-bottom: 15px;">
                <label for="date_debut">Date début </label>
                <input type="date" name="date_debut" id="date_debut" required>
                <input type="time" name="heure_debut" id="heure_debut" required style="float:right;">
                <label for="heure_debut" style="float:right;"> Heure début   </label>
            </div>

            <div style="margin: 5px; padding-top: 10px;">
                <label for="date_fin">Date fin </label>
                <input type="date" name="date_fin" id="date_fin" required>
                <input type="time" name="heure_fin" id="heure_fin" required style="float:right;">
                <label for="heure_fin" style="float:right;"> Heure fin   </label>
            </div>
        </div>
        <textarea placeholder="Description de l'évènement..." name="description"  rows="10" class="desc"></textarea>
        <br>
        <div class="case" style="clear: both;">
            <div class="case" style="border: none; margin: 10px; float: left; width: max-content;">
                <label for="nb_personnes">Nombre de personnes requises</label>
                <input type="number" name="nb_personnes" id="nb_personnes">
            </div>
            <div class="case" style="border: none; margin: 10px; float: right; width: max-content;">
                <label for="lieu">Lieu de l'événement</label>
                <input type="text" name="lieu" id="lieu">
            </div>
        
            <div class="case" style="border: none; margin: 10px; float: left; width: max-content;">
                <label for="event_recurrent">Evènement récurrent </label>
                <input type="checkbox" name="event_recurrent" id="event_recurrent">
            </div>
            <div class="case" style="border: none; margin: 10px; float: right; width: max-content;">
                <label for="frequence">Fréquence </label>
                <select name="frequence">
                    <option value="">-- Choisissez une option --</option>
                    <option value="quot">Quotidienne</option>
                    <option value="hebd">Hebdomadaire</option>
                    <option value="mens">Mensuel</option>
                    <option value="annu">Annuel</option>
                </select>
            </div>
            <div style="clear:both;"></div>
            <div class="case" style="border-radius: 5px; padding: 5px; margin: 10px; float: left; width: max-content;">
                <label for="coorg">Ajouter des coorganisateurs </label>
                <input type="hidden" name="coorg" id="coorg">
            </div>
            <div class="case" style="border: none; margin: 10px; float: right; width: max-content;">
                <label for="visu">Visibilité </label>
                <select name="visu">
                    <option value="publique">Publique</option>
                    <option value="membres">Membres seulement</option>
                    <option value="modos">Modérateurs seulement</option>
                </select>
            </div>
            <div style="clear:both;"></div>
            <p>Image évènement : <input name="uploadedfile" type="file" />
                  <input type="hidden" name="uploadedfile" /></p>

        </div>
        <input type="submit" value="Créer l'évènement" class="submit_button">
    </form>

    
</div>
