<?php declare(strict_types=1);

/** @var array $conseil */

    // Actualisation des droits
    Hook_conseil::hook_actualiser_les_droits_modifier($conseil['Code_conseil']);
    Hook_conseil::hook_actualiser_les_droits_supprimer($conseil['Code_conseil']);

    // boutons
        if ($mf_droits_defaut['conseil__MODIFIER']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_conseil') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante() . '?act=modifier_conseil&Code_conseil=' . mf_Code_conseil() . '&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_conseil');
        }
        $trans['{bouton_modifier_conseil}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_conseil') : '');
        if ($mf_droits_defaut['conseil__SUPPRIMER']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_SUPPRIMER_PREC . get_nom_colonne('bouton_supprimer_conseil') . BOUTON_LIBELLE_SUPPRIMER_SUIV, get_nom_page_courante() . '?act=supprimer_conseil&Code_conseil=' . mf_Code_conseil() . '&mf_instance=' . get_instance(), 'lien', 'bouton_supprimer_conseil');
        }
        $trans['{bouton_supprimer_conseil}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_supprimer_conseil', BOUTON_CLASSE_SUPPRIMER) : '');

        // conseil_Libelle
        if ($mf_droits_defaut['api_modifier__conseil_Libelle']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_conseil_Libelle') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_conseil_Libelle&Code_conseil=' . mf_Code_conseil() . '&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_conseil_Libelle');
        }
        $trans['{bouton_modifier_conseil_Libelle}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_conseil_Libelle') : '');

        // conseil_Description
        if ($mf_droits_defaut['api_modifier__conseil_Description']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_conseil_Description') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_conseil_Description&Code_conseil=' . mf_Code_conseil() . '&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_conseil_Description');
        }
        $trans['{bouton_modifier_conseil_Description}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_conseil_Description') : '');

        // conseil_Actif
        if ($mf_droits_defaut['api_modifier__conseil_Actif']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_conseil_Actif') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_conseil_Actif&Code_conseil=' . mf_Code_conseil() . '&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_conseil_Actif');
        }
        $trans['{bouton_modifier_conseil_Actif}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_conseil_Actif') : '');

    /* prec_et_suiv */
    if ($db->conseil()->mf_compter() < 100) {
        $liste_conseil = $db->conseil()->mf_lister_contexte();
        // prec
        $prec_et_suiv = prec_suiv($liste_conseil, $conseil['Code_conseil']);
        $prec=['link'=>'', 'title'=>''];
        $suiv=['link'=>'', 'title'=>''];
        if (isset($prec_et_suiv['prec']['Code_conseil'])) {
            $prec['link'] = get_nom_page_courante().'?act=apercu_conseil&Code_conseil=' . $prec_et_suiv['prec']['Code_conseil'];
            $prec['title'] = htmlspecialchars(get_titre_ligne_table('conseil', $prec_et_suiv['prec']));
        }
        // suiv
        if (isset($prec_et_suiv['suiv']['Code_conseil'])) {
            $suiv['link'] = get_nom_page_courante().'?act=apercu_conseil&Code_conseil=' . $prec_et_suiv['suiv']['Code_conseil'];
            $suiv['title'] = htmlspecialchars(get_titre_ligne_table('conseil', $prec_et_suiv['suiv']));
        }
        $trans['{pager_conseil}'] = get_code_pager($prec, $suiv);
    } else {
        $trans['{pager_conseil}'] = '';
    }

    /* conseil_Libelle */
        if ($mf_droits_defaut['api_modifier__conseil_Libelle']) {
            $trans['{conseil_Libelle}'] = ajouter_champ_modifiable_interface(['liste_valeurs_cle_table' => ['Code_conseil' => $conseil['Code_conseil']], 'DB_name' => 'conseil_Libelle', 'valeur_initiale' => $conseil['conseil_Libelle']]);
        } else {
            $trans['{conseil_Libelle}'] = get_valeur_html_maj_auto_interface(['liste_valeurs_cle_table' => ['Code_conseil' => $conseil['Code_conseil']], 'DB_name' => 'conseil_Libelle', 'valeur_initiale' => $conseil['conseil_Libelle']]);
        }

    /* conseil_Description */
        if ($mf_droits_defaut['api_modifier__conseil_Description']) {
            $trans['{conseil_Description}'] = ajouter_champ_modifiable_interface(['liste_valeurs_cle_table' => ['Code_conseil' => $conseil['Code_conseil']], 'DB_name' => 'conseil_Description', 'valeur_initiale' => $conseil['conseil_Description']]);
        } else {
            $trans['{conseil_Description}'] = get_valeur_html_maj_auto_interface(['liste_valeurs_cle_table' => ['Code_conseil' => $conseil['Code_conseil']], 'DB_name' => 'conseil_Description', 'valeur_initiale' => $conseil['conseil_Description'], 'class' => 'text' ]);
        }

    /* conseil_Actif */
        if ($mf_droits_defaut['api_modifier__conseil_Actif']) {
            $trans['{conseil_Actif}'] = ajouter_champ_modifiable_interface(['liste_valeurs_cle_table' => ['Code_conseil' => $conseil['Code_conseil']], 'DB_name' => 'conseil_Actif', 'valeur_initiale' => $conseil['conseil_Actif'], 'class' => 'button']);
        } else {
            $trans['{conseil_Actif}'] = get_valeur_html_maj_auto_interface(['liste_valeurs_cle_table' => ['Code_conseil' => $conseil['Code_conseil']], 'DB_name' => 'conseil_Actif', 'valeur_initiale' => $conseil['conseil_Actif']]);
        }

