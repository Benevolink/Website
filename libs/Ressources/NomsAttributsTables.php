<?php


/**
 * Table evenements
 */
 interface AttributsEvents{
    const EVENT              =   "evenements";
    const EVENT_ID           =   "id_event";
    const EVENT_ID_ASSO      =   "id_asso";
    const EVENT_NOM          =   "nom_event";
    const EVENT_DESCRIPTION  =   "desc";
    const EVENT_VISIBILITE   =   "visu";
    const EVENT_ID_LIEU      =   "id_lieu";
    const EVENT_NB_MAX_PERSONNES
                                    =   "nb_personnes";
    const EVENT_ID_HORAIRE   =   "id_horaire";
    
 }

/**
 * Table associations
 */
 interface AttributsAssos{
    const ASSO = "assos";
    const ASSO_ID = "id";
    const ASSO_NOM = "nom";
    const ASSO_DESCRIPTION = "desc";
    const ASSO_DESCRIPTION_MISSIONS = "desc_missions";
    const ASSO_ID_LIEU = "id_lieu";
    const ASSO_EMAIL = "email";
    const ASSO_TELEPHONE = "tel";
    const ASSO_LOGO = "logo";
 }

/**
 * Table domaines
 */
interface AttributsDomaines{
    const DOMAINE = "domaine";
    const DOMAINE_ID = "id_domaine";
    const DOMAINE_NOM = "nom_domaine";
}

/**
 * Table de jonction domaines
 */
interface AttributsDomainesJonction{
    const DOMAINEJONCTION = "domaine_jonction";
    const DOMAINEJONCTION_ID_DOMAINE = "id_domaine";
    const DOMAINEJONCTION_ID_JONCTION = "id_jonction";
    const DOMAINEJONCTION_TYPE = "type";
}

/**
 * Table des horaires
 */
interface AttributsHoraires{
    const HORAIRE = "horaire";

    const HORAIRE_ID = "id_horaire";

    const HORAIRE_DATE_DEBUT = "date_debut";
    const HORAIRE_FREQUENCE = "frequence";
    const HORAIRE_DATE_FIN = "date_fin";
    const HORAIRE_HEURE_DEBUT = "heure_debut";
    const HORAIRE_HEURE_FIN = "heure_fin";
}

/**
 * Table des lieux
 */
interface AttributsLieux{
    const LIEU = "lieu";
    const LIEU_ID = "id_lieu";
    const LIEU_DEPARTEMENT = "departement";
    const LIEU_ADRESSE = "adresse";
}

/**
 * Table des membres des associations
 */
interface AttributsMembresAssos{
    const MEMBRESASSOS = "membres_assos";
    const MEMBRESASSOS_ID_USER = "id_user";
    const MEMBRESASSOS_ID_ASSO = "id_asso";
    const MEMBRESASSOS_STATUT = "statut";
}

/**
 * Table des membres des évènements
 */
interface AttributsMembresEvents{
    const MEMBRESEVENTS = "membres_evenements";
    const MEMBRESEVENTS_ID_EVENT = "id_event";
    const MEMBRESEVENTS_ID_USER  = "id_user";
    const MEMBRESEVENTS_STATUT = "statut";
}

/**
 * Table de propriétés des associations
 */
interface AttributsPropAsso{
    const PROPASSO = "prop_assos";
    const PROPASSO_ID_ASSO = "id_asso";
    const PROPASSO_NOM = "prop_nom";
    const PROPASSO_VALEUR = "valeur";
}

/**
 * Table de propriétés des associations
 */
interface AttributsPropEvent{
    const PROPEVENT = "prop_evenements";
    const PROPEVENT_ID_EVENT = "id_event";
    const PROPEVENT_NOM = "prop_nom";
    const PROPEVENT_VALEUR = "valeur";
}

/**
 * Table des signalements
 */
interface AttributsSignalement{
    const SIGNALEMENT = "signalements";
    const SIGNALEMENT_ID_SOURCE = "id_source";
    const SIGNALEMENT_ID_CIBLE = "id_cible";
    const SIGNALEMENT_MESSAGE = "message";
    const SIGNALEMENT_DATE = "date_signal";
    const SIGNALEMENT_EST_ASSO  = "est_une_asso";
}

/**
 * Table des utilisateurs
 */
interface AttributsUsers{
    const USER = "users";
    const USER_ID = "id";
    const USER_NOM = "nom";
    const USER_DATE_NAISSANCE = "date_de_naissance";
    const USER_EMAIL = "email";
    const USER_MDP = "mdp";
    const USER_TEL = "tel";
    const USER_VISIBILITE ="visu";
    const USER_ID_LIEU = "id_lieu";
    const USER_ID_DISPO   =   "id_disponibilite"; //table contenant des id_horaires de la table horaire
    const USER_PRENOM = "prenom";
    const USER_ETAT_COMPTE = "account_status";
    const USER_LOGO = "logo";

    const USER_ACCOUNT_STATUS = "account_status";
}


/**
 * Table horaires
 */


 /**
 * Définit le nom de toutes les tables
 * permet de rapidemment pouvoir changer le nom des tables sans afftecter le code
 */

 class AttributsTables
 implements 
 AttributsAssos,
 AttributsDomaines,
 AttributsDomainesJonction,
 AttributsEvents,
 AttributsHoraires,
 AttributsLieux,
 AttributsMembresAssos,
 AttributsMembresEvents,
 AttributsPropAsso,
 AttributsPropEvent,
 AttributsSignalement,
 AttributsUsers
 {
    

 }

?>