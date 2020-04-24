<?php declare(strict_types=1);

/** @var string $mf_action */
/** @var string $mess */

    if ($mf_action == 'apercu_sous_categorie_article' || $mf_action <> '' && mf_Code_sous_categorie_article() != 0) {

        $sous_categorie_article = $db->sous_categorie_article()->mf_get(mf_Code_sous_categorie_article(), ['autocompletion' => true]);

        if (isset($sous_categorie_article['Code_sous_categorie_article'])) {

            $fil_ariane->ajouter_titre(get_titre_ligne_table('sous_categorie_article', $sous_categorie_article), get_nom_page_courante().'?act=apercu_sous_categorie_article&Code_sous_categorie_article=' . $sous_categorie_article['Code_sous_categorie_article']);

            $menu_a_droite->raz_boutons();

            if (! MULTI_BLOCS) {
                $code_html = '';
            }

            include __DIR__ . '/_sous_categorie_article_get.php';

            $code_html .= recuperer_gabarit('main/section.html', [
                '{fonction}'  => 'apercu',
                '{nom_table}' => 'sous_categorie_article',
                '{titre}'     => strip_tags(htmlspecialchars_decode(get_titre_ligne_table('sous_categorie_article', $sous_categorie_article)), ''),
                '{contenu}'   => recuperer_gabarit('sous_categorie_article/bloc_apercu.html', $trans),
            ]);

        }

    } else {

        include __DIR__ . '/_sous_categorie_article_list.php';

        $code_html .= recuperer_gabarit('main/section.html', [
            '{fonction}'  => 'lister',
            '{nom_table}' => 'sous_categorie_article',
            '{titre}'     => htmlspecialchars(get_nom_colonne('libelle_liste_sous_categorie_article')),
            '{contenu}'   => recuperer_gabarit('sous_categorie_article/bloc_lister.html', $trans),
        ]);

    }

    if ($mf_action == "ajouter_sous_categorie_article") {

        $form = new Formulaire('', $mess);
        $form->ajouter_input("sous_categorie_article_Libelle", ( isset($_POST['sous_categorie_article_Libelle']) ? $_POST['sous_categorie_article_Libelle'] : $mf_initialisation['sous_categorie_article_Libelle'] ), true);
        if (! isset($est_charge['categorie_article'])) {
            $form->ajouter_select(lister_cles($lang_standard['Code_categorie_article_']), "Code_categorie_article", (isset($_POST['Code_categorie_article']) ? (int) $_POST['Code_categorie_article'] : 0), true);
        }

        $code_html .= recuperer_gabarit('sous_categorie_article/form_add_sous_categorie_article.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_add_sous_categorie_article')], false, true);

    } elseif ($mf_action == "modifier_sous_categorie_article") {

        $sous_categorie_article = $db->sous_categorie_article()->mf_get(mf_Code_sous_categorie_article(), ['autocompletion' => true]);
        if (isset($sous_categorie_article['Code_sous_categorie_article'])) {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("sous_categorie_article_Libelle", ( isset($_POST['sous_categorie_article_Libelle']) ? $_POST['sous_categorie_article_Libelle'] : $sous_categorie_article['sous_categorie_article_Libelle'] ), true);
            if (!isset($est_charge['categorie_article'])) {
                $form->ajouter_select(lister_cles($lang_standard['Code_categorie_article_']), "Code_categorie_article", (isset($_POST['Code_categorie_article']) ? (int) $_POST['Code_categorie_article'] : $sous_categorie_article['Code_categorie_article']), true);
            }

            $code_html .= recuperer_gabarit('sous_categorie_article/form_edit_sous_categorie_article.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_sous_categorie_article')], false, true);

        }

    }
    elseif ($mf_action == 'modifier_sous_categorie_article_Libelle') {

        $sous_categorie_article = $db->sous_categorie_article()->mf_get(mf_Code_sous_categorie_article(), ['autocompletion' => true]);
        if (isset($sous_categorie_article['Code_sous_categorie_article'])) {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("sous_categorie_article_Libelle", ( isset($_POST['sous_categorie_article_Libelle']) ? $_POST['sous_categorie_article_Libelle'] : $sous_categorie_article['sous_categorie_article_Libelle'] ), true);

            $code_html .= recuperer_gabarit('sous_categorie_article/form_edit_sous_categorie_article_Libelle.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_sous_categorie_article_Libelle')], false, true);

        }

    }
    elseif ($mf_action == 'modifier_sous_categorie_article__Code_categorie_article') {

        $sous_categorie_article = $db->sous_categorie_article()->mf_get(mf_Code_sous_categorie_article(), ['autocompletion' => true]);
        if (isset($sous_categorie_article['Code_sous_categorie_article'])) {

            $form = new Formulaire('', $mess);
            if (! isset($est_charge['categorie_article'])) {
                $form->ajouter_select(lister_cles($lang_standard['Code_categorie_article_']), "Code_categorie_article", (isset($_POST['Code_categorie_article']) ? (int) $_POST['Code_categorie_article'] : $sous_categorie_article['Code_categorie_article']), true);
            }

            $code_html .= recuperer_gabarit('sous_categorie_article/form_edit__Code_categorie_article.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_sous_categorie_article__Code_categorie_article')], false, true);

        }

    }
    elseif ($mf_action == 'supprimer_sous_categorie_article') {

        $sous_categorie_article = $db->sous_categorie_article()->mf_get(mf_Code_sous_categorie_article(), ['autocompletion' => true]);
        if (isset($sous_categorie_article['Code_sous_categorie_article'])) {

            $form = new Formulaire('', $mess);
            $form->ajouter_select([0, 1], 'Supprimer', FORM_SUPPR_DEFAUT, true);
            $form->activer_picto_suppression();

            $code_html .= recuperer_gabarit('sous_categorie_article/form_delete_sous_categorie_article.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_delete_sous_categorie_article')], false, true);

        }

    }

