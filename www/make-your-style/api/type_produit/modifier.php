<?php

    $time_start = microtime(true);

    include __DIR__ . '/../../../../systeme/make-your-style/acces_api_rest/type_produit.php';
    if (API_REST_ACCESS_PUT_TYPE_PRODUIT == 'all') {
        include __DIR__ . '/../../../../systeme/make-your-style/api_espace_publique.php';
    } else {
        include __DIR__ . '/../../../../systeme/make-your-style/api_espace_privee.php';
    }

    session_write_close();

    $table_type_produit = new type_produit();

/*
    +------------+
    |  Modifier  |
    +------------+
*/
    $Code_type_produit = lecture_parametre_api("Code_type_produit", 0 );
    $champs = array();
    if ( isset_parametre_api("type_produit_Libelle") ) $champs['type_produit_Libelle'] = lecture_parametre_api("type_produit_Libelle");
    $retour = $table_type_produit->mf_modifier_2( array( $Code_type_produit => $champs ) );
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
