<?php declare(strict_types=1);

/** @var string $mf_action */
/** @var string $mess */

    if ($mf_action == 'apercu_vue_utilisateur' || $mf_action <> '' && mf_Code_vue_utilisateur() != 0) {

        $vue_utilisateur = $db->vue_utilisateur()->mf_get(mf_Code_vue_utilisateur(), ['autocompletion' => true]);

        if (isset($vue_utilisateur['Code_vue_utilisateur'])) {

            $fil_ariane->ajouter_titre(get_titre_ligne_table('vue_utilisateur', $vue_utilisateur), get_nom_page_courante().'?act=apercu_vue_utilisateur&Code_vue_utilisateur=' . $vue_utilisateur['Code_vue_utilisateur']);

            $menu_a_droite->raz_boutons();

            if (! MULTI_BLOCS) {
                $code_html = '';
            }

            include __DIR__ . '/_vue_utilisateur_get.php';

            $code_html .= recuperer_gabarit('main/section.html', [
                '{fonction}'  => 'apercu',
                '{nom_table}' => 'vue_utilisateur',
                '{titre}'     => strip_tags(htmlspecialchars_decode(get_titre_ligne_table('vue_utilisateur', $vue_utilisateur)), ''),
                '{contenu}'   => recuperer_gabarit('vue_utilisateur/bloc_apercu.html', $trans),
            ]);

        }

    } else {

        include __DIR__ . '/_vue_utilisateur_list.php';

        $code_html .= recuperer_gabarit('main/section.html', [
            '{fonction}'  => 'lister',
            '{nom_table}' => 'vue_utilisateur',
            '{titre}'     => htmlspecialchars(get_nom_colonne('libelle_liste_vue_utilisateur')),
            '{contenu}'   => recuperer_gabarit('vue_utilisateur/bloc_lister.html', $trans),
        ]);

    }

    if ($mf_action == "ajouter_vue_utilisateur") {

        $form = new Formulaire('', $mess);
        $form->ajouter_input("vue_utilisateur_Recherche", ( isset($_POST['vue_utilisateur_Recherche']) ? $_POST['vue_utilisateur_Recherche'] : $mf_initialisation['vue_utilisateur_Recherche'] ), true);
        $form->ajouter_select(lister_cles($lang_standard['vue_utilisateur_Filtre_Saison_Type_']), "vue_utilisateur_Filtre_Saison_Type", ( isset($_POST['vue_utilisateur_Filtre_Saison_Type']) ? $_POST['vue_utilisateur_Filtre_Saison_Type'] : $mf_initialisation['vue_utilisateur_Filtre_Saison_Type'] ), true);
        $form->ajouter_input("vue_utilisateur_Filtre_Couleur", ( isset($_POST['vue_utilisateur_Filtre_Couleur']) ? $_POST['vue_utilisateur_Filtre_Couleur'] : $mf_initialisation['vue_utilisateur_Filtre_Couleur'] ), true, 'color');
        $form->ajouter_select(lister_cles($lang_standard['vue_utilisateur_Filtre_Taille_Pays_Type_']), "vue_utilisateur_Filtre_Taille_Pays_Type", ( isset($_POST['vue_utilisateur_Filtre_Taille_Pays_Type']) ? $_POST['vue_utilisateur_Filtre_Taille_Pays_Type'] : $mf_initialisation['vue_utilisateur_Filtre_Taille_Pays_Type'] ), true);
        $form->ajouter_input("vue_utilisateur_Filtre_Taille_Max", ( isset($_POST['vue_utilisateur_Filtre_Taille_Max']) ? $_POST['vue_utilisateur_Filtre_Taille_Max'] : $mf_initialisation['vue_utilisateur_Filtre_Taille_Max'] ), true);
        $form->ajouter_input("vue_utilisateur_Filtre_Taille_Min", ( isset($_POST['vue_utilisateur_Filtre_Taille_Min']) ? $_POST['vue_utilisateur_Filtre_Taille_Min'] : $mf_initialisation['vue_utilisateur_Filtre_Taille_Min'] ), true);

        $code_html .= recuperer_gabarit('vue_utilisateur/form_add_vue_utilisateur.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_add_vue_utilisateur')], false, true);

    } elseif ($mf_action == "modifier_vue_utilisateur") {

        $vue_utilisateur = $db->vue_utilisateur()->mf_get(mf_Code_vue_utilisateur(), ['autocompletion' => true]);
        if (isset($vue_utilisateur['Code_vue_utilisateur'])) {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("vue_utilisateur_Recherche", ( isset($_POST['vue_utilisateur_Recherche']) ? $_POST['vue_utilisateur_Recherche'] : $vue_utilisateur['vue_utilisateur_Recherche'] ), true);
            $form->ajouter_select(liste_union_A_et_B([$vue_utilisateur['vue_utilisateur_Filtre_Saison_Type']], Hook_vue_utilisateur::workflow__vue_utilisateur_Filtre_Saison_Type($vue_utilisateur['vue_utilisateur_Filtre_Saison_Type'])), "vue_utilisateur_Filtre_Saison_Type", ( isset($_POST['vue_utilisateur_Filtre_Saison_Type']) ? $_POST['vue_utilisateur_Filtre_Saison_Type'] : $vue_utilisateur['vue_utilisateur_Filtre_Saison_Type'] ), true);
            $form->ajouter_input("vue_utilisateur_Filtre_Couleur", ( isset($_POST['vue_utilisateur_Filtre_Couleur']) ? $_POST['vue_utilisateur_Filtre_Couleur'] : $vue_utilisateur['vue_utilisateur_Filtre_Couleur'] ), true);
            $form->ajouter_select(liste_union_A_et_B([$vue_utilisateur['vue_utilisateur_Filtre_Taille_Pays_Type']], Hook_vue_utilisateur::workflow__vue_utilisateur_Filtre_Taille_Pays_Type($vue_utilisateur['vue_utilisateur_Filtre_Taille_Pays_Type'])), "vue_utilisateur_Filtre_Taille_Pays_Type", ( isset($_POST['vue_utilisateur_Filtre_Taille_Pays_Type']) ? $_POST['vue_utilisateur_Filtre_Taille_Pays_Type'] : $vue_utilisateur['vue_utilisateur_Filtre_Taille_Pays_Type'] ), true);
            $form->ajouter_input("vue_utilisateur_Filtre_Taille_Max", ( isset($_POST['vue_utilisateur_Filtre_Taille_Max']) ? $_POST['vue_utilisateur_Filtre_Taille_Max'] : $vue_utilisateur['vue_utilisateur_Filtre_Taille_Max'] ), true);
            $form->ajouter_input("vue_utilisateur_Filtre_Taille_Min", ( isset($_POST['vue_utilisateur_Filtre_Taille_Min']) ? $_POST['vue_utilisateur_Filtre_Taille_Min'] : $vue_utilisateur['vue_utilisateur_Filtre_Taille_Min'] ), true);

            $code_html .= recuperer_gabarit('vue_utilisateur/form_edit_vue_utilisateur.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_vue_utilisateur')], false, true);

        }

    }
    elseif ($mf_action == 'modifier_vue_utilisateur_Recherche') {

        $vue_utilisateur = $db->vue_utilisateur()->mf_get(mf_Code_vue_utilisateur(), ['autocompletion' => true]);
        if (isset($vue_utilisateur['Code_vue_utilisateur'])) {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("vue_utilisateur_Recherche", ( isset($_POST['vue_utilisateur_Recherche']) ? $_POST['vue_utilisateur_Recherche'] : $vue_utilisateur['vue_utilisateur_Recherche'] ), true);

            $code_html .= recuperer_gabarit('vue_utilisateur/form_edit_vue_utilisateur_Recherche.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_vue_utilisateur_Recherche')], false, true);

        }

    }
    elseif ($mf_action == 'modifier_vue_utilisateur_Filtre_Saison_Type') {

        $vue_utilisateur = $db->vue_utilisateur()->mf_get(mf_Code_vue_utilisateur(), ['autocompletion' => true]);
        if (isset($vue_utilisateur['Code_vue_utilisateur'])) {

            $form = new Formulaire('', $mess);
            $form->ajouter_select(liste_union_A_et_B([$vue_utilisateur['vue_utilisateur_Filtre_Saison_Type']], Hook_vue_utilisateur::workflow__vue_utilisateur_Filtre_Saison_Type($vue_utilisateur['vue_utilisateur_Filtre_Saison_Type'])), 'vue_utilisateur_Filtre_Saison_Type', (isset($_POST['vue_utilisateur_Filtre_Saison_Type']) ? $_POST['vue_utilisateur_Filtre_Saison_Type'] : $vue_utilisateur['vue_utilisateur_Filtre_Saison_Type']), true);

            $code_html .= recuperer_gabarit('vue_utilisateur/form_edit_vue_utilisateur_Filtre_Saison_Type.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_vue_utilisateur_Filtre_Saison_Type')], false, true);

        }

    }
    elseif ($mf_action == 'modifier_vue_utilisateur_Filtre_Couleur') {

        $vue_utilisateur = $db->vue_utilisateur()->mf_get(mf_Code_vue_utilisateur(), ['autocompletion' => true]);
        if (isset($vue_utilisateur['Code_vue_utilisateur'])) {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("vue_utilisateur_Filtre_Couleur", ( isset($_POST['vue_utilisateur_Filtre_Couleur']) ? $_POST['vue_utilisateur_Filtre_Couleur'] : $vue_utilisateur['vue_utilisateur_Filtre_Couleur'] ), true);

            $code_html .= recuperer_gabarit('vue_utilisateur/form_edit_vue_utilisateur_Filtre_Couleur.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_vue_utilisateur_Filtre_Couleur')], false, true);

        }

    }
    elseif ($mf_action == 'modifier_vue_utilisateur_Filtre_Taille_Pays_Type') {

        $vue_utilisateur = $db->vue_utilisateur()->mf_get(mf_Code_vue_utilisateur(), ['autocompletion' => true]);
        if (isset($vue_utilisateur['Code_vue_utilisateur'])) {

            $form = new Formulaire('', $mess);
            $form->ajouter_select(liste_union_A_et_B([$vue_utilisateur['vue_utilisateur_Filtre_Taille_Pays_Type']], Hook_vue_utilisateur::workflow__vue_utilisateur_Filtre_Taille_Pays_Type($vue_utilisateur['vue_utilisateur_Filtre_Taille_Pays_Type'])), 'vue_utilisateur_Filtre_Taille_Pays_Type', (isset($_POST['vue_utilisateur_Filtre_Taille_Pays_Type']) ? $_POST['vue_utilisateur_Filtre_Taille_Pays_Type'] : $vue_utilisateur['vue_utilisateur_Filtre_Taille_Pays_Type']), true);

            $code_html .= recuperer_gabarit('vue_utilisateur/form_edit_vue_utilisateur_Filtre_Taille_Pays_Type.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_vue_utilisateur_Filtre_Taille_Pays_Type')], false, true);

        }

    }
    elseif ($mf_action == 'modifier_vue_utilisateur_Filtre_Taille_Max') {

        $vue_utilisateur = $db->vue_utilisateur()->mf_get(mf_Code_vue_utilisateur(), ['autocompletion' => true]);
        if (isset($vue_utilisateur['Code_vue_utilisateur'])) {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("vue_utilisateur_Filtre_Taille_Max", ( isset($_POST['vue_utilisateur_Filtre_Taille_Max']) ? $_POST['vue_utilisateur_Filtre_Taille_Max'] : $vue_utilisateur['vue_utilisateur_Filtre_Taille_Max'] ), true);

            $code_html .= recuperer_gabarit('vue_utilisateur/form_edit_vue_utilisateur_Filtre_Taille_Max.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_vue_utilisateur_Filtre_Taille_Max')], false, true);

        }

    }
    elseif ($mf_action == 'modifier_vue_utilisateur_Filtre_Taille_Min') {

        $vue_utilisateur = $db->vue_utilisateur()->mf_get(mf_Code_vue_utilisateur(), ['autocompletion' => true]);
        if (isset($vue_utilisateur['Code_vue_utilisateur'])) {

            $form = new Formulaire('', $mess);
            $form->ajouter_input("vue_utilisateur_Filtre_Taille_Min", ( isset($_POST['vue_utilisateur_Filtre_Taille_Min']) ? $_POST['vue_utilisateur_Filtre_Taille_Min'] : $vue_utilisateur['vue_utilisateur_Filtre_Taille_Min'] ), true);

            $code_html .= recuperer_gabarit('vue_utilisateur/form_edit_vue_utilisateur_Filtre_Taille_Min.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_edit_vue_utilisateur_Filtre_Taille_Min')], false, true);

        }

    }
    elseif ($mf_action == 'supprimer_vue_utilisateur') {

        $vue_utilisateur = $db->vue_utilisateur()->mf_get(mf_Code_vue_utilisateur(), ['autocompletion' => true]);
        if (isset($vue_utilisateur['Code_vue_utilisateur'])) {

            $form = new Formulaire('', $mess);
            $form->ajouter_select([0, 1], 'Supprimer', FORM_SUPPR_DEFAUT, true);
            $form->activer_picto_suppression();

            $code_html .= recuperer_gabarit('vue_utilisateur/form_delete_vue_utilisateur.html', ['{form}' => $form->generer_code(), '{title}' => get_nom_colonne('form_delete_vue_utilisateur')], false, true);

        }

    }

