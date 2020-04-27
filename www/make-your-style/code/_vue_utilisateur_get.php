<?php declare(strict_types=1);

/** @var array $vue_utilisateur */

    // Actualisation des droits
    Hook_vue_utilisateur::hook_actualiser_les_droits_modifier($vue_utilisateur['Code_vue_utilisateur']);
    Hook_vue_utilisateur::hook_actualiser_les_droits_supprimer($vue_utilisateur['Code_vue_utilisateur']);

    // boutons
        if ($mf_droits_defaut['vue_utilisateur__MODIFIER']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_vue_utilisateur') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante() . '?act=modifier_vue_utilisateur&Code_vue_utilisateur=' . mf_Code_vue_utilisateur() . '&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_vue_utilisateur');
        }
        $trans['{bouton_modifier_vue_utilisateur}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_vue_utilisateur') : '');
        if ($mf_droits_defaut['vue_utilisateur__SUPPRIMER']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_SUPPRIMER_PREC . get_nom_colonne('bouton_supprimer_vue_utilisateur') . BOUTON_LIBELLE_SUPPRIMER_SUIV, get_nom_page_courante() . '?act=supprimer_vue_utilisateur&Code_vue_utilisateur=' . mf_Code_vue_utilisateur() . '&mf_instance=' . get_instance(), 'lien', 'bouton_supprimer_vue_utilisateur');
        }
        $trans['{bouton_supprimer_vue_utilisateur}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_supprimer_vue_utilisateur', BOUTON_CLASSE_SUPPRIMER) : '');

        // vue_utilisateur_Recherche
        if ($mf_droits_defaut['api_modifier__vue_utilisateur_Recherche']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_vue_utilisateur_Recherche') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_vue_utilisateur_Recherche&Code_vue_utilisateur=' . mf_Code_vue_utilisateur() . '&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_vue_utilisateur_Recherche');
        }
        $trans['{bouton_modifier_vue_utilisateur_Recherche}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_vue_utilisateur_Recherche') : '');

        // vue_utilisateur_Filtre_Saison_Type
        if ($mf_droits_defaut['api_modifier__vue_utilisateur_Filtre_Saison_Type']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_vue_utilisateur_Filtre_Saison_Type') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_vue_utilisateur_Filtre_Saison_Type&Code_vue_utilisateur=' . mf_Code_vue_utilisateur() . '&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_vue_utilisateur_Filtre_Saison_Type');
        }
        $trans['{bouton_modifier_vue_utilisateur_Filtre_Saison_Type}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_vue_utilisateur_Filtre_Saison_Type') : '');

        // vue_utilisateur_Filtre_Couleur
        if ($mf_droits_defaut['api_modifier__vue_utilisateur_Filtre_Couleur']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_vue_utilisateur_Filtre_Couleur') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_vue_utilisateur_Filtre_Couleur&Code_vue_utilisateur=' . mf_Code_vue_utilisateur() . '&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_vue_utilisateur_Filtre_Couleur');
        }
        $trans['{bouton_modifier_vue_utilisateur_Filtre_Couleur}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_vue_utilisateur_Filtre_Couleur') : '');

        // vue_utilisateur_Filtre_Taille_Pays_Type
        if ($mf_droits_defaut['api_modifier__vue_utilisateur_Filtre_Taille_Pays_Type']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_vue_utilisateur_Filtre_Taille_Pays_Type') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_vue_utilisateur_Filtre_Taille_Pays_Type&Code_vue_utilisateur=' . mf_Code_vue_utilisateur() . '&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_vue_utilisateur_Filtre_Taille_Pays_Type');
        }
        $trans['{bouton_modifier_vue_utilisateur_Filtre_Taille_Pays_Type}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_vue_utilisateur_Filtre_Taille_Pays_Type') : '');

        // vue_utilisateur_Filtre_Taille_Max
        if ($mf_droits_defaut['api_modifier__vue_utilisateur_Filtre_Taille_Max']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_vue_utilisateur_Filtre_Taille_Max') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_vue_utilisateur_Filtre_Taille_Max&Code_vue_utilisateur=' . mf_Code_vue_utilisateur() . '&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_vue_utilisateur_Filtre_Taille_Max');
        }
        $trans['{bouton_modifier_vue_utilisateur_Filtre_Taille_Max}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_vue_utilisateur_Filtre_Taille_Max') : '');

        // vue_utilisateur_Filtre_Taille_Min
        if ($mf_droits_defaut['api_modifier__vue_utilisateur_Filtre_Taille_Min']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_vue_utilisateur_Filtre_Taille_Min') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_vue_utilisateur_Filtre_Taille_Min&Code_vue_utilisateur=' . mf_Code_vue_utilisateur() . '&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_vue_utilisateur_Filtre_Taille_Min');
        }
        $trans['{bouton_modifier_vue_utilisateur_Filtre_Taille_Min}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_vue_utilisateur_Filtre_Taille_Min') : '');

    /* prec_et_suiv */
    if ($db->vue_utilisateur()->mf_compter() < 100) {
        $liste_vue_utilisateur = $db->vue_utilisateur()->mf_lister_contexte();
        // prec
        $prec_et_suiv = prec_suiv($liste_vue_utilisateur, $vue_utilisateur['Code_vue_utilisateur']);
        $prec=['link'=>'', 'title'=>''];
        $suiv=['link'=>'', 'title'=>''];
        if (isset($prec_et_suiv['prec']['Code_vue_utilisateur'])) {
            $prec['link'] = get_nom_page_courante().'?act=apercu_vue_utilisateur&Code_vue_utilisateur=' . $prec_et_suiv['prec']['Code_vue_utilisateur'];
            $prec['title'] = htmlspecialchars(get_titre_ligne_table('vue_utilisateur', $prec_et_suiv['prec']));
        }
        // suiv
        if (isset($prec_et_suiv['suiv']['Code_vue_utilisateur'])) {
            $suiv['link'] = get_nom_page_courante().'?act=apercu_vue_utilisateur&Code_vue_utilisateur=' . $prec_et_suiv['suiv']['Code_vue_utilisateur'];
            $suiv['title'] = htmlspecialchars(get_titre_ligne_table('vue_utilisateur', $prec_et_suiv['suiv']));
        }
        $trans['{pager_vue_utilisateur}'] = get_code_pager($prec, $suiv);
    } else {
        $trans['{pager_vue_utilisateur}'] = '';
    }

    /* vue_utilisateur_Recherche */
        if ($mf_droits_defaut['api_modifier__vue_utilisateur_Recherche']) {
            $trans['{vue_utilisateur_Recherche}'] = ajouter_champ_modifiable_interface(['liste_valeurs_cle_table' => ['Code_vue_utilisateur' => $vue_utilisateur['Code_vue_utilisateur']], 'DB_name' => 'vue_utilisateur_Recherche', 'valeur_initiale' => $vue_utilisateur['vue_utilisateur_Recherche']]);
        } else {
            $trans['{vue_utilisateur_Recherche}'] = get_valeur_html_maj_auto_interface(['liste_valeurs_cle_table' => ['Code_vue_utilisateur' => $vue_utilisateur['Code_vue_utilisateur']], 'DB_name' => 'vue_utilisateur_Recherche', 'valeur_initiale' => $vue_utilisateur['vue_utilisateur_Recherche']]);
        }

    /* vue_utilisateur_Filtre_Saison_Type */
        if ($mf_droits_defaut['api_modifier__vue_utilisateur_Filtre_Saison_Type']) {
            // en fonction des possibilités, liste choix possibles
            $liste = liste_union_A_et_B([$vue_utilisateur['vue_utilisateur_Filtre_Saison_Type']], Hook_vue_utilisateur::workflow__vue_utilisateur_Filtre_Saison_Type($vue_utilisateur['vue_utilisateur_Filtre_Saison_Type']));
            foreach ($lang_standard['vue_utilisateur_Filtre_Saison_Type_'] as $key => $value) {
                if (! in_array($key, $liste) && $key != $vue_utilisateur['vue_utilisateur_Filtre_Saison_Type']) {
                    unset($lang_standard['vue_utilisateur_Filtre_Saison_Type_'][$key]);
                }
            }
            // champ modifiable
            $trans['{vue_utilisateur_Filtre_Saison_Type}'] = ajouter_champ_modifiable_interface(['liste_valeurs_cle_table' => ['Code_vue_utilisateur' => $vue_utilisateur['Code_vue_utilisateur']], 'DB_name' => 'vue_utilisateur_Filtre_Saison_Type', 'valeur_initiale' => $vue_utilisateur['vue_utilisateur_Filtre_Saison_Type']]);
        } else {
            $trans['{vue_utilisateur_Filtre_Saison_Type}'] = get_valeur_html_maj_auto_interface(['liste_valeurs_cle_table' => ['Code_vue_utilisateur' => $vue_utilisateur['Code_vue_utilisateur']], 'DB_name' => 'vue_utilisateur_Filtre_Saison_Type', 'valeur_initiale' => $vue_utilisateur['vue_utilisateur_Filtre_Saison_Type']]);
        }

    /* vue_utilisateur_Filtre_Couleur */
        if ($mf_droits_defaut['api_modifier__vue_utilisateur_Filtre_Couleur']) {
            $trans['{vue_utilisateur_Filtre_Couleur}'] = ajouter_champ_modifiable_interface(['liste_valeurs_cle_table' => ['Code_vue_utilisateur' => $vue_utilisateur['Code_vue_utilisateur']], 'DB_name' => 'vue_utilisateur_Filtre_Couleur', 'valeur_initiale' => $vue_utilisateur['vue_utilisateur_Filtre_Couleur'], 'type_input' => 'color']);
        } else {
            $trans['{vue_utilisateur_Filtre_Couleur}'] = get_valeur_html_maj_auto_interface(['liste_valeurs_cle_table' => ['Code_vue_utilisateur' => $vue_utilisateur['Code_vue_utilisateur']], 'DB_name' => 'vue_utilisateur_Filtre_Couleur', 'valeur_initiale' => $vue_utilisateur['vue_utilisateur_Filtre_Couleur'], 'class' => 'color' ]);
        }

    /* vue_utilisateur_Filtre_Taille_Pays_Type */
        if ($mf_droits_defaut['api_modifier__vue_utilisateur_Filtre_Taille_Pays_Type']) {
            // en fonction des possibilités, liste choix possibles
            $liste = liste_union_A_et_B([$vue_utilisateur['vue_utilisateur_Filtre_Taille_Pays_Type']], Hook_vue_utilisateur::workflow__vue_utilisateur_Filtre_Taille_Pays_Type($vue_utilisateur['vue_utilisateur_Filtre_Taille_Pays_Type']));
            foreach ($lang_standard['vue_utilisateur_Filtre_Taille_Pays_Type_'] as $key => $value) {
                if (! in_array($key, $liste) && $key != $vue_utilisateur['vue_utilisateur_Filtre_Taille_Pays_Type']) {
                    unset($lang_standard['vue_utilisateur_Filtre_Taille_Pays_Type_'][$key]);
                }
            }
            // champ modifiable
            $trans['{vue_utilisateur_Filtre_Taille_Pays_Type}'] = ajouter_champ_modifiable_interface(['liste_valeurs_cle_table' => ['Code_vue_utilisateur' => $vue_utilisateur['Code_vue_utilisateur']], 'DB_name' => 'vue_utilisateur_Filtre_Taille_Pays_Type', 'valeur_initiale' => $vue_utilisateur['vue_utilisateur_Filtre_Taille_Pays_Type']]);
        } else {
            $trans['{vue_utilisateur_Filtre_Taille_Pays_Type}'] = get_valeur_html_maj_auto_interface(['liste_valeurs_cle_table' => ['Code_vue_utilisateur' => $vue_utilisateur['Code_vue_utilisateur']], 'DB_name' => 'vue_utilisateur_Filtre_Taille_Pays_Type', 'valeur_initiale' => $vue_utilisateur['vue_utilisateur_Filtre_Taille_Pays_Type']]);
        }

    /* vue_utilisateur_Filtre_Taille_Max */
        if ($mf_droits_defaut['api_modifier__vue_utilisateur_Filtre_Taille_Max']) {
            $trans['{vue_utilisateur_Filtre_Taille_Max}'] = ajouter_champ_modifiable_interface(['liste_valeurs_cle_table' => ['Code_vue_utilisateur' => $vue_utilisateur['Code_vue_utilisateur']], 'DB_name' => 'vue_utilisateur_Filtre_Taille_Max', 'valeur_initiale' => $vue_utilisateur['vue_utilisateur_Filtre_Taille_Max']]);
        } else {
            $trans['{vue_utilisateur_Filtre_Taille_Max}'] = get_valeur_html_maj_auto_interface(['liste_valeurs_cle_table' => ['Code_vue_utilisateur' => $vue_utilisateur['Code_vue_utilisateur']], 'DB_name' => 'vue_utilisateur_Filtre_Taille_Max', 'valeur_initiale' => $vue_utilisateur['vue_utilisateur_Filtre_Taille_Max']]);
        }

    /* vue_utilisateur_Filtre_Taille_Min */
        if ($mf_droits_defaut['api_modifier__vue_utilisateur_Filtre_Taille_Min']) {
            $trans['{vue_utilisateur_Filtre_Taille_Min}'] = ajouter_champ_modifiable_interface(['liste_valeurs_cle_table' => ['Code_vue_utilisateur' => $vue_utilisateur['Code_vue_utilisateur']], 'DB_name' => 'vue_utilisateur_Filtre_Taille_Min', 'valeur_initiale' => $vue_utilisateur['vue_utilisateur_Filtre_Taille_Min']]);
        } else {
            $trans['{vue_utilisateur_Filtre_Taille_Min}'] = get_valeur_html_maj_auto_interface(['liste_valeurs_cle_table' => ['Code_vue_utilisateur' => $vue_utilisateur['Code_vue_utilisateur']], 'DB_name' => 'vue_utilisateur_Filtre_Taille_Min', 'valeur_initiale' => $vue_utilisateur['vue_utilisateur_Filtre_Taille_Min']]);
        }

