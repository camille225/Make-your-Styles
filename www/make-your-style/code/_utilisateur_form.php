<?php

    if ($mf_action=='apercu_utilisateur' || $mf_action<>'' && mf_Code_utilisateur() != 0)
    {

        $utilisateur = $table_utilisateur->mf_get(mf_Code_utilisateur(), array( 'autocompletion' => true ));

        if (isset($utilisateur['Code_utilisateur']))
        {

            $fil_ariane->ajouter_titre(get_titre_ligne_table('utilisateur', $utilisateur), get_nom_page_courante().'?act=apercu_utilisateur&Code_utilisateur=' . mf_Code_utilisateur());

            $menu_a_droite->raz_boutons();

            if ( ! MULTI_BLOCS ) { $code_html = ''; }

            include __DIR__ . '/_utilisateur_get.php';

            $code_html .= recuperer_gabarit('main/section.html', array(
                '{fonction}'  => 'apercu',
                '{nom_table}' => 'utilisateur',
                '{titre}'     => strip_tags(htmlspecialchars_decode(get_titre_ligne_table('utilisateur', $utilisateur)), ''),
                '{contenu}'   => recuperer_gabarit('utilisateur/bloc_apercu.html', $trans),
            ));

        }

    }
    else
    {

        include __DIR__ . '/_utilisateur_list.php';

        $code_html .= recuperer_gabarit('main/section.html', array(
            '{fonction}'  => 'lister',
            '{nom_table}' => 'utilisateur',
            '{titre}'     => htmlspecialchars(get_nom_colonne('libelle_liste_utilisateur')),
            '{contenu}'   => recuperer_gabarit('utilisateur/bloc_lister.html', $trans),
        ));

    }

    if ($mf_action=="ajouter_utilisateur")
    {

        $form = new Formulaire('', $mess);
        $form->ajouter_input("utilisateur_Identifiant", ( isset($_POST['utilisateur_Identifiant']) ? $_POST['utilisateur_Identifiant'] : $mf_initialisation['utilisateur_Identifiant'] ), true);
        $form->ajouter_input("utilisateur_Password", ( isset($_POST['utilisateur_Password']) ? $_POST['utilisateur_Password'] : $mf_initialisation['utilisateur_Password'] ), true);
        $form->ajouter_input("utilisateur_Email", ( isset($_POST['utilisateur_Email']) ? $_POST['utilisateur_Email'] : $mf_initialisation['utilisateur_Email'] ), true);
        $form->ajouter_select(lister_cles($lang_standard['utilisateur_Administrateur_']), "utilisateur_Administrateur", ( isset($_POST['utilisateur_Administrateur']) ? $_POST['utilisateur_Administrateur'] : $mf_initialisation['utilisateur_Administrateur'] ), true);
        $form->ajouter_select(lister_cles($lang_standard['utilisateur_Developpeur_']), "utilisateur_Developpeur", ( isset($_POST['utilisateur_Developpeur']) ? $_POST['utilisateur_Developpeur'] : $mf_initialisation['utilisateur_Developpeur'] ), true);

        $code_html .= recuperer_gabarit('utilisateur/form_add_utilisateur.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_add_utilisateur')), false, true);

    }
    elseif ($mf_action=="modifier_utilisateur")
    {

        $utilisateur = $table_utilisateur->mf_get(mf_Code_utilisateur(), array( 'autocompletion' => true ));
        if (isset($utilisateur['Code_utilisateur']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("utilisateur_Identifiant", ( isset($_POST['utilisateur_Identifiant']) ? $_POST['utilisateur_Identifiant'] : $utilisateur['utilisateur_Identifiant'] ), true);
            // $form->ajouter_input("utilisateur_Password", "", true);
            $form->ajouter_input("utilisateur_Email", ( isset($_POST['utilisateur_Email']) ? $_POST['utilisateur_Email'] : $utilisateur['utilisateur_Email'] ), true);
            $form->ajouter_select(lister_cles($lang_standard['utilisateur_Administrateur_']), "utilisateur_Administrateur", ( isset($_POST['utilisateur_Administrateur']) ? $_POST['utilisateur_Administrateur'] : $utilisateur['utilisateur_Administrateur'] ), true);
            $form->ajouter_select(lister_cles($lang_standard['utilisateur_Developpeur_']), "utilisateur_Developpeur", ( isset($_POST['utilisateur_Developpeur']) ? $_POST['utilisateur_Developpeur'] : $utilisateur['utilisateur_Developpeur'] ), true);

            $code_html .= recuperer_gabarit('utilisateur/form_edit_utilisateur.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_utilisateur')), false, true);

        }

    }
    elseif ($mf_action=='modifier_utilisateur_Identifiant')
    {

        $utilisateur = $table_utilisateur->mf_get(mf_Code_utilisateur(), array( 'autocompletion' => true ));
        if (isset($utilisateur['Code_utilisateur']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("utilisateur_Identifiant", ( isset($_POST['utilisateur_Identifiant']) ? $_POST['utilisateur_Identifiant'] : $utilisateur['utilisateur_Identifiant'] ), true);

            $code_html .= recuperer_gabarit('utilisateur/form_edit_utilisateur_Identifiant.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_utilisateur_Identifiant')), false, true);

        }

    }
    elseif ($mf_action=='modifier_utilisateur_Password')
    {

        $utilisateur = $table_utilisateur->mf_get(mf_Code_utilisateur(), array( 'autocompletion' => true ));
        if (isset($utilisateur['Code_utilisateur']))
        {

            $form = new Formulaire('', $mess);
            // $form->ajouter_input("utilisateur_Password", "", true);

            $code_html .= recuperer_gabarit('utilisateur/form_edit_utilisateur_Password.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_utilisateur_Password')), false, true);

        }

    }
    elseif ($mf_action=='modifier_utilisateur_Email')
    {

        $utilisateur = $table_utilisateur->mf_get(mf_Code_utilisateur(), array( 'autocompletion' => true ));
        if (isset($utilisateur['Code_utilisateur']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("utilisateur_Email", ( isset($_POST['utilisateur_Email']) ? $_POST['utilisateur_Email'] : $utilisateur['utilisateur_Email'] ), true);

            $code_html .= recuperer_gabarit('utilisateur/form_edit_utilisateur_Email.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_utilisateur_Email')), false, true);

        }

    }
    elseif ($mf_action=='modifier_utilisateur_Administrateur')
    {

        $utilisateur = $table_utilisateur->mf_get(mf_Code_utilisateur(), array( 'autocompletion' => true ));
        if (isset($utilisateur['Code_utilisateur']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_select(lister_cles($lang_standard['utilisateur_Administrateur_']), "utilisateur_Administrateur", ( isset($_POST['utilisateur_Administrateur']) ? $_POST['utilisateur_Administrateur'] : $utilisateur['utilisateur_Administrateur'] ), true);

            $code_html .= recuperer_gabarit('utilisateur/form_edit_utilisateur_Administrateur.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_utilisateur_Administrateur')), false, true);

        }

    }
    elseif ($mf_action=='modifier_utilisateur_Developpeur')
    {

        $utilisateur = $table_utilisateur->mf_get(mf_Code_utilisateur(), array( 'autocompletion' => true ));
        if (isset($utilisateur['Code_utilisateur']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_select(lister_cles($lang_standard['utilisateur_Developpeur_']), "utilisateur_Developpeur", ( isset($_POST['utilisateur_Developpeur']) ? $_POST['utilisateur_Developpeur'] : $utilisateur['utilisateur_Developpeur'] ), true);

            $code_html .= recuperer_gabarit('utilisateur/form_edit_utilisateur_Developpeur.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_utilisateur_Developpeur')), false, true);

        }

    }
    elseif ($mf_action=="modpwd")
    {

        $utilisateur = $table_utilisateur->mf_get(mf_Code_utilisateur());
        if (isset($utilisateur['Code_utilisateur']))
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("utilisateur_Password_old", "", true, "password");
            $form->ajouter_input("utilisateur_Password_new", "", true, "password");
            $form->ajouter_input("utilisateur_Password_verif", "", true, "password");

            $code_html .= recuperer_gabarit('utilisateur/new_password_utilisateur.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('formulaire_modpwd_utilisateur')), false, true);

        }

    }
    elseif ($mf_action=="supprimer_utilisateur")
    {

        $utilisateur = $table_utilisateur->mf_get(mf_Code_utilisateur(), array( 'autocompletion' => true ));
        if ( isset($utilisateur['Code_utilisateur']) )
        {

            $form = new Formulaire('', $mess);
            $form->ajouter_select(array(0, 1), 'Supprimer', FORM_SUPPR_DEFAUT, true);
            $form->activer_picto_suppression();

            $code_html .= recuperer_gabarit('utilisateur/form_delete_utilisateur.html', array('{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_delete_utilisateur')), false, true);

        }

    }

