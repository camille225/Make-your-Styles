<?php declare(strict_types=1);

/** @var array $a_parametre_utilisateur */

    // Actualisation des droits
    Hook_a_parametre_utilisateur::hook_actualiser_les_droits_modifier($a_parametre_utilisateur['Code_utilisateur'], $a_parametre_utilisateur['Code_parametre']);
    Hook_a_parametre_utilisateur::hook_actualiser_les_droits_supprimer($a_parametre_utilisateur['Code_utilisateur'], $a_parametre_utilisateur['Code_parametre']);

    // boutons
        if ($mf_droits_defaut['a_parametre_utilisateur__MODIFIER']) {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_a_parametre_utilisateur') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_a_parametre_utilisateur&Code_utilisateur='.$Code_utilisateur.'&Code_parametre='.$Code_parametre.'&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_a_parametre_utilisateur');
        }
        $trans['{bouton_modifier_a_parametre_utilisateur}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_a_parametre_utilisateur') : '');
        if ($mf_droits_defaut['a_parametre_utilisateur__SUPPRIMER']) {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_SUPPRIMER_PREC . get_nom_colonne('bouton_supprimer_a_parametre_utilisateur') . BOUTON_LIBELLE_SUPPRIMER_SUIV, get_nom_page_courante().'?act=supprimer_a_parametre_utilisateur&Code_utilisateur='.$Code_utilisateur.'&Code_parametre='.$Code_parametre.'&mf_instance=' . get_instance(), 'lien', 'bouton_supprimer_a_parametre_utilisateur');
        }
        $trans['{bouton_supprimer_a_parametre_utilisateur}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_supprimer_a_parametre_utilisateur', BOUTON_CLASSE_SUPPRIMER) : '');

        // a_parametre_utilisateur_Valeur
        if ($mf_droits_defaut['api_modifier__a_parametre_utilisateur_Valeur']) {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_a_parametre_utilisateur_Valeur') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_a_parametre_utilisateur_Valeur&Code_utilisateur='.$Code_utilisateur.'&Code_parametre='.$Code_parametre.'&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_a_parametre_utilisateur_Valeur');
        }
        $trans['{bouton_modifier_a_parametre_utilisateur_Valeur}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_a_parametre_utilisateur_Valeur') : '';

        // a_parametre_utilisateur_Actif
        if ($mf_droits_defaut['api_modifier__a_parametre_utilisateur_Actif']) {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_a_parametre_utilisateur_Actif') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_a_parametre_utilisateur_Actif&Code_utilisateur='.$Code_utilisateur.'&Code_parametre='.$Code_parametre.'&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_a_parametre_utilisateur_Actif');
        }
        $trans['{bouton_modifier_a_parametre_utilisateur_Actif}'] = BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_a_parametre_utilisateur_Actif') : '';

    /* prec_et_suiv */
    if ($db->a_parametre_utilisateur()->mf_compter((isset($est_charge['utilisateur']) ? $mf_contexte['Code_utilisateur'] : 0), (isset($est_charge['parametre']) ? $mf_contexte['Code_parametre'] : 0)) < 100) {
        $liste_a_parametre_utilisateur = $db->a_parametre_utilisateur()->mf_lister_contexte();
        // prec
        $prec_et_suiv = prec_suiv($liste_a_parametre_utilisateur, $a_parametre_utilisateur['Code_utilisateur'].'-'.$a_parametre_utilisateur['Code_parametre']);
        $prec=['link'=>'', 'title'=>''];
        $suiv=['link'=>'', 'title'=>''];
        if (isset($prec_et_suiv['prec']['Code_utilisateur'])) {
            $prec['link'] = get_nom_page_courante().'?act=apercu_a_parametre_utilisateur&Code_utilisateur='.$prec_et_suiv['prec']['Code_utilisateur'].'&Code_parametre='.$prec_et_suiv['prec']['Code_parametre'].'';
            $prec['title'] = htmlspecialchars(get_titre_ligne_table('a_parametre_utilisateur', $prec_et_suiv['prec']));
        }
        // suiv
        if (isset($prec_et_suiv['suiv']['Code_utilisateur'])) {
            $suiv['link'] = get_nom_page_courante().'?act=apercu_a_parametre_utilisateur&Code_utilisateur='.$prec_et_suiv['suiv']['Code_utilisateur'].'&Code_parametre='.$prec_et_suiv['suiv']['Code_parametre'].'';
            $suiv['title'] = htmlspecialchars(get_titre_ligne_table('a_parametre_utilisateur', $prec_et_suiv['suiv']));
        }
        $trans['{pager_a_parametre_utilisateur}'] = get_code_pager($prec, $suiv);
    } else {
        $trans['{pager_a_parametre_utilisateur}'] = '';
    }

    /* Code_utilisateur */
        $trans['{Code_utilisateur}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => ['Code_utilisateur'=>$a_parametre_utilisateur['Code_utilisateur'], 'Code_parametre'=>$a_parametre_utilisateur['Code_parametre']], 'DB_name' => 'Code_utilisateur' , 'valeur_initiale' => $a_parametre_utilisateur['Code_utilisateur'] ]);

    /* Code_parametre */
        $trans['{Code_parametre}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => ['Code_utilisateur'=>$a_parametre_utilisateur['Code_utilisateur'], 'Code_parametre'=>$a_parametre_utilisateur['Code_parametre']], 'DB_name' => 'Code_parametre' , 'valeur_initiale' => $a_parametre_utilisateur['Code_parametre'] ]);

    /* a_parametre_utilisateur_Valeur */
        if ($mf_droits_defaut['api_modifier__a_parametre_utilisateur_Valeur']) {
            $trans['{a_parametre_utilisateur_Valeur}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => ['Code_utilisateur'=>$a_parametre_utilisateur['Code_utilisateur'], 'Code_parametre'=>$a_parametre_utilisateur['Code_parametre']] , 'DB_name' => 'a_parametre_utilisateur_Valeur' , 'valeur_initiale' => $a_parametre_utilisateur['a_parametre_utilisateur_Valeur'] ]);
        } else {
            $trans['{a_parametre_utilisateur_Valeur}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => ['Code_utilisateur'=>$a_parametre_utilisateur['Code_utilisateur'], 'Code_parametre'=>$a_parametre_utilisateur['Code_parametre']] , 'DB_name' => 'a_parametre_utilisateur_Valeur' , 'valeur_initiale' => $a_parametre_utilisateur['a_parametre_utilisateur_Valeur'] ]);
        }

    /* a_parametre_utilisateur_Actif */
        if ($mf_droits_defaut['api_modifier__a_parametre_utilisateur_Actif']) {
            $trans['{a_parametre_utilisateur_Actif}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => ['Code_utilisateur'=>$a_parametre_utilisateur['Code_utilisateur'], 'Code_parametre'=>$a_parametre_utilisateur['Code_parametre']] , 'DB_name' => 'a_parametre_utilisateur_Actif' , 'valeur_initiale' => $a_parametre_utilisateur['a_parametre_utilisateur_Actif'] ]);
        } else {
            $trans['{a_parametre_utilisateur_Actif}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => ['Code_utilisateur'=>$a_parametre_utilisateur['Code_utilisateur'], 'Code_parametre'=>$a_parametre_utilisateur['Code_parametre']] , 'DB_name' => 'a_parametre_utilisateur_Actif' , 'valeur_initiale' => $a_parametre_utilisateur['a_parametre_utilisateur_Actif'] ]);
        }

