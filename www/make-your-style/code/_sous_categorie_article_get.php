<?php declare(strict_types=1);

/** @var array $sous_categorie_article */

    // Actualisation des droits
    Hook_sous_categorie_article::hook_actualiser_les_droits_modifier($sous_categorie_article['Code_sous_categorie_article']);
    Hook_sous_categorie_article::hook_actualiser_les_droits_supprimer($sous_categorie_article['Code_sous_categorie_article']);

    // boutons
        if ($mf_droits_defaut['sous_categorie_article__MODIFIER']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_sous_categorie_article') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante() . '?act=modifier_sous_categorie_article&Code_sous_categorie_article=' . mf_Code_sous_categorie_article() . '&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_sous_categorie_article');
        }
        $trans['{bouton_modifier_sous_categorie_article}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_sous_categorie_article') : '');
        if ($mf_droits_defaut['sous_categorie_article__SUPPRIMER']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_SUPPRIMER_PREC . get_nom_colonne('bouton_supprimer_sous_categorie_article') . BOUTON_LIBELLE_SUPPRIMER_SUIV, get_nom_page_courante() . '?act=supprimer_sous_categorie_article&Code_sous_categorie_article=' . mf_Code_sous_categorie_article() . '&mf_instance=' . get_instance(), 'lien', 'bouton_supprimer_sous_categorie_article');
        }
        $trans['{bouton_supprimer_sous_categorie_article}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_supprimer_sous_categorie_article', BOUTON_CLASSE_SUPPRIMER) : '');

        // sous_categorie_article_Libelle
        if ($mf_droits_defaut['api_modifier__sous_categorie_article_Libelle']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_sous_categorie_article_Libelle') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_sous_categorie_article_Libelle&Code_sous_categorie_article=' . mf_Code_sous_categorie_article() . '&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_sous_categorie_article_Libelle');
        }
        $trans['{bouton_modifier_sous_categorie_article_Libelle}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_sous_categorie_article_Libelle') : '');

        // Code_categorie_article
        if ($mf_droits_defaut['api_modifier_ref__sous_categorie_article__Code_categorie_article']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_sous_categorie_article__Code_categorie_article') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_sous_categorie_article__Code_categorie_article&Code_sous_categorie_article=' . mf_Code_sous_categorie_article() . '&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_sous_categorie_article__Code_categorie_article');
        }
        $trans['{bouton_modifier_sous_categorie_article__Code_categorie_article}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_sous_categorie_article__Code_categorie_article') : '');

    /* prec_et_suiv */
    if ($db->sous_categorie_article()->mf_compter((isset($est_charge['categorie_article']) ? $mf_contexte['Code_categorie_article'] : 0)) < 100) {
        $liste_sous_categorie_article = $db->sous_categorie_article()->mf_lister_contexte();
        // prec
        $prec_et_suiv = prec_suiv($liste_sous_categorie_article, $sous_categorie_article['Code_sous_categorie_article']);
        $prec=['link'=>'', 'title'=>''];
        $suiv=['link'=>'', 'title'=>''];
        if (isset($prec_et_suiv['prec']['Code_sous_categorie_article'])) {
            $prec['link'] = get_nom_page_courante().'?act=apercu_sous_categorie_article&Code_sous_categorie_article=' . $prec_et_suiv['prec']['Code_sous_categorie_article'];
            $prec['title'] = htmlspecialchars(get_titre_ligne_table('sous_categorie_article', $prec_et_suiv['prec']));
        }
        // suiv
        if (isset($prec_et_suiv['suiv']['Code_sous_categorie_article'])) {
            $suiv['link'] = get_nom_page_courante().'?act=apercu_sous_categorie_article&Code_sous_categorie_article=' . $prec_et_suiv['suiv']['Code_sous_categorie_article'];
            $suiv['title'] = htmlspecialchars(get_titre_ligne_table('sous_categorie_article', $prec_et_suiv['suiv']));
        }
        $trans['{pager_sous_categorie_article}'] = get_code_pager($prec, $suiv);
    } else {
        $trans['{pager_sous_categorie_article}'] = '';
    }

    /* sous_categorie_article_Libelle */
        if ($mf_droits_defaut['api_modifier__sous_categorie_article_Libelle']) {
            $trans['{sous_categorie_article_Libelle}'] = ajouter_champ_modifiable_interface(['liste_valeurs_cle_table' => ['Code_sous_categorie_article' => $sous_categorie_article['Code_sous_categorie_article']], 'DB_name' => 'sous_categorie_article_Libelle', 'valeur_initiale' => $sous_categorie_article['sous_categorie_article_Libelle']]);
        } else {
            $trans['{sous_categorie_article_Libelle}'] = get_valeur_html_maj_auto_interface(['liste_valeurs_cle_table' => ['Code_sous_categorie_article' => $sous_categorie_article['Code_sous_categorie_article']], 'DB_name' => 'sous_categorie_article_Libelle', 'valeur_initiale' => $sous_categorie_article['sous_categorie_article_Libelle']]);
        }

    /* Code_categorie_article */
        if ($mf_droits_defaut['api_modifier_ref__sous_categorie_article__Code_categorie_article']) {
            $trans['{Code_categorie_article}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => ['Code_sous_categorie_article' => $sous_categorie_article['Code_sous_categorie_article']], 'DB_name' => 'Code_categorie_article' , 'valeur_initiale' => $sous_categorie_article['Code_categorie_article'] , 'nom_table' => 'sous_categorie_article' ]);
        } else {
            $trans['{Code_categorie_article}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => ['Code_sous_categorie_article' => $sous_categorie_article['Code_sous_categorie_article']], 'DB_name' => 'Code_categorie_article' , 'valeur_initiale' => $sous_categorie_article['Code_categorie_article'] , 'nom_table' => 'sous_categorie_article' ]);
        }

/* debut developpement */
include __DIR__ . '/_article_list.php';
