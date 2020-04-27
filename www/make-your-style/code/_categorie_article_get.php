<?php declare(strict_types=1);

/** @var array $categorie_article */

    // Actualisation des droits
    Hook_categorie_article::hook_actualiser_les_droits_modifier($categorie_article['Code_categorie_article']);
    Hook_categorie_article::hook_actualiser_les_droits_supprimer($categorie_article['Code_categorie_article']);

    // boutons
        if ($mf_droits_defaut['categorie_article__MODIFIER']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_categorie_article') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante() . '?act=modifier_categorie_article&Code_categorie_article=' . mf_Code_categorie_article() . '&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_categorie_article');
        }
        $trans['{bouton_modifier_categorie_article}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_categorie_article') : '');
        if ($mf_droits_defaut['categorie_article__SUPPRIMER']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_SUPPRIMER_PREC . get_nom_colonne('bouton_supprimer_categorie_article') . BOUTON_LIBELLE_SUPPRIMER_SUIV, get_nom_page_courante() . '?act=supprimer_categorie_article&Code_categorie_article=' . mf_Code_categorie_article() . '&mf_instance=' . get_instance(), 'lien', 'bouton_supprimer_categorie_article');
        }
        $trans['{bouton_supprimer_categorie_article}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_supprimer_categorie_article', BOUTON_CLASSE_SUPPRIMER) : '');

        // categorie_article_Libelle
        if ($mf_droits_defaut['api_modifier__categorie_article_Libelle']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_categorie_article_Libelle') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_categorie_article_Libelle&Code_categorie_article=' . mf_Code_categorie_article() . '&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_categorie_article_Libelle');
        }
        $trans['{bouton_modifier_categorie_article_Libelle}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_categorie_article_Libelle') : '');

    /* prec_et_suiv */
    if ($db->categorie_article()->mf_compter() < 100) {
        $liste_categorie_article = $db->categorie_article()->mf_lister_contexte();
        // prec
        $prec_et_suiv = prec_suiv($liste_categorie_article, $categorie_article['Code_categorie_article']);
        $prec=['link'=>'', 'title'=>''];
        $suiv=['link'=>'', 'title'=>''];
        if (isset($prec_et_suiv['prec']['Code_categorie_article'])) {
            $prec['link'] = get_nom_page_courante().'?act=apercu_categorie_article&Code_categorie_article=' . $prec_et_suiv['prec']['Code_categorie_article'];
            $prec['title'] = htmlspecialchars(get_titre_ligne_table('categorie_article', $prec_et_suiv['prec']));
        }
        // suiv
        if (isset($prec_et_suiv['suiv']['Code_categorie_article'])) {
            $suiv['link'] = get_nom_page_courante().'?act=apercu_categorie_article&Code_categorie_article=' . $prec_et_suiv['suiv']['Code_categorie_article'];
            $suiv['title'] = htmlspecialchars(get_titre_ligne_table('categorie_article', $prec_et_suiv['suiv']));
        }
        $trans['{pager_categorie_article}'] = get_code_pager($prec, $suiv);
    } else {
        $trans['{pager_categorie_article}'] = '';
    }

    /* categorie_article_Libelle */
        if ($mf_droits_defaut['api_modifier__categorie_article_Libelle']) {
            $trans['{categorie_article_Libelle}'] = ajouter_champ_modifiable_interface(['liste_valeurs_cle_table' => ['Code_categorie_article' => $categorie_article['Code_categorie_article']], 'DB_name' => 'categorie_article_Libelle', 'valeur_initiale' => $categorie_article['categorie_article_Libelle']]);
        } else {
            $trans['{categorie_article_Libelle}'] = get_valeur_html_maj_auto_interface(['liste_valeurs_cle_table' => ['Code_categorie_article' => $categorie_article['Code_categorie_article']], 'DB_name' => 'categorie_article_Libelle', 'valeur_initiale' => $categorie_article['categorie_article_Libelle']]);
        }

