<!DOCTYPE html>
<html>
<?php
//Lien vers la base de données
require_once '../links.php';
$dbname='database';
$mytable ="users";

/*if(!class_exists('SQLite3'))
  die("SQLite 3 NOT supported.");

$base=new SQLite3($dbname, 0666);*/ 

$query = "CREATE TABLE $mytable(
          	id_indexation_automatique INTEGER,
          	pseudo CHAR(16),
            email CHAR(256),
            mdp CHAR(256),
            tel CHAR(12),
          	PRIMARY KEY(id_indexation_automatique,email)   
            )";
            
//$results = $base->exec($query);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// =========================== CREATION DES TABLES ===========================

// ----- Table des volontaires (travailleurs bénévoles) -----

$req = "CREATE TABLE IF NOT EXISTS users (
	id_user INTEGER PRIMARY KEY AUTOINCREMENT,
	pseudo CHAR(100) NOT NULL,
	email CHAR(256) NOT NULL UNIQUE,
	mdp CHAR(256) NOT NULL,
	tel CHAR(12)
)";
$req = $db->exec($req);

// ----- Table des ONG -----

$req = "CREATE TABLE IF NOT EXISTS assos (
	id_asso INTEGER PRIMARY KEY AUTOINCREMENT,
	nom VARCHAR(100) NOT NULL,
	description TEXT,
	adresse VARCHAR(200),
	email VARCHAR(100) NOT NULL,
	tel VARCHAR(20),
	logo CHAR(256)
)";
$req = $db->exec($req);

// ----- membres_assos -----

$req = "CREATE TABLE IF NOT EXISTS membres_assos (
	id_user INTEGER NOT NULL,
	id_asso INTEGER NOT NULL,
	statut CHAR (20),
	PRIMARY KEY (id_user,id_asso)
)";
$req_e = $db->exec($req);

// ----- prop_assos -----

$req = "CREATE TABLE IF NOT EXISTS prop_assos (
	id_asso INTEGER NOT NULL,
	prop_nom CHAR (256) NOT NULL,
	valeur TEXT,
	PRIMARY KEY (id_asso,prop_nom)
)";
$req = $db->exec($req);

// ----- prop_evenements -----

$req = "CREATE TABLE IF NOT EXISTS prop_evenements (
	FOREIGN KEY (id_event) REFERENCES evenements(id_event), 
	prop_nom CHAR(64) NOT NULL, 
	valeur TEXT NOT NULL
)";
$req = $db->exec($req);

// ----- evenements -----

$req = "CREATE TABLE IF NOT EXISTS evenements ( 
	id_event INTEGER PRIMARY KEY AUTOINCREMENT,
	FOREIGN KEY (id_asso) REFERENCES assos(id_asso),
	nom_event CHAR(256) NOT NULL,
	id_horaire INTEGER NOT NULL
)";
$req = $db->exec($req);

// ----- categories_evenements -----

$req = "CREATE TABLE IF NOT EXISTS categories_evenements (
	id INTEGER PRIMARY KEY AUTOINCREMENT,
	id_event INTEGER,
	categorie CHAR(256)
)";
$req = $db->exec($req);

// ----- Table des intérêts -----

$req = "CREATE TABLE IF NOT EXISTS Interets (
	id_interet INTEGER PRIMARY KEY AUTOINCREMENT,
	nom_interet VARCHAR(100) NOT NULL
)";
$req = $db->exec($req);

// ----- Table des disponibilités et intérêts des volontaires -----

$req = "CREATE TABLE IF NOT EXISTS DisponibilitesInterets (
	id_dispo_interet INTEGER PRIMARY KEY,
	FOREIGN KEY (id_horaire) REFERENCES horaires(id_horaire),
	FOREIGN KEY (id_user) REFERENCES users(id_user),
	FOREIGN KEY (id_interet) REFERENCES Interets(id_interet)
)";
$req = $db->exec($req);

// ----- Table "horaires" -----

$req = "CREATE TABLE IF NOT EXISTS horaires (
	id_horaire INTEGER PRIMARY KEY AUTOINCREMENT,
	JourSemaine VARCHAR(20) NOT NULL,
	HeureDebut TIME NOT NULL,
	HeureFin TIME NOT NULL,
	FOREIGN KEY (id_asso) REFERENCES assos(id_asso),
	FOREIGN KEY (id_interet) REFERENCES Interets(id_interet),
	FOREIGN KEY (id_event) REFERENCES evenements(id_event),
	FOREIGN KEY (id_dispo_interet) REFERENCES DisponibilitesInterets(id_dispo_interet)
)";
$req = $db->exec($req);

// Insertion des intérêts d'exemple

$req = "INSERT INTO Interets (nom_interet) VALUES
	('Lutte contre l''isolement, aide psychologique'),
	('Assurer un cadre sécurisant et respectueux'),
	('Prévention, action de sensibilisation'),
	('Éducation, soutien scolaire, formation')";
$req = $db->exec($req);

// Insertion d'exemples de volontaires avec leurs disponibilités (disponibilites) et intérêts

$req = "INSERT INTO users (pseudo, email, tel, mdp)
VALUES
	('OHN Anne-Sophie', 'anne-sophie.ohn@gmail.com', '01 23 45 67 89', 'password123'),
	('BRAUD Emeric', 'emeric.braud@gmail.com', '06 12 34 56 78', 'securepass456'),
	('GUEVARA David', 'david.guevara@gmail.com', '04 56 78 90 12', 'mypassword789')";

$req = $db->exec($req);

$req = "INSERT INTO DisponibilitesInterets (id_user, JourSemaine, HeureDebut, HeureFin, id_interet)
VALUES
	(1, 'Lundi', '09:00', '12:00', 1),
	(1, 'Mercredi', '14:00', '18:00', 2),
	(2, 'Mardi', '10:00', '13:00', 3),
	(3, 'Jeudi', '08:00', '11:00', 4),
	(3, 'Samedi', '09:00', '12:00', 1)";
$req = $db->exec($req);

// Insertion d'exemples d'ONG et de leurs horaires de mission

$req = "INSERT INTO assos (nom, description, adresse, email, tel)
VALUES
	('Association Aide Humanitaire', 'Fournir de l''aide aux personnes dans le besoin', '10 Rue des Volontaires, 75001 Paris', 'contact@association-aide.org', '01 98 76 54 32'),
	('Fondation Environnementale', 'Protection de l''environnement et préservation des espaces naturels', '25 Avenue de la Nature, 69002 Lyon', 'contact@fondation-environnement.org', '04 76 54 32 10')";
$req = $db->exec($req);

$req = "INSERT INTO horaires (JourSemaine, HeureDebut, HeureFin)
VALUES
	('Lundi', '08:00', '12:00'),
	('Mardi', '10:00', '14:00'),
	('Mercredi', '13:00', '17:00')";
$req = $db->exec($req);

?>


