<link href="<?= BF::abs_path("CSS/evenement.css") ?>" rel="stylesheet"/>
<div class="case" style="width: 800px;<?php if($iframe){echo "margin: 0px;";} //controller?>">
    <div class="titre_event">
        <?= $infos["nom_event"] ?>
    </div>
    <div>
    <?php
    //Affichage du logo
        
        if($logo){
            foreach (glob($path."media/logo/event/".$id_event.".*") as $filename){
                ?>
                <img style ="width: 200px; float: left; height: 200px;" src="<?= BF::abs_path("media/logo/event/".basename($filename))?>">
                <?php
            }
            
        ?>
            
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
            <?= $desc ?>
        </div>
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