<?php

    if ($mf_action=='apercu_a_article_commande' && $_GET['act']!='ajouter_a_article_commande' && $_GET['act']!='supprimer_a_article_commande')
    {

        if (isset($Code_commande) && $Code_commande!=0 && isset($Code_article) && $Code_article!=0)
        {
            $a_article_commande = $table_a_article_commande->mf_get(mf_Code_commande(), mf_Code_article(), array( 'autocompletion' => true ));
        }

        if (isset($a_article_commande['Code_commande']))
        {

            $fil_ariane->ajouter_titre(get_titre_ligne_table('a_article_commande', $a_article_commande), get_nom_page_courante().'?act=apercu_a_article_commande&Code_commande='.$Code_commande.'&Code_article='.$Code_article.'');

            if ( ! MULTI_BLOCS ) { $code_html = ''; }

            include __DIR__ . '/_a_article_commande_get.php';

            $code_html .= recuperer_gabarit('main/section.html', array(
                '{fonction}'  => 'apercu',
                '{nom_table}' => 'a_article_commande',
                '{titre}'     => htmlspecialchars(get_titre_ligne_table('a_article_commande', $a_article_commande)),
                '{contenu}'   => recuperer_gabarit('a_article_commande/bloc_apercu.html', $trans),
            ));

        }

    }
    else
    {

        include __DIR__ . '/_a_article_commande_list.php';

        $code_html .= recuperer_gabarit('main/section.html', array(
            '{fonction}'  => 'lister',
            '{nom_table}' => 'a_article_commande',
            '{titre}'     => htmlspecialchars(get_nom_colonne('libelle_liste_a_article_commande')),
            '{contenu}'   => recuperer_gabarit('a_article_commande/bloc_lister.html', $trans),
        ));

    }

    if ($mf_action=="ajouter_a_article_commande")
    {

        $form = new Formulaire('', $mess);
        if (!isset($est_charge['commande']))
        {
            $form->ajouter_select(lister_cles($lang_standard['Code_commande_']), "Code_commande", ( isset($_POST['Code_commande']) ? $_POST['Code_commande'] : 0 ), true);
        }
        if (!isset($est_charge['article']))
        {
            $form->ajouter_select(lister_cles($lang_standard['Code_article_']), "Code_article", ( isset($_POST['Code_article']) ? $_POST['Code_article'] : 0 ), true);
        }

        $code_html .= recuperer_gabarit('a_article_commande/form_add_a_article_commande.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_add_a_article_commande')), false, true);

    }
    elseif ($mf_action=="supprimer_a_article_commande")
    {

        $a_article_commande = $table_a_article_commande->mf_get(mf_Code_commande(), mf_Code_article(), array( 'autocompletion' => true ));
        if ( isset($a_article_commande['Code_commande']) )
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_select(array(0, 1), 'Supprimer', FORM_SUPPR_DEFAUT, true);
            $form->activer_picto_suppression();

            $code_html .= recuperer_gabarit('a_article_commande/form_delete_a_article_commande.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_delete_a_article_commande')), false, true);

        }

    }
