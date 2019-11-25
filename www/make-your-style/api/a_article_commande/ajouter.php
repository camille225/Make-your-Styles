<?php

    $time_start = microtime(true);

    include __DIR__ . '/../../../../systeme/make-your-style/acces_api_rest/a_article_commande.php';
    if (API_REST_ACCESS_POST_A_ARTICLE_COMMANDE == 'all') {
        include __DIR__ . '/../../../../systeme/make-your-style/api_espace_publique.php';
    } else {
        include __DIR__ . '/../../../../systeme/make-your-style/api_espace_privee.php';
    }

    session_write_close();

    $table_a_article_commande = new a_article_commande();

/*
    +-----------+
    |  Ajouter  |
    +-----------+
*/
    $Code_commande = lecture_parametre_api("Code_commande", 0);
    $Code_article = lecture_parametre_api("Code_article", 0);
    $retour = $table_a_article_commande->mf_ajouter($Code_commande, $Code_article);
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
