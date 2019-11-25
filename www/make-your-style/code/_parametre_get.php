<?php

    // Actualisation des droits
    Hook_parametre::hook_actualiser_les_droits_modifier($parametre['Code_parametre']);
    Hook_parametre::hook_actualiser_les_droits_supprimer($parametre['Code_parametre']);

    // boutons
        if ($mf_droits_defaut['parametre__MODIFIER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_parametre') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_parametre&Code_parametre='.$Code_parametre, 'lien', 'bouton_modifier_parametre');
        }
        $trans['{bouton_modifier_parametre}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_parametre') : '';
        if ($mf_droits_defaut['parametre__SUPPRIMER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_SUPPRIMER_PREC . get_nom_colonne('bouton_supprimer_parametre') . BOUTON_LIBELLE_SUPPRIMER_SUIV, get_nom_page_courante().'?act=supprimer_parametre&Code_parametre='.$Code_parametre, 'lien', 'bouton_supprimer_parametre');
        }
        $trans['{bouton_supprimer_parametre}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_supprimer_parametre', BOUTON_CLASSE_SUPPRIMER) : '';

        // parametre_Libelle
        if ( $mf_droits_defaut['api_modifier__parametre_Libelle'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_parametre_Libelle') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_parametre_Libelle&Code_parametre='.$Code_parametre, 'lien', 'bouton_modifier_parametre_Libelle');
        }
        $trans['{bouton_modifier_parametre_Libelle}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_parametre_Libelle') : '';

    /* prec_et_suiv */
    if ( $table_parametre->mf_compter()<100 )
    {
        $liste_parametre = $table_parametre->mf_lister_contexte();
        // prec
        $prec_et_suiv = prec_suiv($liste_parametre, $parametre['Code_parametre']);
        $prec=['link'=>'', 'title'=>''];
        $suiv=['link'=>'', 'title'=>''];
        if (isset($prec_et_suiv['prec']['Code_parametre']))
        {
            $prec['link'] = get_nom_page_courante().'?act=apercu_parametre&Code_parametre='.$prec_et_suiv['prec']['Code_parametre'];
            $prec['title'] = htmlspecialchars(get_titre_ligne_table('parametre', $prec_et_suiv['prec']));
        }
        // suiv
        if (isset($prec_et_suiv['suiv']['Code_parametre']))
        {
            $suiv['link'] = get_nom_page_courante().'?act=apercu_parametre&Code_parametre='.$prec_et_suiv['suiv']['Code_parametre'];
            $suiv['title'] = htmlspecialchars(get_titre_ligne_table('parametre', $prec_et_suiv['suiv']));
        }
        $trans['{pager_parametre}'] = get_code_pager($prec, $suiv);
    }
    else
    {
        $trans['{pager_parametre}'] = '';
    }

    /* parametre_Libelle */
        if ( $mf_droits_defaut['api_modifier__parametre_Libelle'] )
            $trans['{parametre_Libelle}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_parametre' => $parametre['Code_parametre']) , 'DB_name' => 'parametre_Libelle' , 'valeur_initiale' => $parametre['parametre_Libelle'] ]);
        else
            $trans['{parametre_Libelle}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_parametre' => $parametre['Code_parametre']) , 'DB_name' => 'parametre_Libelle' , 'valeur_initiale' => $parametre['parametre_Libelle'] ]);

