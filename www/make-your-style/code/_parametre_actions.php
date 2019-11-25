<?php

    $est_charge['parametre'] = 1;

/*
    +-----------+
    |  Ajouter  |
    +-----------+
*/
    if ( $mf_action=='ajouter_parametre' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $mf_add = [];
        if ( isset( $_POST['parametre_Libelle'] ) ) { $mf_add['parametre_Libelle'] = $_POST['parametre_Libelle']; }
        $retour = $table_parametre->mf_ajouter_2($mf_add);
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = "apercu_parametre";
            $Code_parametre =  $retour['Code_parametre'];
            $mf_contexte['Code_parametre'] = $retour['Code_parametre'];
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
    if ( $mf_action=="creer_parametre" )
    {
        $retour = $table_parametre->mf_creer();
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = "apercu_parametre";
            $Code_parametre =  $retour['Code_parametre'];
            $mf_contexte['Code_parametre'] = $retour['Code_parametre'];
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
    if ( $mf_action=="modifier_parametre" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $mf_update = [];
        if ( isset( $_POST['parametre_Libelle'] ) ) { $mf_update['parametre_Libelle'] = $_POST['parametre_Libelle']; }
        $retour = $table_parametre->mf_modifier_2( [ $Code_parametre => $mf_update ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_parametre';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_parametre_Libelle' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $parametre_Libelle = $_POST['parametre_Libelle'];
        $retour = $table_parametre->mf_modifier_2( [ $Code_parametre => [ 'parametre_Libelle' => $parametre_Libelle ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_parametre';
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
    if ( $mf_action=="supprimer_parametre" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $Supprimer = round($_POST["Supprimer"]);
        if ($Supprimer==1)
        {
            $retour = $table_parametre->mf_supprimer($Code_parametre);
            if ( $retour['code_erreur']==0 )
            {
                $mf_action = "-";
                $cache->clear();
                $Code_parametre = 0;
            }
            else
            {
                $cache->clear_current_page();
            }
        }
        else
        {
            $mf_action = "apercu_parametre";
            $cache->clear_current_page();
        }
    }
