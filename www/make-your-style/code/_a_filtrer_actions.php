<?php declare(strict_types=1);

    $est_charge['a_filtrer'] = 1;

    if (! isset($lang_standard['Code_utilisateur_'])) {
        $liste = $db->utilisateur()->mf_lister_contexte(null, ['liste_colonnes_a_selectionner' => mf_liste_colonnes_titre('utilisateur'), OPTION_LIMIT => [0, NB_ELEM_MAX_LANGUE]]);
        if (count($liste) < NB_ELEM_MAX_LANGUE) {
            $lang_standard['Code_utilisateur_'] = [];
            foreach ($liste as $code => $value) {
                $lang_standard['Code_utilisateur_'][$code] = get_titre_ligne_table('utilisateur', $value);
            }
        }
        unset($liste);
    }
    if (! isset($lang_standard['Code_vue_utilisateur_'])) {
        $liste = $db->vue_utilisateur()->mf_lister_contexte(null, ['liste_colonnes_a_selectionner' => mf_liste_colonnes_titre('vue_utilisateur'), OPTION_LIMIT => [0, NB_ELEM_MAX_LANGUE]]);
        if (count($liste) < NB_ELEM_MAX_LANGUE) {
            $lang_standard['Code_vue_utilisateur_'] = [];
            foreach ($liste as $code => $value) {
                $lang_standard['Code_vue_utilisateur_'][$code] = get_titre_ligne_table('vue_utilisateur', $value);
            }
        }
        unset($liste);
    }

/*
    +-----------+
    |  Ajouter  |
    +-----------+
*/
    if ($mf_action == 'ajouter_a_filtrer' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $mf_add = [];
        $mf_add['Code_utilisateur'] = (isset($_POST['Code_utilisateur']) ? (int) $_POST['Code_utilisateur'] : $Code_utilisateur );
        $mf_add['Code_vue_utilisateur'] = (isset($_POST['Code_vue_utilisateur']) ? (int) $_POST['Code_vue_utilisateur'] : $Code_vue_utilisateur );
        $retour = $db->a_filtrer()->mf_ajouter_2( $mf_add );
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_a_filtrer';
            if (! isset($est_charge['utilisateur'])) {
                $Code_utilisateur = (isset($_POST['Code_utilisateur']) ? (int) $_POST['Code_utilisateur'] : 0);
            }
            if (! isset($est_charge['vue_utilisateur'])) {
                $Code_vue_utilisateur = (isset($_POST['Code_vue_utilisateur']) ? (int) $_POST['Code_vue_utilisateur'] : 0);
            }
            $cache->clear();
        } else {
            $cache->clear_current_page();
        }
    }

/*
    +-------------+
    |  Supprimer  |
    +-------------+
*/
    if ($mf_action == 'supprimer_a_filtrer' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $Supprimer = intval($_POST["Supprimer"]);
        if ($Supprimer == 1) {
            $retour = $db->a_filtrer()->mf_supprimer($Code_utilisateur, $Code_vue_utilisateur);
            if ($retour['code_erreur'] == 0) {
                $mf_action = "-";
                $cache->clear();
            } else {
                $cache->clear_current_page();
            }
        } else {
            $mf_action = "apercu_a_filtrer";
            $cache->clear_current_page();
        }
    }
