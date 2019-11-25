<?php

    $est_charge['filtre'] = 1;

/*
    +-----------+
    |  Ajouter  |
    +-----------+
*/
    if ( $mf_action=='ajouter_filtre' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $mf_add = [];
        if ( isset( $_POST['filtre_Libelle'] ) ) { $mf_add['filtre_Libelle'] = $_POST['filtre_Libelle']; }
        $retour = $table_filtre->mf_ajouter_2($mf_add);
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = "apercu_filtre";
            $Code_filtre =  $retour['Code_filtre'];
            $mf_contexte['Code_filtre'] = $retour['Code_filtre'];
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
    if ( $mf_action=="creer_filtre" )
    {
        $retour = $table_filtre->mf_creer();
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = "apercu_filtre";
            $Code_filtre =  $retour['Code_filtre'];
            $mf_contexte['Code_filtre'] = $retour['Code_filtre'];
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
    if ( $mf_action=="modifier_filtre" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $mf_update = [];
        if ( isset( $_POST['filtre_Libelle'] ) ) { $mf_update['filtre_Libelle'] = $_POST['filtre_Libelle']; }
        $retour = $table_filtre->mf_modifier_2( [ $Code_filtre => $mf_update ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_filtre';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_filtre_Libelle' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $filtre_Libelle = $_POST['filtre_Libelle'];
        $retour = $table_filtre->mf_modifier_2( [ $Code_filtre => [ 'filtre_Libelle' => $filtre_Libelle ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_filtre';
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
    if ( $mf_action=="supprimer_filtre" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $Supprimer = round($_POST["Supprimer"]);
        if ($Supprimer==1)
        {
            $retour = $table_filtre->mf_supprimer($Code_filtre);
            if ( $retour['code_erreur']==0 )
            {
                $mf_action = "-";
                $cache->clear();
                $Code_filtre = 0;
            }
            else
            {
                $cache->clear_current_page();
            }
        }
        else
        {
            $mf_action = "apercu_filtre";
            $cache->clear_current_page();
        }
    }
