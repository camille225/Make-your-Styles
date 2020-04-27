<?php declare(strict_types=1);

    // Actualisation des droits
    Hook_categorie_article::hook_actualiser_les_droits_ajouter();

    // liste
        $liste = $db->categorie_article()->mf_lister_contexte(null, [OPTION_LIMIT => [0, NB_ELEM_MAX_TABLEAU]]);
        $tab = new Tableau($liste, "");
        $tab->desactiver_pagination();
        $tab->ajouter_ref_Colonne_Code("Code_categorie_article");
        $tab->set_ligne_selectionnee('Code_categorie_article', mf_Code_categorie_article());
        $tab->modifier_code_action("apercu_categorie_article");
        $tab->ajouter_colonne('categorie_article_Libelle', false, '');
        $trans['{tableau_categorie_article}'] = (count($liste) < NB_ELEM_MAX_TABLEAU ? '' : get_code_alert_warning("Attention, affichage partielle des données (soit " . NB_ELEM_MAX_TABLEAU . " enregistrements)")) . $tab->generer_code();

    // boutons
        if ($mf_droits_defaut['categorie_article__AJOUTER']) {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_AJOUTER_PREC . get_nom_colonne('bouton_ajouter_categorie_article') . BOUTON_LIBELLE_AJOUTER_SUIV, get_nom_page_courante() . '?act=ajouter_categorie_article&mf_instance=' . get_instance(), 'lien', 'bouton_ajouter_categorie_article');
        }
        $trans['{bouton_ajouter_categorie_article}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_ajouter_categorie_article', BOUTON_CLASSE_AJOUTER) : '');
        if ($mf_droits_defaut['categorie_article__CREER']) {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_AJOUTER_PREC . get_nom_colonne('bouton_creer_categorie_article') . BOUTON_LIBELLE_AJOUTER_SUIV, get_nom_page_courante() . '?act=creer_categorie_article&mf_instance=' . get_instance(), 'lien', 'bouton_creer_categorie_article');
        }
        $trans['{bouton_creer_categorie_article}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_creer_categorie_article', BOUTON_CLASSE_AJOUTER) : '');
