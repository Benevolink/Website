<?php
 /**
 * Définit le nom de toutes les tables
 * permet de rapidemment pouvoir changer le nom des tables sans afftecter le code
 */

 class AttributsTables
 {
    /**
     * Table evenements
     */
    public const EVENT              =   "evenements";
    public const EVENT_ID           =   "id_event";
    public const EVENT_ID_ASSO      =   "id_asso";
    public const EVENT_NOM          =   "nom_event";
    public const EVENT_DESCRIPTION  =   "desc";
    public const EVENT_VISIBILITE   =   "visu";
    public const EVENT_ID_LIEU      =   "id_lieu";
    public const EVENT_NB_MAX_PERSONNES
                                    =   "nb_personnes";
    public const EVENT_ID_HORAIRE   =   "id_horaire";


    /**
     * Table associations
     */

    public const ASSO = "assos";
    public const ASSO_ID = "id";
    public const ASSO_NOM = "nom";
    public const ASSO_DESCRIPTION = "desc";
    public const ASSO_DESCRIPTION_MISSIONS = "desc_missions";
    public const ASSO_ID_LIEU = "id_lieu";
    public const ASSO_EMAIL = "email";
    public const ASSO_TELEPHONE = "tel";
    public const ASSO_LOGO = "logo";
 
    /**
     * Table domaines
     */
    public const DOMAINE = "domaine";
    public const DOMAINE_ID = "id_domaine";
    public const DOMAINE_NOM = "nom_domaine";


    /**
     * Table de jonction domaines
     */
    public const DOMAINEJONCTION = "domaine_jonction";
    public const DOMAINEJONCTION_ID_DOMAINE = "id_domaine";
    public const DOMAINEJONCTION_ID_JONCTION = "id_jonction";
    public const DOMAINEJONCTION_TYPE = "type";

    /**
     * Table des horaires
     */
    public const HORAIRE = "horaire";

    public const HORAIRE_ID = "id_horaire";

    public const HORAIRE_DATE_DEBUT = "date_debut";
    public const HORAIRE_FREQUENCE = "frequence";
    public const HORAIRE_DATE_FIN = "date_fin";
    public const HORAIRE_HEURE_DEBUT = "heure_debut";
    public const HORAIRE_HEURE_FIN = "heure_fin";
    /**
     * Table des lieux
     */
    public const LIEU = "lieu";
    public const LIEU_ID = "id_lieu";
    public const LIEU_DEPARTEMENT = "departement";
    public const LIEU_ADRESSE = "adresse";
    /**
     * Table des membres des associations
     */
    public const MEMBRESASSOS = "membres_assos";
    public const MEMBRESASSOS_ID_USER = "id_user";
    public const MEMBRESASSOS_ID_ASSO = "id_asso";
    public const MEMBRESASSOS_STATUT = "statut";
    /**
     * Table des membres des évènements
     */
    public const MEMBRESEVENTS = "membres_evenements";
    public const MEMBRESEVENTS_ID_EVENT = "id_event";
    public const MEMBRESEVENTS_ID_USER  = "id_user";
    public const MEMBRESEVENTS_STATUT = "statut";
    
    /**
     * Table de propriétés des associations
     */
    public const PROPASSO = "prop_assos";
    public const PROPASSO_ID_ASSO = "id_asso";
    public const PROPASSO_NOM = "prop_nom";
    
   public const PROPASSO_VALEUR = "valeur";
   /**
     * Table de propriétés des associations
     */
    public const PROPEVENT = "prop_evenements";
    public const PROPEVENT_ID_EVENT = "id_event";
    public const PROPEVENT_NOM = "prop_nom";
    public const PROPEVENT_VALEUR = "valeur";
    /**
     * Table des signalements
     */
    public const SIGNALEMENT = "signalements";
    public const SIGNALEMENT_ID_SOURCE = "id_source";
    public const SIGNALEMENT_ID_CIBLE = "id_cible";
    public const SIGNALEMENT_MESSAGE = "message";
    public const SIGNALEMENT_DATE = "date_signal";
    public const SIGNALEMENT_EST_ASSO  = "est_une_asso";
    /**
    * Table des utilisateurs
    */ 
    public const USER = "users";
    public const USER_ID = "id";
    public const USER_NOM = "nom";
    public const USER_DATE_NAISSANCE = "date_de_naissance";
    public const USER_EMAIL = "email";
    public const USER_MDP = "mdp";
    public const USER_TEL = "tel";
    public const USER_VISIBILITE ="visu";
    public const USER_ID_LIEU = "id_lieu";
    public const USER_PRENOM = "prenom";
    public const USER_ETAT_COMPTE = "account_status";
    public const USER_LOGO = "logo";
 }

?>