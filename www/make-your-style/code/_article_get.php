<?php

    // Actualisation des droits
    Hook_article::hook_actualiser_les_droits_modifier($article['Code_article']);
    Hook_article::hook_actualiser_les_droits_supprimer($article['Code_article']);

    // boutons
        if ($mf_droits_defaut['article__MODIFIER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_article') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_article&Code_article='.$Code_article, 'lien', 'bouton_modifier_article');
        }
        $trans['{bouton_modifier_article}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_article') : '';
        if ($mf_droits_defaut['article__SUPPRIMER'])
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_SUPPRIMER_PREC . get_nom_colonne('bouton_supprimer_article') . BOUTON_LIBELLE_SUPPRIMER_SUIV, get_nom_page_courante().'?act=supprimer_article&Code_article='.$Code_article, 'lien', 'bouton_supprimer_article');
        }
        $trans['{bouton_supprimer_article}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_supprimer_article', BOUTON_CLASSE_SUPPRIMER) : '';

        // article_Libelle
        if ( $mf_droits_defaut['api_modifier__article_Libelle'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_article_Libelle') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_article_Libelle&Code_article='.$Code_article, 'lien', 'bouton_modifier_article_Libelle');
        }
        $trans['{bouton_modifier_article_Libelle}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_article_Libelle') : '';

        // article_Photo_Fichier
        if ( $mf_droits_defaut['api_modifier__article_Photo_Fichier'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_article_Photo_Fichier') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_article_Photo_Fichier&Code_article='.$Code_article, 'lien', 'bouton_modifier_article_Photo_Fichier');
        }
        $trans['{bouton_modifier_article_Photo_Fichier}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_article_Photo_Fichier') : '';

        // article_Prix
        if ( $mf_droits_defaut['api_modifier__article_Prix'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_article_Prix') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_article_Prix&Code_article='.$Code_article, 'lien', 'bouton_modifier_article_Prix');
        }
        $trans['{bouton_modifier_article_Prix}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_article_Prix') : '';

        // article_Actif
        if ( $mf_droits_defaut['api_modifier__article_Actif'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_article_Actif') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_article_Actif&Code_article='.$Code_article, 'lien', 'bouton_modifier_article_Actif');
        }
        $trans['{bouton_modifier_article_Actif}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_article_Actif') : '';

        // Code_type_produit
        if ( $mf_droits_defaut['api_modifier_ref__article__Code_type_produit'] )
        {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_article__Code_type_produit') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_article__Code_type_produit&Code_article='.$Code_article, 'lien', 'bouton_modifier_article__Code_type_produit');
        }
        $trans['{bouton_modifier_article__Code_type_produit}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_article__Code_type_produit') : '';

    /* prec_et_suiv */
    if ( $table_article->mf_compter((isset($est_charge['type_produit']) ? $mf_contexte['Code_type_produit'] : 0))<100 )
    {
        $liste_article = $table_article->mf_lister_contexte();
        // prec
        $prec_et_suiv = prec_suiv($liste_article, $article['Code_article']);
        $prec=['link'=>'', 'title'=>''];
        $suiv=['link'=>'', 'title'=>''];
        if (isset($prec_et_suiv['prec']['Code_article']))
        {
            $prec['link'] = get_nom_page_courante().'?act=apercu_article&Code_article='.$prec_et_suiv['prec']['Code_article'];
            $prec['title'] = htmlspecialchars(get_titre_ligne_table('article', $prec_et_suiv['prec']));
        }
        // suiv
        if (isset($prec_et_suiv['suiv']['Code_article']))
        {
            $suiv['link'] = get_nom_page_courante().'?act=apercu_article&Code_article='.$prec_et_suiv['suiv']['Code_article'];
            $suiv['title'] = htmlspecialchars(get_titre_ligne_table('article', $prec_et_suiv['suiv']));
        }
        $trans['{pager_article}'] = get_code_pager($prec, $suiv);
    }
    else
    {
        $trans['{pager_article}'] = '';
    }

    /* article_Libelle */
        if ( $mf_droits_defaut['api_modifier__article_Libelle'] )
            $trans['{article_Libelle}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_article' => $article['Code_article']) , 'DB_name' => 'article_Libelle' , 'valeur_initiale' => $article['article_Libelle'] ]);
        else
            $trans['{article_Libelle}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_article' => $article['Code_article']) , 'DB_name' => 'article_Libelle' , 'valeur_initiale' => $article['article_Libelle'] ]);

    /* article_Photo_Fichier */
        if ( $mf_droits_defaut['api_modifier__article_Photo_Fichier'] )
            $trans['{article_Photo_Fichier}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_article' => $article['Code_article']) , 'DB_name' => 'article_Photo_Fichier' , 'valeur_initiale' => $article['article_Photo_Fichier'] ]);
        else
            $trans['{article_Photo_Fichier}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_article' => $article['Code_article']) , 'DB_name' => 'article_Photo_Fichier' , 'valeur_initiale' => $article['article_Photo_Fichier'] ]);

    /* article_Prix */
        if ( $mf_droits_defaut['api_modifier__article_Prix'] )
            $trans['{article_Prix}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_article' => $article['Code_article']) , 'DB_name' => 'article_Prix' , 'valeur_initiale' => $article['article_Prix'] ]);
        else
            $trans['{article_Prix}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_article' => $article['Code_article']) , 'DB_name' => 'article_Prix' , 'valeur_initiale' => $article['article_Prix'] ]);

    /* article_Actif */
        if ( $mf_droits_defaut['api_modifier__article_Actif'] )
            $trans['{article_Actif}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_article' => $article['Code_article']) , 'DB_name' => 'article_Actif' , 'valeur_initiale' => $article['article_Actif'], 'class' => 'button' ]);
        else
            $trans['{article_Actif}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_article' => $article['Code_article']) , 'DB_name' => 'article_Actif' , 'valeur_initiale' => $article['article_Actif'] ]);

    /* Code_type_produit */
        if ( $mf_droits_defaut['api_modifier_ref__article__Code_type_produit'] )
            $trans['{Code_type_produit}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_article' => $article['Code_article']) , 'DB_name' => 'Code_type_produit' , 'valeur_initiale' => $article['Code_type_produit'] , 'nom_table' => 'article' ]);
        else
            $trans['{Code_type_produit}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_article' => $article['Code_article']) , 'DB_name' => 'Code_type_produit' , 'valeur_initiale' => $article['Code_type_produit'] , 'nom_table' => 'article' ]);

