<?php declare(strict_types=1);

    // Actualisation des droits
    Hook_utilisateur::hook_actualiser_les_droits_ajouter();

    // liste
        $liste = $db->utilisateur()->mf_lister_contexte(null, [OPTION_LIMIT => [0, NB_ELEM_MAX_TABLEAU]]);
        $tab = new Tableau($liste, "");
        $tab->desactiver_pagination();
        $tab->ajouter_ref_Colonne_Code("Code_utilisateur");
        $tab->set_ligne_selectionnee('Code_utilisateur', mf_Code_utilisateur());
        $tab->modifier_code_action("apercu_utilisateur");
        /* debut developpement */
        $tab->ajouter_colonne('utilisateur_Prenom', false, '');
        $tab->ajouter_colonne('utilisateur_Nom', false, '');
        $tab->ajouter_colonne('utilisateur_Civilite_Type', true, '');
        $tab->ajouter_colonne('utilisateur_Identifiant', false, '');
        $tab->ajouter_colonne('utilisateur_Email', false, '');
        $tab->ajouter_colonne('utilisateur_Adresse_1', false, '');
        $tab->ajouter_colonne('utilisateur_Adresse_2', false, '');
        $tab->ajouter_colonne('utilisateur_Ville', false, '');
        $tab->ajouter_colonne('utilisateur_Code_postal', false, '');
//        $tab->ajouter_colonne('utilisateur_Date_naissance', false, 'date');
        $tab->ajouter_colonne('utilisateur_Administrateur', true, '');
        $tab->ajouter_colonne('utilisateur_Fournisseur', true, '');
        $tab->ajouter_colonne('utilisateur_Accepte_mail_publicitaire', true, '');
        /* fin developpement */
        $trans['{tableau_utilisateur}'] = (count($liste) < NB_ELEM_MAX_TABLEAU ? '' : get_code_alert_warning("Attention, affichage partielle des données (soit " . NB_ELEM_MAX_TABLEAU . " enregistrements)")) . $tab->generer_code();

    // boutons
        if ($mf_droits_defaut['utilisateur__AJOUTER']) {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_AJOUTER_PREC . get_nom_colonne('bouton_ajouter_utilisateur') . BOUTON_LIBELLE_AJOUTER_SUIV, get_nom_page_courante() . '?act=ajouter_utilisateur&mf_instance=' . get_instance(), 'lien', 'bouton_ajouter_utilisateur');
        }
        $trans['{bouton_ajouter_utilisateur}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_ajouter_utilisateur', BOUTON_CLASSE_AJOUTER) : '');
