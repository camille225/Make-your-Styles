<?php declare(strict_types=1);

/** @var string $mf_action */
/** @var string $mess */

    if ($mf_action == 'apercu_parametre' || $mf_action <> '' && mf_Code_parametre() != 0) {

        $parametre = $db->parametre()->mf_get(mf_Code_parametre(), ['autocompletion' => true]);

        if (isset($parametre['Code_parametre'])) {

            $fil_ariane->ajouter_titre(get_titre_ligne_table('parametre', $parametre), get_nom_page_courante().'?act=apercu_parametre&Code_parametre=' . $parametre['Code_parametre']);

            $menu_a_droite->raz_boutons();

            if (! MULTI_BLOCS) {
                $code_html = '';
            }

            include __DIR__ . '/_parametre_get.php';

            $code_html .= recuperer_gabarit('main/section.html', [
                '{fonction}'  => 'apercu',
                '{nom_table}' => 'parametre',
                '{titre}'     => strip_tags(htmlspecialchars_decode(get_titre_ligne_table('parametre', $parametre)), ''),
                '{contenu}'   => recuperer_gabarit('parametre/bloc_apercu.html', $trans),
            ]);

        }

    } else {

        include __DIR__ . '/_parametre_list.php';

        $code_html .= recuperer_gabarit('main/section.html', [
            '{fonction}'  => 'lister',
            '{nom_table}' => 'parametre',
            '{titre}'     => htmlspecialchars(get_nom_colonne('libelle_liste_parametre')),
            '{contenu}'   => recuperer_gabarit('parametre/bloc_lister.html', $trans),
        ]);

    }

    if ($mf_action == "ajouter_parametre") {

        $form = new Formulaire('', $mess);
        $form->ajouter_input("parametre_Libelle", ( isset($_POST['parametre_Libelle']) ? $_POST['parametre_Libelle'] : $mf_initialisation['parametre_Libelle'] ), true);

        $code_html .= recuperer_gabarit('parametre/form_add_parametre.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_add_parametre')], false, true);

    } elseif ($mf_action == "modifier_parametre") {

        $parametre = $db->parametre()->mf_get(mf_Code_parametre(), ['autocompletion' => true]);
        if (isset($parametre['Code_parametre'])) {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("parametre_Libelle", ( isset($_POST['parametre_Libelle']) ? $_POST['parametre_Libelle'] : $parametre['parametre_Libelle'] ), true);

            $code_html .= recuperer_gabarit('parametre/form_edit_parametre.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_parametre')], false, true);

        }

    }
    elseif ($mf_action == 'modifier_parametre_Libelle') {

        $parametre = $db->parametre()->mf_get(mf_Code_parametre(), ['autocompletion' => true]);
        if (isset($parametre['Code_parametre'])) {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("parametre_Libelle", ( isset($_POST['parametre_Libelle']) ? $_POST['parametre_Libelle'] : $parametre['parametre_Libelle'] ), true);

            $code_html .= recuperer_gabarit('parametre/form_edit_parametre_Libelle.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_parametre_Libelle')], false, true);

        }

    }
    elseif ($mf_action == 'supprimer_parametre') {

        $parametre = $db->parametre()->mf_get(mf_Code_parametre(), ['autocompletion' => true]);
        if (isset($parametre['Code_parametre'])) {

            $form = new Formulaire('', $mess);
            $form->ajouter_select([0, 1], 'Supprimer', FORM_SUPPR_DEFAUT, true);
            $form->activer_picto_suppression();

            $code_html .= recuperer_gabarit('parametre/form_delete_parametre.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_delete_parametre')], false, true);

        }

    }

