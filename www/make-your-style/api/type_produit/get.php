<?php

    $time_start = microtime(true);

    include __DIR__ . '/../../../../systeme/make-your-style/acces_api_rest/type_produit.php';
    if (API_REST_ACCESS_GET_TYPE_PRODUIT == 'all') {
        include __DIR__ . '/../../../../systeme/make-your-style/api_espace_publique.php';
    } else {
        include __DIR__ . '/../../../../systeme/make-your-style/api_espace_privee.php';
    }

    session_write_close();

    $table_type_produit = new type_produit();

/*
    +-------+
    |  Get  |
    +-------+
*/
    $Code_type_produit = lecture_parametre_api("Code_type_produit", 0);
    $retour_json = [];
    $retour_json['get'] = $table_type_produit->mf_get( $Code_type_produit, array( 'autocompletion' => true ));
    fermeture_connexion_db();
    $time_end = microtime(true);
    $retour_json['duree'] = round( $time_end-$time_start, 4 );
    vue_api_echo( $retour_json );
