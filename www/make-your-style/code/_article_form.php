<?php declare(strict_types=1);

/** @var string $mf_action */
/** @var string $mess */

    if ($mf_action == 'apercu_article' || $mf_action <> '' && mf_Code_article() != 0) {

        $article = $db->article()->mf_get(mf_Code_article(), ['autocompletion' => true]);

        if (isset($article['Code_article'])) {

            $fil_ariane->ajouter_titre(get_titre_ligne_table('article', $article), get_nom_page_courante().'?act=apercu_article&Code_article=' . $article['Code_article']);

            $menu_a_droite->raz_boutons();

            if (! MULTI_BLOCS) {
                $code_html = '';
            }

            include __DIR__ . '/_article_get.php';

            $code_html .= recuperer_gabarit('main/section.html', [
                '{fonction}'  => 'apercu',
                '{nom_table}' => 'article',
                '{titre}'     => strip_tags(htmlspecialchars_decode(get_titre_ligne_table('article', $article)), ''),
                '{contenu}'   => recuperer_gabarit('article/bloc_apercu.html', $trans),
            ]);

        }

    } else {

        /* debut developpement */
//        include __DIR__ . '/_article_list.php';
//
//        $code_html .= recuperer_gabarit('main/section.html', [
//            '{fonction}'  => 'lister',
//            '{nom_table}' => 'article',
//            '{titre}'     => htmlspecialchars(get_nom_colonne('libelle_liste_article')),
//            '{contenu}'   => recuperer_gabarit('article/bloc_lister.html', $trans),
//        ]);
        /* fin developpement */

    }

    if ($mf_action == "ajouter_article") {

        $form = new Formulaire('', $mess);
        $form->ajouter_input("article_Libelle", ( isset($_POST['article_Libelle']) ? $_POST['article_Libelle'] : $mf_initialisation['article_Libelle'] ), true);
        $form->ajouter_textarea("article_Description", ( isset($_POST['article_Description']) ? $_POST['article_Description'] : $mf_initialisation['article_Description'] ), true);
        $form->ajouter_select(lister_cles($lang_standard['article_Saison_Type_']), "article_Saison_Type", ( isset($_POST['article_Saison_Type']) ? $_POST['article_Saison_Type'] : $mf_initialisation['article_Saison_Type'] ), true);
        $form->ajouter_input("article_Nom_fournisseur", ( isset($_POST['article_Nom_fournisseur']) ? $_POST['article_Nom_fournisseur'] : $mf_initialisation['article_Nom_fournisseur'] ), true);
        $form->ajouter_input("article_Url", ( isset($_POST['article_Url']) ? $_POST['article_Url'] : $mf_initialisation['article_Url'] ), true);
        $form->ajouter_input("article_Reference", ( isset($_POST['article_Reference']) ? $_POST['article_Reference'] : $mf_initialisation['article_Reference'] ), true);
        $form->ajouter_input("article_Couleur", ( isset($_POST['article_Couleur']) ? $_POST['article_Couleur'] : $mf_initialisation['article_Couleur'] ), true, 'color');
        $form->ajouter_input("article_Code_couleur_svg", ( isset($_POST['article_Code_couleur_svg']) ? $_POST['article_Code_couleur_svg'] : $mf_initialisation['article_Code_couleur_svg'] ), true);
        $form->ajouter_select(lister_cles($lang_standard['article_Taille_Pays_Type_']), "article_Taille_Pays_Type", ( isset($_POST['article_Taille_Pays_Type']) ? $_POST['article_Taille_Pays_Type'] : $mf_initialisation['article_Taille_Pays_Type'] ), true);
        $form->ajouter_input("article_Taille", ( isset($_POST['article_Taille']) ? $_POST['article_Taille'] : $mf_initialisation['article_Taille'] ), true);
        $form->ajouter_input("article_Matiere", ( isset($_POST['article_Matiere']) ? $_POST['article_Matiere'] : $mf_initialisation['article_Matiere'] ), true);
        $form->ajouter_input("article_Photo_Fichier", ( isset($_POST['article_Photo_Fichier']) ? $_POST['article_Photo_Fichier'] : "" ), true, "file");
        $form->ajouter_input("article_Prix", ( isset($_POST['article_Prix']) ? $_POST['article_Prix'] : $mf_initialisation['article_Prix'] ), true);
        $form->ajouter_select(lister_cles($lang_standard['article_Actif_']), "article_Actif", ( isset($_POST['article_Actif']) ? $_POST['article_Actif'] : $mf_initialisation['article_Actif'] ), true);
        if (! isset($est_charge['sous_categorie_article'])) {
            $form->ajouter_select(lister_cles($lang_standard['Code_sous_categorie_article_']), "Code_sous_categorie_article", (isset($_POST['Code_sous_categorie_article']) ? (int) $_POST['Code_sous_categorie_article'] : 0), true);
        }

        $code_html .= recuperer_gabarit('article/form_add_article.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_add_article')], false, true);

    } elseif ($mf_action == "modifier_article") {

        $article = $db->article()->mf_get(mf_Code_article(), ['autocompletion' => true]);
        if (isset($article['Code_article'])) {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("article_Libelle", ( isset($_POST['article_Libelle']) ? $_POST['article_Libelle'] : $article['article_Libelle'] ), true);
            $form->ajouter_textarea("article_Description", ( isset($_POST['article_Description']) ? $_POST['article_Description'] : $article['article_Description'] ), true);
            $form->ajouter_select(liste_union_A_et_B([$article['article_Saison_Type']], Hook_article::workflow__article_Saison_Type($article['article_Saison_Type'])), "article_Saison_Type", ( isset($_POST['article_Saison_Type']) ? $_POST['article_Saison_Type'] : $article['article_Saison_Type'] ), true);
            $form->ajouter_input("article_Nom_fournisseur", ( isset($_POST['article_Nom_fournisseur']) ? $_POST['article_Nom_fournisseur'] : $article['article_Nom_fournisseur'] ), true);
            $form->ajouter_input("article_Url", ( isset($_POST['article_Url']) ? $_POST['article_Url'] : $article['article_Url'] ), true);
            $form->ajouter_input("article_Reference", ( isset($_POST['article_Reference']) ? $_POST['article_Reference'] : $article['article_Reference'] ), true);
            $form->ajouter_input("article_Couleur", ( isset($_POST['article_Couleur']) ? $_POST['article_Couleur'] : $article['article_Couleur'] ), true);
            $form->ajouter_input("article_Code_couleur_svg", ( isset($_POST['article_Code_couleur_svg']) ? $_POST['article_Code_couleur_svg'] : $article['article_Code_couleur_svg'] ), true);
            $form->ajouter_select(liste_union_A_et_B([$article['article_Taille_Pays_Type']], Hook_article::workflow__article_Taille_Pays_Type($article['article_Taille_Pays_Type'])), "article_Taille_Pays_Type", ( isset($_POST['article_Taille_Pays_Type']) ? $_POST['article_Taille_Pays_Type'] : $article['article_Taille_Pays_Type'] ), true);
            $form->ajouter_input("article_Taille", ( isset($_POST['article_Taille']) ? $_POST['article_Taille'] : $article['article_Taille'] ), true);
            $form->ajouter_input("article_Matiere", ( isset($_POST['article_Matiere']) ? $_POST['article_Matiere'] : $article['article_Matiere'] ), true);
            $form->ajouter_input("article_Photo_Fichier", ( isset($_POST['article_Photo_Fichier']) ? $_POST['article_Photo_Fichier'] : "" ), true, "file");
            $form->ajouter_input("article_Prix", ( isset($_POST['article_Prix']) ? $_POST['article_Prix'] : $article['article_Prix'] ), true);
            $form->ajouter_select(lister_cles($lang_standard['article_Actif_']), "article_Actif", ( isset($_POST['article_Actif']) ? $_POST['article_Actif'] : $article['article_Actif'] ), true);
            if (!isset($est_charge['sous_categorie_article'])) {
                $form->ajouter_select(lister_cles($lang_standard['Code_sous_categorie_article_']), "Code_sous_categorie_article", (isset($_POST['Code_sous_categorie_article']) ? (int) $_POST['Code_sous_categorie_article'] : $article['Code_sous_categorie_article']), true);
            }

            $code_html .= recuperer_gabarit('article/form_edit_article.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_article')], false, true);

        }

    }
    elseif ($mf_action == 'modifier_article_Libelle') {

        $article = $db->article()->mf_get(mf_Code_article(), ['autocompletion' => true]);
        if (isset($article['Code_article'])) {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("article_Libelle", ( isset($_POST['article_Libelle']) ? $_POST['article_Libelle'] : $article['article_Libelle'] ), true);

            $code_html .= recuperer_gabarit('article/form_edit_article_Libelle.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_article_Libelle')], false, true);

        }

    }
    elseif ($mf_action == 'modifier_article_Description') {

        $article = $db->article()->mf_get(mf_Code_article(), ['autocompletion' => true]);
        if (isset($article['Code_article'])) {

            $form = new Formulaire('', $mess);
            $form->ajouter_textarea("article_Description", ( isset($_POST['article_Description']) ? $_POST['article_Description'] : $article['article_Description'] ), true);

            $code_html .= recuperer_gabarit('article/form_edit_article_Description.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_article_Description')], false, true);

        }

    }
    elseif ($mf_action == 'modifier_article_Saison_Type') {

        $article = $db->article()->mf_get(mf_Code_article(), ['autocompletion' => true]);
        if (isset($article['Code_article'])) {

            $form = new Formulaire('', $mess);
            $form->ajouter_select(liste_union_A_et_B([$article['article_Saison_Type']], Hook_article::workflow__article_Saison_Type($article['article_Saison_Type'])), 'article_Saison_Type', (isset($_POST['article_Saison_Type']) ? $_POST['article_Saison_Type'] : $article['article_Saison_Type']), true);

            $code_html .= recuperer_gabarit('article/form_edit_article_Saison_Type.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_article_Saison_Type')], false, true);

        }

    }
    elseif ($mf_action == 'modifier_article_Nom_fournisseur') {

        $article = $db->article()->mf_get(mf_Code_article(), ['autocompletion' => true]);
        if (isset($article['Code_article'])) {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("article_Nom_fournisseur", ( isset($_POST['article_Nom_fournisseur']) ? $_POST['article_Nom_fournisseur'] : $article['article_Nom_fournisseur'] ), true);

            $code_html .= recuperer_gabarit('article/form_edit_article_Nom_fournisseur.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_article_Nom_fournisseur')], false, true);

        }

    }
    elseif ($mf_action == 'modifier_article_Url') {

        $article = $db->article()->mf_get(mf_Code_article(), ['autocompletion' => true]);
        if (isset($article['Code_article'])) {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("article_Url", ( isset($_POST['article_Url']) ? $_POST['article_Url'] : $article['article_Url'] ), true);

            $code_html .= recuperer_gabarit('article/form_edit_article_Url.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_article_Url')], false, true);

        }

    }
    elseif ($mf_action == 'modifier_article_Reference') {

        $article = $db->article()->mf_get(mf_Code_article(), ['autocompletion' => true]);
        if (isset($article['Code_article'])) {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("article_Reference", ( isset($_POST['article_Reference']) ? $_POST['article_Reference'] : $article['article_Reference'] ), true);

            $code_html .= recuperer_gabarit('article/form_edit_article_Reference.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_article_Reference')], false, true);

        }

    }
    elseif ($mf_action == 'modifier_article_Couleur') {

        $article = $db->article()->mf_get(mf_Code_article(), ['autocompletion' => true]);
        if (isset($article['Code_article'])) {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("article_Couleur", ( isset($_POST['article_Couleur']) ? $_POST['article_Couleur'] : $article['article_Couleur'] ), true);

            $code_html .= recuperer_gabarit('article/form_edit_article_Couleur.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_article_Couleur')], false, true);

        }

    }
    elseif ($mf_action == 'modifier_article_Code_couleur_svg') {

        $article = $db->article()->mf_get(mf_Code_article(), ['autocompletion' => true]);
        if (isset($article['Code_article'])) {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("article_Code_couleur_svg", ( isset($_POST['article_Code_couleur_svg']) ? $_POST['article_Code_couleur_svg'] : $article['article_Code_couleur_svg'] ), true);

            $code_html .= recuperer_gabarit('article/form_edit_article_Code_couleur_svg.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_article_Code_couleur_svg')], false, true);

        }

    }
    elseif ($mf_action == 'modifier_article_Taille_Pays_Type') {

        $article = $db->article()->mf_get(mf_Code_article(), ['autocompletion' => true]);
        if (isset($article['Code_article'])) {

            $form = new Formulaire('', $mess);
            $form->ajouter_select(liste_union_A_et_B([$article['article_Taille_Pays_Type']], Hook_article::workflow__article_Taille_Pays_Type($article['article_Taille_Pays_Type'])), 'article_Taille_Pays_Type', (isset($_POST['article_Taille_Pays_Type']) ? $_POST['article_Taille_Pays_Type'] : $article['article_Taille_Pays_Type']), true);

            $code_html .= recuperer_gabarit('article/form_edit_article_Taille_Pays_Type.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_article_Taille_Pays_Type')], false, true);

        }

    }
    elseif ($mf_action == 'modifier_article_Taille') {

        $article = $db->article()->mf_get(mf_Code_article(), ['autocompletion' => true]);
        if (isset($article['Code_article'])) {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("article_Taille", ( isset($_POST['article_Taille']) ? $_POST['article_Taille'] : $article['article_Taille'] ), true);

            $code_html .= recuperer_gabarit('article/form_edit_article_Taille.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_article_Taille')], false, true);

        }

    }
    elseif ($mf_action == 'modifier_article_Matiere') {

        $article = $db->article()->mf_get(mf_Code_article(), ['autocompletion' => true]);
        if (isset($article['Code_article'])) {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("article_Matiere", ( isset($_POST['article_Matiere']) ? $_POST['article_Matiere'] : $article['article_Matiere'] ), true);

            $code_html .= recuperer_gabarit('article/form_edit_article_Matiere.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_article_Matiere')], false, true);

        }

    }
    elseif ($mf_action == 'modifier_article_Photo_Fichier') {

        $article = $db->article()->mf_get(mf_Code_article(), ['autocompletion' => true]);
        if (isset($article['Code_article'])) {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("article_Photo_Fichier", ( isset($_POST['article_Photo_Fichier']) ? $_POST['article_Photo_Fichier'] : "" ), true, "file");

            $code_html .= recuperer_gabarit('article/form_edit_article_Photo_Fichier.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_article_Photo_Fichier')], false, true);

        }

    }
    elseif ($mf_action == 'modifier_article_Prix') {

        $article = $db->article()->mf_get(mf_Code_article(), ['autocompletion' => true]);
        if (isset($article['Code_article'])) {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("article_Prix", ( isset($_POST['article_Prix']) ? $_POST['article_Prix'] : $article['article_Prix'] ), true);

            $code_html .= recuperer_gabarit('article/form_edit_article_Prix.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_article_Prix')], false, true);

        }

    }
    elseif ($mf_action == 'modifier_article_Actif') {

        $article = $db->article()->mf_get(mf_Code_article(), ['autocompletion' => true]);
        if (isset($article['Code_article'])) {

            $form = new Formulaire('', $mess);
            $form->ajouter_select(lister_cles($lang_standard['article_Actif_']), "article_Actif", ( isset($_POST['article_Actif']) ? $_POST['article_Actif'] : $article['article_Actif'] ), true);

            $code_html .= recuperer_gabarit('article/form_edit_article_Actif.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_article_Actif')], false, true);

        }

    }
    elseif ($mf_action == 'modifier_article__Code_sous_categorie_article') {

        $article = $db->article()->mf_get(mf_Code_article(), ['autocompletion' => true]);
        if (isset($article['Code_article'])) {

            $form = new Formulaire('', $mess);
            if (! isset($est_charge['sous_categorie_article'])) {
                $form->ajouter_select(lister_cles($lang_standard['Code_sous_categorie_article_']), "Code_sous_categorie_article", (isset($_POST['Code_sous_categorie_article']) ? (int) $_POST['Code_sous_categorie_article'] : $article['Code_sous_categorie_article']), true);
            }

            $code_html .= recuperer_gabarit('article/form_edit__Code_sous_categorie_article.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_article__Code_sous_categorie_article')], false, true);

        }

    }
    elseif ($mf_action == 'supprimer_article') {

        $article = $db->article()->mf_get(mf_Code_article(), ['autocompletion' => true]);
        if (isset($article['Code_article'])) {

            $form = new Formulaire('', $mess);
            $form->ajouter_select([0, 1], 'Supprimer', FORM_SUPPR_DEFAUT, true);
            $form->activer_picto_suppression();

            $code_html .= recuperer_gabarit('article/form_delete_article.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_delete_article')], false, true);

        }

    }

