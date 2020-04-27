<?php declare(strict_types=1);

/** @var TYPE_NAME $mf_action */

    $est_charge['conseil'] = 1;

/*
    +-----------+
    |  Ajouter  |
    +-----------+
*/
    if ($mf_action == 'ajouter_conseil' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $mf_add = [];
        if (isset($_POST['conseil_Libelle'])) {$mf_add['conseil_Libelle'] = $_POST['conseil_Libelle'];}
        if (isset($_POST['conseil_Description'])) {$mf_add['conseil_Description'] = $_POST['conseil_Description'];}
        if (isset($_POST['conseil_Actif'])) {$mf_add['conseil_Actif'] = $_POST['conseil_Actif'];}
        $retour = $db->conseil()->mf_ajouter_2($mf_add);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_conseil';
            $Code_conseil = $retour['Code_conseil'];
            $mf_contexte['Code_conseil'] = $retour['Code_conseil'];
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
    if ($mf_action == 'creer_conseil') {
        $retour = $db->conseil()->mf_creer();
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_conseil';
            $Code_conseil =  $retour['Code_conseil'];
            $mf_contexte['Code_conseil'] = $retour['Code_conseil'];
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
    if ($mf_action == 'modifier_conseil' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $mf_update = [];
        if (isset($_POST['conseil_Libelle'])) { $mf_update['conseil_Libelle'] = $_POST['conseil_Libelle']; }
        if (isset($_POST['conseil_Description'])) { $mf_update['conseil_Description'] = $_POST['conseil_Description']; }
        if (isset($_POST['conseil_Actif'])) { $mf_update['conseil_Actif'] = $_POST['conseil_Actif']; }
        $retour = $db->conseil()->mf_modifier_2([$Code_conseil => $mf_update]);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_conseil';
            $cache->clear();
        } else {
            $cache->clear_current_page();
        }
    }

    if ($mf_action == 'modifier_conseil_Libelle' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $conseil_Libelle = $_POST['conseil_Libelle'];
        $retour = $db->conseil()->mf_modifier_2([$Code_conseil => ['conseil_Libelle' => $conseil_Libelle]]);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_conseil';
            $cache->clear();
        } else {
            $cache->clear_current_page();
        }
    }

    if ($mf_action == 'modifier_conseil_Description' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $conseil_Description = $_POST['conseil_Description'];
        $retour = $db->conseil()->mf_modifier_2([$Code_conseil => ['conseil_Description' => $conseil_Description]]);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_conseil';
            $cache->clear();
        } else {
            $cache->clear_current_page();
        }
    }

    if ($mf_action == 'modifier_conseil_Actif' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $conseil_Actif = $_POST['conseil_Actif'];
        $retour = $db->conseil()->mf_modifier_2([$Code_conseil => ['conseil_Actif' => $conseil_Actif]]);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_conseil';
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
    if ($mf_action == "supprimer_conseil" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $Supprimer = intval($_POST["Supprimer"]);
        if ($Supprimer == 1) {
            $retour = $db->conseil()->mf_supprimer($Code_conseil);
            if ($retour['code_erreur'] == 0) {
                $mf_action = "-";
                $cache->clear();
                $Code_conseil = 0;
            } else {
                $cache->clear_current_page();
            }
        } else {
            $mf_action = "apercu_conseil";
            $cache->clear_current_page();
        }
    }
