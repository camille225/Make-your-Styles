<?php

    // Actualisation des droits
    Hook_a_article_commande::hook_actualiser_les_droits_ajouter(mf_Code_commande(), mf_Code_article());
    Hook_a_article_commande::hook_actualiser_les_droits_supprimer(mf_Code_commande(), mf_Code_article());

    $table_a_article_commande = new a_article_commande();

    // liste
        $liste = $table_a_article_commande->mf_lister_contexte();
        $tab = new Tableau($liste, '');
        $tab->desactiver_pagination();
        if (!isset($est_charge['commande']))
        {
            $tab->ajouter_colonne('Code_commande', true, '');
        }
        $tab->ajouter_ref_Colonne_Code('Code_commande');
        if (!isset($est_charge['article']))
        {
            $tab->ajouter_colonne('Code_article', true, '');
        }
        $tab->ajouter_ref_Colonne_Code('Code_article');
        // $tab->modifier_code_action('apercu_a_article_commande');
        if ($mf_droits_defaut['a_article_commande__SUPPRIMER']) {
            $tab->ajouter_colonne_bouton('supprimer_a_article_commande', BOUTON_LIBELLE_SUPPRIMER_PREC . get_nom_colonne('bouton_supprimer_a_article_commande') . BOUTON_LIBELLE_SUPPRIMER_SUIV );
        }
        $trans['{tableau_a_article_commande}']=$tab->generer_code();

    // boutons
        if ($mf_droits_defaut['a_article_commande__AJOUTER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_AJOUTER_PREC . get_nom_colonne('bouton_ajouter_a_article_commande') . BOUTON_LIBELLE_AJOUTER_SUIV , get_nom_page_courante().'?act=ajouter_a_article_commande&Code_commande='.$Code_commande.'&Code_article='.$Code_article.'', 'lien', 'bouton_ajouter_a_article_commande');
        }
        $trans['{bouton_ajouter_a_article_commande}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_ajouter_a_article_commande', BOUTON_CLASSE_AJOUTER) : '';
