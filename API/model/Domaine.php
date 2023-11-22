<?php

class APIDomaine extends Domaine{
    public function api_insert($domaine){
        require_once BF::abs_path("libs/User.php",true);
        $user = new User();
    }
}