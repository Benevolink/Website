<?php

/**
 * Implémente des fonctionnalités de création et de suppression d'éléments
 */
interface Suppression{

    //Supprime l'objet dans sa table et dans toutes les tables où il apparaît
    public function suppr();
}

/**
 * Gestion des membres (pour évènements et associations)
 */
interface GestionMembres{
    public function get_all_membres();
    public function ajouter_membre($user, $role = null);
    public function supprimer_membre($user);

    public function modifier_role_membre($user, $role);

}

/**
 * Gestion des logos (pour utilisateurs, associations et évènements)
 */
interface GestionLogo{

    /**
     * Renvoie le chemin du logo pour l'implémenter en HTML
     */
    public function image_get();

    //Paramètres dans la fonction à rajouter
    public function image_set();

    /**
     * Supprime le logo s'il existe
     */
    public function image_suppr();
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