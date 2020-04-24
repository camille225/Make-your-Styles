<?php declare(strict_types=1);

/** @var string $mf_action */
/** @var string $mess */

    if ($mf_action == 'apercu_conseil' || $mf_action <> '' && mf_Code_conseil() != 0) {

        $conseil = $db->conseil()->mf_get(mf_Code_conseil(), ['autocompletion' => true]);

        if (isset($conseil['Code_conseil'])) {

            $fil_ariane->ajouter_titre(get_titre_ligne_table('conseil', $conseil), get_nom_page_courante().'?act=apercu_conseil&Code_conseil=' . $conseil['Code_conseil']);

            $menu_a_droite->raz_boutons();

            if (! MULTI_BLOCS) {
                $code_html = '';
            }

            include __DIR__ . '/_conseil_get.php';

            $code_html .= recuperer_gabarit('main/section.html', [
                '{fonction}'  => 'apercu',
                '{nom_table}' => 'conseil',
                '{titre}'     => strip_tags(htmlspecialchars_decode(get_titre_ligne_table('conseil', $conseil)), ''),
                '{contenu}'   => recuperer_gabarit('conseil/bloc_apercu.html', $trans),
            ]);

        }

    } else {

        include __DIR__ . '/_conseil_list.php';

        $code_html .= recuperer_gabarit('main/section.html', [
            '{fonction}'  => 'lister',
            '{nom_table}' => 'conseil',
            '{titre}'     => htmlspecialchars(get_nom_colonne('libelle_liste_conseil')),
            '{contenu}'   => recuperer_gabarit('conseil/bloc_lister.html', $trans),
        ]);

    }

    if ($mf_action == "ajouter_conseil") {

        $form = new Formulaire('', $mess);
        $form->ajouter_input("conseil_Libelle", ( isset($_POST['conseil_Libelle']) ? $_POST['conseil_Libelle'] : $mf_initialisation['conseil_Libelle'] ), true);
        $form->ajouter_textarea("conseil_Description", ( isset($_POST['conseil_Description']) ? $_POST['conseil_Description'] : $mf_initialisation['conseil_Description'] ), true);
        $form->ajouter_select(lister_cles($lang_standard['conseil_Actif_']), "conseil_Actif", ( isset($_POST['conseil_Actif']) ? $_POST['conseil_Actif'] : $mf_initialisation['conseil_Actif'] ), true);

        $code_html .= recuperer_gabarit('conseil/form_add_conseil.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_add_conseil')], false, true);

    } elseif ($mf_action == "modifier_conseil") {

        $conseil = $db->conseil()->mf_get(mf_Code_conseil(), ['autocompletion' => true]);
        if (isset($conseil['Code_conseil'])) {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("conseil_Libelle", ( isset($_POST['conseil_Libelle']) ? $_POST['conseil_Libelle'] : $conseil['conseil_Libelle'] ), true);
            $form->ajouter_textarea("conseil_Description", ( isset($_POST['conseil_Description']) ? $_POST['conseil_Description'] : $conseil['conseil_Description'] ), true);
            $form->ajouter_select(lister_cles($lang_standard['conseil_Actif_']), "conseil_Actif", ( isset($_POST['conseil_Actif']) ? $_POST['conseil_Actif'] : $conseil['conseil_Actif'] ), true);

            $code_html .= recuperer_gabarit('conseil/form_edit_conseil.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_conseil')], false, true);

        }

    }
    elseif ($mf_action == 'modifier_conseil_Libelle') {

        $conseil = $db->conseil()->mf_get(mf_Code_conseil(), ['autocompletion' => true]);
        if (isset($conseil['Code_conseil'])) {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("conseil_Libelle", ( isset($_POST['conseil_Libelle']) ? $_POST['conseil_Libelle'] : $conseil['conseil_Libelle'] ), true);

            $code_html .= recuperer_gabarit('conseil/form_edit_conseil_Libelle.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_conseil_Libelle')], false, true);

        }

    }
    elseif ($mf_action == 'modifier_conseil_Description') {

        $conseil = $db->conseil()->mf_get(mf_Code_conseil(), ['autocompletion' => true]);
        if (isset($conseil['Code_conseil'])) {

            $form = new Formulaire('', $mess);
            $form->ajouter_textarea("conseil_Description", ( isset($_POST['conseil_Description']) ? $_POST['conseil_Description'] : $conseil['conseil_Description'] ), true);

            $code_html .= recuperer_gabarit('conseil/form_edit_conseil_Description.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_conseil_Description')], false, true);

        }

    }
    elseif ($mf_action == 'modifier_conseil_Actif') {

        $conseil = $db->conseil()->mf_get(mf_Code_conseil(), ['autocompletion' => true]);
        if (isset($conseil['Code_conseil'])) {

            $form = new Formulaire('', $mess);
            $form->ajouter_select(lister_cles($lang_standard['conseil_Actif_']), "conseil_Actif", ( isset($_POST['conseil_Actif']) ? $_POST['conseil_Actif'] : $conseil['conseil_Actif'] ), true);

            $code_html .= recuperer_gabarit('conseil/form_edit_conseil_Actif.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_conseil_Actif')], false, true);

        }

    }
    elseif ($mf_action == 'supprimer_conseil') {

        $conseil = $db->conseil()->mf_get(mf_Code_conseil(), ['autocompletion' => true]);
        if (isset($conseil['Code_conseil'])) {

            $form = new Formulaire('', $mess);
            $form->ajouter_select([0, 1], 'Supprimer', FORM_SUPPR_DEFAUT, true);
            $form->activer_picto_suppression();

            $code_html .= recuperer_gabarit('conseil/form_delete_conseil.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_delete_conseil')], false, true);

        }

    }

