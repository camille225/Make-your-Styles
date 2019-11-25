<?php

    if ($mf_action=='apercu_article' || $mf_action<>'' && mf_Code_article() != 0)
    {

        $article = $table_article->mf_get(mf_Code_article(), array( 'autocompletion' => true ));

        if (isset($article['Code_article']))
        {

            $fil_ariane->ajouter_titre(get_titre_ligne_table('article', $article), get_nom_page_courante().'?act=apercu_article&Code_article=' . mf_Code_article());

            $menu_a_droite->raz_boutons();

            if ( ! MULTI_BLOCS ) { $code_html = ''; }

            include __DIR__ . '/_article_get.php';

            $code_html .= recuperer_gabarit('main/section.html', array(
                '{fonction}'  => 'apercu',
                '{nom_table}' => 'article',
                '{titre}'     => strip_tags(htmlspecialchars_decode(get_titre_ligne_table('article', $article)), ''),
                '{contenu}'   => recuperer_gabarit('article/bloc_apercu.html', $trans),
            ));

        }

    }
    else
    {

        include __DIR__ . '/_article_list.php';

        $code_html .= recuperer_gabarit('main/section.html', array(
            '{fonction}'  => 'lister',
            '{nom_table}' => 'article',
            '{titre}'     => htmlspecialchars(get_nom_colonne('libelle_liste_article')),
            '{contenu}'   => recuperer_gabarit('article/bloc_lister.html', $trans),
        ));

    }

    if ($mf_action=="ajouter_article")
    {

        $form = new Formulaire('', $mess);
        $form->ajouter_input("article_Libelle", ( isset($_POST['article_Libelle']) ? $_POST['article_Libelle'] : $mf_initialisation['article_Libelle'] ), true);
        $form->ajouter_input("article_Photo_Fichier", ( isset($_POST['article_Photo_Fichier']) ? $_POST['article_Photo_Fichier'] : "" ), true, "file");
        $form->ajouter_input("article_Prix", ( isset($_POST['article_Prix']) ? $_POST['article_Prix'] : $mf_initialisation['article_Prix'] ), true);
        $form->ajouter_select(lister_cles($lang_standard['article_Actif_']), "article_Actif", ( isset($_POST['article_Actif']) ? $_POST['article_Actif'] : $mf_initialisation['article_Actif'] ), true);
        if (!isset($est_charge['type_produit']))
        {
            $form->ajouter_select(lister_cles($lang_standard['Code_type_produit_']), "Code_type_produit", ( isset($_POST['Code_type_produit']) ? $_POST['Code_type_produit'] : 0 ), true);
        }

        $code_html .= recuperer_gabarit('article/form_add_article.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_add_article')), false, true);

    }
    elseif ($mf_action=="modifier_article")
    {

        $article = $table_article->mf_get(mf_Code_article(), array( 'autocompletion' => true ));
        if (isset($article['Code_article']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("article_Libelle", ( isset($_POST['article_Libelle']) ? $_POST['article_Libelle'] : $article['article_Libelle'] ), true);
            $form->ajouter_input("article_Photo_Fichier", ( isset($_POST['article_Photo_Fichier']) ? $_POST['article_Photo_Fichier'] : "" ), true, "file");
            $form->ajouter_input("article_Prix", ( isset($_POST['article_Prix']) ? $_POST['article_Prix'] : $article['article_Prix'] ), true);
            $form->ajouter_select(lister_cles($lang_standard['article_Actif_']), "article_Actif", ( isset($_POST['article_Actif']) ? $_POST['article_Actif'] : $article['article_Actif'] ), true);
            if (!isset($est_charge['type_produit']))
            {
                $form->ajouter_select(lister_cles($lang_standard['Code_type_produit_']), "Code_type_produit", ( isset($_POST['Code_type_produit']) ? $_POST['Code_type_produit'] : $article['Code_type_produit'] ), true);
            }

            $code_html .= recuperer_gabarit('article/form_edit_article.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_article')), false, true);

        }

    }
    elseif ($mf_action=='modifier_article_Libelle')
    {

        $article = $table_article->mf_get(mf_Code_article(), array( 'autocompletion' => true ));
        if (isset($article['Code_article']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("article_Libelle", ( isset($_POST['article_Libelle']) ? $_POST['article_Libelle'] : $article['article_Libelle'] ), true);

            $code_html .= recuperer_gabarit('article/form_edit_article_Libelle.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_article_Libelle')), false, true);

        }

    }
    elseif ($mf_action=='modifier_article_Photo_Fichier')
    {

        $article = $table_article->mf_get(mf_Code_article(), array( 'autocompletion' => true ));
        if (isset($article['Code_article']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("article_Photo_Fichier", ( isset($_POST['article_Photo_Fichier']) ? $_POST['article_Photo_Fichier'] : "" ), true, "file");

            $code_html .= recuperer_gabarit('article/form_edit_article_Photo_Fichier.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_article_Photo_Fichier')), false, true);

        }

    }
    elseif ($mf_action=='modifier_article_Prix')
    {

        $article = $table_article->mf_get(mf_Code_article(), array( 'autocompletion' => true ));
        if (isset($article['Code_article']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("article_Prix", ( isset($_POST['article_Prix']) ? $_POST['article_Prix'] : $article['article_Prix'] ), true);

            $code_html .= recuperer_gabarit('article/form_edit_article_Prix.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_article_Prix')), false, true);

        }

    }
    elseif ($mf_action=='modifier_article_Actif')
    {

        $article = $table_article->mf_get(mf_Code_article(), array( 'autocompletion' => true ));
        if (isset($article['Code_article']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_select(lister_cles($lang_standard['article_Actif_']), "article_Actif", ( isset($_POST['article_Actif']) ? $_POST['article_Actif'] : $article['article_Actif'] ), true);

            $code_html .= recuperer_gabarit('article/form_edit_article_Actif.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_article_Actif')), false, true);

        }

    }
    elseif ($mf_action=='modifier_article__Code_type_produit')
    {

        $article = $table_article->mf_get(mf_Code_article(), array( 'autocompletion' => true ));
        if (isset($article['Code_article']))
        {

            $form = new Formulaire('', $mess);
            if (!isset($est_charge['type_produit']))
            {
                $form->ajouter_select(lister_cles($lang_standard['Code_type_produit_']), "Code_type_produit", ( isset($_POST['Code_type_produit']) ? $_POST['Code_type_produit'] : $article['Code_type_produit'] ), true);
            }

            $code_html .= recuperer_gabarit('article/form_edit__Code_type_produit.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_article__Code_type_produit')), false, true);

        }

    }
    elseif ($mf_action=="supprimer_article")
    {

        $article = $table_article->mf_get(mf_Code_article(), array( 'autocompletion' => true ));
        if ( isset($article['Code_article']) )
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_select(array(0, 1), 'Supprimer', FORM_SUPPR_DEFAUT, true);
            $form->activer_picto_suppression();

            $code_html .= recuperer_gabarit('article/form_delete_article.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_delete_article')), false, true);

        }

    }

