<?php declare(strict_types=1);

/** @var string $mf_action */
/** @var string $mess */

    if ($mf_action == 'apercu_utilisateur' || $mf_action <> '' && mf_Code_utilisateur() != 0) {

        $utilisateur = $db->utilisateur()->mf_get(mf_Code_utilisateur(), ['autocompletion' => true]);

        if (isset($utilisateur['Code_utilisateur'])) {

            $fil_ariane->ajouter_titre(get_titre_ligne_table('utilisateur', $utilisateur), get_nom_page_courante().'?act=apercu_utilisateur&Code_utilisateur=' . $utilisateur['Code_utilisateur']);

            $menu_a_droite->raz_boutons();

            if (! MULTI_BLOCS) {
                $code_html = '';
            }

            include __DIR__ . '/_utilisateur_get.php';

            $code_html .= recuperer_gabarit('main/section.html', [
                '{fonction}'  => 'apercu',
                '{nom_table}' => 'utilisateur',
                '{titre}'     => strip_tags(htmlspecialchars_decode(get_titre_ligne_table('utilisateur', $utilisateur)), ''),
                '{contenu}'   => recuperer_gabarit('utilisateur/bloc_apercu.html', $trans),
            ]);

        }

    } else {

        include __DIR__ . '/_utilisateur_list.php';

        $code_html .= recuperer_gabarit('main/section.html', [
            '{fonction}'  => 'lister',
            '{nom_table}' => 'utilisateur',
            '{titre}'     => htmlspecialchars(get_nom_colonne('libelle_liste_utilisateur')),
            '{contenu}'   => recuperer_gabarit('utilisateur/bloc_lister.html', $trans),
        ]);

    }

    if ($mf_action == "ajouter_utilisateur") {

        $form = new Formulaire('', $mess);
        $form->ajouter_input("utilisateur_Identifiant", ( isset($_POST['utilisateur_Identifiant']) ? $_POST['utilisateur_Identifiant'] : $mf_initialisation['utilisateur_Identifiant'] ), true);
        $form->ajouter_input("utilisateur_Password", ( isset($_POST['utilisateur_Password']) ? $_POST['utilisateur_Password'] : $mf_initialisation['utilisateur_Password'] ), true, 'password');
        $form->ajouter_input("utilisateur_Email", ( isset($_POST['utilisateur_Email']) ? $_POST['utilisateur_Email'] : $mf_initialisation['utilisateur_Email'] ), true);
        $form->ajouter_select(lister_cles($lang_standard['utilisateur_Civilite_Type_']), "utilisateur_Civilite_Type", ( isset($_POST['utilisateur_Civilite_Type']) ? $_POST['utilisateur_Civilite_Type'] : $mf_initialisation['utilisateur_Civilite_Type'] ), true);
        $form->ajouter_input("utilisateur_Prenom", ( isset($_POST['utilisateur_Prenom']) ? $_POST['utilisateur_Prenom'] : $mf_initialisation['utilisateur_Prenom'] ), true);
        $form->ajouter_input("utilisateur_Nom", ( isset($_POST['utilisateur_Nom']) ? $_POST['utilisateur_Nom'] : $mf_initialisation['utilisateur_Nom'] ), true);
        $form->ajouter_input("utilisateur_Adresse_1", ( isset($_POST['utilisateur_Adresse_1']) ? $_POST['utilisateur_Adresse_1'] : $mf_initialisation['utilisateur_Adresse_1'] ), true);
        $form->ajouter_input("utilisateur_Adresse_2", ( isset($_POST['utilisateur_Adresse_2']) ? $_POST['utilisateur_Adresse_2'] : $mf_initialisation['utilisateur_Adresse_2'] ), true);
        $form->ajouter_input("utilisateur_Ville", ( isset($_POST['utilisateur_Ville']) ? $_POST['utilisateur_Ville'] : $mf_initialisation['utilisateur_Ville'] ), true);
        $form->ajouter_input("utilisateur_Code_postal", ( isset($_POST['utilisateur_Code_postal']) ? $_POST['utilisateur_Code_postal'] : $mf_initialisation['utilisateur_Code_postal'] ), true);
        $form->ajouter_input("utilisateur_Date_naissance", ( isset($_POST['utilisateur_Date_naissance']) ? $_POST['utilisateur_Date_naissance'] : $mf_initialisation['utilisateur_Date_naissance'] ), true);
        $form->ajouter_select(lister_cles($lang_standard['utilisateur_Accepte_mail_publicitaire_']), "utilisateur_Accepte_mail_publicitaire", ( isset($_POST['utilisateur_Accepte_mail_publicitaire']) ? $_POST['utilisateur_Accepte_mail_publicitaire'] : $mf_initialisation['utilisateur_Accepte_mail_publicitaire'] ), true);
        $form->ajouter_select(lister_cles($lang_standard['utilisateur_Administrateur_']), "utilisateur_Administrateur", ( isset($_POST['utilisateur_Administrateur']) ? $_POST['utilisateur_Administrateur'] : $mf_initialisation['utilisateur_Administrateur'] ), true);
        $form->ajouter_select(lister_cles($lang_standard['utilisateur_Fournisseur_']), "utilisateur_Fournisseur", ( isset($_POST['utilisateur_Fournisseur']) ? $_POST['utilisateur_Fournisseur'] : $mf_initialisation['utilisateur_Fournisseur'] ), true);

        $code_html .= recuperer_gabarit('utilisateur/form_add_utilisateur.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_add_utilisateur')], false, true);

    } elseif ($mf_action == "modifier_utilisateur") {

        $utilisateur = $db->utilisateur()->mf_get(mf_Code_utilisateur(), ['autocompletion' => true]);
        if (isset($utilisateur['Code_utilisateur'])) {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("utilisateur_Identifiant", ( isset($_POST['utilisateur_Identifiant']) ? $_POST['utilisateur_Identifiant'] : $utilisateur['utilisateur_Identifiant'] ), true);
            // $form->ajouter_input("utilisateur_Password", "", true);
            $form->ajouter_input("utilisateur_Email", ( isset($_POST['utilisateur_Email']) ? $_POST['utilisateur_Email'] : $utilisateur['utilisateur_Email'] ), true);
            $form->ajouter_select(liste_union_A_et_B([$utilisateur['utilisateur_Civilite_Type']], Hook_utilisateur::workflow__utilisateur_Civilite_Type($utilisateur['utilisateur_Civilite_Type'])), "utilisateur_Civilite_Type", ( isset($_POST['utilisateur_Civilite_Type']) ? $_POST['utilisateur_Civilite_Type'] : $utilisateur['utilisateur_Civilite_Type'] ), true);
            $form->ajouter_input("utilisateur_Prenom", ( isset($_POST['utilisateur_Prenom']) ? $_POST['utilisateur_Prenom'] : $utilisateur['utilisateur_Prenom'] ), true);
            $form->ajouter_input("utilisateur_Nom", ( isset($_POST['utilisateur_Nom']) ? $_POST['utilisateur_Nom'] : $utilisateur['utilisateur_Nom'] ), true);
            $form->ajouter_input("utilisateur_Adresse_1", ( isset($_POST['utilisateur_Adresse_1']) ? $_POST['utilisateur_Adresse_1'] : $utilisateur['utilisateur_Adresse_1'] ), true);
            $form->ajouter_input("utilisateur_Adresse_2", ( isset($_POST['utilisateur_Adresse_2']) ? $_POST['utilisateur_Adresse_2'] : $utilisateur['utilisateur_Adresse_2'] ), true);
            $form->ajouter_input("utilisateur_Ville", ( isset($_POST['utilisateur_Ville']) ? $_POST['utilisateur_Ville'] : $utilisateur['utilisateur_Ville'] ), true);
            $form->ajouter_input("utilisateur_Code_postal", ( isset($_POST['utilisateur_Code_postal']) ? $_POST['utilisateur_Code_postal'] : $utilisateur['utilisateur_Code_postal'] ), true);
            $form->ajouter_input("utilisateur_Date_naissance", ( isset($_POST['utilisateur_Date_naissance']) ? $_POST['utilisateur_Date_naissance'] : $utilisateur['utilisateur_Date_naissance'] ), true);
            $form->ajouter_select(lister_cles($lang_standard['utilisateur_Accepte_mail_publicitaire_']), "utilisateur_Accepte_mail_publicitaire", ( isset($_POST['utilisateur_Accepte_mail_publicitaire']) ? $_POST['utilisateur_Accepte_mail_publicitaire'] : $utilisateur['utilisateur_Accepte_mail_publicitaire'] ), true);
            $form->ajouter_select(lister_cles($lang_standard['utilisateur_Administrateur_']), "utilisateur_Administrateur", ( isset($_POST['utilisateur_Administrateur']) ? $_POST['utilisateur_Administrateur'] : $utilisateur['utilisateur_Administrateur'] ), true);
            $form->ajouter_select(lister_cles($lang_standard['utilisateur_Fournisseur_']), "utilisateur_Fournisseur", ( isset($_POST['utilisateur_Fournisseur']) ? $_POST['utilisateur_Fournisseur'] : $utilisateur['utilisateur_Fournisseur'] ), true);

            $code_html .= recuperer_gabarit('utilisateur/form_edit_utilisateur.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_utilisateur')], false, true);

        }

    }
    elseif ($mf_action == 'modifier_utilisateur_Identifiant') {

        $utilisateur = $db->utilisateur()->mf_get(mf_Code_utilisateur(), ['autocompletion' => true]);
        if (isset($utilisateur['Code_utilisateur'])) {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("utilisateur_Identifiant", ( isset($_POST['utilisateur_Identifiant']) ? $_POST['utilisateur_Identifiant'] : $utilisateur['utilisateur_Identifiant'] ), true);

            $code_html .= recuperer_gabarit('utilisateur/form_edit_utilisateur_Identifiant.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_utilisateur_Identifiant')], false, true);

        }

    }
    elseif ($mf_action == 'modifier_utilisateur_Password') {

        $utilisateur = $db->utilisateur()->mf_get(mf_Code_utilisateur(), ['autocompletion' => true]);
        if (isset($utilisateur['Code_utilisateur'])) {

            $form = new Formulaire('', $mess);
            // $form->ajouter_input("utilisateur_Password", "", true);

            $code_html .= recuperer_gabarit('utilisateur/form_edit_utilisateur_Password.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_utilisateur_Password')], false, true);

        }

    }
    elseif ($mf_action == 'modifier_utilisateur_Email') {

        $utilisateur = $db->utilisateur()->mf_get(mf_Code_utilisateur(), ['autocompletion' => true]);
        if (isset($utilisateur['Code_utilisateur'])) {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("utilisateur_Email", ( isset($_POST['utilisateur_Email']) ? $_POST['utilisateur_Email'] : $utilisateur['utilisateur_Email'] ), true);

            $code_html .= recuperer_gabarit('utilisateur/form_edit_utilisateur_Email.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_utilisateur_Email')], false, true);

        }

    }
    elseif ($mf_action == 'modifier_utilisateur_Civilite_Type') {

        $utilisateur = $db->utilisateur()->mf_get(mf_Code_utilisateur(), ['autocompletion' => true]);
        if (isset($utilisateur['Code_utilisateur'])) {

            $form = new Formulaire('', $mess);
            $form->ajouter_select(liste_union_A_et_B([$utilisateur['utilisateur_Civilite_Type']], Hook_utilisateur::workflow__utilisateur_Civilite_Type($utilisateur['utilisateur_Civilite_Type'])), 'utilisateur_Civilite_Type', (isset($_POST['utilisateur_Civilite_Type']) ? $_POST['utilisateur_Civilite_Type'] : $utilisateur['utilisateur_Civilite_Type']), true);

            $code_html .= recuperer_gabarit('utilisateur/form_edit_utilisateur_Civilite_Type.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_utilisateur_Civilite_Type')], false, true);

        }

    }
    elseif ($mf_action == 'modifier_utilisateur_Prenom') {

        $utilisateur = $db->utilisateur()->mf_get(mf_Code_utilisateur(), ['autocompletion' => true]);
        if (isset($utilisateur['Code_utilisateur'])) {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("utilisateur_Prenom", ( isset($_POST['utilisateur_Prenom']) ? $_POST['utilisateur_Prenom'] : $utilisateur['utilisateur_Prenom'] ), true);

            $code_html .= recuperer_gabarit('utilisateur/form_edit_utilisateur_Prenom.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_utilisateur_Prenom')], false, true);

        }

    }
    elseif ($mf_action == 'modifier_utilisateur_Nom') {

        $utilisateur = $db->utilisateur()->mf_get(mf_Code_utilisateur(), ['autocompletion' => true]);
        if (isset($utilisateur['Code_utilisateur'])) {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("utilisateur_Nom", ( isset($_POST['utilisateur_Nom']) ? $_POST['utilisateur_Nom'] : $utilisateur['utilisateur_Nom'] ), true);

            $code_html .= recuperer_gabarit('utilisateur/form_edit_utilisateur_Nom.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_utilisateur_Nom')], false, true);

        }

    }
    elseif ($mf_action == 'modifier_utilisateur_Adresse_1') {

        $utilisateur = $db->utilisateur()->mf_get(mf_Code_utilisateur(), ['autocompletion' => true]);
        if (isset($utilisateur['Code_utilisateur'])) {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("utilisateur_Adresse_1", ( isset($_POST['utilisateur_Adresse_1']) ? $_POST['utilisateur_Adresse_1'] : $utilisateur['utilisateur_Adresse_1'] ), true);

            $code_html .= recuperer_gabarit('utilisateur/form_edit_utilisateur_Adresse_1.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_utilisateur_Adresse_1')], false, true);

        }

    }
    elseif ($mf_action == 'modifier_utilisateur_Adresse_2') {

        $utilisateur = $db->utilisateur()->mf_get(mf_Code_utilisateur(), ['autocompletion' => true]);
        if (isset($utilisateur['Code_utilisateur'])) {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("utilisateur_Adresse_2", ( isset($_POST['utilisateur_Adresse_2']) ? $_POST['utilisateur_Adresse_2'] : $utilisateur['utilisateur_Adresse_2'] ), true);

            $code_html .= recuperer_gabarit('utilisateur/form_edit_utilisateur_Adresse_2.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_utilisateur_Adresse_2')], false, true);

        }

    }
    elseif ($mf_action == 'modifier_utilisateur_Ville') {

        $utilisateur = $db->utilisateur()->mf_get(mf_Code_utilisateur(), ['autocompletion' => true]);
        if (isset($utilisateur['Code_utilisateur'])) {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("utilisateur_Ville", ( isset($_POST['utilisateur_Ville']) ? $_POST['utilisateur_Ville'] : $utilisateur['utilisateur_Ville'] ), true);

            $code_html .= recuperer_gabarit('utilisateur/form_edit_utilisateur_Ville.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_utilisateur_Ville')], false, true);

        }

    }
    elseif ($mf_action == 'modifier_utilisateur_Code_postal') {

        $utilisateur = $db->utilisateur()->mf_get(mf_Code_utilisateur(), ['autocompletion' => true]);
        if (isset($utilisateur['Code_utilisateur'])) {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("utilisateur_Code_postal", ( isset($_POST['utilisateur_Code_postal']) ? $_POST['utilisateur_Code_postal'] : $utilisateur['utilisateur_Code_postal'] ), true);

            $code_html .= recuperer_gabarit('utilisateur/form_edit_utilisateur_Code_postal.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_utilisateur_Code_postal')], false, true);

        }

    }
    elseif ($mf_action == 'modifier_utilisateur_Date_naissance') {

        $utilisateur = $db->utilisateur()->mf_get(mf_Code_utilisateur(), ['autocompletion' => true]);
        if (isset($utilisateur['Code_utilisateur'])) {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("utilisateur_Date_naissance", ( isset($_POST['utilisateur_Date_naissance']) ? $_POST['utilisateur_Date_naissance'] : $utilisateur['utilisateur_Date_naissance'] ), true);

            $code_html .= recuperer_gabarit('utilisateur/form_edit_utilisateur_Date_naissance.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_utilisateur_Date_naissance')], false, true);

        }

    }
    elseif ($mf_action == 'modifier_utilisateur_Accepte_mail_publicitaire') {

        $utilisateur = $db->utilisateur()->mf_get(mf_Code_utilisateur(), ['autocompletion' => true]);
        if (isset($utilisateur['Code_utilisateur'])) {

            $form = new Formulaire('', $mess);
            $form->ajouter_select(lister_cles($lang_standard['utilisateur_Accepte_mail_publicitaire_']), "utilisateur_Accepte_mail_publicitaire", ( isset($_POST['utilisateur_Accepte_mail_publicitaire']) ? $_POST['utilisateur_Accepte_mail_publicitaire'] : $utilisateur['utilisateur_Accepte_mail_publicitaire'] ), true);

            $code_html .= recuperer_gabarit('utilisateur/form_edit_utilisateur_Accepte_mail_publicitaire.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_utilisateur_Accepte_mail_publicitaire')], false, true);

        }

    }
    elseif ($mf_action == 'modifier_utilisateur_Administrateur') {

        $utilisateur = $db->utilisateur()->mf_get(mf_Code_utilisateur(), ['autocompletion' => true]);
        if (isset($utilisateur['Code_utilisateur'])) {

            $form = new Formulaire('', $mess);
            $form->ajouter_select(lister_cles($lang_standard['utilisateur_Administrateur_']), "utilisateur_Administrateur", ( isset($_POST['utilisateur_Administrateur']) ? $_POST['utilisateur_Administrateur'] : $utilisateur['utilisateur_Administrateur'] ), true);

            $code_html .= recuperer_gabarit('utilisateur/form_edit_utilisateur_Administrateur.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_utilisateur_Administrateur')], false, true);

        }

    }
    elseif ($mf_action == 'modifier_utilisateur_Fournisseur') {

        $utilisateur = $db->utilisateur()->mf_get(mf_Code_utilisateur(), ['autocompletion' => true]);
        if (isset($utilisateur['Code_utilisateur'])) {

            $form = new Formulaire('', $mess);
            $form->ajouter_select(lister_cles($lang_standard['utilisateur_Fournisseur_']), "utilisateur_Fournisseur", ( isset($_POST['utilisateur_Fournisseur']) ? $_POST['utilisateur_Fournisseur'] : $utilisateur['utilisateur_Fournisseur'] ), true);

            $code_html .= recuperer_gabarit('utilisateur/form_edit_utilisateur_Fournisseur.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_utilisateur_Fournisseur')], false, true);

        }

    }
    elseif ($mf_action == 'modpwd') {

        $utilisateur = $db->utilisateur()->mf_get(mf_Code_utilisateur());
        if (isset($utilisateur['Code_utilisateur'])) {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("utilisateur_Password_old", "", true, "password");
            $form->ajouter_input("utilisateur_Password_new", "", true, "password");
            $form->ajouter_input("utilisateur_Password_verif", "", true, "password");

            $code_html .= recuperer_gabarit('utilisateur/new_password_utilisateur.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('formulaire_modpwd_utilisateur')], false, true);

        }

    }
    elseif ($mf_action == 'supprimer_utilisateur') {

        $utilisateur = $db->utilisateur()->mf_get(mf_Code_utilisateur(), ['autocompletion' => true]);
        if (isset($utilisateur['Code_utilisateur'])) {

            $form = new Formulaire('', $mess);
            $form->ajouter_select([0, 1], 'Supprimer', FORM_SUPPR_DEFAUT, true);
            $form->activer_picto_suppression();

            $code_html .= recuperer_gabarit('utilisateur/form_delete_utilisateur.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_delete_utilisateur')], false, true);

        }

    }

