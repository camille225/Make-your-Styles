<?php

    if ($mf_action=='apercu_filtre' || $mf_action<>'' && mf_Code_filtre() != 0)
    {

        $filtre = $table_filtre->mf_get(mf_Code_filtre(), array( 'autocompletion' => true ));

        if (isset($filtre['Code_filtre']))
        {

            $fil_ariane->ajouter_titre(get_titre_ligne_table('filtre', $filtre), get_nom_page_courante().'?act=apercu_filtre&Code_filtre=' . mf_Code_filtre());

            $menu_a_droite->raz_boutons();

            if ( ! MULTI_BLOCS ) { $code_html = ''; }

            include __DIR__ . '/_filtre_get.php';

            $code_html .= recuperer_gabarit('main/section.html', array(
                '{fonction}'  => 'apercu',
                '{nom_table}' => 'filtre',
                '{titre}'     => strip_tags(htmlspecialchars_decode(get_titre_ligne_table('filtre', $filtre)), ''),
                '{contenu}'   => recuperer_gabarit('filtre/bloc_apercu.html', $trans),
            ));

        }

    }
    else
    {

        include __DIR__ . '/_filtre_list.php';

        $code_html .= recuperer_gabarit('main/section.html', array(
            '{fonction}'  => 'lister',
            '{nom_table}' => 'filtre',
            '{titre}'     => htmlspecialchars(get_nom_colonne('libelle_liste_filtre')),
            '{contenu}'   => recuperer_gabarit('filtre/bloc_lister.html', $trans),
        ));

    }

    if ($mf_action=="ajouter_filtre")
    {

        $form = new Formulaire('', $mess);
        $form->ajouter_input("filtre_Libelle", ( isset($_POST['filtre_Libelle']) ? $_POST['filtre_Libelle'] : $mf_initialisation['filtre_Libelle'] ), true);

        $code_html .= recuperer_gabarit('filtre/form_add_filtre.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_add_filtre')), false, true);

    }
    elseif ($mf_action=="modifier_filtre")
    {

        $filtre = $table_filtre->mf_get(mf_Code_filtre(), array( 'autocompletion' => true ));
        if (isset($filtre['Code_filtre']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("filtre_Libelle", ( isset($_POST['filtre_Libelle']) ? $_POST['filtre_Libelle'] : $filtre['filtre_Libelle'] ), true);

            $code_html .= recuperer_gabarit('filtre/form_edit_filtre.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_filtre')), false, true);

        }

    }
    elseif ($mf_action=='modifier_filtre_Libelle')
    {

        $filtre = $table_filtre->mf_get(mf_Code_filtre(), array( 'autocompletion' => true ));
        if (isset($filtre['Code_filtre']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("filtre_Libelle", ( isset($_POST['filtre_Libelle']) ? $_POST['filtre_Libelle'] : $filtre['filtre_Libelle'] ), true);

            $code_html .= recuperer_gabarit('filtre/form_edit_filtre_Libelle.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_filtre_Libelle')), false, true);

        }

    }
    elseif ($mf_action=="supprimer_filtre")
    {

        $filtre = $table_filtre->mf_get(mf_Code_filtre(), array( 'autocompletion' => true ));
        if ( isset($filtre['Code_filtre']) )
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_select(array(0, 1), 'Supprimer', FORM_SUPPR_DEFAUT, true);
            $form->activer_picto_suppression();

            $code_html .= recuperer_gabarit('filtre/form_delete_filtre.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_delete_filtre')), false, true);

        }

    }

