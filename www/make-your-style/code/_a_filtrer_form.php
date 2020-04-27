<?php declare(strict_types=1);

    if ($mf_action == 'apercu_a_filtrer' && $_GET['act'] != 'ajouter_a_filtrer' && $_GET['act'] != 'supprimer_a_filtrer') {

        if (isset($Code_utilisateur) && $Code_utilisateur!=0 && isset($Code_vue_utilisateur) && $Code_vue_utilisateur!=0) {
            $a_filtrer = $db->a_filtrer()->mf_get(mf_Code_utilisateur(), mf_Code_vue_utilisateur(), ['autocompletion' => true]);
        }

        if (isset($a_filtrer['Code_utilisateur'])) {

            $fil_ariane->ajouter_titre(get_titre_ligne_table('a_filtrer', $a_filtrer), get_nom_page_courante().'?act=apercu_a_filtrer&Code_utilisateur='.$Code_utilisateur.'&Code_vue_utilisateur='.$Code_vue_utilisateur.'');

            if (! MULTI_BLOCS) {
                $code_html = '';
            }

            include __DIR__ . '/_a_filtrer_get.php';

            $code_html .= recuperer_gabarit('main/section.html', [
                '{fonction}'  => 'apercu',
                '{nom_table}' => 'a_filtrer',
                '{titre}'     => htmlspecialchars(get_titre_ligne_table('a_filtrer', $a_filtrer)),
                '{contenu}'   => recuperer_gabarit('a_filtrer/bloc_apercu.html', $trans),
            ]);

        }

    } else {

        include __DIR__ . '/_a_filtrer_list.php';

        $code_html .= recuperer_gabarit('main/section.html', [
            '{fonction}'  => 'lister',
            '{nom_table}' => 'a_filtrer',
            '{titre}'     => htmlspecialchars(get_nom_colonne('libelle_liste_a_filtrer')),
            '{contenu}'   => recuperer_gabarit('a_filtrer/bloc_lister.html', $trans),
        ]);

    }

    if ($mf_action == "ajouter_a_filtrer") {

        $form = new Formulaire('', $mess);
        if (!isset($est_charge['utilisateur']))
        {
            $form->ajouter_select(lister_cles($lang_standard['Code_utilisateur_']), "Code_utilisateur", ( isset($_POST['Code_utilisateur']) ? (int) $_POST['Code_utilisateur'] : 0 ), true);
        }
        if (!isset($est_charge['vue_utilisateur']))
        {
            $form->ajouter_select(lister_cles($lang_standard['Code_vue_utilisateur_']), "Code_vue_utilisateur", ( isset($_POST['Code_vue_utilisateur']) ? (int) $_POST['Code_vue_utilisateur'] : 0 ), true);
        }

        $code_html .= recuperer_gabarit('a_filtrer/form_add_a_filtrer.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_add_a_filtrer')], false, true);

    } elseif ($mf_action=="supprimer_a_filtrer")
    {

        $a_filtrer = $db->a_filtrer()->mf_get(mf_Code_utilisateur(), mf_Code_vue_utilisateur(), ['autocompletion' => true]);
        if ( isset($a_filtrer['Code_utilisateur']) )
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_select([0, 1], 'Supprimer', FORM_SUPPR_DEFAUT, true);
            $form->activer_picto_suppression();

            $code_html .= recuperer_gabarit('a_filtrer/form_delete_a_filtrer.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_delete_a_filtrer')], false, true);

        }

    }
