<?php declare(strict_types=1);

/** @var array $a_commande_article */

    // Actualisation des droits
    Hook_a_commande_article::hook_actualiser_les_droits_modifier($a_commande_article['Code_commande'], $a_commande_article['Code_article']);
    Hook_a_commande_article::hook_actualiser_les_droits_supprimer($a_commande_article['Code_commande'], $a_commande_article['Code_article']);

    // boutons
        if ($mf_droits_defaut['a_commande_article__MODIFIER']) {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_a_commande_article') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_a_commande_article&Code_commande='.$Code_commande.'&Code_article='.$Code_article.'&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_a_commande_article');
        }
        $trans['{bouton_modifier_a_commande_article}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_a_commande_article') : '');
        if ($mf_droits_defaut['a_commande_article__SUPPRIMER']) {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_SUPPRIMER_PREC . get_nom_colonne('bouton_supprimer_a_commande_article') . BOUTON_LIBELLE_SUPPRIMER_SUIV, get_nom_page_courante().'?act=supprimer_a_commande_article&Code_commande='.$Code_commande.'&Code_article='.$Code_article.'&mf_instance=' . get_instance(), 'lien', 'bouton_supprimer_a_commande_article');
        }
        $trans['{bouton_supprimer_a_commande_article}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_supprimer_a_commande_article', BOUTON_CLASSE_SUPPRIMER) : '');

        // a_commande_article_Quantite
        if ($mf_droits_defaut['api_modifier__a_commande_article_Quantite']) {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_a_commande_article_Quantite') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_a_commande_article_Quantite&Code_commande='.$Code_commande.'&Code_article='.$Code_article.'&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_a_commande_article_Quantite');
        }
        $trans['{bouton_modifier_a_commande_article_Quantite}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_a_commande_article_Quantite') : '';

        // a_commande_article_Prix_ligne
        if ($mf_droits_defaut['api_modifier__a_commande_article_Prix_ligne']) {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_a_commande_article_Prix_ligne') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_a_commande_article_Prix_ligne&Code_commande='.$Code_commande.'&Code_article='.$Code_article.'&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_a_commande_article_Prix_ligne');
        }
        $trans['{bouton_modifier_a_commande_article_Prix_ligne}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_a_commande_article_Prix_ligne') : '';

    /* prec_et_suiv */
    if ($db->a_commande_article()->mf_compter((isset($est_charge['commande']) ? $mf_contexte['Code_commande'] : 0), (isset($est_charge['article']) ? $mf_contexte['Code_article'] : 0)) < 100) {
        $liste_a_commande_article = $db->a_commande_article()->mf_lister_contexte();
        // prec
        $prec_et_suiv = prec_suiv($liste_a_commande_article, $a_commande_article['Code_commande'].'-'.$a_commande_article['Code_article']);
        $prec=['link'=>'', 'title'=>''];
        $suiv=['link'=>'', 'title'=>''];
        if (isset($prec_et_suiv['prec']['Code_commande'])) {
            $prec['link'] = get_nom_page_courante().'?act=apercu_a_commande_article&Code_commande='.$prec_et_suiv['prec']['Code_commande'].'&Code_article='.$prec_et_suiv['prec']['Code_article'].'';
            $prec['title'] = htmlspecialchars(get_titre_ligne_table('a_commande_article', $prec_et_suiv['prec']));
        }
        // suiv
        if (isset($prec_et_suiv['suiv']['Code_commande'])) {
            $suiv['link'] = get_nom_page_courante().'?act=apercu_a_commande_article&Code_commande='.$prec_et_suiv['suiv']['Code_commande'].'&Code_article='.$prec_et_suiv['suiv']['Code_article'].'';
            $suiv['title'] = htmlspecialchars(get_titre_ligne_table('a_commande_article', $prec_et_suiv['suiv']));
        }
        $trans['{pager_a_commande_article}'] = get_code_pager($prec, $suiv);
    } else {
        $trans['{pager_a_commande_article}'] = '';
    }

    /* Code_commande */
        $trans['{Code_commande}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => ['Code_commande'=>$a_commande_article['Code_commande'], 'Code_article'=>$a_commande_article['Code_article']], 'DB_name' => 'Code_commande' , 'valeur_initiale' => $a_commande_article['Code_commande'] ]);

    /* Code_article */
        $trans['{Code_article}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => ['Code_commande'=>$a_commande_article['Code_commande'], 'Code_article'=>$a_commande_article['Code_article']], 'DB_name' => 'Code_article' , 'valeur_initiale' => $a_commande_article['Code_article'] ]);

    /* a_commande_article_Quantite */
        if ($mf_droits_defaut['api_modifier__a_commande_article_Quantite']) {
            $trans['{a_commande_article_Quantite}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => ['Code_commande'=>$a_commande_article['Code_commande'], 'Code_article'=>$a_commande_article['Code_article']] , 'DB_name' => 'a_commande_article_Quantite' , 'valeur_initiale' => $a_commande_article['a_commande_article_Quantite'] ]);
        } else {
            $trans['{a_commande_article_Quantite}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => ['Code_commande'=>$a_commande_article['Code_commande'], 'Code_article'=>$a_commande_article['Code_article']] , 'DB_name' => 'a_commande_article_Quantite' , 'valeur_initiale' => $a_commande_article['a_commande_article_Quantite'] ]);
        }

    /* a_commande_article_Prix_ligne */
        if ($mf_droits_defaut['api_modifier__a_commande_article_Prix_ligne']) {
            $trans['{a_commande_article_Prix_ligne}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => ['Code_commande'=>$a_commande_article['Code_commande'], 'Code_article'=>$a_commande_article['Code_article']] , 'DB_name' => 'a_commande_article_Prix_ligne' , 'valeur_initiale' => $a_commande_article['a_commande_article_Prix_ligne'] ]);
        } else {
            $trans['{a_commande_article_Prix_ligne}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => ['Code_commande'=>$a_commande_article['Code_commande'], 'Code_article'=>$a_commande_article['Code_article']] , 'DB_name' => 'a_commande_article_Prix_ligne' , 'valeur_initiale' => $a_commande_article['a_commande_article_Prix_ligne'] ]);
        }

