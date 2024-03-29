<?php declare(strict_types=1);

    $est_charge['a_parametre_utilisateur'] = 1;

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
    if (! isset($lang_standard['Code_parametre_'])) {
        $liste = $db->parametre()->mf_lister_contexte(null, ['liste_colonnes_a_selectionner' => mf_liste_colonnes_titre('parametre'), OPTION_LIMIT => [0, NB_ELEM_MAX_LANGUE]]);
        if (count($liste) < NB_ELEM_MAX_LANGUE) {
            $lang_standard['Code_parametre_'] = [];
            foreach ($liste as $code => $value) {
                $lang_standard['Code_parametre_'][$code] = get_titre_ligne_table('parametre', $value);
            }
        }
        unset($liste);
    }

/*
    +-----------+
    |  Ajouter  |
    +-----------+
*/
    if ($mf_action == 'ajouter_a_parametre_utilisateur' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $mf_add = [];
        $mf_add['Code_utilisateur'] = (isset($_POST['Code_utilisateur']) ? (int) $_POST['Code_utilisateur'] : $Code_utilisateur );
        $mf_add['Code_parametre'] = (isset($_POST['Code_parametre']) ? (int) $_POST['Code_parametre'] : $Code_parametre );
        if (isset($_POST['a_parametre_utilisateur_Valeur'])) {
            $mf_add['a_parametre_utilisateur_Valeur'] = $_POST['a_parametre_utilisateur_Valeur'];
        }
        if (isset($_POST['a_parametre_utilisateur_Actif'])) {
            $mf_add['a_parametre_utilisateur_Actif'] = $_POST['a_parametre_utilisateur_Actif'];
        }
        $retour = $db->a_parametre_utilisateur()->mf_ajouter_2( $mf_add );
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_a_parametre_utilisateur';
            if (! isset($est_charge['utilisateur'])) {
                $Code_utilisateur = (isset($_POST['Code_utilisateur']) ? (int) $_POST['Code_utilisateur'] : 0);
            }
            if (! isset($est_charge['parametre'])) {
                $Code_parametre = (isset($_POST['Code_parametre']) ? (int) $_POST['Code_parametre'] : 0);
            }
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
    if ($mf_action == 'modifier_a_parametre_utilisateur' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $mf_update = [];
        $mf_update['Code_utilisateur'] = $Code_utilisateur;
        $mf_update['Code_parametre'] = $Code_parametre;
        if (isset($_POST['a_parametre_utilisateur_Valeur'])) {
            $mf_update['a_parametre_utilisateur_Valeur'] = $_POST['a_parametre_utilisateur_Valeur'];
        }
        if (isset($_POST['a_parametre_utilisateur_Actif'])) {
            $mf_update['a_parametre_utilisateur_Actif'] = $_POST['a_parametre_utilisateur_Actif'];
        }
        $retour = $db->a_parametre_utilisateur()->mf_modifier_2($mf_update);
        if ($retour['code_erreur'] == 0) {
            $mf_action = "apercu_a_parametre_utilisateur";
            $cache->clear();
        } else {
            $cache->clear_current_page();
        }
    }

    if ($mf_action == 'modifier_a_parametre_utilisateur_Valeur' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $a_parametre_utilisateur_Valeur = $_POST['a_parametre_utilisateur_Valeur'];
        $retour = $db->a_parametre_utilisateur()->mf_modifier_2([['Code_utilisateur' => $Code_utilisateur , 'Code_parametre' => $Code_parametre , 'a_parametre_utilisateur_Valeur' => $a_parametre_utilisateur_Valeur]]);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_a_parametre_utilisateur';
            $cache->clear();
        } else {
            $cache->clear_current_page();
        }
    }

    if ($mf_action == 'modifier_a_parametre_utilisateur_Actif' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $a_parametre_utilisateur_Actif = $_POST['a_parametre_utilisateur_Actif'];
        $retour = $db->a_parametre_utilisateur()->mf_modifier_2([['Code_utilisateur' => $Code_utilisateur , 'Code_parametre' => $Code_parametre , 'a_parametre_utilisateur_Actif' => $a_parametre_utilisateur_Actif]]);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_a_parametre_utilisateur';
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
    if ($mf_action == 'supprimer_a_parametre_utilisateur' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $Supprimer = intval($_POST["Supprimer"]);
        if ($Supprimer == 1) {
            $retour = $db->a_parametre_utilisateur()->mf_supprimer($Code_utilisateur, $Code_parametre);
            if ($retour['code_erreur'] == 0) {
                $mf_action = "-";
                $cache->clear();
            } else {
                $cache->clear_current_page();
            }
        } else {
            $mf_action = "apercu_a_parametre_utilisateur";
            $cache->clear_current_page();
        }
    }
