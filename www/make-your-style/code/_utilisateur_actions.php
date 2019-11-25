<?php

    $est_charge['utilisateur'] = 1;

/*
    +-----------+
    |  Ajouter  |
    +-----------+
*/
    if ( $mf_action=='ajouter_utilisateur' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $mf_add = [];
        if ( isset( $_POST['utilisateur_Identifiant'] ) ) { $mf_add['utilisateur_Identifiant'] = $_POST['utilisateur_Identifiant']; }
        if ( isset( $_POST['utilisateur_Password'] ) ) { $mf_add['utilisateur_Password'] = $_POST['utilisateur_Password']; }
        if ( isset( $_POST['utilisateur_Email'] ) ) { $mf_add['utilisateur_Email'] = $_POST['utilisateur_Email']; }
        if ( isset( $_POST['utilisateur_Administrateur'] ) ) { $mf_add['utilisateur_Administrateur'] = $_POST['utilisateur_Administrateur']; }
        if ( isset( $_POST['utilisateur_Developpeur'] ) ) { $mf_add['utilisateur_Developpeur'] = $_POST['utilisateur_Developpeur']; }
        $retour = $table_utilisateur->mf_ajouter_2($mf_add);
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = "apercu_utilisateur";
            $Code_utilisateur =  $retour['Code_utilisateur'];
            $mf_contexte['Code_utilisateur'] = $retour['Code_utilisateur'];
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
    if ( $mf_action=="modifier_utilisateur" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $mf_update = [];
        if ( isset( $_POST['utilisateur_Identifiant'] ) ) { $mf_update['utilisateur_Identifiant'] = $_POST['utilisateur_Identifiant']; }
        // if ( isset( $_POST['utilisateur_Password'] ) ) { $mf_update['utilisateur_Password'] = $_POST['utilisateur_Password']; }
        if ( isset( $_POST['utilisateur_Email'] ) ) { $mf_update['utilisateur_Email'] = $_POST['utilisateur_Email']; }
        if ( isset( $_POST['utilisateur_Administrateur'] ) ) { $mf_update['utilisateur_Administrateur'] = $_POST['utilisateur_Administrateur']; }
        if ( isset( $_POST['utilisateur_Developpeur'] ) ) { $mf_update['utilisateur_Developpeur'] = $_POST['utilisateur_Developpeur']; }
        $retour = $table_utilisateur->mf_modifier_2( [ $Code_utilisateur => $mf_update ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_utilisateur';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_utilisateur_Identifiant' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $utilisateur_Identifiant = $_POST['utilisateur_Identifiant'];
        $retour = $table_utilisateur->mf_modifier_2( [ $Code_utilisateur => [ 'utilisateur_Identifiant' => $utilisateur_Identifiant ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_utilisateur';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_utilisateur_Email' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $utilisateur_Email = $_POST['utilisateur_Email'];
        $retour = $table_utilisateur->mf_modifier_2( [ $Code_utilisateur => [ 'utilisateur_Email' => $utilisateur_Email ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_utilisateur';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_utilisateur_Administrateur' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $utilisateur_Administrateur = $_POST['utilisateur_Administrateur'];
        $retour = $table_utilisateur->mf_modifier_2( [ $Code_utilisateur => [ 'utilisateur_Administrateur' => $utilisateur_Administrateur ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_utilisateur';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

    if ( $mf_action=='modifier_utilisateur_Developpeur' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $utilisateur_Developpeur = $_POST['utilisateur_Developpeur'];
        $retour = $table_utilisateur->mf_modifier_2( [ $Code_utilisateur => [ 'utilisateur_Developpeur' => $utilisateur_Developpeur ] ] );
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = 'apercu_utilisateur';
            $cache->clear();
        }
        else
        {
            $cache->clear_current_page();
        }
    }

/*
    +----------------------------+
    |  Modifier le mot de passe  |
    +----------------------------+
*/
    if ( $mf_action=="modpwd" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $utilisateur_Password_old=$_POST["utilisateur_Password_old"];
        $utilisateur_Password_new=$_POST["utilisateur_Password_new"];
        $utilisateur_Password_verif=$_POST["utilisateur_Password_verif"];
        $retour = $mf_connexion->changer_mot_de_passe($Code_utilisateur, $utilisateur_Password_old, $utilisateur_Password_new, $utilisateur_Password_verif);
        if ( $retour['code_erreur']==0 )
        {
            $mf_action = "apercu_utilisateur";
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
    if ( $mf_action=="supprimer_utilisateur" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire']) )
    {
        $Supprimer = round($_POST["Supprimer"]);
        if ($Supprimer==1)
        {
            $retour = $table_utilisateur->mf_supprimer($Code_utilisateur);
            if ( $retour['code_erreur']==0 )
            {
                $mf_action = "-";
                $cache->clear();
                $Code_utilisateur = 0;
            }
            else
            {
                $cache->clear_current_page();
            }
        }
        else
        {
            $mf_action = "apercu_utilisateur";
            $cache->clear_current_page();
        }
    }
