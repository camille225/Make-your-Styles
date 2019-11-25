<?php

    // Actualisation des droits
    Hook_a_filtre_produit::hook_actualiser_les_droits_ajouter(mf_Code_filtre(), mf_Code_article());
    Hook_a_filtre_produit::hook_actualiser_les_droits_modifier(mf_Code_filtre(), mf_Code_article());
    Hook_a_filtre_produit::hook_actualiser_les_droits_supprimer(mf_Code_filtre(), mf_Code_article());

    $table_a_filtre_produit = new a_filtre_produit();

    // liste
        $liste = $table_a_filtre_produit->mf_lister_contexte();
        $tab = new Tableau($liste, '');
        $tab->desactiver_pagination();
        if (!isset($est_charge['filtre']))
        {
            $tab->ajouter_colonne('Code_filtre', true, '');
        }
        $tab->ajouter_ref_Colonne_Code('Code_filtre');
        if (!isset($est_charge['article']))
        {
            $tab->ajouter_colonne('Code_article', true, '');
        }
        $tab->ajouter_ref_Colonne_Code('Code_article');
        $tab->modifier_code_action('apercu_a_filtre_produit');
        $tab->ajouter_colonne('a_filtre_produit_Actif', false, '');
        if ($mf_droits_defaut['a_filtre_produit__SUPPRIMER']) {
            $tab->ajouter_colonne_bouton('supprimer_a_filtre_produit', BOUTON_LIBELLE_SUPPRIMER_PREC . get_nom_colonne('bouton_supprimer_a_filtre_produit') . BOUTON_LIBELLE_SUPPRIMER_SUIV );
        }
        $trans['{tableau_a_filtre_produit}']=$tab->generer_code();

    // boutons
        if ($mf_droits_defaut['a_filtre_produit__AJOUTER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_AJOUTER_PREC . get_nom_colonne('bouton_ajouter_a_filtre_produit') . BOUTON_LIBELLE_AJOUTER_SUIV , get_nom_page_courante().'?act=ajouter_a_filtre_produit&Code_filtre='.$Code_filtre.'&Code_article='.$Code_article.'', 'lien', 'bouton_ajouter_a_filtre_produit');
        }
        $trans['{bouton_ajouter_a_filtre_produit}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_ajouter_a_filtre_produit', BOUTON_CLASSE_AJOUTER) : '';
