<?php declare(strict_types=1);

    // Actualisation des droits
    Hook_commande::hook_actualiser_les_droits_ajouter(mf_Code_utilisateur());

    // liste
        $liste = $db->commande()->mf_lister_contexte(null, [OPTION_LIMIT => [0, NB_ELEM_MAX_TABLEAU]]);
        $tab = new Tableau($liste, "");
        $tab->desactiver_pagination();
        $tab->ajouter_ref_Colonne_Code("Code_commande");
        $tab->set_ligne_selectionnee('Code_commande', mf_Code_commande());
        $tab->modifier_code_action("apercu_commande");
        $tab->ajouter_colonne('commande_Prix_total', false, '');
        $tab->ajouter_colonne('commande_Date_livraison', false, 'date');
        $tab->ajouter_colonne('commande_Date_creation', false, 'date');
        if (! isset($est_charge['utilisateur'])) {
            $tab->ajouter_colonne('Code_utilisateur', true, '');
        }
        $trans['{tableau_commande}'] = (count($liste) < NB_ELEM_MAX_TABLEAU ? '' : get_code_alert_warning("Attention, affichage partielle des données (soit " . NB_ELEM_MAX_TABLEAU . " enregistrements)")) . $tab->generer_code();

    // boutons
        if ($mf_droits_defaut['commande__AJOUTER']) {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_AJOUTER_PREC . get_nom_colonne('bouton_ajouter_commande') . BOUTON_LIBELLE_AJOUTER_SUIV, get_nom_page_courante() . '?act=ajouter_commande&Code_utilisateur=' . mf_Code_utilisateur() . '&mf_instance=' . get_instance(), 'lien', 'bouton_ajouter_commande');
        }
        $trans['{bouton_ajouter_commande}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_ajouter_commande', BOUTON_CLASSE_AJOUTER) : '');
        if ($mf_droits_defaut['commande__CREER']) {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_AJOUTER_PREC . get_nom_colonne('bouton_creer_commande') . BOUTON_LIBELLE_AJOUTER_SUIV, get_nom_page_courante() . '?act=creer_commande&Code_utilisateur=' . mf_Code_utilisateur() . '&mf_instance=' . get_instance(), 'lien', 'bouton_creer_commande');
        }
        $trans['{bouton_creer_commande}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_creer_commande', BOUTON_CLASSE_AJOUTER) : '');
