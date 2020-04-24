<?php declare(strict_types=1);

    // Actualisation des droits
    Hook_article::hook_actualiser_les_droits_ajouter(mf_Code_sous_categorie_article());

    // liste
        $liste = $db->article()->mf_lister_contexte(null, [OPTION_LIMIT => [0, NB_ELEM_MAX_TABLEAU]]);
        $tab = new Tableau($liste, "");
        $tab->desactiver_pagination();
        $tab->ajouter_ref_Colonne_Code("Code_article");
        $tab->set_ligne_selectionnee('Code_article', mf_Code_article());
        $tab->modifier_code_action("apercu_article");
        $tab->ajouter_colonne('article_Libelle', false, '');
        // $tab->ajouter_colonne('article_Description', false, '');
        $tab->ajouter_colonne('article_Saison_Type', true, '');
        $tab->ajouter_colonne('article_Nom_fournisseur', false, '');
        $tab->ajouter_colonne('article_Url', false, '');
        $tab->ajouter_colonne('article_Reference', false, '');
        $tab->ajouter_colonne('article_Couleur', false, 'color');
        $tab->ajouter_colonne('article_Code_couleur_svg', false, '');
        $tab->ajouter_colonne('article_Taille_Pays_Type', true, '');
        $tab->ajouter_colonne('article_Taille', false, '');
        $tab->ajouter_colonne('article_Matiere', false, '');
        // $tab->ajouter_colonne_fichier('article_Photo_Fichier', '');
        $tab->ajouter_colonne('article_Prix', false, '');
        $tab->ajouter_colonne('article_Actif', true, '');
        if (! isset($est_charge['sous_categorie_article'])) {
            $tab->ajouter_colonne('Code_sous_categorie_article', true, '');
        }
        $trans['{tableau_article}'] = (count($liste) < NB_ELEM_MAX_TABLEAU ? '' : get_code_alert_warning("Attention, affichage partielle des données (soit " . NB_ELEM_MAX_TABLEAU . " enregistrements)")) . $tab->generer_code();

    // boutons
        if ($mf_droits_defaut['article__AJOUTER']) {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_AJOUTER_PREC . get_nom_colonne('bouton_ajouter_article') . BOUTON_LIBELLE_AJOUTER_SUIV, get_nom_page_courante() . '?act=ajouter_article&Code_sous_categorie_article=' . mf_Code_sous_categorie_article() . '&mf_instance=' . get_instance(), 'lien', 'bouton_ajouter_article');
        }
        $trans['{bouton_ajouter_article}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_ajouter_article', BOUTON_CLASSE_AJOUTER) : '');
        if ($mf_droits_defaut['article__CREER']) {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_AJOUTER_PREC . get_nom_colonne('bouton_creer_article') . BOUTON_LIBELLE_AJOUTER_SUIV, get_nom_page_courante() . '?act=creer_article&Code_sous_categorie_article=' . mf_Code_sous_categorie_article() . '&mf_instance=' . get_instance(), 'lien', 'bouton_creer_article');
        }
        $trans['{bouton_creer_article}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_creer_article', BOUTON_CLASSE_AJOUTER) : '');
