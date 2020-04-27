<?php declare(strict_types=1);

/** @var array $utilisateur */

    // Actualisation des droits
    Hook_utilisateur::hook_actualiser_les_droits_modifier($utilisateur['Code_utilisateur']);
    Hook_utilisateur::hook_actualiser_les_droits_supprimer($utilisateur['Code_utilisateur']);

    // boutons
        if ($mf_droits_defaut['utilisateur__MODIFIER']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_utilisateur') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante() . '?act=modifier_utilisateur&Code_utilisateur=' . mf_Code_utilisateur() . '&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_utilisateur');
        }
        $trans['{bouton_modifier_utilisateur}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_utilisateur') : '');
        if ($mf_droits_defaut['utilisateur__MODIFIER_PWD']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_MODIFIER_PWD_PREC . get_nom_colonne('bouton_modpwd_utilisateur') . BOUTON_LIBELLE_MODIFIER_PWD_SUIV, get_nom_page_courante() . '?act=modpwd&Code_utilisateur=' . mf_Code_utilisateur() . '&mf_instance=' . get_instance(), 'lien', 'bouton_modpwd_utilisateur');
        }
        $trans['{bouton_modpwd_utilisateur}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modpwd_utilisateur') : '');
        if ($mf_droits_defaut['utilisateur__SUPPRIMER']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_SUPPRIMER_PREC . get_nom_colonne('bouton_supprimer_utilisateur') . BOUTON_LIBELLE_SUPPRIMER_SUIV, get_nom_page_courante() . '?act=supprimer_utilisateur&Code_utilisateur=' . mf_Code_utilisateur() . '&mf_instance=' . get_instance(), 'lien', 'bouton_supprimer_utilisateur');
        }
        $trans['{bouton_supprimer_utilisateur}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_supprimer_utilisateur', BOUTON_CLASSE_SUPPRIMER) : '');

        // utilisateur_Identifiant
        if ($mf_droits_defaut['api_modifier__utilisateur_Identifiant']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_utilisateur_Identifiant') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_utilisateur_Identifiant&Code_utilisateur=' . mf_Code_utilisateur() . '&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_utilisateur_Identifiant');
        }
        $trans['{bouton_modifier_utilisateur_Identifiant}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_utilisateur_Identifiant') : '');

        // utilisateur_Password
        if ($mf_droits_defaut['api_modifier__utilisateur_Password']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_utilisateur_Password') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_utilisateur_Password&Code_utilisateur=' . mf_Code_utilisateur() . '&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_utilisateur_Password');
        }
        $trans['{bouton_modifier_utilisateur_Password}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_utilisateur_Password') : '');

        // utilisateur_Email
        if ($mf_droits_defaut['api_modifier__utilisateur_Email']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_utilisateur_Email') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_utilisateur_Email&Code_utilisateur=' . mf_Code_utilisateur() . '&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_utilisateur_Email');
        }
        $trans['{bouton_modifier_utilisateur_Email}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_utilisateur_Email') : '');

        // utilisateur_Civilite_Type
        if ($mf_droits_defaut['api_modifier__utilisateur_Civilite_Type']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_utilisateur_Civilite_Type') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_utilisateur_Civilite_Type&Code_utilisateur=' . mf_Code_utilisateur() . '&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_utilisateur_Civilite_Type');
        }
        $trans['{bouton_modifier_utilisateur_Civilite_Type}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_utilisateur_Civilite_Type') : '');

        // utilisateur_Prenom
        if ($mf_droits_defaut['api_modifier__utilisateur_Prenom']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_utilisateur_Prenom') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_utilisateur_Prenom&Code_utilisateur=' . mf_Code_utilisateur() . '&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_utilisateur_Prenom');
        }
        $trans['{bouton_modifier_utilisateur_Prenom}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_utilisateur_Prenom') : '');

        // utilisateur_Nom
        if ($mf_droits_defaut['api_modifier__utilisateur_Nom']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_utilisateur_Nom') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_utilisateur_Nom&Code_utilisateur=' . mf_Code_utilisateur() . '&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_utilisateur_Nom');
        }
        $trans['{bouton_modifier_utilisateur_Nom}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_utilisateur_Nom') : '');

        // utilisateur_Adresse_1
        if ($mf_droits_defaut['api_modifier__utilisateur_Adresse_1']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_utilisateur_Adresse_1') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_utilisateur_Adresse_1&Code_utilisateur=' . mf_Code_utilisateur() . '&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_utilisateur_Adresse_1');
        }
        $trans['{bouton_modifier_utilisateur_Adresse_1}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_utilisateur_Adresse_1') : '');

        // utilisateur_Adresse_2
        if ($mf_droits_defaut['api_modifier__utilisateur_Adresse_2']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_utilisateur_Adresse_2') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_utilisateur_Adresse_2&Code_utilisateur=' . mf_Code_utilisateur() . '&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_utilisateur_Adresse_2');
        }
        $trans['{bouton_modifier_utilisateur_Adresse_2}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_utilisateur_Adresse_2') : '');

        // utilisateur_Ville
        if ($mf_droits_defaut['api_modifier__utilisateur_Ville']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_utilisateur_Ville') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_utilisateur_Ville&Code_utilisateur=' . mf_Code_utilisateur() . '&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_utilisateur_Ville');
        }
        $trans['{bouton_modifier_utilisateur_Ville}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_utilisateur_Ville') : '');

        // utilisateur_Code_postal
        if ($mf_droits_defaut['api_modifier__utilisateur_Code_postal']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_utilisateur_Code_postal') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_utilisateur_Code_postal&Code_utilisateur=' . mf_Code_utilisateur() . '&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_utilisateur_Code_postal');
        }
        $trans['{bouton_modifier_utilisateur_Code_postal}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_utilisateur_Code_postal') : '');

        // utilisateur_Date_naissance
        if ($mf_droits_defaut['api_modifier__utilisateur_Date_naissance']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_utilisateur_Date_naissance') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_utilisateur_Date_naissance&Code_utilisateur=' . mf_Code_utilisateur() . '&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_utilisateur_Date_naissance');
        }
        $trans['{bouton_modifier_utilisateur_Date_naissance}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_utilisateur_Date_naissance') : '');

        // utilisateur_Accepte_mail_publicitaire
        if ($mf_droits_defaut['api_modifier__utilisateur_Accepte_mail_publicitaire']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_utilisateur_Accepte_mail_publicitaire') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_utilisateur_Accepte_mail_publicitaire&Code_utilisateur=' . mf_Code_utilisateur() . '&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_utilisateur_Accepte_mail_publicitaire');
        }
        $trans['{bouton_modifier_utilisateur_Accepte_mail_publicitaire}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_utilisateur_Accepte_mail_publicitaire') : '');

        // utilisateur_Administrateur
        if ($mf_droits_defaut['api_modifier__utilisateur_Administrateur']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_utilisateur_Administrateur') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_utilisateur_Administrateur&Code_utilisateur=' . mf_Code_utilisateur() . '&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_utilisateur_Administrateur');
        }
        $trans['{bouton_modifier_utilisateur_Administrateur}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_utilisateur_Administrateur') : '');

        // utilisateur_Fournisseur
        if ($mf_droits_defaut['api_modifier__utilisateur_Fournisseur']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_utilisateur_Fournisseur') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_utilisateur_Fournisseur&Code_utilisateur=' . mf_Code_utilisateur() . '&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_utilisateur_Fournisseur');
        }
        $trans['{bouton_modifier_utilisateur_Fournisseur}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_utilisateur_Fournisseur') : '');

    /* prec_et_suiv */
    if ($db->utilisateur()->mf_compter() < 100) {
        $liste_utilisateur = $db->utilisateur()->mf_lister_contexte();
        // prec
        $prec_et_suiv = prec_suiv($liste_utilisateur, $utilisateur['Code_utilisateur']);
        $prec=['link'=>'', 'title'=>''];
        $suiv=['link'=>'', 'title'=>''];
        if (isset($prec_et_suiv['prec']['Code_utilisateur'])) {
            $prec['link'] = get_nom_page_courante().'?act=apercu_utilisateur&Code_utilisateur=' . $prec_et_suiv['prec']['Code_utilisateur'];
            $prec['title'] = htmlspecialchars(get_titre_ligne_table('utilisateur', $prec_et_suiv['prec']));
        }
        // suiv
        if (isset($prec_et_suiv['suiv']['Code_utilisateur'])) {
            $suiv['link'] = get_nom_page_courante().'?act=apercu_utilisateur&Code_utilisateur=' . $prec_et_suiv['suiv']['Code_utilisateur'];
            $suiv['title'] = htmlspecialchars(get_titre_ligne_table('utilisateur', $prec_et_suiv['suiv']));
        }
        $trans['{pager_utilisateur}'] = get_code_pager($prec, $suiv);
    } else {
        $trans['{pager_utilisateur}'] = '';
    }

    /* utilisateur_Identifiant */
        if ($mf_droits_defaut['api_modifier__utilisateur_Identifiant']) {
            $trans['{utilisateur_Identifiant}'] = ajouter_champ_modifiable_interface(['liste_valeurs_cle_table' => ['Code_utilisateur' => $utilisateur['Code_utilisateur']], 'DB_name' => 'utilisateur_Identifiant', 'valeur_initiale' => $utilisateur['utilisateur_Identifiant']]);
        } else {
            $trans['{utilisateur_Identifiant}'] = get_valeur_html_maj_auto_interface(['liste_valeurs_cle_table' => ['Code_utilisateur' => $utilisateur['Code_utilisateur']], 'DB_name' => 'utilisateur_Identifiant', 'valeur_initiale' => $utilisateur['utilisateur_Identifiant']]);
        }

    /* utilisateur_Password */
        $trans['{utilisateur_Password}'] = get_valeur_html_maj_auto_interface(['liste_valeurs_cle_table' => ['Code_utilisateur' => $utilisateur['Code_utilisateur']], 'DB_name' => 'utilisateur_Password', 'valeur_initiale' => $trans['{bouton_modpwd_utilisateur}'], 'class' => 'html', 'maj_auto' => false ]);

    /* utilisateur_Email */
        if ($mf_droits_defaut['api_modifier__utilisateur_Email']) {
            $trans['{utilisateur_Email}'] = ajouter_champ_modifiable_interface(['liste_valeurs_cle_table' => ['Code_utilisateur' => $utilisateur['Code_utilisateur']], 'DB_name' => 'utilisateur_Email', 'valeur_initiale' => $utilisateur['utilisateur_Email']]);
        } else {
            $trans['{utilisateur_Email}'] = get_valeur_html_maj_auto_interface(['liste_valeurs_cle_table' => ['Code_utilisateur' => $utilisateur['Code_utilisateur']], 'DB_name' => 'utilisateur_Email', 'valeur_initiale' => $utilisateur['utilisateur_Email']]);
        }

    /* utilisateur_Civilite_Type */
        if ($mf_droits_defaut['api_modifier__utilisateur_Civilite_Type']) {
            // en fonction des possibilités, liste choix possibles
            $liste = liste_union_A_et_B([$utilisateur['utilisateur_Civilite_Type']], Hook_utilisateur::workflow__utilisateur_Civilite_Type($utilisateur['utilisateur_Civilite_Type']));
            foreach ($lang_standard['utilisateur_Civilite_Type_'] as $key => $value) {
                if (! in_array($key, $liste) && $key != $utilisateur['utilisateur_Civilite_Type']) {
                    unset($lang_standard['utilisateur_Civilite_Type_'][$key]);
                }
            }
            // champ modifiable
            $trans['{utilisateur_Civilite_Type}'] = ajouter_champ_modifiable_interface(['liste_valeurs_cle_table' => ['Code_utilisateur' => $utilisateur['Code_utilisateur']], 'DB_name' => 'utilisateur_Civilite_Type', 'valeur_initiale' => $utilisateur['utilisateur_Civilite_Type']]);
        } else {
            $trans['{utilisateur_Civilite_Type}'] = get_valeur_html_maj_auto_interface(['liste_valeurs_cle_table' => ['Code_utilisateur' => $utilisateur['Code_utilisateur']], 'DB_name' => 'utilisateur_Civilite_Type', 'valeur_initiale' => $utilisateur['utilisateur_Civilite_Type']]);
        }

    /* utilisateur_Prenom */
        if ($mf_droits_defaut['api_modifier__utilisateur_Prenom']) {
            $trans['{utilisateur_Prenom}'] = ajouter_champ_modifiable_interface(['liste_valeurs_cle_table' => ['Code_utilisateur' => $utilisateur['Code_utilisateur']], 'DB_name' => 'utilisateur_Prenom', 'valeur_initiale' => $utilisateur['utilisateur_Prenom']]);
        } else {
            $trans['{utilisateur_Prenom}'] = get_valeur_html_maj_auto_interface(['liste_valeurs_cle_table' => ['Code_utilisateur' => $utilisateur['Code_utilisateur']], 'DB_name' => 'utilisateur_Prenom', 'valeur_initiale' => $utilisateur['utilisateur_Prenom']]);
        }

    /* utilisateur_Nom */
        if ($mf_droits_defaut['api_modifier__utilisateur_Nom']) {
            $trans['{utilisateur_Nom}'] = ajouter_champ_modifiable_interface(['liste_valeurs_cle_table' => ['Code_utilisateur' => $utilisateur['Code_utilisateur']], 'DB_name' => 'utilisateur_Nom', 'valeur_initiale' => $utilisateur['utilisateur_Nom']]);
        } else {
            $trans['{utilisateur_Nom}'] = get_valeur_html_maj_auto_interface(['liste_valeurs_cle_table' => ['Code_utilisateur' => $utilisateur['Code_utilisateur']], 'DB_name' => 'utilisateur_Nom', 'valeur_initiale' => $utilisateur['utilisateur_Nom']]);
        }

    /* utilisateur_Adresse_1 */
        if ($mf_droits_defaut['api_modifier__utilisateur_Adresse_1']) {
            $trans['{utilisateur_Adresse_1}'] = ajouter_champ_modifiable_interface(['liste_valeurs_cle_table' => ['Code_utilisateur' => $utilisateur['Code_utilisateur']], 'DB_name' => 'utilisateur_Adresse_1', 'valeur_initiale' => $utilisateur['utilisateur_Adresse_1']]);
        } else {
            $trans['{utilisateur_Adresse_1}'] = get_valeur_html_maj_auto_interface(['liste_valeurs_cle_table' => ['Code_utilisateur' => $utilisateur['Code_utilisateur']], 'DB_name' => 'utilisateur_Adresse_1', 'valeur_initiale' => $utilisateur['utilisateur_Adresse_1']]);
        }

    /* utilisateur_Adresse_2 */
        if ($mf_droits_defaut['api_modifier__utilisateur_Adresse_2']) {
            $trans['{utilisateur_Adresse_2}'] = ajouter_champ_modifiable_interface(['liste_valeurs_cle_table' => ['Code_utilisateur' => $utilisateur['Code_utilisateur']], 'DB_name' => 'utilisateur_Adresse_2', 'valeur_initiale' => $utilisateur['utilisateur_Adresse_2']]);
        } else {
            $trans['{utilisateur_Adresse_2}'] = get_valeur_html_maj_auto_interface(['liste_valeurs_cle_table' => ['Code_utilisateur' => $utilisateur['Code_utilisateur']], 'DB_name' => 'utilisateur_Adresse_2', 'valeur_initiale' => $utilisateur['utilisateur_Adresse_2']]);
        }

    /* utilisateur_Ville */
        if ($mf_droits_defaut['api_modifier__utilisateur_Ville']) {
            $trans['{utilisateur_Ville}'] = ajouter_champ_modifiable_interface(['liste_valeurs_cle_table' => ['Code_utilisateur' => $utilisateur['Code_utilisateur']], 'DB_name' => 'utilisateur_Ville', 'valeur_initiale' => $utilisateur['utilisateur_Ville']]);
        } else {
            $trans['{utilisateur_Ville}'] = get_valeur_html_maj_auto_interface(['liste_valeurs_cle_table' => ['Code_utilisateur' => $utilisateur['Code_utilisateur']], 'DB_name' => 'utilisateur_Ville', 'valeur_initiale' => $utilisateur['utilisateur_Ville']]);
        }

    /* utilisateur_Code_postal */
        if ($mf_droits_defaut['api_modifier__utilisateur_Code_postal']) {
            $trans['{utilisateur_Code_postal}'] = ajouter_champ_modifiable_interface(['liste_valeurs_cle_table' => ['Code_utilisateur' => $utilisateur['Code_utilisateur']], 'DB_name' => 'utilisateur_Code_postal', 'valeur_initiale' => $utilisateur['utilisateur_Code_postal']]);
        } else {
            $trans['{utilisateur_Code_postal}'] = get_valeur_html_maj_auto_interface(['liste_valeurs_cle_table' => ['Code_utilisateur' => $utilisateur['Code_utilisateur']], 'DB_name' => 'utilisateur_Code_postal', 'valeur_initiale' => $utilisateur['utilisateur_Code_postal']]);
        }

    /* utilisateur_Date_naissance */
        if ($mf_droits_defaut['api_modifier__utilisateur_Date_naissance']) {
            $trans['{utilisateur_Date_naissance}'] = ajouter_champ_modifiable_interface(['liste_valeurs_cle_table' => ['Code_utilisateur' => $utilisateur['Code_utilisateur']], 'DB_name' => 'utilisateur_Date_naissance', 'valeur_initiale' => $utilisateur['utilisateur_Date_naissance']]);
        } else {
            $trans['{utilisateur_Date_naissance}'] = get_valeur_html_maj_auto_interface(['liste_valeurs_cle_table' => ['Code_utilisateur' => $utilisateur['Code_utilisateur']], 'DB_name' => 'utilisateur_Date_naissance', 'valeur_initiale' => $utilisateur['utilisateur_Date_naissance']]);
        }

    /* utilisateur_Accepte_mail_publicitaire */
        if ($mf_droits_defaut['api_modifier__utilisateur_Accepte_mail_publicitaire']) {
            $trans['{utilisateur_Accepte_mail_publicitaire}'] = ajouter_champ_modifiable_interface(['liste_valeurs_cle_table' => ['Code_utilisateur' => $utilisateur['Code_utilisateur']], 'DB_name' => 'utilisateur_Accepte_mail_publicitaire', 'valeur_initiale' => $utilisateur['utilisateur_Accepte_mail_publicitaire'], 'class' => 'button']);
        } else {
            $trans['{utilisateur_Accepte_mail_publicitaire}'] = get_valeur_html_maj_auto_interface(['liste_valeurs_cle_table' => ['Code_utilisateur' => $utilisateur['Code_utilisateur']], 'DB_name' => 'utilisateur_Accepte_mail_publicitaire', 'valeur_initiale' => $utilisateur['utilisateur_Accepte_mail_publicitaire']]);
        }

    /* utilisateur_Administrateur */
        if ($mf_droits_defaut['api_modifier__utilisateur_Administrateur']) {
            $trans['{utilisateur_Administrateur}'] = ajouter_champ_modifiable_interface(['liste_valeurs_cle_table' => ['Code_utilisateur' => $utilisateur['Code_utilisateur']], 'DB_name' => 'utilisateur_Administrateur', 'valeur_initiale' => $utilisateur['utilisateur_Administrateur'], 'class' => 'button']);
        } else {
            $trans['{utilisateur_Administrateur}'] = get_valeur_html_maj_auto_interface(['liste_valeurs_cle_table' => ['Code_utilisateur' => $utilisateur['Code_utilisateur']], 'DB_name' => 'utilisateur_Administrateur', 'valeur_initiale' => $utilisateur['utilisateur_Administrateur']]);
        }

    /* utilisateur_Fournisseur */
        if ($mf_droits_defaut['api_modifier__utilisateur_Fournisseur']) {
            $trans['{utilisateur_Fournisseur}'] = ajouter_champ_modifiable_interface(['liste_valeurs_cle_table' => ['Code_utilisateur' => $utilisateur['Code_utilisateur']], 'DB_name' => 'utilisateur_Fournisseur', 'valeur_initiale' => $utilisateur['utilisateur_Fournisseur'], 'class' => 'button']);
        } else {
            $trans['{utilisateur_Fournisseur}'] = get_valeur_html_maj_auto_interface(['liste_valeurs_cle_table' => ['Code_utilisateur' => $utilisateur['Code_utilisateur']], 'DB_name' => 'utilisateur_Fournisseur', 'valeur_initiale' => $utilisateur['utilisateur_Fournisseur']]);
        }

/* debut developpement */
include __DIR__ . '/_a_parametre_utilisateur_list.php';
include __DIR__ . '/_commande_list.php';
