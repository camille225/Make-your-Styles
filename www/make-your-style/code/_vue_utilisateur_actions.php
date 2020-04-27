<?php declare(strict_types=1);

/** @var TYPE_NAME $mf_action */

    $est_charge['vue_utilisateur'] = 1;

/*
    +-----------+
    |  Ajouter  |
    +-----------+
*/
    if ($mf_action == 'ajouter_vue_utilisateur' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $mf_add = [];
        if (isset($_POST['vue_utilisateur_Recherche'])) {$mf_add['vue_utilisateur_Recherche'] = $_POST['vue_utilisateur_Recherche'];}
        if (isset($_POST['vue_utilisateur_Filtre_Saison_Type'])) {$mf_add['vue_utilisateur_Filtre_Saison_Type'] = $_POST['vue_utilisateur_Filtre_Saison_Type'];}
        if (isset($_POST['vue_utilisateur_Filtre_Couleur'])) {$mf_add['vue_utilisateur_Filtre_Couleur'] = $_POST['vue_utilisateur_Filtre_Couleur'];}
        if (isset($_POST['vue_utilisateur_Filtre_Taille_Pays_Type'])) {$mf_add['vue_utilisateur_Filtre_Taille_Pays_Type'] = $_POST['vue_utilisateur_Filtre_Taille_Pays_Type'];}
        if (isset($_POST['vue_utilisateur_Filtre_Taille_Max'])) {$mf_add['vue_utilisateur_Filtre_Taille_Max'] = $_POST['vue_utilisateur_Filtre_Taille_Max'];}
        if (isset($_POST['vue_utilisateur_Filtre_Taille_Min'])) {$mf_add['vue_utilisateur_Filtre_Taille_Min'] = $_POST['vue_utilisateur_Filtre_Taille_Min'];}
        $retour = $db->vue_utilisateur()->mf_ajouter_2($mf_add);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_vue_utilisateur';
            $Code_vue_utilisateur = $retour['Code_vue_utilisateur'];
            $mf_contexte['Code_vue_utilisateur'] = $retour['Code_vue_utilisateur'];
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
    if ($mf_action == 'creer_vue_utilisateur') {
        $retour = $db->vue_utilisateur()->mf_creer();
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_vue_utilisateur';
            $Code_vue_utilisateur =  $retour['Code_vue_utilisateur'];
            $mf_contexte['Code_vue_utilisateur'] = $retour['Code_vue_utilisateur'];
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
    if ($mf_action == 'modifier_vue_utilisateur' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $mf_update = [];
        if (isset($_POST['vue_utilisateur_Recherche'])) { $mf_update['vue_utilisateur_Recherche'] = $_POST['vue_utilisateur_Recherche']; }
        if (isset($_POST['vue_utilisateur_Filtre_Saison_Type'])) { $mf_update['vue_utilisateur_Filtre_Saison_Type'] = $_POST['vue_utilisateur_Filtre_Saison_Type']; }
        if (isset($_POST['vue_utilisateur_Filtre_Couleur'])) { $mf_update['vue_utilisateur_Filtre_Couleur'] = $_POST['vue_utilisateur_Filtre_Couleur']; }
        if (isset($_POST['vue_utilisateur_Filtre_Taille_Pays_Type'])) { $mf_update['vue_utilisateur_Filtre_Taille_Pays_Type'] = $_POST['vue_utilisateur_Filtre_Taille_Pays_Type']; }
        if (isset($_POST['vue_utilisateur_Filtre_Taille_Max'])) { $mf_update['vue_utilisateur_Filtre_Taille_Max'] = $_POST['vue_utilisateur_Filtre_Taille_Max']; }
        if (isset($_POST['vue_utilisateur_Filtre_Taille_Min'])) { $mf_update['vue_utilisateur_Filtre_Taille_Min'] = $_POST['vue_utilisateur_Filtre_Taille_Min']; }
        $retour = $db->vue_utilisateur()->mf_modifier_2([$Code_vue_utilisateur => $mf_update]);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_vue_utilisateur';
            $cache->clear();
        } else {
            $cache->clear_current_page();
        }
    }

    if ($mf_action == 'modifier_vue_utilisateur_Recherche' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $vue_utilisateur_Recherche = $_POST['vue_utilisateur_Recherche'];
        $retour = $db->vue_utilisateur()->mf_modifier_2([$Code_vue_utilisateur => ['vue_utilisateur_Recherche' => $vue_utilisateur_Recherche]]);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_vue_utilisateur';
            $cache->clear();
        } else {
            $cache->clear_current_page();
        }
    }

    if ($mf_action == 'modifier_vue_utilisateur_Filtre_Saison_Type' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $vue_utilisateur_Filtre_Saison_Type = $_POST['vue_utilisateur_Filtre_Saison_Type'];
        $retour = $db->vue_utilisateur()->mf_modifier_2([$Code_vue_utilisateur => ['vue_utilisateur_Filtre_Saison_Type' => $vue_utilisateur_Filtre_Saison_Type]]);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_vue_utilisateur';
            $cache->clear();
        } else {
            $cache->clear_current_page();
        }
    }

    if ($mf_action == 'modifier_vue_utilisateur_Filtre_Couleur' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $vue_utilisateur_Filtre_Couleur = $_POST['vue_utilisateur_Filtre_Couleur'];
        $retour = $db->vue_utilisateur()->mf_modifier_2([$Code_vue_utilisateur => ['vue_utilisateur_Filtre_Couleur' => $vue_utilisateur_Filtre_Couleur]]);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_vue_utilisateur';
            $cache->clear();
        } else {
            $cache->clear_current_page();
        }
    }

    if ($mf_action == 'modifier_vue_utilisateur_Filtre_Taille_Pays_Type' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $vue_utilisateur_Filtre_Taille_Pays_Type = $_POST['vue_utilisateur_Filtre_Taille_Pays_Type'];
        $retour = $db->vue_utilisateur()->mf_modifier_2([$Code_vue_utilisateur => ['vue_utilisateur_Filtre_Taille_Pays_Type' => $vue_utilisateur_Filtre_Taille_Pays_Type]]);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_vue_utilisateur';
            $cache->clear();
        } else {
            $cache->clear_current_page();
        }
    }

    if ($mf_action == 'modifier_vue_utilisateur_Filtre_Taille_Max' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $vue_utilisateur_Filtre_Taille_Max = $_POST['vue_utilisateur_Filtre_Taille_Max'];
        $retour = $db->vue_utilisateur()->mf_modifier_2([$Code_vue_utilisateur => ['vue_utilisateur_Filtre_Taille_Max' => $vue_utilisateur_Filtre_Taille_Max]]);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_vue_utilisateur';
            $cache->clear();
        } else {
            $cache->clear_current_page();
        }
    }

    if ($mf_action == 'modifier_vue_utilisateur_Filtre_Taille_Min' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $vue_utilisateur_Filtre_Taille_Min = $_POST['vue_utilisateur_Filtre_Taille_Min'];
        $retour = $db->vue_utilisateur()->mf_modifier_2([$Code_vue_utilisateur => ['vue_utilisateur_Filtre_Taille_Min' => $vue_utilisateur_Filtre_Taille_Min]]);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_vue_utilisateur';
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
    if ($mf_action == "supprimer_vue_utilisateur" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $Supprimer = intval($_POST["Supprimer"]);
        if ($Supprimer == 1) {
            $retour = $db->vue_utilisateur()->mf_supprimer($Code_vue_utilisateur);
            if ($retour['code_erreur'] == 0) {
                $mf_action = "-";
                $cache->clear();
                $Code_vue_utilisateur = 0;
            } else {
                $cache->clear_current_page();
            }
        } else {
            $mf_action = "apercu_vue_utilisateur";
            $cache->clear_current_page();
        }
    }
