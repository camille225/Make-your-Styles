<?php declare(strict_types=1);

/** @var array $a_filtrer */

    // Actualisation des droits
    Hook_a_filtrer::hook_actualiser_les_droits_supprimer();

    // boutons
        if ($mf_droits_defaut['a_filtrer__SUPPRIMER']) {
            $menu_a_droite->ajouter_bouton( BOUTON_LIBELLE_SUPPRIMER_PREC . get_nom_colonne('bouton_supprimer_a_filtrer') . BOUTON_LIBELLE_SUPPRIMER_SUIV, get_nom_page_courante().'?act=supprimer_a_filtrer&Code_utilisateur='.$Code_utilisateur.'&Code_vue_utilisateur='.$Code_vue_utilisateur.'&mf_instance=' . get_instance(), 'lien', 'bouton_supprimer_a_filtrer');
        }
        $trans['{bouton_supprimer_a_filtrer}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_supprimer_a_filtrer', BOUTON_CLASSE_SUPPRIMER) : '');

    /* prec_et_suiv */
    if ($db->a_filtrer()->mf_compter((isset($est_charge['utilisateur']) ? $mf_contexte['Code_utilisateur'] : 0), (isset($est_charge['vue_utilisateur']) ? $mf_contexte['Code_vue_utilisateur'] : 0)) < 100) {
        $liste_a_filtrer = $db->a_filtrer()->mf_lister_contexte();
        // prec
        $prec_et_suiv = prec_suiv($liste_a_filtrer, $a_filtrer['Code_utilisateur'].'-'.$a_filtrer['Code_vue_utilisateur']);
        $prec=['link'=>'', 'title'=>''];
        $suiv=['link'=>'', 'title'=>''];
        if (isset($prec_et_suiv['prec']['Code_utilisateur'])) {
            $prec['link'] = get_nom_page_courante().'?act=apercu_a_filtrer&Code_utilisateur='.$prec_et_suiv['prec']['Code_utilisateur'].'&Code_vue_utilisateur='.$prec_et_suiv['prec']['Code_vue_utilisateur'].'';
            $prec['title'] = htmlspecialchars(get_titre_ligne_table('a_filtrer', $prec_et_suiv['prec']));
        }
        // suiv
        if (isset($prec_et_suiv['suiv']['Code_utilisateur'])) {
            $suiv['link'] = get_nom_page_courante().'?act=apercu_a_filtrer&Code_utilisateur='.$prec_et_suiv['suiv']['Code_utilisateur'].'&Code_vue_utilisateur='.$prec_et_suiv['suiv']['Code_vue_utilisateur'].'';
            $suiv['title'] = htmlspecialchars(get_titre_ligne_table('a_filtrer', $prec_et_suiv['suiv']));
        }
        $trans['{pager_a_filtrer}'] = get_code_pager($prec, $suiv);
    } else {
        $trans['{pager_a_filtrer}'] = '';
    }

    /* Code_utilisateur */
        $trans['{Code_utilisateur}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => ['Code_utilisateur'=>$a_filtrer['Code_utilisateur'], 'Code_vue_utilisateur'=>$a_filtrer['Code_vue_utilisateur']], 'DB_name' => 'Code_utilisateur' , 'valeur_initiale' => $a_filtrer['Code_utilisateur'] ]);

    /* Code_vue_utilisateur */
        $trans['{Code_vue_utilisateur}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => ['Code_utilisateur'=>$a_filtrer['Code_utilisateur'], 'Code_vue_utilisateur'=>$a_filtrer['Code_vue_utilisateur']], 'DB_name' => 'Code_vue_utilisateur' , 'valeur_initiale' => $a_filtrer['Code_vue_utilisateur'] ]);

