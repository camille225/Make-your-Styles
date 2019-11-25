<?php

    $est_charge['type_produit'] = 1;

/*
    +-----------+
    |  Ajouter  |
    +-----------+
*/
    if ( $mf_action=='ajouter_type_produit' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $mf_add = [];
        if ( isset( $_POST['type_produit_Libelle'] ) ) { $mf_add['type_produit_Libelle'] = $_POST['type_produit_Libelle']; }
        $retour = $table_type_produit->mf_ajouter_2($mf_add);
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = "apercu_type_produit";
            $Code_type_produit =  $retour['Code_type_produit'];
            $mf_contexte['Code_type_produit'] = $retour['Code_type_produit'];
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
    if ( $mf_action=="creer_type_produit" )
    {
        $retour = $table_type_produit->mf_creer();
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = "apercu_type_produit";
            $Code_type_produit =  $retour['Code_type_produit'];
            $mf_contexte['Code_type_produit'] = $retour['Code_type_produit'];
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
    if ( $mf_action=="modifier_type_produit" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $mf_update = [];
        if ( isset( $_POST['type_produit_Libelle'] ) ) { $mf_update['type_produit_Libelle'] = $_POST['type_produit_Libelle']; }
        $retour = $table_type_produit->mf_modifier_2( [ $Code_type_produit => $mf_update ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_type_produit';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_type_produit_Libelle' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $type_produit_Libelle = $_POST['type_produit_Libelle'];
        $retour = $table_type_produit->mf_modifier_2( [ $Code_type_produit => [ 'type_produit_Libelle' => $type_produit_Libelle ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_type_produit';
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
    if ( $mf_action=="supprimer_type_produit" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $Supprimer = round($_POST["Supprimer"]);
        if ($Supprimer==1)
        {
            $retour = $table_type_produit->mf_supprimer($Code_type_produit);
            if ( $retour['code_erreur']==0 )
            {
                $mf_action = "-";
                $cache->clear();
                $Code_type_produit = 0;
            }
            else
            {
                $cache->clear_current_page();
            }
        }
        else
        {
            $mf_action = "apercu_type_produit";
            $cache->clear_current_page();
        }
    }
