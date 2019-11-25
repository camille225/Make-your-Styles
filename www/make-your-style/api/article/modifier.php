<?php

    $time_start = microtime(true);

    include __DIR__ . '/../../../../systeme/make-your-style/acces_api_rest/article.php';
    if (API_REST_ACCESS_PUT_ARTICLE == 'all') {
        include __DIR__ . '/../../../../systeme/make-your-style/api_espace_publique.php';
    } else {
        include __DIR__ . '/../../../../systeme/make-your-style/api_espace_privee.php';
    }

    session_write_close();

    $table_article = new article();

/*
    +------------+
    |  Modifier  |
    +------------+
*/
    $Code_article = lecture_parametre_api("Code_article", 0 );
    $champs = array();
    if ( isset_parametre_api("article_Libelle") ) $champs['article_Libelle'] = lecture_parametre_api("article_Libelle");
    if ( isset_parametre_api("article_Photo_Fichier") ) $champs['article_Photo_Fichier'] = lecture_parametre_api("article_Photo_Fichier");
    if ( isset_parametre_api("article_Prix") ) $champs['article_Prix'] = lecture_parametre_api("article_Prix");
    if ( isset_parametre_api("article_Actif") ) $champs['article_Actif'] = lecture_parametre_api("article_Actif");
    if ( isset_parametre_api("Code_type_produit") ) $champs['Code_type_produit'] = lecture_parametre_api("Code_type_produit");
    $retour = $table_article->mf_modifier_2( array( $Code_article => $champs ) );
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
