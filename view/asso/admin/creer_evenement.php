<link rel="stylesheet" href= "<?= BF::abs_path("CSS/creation_event.css") ?>">

<style>
    body {
        font-family: 'Corps', sans-serif;
    }

</style>

<div class= "case" style="width: min-content; min-width: 600px; margin: 10px;">
    <h2 style="margin: auto;width: max-content;">Créer un évènement</h2>

    <form id= "form_event" action="creer_evenement.php?id_asso=<?= $id_asso ?>" method="POST" enctype="multipart/form-data">
        <div class="case" style= "margin: auto; text-align: center;">
            <label for="nom" style="font-weight: bold;">Nom de l'évènement :</label>
            <input type="text" name="nom" id="nom" required>
        </div>
        <input type ="hidden" name="id_asso" value ="<?= $id_asso ?>"/>
        
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
            <p>Image évènement : <input name="uploadedfile" type="file" id="image_file" />
                  <input type="hidden" name="uploadedfile" /></p>

        </div>
        <input type="submit" value="Créer l'évènement" class="submit_button">
    </form>

</div>

<script type="text/javascript" src="<?= BF::abs_path("JS/after/asso/admin/creer_evenement.js") ?>">
</script>
