<?php declare(strict_types=1);

    // Actualisation des droits
    Hook_a_commande_article::hook_actualiser_les_droits_ajouter(mf_Code_commande(), mf_Code_article());
    Hook_a_commande_article::hook_actualiser_les_droits_modifier(mf_Code_commande(), mf_Code_article());
    Hook_a_commande_article::hook_actualiser_les_droits_supprimer(mf_Code_commande(), mf_Code_article());

    // liste
        $liste = $db->a_commande_article()->mf_lister_contexte([OPTION_LIMIT => [0, NB_ELEM_MAX_TABLEAU]]);
        $tab = new Tableau($liste, '');
        $tab->desactiver_pagination();
        if (! isset($est_charge['commande'])) {
            $tab->ajouter_colonne('Code_commande', true, '');
        }
        $tab->ajouter_ref_Colonne_Code('Code_commande');
        if (! isset($est_charge['article'])) {
            $tab->ajouter_colonne('Code_article', true, '');
        }
        $tab->ajouter_ref_Colonne_Code('Code_article');
        $tab->modifier_code_action('apercu_a_commande_article');
        /* debut developpement */
        $tab->ajouter_colonne('a_commande_article_Prix_ligne', false, '');
        $tab->ajouter_colonne('a_commande_article_Quantite', false, '');
        /* debut developpement */
        if ($mf_droits_defaut['a_commande_article__SUPPRIMER']) {
            $tab->ajouter_colonne_bouton('supprimer_a_commande_article', BOUTON_LIBELLE_SUPPRIMER_PREC . get_nom_colonne('bouton_supprimer_a_commande_article') . BOUTON_LIBELLE_SUPPRIMER_SUIV );
        }
        $trans['{tableau_a_commande_article}'] = (count($liste) < NB_ELEM_MAX_TABLEAU ? '' : get_code_alert_warning("Attention, affichage partielle des données (soit " . NB_ELEM_MAX_TABLEAU . " enregistrements)")) . $tab->generer_code();

    // boutons
        if ($mf_droits_defaut['a_commande_article__AJOUTER']) {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_AJOUTER_PREC . get_nom_colonne('bouton_ajouter_a_commande_article') . BOUTON_LIBELLE_AJOUTER_SUIV , get_nom_page_courante().'?act=ajouter_a_commande_article&Code_commande='.$Code_commande.'&Code_article='.$Code_article.'&mf_instance=' . get_instance(), 'lien', 'bouton_ajouter_a_commande_article');
        }
        $trans['{bouton_ajouter_a_commande_article}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_ajouter_a_commande_article', BOUTON_CLASSE_AJOUTER) : '');
