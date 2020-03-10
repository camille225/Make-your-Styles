
DROP TABLE IF EXISTS utilisateur ;

CREATE TABLE utilisateur (Code_utilisateur int AUTO_INCREMENT NOT NULL,
utilisateur_Identifiant VARCHAR,
utilisateur_Password VARCHAR,
utilisateur_Email VARCHAR,
utilisateur_Civilite_Type INT,
utilisateur_Prenom VARCHAR,
utilisateur_Nom VARCHAR,
utilisateur_Adresse_1 VARCHAR,
utilisateur_Adresse_2 VARCHAR,
utilisateur_Ville VARCHAR,
utilisateur_Code_postal VARCHAR,
utilisateur_Date_naissance DATE,
utilisateur_Accepte_mail_publicitaire BOOL,
utilisateur_Administrateur BOOL,
utilisateur_Fournisseur BOOL,
PRIMARY KEY (Code_utilisateur) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS article ;

CREATE TABLE article (Code_article int AUTO_INCREMENT NOT NULL,
article_Libelle VARCHAR,
article_Description TEXT,
article_Saison_Type INT,
article_Nom_fournisseur VARCHAR,
article_Url VARCHAR,
article_Reference VARCHAR,
article_Couleur VARCHAR,
article_Code_couleur_svg VARCHAR,
article_Taille_Pays_Type INT,
article_Taille INT,
article_Photo_Fichier VARCHAR,
article_Prix FLOAT,
article_Actif BOOL,
Code_sous_categorie_article int NOT NULL,
PRIMARY KEY (Code_article) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS commande ;

CREATE TABLE commande (Code_commande int AUTO_INCREMENT NOT NULL,
commande_Prix_total FLOAT,
commande_Date_livraison DATE,
commande_Date_creation DATE,
Code_utilisateur int NOT NULL,
PRIMARY KEY (Code_commande) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS categorie_article ;

CREATE TABLE categorie_article (Code_categorie_article int AUTO_INCREMENT NOT NULL,
categorie_article_Libelle VARCHAR,
PRIMARY KEY (Code_categorie_article) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS parametre ;

CREATE TABLE parametre (Code_parametre int AUTO_INCREMENT NOT NULL,
parametre_Libelle VARCHAR,
PRIMARY KEY (Code_parametre) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS vue_utilisateur ;

CREATE TABLE vue_utilisateur (Code_vue_utilisateur int AUTO_INCREMENT NOT NULL,
vue_utilisateur_Recherche VARCHAR,
vue_utilisateur_Filtre_Saison_Type INT,
vue_utilisateur_Filtre_Couleur VARCHAR,
vue_utilisateur_Filtre_Taille_Pays_Type INT,
vue_utilisateur_Filtre_Taille_Max INT,
vue_utilisateur_Filtre_Taille_Min INT,
PRIMARY KEY (Code_vue_utilisateur) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS sous_categorie_article ;

CREATE TABLE sous_categorie_article (Code_sous_categorie_article int AUTO_INCREMENT NOT NULL,
sous_categorie_article_Libelle VARCHAR,
Code_categorie_article int,
PRIMARY KEY (Code_sous_categorie_article) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS conseil ;

CREATE TABLE conseil (Code_conseil int AUTO_INCREMENT NOT NULL,
conseil_Libelle VARCHAR,
conseil_Description TEXT,
conseil_Actif BOOL,
PRIMARY KEY (Code_conseil) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS a_commande_article ;

CREATE TABLE a_commande_article (Code_commande int AUTO_INCREMENT NOT NULL,
Code_article int NOT NULL,
a_commande_article_Quantite INT,
a_commande_article_Prix_ligne FLOAT,
PRIMARY KEY (Code_commande,
 Code_article) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS a_parametre_utilisateur ;

CREATE TABLE a_parametre_utilisateur (Code_utilisateur int AUTO_INCREMENT NOT NULL,
Code_parametre int NOT NULL,
a_parametre_utilisateur_Valeur INT,
a_parametre_utilisateur_Actif INT,
PRIMARY KEY (Code_utilisateur,
 Code_parametre) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS a_filtrer ;

CREATE TABLE a_filtrer (Code_utilisateur int AUTO_INCREMENT NOT NULL,
Code_vue_utilisateur int NOT NULL,
PRIMARY KEY (Code_utilisateur,
 Code_vue_utilisateur) ) ENGINE=InnoDB;
