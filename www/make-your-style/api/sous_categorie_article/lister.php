<?php declare(strict_types=1);

    include __DIR__ . '/../../../../systeme/make-your-style/acces_api_rest/sous_categorie_article.php';
    if (API_REST_ACCESS_GET_SOUS_CATEGORIE_ARTICLE == 'all') {
        include __DIR__ . '/../../../../systeme/make-your-style/api_espace_publique.php';
    } else {
        include __DIR__ . '/../../../../systeme/make-your-style/api_espace_privee.php';
    }

    $db = new DB();

/*
    +----------+
    |  Lister  |
    +----------+
*/
    $Code_categorie_article = (int) lecture_parametre_api("Code_categorie_article", 0 );
    $retour_json = [];
    $retour_json['liste'] = $db->sous_categorie_article()->mf_lister($Code_categorie_article, ['autocompletion' => true]);
    fermeture_connexion_db();
    $retour_json['duree'] = get_execution_time(4);
    vue_api_echo($retour_json);
