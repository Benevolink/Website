<?php
?>
<link rel="stylesheet" href= "<?= BF::abs_path("CSS/creation_event.css") ?>">
<div class= "case" style="width: min-content; min-width: 600px; margin: 10px;">
    <h2 style="margin: auto;width: max-content;">Créer un sondage</h2>

    <form action="creer_evenement.php?id_asso=<?= $_GET['id_asso'] ?>" method="POST" enctype="multipart/form-data">
        <div class="case" style= "margin: auto; text-align: center;">
            <label for="question" style="font-weight: bold;">Question :</label>
            <textarea placeholder="Entrez vore question..." name="question"  rows="10" class="desc" id="question"></textarea>
        <br>
        </div>
        
        <div class="case">
            <button id="add_reponse" type="button"> Ajouter une réponse</button>
            <div id="reponse_cont">
            </div>
            <input id="reponses" name="reponses" type="hidden" />
        </div>

        <input id="submit_button" type="submit" value="Créer le sondage" class="submit_button">
    </form>

    
</div>
