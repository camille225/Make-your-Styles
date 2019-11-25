<?php

    $time_start = microtime(true);

    include __DIR__ . '/../../../../systeme/make-your-style/acces_api_rest/a_article_commande.php';
    if (API_REST_ACCESS_GET_A_ARTICLE_COMMANDE == 'all') {
        include __DIR__ . '/../../../../systeme/make-your-style/api_espace_publique.php';
    } else {
        include __DIR__ . '/../../../../systeme/make-your-style/api_espace_privee.php';
    }

    session_write_close();

    $table_a_article_commande = new a_article_commande();

/*
    +-------+
    |  Get  |
    +-------+
*/
    $Code_commande = lecture_parametre_api("Code_commande", 0 );
    $Code_article = lecture_parametre_api("Code_article", 0 );
    $retour_json = [];
    $retour_json['get'] = $table_a_article_commande->mf_get($Code_commande, $Code_article, array( 'autocompletion' => true ));
    fermeture_connexion_db();
    $time_end = microtime(true);
    $retour_json['duree'] = round( $time_end-$time_start, 4 );
    vue_api_echo( $retour_json );
