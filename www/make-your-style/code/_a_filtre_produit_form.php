<?php

    if ($mf_action=='apercu_a_filtre_produit' && $_GET['act']!='ajouter_a_filtre_produit' && $_GET['act']!='supprimer_a_filtre_produit')
    {

        if (isset($Code_filtre) && $Code_filtre!=0 && isset($Code_article) && $Code_article!=0)
        {
            $a_filtre_produit = $table_a_filtre_produit->mf_get(mf_Code_filtre(), mf_Code_article(), array( 'autocompletion' => true ));
        }

        if (isset($a_filtre_produit['Code_filtre']))
        {

            $fil_ariane->ajouter_titre(get_titre_ligne_table('a_filtre_produit', $a_filtre_produit), get_nom_page_courante().'?act=apercu_a_filtre_produit&Code_filtre='.$Code_filtre.'&Code_article='.$Code_article.'');

            if ( ! MULTI_BLOCS ) { $code_html = ''; }

            include __DIR__ . '/_a_filtre_produit_get.php';

            $code_html .= recuperer_gabarit('main/section.html', array(
                '{fonction}'  => 'apercu',
                '{nom_table}' => 'a_filtre_produit',
                '{titre}'     => htmlspecialchars(get_titre_ligne_table('a_filtre_produit', $a_filtre_produit)),
                '{contenu}'   => recuperer_gabarit('a_filtre_produit/bloc_apercu.html', $trans),
            ));

        }

    }
    else
    {

        include __DIR__ . '/_a_filtre_produit_list.php';

        $code_html .= recuperer_gabarit('main/section.html', array(
            '{fonction}'  => 'lister',
            '{nom_table}' => 'a_filtre_produit',
            '{titre}'     => htmlspecialchars(get_nom_colonne('libelle_liste_a_filtre_produit')),
            '{contenu}'   => recuperer_gabarit('a_filtre_produit/bloc_lister.html', $trans),
        ));

    }

    if ($mf_action=="ajouter_a_filtre_produit")
    {

        $form = new Formulaire('', $mess);
        if (!isset($est_charge['filtre']))
        {
            $form->ajouter_select(lister_cles($lang_standard['Code_filtre_']), "Code_filtre", ( isset($_POST['Code_filtre']) ? $_POST['Code_filtre'] : 0 ), true);
        }
        if (!isset($est_charge['article']))
        {
            $form->ajouter_select(lister_cles($lang_standard['Code_article_']), "Code_article", ( isset($_POST['Code_article']) ? $_POST['Code_article'] : 0 ), true);
        }
        $form->ajouter_input("a_filtre_produit_Actif", ( isset($_POST['a_filtre_produit_Actif']) ? $_POST['a_filtre_produit_Actif'] : $mf_initialisation['a_filtre_produit_Actif'] ), true);

        $code_html .= recuperer_gabarit('a_filtre_produit/form_add_a_filtre_produit.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_add_a_filtre_produit')), false, true);

    }
    elseif ($mf_action=="modifier_a_filtre_produit")
    {

        $a_filtre_produit = $table_a_filtre_produit->mf_get(mf_Code_filtre(), mf_Code_article(), array( 'autocompletion' => true ));
        if (isset($a_filtre_produit['Code_filtre']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("a_filtre_produit_Actif", ( isset($_POST['a_filtre_produit_Actif']) ? $_POST['a_filtre_produit_Actif'] : $a_filtre_produit['a_filtre_produit_Actif'] ), true);

            $code_html .= recuperer_gabarit('a_filtre_produit/form_edit_a_filtre_produit.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_a_filtre_produit')), false, true);

        }

    }
    elseif ($mf_action=='modifier_a_filtre_produit_Actif')
    {

        $a_filtre_produit = $table_a_filtre_produit->mf_get(mf_Code_filtre(), mf_Code_article(), array( 'autocompletion' => true ));
        if (isset($a_filtre_produit['Code_filtre']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("a_filtre_produit_Actif", ( isset($_POST['a_filtre_produit_Actif']) ? $_POST['a_filtre_produit_Actif'] : $a_filtre_produit['a_filtre_produit_Actif'] ), true);

            $code_html .= recuperer_gabarit('a_filtre_produit/form_edit_a_filtre_produit_Actif.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_a_filtre_produit_Actif')), false, true);

        }

    }
    elseif ($mf_action=="supprimer_a_filtre_produit")
    {

        $a_filtre_produit = $table_a_filtre_produit->mf_get(mf_Code_filtre(), mf_Code_article(), array( 'autocompletion' => true ));
        if ( isset($a_filtre_produit['Code_filtre']) )
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_select(array(0, 1), 'Supprimer', FORM_SUPPR_DEFAUT, true);
            $form->activer_picto_suppression();

            $code_html .= recuperer_gabarit('a_filtre_produit/form_delete_a_filtre_produit.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_delete_a_filtre_produit')), false, true);

        }

    }
