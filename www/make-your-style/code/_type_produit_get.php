<?php

    // Actualisation des droits
    Hook_type_produit::hook_actualiser_les_droits_modifier($type_produit['Code_type_produit']);
    Hook_type_produit::hook_actualiser_les_droits_supprimer($type_produit['Code_type_produit']);

    // boutons
        if ($mf_droits_defaut['type_produit__MODIFIER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_type_produit') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_type_produit&Code_type_produit='.$Code_type_produit, 'lien', 'bouton_modifier_type_produit');
        }
        $trans['{bouton_modifier_type_produit}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_type_produit') : '';
        if ($mf_droits_defaut['type_produit__SUPPRIMER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_SUPPRIMER_PREC . get_nom_colonne('bouton_supprimer_type_produit') . BOUTON_LIBELLE_SUPPRIMER_SUIV, get_nom_page_courante().'?act=supprimer_type_produit&Code_type_produit='.$Code_type_produit, 'lien', 'bouton_supprimer_type_produit');
        }
        $trans['{bouton_supprimer_type_produit}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_supprimer_type_produit', BOUTON_CLASSE_SUPPRIMER) : '';

        // type_produit_Libelle
        if ( $mf_droits_defaut['api_modifier__type_produit_Libelle'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_type_produit_Libelle') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_type_produit_Libelle&Code_type_produit='.$Code_type_produit, 'lien', 'bouton_modifier_type_produit_Libelle');
        }
        $trans['{bouton_modifier_type_produit_Libelle}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_type_produit_Libelle') : '';

    /* prec_et_suiv */
    if ( $table_type_produit->mf_compter()<100 )
    {
        $liste_type_produit = $table_type_produit->mf_lister_contexte();
        // prec
        $prec_et_suiv = prec_suiv($liste_type_produit, $type_produit['Code_type_produit']);
        $prec=['link'=>'', 'title'=>''];
        $suiv=['link'=>'', 'title'=>''];
        if (isset($prec_et_suiv['prec']['Code_type_produit']))
        {
            $prec['link'] = get_nom_page_courante().'?act=apercu_type_produit&Code_type_produit='.$prec_et_suiv['prec']['Code_type_produit'];
            $prec['title'] = htmlspecialchars(get_titre_ligne_table('type_produit', $prec_et_suiv['prec']));
        }
        // suiv
        if (isset($prec_et_suiv['suiv']['Code_type_produit']))
        {
            $suiv['link'] = get_nom_page_courante().'?act=apercu_type_produit&Code_type_produit='.$prec_et_suiv['suiv']['Code_type_produit'];
            $suiv['title'] = htmlspecialchars(get_titre_ligne_table('type_produit', $prec_et_suiv['suiv']));
        }
        $trans['{pager_type_produit}'] = get_code_pager($prec, $suiv);
    }
    else
    {
        $trans['{pager_type_produit}'] = '';
    }

    /* type_produit_Libelle */
        if ( $mf_droits_defaut['api_modifier__type_produit_Libelle'] )
            $trans['{type_produit_Libelle}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_type_produit' => $type_produit['Code_type_produit']) , 'DB_name' => 'type_produit_Libelle' , 'valeur_initiale' => $type_produit['type_produit_Libelle'] ]);
        else
            $trans['{type_produit_Libelle}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_type_produit' => $type_produit['Code_type_produit']) , 'DB_name' => 'type_produit_Libelle' , 'valeur_initiale' => $type_produit['type_produit_Libelle'] ]);

