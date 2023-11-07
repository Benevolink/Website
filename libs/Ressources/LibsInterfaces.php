<?php

/**
 * Implémente des fonctionnalités de création et de suppression d'éléments
 */
interface CreationSuppression{

    //Méthode abstraite
    public function insert();
    public function suppr();
}

/**
 * Gestion des membres (pour évènements et associations)
 */
interface GestionMembres{
    public function get_all_membres();
    public function ajouter_membre($user, $role = null);
    public function supprimer_membre($user);

}

/**
 * Gestion des logos (pour utilisateurs, associations et évènements)
 */
interface GestionLogo{
    public function get_logo();

    //Paramètres dans la fonction à rajouter
    public function ajouter_logo();
    public function suppr_logo();
}

/**
 * Pour certaines tables, gestion de propriétés supplémentaires dans une table annexe
 */
interface GestionProprietesAdditionnelles{
    public function get_prop_value($prop_name);
    public function insert_prop($prop_name,$prop_value);
    public function suppr_prop($prop_name);
}

?>