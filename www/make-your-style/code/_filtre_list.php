<?php

    // Actualisation des droits
    Hook_filtre::hook_actualiser_les_droits_ajouter();

    $table_filtre = new filtre();

    // liste
        $liste = $table_filtre->mf_lister_contexte();
        $tab = new Tableau($liste, "");
        $tab->desactiver_pagination();
        $tab->ajouter_ref_Colonne_Code("Code_filtre");
        $tab->set_ligne_selectionnee('Code_filtre', mf_Code_filtre());
        $tab->modifier_code_action("apercu_filtre");
        $tab->ajouter_colonne('filtre_Libelle', false, '');
        $trans['{tableau_filtre}']=$tab->generer_code();

    // boutons
        if ($mf_droits_defaut['filtre__AJOUTER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_AJOUTER_PREC . get_nom_colonne('bouton_ajouter_filtre') . BOUTON_LIBELLE_AJOUTER_SUIV, get_nom_page_courante().'?act=ajouter_filtre', 'lien', 'bouton_ajouter_filtre');
        }
        $trans['{bouton_ajouter_filtre}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_ajouter_filtre', BOUTON_CLASSE_AJOUTER) : '';
        if ($mf_droits_defaut['filtre__CREER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_AJOUTER_PREC . get_nom_colonne('bouton_creer_filtre') . BOUTON_LIBELLE_AJOUTER_SUIV, get_nom_page_courante().'?act=creer_filtre', 'lien', 'bouton_creer_filtre');
        }
        $trans['{bouton_creer_filtre}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_creer_filtre', BOUTON_CLASSE_AJOUTER) : '';
