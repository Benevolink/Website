<?php
require_once BF::abs_path("libs/Asso.php",true);
require_once __DIR__."/../model/Asso.php";

switch($fonction){
    case "":
        break;
    case "search":
        APIAsso::api_search($_POST["recherche"]);
}