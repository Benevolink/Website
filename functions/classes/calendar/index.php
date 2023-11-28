<?php 
require_once __DIR__.'/links.php';
require_once __DIR__.'/../../basic_functions.php';

function creer_select_categorie($key,$value){
    ?>
    <input type="checkbox" name=<?= "'sel_cate_{$key}'"?> id=<?= "'sel_cate_{$key}'" ?> class="cate_missions_checkbox"/>
    <div class="label_cate"> <?= $value[AttributsTables::DOMAINE_NOM] ?> </div>
    
    <br>
    <?php
  }


?>


    <style>
        #calendar_days{
            grid-auto-rows: <?= $case_width ."px" ?>;
            grid-auto-columns: <?= $case_height."px" ?>;
        }
        .calendar_jour{
            --couleur_case: rgb(150, 230, 175);
            --couleur_case_hors_mois: rgb(200,200,200);
            height: <?= $case_height.'px'?>;
            width: <?= $case_width.'px'?>;
            border: 1px solid black;
            clear: both;
            margin-right: -1px;
            margin-right: -1px;
            padding-left: 0px;
            background-color: var(--couleur_case);
        }
    </style>
        <script src="<?= BF::abs_path("functions/classes/calendar/jquery.js")?>"></script>
        
        <link href="<?= BF::abs_path("functions/classes/calendar/stylesheet.css") ?>" rel="stylesheet"/>

        <form method="get" action="<?= basename($_SERVER['REQUEST_URI']) ?>" id="calendar_form_lang">
            <label for="lang">
                <?= ucfirst($lex["pick_lang"])." "?>
            </label>
            <select name = "lang" id="lang" onchange="this.parentElement.submit();">
                <option value="fr" <?php if(same("fr",valid("lang"))||same("",valid("lang")))echo "selected";?>>FR</option>
                <option value="en" <?php if(same("en",valid("lang")))echo "selected";?>>EN</option>
            </select>
        </form>

        <div id="calendar">
            <form method="post" action="<?= $_SERVER['REQUEST_URI'] ?>" id="calendar_form_date">
                
                <div class="calendar_changer_mois" onclick="change_month(this,-1)">
                    <?= ucfirst($lex["previous_month"]) ?>
                </div>
                <?= ucfirst($lex["month"][date("n",$date_debut_mois)-1])." ".date("Y",$date_debut_mois) ?>
                <div class="calendar_changer_mois" onclick="change_month(this,1)">
                <?= ucfirst($lex["next_month"]) ?>
                </div>
                <input type="hidden" id="current_month" name="current_month" value="<?=$current_increment?>"/>
            </form>


            <div id="calendar_days">
                <?php
                if(BF::is_connected()){
                    $calendrier = new cal_Calendar($date_debut_mois,$date_fin_mois);
                    $liste_events = cal_Event::get_all_events_id($_SESSION["user_id"]);
                    foreach($liste_events as $key => $value){
                        
                        $event = new cal_Event($value);
                        $calendrier->add_event($event);
                    }
                    $calendrier->afficher_calendrier();
                }
                    
                ?>
            </div>
        </div>
        <div class="Iframe_container">
        <iframe
        id="Iframe"
        title="test"
        frameborder="0"
        scrolling="no"
        style="display: none"
        >
        </iframe>
        </div>
      <script src="<?= BF::abs_path("functions/classes/calendar/javascript.js")?>">

        
<link rel="stylesheet" href="<?= BF::abs_path("CSS/categories.css")?>"/>
  
<div id = "wrapper_all" style="display: flex;flex-wrap: wrap; margin-top: 30px;">
  <form id="liste_cate">
    <img src="<?= BF::abs_path("media/img/select.jpg") ?>" onclick="retrecir(this);" style="width: 20px; border-radius: 5px;cursor: pointer;"/>
    <div style="display: inline; font-size: 16px; font-weight: bold; padding-left: 20px; text-overflow: ellipsis; overflow: hidden;white-space: nowrap;">Catégories de missions</div>
    <br>
      <?php
      foreach($categories as $key => $value){
        creer_select_categorie($key,$value);
      }
      ?>
  </form>
    
  </div>

         
        
      </script>