<?php declare(strict_types=1);

define('ADRESSE_SITE', 'http://localhost/make-your-style/www/make-your-style/'); // Correspond a l'adresse de la page d'accueil
define('ADRESSE_API', 'http://localhost/make-your-style/www/make-your-style/api.rest/'); // Correspond a l'adresse de l'API
define('FIN_ADRESSE_RACINE', 'make-your-style'); // permet l'utilisation d'un sous-domaine
define('REPERTOIRE_WWW', 'www'); // nom du dossier publique

define('HTTPS_ON', false);
define('ADRESSES_IP_AUTORISES', ['127.0.0.1', '::1']); // si vide, pas de restriction. Sinon, les ip autorisees
define('MODE_PROD', false);
define('MODE_DESIGN', false); // Nécessite (! MODE_PROD)

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'make-your-style');
define('DB_PORT', 0);

// Connexion à un compte pour assistance
define('PREFIXE_ASSIST_LOGIN', ''); // Si = ADMIN/ alors IDENTIFIANT devient ADMIN/IDENTIFIANT
define('PREFIXE_ASSIST_PWD', '');   // Mot de passe qui permet la connexion dans le cas d'une connexion d'assistance

define('DB_CACHE_HOST', 'localhost');
define('DB_CACHE_USER', 'root');
define('DB_CACHE_PASSWORD', '');
define('DB_CACHE_NAME', 'make-your-style_cache');
define('DB_CACHE_PORT', 0);

define('MAIL_NOREPLY', 'exemple@exemple.com');
define('MAIL_ADMIN', 'herve.hautbois@gmail.com');

// Connexion google
define('GOOGLE_CLIENT_ID', '');
define('GOOGLE_CLIENT_SECRET', '');

// Connexion facebook
define('FACEBOOK_CLIENT_ID', '');
define('FACEBOOK_CLIENT_SECRET', '');
