<?php declare(strict_types=1);

    include __DIR__ . '/../../../../systeme/make-your-style/acces_api_rest/sous_categorie_article.php';
    if (API_REST_ACCESS_PUT_SOUS_CATEGORIE_ARTICLE == 'all') {
        include __DIR__ . '/../../../../systeme/make-your-style/api_espace_publique.php';
    } else {
        include __DIR__ . '/../../../../systeme/make-your-style/api_espace_privee.php';
    }

    $db = new DB();

/*
    +------------+
    |  Modifier  |
    +------------+
*/
    $Code_sous_categorie_article = lecture_parametre_api("Code_sous_categorie_article", 0 );
    $champs = [];
    if ( isset_parametre_api("sous_categorie_article_Libelle") ) $champs['sous_categorie_article_Libelle'] = lecture_parametre_api("sous_categorie_article_Libelle");
    if ( isset_parametre_api("Code_categorie_article") ) $champs['Code_categorie_article'] = lecture_parametre_api("Code_categorie_article");
    $retour = $db->sous_categorie_article()->mf_modifier_2([$Code_sous_categorie_article => $champs]);
    if ($retour['code_erreur'] == 0) {
        $cache = new Cachehtml();
        $cache->clear();
    }
    $retour_json = [];
    $retour_json['code_erreur'] = $retour['code_erreur'];
    $retour_json['message_erreur'] = ( (isset($retour) && $retour['code_erreur']>0) ? (isset($mf_libelle_erreur[$retour['code_erreur']]) ? $mf_libelle_erreur[$retour['code_erreur']] : 'ERREUR N_'.$retour['code_erreur'] ) : '' );
    fermeture_connexion_db();
    $retour_json['duree'] = get_execution_time(4);
    vue_api_echo($retour_json);
