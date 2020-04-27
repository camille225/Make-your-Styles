<?php declare(strict_types=1);

/** @var array $commande */

    // Actualisation des droits
    Hook_commande::hook_actualiser_les_droits_modifier($commande['Code_commande']);
    Hook_commande::hook_actualiser_les_droits_supprimer($commande['Code_commande']);

    // boutons
        if ($mf_droits_defaut['commande__MODIFIER']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_commande') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante() . '?act=modifier_commande&Code_commande=' . mf_Code_commande() . '&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_commande');
        }
        $trans['{bouton_modifier_commande}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_commande') : '');
        if ($mf_droits_defaut['commande__SUPPRIMER']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_SUPPRIMER_PREC . get_nom_colonne('bouton_supprimer_commande') . BOUTON_LIBELLE_SUPPRIMER_SUIV, get_nom_page_courante() . '?act=supprimer_commande&Code_commande=' . mf_Code_commande() . '&mf_instance=' . get_instance(), 'lien', 'bouton_supprimer_commande');
        }
        $trans['{bouton_supprimer_commande}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_supprimer_commande', BOUTON_CLASSE_SUPPRIMER) : '');

        // commande_Prix_total
        if ($mf_droits_defaut['api_modifier__commande_Prix_total']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_commande_Prix_total') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_commande_Prix_total&Code_commande=' . mf_Code_commande() . '&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_commande_Prix_total');
        }
        $trans['{bouton_modifier_commande_Prix_total}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_commande_Prix_total') : '');

        // commande_Date_livraison
        if ($mf_droits_defaut['api_modifier__commande_Date_livraison']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_commande_Date_livraison') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_commande_Date_livraison&Code_commande=' . mf_Code_commande() . '&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_commande_Date_livraison');
        }
        $trans['{bouton_modifier_commande_Date_livraison}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_commande_Date_livraison') : '');

        // commande_Date_creation
        if ($mf_droits_defaut['api_modifier__commande_Date_creation']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_commande_Date_creation') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_commande_Date_creation&Code_commande=' . mf_Code_commande() . '&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_commande_Date_creation');
        }
        $trans['{bouton_modifier_commande_Date_creation}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_commande_Date_creation') : '');

        // Code_utilisateur
        if ($mf_droits_defaut['api_modifier_ref__commande__Code_utilisateur']) {
            $menu_a_droite->ajouter_bouton(BOUTON_LIBELLE_MODIFIER_PREC . get_nom_colonne('bouton_modifier_commande__Code_utilisateur') . BOUTON_LIBELLE_MODIFIER_SUIV, get_nom_page_courante().'?act=modifier_commande__Code_utilisateur&Code_commande=' . mf_Code_commande() . '&mf_instance=' . get_instance(), 'lien', 'bouton_modifier_commande__Code_utilisateur');
        }
        $trans['{bouton_modifier_commande__Code_utilisateur}'] = (BOUTON_INTEGRABLE ? $menu_a_droite->generer_code_bouton('bouton_modifier_commande__Code_utilisateur') : '');

    /* prec_et_suiv */
    if ($db->commande()->mf_compter((isset($est_charge['utilisateur']) ? $mf_contexte['Code_utilisateur'] : 0)) < 100) {
        $liste_commande = $db->commande()->mf_lister_contexte();
        // prec
        $prec_et_suiv = prec_suiv($liste_commande, $commande['Code_commande']);
        $prec=['link'=>'', 'title'=>''];
        $suiv=['link'=>'', 'title'=>''];
        if (isset($prec_et_suiv['prec']['Code_commande'])) {
            $prec['link'] = get_nom_page_courante().'?act=apercu_commande&Code_commande=' . $prec_et_suiv['prec']['Code_commande'];
            $prec['title'] = htmlspecialchars(get_titre_ligne_table('commande', $prec_et_suiv['prec']));
        }
        // suiv
        if (isset($prec_et_suiv['suiv']['Code_commande'])) {
            $suiv['link'] = get_nom_page_courante().'?act=apercu_commande&Code_commande=' . $prec_et_suiv['suiv']['Code_commande'];
            $suiv['title'] = htmlspecialchars(get_titre_ligne_table('commande', $prec_et_suiv['suiv']));
        }
        $trans['{pager_commande}'] = get_code_pager($prec, $suiv);
    } else {
        $trans['{pager_commande}'] = '';
    }

    /* commande_Prix_total */
        if ($mf_droits_defaut['api_modifier__commande_Prix_total']) {
            $trans['{commande_Prix_total}'] = ajouter_champ_modifiable_interface(['liste_valeurs_cle_table' => ['Code_commande' => $commande['Code_commande']], 'DB_name' => 'commande_Prix_total', 'valeur_initiale' => $commande['commande_Prix_total']]);
        } else {
            $trans['{commande_Prix_total}'] = get_valeur_html_maj_auto_interface(['liste_valeurs_cle_table' => ['Code_commande' => $commande['Code_commande']], 'DB_name' => 'commande_Prix_total', 'valeur_initiale' => $commande['commande_Prix_total']]);
        }

    /* commande_Date_livraison */
        if ($mf_droits_defaut['api_modifier__commande_Date_livraison']) {
            $trans['{commande_Date_livraison}'] = ajouter_champ_modifiable_interface(['liste_valeurs_cle_table' => ['Code_commande' => $commande['Code_commande']], 'DB_name' => 'commande_Date_livraison', 'valeur_initiale' => $commande['commande_Date_livraison']]);
        } else {
            $trans['{commande_Date_livraison}'] = get_valeur_html_maj_auto_interface(['liste_valeurs_cle_table' => ['Code_commande' => $commande['Code_commande']], 'DB_name' => 'commande_Date_livraison', 'valeur_initiale' => $commande['commande_Date_livraison']]);
        }

    /* commande_Date_creation */
        if ($mf_droits_defaut['api_modifier__commande_Date_creation']) {
            $trans['{commande_Date_creation}'] = ajouter_champ_modifiable_interface(['liste_valeurs_cle_table' => ['Code_commande' => $commande['Code_commande']], 'DB_name' => 'commande_Date_creation', 'valeur_initiale' => $commande['commande_Date_creation']]);
        } else {
            $trans['{commande_Date_creation}'] = get_valeur_html_maj_auto_interface(['liste_valeurs_cle_table' => ['Code_commande' => $commande['Code_commande']], 'DB_name' => 'commande_Date_creation', 'valeur_initiale' => $commande['commande_Date_creation']]);
        }

    /* Code_utilisateur */
        if ($mf_droits_defaut['api_modifier_ref__commande__Code_utilisateur']) {
            $trans['{Code_utilisateur}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => ['Code_commande' => $commande['Code_commande']], 'DB_name' => 'Code_utilisateur' , 'valeur_initiale' => $commande['Code_utilisateur'] , 'nom_table' => 'commande' ]);
        } else {
            $trans['{Code_utilisateur}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => ['Code_commande' => $commande['Code_commande']], 'DB_name' => 'Code_utilisateur' , 'valeur_initiale' => $commande['Code_utilisateur'] , 'nom_table' => 'commande' ]);
        }

