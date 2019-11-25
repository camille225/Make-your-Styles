<?php

    // Actualisation des droits
    Hook_utilisateur::hook_actualiser_les_droits_modifier($utilisateur['Code_utilisateur']);
    Hook_utilisateur::hook_actualiser_les_droits_supprimer($utilisateur['Code_utilisateur']);

    // boutons
        if ($mf_droits_defaut['utilisateur__MODIFIER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_utilisateur') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_utilisateur&Code_utilisateur='.$Code_utilisateur, 'lien', 'bouton_modifier_utilisateur');
        }
        $trans['{bouton_modifier_utilisateur}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_utilisateur') : '';
        if ($mf_droits_defaut['utilisateur__MODIFIER_PWD'])
        {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_MODIFIER_PWD_PREC . get_nom_colonne('bouton_modpwd_utilisateur') . BOUTON_LIBELLE_MODIFIER_PWD_SUIV, get_nom_page_courante().'?act=modpwd&Code_utilisateur='.$Code_utilisateur, 'lien', 'bouton_modpwd_utilisateur');
        }
        $trans['{bouton_modpwd_utilisateur}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modpwd_utilisateur') : '';
        if ($mf_droits_defaut['utilisateur__SUPPRIMER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_SUPPRIMER_PREC . get_nom_colonne('bouton_supprimer_utilisateur') . BOUTON_LIBELLE_SUPPRIMER_SUIV, get_nom_page_courante().'?act=supprimer_utilisateur&Code_utilisateur='.$Code_utilisateur, 'lien', 'bouton_supprimer_utilisateur');
        }
        $trans['{bouton_supprimer_utilisateur}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_supprimer_utilisateur', BOUTON_CLASSE_SUPPRIMER) : '';

        // utilisateur_Identifiant
        if ( $mf_droits_defaut['api_modifier__utilisateur_Identifiant'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_utilisateur_Identifiant') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_utilisateur_Identifiant&Code_utilisateur='.$Code_utilisateur, 'lien', 'bouton_modifier_utilisateur_Identifiant');
        }
        $trans['{bouton_modifier_utilisateur_Identifiant}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_utilisateur_Identifiant') : '';

        // utilisateur_Password
        if ( $mf_droits_defaut['api_modifier__utilisateur_Password'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_utilisateur_Password') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_utilisateur_Password&Code_utilisateur='.$Code_utilisateur, 'lien', 'bouton_modifier_utilisateur_Password');
        }
        $trans['{bouton_modifier_utilisateur_Password}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_utilisateur_Password') : '';

        // utilisateur_Email
        if ( $mf_droits_defaut['api_modifier__utilisateur_Email'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_utilisateur_Email') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_utilisateur_Email&Code_utilisateur='.$Code_utilisateur, 'lien', 'bouton_modifier_utilisateur_Email');
        }
        $trans['{bouton_modifier_utilisateur_Email}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_utilisateur_Email') : '';

        // utilisateur_Administrateur
        if ( $mf_droits_defaut['api_modifier__utilisateur_Administrateur'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_utilisateur_Administrateur') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_utilisateur_Administrateur&Code_utilisateur='.$Code_utilisateur, 'lien', 'bouton_modifier_utilisateur_Administrateur');
        }
        $trans['{bouton_modifier_utilisateur_Administrateur}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_utilisateur_Administrateur') : '';

        // utilisateur_Developpeur
        if ( $mf_droits_defaut['api_modifier__utilisateur_Developpeur'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_utilisateur_Developpeur') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_utilisateur_Developpeur&Code_utilisateur='.$Code_utilisateur, 'lien', 'bouton_modifier_utilisateur_Developpeur');
        }
        $trans['{bouton_modifier_utilisateur_Developpeur}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_utilisateur_Developpeur') : '';

    /* prec_et_suiv */
    if ( $table_utilisateur->mf_compter()<100 )
    {
        $liste_utilisateur = $table_utilisateur->mf_lister_contexte();
        // prec
        $prec_et_suiv = prec_suiv($liste_utilisateur, $utilisateur['Code_utilisateur']);
        $prec=['link'=>'', 'title'=>''];
        $suiv=['link'=>'', 'title'=>''];
        if (isset($prec_et_suiv['prec']['Code_utilisateur']))
        {
            $prec['link'] = get_nom_page_courante().'?act=apercu_utilisateur&Code_utilisateur='.$prec_et_suiv['prec']['Code_utilisateur'];
            $prec['title'] = htmlspecialchars(get_titre_ligne_table('utilisateur', $prec_et_suiv['prec']));
        }
        // suiv
        if (isset($prec_et_suiv['suiv']['Code_utilisateur']))
        {
            $suiv['link'] = get_nom_page_courante().'?act=apercu_utilisateur&Code_utilisateur='.$prec_et_suiv['suiv']['Code_utilisateur'];
            $suiv['title'] = htmlspecialchars(get_titre_ligne_table('utilisateur', $prec_et_suiv['suiv']));
        }
        $trans['{pager_utilisateur}'] = get_code_pager($prec, $suiv);
    }
    else
    {
        $trans['{pager_utilisateur}'] = '';
    }

    /* utilisateur_Identifiant */
        if ( $mf_droits_defaut['api_modifier__utilisateur_Identifiant'] )
            $trans['{utilisateur_Identifiant}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_utilisateur' => $utilisateur['Code_utilisateur']) , 'DB_name' => 'utilisateur_Identifiant' , 'valeur_initiale' => $utilisateur['utilisateur_Identifiant'] ]);
        else
            $trans['{utilisateur_Identifiant}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_utilisateur' => $utilisateur['Code_utilisateur']) , 'DB_name' => 'utilisateur_Identifiant' , 'valeur_initiale' => $utilisateur['utilisateur_Identifiant'] ]);

    /* utilisateur_Password */
        $trans['{utilisateur_Password}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_utilisateur' => $utilisateur['Code_utilisateur']) , 'DB_name' => 'utilisateur_Password' , 'valeur_initiale' => $trans['{bouton_modpwd_utilisateur}'] , 'class' => 'html' , 'maj_auto' => false ]);

    /* utilisateur_Email */
        if ( $mf_droits_defaut['api_modifier__utilisateur_Email'] )
            $trans['{utilisateur_Email}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_utilisateur' => $utilisateur['Code_utilisateur']) , 'DB_name' => 'utilisateur_Email' , 'valeur_initiale' => $utilisateur['utilisateur_Email'] ]);
        else
            $trans['{utilisateur_Email}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_utilisateur' => $utilisateur['Code_utilisateur']) , 'DB_name' => 'utilisateur_Email' , 'valeur_initiale' => $utilisateur['utilisateur_Email'] ]);

    /* utilisateur_Administrateur */
        if ( $mf_droits_defaut['api_modifier__utilisateur_Administrateur'] )
            $trans['{utilisateur_Administrateur}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_utilisateur' => $utilisateur['Code_utilisateur']) , 'DB_name' => 'utilisateur_Administrateur' , 'valeur_initiale' => $utilisateur['utilisateur_Administrateur'], 'class' => 'button' ]);
        else
            $trans['{utilisateur_Administrateur}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_utilisateur' => $utilisateur['Code_utilisateur']) , 'DB_name' => 'utilisateur_Administrateur' , 'valeur_initiale' => $utilisateur['utilisateur_Administrateur'] ]);

    /* utilisateur_Developpeur */
        if ( $mf_droits_defaut['api_modifier__utilisateur_Developpeur'] )
            $trans['{utilisateur_Developpeur}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_utilisateur' => $utilisateur['Code_utilisateur']) , 'DB_name' => 'utilisateur_Developpeur' , 'valeur_initiale' => $utilisateur['utilisateur_Developpeur'], 'class' => 'button' ]);
        else
            $trans['{utilisateur_Developpeur}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_utilisateur' => $utilisateur['Code_utilisateur']) , 'DB_name' => 'utilisateur_Developpeur' , 'valeur_initiale' => $utilisateur['utilisateur_Developpeur'] ]);

