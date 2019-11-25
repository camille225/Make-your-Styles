<?php

    $est_charge['commande'] = 1;

    if (!isset($lang_standard['Code_utilisateur_']))
    {
        $lang_standard['Code_utilisateur_'] = array();
        $table_utilisateur = new utilisateur();
        $liste = $table_utilisateur->mf_lister_contexte();
        foreach ($liste as $code => $value)
        {
            $lang_standard['Code_utilisateur_'][$code] = get_titre_ligne_table('utilisateur', $value);
        }
    }

/*
    +-----------+
    |  Ajouter  |
    +-----------+
*/
    if ( $mf_action=='ajouter_commande' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $mf_add = [];
        if ( isset( $_POST['commande_Prix_total'] ) ) { $mf_add['commande_Prix_total'] = $_POST['commande_Prix_total']; }
        if ( isset( $_POST['commande_Date_livraison'] ) ) { $mf_add['commande_Date_livraison'] = $_POST['commande_Date_livraison']; }
        if ( isset( $_POST['commande_Date_creation'] ) ) { $mf_add['commande_Date_creation'] = $_POST['commande_Date_creation']; }
        $mf_add['Code_utilisateur'] = ( isset($_POST['Code_utilisateur']) ? $_POST['Code_utilisateur'] : $Code_utilisateur );
        $retour = $table_commande->mf_ajouter_2($mf_add);
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = "apercu_commande";
            $Code_commande =  $retour['Code_commande'];
            $mf_contexte['Code_commande'] = $retour['Code_commande'];
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
    if ( $mf_action=="creer_commande" )
    {
        $retour = $table_commande->mf_creer($Code_utilisateur);
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = "apercu_commande";
            $Code_commande =  $retour['Code_commande'];
            $mf_contexte['Code_commande'] = $retour['Code_commande'];
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
    if ( $mf_action=="modifier_commande" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $mf_update = [];
        if ( isset( $_POST['commande_Prix_total'] ) ) { $mf_update['commande_Prix_total'] = $_POST['commande_Prix_total']; }
        if ( isset( $_POST['commande_Date_livraison'] ) ) { $mf_update['commande_Date_livraison'] = $_POST['commande_Date_livraison']; }
        if ( isset( $_POST['commande_Date_creation'] ) ) { $mf_update['commande_Date_creation'] = $_POST['commande_Date_creation']; }
        if ( isset($_POST['Code_utilisateur']) ) { $mf_update['Code_utilisateur'] = $_POST['Code_utilisateur']; }
        $retour = $table_commande->mf_modifier_2( [ $Code_commande => $mf_update ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_commande';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_commande_Prix_total' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $commande_Prix_total = $_POST['commande_Prix_total'];
        $retour = $table_commande->mf_modifier_2( [ $Code_commande => [ 'commande_Prix_total' => $commande_Prix_total ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_commande';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_commande_Date_livraison' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $commande_Date_livraison = $_POST['commande_Date_livraison'];
        $retour = $table_commande->mf_modifier_2( [ $Code_commande => [ 'commande_Date_livraison' => $commande_Date_livraison ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_commande';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_commande_Date_creation' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $commande_Date_creation = $_POST['commande_Date_creation'];
        $retour = $table_commande->mf_modifier_2( [ $Code_commande => [ 'commande_Date_creation' => $commande_Date_creation ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_commande';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_commande__Code_utilisateur' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $retour = $table_commande->mf_modifier_2( [ $Code_commande => [ 'Code_utilisateur' => ( isset($_POST['Code_utilisateur']) ? $_POST['Code_utilisateur'] : $Code_utilisateur ) ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_commande';
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
    if ( $mf_action=="supprimer_commande" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $Supprimer = round($_POST["Supprimer"]);
        if ($Supprimer==1)
        {
            $retour = $table_commande->mf_supprimer($Code_commande);
            if ( $retour['code_erreur']==0 )
            {
                $mf_action = "-";
                $cache->clear();
                $Code_commande = 0;
            }
            else
            {
                $cache->clear_current_page();
            }
        }
        else
        {
            $mf_action = "apercu_commande";
            $cache->clear_current_page();
        }
    }
