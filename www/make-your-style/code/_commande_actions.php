<?php declare(strict_types=1);

/** @var TYPE_NAME $mf_action */

    $est_charge['commande'] = 1;

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

/*
    +-----------+
    |  Ajouter  |
    +-----------+
*/
    if ($mf_action == 'ajouter_commande' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $mf_add = [];
        if (isset($_POST['commande_Prix_total'])) {$mf_add['commande_Prix_total'] = $_POST['commande_Prix_total'];}
        if (isset($_POST['commande_Date_livraison'])) {$mf_add['commande_Date_livraison'] = $_POST['commande_Date_livraison'];}
        if (isset($_POST['commande_Date_creation'])) {$mf_add['commande_Date_creation'] = $_POST['commande_Date_creation'];}
        $mf_add['Code_utilisateur'] = (isset($_POST['Code_utilisateur']) ? (int) $_POST['Code_utilisateur'] : $Code_utilisateur);
        $retour = $db->commande()->mf_ajouter_2($mf_add);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_commande';
            $Code_commande = $retour['Code_commande'];
            $mf_contexte['Code_commande'] = $retour['Code_commande'];
            $cache->clear();
        } else {
            $cache->clear_current_page();
        }
    }

/*
    +---------+
    |  Creer  |
    +---------+
*/
    if ($mf_action == 'creer_commande') {
        $retour = $db->commande()->mf_creer(mf_Code_utilisateur());
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_commande';
            $Code_commande =  $retour['Code_commande'];
            $mf_contexte['Code_commande'] = $retour['Code_commande'];
            $cache->clear();
        } else {
            $cache->clear_current_page();
        }
    }

/*
    +------------+
    |  Modifier  |
    +------------+
*/
    if ($mf_action == 'modifier_commande' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $mf_update = [];
        if (isset($_POST['commande_Prix_total'])) { $mf_update['commande_Prix_total'] = $_POST['commande_Prix_total']; }
        if (isset($_POST['commande_Date_livraison'])) { $mf_update['commande_Date_livraison'] = $_POST['commande_Date_livraison']; }
        if (isset($_POST['commande_Date_creation'])) { $mf_update['commande_Date_creation'] = $_POST['commande_Date_creation']; }
        if (isset($_POST['Code_utilisateur'])) { $mf_update['Code_utilisateur'] = (int) $_POST['Code_utilisateur']; }
        $retour = $db->commande()->mf_modifier_2([$Code_commande => $mf_update]);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_commande';
            $cache->clear();
        } else {
            $cache->clear_current_page();
        }
    }

    if ($mf_action == 'modifier_commande_Prix_total' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $commande_Prix_total = $_POST['commande_Prix_total'];
        $retour = $db->commande()->mf_modifier_2([$Code_commande => ['commande_Prix_total' => $commande_Prix_total]]);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_commande';
            $cache->clear();
        } else {
            $cache->clear_current_page();
        }
    }

    if ($mf_action == 'modifier_commande_Date_livraison' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $commande_Date_livraison = $_POST['commande_Date_livraison'];
        $retour = $db->commande()->mf_modifier_2([$Code_commande => ['commande_Date_livraison' => $commande_Date_livraison]]);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_commande';
            $cache->clear();
        } else {
            $cache->clear_current_page();
        }
    }

    if ($mf_action == 'modifier_commande_Date_creation' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $commande_Date_creation = $_POST['commande_Date_creation'];
        $retour = $db->commande()->mf_modifier_2([$Code_commande => ['commande_Date_creation' => $commande_Date_creation]]);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_commande';
            $cache->clear();
        } else {
            $cache->clear_current_page();
        }
    }

    if ($mf_action == 'modifier_commande__Code_utilisateur' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $retour = $db->commande()->mf_modifier_2([$Code_commande => ['Code_utilisateur' => (isset($_POST['Code_utilisateur']) ? (int) $_POST['Code_utilisateur'] : $Code_utilisateur)]]);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_commande';
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
    if ($mf_action == "supprimer_commande" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $Supprimer = intval($_POST["Supprimer"]);
        if ($Supprimer == 1) {
            $retour = $db->commande()->mf_supprimer($Code_commande);
            if ($retour['code_erreur'] == 0) {
                $mf_action = "-";
                $cache->clear();
                $Code_commande = 0;
            } else {
                $cache->clear_current_page();
            }
        } else {
            $mf_action = "apercu_commande";
            $cache->clear_current_page();
        }
    }
