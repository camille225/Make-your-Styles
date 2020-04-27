<?php declare(strict_types=1);

    if ($mf_action == 'apercu_a_commande_article' && $_GET['act'] != 'ajouter_a_commande_article' && $_GET['act'] != 'supprimer_a_commande_article') {

        if (isset($Code_commande) && $Code_commande!=0 && isset($Code_article) && $Code_article!=0) {
            $a_commande_article = $db->a_commande_article()->mf_get(mf_Code_commande(), mf_Code_article(), ['autocompletion' => true]);
        }

        if (isset($a_commande_article['Code_commande'])) {

            $fil_ariane->ajouter_titre(get_titre_ligne_table('a_commande_article', $a_commande_article), get_nom_page_courante().'?act=apercu_a_commande_article&Code_commande='.$Code_commande.'&Code_article='.$Code_article.'');

            if (! MULTI_BLOCS) {
                $code_html = '';
            }

            include __DIR__ . '/_a_commande_article_get.php';

            $code_html .= recuperer_gabarit('main/section.html', [
                '{fonction}'  => 'apercu',
                '{nom_table}' => 'a_commande_article',
                '{titre}'     => htmlspecialchars(get_titre_ligne_table('a_commande_article', $a_commande_article)),
                '{contenu}'   => recuperer_gabarit('a_commande_article/bloc_apercu.html', $trans),
            ]);

        }

    } else {

        /* debut developpement */
//        include __DIR__ . '/_a_commande_article_list.php';
//
//        $code_html .= recuperer_gabarit('main/section.html', [
//            '{fonction}'  => 'lister',
//            '{nom_table}' => 'a_commande_article',
//            '{titre}'     => htmlspecialchars(get_nom_colonne('libelle_liste_a_commande_article')),
//            '{contenu}'   => recuperer_gabarit('a_commande_article/bloc_lister.html', $trans),
//        ]);
        /* fin developpement */

    }

    if ($mf_action == "ajouter_a_commande_article") {

        $form = new Formulaire('', $mess);
        if (!isset($est_charge['commande']))
        {
            $form->ajouter_select(lister_cles($lang_standard['Code_commande_']), "Code_commande", ( isset($_POST['Code_commande']) ? (int) $_POST['Code_commande'] : 0 ), true);
        }
        if (!isset($est_charge['article']))
        {
            $form->ajouter_select(lister_cles($lang_standard['Code_article_']), "Code_article", ( isset($_POST['Code_article']) ? (int) $_POST['Code_article'] : 0 ), true);
        }
        $form->ajouter_input("a_commande_article_Quantite", ( isset($_POST['a_commande_article_Quantite']) ? $_POST['a_commande_article_Quantite'] : $mf_initialisation['a_commande_article_Quantite'] ), true);
        /* debut developpement */
//        $form->ajouter_input("a_commande_article_Prix_ligne", ( isset($_POST['a_commande_article_Prix_ligne']) ? $_POST['a_commande_article_Prix_ligne'] : $mf_initialisation['a_commande_article_Prix_ligne'] ), true);
        /* fin developpement */

        $code_html .= recuperer_gabarit('a_commande_article/form_add_a_commande_article.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_add_a_commande_article')], false, true);

    } elseif ($mf_action=="modifier_a_commande_article") {

        $a_commande_article = $db->a_commande_article()->mf_get(mf_Code_commande(), mf_Code_article(), ['autocompletion' => true]);
        if (isset($a_commande_article['Code_commande']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("a_commande_article_Quantite", ( isset($_POST['a_commande_article_Quantite']) ? $_POST['a_commande_article_Quantite'] : $a_commande_article['a_commande_article_Quantite'] ), true);
            $form->ajouter_input("a_commande_article_Prix_ligne", ( isset($_POST['a_commande_article_Prix_ligne']) ? $_POST['a_commande_article_Prix_ligne'] : $a_commande_article['a_commande_article_Prix_ligne'] ), true);

            $code_html .= recuperer_gabarit('a_commande_article/form_edit_a_commande_article.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_a_commande_article')], false, true);

        }
    } elseif ($mf_action=='modifier_a_commande_article_Quantite')
    {

        $a_commande_article = $db->a_commande_article()->mf_get(mf_Code_commande(), mf_Code_article(), ['autocompletion' => true]);
        if (isset($a_commande_article['Code_commande']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("a_commande_article_Quantite", ( isset($_POST['a_commande_article_Quantite']) ? $_POST['a_commande_article_Quantite'] : $a_commande_article['a_commande_article_Quantite'] ), true);

            $code_html .= recuperer_gabarit('a_commande_article/form_edit_a_commande_article_Quantite.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_a_commande_article_Quantite')], false, true);

        }
    } elseif ($mf_action=='modifier_a_commande_article_Prix_ligne')
    {

        $a_commande_article = $db->a_commande_article()->mf_get(mf_Code_commande(), mf_Code_article(), ['autocompletion' => true]);
        if (isset($a_commande_article['Code_commande']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("a_commande_article_Prix_ligne", ( isset($_POST['a_commande_article_Prix_ligne']) ? $_POST['a_commande_article_Prix_ligne'] : $a_commande_article['a_commande_article_Prix_ligne'] ), true);

            $code_html .= recuperer_gabarit('a_commande_article/form_edit_a_commande_article_Prix_ligne.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_a_commande_article_Prix_ligne')], false, true);

        }
    } elseif ($mf_action=="supprimer_a_commande_article")
    {

        $a_commande_article = $db->a_commande_article()->mf_get(mf_Code_commande(), mf_Code_article(), ['autocompletion' => true]);
        if ( isset($a_commande_article['Code_commande']) )
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_select([0, 1], 'Supprimer', FORM_SUPPR_DEFAUT, true);
            $form->activer_picto_suppression();

            $code_html .= recuperer_gabarit('a_commande_article/form_delete_a_commande_article.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_delete_a_commande_article')], false, true);

        }

    }
