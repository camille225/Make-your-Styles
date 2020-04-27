<?php declare(strict_types=1);

/** @var TYPE_NAME $mf_action */

    $est_charge['categorie_article'] = 1;

/*
    +-----------+
    |  Ajouter  |
    +-----------+
*/
    if ($mf_action == 'ajouter_categorie_article' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $mf_add = [];
        if (isset($_POST['categorie_article_Libelle'])) {$mf_add['categorie_article_Libelle'] = $_POST['categorie_article_Libelle'];}
        $retour = $db->categorie_article()->mf_ajouter_2($mf_add);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_categorie_article';
            $Code_categorie_article = $retour['Code_categorie_article'];
            $mf_contexte['Code_categorie_article'] = $retour['Code_categorie_article'];
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
    if ($mf_action == 'creer_categorie_article') {
        $retour = $db->categorie_article()->mf_creer();
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_categorie_article';
            $Code_categorie_article =  $retour['Code_categorie_article'];
            $mf_contexte['Code_categorie_article'] = $retour['Code_categorie_article'];
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
    if ($mf_action == 'modifier_categorie_article' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $mf_update = [];
        if (isset($_POST['categorie_article_Libelle'])) { $mf_update['categorie_article_Libelle'] = $_POST['categorie_article_Libelle']; }
        $retour = $db->categorie_article()->mf_modifier_2([$Code_categorie_article => $mf_update]);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_categorie_article';
            $cache->clear();
        } else {
            $cache->clear_current_page();
        }
    }

    if ($mf_action == 'modifier_categorie_article_Libelle' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $categorie_article_Libelle = $_POST['categorie_article_Libelle'];
        $retour = $db->categorie_article()->mf_modifier_2([$Code_categorie_article => ['categorie_article_Libelle' => $categorie_article_Libelle]]);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_categorie_article';
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
    if ($mf_action == "supprimer_categorie_article" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $Supprimer = intval($_POST["Supprimer"]);
        if ($Supprimer == 1) {
            $retour = $db->categorie_article()->mf_supprimer($Code_categorie_article);
            if ($retour['code_erreur'] == 0) {
                $mf_action = "-";
                $cache->clear();
                $Code_categorie_article = 0;
            } else {
                $cache->clear_current_page();
            }
        } else {
            $mf_action = "apercu_categorie_article";
            $cache->clear_current_page();
        }
    }
