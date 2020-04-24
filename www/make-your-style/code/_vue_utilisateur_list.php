<?php declare(strict_types=1);

    // Actualisation des droits
    Hook_vue_utilisateur::hook_actualiser_les_droits_ajouter();

    // liste
        $liste = $db->vue_utilisateur()->mf_lister_contexte(null, [OPTION_LIMIT => [0, NB_ELEM_MAX_TABLEAU]]);
        $tab = new Tableau($liste, "");
        $tab->desactiver_pagination();
        $tab->ajouter_ref_Colonne_Code("Code_vue_utilisateur");
        $tab->set_ligne_selectionnee('Code_vue_utilisateur', mf_Code_vue_utilisateur());
        $tab->modifier_code_action("apercu_vue_utilisateur");
        $tab->ajouter_colonne('vue_utilisateur_Recherche', false, '');
        $tab->ajouter_colonne('vue_utilisateur_Filtre_Saison_Type', true, '');
        $tab->ajouter_colonne('vue_utilisateur_Filtre_Couleur', false, 'color');
        $tab->ajouter_colonne('vue_utilisateur_Filtre_Taille_Pays_Type', true, '');
        $tab->ajouter_colonne('vue_utilisateur_Filtre_Taille_Max', false, '');
        $tab->ajouter_colonne('vue_utilisateur_Filtre_Taille_Min', false, '');
        $trans['{tableau_vue_utilisateur}'] = (count($liste) < NB_ELEM_MAX_TABLEAU ? '' : get_code_alert_warning("Attention, affichage partielle des données (soit " . NB_ELEM_MAX_TABLEAU . " enregistrements)")) . $tab->generer_code();

    // boutons
        if ($mf_droits_defaut['vue_utilisateur__AJOUTER']) {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_AJOUTER_PREC . get_nom_colonne('bouton_ajouter_vue_utilisateur') . BOUTON_LIBELLE_AJOUTER_SUIV, get_nom_page_courante() . '?act=ajouter_vue_utilisateur&mf_instance=' . get_instance(), 'lien', 'bouton_ajouter_vue_utilisateur');
        }
        $trans['{bouton_ajouter_vue_utilisateur}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_ajouter_vue_utilisateur', BOUTON_CLASSE_AJOUTER) : '');
        if ($mf_droits_defaut['vue_utilisateur__CREER']) {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_AJOUTER_PREC . get_nom_colonne('bouton_creer_vue_utilisateur') . BOUTON_LIBELLE_AJOUTER_SUIV, get_nom_page_courante() . '?act=creer_vue_utilisateur&mf_instance=' . get_instance(), 'lien', 'bouton_creer_vue_utilisateur');
        }
        $trans['{bouton_creer_vue_utilisateur}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_creer_vue_utilisateur', BOUTON_CLASSE_AJOUTER) : '');
