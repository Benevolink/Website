<?php
class APIEvent extends Event{    
    /**
     * Supprime l'évènement
     *
     * @return void
     */
    public function api_suppr(){
        require_once BF::abs_path("libs/User.php",true);
        $user = new User();
        if(!$user->est_admin_asso($this->get_asso_id())){
            return_statut(false,"Vous n'avez pas les privilèges pour faire cela !");
        }
        $this->suppr();
    }
}
       