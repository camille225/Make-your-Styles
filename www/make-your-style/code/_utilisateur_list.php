<?php

    // Actualisation des droits
    Hook_utilisateur::hook_actualiser_les_droits_ajouter();

    $table_utilisateur = new utilisateur();

    // liste
        $liste = $table_utilisateur->mf_lister_contexte();
        $tab = new Tableau($liste, "");
        $tab->desactiver_pagination();
        $tab->ajouter_ref_Colonne_Code("Code_utilisateur");
        $tab->set_ligne_selectionnee('Code_utilisateur', mf_Code_utilisateur());
        $tab->modifier_code_action("apercu_utilisateur");
        $tab->ajouter_colonne('utilisateur_Identifiant', false, '');
        $tab->ajouter_colonne('utilisateur_Email', false, '');
        $tab->ajouter_colonne('utilisateur_Administrateur', true, '');
        $tab->ajouter_colonne('utilisateur_Developpeur', true, '');
        $trans['{tableau_utilisateur}']=$tab->generer_code();

    // boutons
        if ($mf_droits_defaut['utilisateur__AJOUTER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_AJOUTER_PREC . get_nom_colonne('bouton_ajouter_utilisateur') . BOUTON_LIBELLE_AJOUTER_SUIV, get_nom_page_courante().'?act=ajouter_utilisateur', 'lien', 'bouton_ajouter_utilisateur');
        }
        $trans['{bouton_ajouter_utilisateur}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_ajouter_utilisateur', BOUTON_CLASSE_AJOUTER) : '';
