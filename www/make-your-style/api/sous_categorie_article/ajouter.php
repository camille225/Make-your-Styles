<?php declare(strict_types=1);

    include __DIR__ . '/../../../../systeme/make-your-style/acces_api_rest/sous_categorie_article.php';
    if (API_REST_ACCESS_POST_SOUS_CATEGORIE_ARTICLE == 'all') {
        include __DIR__ . '/../../../../systeme/make-your-style/api_espace_publique.php';
    } else {
        include __DIR__ . '/../../../../systeme/make-your-style/api_espace_privee.php';
    }

    $db = new DB();

/*
    +-----------+
    |  Ajouter  |
    +-----------+
*/
    $sous_categorie_article_Libelle = (string) lecture_parametre_api("sous_categorie_article_Libelle", '');
    $Code_categorie_article = (int) lecture_parametre_api("Code_categorie_article", 0);
    $retour = $db->sous_categorie_article()->mf_ajouter($sous_categorie_article_Libelle, $Code_categorie_article);
    if ( $retour['code_erreur']==0 )
    {
        $cache = new Cachehtml();
        $cache->clear();
    }
    $retour_json = [];
    $retour_json['code_erreur'] = $retour['code_erreur'];
    $retour_json['message_erreur'] = ( (isset($retour) && $retour['code_erreur']>0) ? (isset($mf_libelle_erreur[$retour['code_erreur']]) ? $mf_libelle_erreur[$retour['code_erreur']] : 'ERREUR N_'.$retour['code_erreur'] ) : '' );
    $retour_json['Code_sous_categorie_article'] = $retour['Code_sous_categorie_article'];
    fermeture_connexion_db();
    $retour_json['duree'] = get_execution_time(4);
    vue_api_echo($retour_json);
