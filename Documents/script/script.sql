
DROP TABLE IF EXISTS utilisateur ;

CREATE TABLE utilisateur (Code_utilisateur int AUTO_INCREMENT NOT NULL,
utilisateur_Identifiant VARCHAR,
utilisateur_Password VARCHAR,
utilisateur_Email VARCHAR,
utilisateur_Administrateur BOOL,
utilisateur_Developpeur BOOL,
PRIMARY KEY (Code_utilisateur) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS article ;

CREATE TABLE article (Code_article int AUTO_INCREMENT NOT NULL,
article_Libelle VARCHAR,
article_Photo_Fichier VARCHAR,
article_Prix FLOAT,
article_Actif BOOL,
Code_type_produit int NOT NULL,
PRIMARY KEY (Code_article) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS commande ;

CREATE TABLE commande (Code_commande int AUTO_INCREMENT NOT NULL,
commande_Prix_total FLOAT,
commande_Date_livraison DATE,
commande_Date_creation DATE,
Code_utilisateur int NOT NULL,
PRIMARY KEY (Code_commande) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS type_produit ;

CREATE TABLE type_produit (Code_type_produit int AUTO_INCREMENT NOT NULL,
type_produit_Libelle VARCHAR,
PRIMARY KEY (Code_type_produit) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS parametre ;

CREATE TABLE parametre (Code_parametre int AUTO_INCREMENT NOT NULL,
parametre_Libelle VARCHAR,
PRIMARY KEY (Code_parametre) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS filtre ;

CREATE TABLE filtre (Code_filtre int AUTO_INCREMENT NOT NULL,
filtre_Libelle VARCHAR,
PRIMARY KEY (Code_filtre) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS a_article_commande ;

CREATE TABLE a_article_commande (Code_commande int AUTO_INCREMENT NOT NULL,
Code_article int NOT NULL,
PRIMARY KEY (Code_commande,
 Code_article) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS a_filtre_produit ;

CREATE TABLE a_filtre_produit (Code_filtre int AUTO_INCREMENT NOT NULL,
Code_article int NOT NULL,
a_filtre_produit_Actif INT,
PRIMARY KEY (Code_filtre,
 Code_article) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS a_parametre_utilisateur ;

CREATE TABLE a_parametre_utilisateur (Code_utilisateur int AUTO_INCREMENT NOT NULL,
Code_parametre int NOT NULL,
a_parametre_utilisateur_Valeur INT,
a_parametre_utilisateur_Actif INT,
PRIMARY KEY (Code_utilisateur,
 Code_parametre) ) ENGINE=InnoDB;
