<?php
require_once 'db.php';
try {
    // Connect to the SQLite database

    // Set error mode to exception
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create users table
    $createUsersTableQuery = "
        CREATE TABLE IF NOT EXISTS users (
            id_user INTEGER PRIMARY KEY AUTOINCREMENT,
            nom CHAR(40) NOT NULL,
            prenom CHAR(30) NOT NULL,
            date_de_naissance INTEGER NOT NULL,
            email CHAR(256) NOT NULL UNIQUE,
            mdp CHAR(256) NOT NULL,
            tel CHAR(12),
            visu INTEGER,
            logo CHAR(256), 
            id_lieu INTEGER,
            account_status INTEGER NOT NULL DEFAULT 0
        );
    ";
    $db->exec($createUsersTableQuery);

    // Ajouter une nouvelle colonne account_status à la table "users"
    $addNewColumnQuery = "
        ALTER TABLE users
        ADD logo CHAR(256);
    ";
    $db->exec($addNewColumnQuery);

  /*
    // Supprimer la colonne est_bloque de la table "users"
    $delNewColumnQuery = "
        ALTER TABLE users
        DROP COLUMN est_bloque;
    ";
    $db->exec($delNewColumnQuery); */

    // Create membres_assos table
    $createMembresAssosTableQuery = "
        CREATE TABLE IF NOT EXISTS membres_assos (
            id_user INTEGER NOT NULL,
            id_asso INTEGER NOT NULL,
            statut INTEGER,
            PRIMARY KEY (id_user, id_asso)
        );
    ";
    $db->exec($createMembresAssosTableQuery);

    // Create assos table
    $createAssosTableQuery = "
        CREATE TABLE IF NOT EXISTS assos (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nom VARCHAR(100) NOT NULL,
            desc TEXT,
            desc_missions TEXT,
            id_lieu INTEGER,
            email VARCHAR(100) NOT NULL,
            tel VARCHAR(20),
            logo CHAR(256)
        );
    ";
    $db->exec($createAssosTableQuery);

    // Create domaine table
    $createDomaineTableQuery = "
        CREATE TABLE IF NOT EXISTS domaine (
            id_domaine INTEGER PRIMARY KEY NOT NULL,
            nom_domaine CHAR(256)
        );
    ";
    $db->exec($createDomaineTableQuery);
  
    /*
    // Requête SQL pour supprimer la table
    $sql = "DROP TABLE IF EXISTS domaine"; // Supprime la table "domaine" s'il existe
    
    // Exécution de la requête
    $db->exec($sql);
    
    echo "La table 'domaine' a été supprimée avec succès.";*/

    // Create domaine_jonction table
    // type = 0 si user
    // type = 1 si asso
    // type = 2 si mission
    $createDomaineAssoTableQuery = "
        CREATE TABLE IF NOT EXISTS domaine_jonction (
            id_domaine INTEGER NOT NULL,
            id_jonction INTEGER NOT NULL,
            type INTEGER NOT NULL, 
            PRIMARY KEY (id_domaine, id_jonction, type)
        );
    ";
    $db->exec($createDomaineAssoTableQuery);

    // Create prop_assos table
    $createPropAssosTableQuery = "
        CREATE TABLE IF NOT EXISTS prop_assos (
            id_asso INTEGER NOT NULL,
            prop_nom CHAR(256) NOT NULL,
            valeur TEXT,
            PRIMARY KEY (id_asso, prop_nom)
        );
    ";
    $db->exec($createPropAssosTableQuery);

    // Create prop_evenements table
    $createPropEvenementsTableQuery = "
        CREATE TABLE IF NOT EXISTS prop_evenements (
            id_event INTEGER NOT NULL,
            prop_nom CHAR(256) NOT NULL,
            valeur TEXT,
            PRIMARY KEY (id_event, prop_nom)
        );
    ";
    $db->exec($createPropEvenementsTableQuery);

    // Create evenements table
    $createEvenementsTableQuery = "
        CREATE TABLE IF NOT EXISTS evenements (
            id_event INTEGER PRIMARY KEY AUTOINCREMENT,
            id_asso INTEGER NOT NULL,
            nom_event CHAR(256) NOT NULL,
            desc VARCHAR(256),
            visu INTEGER,
            id_lieu INTEGER,
            nb_personnes INTEGER NOT NULL,
            id_horaire INTEGER NOT NULL,
            id_domaine CHAR(256) NOT NULL,
            id_comp CHAR(256) NOT NULL
        );
    ";
    $db->exec($createEvenementsTableQuery);

    // Create membres_evenements table
    $createMembresEvenementsTableQuery = "
        CREATE TABLE IF NOT EXISTS membres_evenements (
            id_event INTEGER NOT NULL,
            id_user INTEGER NOT NULL,
            statut INTEGER,
            PRIMARY KEY (id_event, id_user)
        );
    ";
    $db->exec($createMembresEvenementsTableQuery);

    // Create horaire table
    $createHoraireTableQuery = "
        CREATE TABLE IF NOT EXISTS horaire (
            id_horaire INTEGER PRIMARY KEY NOT NULL,
            date_debut INTEGER NOT NULL,
            frequence VARCHAR(32),
            date_fin INTEGER NOT NULL,
            heure_debut INTEGER NOT NULL,
            heure_fin INTEGER NOT NULL
        );
    ";
    $db->exec($createHoraireTableQuery);

    // Create lieu table
    $createLieuTableQuery = "
        CREATE TABLE IF NOT EXISTS lieu (
            id_lieu INTEGER PRIMARY KEY NOT NULL,
            departement VARCHAR(200),
            adresse VARCHAR(200)
        );
    ";
    $db->exec($createLieuTableQuery);

    // Create competences table
    $createCompetencesTableQuery = "
        CREATE TABLE IF NOT EXISTS competences (
            id_comp CHAR(256) PRIMARY KEY NOT NULL,
            nom_comp TEXT
        );
    ";
    $db->exec($createCompetencesTableQuery);

    // Create logs table
    $createLogsTableQuery = "
        CREATE TABLE IF NOT EXISTS logs (
            id_message INTEGER PRIMARY KEY AUTOINCREMENT,
            message VARCHAR(600) NOT NULL,
            date_message INTEGER NOT NULL
        );
    ";
    $db->exec($createLogsTableQuery);

    // Create signalements table
    $createSignalementsTableQuery = "
        CREATE TABLE IF NOT EXISTS signalements (
            id_source INTEGER,
            id_cible INTEGER,
            message VARCHAR(600),
            date_signal INTEGER NOT NULL,
            est_une_asso BOOL NOT NULL,
            PRIMARY KEY (id_source, id_cible)
        );
    ";
    $db->exec($createSignalementsTableQuery);

    echo "Database and tables created successfully!";
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>