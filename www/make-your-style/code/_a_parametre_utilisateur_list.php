<?php declare(strict_types=1);

    // Actualisation des droits
    Hook_a_parametre_utilisateur::hook_actualiser_les_droits_ajouter(mf_Code_utilisateur(), mf_Code_parametre());
    Hook_a_parametre_utilisateur::hook_actualiser_les_droits_modifier(mf_Code_utilisateur(), mf_Code_parametre());
    Hook_a_parametre_utilisateur::hook_actualiser_les_droits_supprimer(mf_Code_utilisateur(), mf_Code_parametre());

    // liste
        $liste = $db->a_parametre_utilisateur()->mf_lister_contexte([OPTION_LIMIT => [0, NB_ELEM_MAX_TABLEAU]]);
        $tab = new Tableau($liste, '');
        $tab->desactiver_pagination();
        if (! isset($est_charge['utilisateur'])) {
            $tab->ajouter_colonne('Code_utilisateur', true, '');
        }
        $tab->ajouter_ref_Colonne_Code('Code_utilisateur');
        if (! isset($est_charge['parametre'])) {
            $tab->ajouter_colonne('Code_parametre', true, '');
        }
        $tab->ajouter_ref_Colonne_Code('Code_parametre');
        $tab->modifier_code_action('apercu_a_parametre_utilisateur');
        $tab->ajouter_colonne('a_parametre_utilisateur_Valeur', false, '');
        $tab->ajouter_colonne('a_parametre_utilisateur_Actif', false, '');
        if ($mf_droits_defaut['a_parametre_utilisateur__SUPPRIMER']) {
            $tab->ajouter_colonne_bouton('supprimer_a_parametre_utilisateur', BOUTON_LIBELLE_SUPPRIMER_PREC . get_nom_colonne('bouton_supprimer_a_parametre_utilisateur') . BOUTON_LIBELLE_SUPPRIMER_SUIV );
        }
        $trans['{tableau_a_parametre_utilisateur}'] = (count($liste) < NB_ELEM_MAX_TABLEAU ? '' : get_code_alert_warning("Attention, affichage partielle des données (soit " . NB_ELEM_MAX_TABLEAU . " enregistrements)")) . $tab->generer_code();

    // boutons
        if ($mf_droits_defaut['a_parametre_utilisateur__AJOUTER']) {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_AJOUTER_PREC . get_nom_colonne('bouton_ajouter_a_parametre_utilisateur') . BOUTON_LIBELLE_AJOUTER_SUIV , get_nom_page_courante().'?act=ajouter_a_parametre_utilisateur&Code_utilisateur='.$Code_utilisateur.'&Code_parametre='.$Code_parametre.'&mf_instance=' . get_instance(), 'lien', 'bouton_ajouter_a_parametre_utilisateur');
        }
        $trans['{bouton_ajouter_a_parametre_utilisateur}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_ajouter_a_parametre_utilisateur', BOUTON_CLASSE_AJOUTER) : '');
