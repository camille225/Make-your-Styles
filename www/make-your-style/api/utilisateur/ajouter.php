<?php

    $time_start = microtime(true);

    include __DIR__ . '/../../../../systeme/make-your-style/acces_api_rest/utilisateur.php';
    if (API_REST_ACCESS_POST_UTILISATEUR == 'all') {
        include __DIR__ . '/../../../../systeme/make-your-style/api_espace_publique.php';
    } else {
        include __DIR__ . '/../../../../systeme/make-your-style/api_espace_privee.php';
    }

    session_write_close();

    $table_utilisateur = new utilisateur();

/*
    +-----------+
    |  Ajouter  |
    +-----------+
*/
    $utilisateur_Identifiant = lecture_parametre_api("utilisateur_Identifiant", '');
    $utilisateur_Password = lecture_parametre_api("utilisateur_Password", '');
    $utilisateur_Email = lecture_parametre_api("utilisateur_Email", '');
    $utilisateur_Administrateur = lecture_parametre_api("utilisateur_Administrateur", '');
    $utilisateur_Developpeur = lecture_parametre_api("utilisateur_Developpeur", '');
    $retour = $table_utilisateur->mf_ajouter($utilisateur_Identifiant, $utilisateur_Password, $utilisateur_Email, $utilisateur_Administrateur, $utilisateur_Developpeur);
    if ( $retour['code_erreur']==0 )
    {
        $cache = new Cachehtml();
        $cache->clear();
    }
    $retour_json = [];
    $retour_json['code_erreur'] = $retour['code_erreur'];
    $retour_json['message_erreur'] = ( (isset($retour) && $retour['code_erreur']>0) ? (isset($mf_libelle_erreur[$retour['code_erreur']]) ? $mf_libelle_erreur[$retour['code_erreur']] : 'ERREUR N_'.$retour['code_erreur'] ) : '' );
    $retour_json['Code_utilisateur'] = $retour['Code_utilisateur'];
    fermeture_connexion_db();
    $time_end = microtime(true);
    $retour_json['duree'] = round( $time_end-$time_start, 4 );
    vue_api_echo( $retour_json );
