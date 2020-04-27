<?php declare(strict_types=1);

    include __DIR__ . '/../../../../systeme/make-your-style/acces_api_rest/article.php';
    if (API_REST_ACCESS_POST_ARTICLE == 'all') {
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
    $article_Libelle = (string) lecture_parametre_api("article_Libelle", '');
    $article_Description = (string) lecture_parametre_api("article_Description", '');
    $article_Saison_Type = (int) lecture_parametre_api("article_Saison_Type", '');
    $article_Nom_fournisseur = (string) lecture_parametre_api("article_Nom_fournisseur", '');
    $article_Url = (string) lecture_parametre_api("article_Url", '');
    $article_Reference = (string) lecture_parametre_api("article_Reference", '');
    $article_Couleur = (string) lecture_parametre_api("article_Couleur", '');
    $article_Code_couleur_svg = (string) lecture_parametre_api("article_Code_couleur_svg", '');
    $article_Taille_Pays_Type = (int) lecture_parametre_api("article_Taille_Pays_Type", '');
    $article_Taille = (int) lecture_parametre_api("article_Taille", '');
    $article_Matiere = (string) lecture_parametre_api("article_Matiere", '');
    $article_Photo_Fichier = (string) lecture_parametre_api("article_Photo_Fichier", '');
    $article_Prix = (float) lecture_parametre_api("article_Prix", '');
    $article_Actif = (bool) lecture_parametre_api("article_Actif", '');
    $Code_sous_categorie_article = (int) lecture_parametre_api("Code_sous_categorie_article", 0);
    $retour = $db->article()->mf_ajouter($article_Libelle, $article_Description, $article_Saison_Type, $article_Nom_fournisseur, $article_Url, $article_Reference, $article_Couleur, $article_Code_couleur_svg, $article_Taille_Pays_Type, $article_Taille, $article_Matiere, $article_Photo_Fichier, $article_Prix, $article_Actif, $Code_sous_categorie_article);
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
    $retour_json['duree'] = get_execution_time(4);
    vue_api_echo($retour_json);
