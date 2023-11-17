<?php
require_once BF::abs_path("libs/Event.php",true);
require_once __DIR__."/../model/Event.php";

switch($fonction){
    case "":
        break;
    case "user_get_all":
        require_once BF::abs_path("libs/User.php",true);
        $user = new User();
        return_json($user->infos_events());
        exit();



}