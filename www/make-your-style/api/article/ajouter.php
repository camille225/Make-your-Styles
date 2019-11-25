<?php

    $time_start = microtime(true);

    include __DIR__ . '/../../../../systeme/make-your-style/acces_api_rest/article.php';
    if (API_REST_ACCESS_POST_ARTICLE == 'all') {
        include __DIR__ . '/../../../../systeme/make-your-style/api_espace_publique.php';
    } else {
        include __DIR__ . '/../../../../systeme/make-your-style/api_espace_privee.php';
    }

    session_write_close();

    $table_article = new article();

/*
    +-----------+
    |  Ajouter  |
    +-----------+
*/
    $article_Libelle = lecture_parametre_api("article_Libelle", '');
    $article_Photo_Fichier = lecture_parametre_api("article_Photo_Fichier", '');
    $article_Prix = lecture_parametre_api("article_Prix", '');
    $article_Actif = lecture_parametre_api("article_Actif", '');
    $Code_type_produit = lecture_parametre_api("Code_type_produit", 0);
    $retour = $table_article->mf_ajouter($article_Libelle, $article_Photo_Fichier, $article_Prix, $article_Actif, $Code_type_produit);
    if ( $retour['code_erreur']==0 )
    {
        $cache = new Cachehtml();
        $cache->clear();
    }
    $retour_json = [];
    $retour_json['code_erreur'] = $retour['code_erreur'];
    $retour_json['message_erreur'] = ( (isset($retour) && $retour['code_erreur']>0) ? (isset($mf_libelle_erreur[$retour['code_erreur']]) ? $mf_libelle_erreur[$retour['code_erreur']] : 'ERREUR N_'.$retour['code_erreur'] ) : '' );
    $retour_json['Code_article'] = $retour['Code_article'];
    fermeture_connexion_db();
    $time_end = microtime(true);
    $retour_json['duree'] = round( $time_end-$time_start, 4 );
    vue_api_echo( $retour_json );
