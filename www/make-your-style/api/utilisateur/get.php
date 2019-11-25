<?php

    $time_start = microtime(true);

    include __DIR__ . '/../../../../systeme/make-your-style/acces_api_rest/utilisateur.php';
    if (API_REST_ACCESS_GET_UTILISATEUR == 'all') {
        include __DIR__ . '/../../../../systeme/make-your-style/api_espace_publique.php';
    } else {
        include __DIR__ . '/../../../../systeme/make-your-style/api_espace_privee.php';
    }

    session_write_close();

    $table_utilisateur = new utilisateur();

/*
    +-------+
    |  Get  |
    +-------+
*/
    $Code_utilisateur = lecture_parametre_api("Code_utilisateur", $utilisateur_courant['Code_utilisateur']);
    $retour_json = [];
    $retour_json['get'] = $table_utilisateur->mf_get( $Code_utilisateur, array( 'autocompletion' => true ));
    unset($retour_json['get']['utilisateur_Password']);
    fermeture_connexion_db();
    $time_end = microtime(true);
    $retour_json['duree'] = round( $time_end-$time_start, 4 );
    vue_api_echo( $retour_json );
