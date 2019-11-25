<?php

    $time_start = microtime(true);

    include __DIR__ . '/../../../../systeme/make-your-style/acces_api_rest/article.php';
    if (API_REST_ACCESS_GET_ARTICLE == 'all') {
        include __DIR__ . '/../../../../systeme/make-your-style/api_espace_publique.php';
    } else {
        include __DIR__ . '/../../../../systeme/make-your-style/api_espace_privee.php';
    }

    session_write_close();

    $table_article = new article();

/*
    +-------+
    |  Get  |
    +-------+
*/
    $Code_article = lecture_parametre_api("Code_article", 0);
    $retour_json = [];
    $retour_json['get'] = $table_article->mf_get( $Code_article, array( 'autocompletion' => true ));
    fermeture_connexion_db();
    $time_end = microtime(true);
    $retour_json['duree'] = round( $time_end-$time_start, 4 );
    vue_api_echo( $retour_json );
