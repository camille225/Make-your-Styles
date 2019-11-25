<?php

    $time_start = microtime(true);

    include __DIR__ . '/../../../../systeme/make-your-style/acces_api_rest/a_filtre_produit.php';
    if (API_REST_ACCESS_PUT_A_FILTRE_PRODUIT == 'all') {
        include __DIR__ . '/../../../../systeme/make-your-style/api_espace_publique.php';
    } else {
        include __DIR__ . '/../../../../systeme/make-your-style/api_espace_privee.php';
    }

    session_write_close();

    $table_a_filtre_produit = new a_filtre_produit();

/*
    +------------+
    |  Modifier  |
    +------------+
*/
    $Code_filtre = lecture_parametre_api("Code_filtre", 0 );
    $Code_article = lecture_parametre_api("Code_article", 0 );
    $champs = array('Code_filtre'=>$Code_filtre, 'Code_article'=>$Code_article);
    if ( isset_parametre_api("a_filtre_produit_Actif") ) $champs['a_filtre_produit_Actif'] = lecture_parametre_api("a_filtre_produit_Actif");
    $retour = $table_a_filtre_produit->mf_modifier_2( array($champs) );
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
