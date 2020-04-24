<?php declare(strict_types=1);

/** @var array $article */

    // Actualisation des droits
    Hook_article::hook_actualiser_les_droits_modifier($article['Code_article']);
    Hook_article::hook_actualiser_les_droits_supprimer($article['Code_article']);

    // boutons
        if ($mf_droits_defaut['article__MODIFIER']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_article') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante() . '?act=modifier_article&Code_article=' . mf_Code_article() . '&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_article');
        }
        $trans['{bouton_modifier_article}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_article') : '');
        if ($mf_droits_defaut['article__SUPPRIMER']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_SUPPRIMER_PREC . get_nom_colonne('bouton_supprimer_article') . BOUTON_LIBELLE_SUPPRIMER_SUIV, get_nom_page_courante() . '?act=supprimer_article&Code_article=' . mf_Code_article() . '&mf_instance=' . get_instance(), 'lien', 'bouton_supprimer_article');
        }
        $trans['{bouton_supprimer_article}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_supprimer_article', BOUTON_CLASSE_SUPPRIMER) : '');

        // article_Libelle
        if ($mf_droits_defaut['api_modifier__article_Libelle']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_article_Libelle') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_article_Libelle&Code_article=' . mf_Code_article() . '&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_article_Libelle');
        }
        $trans['{bouton_modifier_article_Libelle}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_article_Libelle') : '');

        // article_Description
        if ($mf_droits_defaut['api_modifier__article_Description']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_article_Description') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_article_Description&Code_article=' . mf_Code_article() . '&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_article_Description');
        }
        $trans['{bouton_modifier_article_Description}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_article_Description') : '');

        // article_Saison_Type
        if ($mf_droits_defaut['api_modifier__article_Saison_Type']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_article_Saison_Type') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_article_Saison_Type&Code_article=' . mf_Code_article() . '&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_article_Saison_Type');
        }
        $trans['{bouton_modifier_article_Saison_Type}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_article_Saison_Type') : '');

        // article_Nom_fournisseur
        if ($mf_droits_defaut['api_modifier__article_Nom_fournisseur']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_article_Nom_fournisseur') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_article_Nom_fournisseur&Code_article=' . mf_Code_article() . '&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_article_Nom_fournisseur');
        }
        $trans['{bouton_modifier_article_Nom_fournisseur}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_article_Nom_fournisseur') : '');

        // article_Url
        if ($mf_droits_defaut['api_modifier__article_Url']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_article_Url') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_article_Url&Code_article=' . mf_Code_article() . '&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_article_Url');
        }
        $trans['{bouton_modifier_article_Url}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_article_Url') : '');

        // article_Reference
        if ($mf_droits_defaut['api_modifier__article_Reference']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_article_Reference') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_article_Reference&Code_article=' . mf_Code_article() . '&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_article_Reference');
        }
        $trans['{bouton_modifier_article_Reference}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_article_Reference') : '');

        // article_Couleur
        if ($mf_droits_defaut['api_modifier__article_Couleur']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_article_Couleur') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_article_Couleur&Code_article=' . mf_Code_article() . '&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_article_Couleur');
        }
        $trans['{bouton_modifier_article_Couleur}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_article_Couleur') : '');

        // article_Code_couleur_svg
        if ($mf_droits_defaut['api_modifier__article_Code_couleur_svg']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_article_Code_couleur_svg') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_article_Code_couleur_svg&Code_article=' . mf_Code_article() . '&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_article_Code_couleur_svg');
        }
        $trans['{bouton_modifier_article_Code_couleur_svg}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_article_Code_couleur_svg') : '');

        // article_Taille_Pays_Type
        if ($mf_droits_defaut['api_modifier__article_Taille_Pays_Type']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_article_Taille_Pays_Type') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_article_Taille_Pays_Type&Code_article=' . mf_Code_article() . '&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_article_Taille_Pays_Type');
        }
        $trans['{bouton_modifier_article_Taille_Pays_Type}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_article_Taille_Pays_Type') : '');

        // article_Taille
        if ($mf_droits_defaut['api_modifier__article_Taille']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_article_Taille') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_article_Taille&Code_article=' . mf_Code_article() . '&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_article_Taille');
        }
        $trans['{bouton_modifier_article_Taille}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_article_Taille') : '');

        // article_Matiere
        if ($mf_droits_defaut['api_modifier__article_Matiere']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_article_Matiere') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_article_Matiere&Code_article=' . mf_Code_article() . '&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_article_Matiere');
        }
        $trans['{bouton_modifier_article_Matiere}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_article_Matiere') : '');

        // article_Photo_Fichier
        if ($mf_droits_defaut['api_modifier__article_Photo_Fichier']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_article_Photo_Fichier') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_article_Photo_Fichier&Code_article=' . mf_Code_article() . '&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_article_Photo_Fichier');
        }
        $trans['{bouton_modifier_article_Photo_Fichier}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_article_Photo_Fichier') : '');

        // article_Prix
        if ($mf_droits_defaut['api_modifier__article_Prix']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_article_Prix') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_article_Prix&Code_article=' . mf_Code_article() . '&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_article_Prix');
        }
        $trans['{bouton_modifier_article_Prix}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_article_Prix') : '');

        // article_Actif
        if ($mf_droits_defaut['api_modifier__article_Actif']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_article_Actif') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_article_Actif&Code_article=' . mf_Code_article() . '&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_article_Actif');
        }
        $trans['{bouton_modifier_article_Actif}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_article_Actif') : '');

        // Code_sous_categorie_article
        if ($mf_droits_defaut['api_modifier_ref__article__Code_sous_categorie_article']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_article__Code_sous_categorie_article') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_article__Code_sous_categorie_article&Code_article=' . mf_Code_article() . '&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_article__Code_sous_categorie_article');
        }
        $trans['{bouton_modifier_article__Code_sous_categorie_article}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_article__Code_sous_categorie_article') : '');

    /* prec_et_suiv */
    if ($db->article()->mf_compter((isset($est_charge['sous_categorie_article']) ? $mf_contexte['Code_sous_categorie_article'] : 0)) < 100) {
        $liste_article = $db->article()->mf_lister_contexte();
        // prec
        $prec_et_suiv = prec_suiv($liste_article, $article['Code_article']);
        $prec=['link'=>'', 'title'=>''];
        $suiv=['link'=>'', 'title'=>''];
        if (isset($prec_et_suiv['prec']['Code_article'])) {
            $prec['link'] = get_nom_page_courante().'?act=apercu_article&Code_article=' . $prec_et_suiv['prec']['Code_article'];
            $prec['title'] = htmlspecialchars(get_titre_ligne_table('article', $prec_et_suiv['prec']));
        }
        // suiv
        if (isset($prec_et_suiv['suiv']['Code_article'])) {
            $suiv['link'] = get_nom_page_courante().'?act=apercu_article&Code_article=' . $prec_et_suiv['suiv']['Code_article'];
            $suiv['title'] = htmlspecialchars(get_titre_ligne_table('article', $prec_et_suiv['suiv']));
        }
        $trans['{pager_article}'] = get_code_pager($prec, $suiv);
    } else {
        $trans['{pager_article}'] = '';
    }

    /* article_Libelle */
        if ($mf_droits_defaut['api_modifier__article_Libelle']) {
            $trans['{article_Libelle}'] = ajouter_champ_modifiable_interface(['liste_valeurs_cle_table' => ['Code_article' => $article['Code_article']], 'DB_name' => 'article_Libelle', 'valeur_initiale' => $article['article_Libelle']]);
        } else {
            $trans['{article_Libelle}'] = get_valeur_html_maj_auto_interface(['liste_valeurs_cle_table' => ['Code_article' => $article['Code_article']], 'DB_name' => 'article_Libelle', 'valeur_initiale' => $article['article_Libelle']]);
        }

    /* article_Description */
        if ($mf_droits_defaut['api_modifier__article_Description']) {
            $trans['{article_Description}'] = ajouter_champ_modifiable_interface(['liste_valeurs_cle_table' => ['Code_article' => $article['Code_article']], 'DB_name' => 'article_Description', 'valeur_initiale' => $article['article_Description']]);
        } else {
            $trans['{article_Description}'] = get_valeur_html_maj_auto_interface(['liste_valeurs_cle_table' => ['Code_article' => $article['Code_article']], 'DB_name' => 'article_Description', 'valeur_initiale' => $article['article_Description'], 'class' => 'text' ]);
        }

    /* article_Saison_Type */
        if ($mf_droits_defaut['api_modifier__article_Saison_Type']) {
            // en fonction des possibilités, liste choix possibles
            $liste = liste_union_A_et_B([$article['article_Saison_Type']], Hook_article::workflow__article_Saison_Type($article['article_Saison_Type']));
            foreach ($lang_standard['article_Saison_Type_'] as $key => $value) {
                if (! in_array($key, $liste) && $key != $article['article_Saison_Type']) {
                    unset($lang_standard['article_Saison_Type_'][$key]);
                }
            }
            // champ modifiable
            $trans['{article_Saison_Type}'] = ajouter_champ_modifiable_interface(['liste_valeurs_cle_table' => ['Code_article' => $article['Code_article']], 'DB_name' => 'article_Saison_Type', 'valeur_initiale' => $article['article_Saison_Type']]);
        } else {
            $trans['{article_Saison_Type}'] = get_valeur_html_maj_auto_interface(['liste_valeurs_cle_table' => ['Code_article' => $article['Code_article']], 'DB_name' => 'article_Saison_Type', 'valeur_initiale' => $article['article_Saison_Type']]);
        }

    /* article_Nom_fournisseur */
        if ($mf_droits_defaut['api_modifier__article_Nom_fournisseur']) {
            $trans['{article_Nom_fournisseur}'] = ajouter_champ_modifiable_interface(['liste_valeurs_cle_table' => ['Code_article' => $article['Code_article']], 'DB_name' => 'article_Nom_fournisseur', 'valeur_initiale' => $article['article_Nom_fournisseur']]);
        } else {
            $trans['{article_Nom_fournisseur}'] = get_valeur_html_maj_auto_interface(['liste_valeurs_cle_table' => ['Code_article' => $article['Code_article']], 'DB_name' => 'article_Nom_fournisseur', 'valeur_initiale' => $article['article_Nom_fournisseur']]);
        }

    /* article_Url */
        if ($mf_droits_defaut['api_modifier__article_Url']) {
            $trans['{article_Url}'] = ajouter_champ_modifiable_interface(['liste_valeurs_cle_table' => ['Code_article' => $article['Code_article']], 'DB_name' => 'article_Url', 'valeur_initiale' => $article['article_Url']]);
        } else {
            $trans['{article_Url}'] = get_valeur_html_maj_auto_interface(['liste_valeurs_cle_table' => ['Code_article' => $article['Code_article']], 'DB_name' => 'article_Url', 'valeur_initiale' => $article['article_Url']]);
        }

    /* article_Reference */
        if ($mf_droits_defaut['api_modifier__article_Reference']) {
            $trans['{article_Reference}'] = ajouter_champ_modifiable_interface(['liste_valeurs_cle_table' => ['Code_article' => $article['Code_article']], 'DB_name' => 'article_Reference', 'valeur_initiale' => $article['article_Reference']]);
        } else {
            $trans['{article_Reference}'] = get_valeur_html_maj_auto_interface(['liste_valeurs_cle_table' => ['Code_article' => $article['Code_article']], 'DB_name' => 'article_Reference', 'valeur_initiale' => $article['article_Reference']]);
        }

    /* article_Couleur */
        if ($mf_droits_defaut['api_modifier__article_Couleur']) {
            $trans['{article_Couleur}'] = ajouter_champ_modifiable_interface(['liste_valeurs_cle_table' => ['Code_article' => $article['Code_article']], 'DB_name' => 'article_Couleur', 'valeur_initiale' => $article['article_Couleur'], 'type_input' => 'color']);
        } else {
            $trans['{article_Couleur}'] = get_valeur_html_maj_auto_interface(['liste_valeurs_cle_table' => ['Code_article' => $article['Code_article']], 'DB_name' => 'article_Couleur', 'valeur_initiale' => $article['article_Couleur'], 'class' => 'color' ]);
        }

    /* article_Code_couleur_svg */
        if ($mf_droits_defaut['api_modifier__article_Code_couleur_svg']) {
            $trans['{article_Code_couleur_svg}'] = ajouter_champ_modifiable_interface(['liste_valeurs_cle_table' => ['Code_article' => $article['Code_article']], 'DB_name' => 'article_Code_couleur_svg', 'valeur_initiale' => $article['article_Code_couleur_svg']]);
        } else {
            $trans['{article_Code_couleur_svg}'] = get_valeur_html_maj_auto_interface(['liste_valeurs_cle_table' => ['Code_article' => $article['Code_article']], 'DB_name' => 'article_Code_couleur_svg', 'valeur_initiale' => $article['article_Code_couleur_svg']]);
        }

    /* article_Taille_Pays_Type */
        if ($mf_droits_defaut['api_modifier__article_Taille_Pays_Type']) {
            // en fonction des possibilités, liste choix possibles
            $liste = liste_union_A_et_B([$article['article_Taille_Pays_Type']], Hook_article::workflow__article_Taille_Pays_Type($article['article_Taille_Pays_Type']));
            foreach ($lang_standard['article_Taille_Pays_Type_'] as $key => $value) {
                if (! in_array($key, $liste) && $key != $article['article_Taille_Pays_Type']) {
                    unset($lang_standard['article_Taille_Pays_Type_'][$key]);
                }
            }
            // champ modifiable
            $trans['{article_Taille_Pays_Type}'] = ajouter_champ_modifiable_interface(['liste_valeurs_cle_table' => ['Code_article' => $article['Code_article']], 'DB_name' => 'article_Taille_Pays_Type', 'valeur_initiale' => $article['article_Taille_Pays_Type']]);
        } else {
            $trans['{article_Taille_Pays_Type}'] = get_valeur_html_maj_auto_interface(['liste_valeurs_cle_table' => ['Code_article' => $article['Code_article']], 'DB_name' => 'article_Taille_Pays_Type', 'valeur_initiale' => $article['article_Taille_Pays_Type']]);
        }

    /* article_Taille */
        if ($mf_droits_defaut['api_modifier__article_Taille']) {
            $trans['{article_Taille}'] = ajouter_champ_modifiable_interface(['liste_valeurs_cle_table' => ['Code_article' => $article['Code_article']], 'DB_name' => 'article_Taille', 'valeur_initiale' => $article['article_Taille']]);
        } else {
            $trans['{article_Taille}'] = get_valeur_html_maj_auto_interface(['liste_valeurs_cle_table' => ['Code_article' => $article['Code_article']], 'DB_name' => 'article_Taille', 'valeur_initiale' => $article['article_Taille']]);
        }

    /* article_Matiere */
        if ($mf_droits_defaut['api_modifier__article_Matiere']) {
            $trans['{article_Matiere}'] = ajouter_champ_modifiable_interface(['liste_valeurs_cle_table' => ['Code_article' => $article['Code_article']], 'DB_name' => 'article_Matiere', 'valeur_initiale' => $article['article_Matiere']]);
        } else {
            $trans['{article_Matiere}'] = get_valeur_html_maj_auto_interface(['liste_valeurs_cle_table' => ['Code_article' => $article['Code_article']], 'DB_name' => 'article_Matiere', 'valeur_initiale' => $article['article_Matiere']]);
        }

    /* article_Photo_Fichier */
        $trans['{article_Photo_Fichier}'] = get_valeur_html_maj_auto_interface([
            'liste_valeurs_cle_table' => ['Code_article' => $article['Code_article']],
            'DB_name' => 'article_Photo_Fichier',
            'valeur_initiale' => ($article['article_Photo_Fichier'] == '' ? '<i>Pas de fichier</i>' : '<a href="mf_fichier.php?n=' . $article['article_Photo_Fichier'] . '&l=' . urlencode(get_nom_colonne('article_Photo_Fichier') . ' - ' . get_titre_ligne_table('article', $article)) . '" target="_blank">Accès au fichier</a>') . '<br>' . $trans['{bouton_modifier_article_Photo_Fichier}'],
            'maj_auto' => false,
            'class' => 'html'
        ]);

    /* article_Prix */
        if ($mf_droits_defaut['api_modifier__article_Prix']) {
            $trans['{article_Prix}'] = ajouter_champ_modifiable_interface(['liste_valeurs_cle_table' => ['Code_article' => $article['Code_article']], 'DB_name' => 'article_Prix', 'valeur_initiale' => $article['article_Prix']]);
        } else {
            $trans['{article_Prix}'] = get_valeur_html_maj_auto_interface(['liste_valeurs_cle_table' => ['Code_article' => $article['Code_article']], 'DB_name' => 'article_Prix', 'valeur_initiale' => $article['article_Prix']]);
        }

    /* article_Actif */
        if ($mf_droits_defaut['api_modifier__article_Actif']) {
            $trans['{article_Actif}'] = ajouter_champ_modifiable_interface(['liste_valeurs_cle_table' => ['Code_article' => $article['Code_article']], 'DB_name' => 'article_Actif', 'valeur_initiale' => $article['article_Actif'], 'class' => 'button']);
        } else {
            $trans['{article_Actif}'] = get_valeur_html_maj_auto_interface(['liste_valeurs_cle_table' => ['Code_article' => $article['Code_article']], 'DB_name' => 'article_Actif', 'valeur_initiale' => $article['article_Actif']]);
        }

    /* Code_sous_categorie_article */
        if ($mf_droits_defaut['api_modifier_ref__article__Code_sous_categorie_article']) {
            $trans['{Code_sous_categorie_article}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => ['Code_article' => $article['Code_article']], 'DB_name' => 'Code_sous_categorie_article' , 'valeur_initiale' => $article['Code_sous_categorie_article'] , 'nom_table' => 'article' ]);
        } else {
            $trans['{Code_sous_categorie_article}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => ['Code_article' => $article['Code_article']], 'DB_name' => 'Code_sous_categorie_article' , 'valeur_initiale' => $article['Code_sous_categorie_article'] , 'nom_table' => 'article' ]);
        }

