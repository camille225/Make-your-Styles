<?php declare(strict_types=1);

/** @var string $mf_action */
/** @var string $mess */

    if ($mf_action == 'apercu_categorie_article' || $mf_action <> '' && mf_Code_categorie_article() != 0) {

        $categorie_article = $db->categorie_article()->mf_get(mf_Code_categorie_article(), ['autocompletion' => true]);

        if (isset($categorie_article['Code_categorie_article'])) {

            $fil_ariane->ajouter_titre(get_titre_ligne_table('categorie_article', $categorie_article), get_nom_page_courante().'?act=apercu_categorie_article&Code_categorie_article=' . $categorie_article['Code_categorie_article']);

            $menu_a_droite->raz_boutons();

            if (! MULTI_BLOCS) {
                $code_html = '';
            }

            include __DIR__ . '/_categorie_article_get.php';

            $code_html .= recuperer_gabarit('main/section.html', [
                '{fonction}'  => 'apercu',
                '{nom_table}' => 'categorie_article',
                '{titre}'     => strip_tags(htmlspecialchars_decode(get_titre_ligne_table('categorie_article', $categorie_article)), ''),
                '{contenu}'   => recuperer_gabarit('categorie_article/bloc_apercu.html', $trans),
            ]);

        }

    } else {

        include __DIR__ . '/_categorie_article_list.php';

        $code_html .= recuperer_gabarit('main/section.html', [
            '{fonction}'  => 'lister',
            '{nom_table}' => 'categorie_article',
            '{titre}'     => htmlspecialchars(get_nom_colonne('libelle_liste_categorie_article')),
            '{contenu}'   => recuperer_gabarit('categorie_article/bloc_lister.html', $trans),
        ]);

    }

    if ($mf_action == "ajouter_categorie_article") {

        $form = new Formulaire('', $mess);
        $form->ajouter_input("categorie_article_Libelle", ( isset($_POST['categorie_article_Libelle']) ? $_POST['categorie_article_Libelle'] : $mf_initialisation['categorie_article_Libelle'] ), true);

        $code_html .= recuperer_gabarit('categorie_article/form_add_categorie_article.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_add_categorie_article')], false, true);

    } elseif ($mf_action == "modifier_categorie_article") {

        $categorie_article = $db->categorie_article()->mf_get(mf_Code_categorie_article(), ['autocompletion' => true]);
        if (isset($categorie_article['Code_categorie_article'])) {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("categorie_article_Libelle", ( isset($_POST['categorie_article_Libelle']) ? $_POST['categorie_article_Libelle'] : $categorie_article['categorie_article_Libelle'] ), true);

            $code_html .= recuperer_gabarit('categorie_article/form_edit_categorie_article.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_categorie_article')], false, true);

        }

    }
    elseif ($mf_action == 'modifier_categorie_article_Libelle') {

        $categorie_article = $db->categorie_article()->mf_get(mf_Code_categorie_article(), ['autocompletion' => true]);
        if (isset($categorie_article['Code_categorie_article'])) {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("categorie_article_Libelle", ( isset($_POST['categorie_article_Libelle']) ? $_POST['categorie_article_Libelle'] : $categorie_article['categorie_article_Libelle'] ), true);

            $code_html .= recuperer_gabarit('categorie_article/form_edit_categorie_article_Libelle.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_categorie_article_Libelle')], false, true);

        }

    }
    elseif ($mf_action == 'supprimer_categorie_article') {

        $categorie_article = $db->categorie_article()->mf_get(mf_Code_categorie_article(), ['autocompletion' => true]);
        if (isset($categorie_article['Code_categorie_article'])) {

            $form = new Formulaire('', $mess);
            $form->ajouter_select([0, 1], 'Supprimer', FORM_SUPPR_DEFAUT, true);
            $form->activer_picto_suppression();

            $code_html .= recuperer_gabarit('categorie_article/form_delete_categorie_article.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_delete_categorie_article')], false, true);

        }

    }

