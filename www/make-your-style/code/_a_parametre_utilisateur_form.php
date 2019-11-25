<?php

    if ($mf_action=='apercu_a_parametre_utilisateur' && $_GET['act']!='ajouter_a_parametre_utilisateur' && $_GET['act']!='supprimer_a_parametre_utilisateur')
    {

        if (isset($Code_utilisateur) && $Code_utilisateur!=0 && isset($Code_parametre) && $Code_parametre!=0)
        {
            $a_parametre_utilisateur = $table_a_parametre_utilisateur->mf_get(mf_Code_utilisateur(), mf_Code_parametre(), array( 'autocompletion' => true ));
        }

        if (isset($a_parametre_utilisateur['Code_utilisateur']))
        {

            $fil_ariane->ajouter_titre(get_titre_ligne_table('a_parametre_utilisateur', $a_parametre_utilisateur), get_nom_page_courante().'?act=apercu_a_parametre_utilisateur&Code_utilisateur='.$Code_utilisateur.'&Code_parametre='.$Code_parametre.'');

            if ( ! MULTI_BLOCS ) { $code_html = ''; }

            include __DIR__ . '/_a_parametre_utilisateur_get.php';

            $code_html .= recuperer_gabarit('main/section.html', array(
                '{fonction}'  => 'apercu',
                '{nom_table}' => 'a_parametre_utilisateur',
                '{titre}'     => htmlspecialchars(get_titre_ligne_table('a_parametre_utilisateur', $a_parametre_utilisateur)),
                '{contenu}'   => recuperer_gabarit('a_parametre_utilisateur/bloc_apercu.html', $trans),
            ));

        }

    }
    else
    {

        include __DIR__ . '/_a_parametre_utilisateur_list.php';

        $code_html .= recuperer_gabarit('main/section.html', array(
            '{fonction}'  => 'lister',
            '{nom_table}' => 'a_parametre_utilisateur',
            '{titre}'     => htmlspecialchars(get_nom_colonne('libelle_liste_a_parametre_utilisateur')),
            '{contenu}'   => recuperer_gabarit('a_parametre_utilisateur/bloc_lister.html', $trans),
        ));

    }

    if ($mf_action=="ajouter_a_parametre_utilisateur")
    {

        $form = new Formulaire('', $mess);
        if (!isset($est_charge['utilisateur']))
        {
            $form->ajouter_select(lister_cles($lang_standard['Code_utilisateur_']), "Code_utilisateur", ( isset($_POST['Code_utilisateur']) ? $_POST['Code_utilisateur'] : 0 ), true);
        }
        if (!isset($est_charge['parametre']))
        {
            $form->ajouter_select(lister_cles($lang_standard['Code_parametre_']), "Code_parametre", ( isset($_POST['Code_parametre']) ? $_POST['Code_parametre'] : 0 ), true);
        }
        $form->ajouter_input("a_parametre_utilisateur_Valeur", ( isset($_POST['a_parametre_utilisateur_Valeur']) ? $_POST['a_parametre_utilisateur_Valeur'] : $mf_initialisation['a_parametre_utilisateur_Valeur'] ), true);
        $form->ajouter_input("a_parametre_utilisateur_Actif", ( isset($_POST['a_parametre_utilisateur_Actif']) ? $_POST['a_parametre_utilisateur_Actif'] : $mf_initialisation['a_parametre_utilisateur_Actif'] ), true);

        $code_html .= recuperer_gabarit('a_parametre_utilisateur/form_add_a_parametre_utilisateur.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_add_a_parametre_utilisateur')), false, true);

    }
    elseif ($mf_action=="modifier_a_parametre_utilisateur")
    {

        $a_parametre_utilisateur = $table_a_parametre_utilisateur->mf_get(mf_Code_utilisateur(), mf_Code_parametre(), array( 'autocompletion' => true ));
        if (isset($a_parametre_utilisateur['Code_utilisateur']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("a_parametre_utilisateur_Valeur", ( isset($_POST['a_parametre_utilisateur_Valeur']) ? $_POST['a_parametre_utilisateur_Valeur'] : $a_parametre_utilisateur['a_parametre_utilisateur_Valeur'] ), true);
            $form->ajouter_input("a_parametre_utilisateur_Actif", ( isset($_POST['a_parametre_utilisateur_Actif']) ? $_POST['a_parametre_utilisateur_Actif'] : $a_parametre_utilisateur['a_parametre_utilisateur_Actif'] ), true);

            $code_html .= recuperer_gabarit('a_parametre_utilisateur/form_edit_a_parametre_utilisateur.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_a_parametre_utilisateur')), false, true);

        }

    }
    elseif ($mf_action=='modifier_a_parametre_utilisateur_Valeur')
    {

        $a_parametre_utilisateur = $table_a_parametre_utilisateur->mf_get(mf_Code_utilisateur(), mf_Code_parametre(), array( 'autocompletion' => true ));
        if (isset($a_parametre_utilisateur['Code_utilisateur']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("a_parametre_utilisateur_Valeur", ( isset($_POST['a_parametre_utilisateur_Valeur']) ? $_POST['a_parametre_utilisateur_Valeur'] : $a_parametre_utilisateur['a_parametre_utilisateur_Valeur'] ), true);

            $code_html .= recuperer_gabarit('a_parametre_utilisateur/form_edit_a_parametre_utilisateur_Valeur.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_a_parametre_utilisateur_Valeur')), false, true);

        }

    }
    elseif ($mf_action=='modifier_a_parametre_utilisateur_Actif')
    {

        $a_parametre_utilisateur = $table_a_parametre_utilisateur->mf_get(mf_Code_utilisateur(), mf_Code_parametre(), array( 'autocompletion' => true ));
        if (isset($a_parametre_utilisateur['Code_utilisateur']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("a_parametre_utilisateur_Actif", ( isset($_POST['a_parametre_utilisateur_Actif']) ? $_POST['a_parametre_utilisateur_Actif'] : $a_parametre_utilisateur['a_parametre_utilisateur_Actif'] ), true);

            $code_html .= recuperer_gabarit('a_parametre_utilisateur/form_edit_a_parametre_utilisateur_Actif.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_a_parametre_utilisateur_Actif')), false, true);

        }

    }
    elseif ($mf_action=="supprimer_a_parametre_utilisateur")
    {

        $a_parametre_utilisateur = $table_a_parametre_utilisateur->mf_get(mf_Code_utilisateur(), mf_Code_parametre(), array( 'autocompletion' => true ));
        if ( isset($a_parametre_utilisateur['Code_utilisateur']) )
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_select(array(0, 1), 'Supprimer', FORM_SUPPR_DEFAUT, true);
            $form->activer_picto_suppression();

            $code_html .= recuperer_gabarit('a_parametre_utilisateur/form_delete_a_parametre_utilisateur.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_delete_a_parametre_utilisateur')), false, true);

        }

    }
