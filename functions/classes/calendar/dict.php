<?php
$lex = array();
/**
 * Défini le dictionnaire avec la langue voulue.
 * Pour cela modifie le tableau $lex
 * 
 * @param string $lang
 */
function def_dictionnaire($lang){
    global $lex;
    if(same($lang,"fr")){
        $lex["day"] = array("lundi","mardi","mercredi","jeudi","vendredi","samedi","dimanche");
        $lex["month"] = array("janvier","février","mars","avril","mai","juin","juillet","août","septembre","octobre","novembre","décembre");
        $lex["next_month"]="mois suivant";
        $lex["previous_month"] = "mois précédent";
        $lex["pick_lang"] = "choix de la langue";

    }elseif(same($lang,"en")){
        $lex["day"] = array("monday","tuesday","wednesday","thursday","friday","saturday","sunday");
        $lex["month"] = array("january","febuary","march","april","may","june","july","august","september","october","november","december");
        $lex["next_month"]="next month";
        $lex["previous_month"] = "previous month";
        $lex["pick_lang"] = "language choice";

    }
}

switch ((string)$lang){
    case 'fr':
        def_dictionnaire("fr");
        break;
    case 'en':
        def_dictionnaire("en");
        break;
    default:
        def_dictionnaire("fr");
}

?>