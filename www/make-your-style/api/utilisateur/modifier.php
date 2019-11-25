<?php

    $time_start = microtime(true);

    include __DIR__ . '/../../../../systeme/make-your-style/acces_api_rest/utilisateur.php';
    if (API_REST_ACCESS_PUT_UTILISATEUR == 'all') {
        include __DIR__ . '/../../../../systeme/make-your-style/api_espace_publique.php';
    } else {
        include __DIR__ . '/../../../../systeme/make-your-style/api_espace_privee.php';
    }

    session_write_close();

    $table_utilisateur = new utilisateur();

/*
    +------------+
    |  Modifier  |
    +------------+
*/
    $Code_utilisateur = lecture_parametre_api("Code_utilisateur", 0 );
    $champs = array();
    if ( isset_parametre_api("utilisateur_Identifiant") ) $champs['utilisateur_Identifiant'] = lecture_parametre_api("utilisateur_Identifiant");
    if ( isset_parametre_api("utilisateur_Email") ) $champs['utilisateur_Email'] = lecture_parametre_api("utilisateur_Email");
    if ( isset_parametre_api("utilisateur_Administrateur") ) $champs['utilisateur_Administrateur'] = lecture_parametre_api("utilisateur_Administrateur");
    if ( isset_parametre_api("utilisateur_Developpeur") ) $champs['utilisateur_Developpeur'] = lecture_parametre_api("utilisateur_Developpeur");
    $retour = $table_utilisateur->mf_modifier_2( array( $Code_utilisateur => $champs ) );
    if ( $retour['code_erreur']==0 )
    {
        $cache = new Cachehtml();
        $cache->clear();
    }
    $retour_json = [];
    $retour_json['code_erreur'] = $retour['code_erreur'];
    $retour_json['message_erreur'] = ( (isset($retour) && $retour['code_erreur']>0) ? (isset($mf_libelle_erreur[$retour['code_erreur']]) ? $mf_libelle_erreur[$retour['code_erreur']] : 'ERREUR N_'.$retour['code_erreur'] ) : '' );
    fermeture_connexion_db();
    $time_end = microtime(true);
    $retour_json['duree'] = round( $time_end-$time_start, 4 );
    vue_api_echo( $retour_json );
