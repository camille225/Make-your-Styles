<?php declare(strict_types=1);

// Nom du projet
define('NOM_PROJET', 'make-your-style');

// Table d'instance
define('TABLE_INSTANCE', '');
define('PREFIXE_DB_INSTANCE', 'zz');
define('TITRE_DB_INSTANCE', '{colonne_1} {colonne_2} ...');
define('LISTE_TABLES_GLOBALES', []); // Liste des tables qui restent globales dans le cas d'une application en instance.

// Comportement
define('ACTIVER_FORMULAIRE_INSCRIPTION', false);
define('ACTIVER_CONNEXION_EMAIL', false);

// Sécurité
define('LNG_TOKEN', 128);

// API
define('CONNECTEUR_API_TABLE', '');              // table qui contient les connecteurs API
define('CONNECTEUR_API_COLONNE_DATE_START', ''); // date d'activation du connecteur
define('CONNECTEUR_API_COLONNE_DATE_STOP', '');  // date d'arret du connecteur
define('CONNECTEUR_API_COLONNE_TOKEN', '');      // token de connexion

// Worker
define('DELAI_EXECUTION_WORKER', 60); // Delai d'execution du worker en secondes

// Long polling et websocket
define('WEBSOCKET_PERIOD_US', 250000);

// Optimisation
define('NB_RESULT_MAX_API', 10000);
define('NB_ELEM_MAX_LANGUE', 10000);
define('NB_ELEM_MAX_TABLEAU', 1000);
define('AUTOCOMPLETION_DEFAUT', false); // false pour plus d'optimisation
define('AUTOCOMPLETION_RECURSIVE_DEFAUT', false); // false pour plus d'optimisation
define('TOUTES_COLONNES_DEFAUT', false); // false pour plus d'optimisation
define('CONTROLE_ACCES_DONNEES_DEFAUT', true); // activation du controle des acces aux donnes par defaut
define('DUREE_CACHE_MINUTES', '60'); // duree du cache html uniquement

// Apparence
define('BOUTON_VALIDATION_SOUS_FORMULAIRE', true);
define('BOUTON_INTEGRABLE', true);
define('NB_ELEMENTS_MAX_PAR_TABLEAU', '100');
define('FORM_SUPPR_DEFAUT', '1'); // 0 : Nom ou 1 : Oui
define('USE_BOOTSTRAP', true);
define('VERSION_BOOTSTRAP', '4'); // 3 ou 4
define('DUREE_CACHE_NAV_CLIENT_EN_JOURS', 100);
define('IMAGES_LARGEUR_MAXI', 1024);
define('IMAGES_HAUTEUR_MAXI', 768);
define('MODE_RETINA', false); // true : permet de prendre en charge les ecrans retina en doublant la resolution des images
define('MULTI_BLOCS', true);
define('ALERTE_INFOS_NON_ENREGISTREES', true);

define('PREFIXE_SESSION', 'make-your-style');
define('PREFIXE_COOKIE', 'make-your-style');

// Sauvegarde
define('DUREE_HISTORIQUE', 150); // duree de conservation de l'historique en jours
define('LISTE_TABLES_HISTORIQUE_DESACTIVE', []); // Liste des tables sans historique.
