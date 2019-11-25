<?php

    $est_charge['a_article_commande'] = 1;

    if (!isset($lang_standard['Code_commande_']))
    {
        $lang_standard['Code_commande_'] = array();
        $table_commande = new commande();
        $liste = $table_commande->mf_lister_contexte();
        foreach ($liste as $code => $value)
        {
            $lang_standard['Code_commande_'][$code] = get_titre_ligne_table('commande', $value);
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
    if ( $mf_action=='ajouter_a_article_commande' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $mf_add = [];
        $mf_add['Code_commande'] = ( isset( $_POST['Code_commande'] ) ? $_POST['Code_commande'] : $Code_commande );
        $mf_add['Code_article'] = ( isset( $_POST['Code_article'] ) ? $_POST['Code_article'] : $Code_article );
        $retour = $table_a_article_commande->mf_ajouter_2( $mf_add );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_a_article_commande';
            if (!isset($est_charge['commande']))
            {
                $Code_commande = ( isset( $_POST['Code_commande'] ) ?  $_POST['Code_commande'] : 0 );
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
    +-------------+
    |  Supprimer  |
    +-------------+
*/
    if ( $mf_action=="supprimer_a_article_commande" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $Supprimer = round($_POST["Supprimer"]);
        if ($Supprimer==1)
        {
            $retour = $table_a_article_commande->mf_supprimer($Code_commande, $Code_article);
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
            $mf_action = "apercu_a_article_commande";
            $cache->clear_current_page();
        }
    }
