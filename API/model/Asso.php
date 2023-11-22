<?php
class APIAsso extends Asso{
        
    /**
     * Method api_search
     *
     * @param string $nom_asso $nom_asso [explicite description]
     *
     * @return void
     */
    public static function api_search($nom_asso){
        $array = Asso::recherche_asso($nom_asso);
        return_json($array);
        exit();
    }

}

?>