<?php

/**
* @author Emeric BRAUD
*/
$path_rel = __DIR__;
require_once __DIR__."/basic_functions.php";
include_once __DIR__."/config.php";
require_once __DIR__."/dict.php";
require_once __DIR__."/php_class/cal_Calendar.php";

// used variables


$current_increment=0;

if(isset($_POST["current_month"])){
    if(is_numeric($_POST["current_month"])){ //Dans ce cas on a une incrémentation de mois
        
        $current_increment = $_POST["current_month"];
        $date_debut_mois = strtotime(date("Y-m-01",strtotime("$current_increment month")));
        $date_fin_mois = strtotime(date("Y-m-t",strtotime("$current_increment month")));

        $date_debut = strtotime("monday this week",$date_debut_mois);
        $date_fin = strtotime("sunday this week",$date_fin_mois);
    }
}else{
    if(!isset($current_year)){
        $current_year = date("Y");
    }
    if(!isset($current_month)){
        $current_month = date("m");
    }
    
    
    $date_debut_mois = strtotime(date("$current_year-$current_month-01"));
    $date_fin_mois =   strtotime(date("$current_year-$current_month-t"));
    
    $date_debut = strtotime("monday this week",$date_debut_mois);
    $date_fin = strtotime("sunday this week",$date_fin_mois);
}





// based URL or based path
$base_url="http://127.0.0.1/calendar/";
$base_urlc = $base_url."controller/";
$path_cal=__DIR__.'/';