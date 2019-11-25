<?php

    $est_charge['article'] = 1;

    if (!isset($lang_standard['Code_type_produit_']))
    {
        $lang_standard['Code_type_produit_'] = array();
        $table_type_produit = new type_produit();
        $liste = $table_type_produit->mf_lister_contexte();
        foreach ($liste as $code => $value)
        {
            $lang_standard['Code_type_produit_'][$code] = get_titre_ligne_table('type_produit', $value);
        }
    }

/*
    +-----------+
    |  Ajouter  |
    +-----------+
*/
    if ( $mf_action=='ajouter_article' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $mf_add = [];
        if ( isset( $_POST['article_Libelle'] ) ) { $mf_add['article_Libelle'] = $_POST['article_Libelle']; }
        if ( isset( $_FILES['article_Photo_Fichier'] ) ) { $fichier = new Fichier(); $mf_add['article_Photo_Fichier'] = $fichier->importer($_FILES['article_Photo_Fichier']); }
        if ( isset( $_POST['article_Prix'] ) ) { $mf_add['article_Prix'] = $_POST['article_Prix']; }
        if ( isset( $_POST['article_Actif'] ) ) { $mf_add['article_Actif'] = $_POST['article_Actif']; }
        $mf_add['Code_type_produit'] = ( isset($_POST['Code_type_produit']) ? $_POST['Code_type_produit'] : $Code_type_produit );
        $retour = $table_article->mf_ajouter_2($mf_add);
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = "apercu_article";
            $Code_article =  $retour['Code_article'];
            $mf_contexte['Code_article'] = $retour['Code_article'];
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

/*
    +---------+
    |  Creer  |
    +---------+
*/
    if ( $mf_action=="creer_article" )
    {
        $retour = $table_article->mf_creer($Code_type_produit);
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = "apercu_article";
            $Code_article =  $retour['Code_article'];
            $mf_contexte['Code_article'] = $retour['Code_article'];
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

/*
    +------------+
    |  Modifier  |
    +------------+
*/
    if ( $mf_action=="modifier_article" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $mf_update = [];
        if ( isset( $_POST['article_Libelle'] ) ) { $mf_update['article_Libelle'] = $_POST['article_Libelle']; }
        if ( isset( $_FILES['article_Photo_Fichier'] ) ) { $fichier = new Fichier(); $mf_update['article_Photo_Fichier'] = $fichier->importer($_FILES['article_Photo_Fichier']); }
        if ( isset( $_POST['article_Prix'] ) ) { $mf_update['article_Prix'] = $_POST['article_Prix']; }
        if ( isset( $_POST['article_Actif'] ) ) { $mf_update['article_Actif'] = $_POST['article_Actif']; }
        if ( isset($_POST['Code_type_produit']) ) { $mf_update['Code_type_produit'] = $_POST['Code_type_produit']; }
        $retour = $table_article->mf_modifier_2( [ $Code_article => $mf_update ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_article';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_article_Libelle' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $article_Libelle = $_POST['article_Libelle'];
        $retour = $table_article->mf_modifier_2( [ $Code_article => [ 'article_Libelle' => $article_Libelle ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_article';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_article_Photo_Fichier' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $fichier = new Fichier();
        $article_Photo_Fichier = $fichier->importer($_FILES['article_Photo_Fichier']);
        if ($article_Photo_Fichier=='') { $temp = $table_article->mf_get($Code_article); $article_Photo_Fichier = $temp['article_Photo_Fichier']; }
        $retour = $table_article->mf_modifier_2( [ $Code_article => [ 'article_Photo_Fichier' => $article_Photo_Fichier ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_article';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_article_Prix' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $article_Prix = $_POST['article_Prix'];
        $retour = $table_article->mf_modifier_2( [ $Code_article => [ 'article_Prix' => $article_Prix ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_article';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_article_Actif' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $article_Actif = $_POST['article_Actif'];
        $retour = $table_article->mf_modifier_2( [ $Code_article => [ 'article_Actif' => $article_Actif ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_article';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_article__Code_type_produit' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $retour = $table_article->mf_modifier_2( [ $Code_article => [ 'Code_type_produit' => ( isset($_POST['Code_type_produit']) ? $_POST['Code_type_produit'] : $Code_type_produit ) ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_article';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

/*
    +-------------+
    |  Supprimer  |
    +-------------+
*/
    if ( $mf_action=="supprimer_article" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $Supprimer = round($_POST["Supprimer"]);
        if ($Supprimer==1)
        {
            $retour = $table_article->mf_supprimer($Code_article);
            if ( $retour['code_erreur']==0 )
            {
                $mf_action = "-";
                $cache->clear();
                $Code_article = 0;
            }
            else
            {
                $cache->clear_current_page();
            }
        }
        else
        {
            $mf_action = "apercu_article";
            $cache->clear_current_page();
        }
    }
