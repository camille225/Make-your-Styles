<?php

    // Actualisation des droits
    Hook_article::hook_actualiser_les_droits_ajouter(mf_Code_type_produit());

    $table_article = new article();

    // liste
        $liste = $table_article->mf_lister_contexte();
        $tab = new Tableau($liste, "");
        $tab->desactiver_pagination();
        $tab->ajouter_ref_Colonne_Code("Code_article");
        $tab->set_ligne_selectionnee('Code_article', mf_Code_article());
        $tab->modifier_code_action("apercu_article");
        $tab->ajouter_colonne('article_Libelle', false, '');
        $tab->ajouter_colonne_fichier('article_Photo_Fichier', '');
        $tab->ajouter_colonne('article_Prix', false, '');
        $tab->ajouter_colonne('article_Actif', true, '');
        if (!isset($est_charge['type_produit']))
        {
            $tab->ajouter_colonne('Code_type_produit', true, '');
        }
        $trans['{tableau_article}']=$tab->generer_code();

    // boutons
        if ($mf_droits_defaut['article__AJOUTER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_AJOUTER_PREC . get_nom_colonne('bouton_ajouter_article') . BOUTON_LIBELLE_AJOUTER_SUIV, get_nom_page_courante().'?act=ajouter_article&Code_type_produit='.$Code_type_produit.'', 'lien', 'bouton_ajouter_article');
        }
        $trans['{bouton_ajouter_article}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_ajouter_article', BOUTON_CLASSE_AJOUTER) : '';
        if ($mf_droits_defaut['article__CREER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_AJOUTER_PREC . get_nom_colonne('bouton_creer_article') . BOUTON_LIBELLE_AJOUTER_SUIV, get_nom_page_courante().'?act=creer_article&Code_type_produit='.$Code_type_produit.'', 'lien', 'bouton_creer_article');
        }
        $trans['{bouton_creer_article}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_creer_article', BOUTON_CLASSE_AJOUTER) : '';
