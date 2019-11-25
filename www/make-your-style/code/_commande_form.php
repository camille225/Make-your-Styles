<?php

    if ($mf_action=='apercu_commande' || $mf_action<>'' && mf_Code_commande() != 0)
    {

        $commande = $table_commande->mf_get(mf_Code_commande(), array( 'autocompletion' => true ));

        if (isset($commande['Code_commande']))
        {

            $fil_ariane->ajouter_titre(get_titre_ligne_table('commande', $commande), get_nom_page_courante().'?act=apercu_commande&Code_commande=' . mf_Code_commande());

            $menu_a_droite->raz_boutons();

            if ( ! MULTI_BLOCS ) { $code_html = ''; }

            include __DIR__ . '/_commande_get.php';

            $code_html .= recuperer_gabarit('main/section.html', array(
                '{fonction}'  => 'apercu',
                '{nom_table}' => 'commande',
                '{titre}'     => strip_tags(htmlspecialchars_decode(get_titre_ligne_table('commande', $commande)), ''),
                '{contenu}'   => recuperer_gabarit('commande/bloc_apercu.html', $trans),
            ));

        }

    }
    else
    {

        include __DIR__ . '/_commande_list.php';

        $code_html .= recuperer_gabarit('main/section.html', array(
            '{fonction}'  => 'lister',
            '{nom_table}' => 'commande',
            '{titre}'     => htmlspecialchars(get_nom_colonne('libelle_liste_commande')),
            '{contenu}'   => recuperer_gabarit('commande/bloc_lister.html', $trans),
        ));

    }

    if ($mf_action=="ajouter_commande")
    {

        $form = new Formulaire('', $mess);
        $form->ajouter_input("commande_Prix_total", ( isset($_POST['commande_Prix_total']) ? $_POST['commande_Prix_total'] : $mf_initialisation['commande_Prix_total'] ), true);
        $form->ajouter_input("commande_Date_livraison", ( isset($_POST['commande_Date_livraison']) ? $_POST['commande_Date_livraison'] : $mf_initialisation['commande_Date_livraison'] ), true);
        $form->ajouter_input("commande_Date_creation", ( isset($_POST['commande_Date_creation']) ? $_POST['commande_Date_creation'] : $mf_initialisation['commande_Date_creation'] ), true);
        if (!isset($est_charge['utilisateur']))
        {
            $form->ajouter_select(lister_cles($lang_standard['Code_utilisateur_']), "Code_utilisateur", ( isset($_POST['Code_utilisateur']) ? $_POST['Code_utilisateur'] : 0 ), true);
        }

        $code_html .= recuperer_gabarit('commande/form_add_commande.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_add_commande')), false, true);

    }
    elseif ($mf_action=="modifier_commande")
    {

        $commande = $table_commande->mf_get(mf_Code_commande(), array( 'autocompletion' => true ));
        if (isset($commande['Code_commande']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("commande_Prix_total", ( isset($_POST['commande_Prix_total']) ? $_POST['commande_Prix_total'] : $commande['commande_Prix_total'] ), true);
            $form->ajouter_input("commande_Date_livraison", ( isset($_POST['commande_Date_livraison']) ? $_POST['commande_Date_livraison'] : $commande['commande_Date_livraison'] ), true);
            $form->ajouter_input("commande_Date_creation", ( isset($_POST['commande_Date_creation']) ? $_POST['commande_Date_creation'] : $commande['commande_Date_creation'] ), true);
            if (!isset($est_charge['utilisateur']))
            {
                $form->ajouter_select(lister_cles($lang_standard['Code_utilisateur_']), "Code_utilisateur", ( isset($_POST['Code_utilisateur']) ? $_POST['Code_utilisateur'] : $commande['Code_utilisateur'] ), true);
            }

            $code_html .= recuperer_gabarit('commande/form_edit_commande.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_commande')), false, true);

        }

    }
    elseif ($mf_action=='modifier_commande_Prix_total')
    {

        $commande = $table_commande->mf_get(mf_Code_commande(), array( 'autocompletion' => true ));
        if (isset($commande['Code_commande']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("commande_Prix_total", ( isset($_POST['commande_Prix_total']) ? $_POST['commande_Prix_total'] : $commande['commande_Prix_total'] ), true);

            $code_html .= recuperer_gabarit('commande/form_edit_commande_Prix_total.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_commande_Prix_total')), false, true);

        }

    }
    elseif ($mf_action=='modifier_commande_Date_livraison')
    {

        $commande = $table_commande->mf_get(mf_Code_commande(), array( 'autocompletion' => true ));
        if (isset($commande['Code_commande']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("commande_Date_livraison", ( isset($_POST['commande_Date_livraison']) ? $_POST['commande_Date_livraison'] : $commande['commande_Date_livraison'] ), true);

            $code_html .= recuperer_gabarit('commande/form_edit_commande_Date_livraison.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_commande_Date_livraison')), false, true);

        }

    }
    elseif ($mf_action=='modifier_commande_Date_creation')
    {

        $commande = $table_commande->mf_get(mf_Code_commande(), array( 'autocompletion' => true ));
        if (isset($commande['Code_commande']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("commande_Date_creation", ( isset($_POST['commande_Date_creation']) ? $_POST['commande_Date_creation'] : $commande['commande_Date_creation'] ), true);

            $code_html .= recuperer_gabarit('commande/form_edit_commande_Date_creation.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_commande_Date_creation')), false, true);

        }

    }
    elseif ($mf_action=='modifier_commande__Code_utilisateur')
    {

        $commande = $table_commande->mf_get(mf_Code_commande(), array( 'autocompletion' => true ));
        if (isset($commande['Code_commande']))
        {

            $form = new Formulaire('', $mess);
            if (!isset($est_charge['utilisateur']))
            {
                $form->ajouter_select(lister_cles($lang_standard['Code_utilisateur_']), "Code_utilisateur", ( isset($_POST['Code_utilisateur']) ? $_POST['Code_utilisateur'] : $commande['Code_utilisateur'] ), true);
            }

            $code_html .= recuperer_gabarit('commande/form_edit__Code_utilisateur.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_commande__Code_utilisateur')), false, true);

        }

    }
    elseif ($mf_action=="supprimer_commande")
    {

        $commande = $table_commande->mf_get(mf_Code_commande(), array( 'autocompletion' => true ));
        if ( isset($commande['Code_commande']) )
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_select(array(0, 1), 'Supprimer', FORM_SUPPR_DEFAUT, true);
            $form->activer_picto_suppression();

            $code_html .= recuperer_gabarit('commande/form_delete_commande.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_delete_commande')), false, true);

        }

    }

