<?php

    $time_start = microtime(true);

    include __DIR__ . '/../../../../systeme/make-your-style/acces_api_rest/filtre.php';
    if (API_REST_ACCESS_GET_FILTRE == 'all') {
        include __DIR__ . '/../../../../systeme/make-your-style/api_espace_publique.php';
    } else {
        include __DIR__ . '/../../../../systeme/make-your-style/api_espace_privee.php';
    }

    session_write_close();

    $table_filtre = new filtre();

/*
    +-------+
    |  Get  |
    +-------+
*/
    $Code_filtre = lecture_parametre_api("Code_filtre", 0);
    $retour_json = [];
    $retour_json['get'] = $table_filtre->mf_get( $Code_filtre, array( 'autocompletion' => true ));
    fermeture_connexion_db();
    $time_end = microtime(true);
    $retour_json['duree'] = round( $time_end-$time_start, 4 );
    vue_api_echo( $retour_json );
