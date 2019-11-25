<?php

    // Actualisation des droits
    Hook_filtre::hook_actualiser_les_droits_modifier($filtre['Code_filtre']);
    Hook_filtre::hook_actualiser_les_droits_supprimer($filtre['Code_filtre']);

    // boutons
        if ($mf_droits_defaut['filtre__MODIFIER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_filtre') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_filtre&Code_filtre='.$Code_filtre, 'lien', 'bouton_modifier_filtre');
        }
        $trans['{bouton_modifier_filtre}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_filtre') : '';
        if ($mf_droits_defaut['filtre__SUPPRIMER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_SUPPRIMER_PREC . get_nom_colonne('bouton_supprimer_filtre') . BOUTON_LIBELLE_SUPPRIMER_SUIV, get_nom_page_courante().'?act=supprimer_filtre&Code_filtre='.$Code_filtre, 'lien', 'bouton_supprimer_filtre');
        }
        $trans['{bouton_supprimer_filtre}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_supprimer_filtre', BOUTON_CLASSE_SUPPRIMER) : '';

        // filtre_Libelle
        if ( $mf_droits_defaut['api_modifier__filtre_Libelle'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_filtre_Libelle') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_filtre_Libelle&Code_filtre='.$Code_filtre, 'lien', 'bouton_modifier_filtre_Libelle');
        }
        $trans['{bouton_modifier_filtre_Libelle}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_filtre_Libelle') : '';

    /* prec_et_suiv */
    if ( $table_filtre->mf_compter()<100 )
    {
        $liste_filtre = $table_filtre->mf_lister_contexte();
        // prec
        $prec_et_suiv = prec_suiv($liste_filtre, $filtre['Code_filtre']);
        $prec=['link'=>'', 'title'=>''];
        $suiv=['link'=>'', 'title'=>''];
        if (isset($prec_et_suiv['prec']['Code_filtre']))
        {
            $prec['link'] = get_nom_page_courante().'?act=apercu_filtre&Code_filtre='.$prec_et_suiv['prec']['Code_filtre'];
            $prec['title'] = htmlspecialchars(get_titre_ligne_table('filtre', $prec_et_suiv['prec']));
        }
        // suiv
        if (isset($prec_et_suiv['suiv']['Code_filtre']))
        {
            $suiv['link'] = get_nom_page_courante().'?act=apercu_filtre&Code_filtre='.$prec_et_suiv['suiv']['Code_filtre'];
            $suiv['title'] = htmlspecialchars(get_titre_ligne_table('filtre', $prec_et_suiv['suiv']));
        }
        $trans['{pager_filtre}'] = get_code_pager($prec, $suiv);
    }
    else
    {
        $trans['{pager_filtre}'] = '';
    }

    /* filtre_Libelle */
        if ( $mf_droits_defaut['api_modifier__filtre_Libelle'] )
            $trans['{filtre_Libelle}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_filtre' => $filtre['Code_filtre']) , 'DB_name' => 'filtre_Libelle' , 'valeur_initiale' => $filtre['filtre_Libelle'] ]);
        else
            $trans['{filtre_Libelle}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_filtre' => $filtre['Code_filtre']) , 'DB_name' => 'filtre_Libelle' , 'valeur_initiale' => $filtre['filtre_Libelle'] ]);

