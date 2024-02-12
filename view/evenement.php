<link href="<?= BF::abs_path("CSS/evenement.css") ?>" rel="stylesheet"/>
<input type = "hidden" id="value_id_event" value="<?= $id_event ?>"/>
<div class="case" style="width: 900px;<?php if($iframe){echo "margin: 0px;";} //controller?>">
    <div class="titre_event">
        <?= $infos["nom_event"] ?>
    </div>
    <div>

    <div id="logo_img">
    <?php
    //Affichage du logo
        
        if($logo){
            ?>
            <img style ="width: 200px; float: right; height: auto;" src="<?= $logo ?>">
            <?php
            
        ?>
    </div>
            
        <div class="event_a_droite">
            <div class="event_infos">
                <?php afficher_dates(); ?>
            </div>
            <div class="desc">
                <div class="titre_rubrique_event">
                    Informations
                </div>
                <?php 
                    afficher_visu();
                    ?>
                    <img src="<?= BF::abs_path("media/img/eye.png") ?>" style="width: 13px; display: inline-block;">
                <br> <br>
                Nombre d'inscrits : <strong><?= $infos["nb_personnes"] ?></strong>
            </div>
            
        </div>
        <div style="clear:both;">
        </div>
        <?php
        }
    ?>
    </div>
    <div style="display: flex">
        <div class="event_infos" style="flex: auto; margin-top: 5px;">
            <div class="titre_rubrique_event">
                        Description
            </div>
            <?= $infos["desc"] ?>
        </div>
    </div>
    <br>
    <div id="bouton_rejoindre">
        Rejoindre
    </div>
</div>
<div style = "height: 20px;">
</div>
<?php

if($iframe){
    ?>
    <script>
        let body = document.body;
        body.style.width = "min-content";
        const html = document.documentElement;
        const height = body.scrollHeight;
        document.body.setAttribute("h_height",height);
        const width = body.scrollWidth;
        document.body.setAttribute("h_width",width);
    </script>
    <?php

}
?>
<script type="text/javascript" src="<?= BF::abs_path("JS/after/evenement.js")?>"></script>

<style>

    .event_infos{
        font-family: Corps;
      src: url(fonts/Nexa-Heavy.woff2) format("woff2");
      
    }

    .titre_event{
        font-family: Corps;
      src: url(fonts/Nexa-Heavy.woff2) format("woff2");
      font-size:30px;
      
    }
#bouton_rejoindre {
    background-color: lightgreen; /* Couleur de fond */
    border-radius: 20px; /* Rayon de l'arrondi */
    width: 200px; /* Largeur du bouton */
    padding: 10px; /* Espacement interne */
    text-align: center; /* Centrage du texte */
    margin: 0 auto; /* Centrage horizontal */
    font-size: 20px;
      font-family: Corps;
      src: url(fonts/Nexa-Heavy.woff2) format("woff2");
      font-weight: bold;
      cursor: pointer;
}
.titre_rubrique_event{
    src: url(fonts/Nexa-Heavy.woff2) format("woff2");
      font-size:20px;
}

.desc{
    font-family: Corps;
      src: url(fonts/Nexa-Heavy.woff2) format("woff2");
      font-size:16px;
      text-align: center;
      background-color:lightgreen;

}
.case{
    background-color:lightyellow;
    border-radius: 10px; /* Rayon de l'arrondi */


}

#logo_img{
    border-radius: 10px; /* Rayon de l'arrondi */
}
</style>