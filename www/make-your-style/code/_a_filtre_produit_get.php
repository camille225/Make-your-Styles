<?php

    // Actualisation des droits
    Hook_a_filtre_produit::hook_actualiser_les_droits_modifier($a_filtre_produit['Code_filtre'], $a_filtre_produit['Code_article']);
    Hook_a_filtre_produit::hook_actualiser_les_droits_supprimer($a_filtre_produit['Code_filtre'], $a_filtre_produit['Code_article']);

    // boutons
        if ($mf_droits_defaut['a_filtre_produit__MODIFIER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_a_filtre_produit') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_a_filtre_produit&Code_filtre='.$Code_filtre.'&Code_article='.$Code_article.'', 'lien', 'bouton_modifier_a_filtre_produit');
        }
        $trans['{bouton_modifier_a_filtre_produit}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_a_filtre_produit') : '';
        if ($mf_droits_defaut['a_filtre_produit__SUPPRIMER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_SUPPRIMER_PREC . get_nom_colonne('bouton_supprimer_a_filtre_produit') . BOUTON_LIBELLE_SUPPRIMER_SUIV, get_nom_page_courante().'?act=supprimer_a_filtre_produit&Code_filtre='.$Code_filtre.'&Code_article='.$Code_article.'', 'lien', 'bouton_supprimer_a_filtre_produit');
        }
        $trans['{bouton_supprimer_a_filtre_produit}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_supprimer_a_filtre_produit', BOUTON_CLASSE_SUPPRIMER) : '';

        // a_filtre_produit_Actif
        if ( $mf_droits_defaut['api_modifier__a_filtre_produit_Actif'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_a_filtre_produit_Actif') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_a_filtre_produit_Actif&Code_filtre='.$Code_filtre.'&Code_article='.$Code_article.'', 'lien', 'bouton_modifier_a_filtre_produit_Actif');
        }
        $trans['{bouton_modifier_a_filtre_produit_Actif}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_a_filtre_produit_Actif') : '';

    /* prec_et_suiv */
    if ( $table_a_filtre_produit->mf_compter((isset($est_charge['filtre']) ? $mf_contexte['Code_filtre'] : 0), (isset($est_charge['article']) ? $mf_contexte['Code_article'] : 0))<100 )
    {
        $liste_a_filtre_produit = $table_a_filtre_produit->mf_lister_contexte();
        // prec
        $prec_et_suiv = prec_suiv($liste_a_filtre_produit, $a_filtre_produit['Code_filtre'].'-'.$a_filtre_produit['Code_article']);
        $prec=['link'=>'', 'title'=>''];
        $suiv=['link'=>'', 'title'=>''];
        if (isset($prec_et_suiv['prec']['Code_filtre']))
        {
            $prec['link'] = get_nom_page_courante().'?act=apercu_a_filtre_produit&Code_filtre='.$prec_et_suiv['prec']['Code_filtre'].'&Code_article='.$prec_et_suiv['prec']['Code_article'].'';
            $prec['title'] = htmlspecialchars(get_titre_ligne_table('a_filtre_produit', $prec_et_suiv['prec']));
        }
        // suiv
        if (isset($prec_et_suiv['suiv']['Code_filtre']))
        {
            $suiv['link'] = get_nom_page_courante().'?act=apercu_a_filtre_produit&Code_filtre='.$prec_et_suiv['suiv']['Code_filtre'].'&Code_article='.$prec_et_suiv['suiv']['Code_article'].'';
            $suiv['title'] = htmlspecialchars(get_titre_ligne_table('a_filtre_produit', $prec_et_suiv['suiv']));
        }
        $trans['{pager_a_filtre_produit}'] = get_code_pager($prec, $suiv);
    }
    else
    {
        $trans['{pager_a_filtre_produit}'] = '';
    }

    /* Code_filtre */
        $trans['{Code_filtre}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_filtre'=>$a_filtre_produit['Code_filtre'], 'Code_article'=>$a_filtre_produit['Code_article']) , 'DB_name' => 'Code_filtre' , 'valeur_initiale' => $a_filtre_produit['Code_filtre'] ]);

    /* Code_article */
        $trans['{Code_article}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_filtre'=>$a_filtre_produit['Code_filtre'], 'Code_article'=>$a_filtre_produit['Code_article']) , 'DB_name' => 'Code_article' , 'valeur_initiale' => $a_filtre_produit['Code_article'] ]);

    /* a_filtre_produit_Actif */
        if ( $mf_droits_defaut['api_modifier__a_filtre_produit_Actif'] )
            $trans['{a_filtre_produit_Actif}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_filtre'=>$a_filtre_produit['Code_filtre'], 'Code_article'=>$a_filtre_produit['Code_article']) , 'DB_name' => 'a_filtre_produit_Actif' , 'valeur_initiale' => $a_filtre_produit['a_filtre_produit_Actif'] ]);
        else
            $trans['{a_filtre_produit_Actif}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_filtre'=>$a_filtre_produit['Code_filtre'], 'Code_article'=>$a_filtre_produit['Code_article']) , 'DB_name' => 'a_filtre_produit_Actif' , 'valeur_initiale' => $a_filtre_produit['a_filtre_produit_Actif'] ]);

