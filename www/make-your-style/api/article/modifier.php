<?php declare(strict_types=1);

    include __DIR__ . '/../../../../systeme/make-your-style/acces_api_rest/article.php';
    if (API_REST_ACCESS_PUT_ARTICLE == 'all') {
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
    $Code_article = lecture_parametre_api("Code_article", 0 );
    $champs = [];
    if ( isset_parametre_api("article_Libelle") ) $champs['article_Libelle'] = lecture_parametre_api("article_Libelle");
    if ( isset_parametre_api("article_Description") ) $champs['article_Description'] = lecture_parametre_api("article_Description");
    if ( isset_parametre_api("article_Saison_Type") ) $champs['article_Saison_Type'] = lecture_parametre_api("article_Saison_Type");
    if ( isset_parametre_api("article_Nom_fournisseur") ) $champs['article_Nom_fournisseur'] = lecture_parametre_api("article_Nom_fournisseur");
    if ( isset_parametre_api("article_Url") ) $champs['article_Url'] = lecture_parametre_api("article_Url");
    if ( isset_parametre_api("article_Reference") ) $champs['article_Reference'] = lecture_parametre_api("article_Reference");
    if ( isset_parametre_api("article_Couleur") ) $champs['article_Couleur'] = lecture_parametre_api("article_Couleur");
    if ( isset_parametre_api("article_Code_couleur_svg") ) $champs['article_Code_couleur_svg'] = lecture_parametre_api("article_Code_couleur_svg");
    if ( isset_parametre_api("article_Taille_Pays_Type") ) $champs['article_Taille_Pays_Type'] = lecture_parametre_api("article_Taille_Pays_Type");
    if ( isset_parametre_api("article_Taille") ) $champs['article_Taille'] = lecture_parametre_api("article_Taille");
    if ( isset_parametre_api("article_Matiere") ) $champs['article_Matiere'] = lecture_parametre_api("article_Matiere");
    if ( isset_parametre_api("article_Photo_Fichier") ) $champs['article_Photo_Fichier'] = lecture_parametre_api("article_Photo_Fichier");
    if ( isset_parametre_api("article_Prix") ) $champs['article_Prix'] = lecture_parametre_api("article_Prix");
    if ( isset_parametre_api("article_Actif") ) $champs['article_Actif'] = lecture_parametre_api("article_Actif");
    if ( isset_parametre_api("Code_sous_categorie_article") ) $champs['Code_sous_categorie_article'] = lecture_parametre_api("Code_sous_categorie_article");
    $retour = $db->article()->mf_modifier_2([$Code_article => $champs]);
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
