<?php

    // Actualisation des droits
    Hook_type_produit::hook_actualiser_les_droits_ajouter();

    $table_type_produit = new type_produit();

    // liste
        $liste = $table_type_produit->mf_lister_contexte();
        $tab = new Tableau($liste, "");
        $tab->desactiver_pagination();
        $tab->ajouter_ref_Colonne_Code("Code_type_produit");
        $tab->set_ligne_selectionnee('Code_type_produit', mf_Code_type_produit());
        $tab->modifier_code_action("apercu_type_produit");
        $tab->ajouter_colonne('type_produit_Libelle', false, '');
        $trans['{tableau_type_produit}']=$tab->generer_code();

    // boutons
        if ($mf_droits_defaut['type_produit__AJOUTER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_AJOUTER_PREC . get_nom_colonne('bouton_ajouter_type_produit') . BOUTON_LIBELLE_AJOUTER_SUIV, get_nom_page_courante().'?act=ajouter_type_produit', 'lien', 'bouton_ajouter_type_produit');
        }
        $trans['{bouton_ajouter_type_produit}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_ajouter_type_produit', BOUTON_CLASSE_AJOUTER) : '';
        if ($mf_droits_defaut['type_produit__CREER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_AJOUTER_PREC . get_nom_colonne('bouton_creer_type_produit') . BOUTON_LIBELLE_AJOUTER_SUIV, get_nom_page_courante().'?act=creer_type_produit', 'lien', 'bouton_creer_type_produit');
        }
        $trans['{bouton_creer_type_produit}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_creer_type_produit', BOUTON_CLASSE_AJOUTER) : '';
