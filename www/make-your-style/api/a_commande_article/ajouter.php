<?php declare(strict_types=1);

    include __DIR__ . '/../../../../systeme/make-your-style/acces_api_rest/a_commande_article.php';
    if (API_REST_ACCESS_POST_A_COMMANDE_ARTICLE == 'all') {
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
    $Code_commande = (int) lecture_parametre_api("Code_commande", 0);
    $Code_article = (int) lecture_parametre_api("Code_article", 0);
    $a_commande_article_Quantite = (int) lecture_parametre_api("a_commande_article_Quantite", '');
    $a_commande_article_Prix_ligne = (float) lecture_parametre_api("a_commande_article_Prix_ligne", '');
    $retour = $db->a_commande_article()->mf_ajouter($Code_commande, $Code_article, $a_commande_article_Quantite, $a_commande_article_Prix_ligne);
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
