<?php

    $est_charge['a_filtre_produit'] = 1;

    if (!isset($lang_standard['Code_filtre_']))
    {
        $lang_standard['Code_filtre_'] = array();
        $table_filtre = new filtre();
        $liste = $table_filtre->mf_lister_contexte();
        foreach ($liste as $code => $value)
        {
            $lang_standard['Code_filtre_'][$code] = get_titre_ligne_table('filtre', $value);
        }
    }
    if (!isset($lang_standard['Code_article_']))
    {
        $lang_standard['Code_article_'] = array();
        $table_article = new article();
        $liste = $table_article->mf_lister_contexte();
        foreach ($liste as $code => $value)
        {
            $lang_standard['Code_article_'][$code] = get_titre_ligne_table('article', $value);
        }
    }

/*
    +-----------+
    |  Ajouter  |
    +-----------+
*/
    if ( $mf_action=='ajouter_a_filtre_produit' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $mf_add = [];
        $mf_add['Code_filtre'] = ( isset( $_POST['Code_filtre'] ) ? $_POST['Code_filtre'] : $Code_filtre );
        $mf_add['Code_article'] = ( isset( $_POST['Code_article'] ) ? $_POST['Code_article'] : $Code_article );
        if ( isset( $_POST['a_filtre_produit_Actif'] ) ) { $mf_add['a_filtre_produit_Actif'] = $_POST['a_filtre_produit_Actif']; }
        $retour = $table_a_filtre_produit->mf_ajouter_2( $mf_add );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_a_filtre_produit';
            if (!isset($est_charge['filtre']))
            {
                $Code_filtre = ( isset( $_POST['Code_filtre'] ) ?  $_POST['Code_filtre'] : 0 );
            }
            if (!isset($est_charge['article']))
            {
                $Code_article = ( isset( $_POST['Code_article'] ) ?  $_POST['Code_article'] : 0 );
            }
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
    if ( $mf_action=="modifier_a_filtre_produit" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $mf_update = [];
        $mf_update['Code_filtre'] = $Code_filtre;
        $mf_update['Code_article'] = $Code_article;
        if ( isset( $_POST['a_filtre_produit_Actif'] ) ) { $mf_update['a_filtre_produit_Actif'] = $_POST['a_filtre_produit_Actif']; }
        $retour = $table_a_filtre_produit->mf_modifier_2( $mf_update );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = "apercu_a_filtre_produit";
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_a_filtre_produit_Actif' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $a_filtre_produit_Actif = $_POST['a_filtre_produit_Actif'];
        $retour = $table_a_filtre_produit -> mf_modifier_2( [ [ 'Code_filtre' => $Code_filtre , 'Code_article' => $Code_article , 'a_filtre_produit_Actif' => $a_filtre_produit_Actif ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_a_filtre_produit';
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
    if ( $mf_action=="supprimer_a_filtre_produit" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $Supprimer = round($_POST["Supprimer"]);
        if ($Supprimer==1)
        {
            $retour = $table_a_filtre_produit->mf_supprimer($Code_filtre, $Code_article);
            if ( $retour['code_erreur']==0 )
            {
                $mf_action = "-";
                $cache->clear();
            }
            else
            {
                $cache->clear_current_page();
            }
        }
        else
        {
            $mf_action = "apercu_a_filtre_produit";
            $cache->clear_current_page();
        }
    }
