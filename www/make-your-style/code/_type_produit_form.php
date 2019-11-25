<?php

    if ($mf_action=='apercu_type_produit' || $mf_action<>'' && mf_Code_type_produit() != 0)
    {

        $type_produit = $table_type_produit->mf_get(mf_Code_type_produit(), array( 'autocompletion' => true ));

        if (isset($type_produit['Code_type_produit']))
        {

            $fil_ariane->ajouter_titre(get_titre_ligne_table('type_produit', $type_produit), get_nom_page_courante().'?act=apercu_type_produit&Code_type_produit=' . mf_Code_type_produit());

            $menu_a_droite->raz_boutons();

            if ( ! MULTI_BLOCS ) { $code_html = ''; }

            include __DIR__ . '/_type_produit_get.php';

            $code_html .= recuperer_gabarit('main/section.html', array(
                '{fonction}'  => 'apercu',
                '{nom_table}' => 'type_produit',
                '{titre}'     => strip_tags(htmlspecialchars_decode(get_titre_ligne_table('type_produit', $type_produit)), ''),
                '{contenu}'   => recuperer_gabarit('type_produit/bloc_apercu.html', $trans),
            ));

        }

    }
    else
    {

        include __DIR__ . '/_type_produit_list.php';

        $code_html .= recuperer_gabarit('main/section.html', array(
            '{fonction}'  => 'lister',
            '{nom_table}' => 'type_produit',
            '{titre}'     => htmlspecialchars(get_nom_colonne('libelle_liste_type_produit')),
            '{contenu}'   => recuperer_gabarit('type_produit/bloc_lister.html', $trans),
        ));

    }

    if ($mf_action=="ajouter_type_produit")
    {

        $form = new Formulaire('', $mess);
        $form->ajouter_input("type_produit_Libelle", ( isset($_POST['type_produit_Libelle']) ? $_POST['type_produit_Libelle'] : $mf_initialisation['type_produit_Libelle'] ), true);

        $code_html .= recuperer_gabarit('type_produit/form_add_type_produit.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_add_type_produit')), false, true);

    }
    elseif ($mf_action=="modifier_type_produit")
    {

        $type_produit = $table_type_produit->mf_get(mf_Code_type_produit(), array( 'autocompletion' => true ));
        if (isset($type_produit['Code_type_produit']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("type_produit_Libelle", ( isset($_POST['type_produit_Libelle']) ? $_POST['type_produit_Libelle'] : $type_produit['type_produit_Libelle'] ), true);

            $code_html .= recuperer_gabarit('type_produit/form_edit_type_produit.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_type_produit')), false, true);

        }

    }
    elseif ($mf_action=='modifier_type_produit_Libelle')
    {

        $type_produit = $table_type_produit->mf_get(mf_Code_type_produit(), array( 'autocompletion' => true ));
        if (isset($type_produit['Code_type_produit']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("type_produit_Libelle", ( isset($_POST['type_produit_Libelle']) ? $_POST['type_produit_Libelle'] : $type_produit['type_produit_Libelle'] ), true);

            $code_html .= recuperer_gabarit('type_produit/form_edit_type_produit_Libelle.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_type_produit_Libelle')), false, true);

        }

    }
    elseif ($mf_action=="supprimer_type_produit")
    {

        $type_produit = $table_type_produit->mf_get(mf_Code_type_produit(), array( 'autocompletion' => true ));
        if ( isset($type_produit['Code_type_produit']) )
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_select(array(0, 1), 'Supprimer', FORM_SUPPR_DEFAUT, true);
            $form->activer_picto_suppression();

            $code_html .= recuperer_gabarit('type_produit/form_delete_type_produit.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_delete_type_produit')), false, true);

        }

    }

