<?php declare(strict_types=1);

    // Actualisation des droits
    Hook_conseil::hook_actualiser_les_droits_ajouter();

    // liste
        $liste = $db->conseil()->mf_lister_contexte(null, [OPTION_LIMIT => [0, NB_ELEM_MAX_TABLEAU]]);
        $tab = new Tableau($liste, "");
        $tab->desactiver_pagination();
        $tab->ajouter_ref_Colonne_Code("Code_conseil");
        $tab->set_ligne_selectionnee('Code_conseil', mf_Code_conseil());
        $tab->modifier_code_action("apercu_conseil");
        $tab->ajouter_colonne('conseil_Libelle', false, '');
        // $tab->ajouter_colonne('conseil_Description', false, '');
        $tab->ajouter_colonne('conseil_Actif', true, '');
        $trans['{tableau_conseil}'] = (count($liste) < NB_ELEM_MAX_TABLEAU ? '' : get_code_alert_warning("Attention, affichage partielle des données (soit " . NB_ELEM_MAX_TABLEAU . " enregistrements)")) . $tab->generer_code();

    // boutons
        if ($mf_droits_defaut['conseil__AJOUTER']) {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_AJOUTER_PREC . get_nom_colonne('bouton_ajouter_conseil') . BOUTON_LIBELLE_AJOUTER_SUIV, get_nom_page_courante() . '?act=ajouter_conseil&mf_instance=' . get_instance(), 'lien', 'bouton_ajouter_conseil');
        }
        $trans['{bouton_ajouter_conseil}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_ajouter_conseil', BOUTON_CLASSE_AJOUTER) : '');
        if ($mf_droits_defaut['conseil__CREER']) {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_AJOUTER_PREC . get_nom_colonne('bouton_creer_conseil') . BOUTON_LIBELLE_AJOUTER_SUIV, get_nom_page_courante() . '?act=creer_conseil&mf_instance=' . get_instance(), 'lien', 'bouton_creer_conseil');
        }
        $trans['{bouton_creer_conseil}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_creer_conseil', BOUTON_CLASSE_AJOUTER) : '');
