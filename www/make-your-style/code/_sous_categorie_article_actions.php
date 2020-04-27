<?php declare(strict_types=1);

/** @var TYPE_NAME $mf_action */

    $est_charge['sous_categorie_article'] = 1;

    if (! isset($lang_standard['Code_categorie_article_'])) {
        $liste = $db->categorie_article()->mf_lister_contexte(null, ['liste_colonnes_a_selectionner' => mf_liste_colonnes_titre('categorie_article'), OPTION_LIMIT => [0, NB_ELEM_MAX_LANGUE]]);
        if (count($liste) < NB_ELEM_MAX_LANGUE) {
            $lang_standard['Code_categorie_article_'] = [];
            foreach ($liste as $code => $value) {
                $lang_standard['Code_categorie_article_'][$code] = get_titre_ligne_table('categorie_article', $value);
            }
        }
        unset($liste);
    }

/*
    +-----------+
    |  Ajouter  |
    +-----------+
*/
    if ($mf_action == 'ajouter_sous_categorie_article' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $mf_add = [];
        if (isset($_POST['sous_categorie_article_Libelle'])) {$mf_add['sous_categorie_article_Libelle'] = $_POST['sous_categorie_article_Libelle'];}
        $mf_add['Code_categorie_article'] = (isset($_POST['Code_categorie_article']) ? (int) $_POST['Code_categorie_article'] : $Code_categorie_article);
        $retour = $db->sous_categorie_article()->mf_ajouter_2($mf_add);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_sous_categorie_article';
            $Code_sous_categorie_article = $retour['Code_sous_categorie_article'];
            $mf_contexte['Code_sous_categorie_article'] = $retour['Code_sous_categorie_article'];
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
    if ($mf_action == 'creer_sous_categorie_article') {
        $retour = $db->sous_categorie_article()->mf_creer(mf_Code_categorie_article());
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_sous_categorie_article';
            $Code_sous_categorie_article =  $retour['Code_sous_categorie_article'];
            $mf_contexte['Code_sous_categorie_article'] = $retour['Code_sous_categorie_article'];
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
    if ($mf_action == 'modifier_sous_categorie_article' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $mf_update = [];
        if (isset($_POST['sous_categorie_article_Libelle'])) { $mf_update['sous_categorie_article_Libelle'] = $_POST['sous_categorie_article_Libelle']; }
        if (isset($_POST['Code_categorie_article'])) { $mf_update['Code_categorie_article'] = (int) $_POST['Code_categorie_article']; }
        $retour = $db->sous_categorie_article()->mf_modifier_2([$Code_sous_categorie_article => $mf_update]);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_sous_categorie_article';
            $cache->clear();
        } else {
            $cache->clear_current_page();
        }
    }

    if ($mf_action == 'modifier_sous_categorie_article_Libelle' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $sous_categorie_article_Libelle = $_POST['sous_categorie_article_Libelle'];
        $retour = $db->sous_categorie_article()->mf_modifier_2([$Code_sous_categorie_article => ['sous_categorie_article_Libelle' => $sous_categorie_article_Libelle]]);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_sous_categorie_article';
            $cache->clear();
        } else {
            $cache->clear_current_page();
        }
    }

    if ($mf_action == 'modifier_sous_categorie_article__Code_categorie_article' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $retour = $db->sous_categorie_article()->mf_modifier_2([$Code_sous_categorie_article => ['Code_categorie_article' => (isset($_POST['Code_categorie_article']) ? (int) $_POST['Code_categorie_article'] : $Code_categorie_article)]]);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_sous_categorie_article';
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
    if ($mf_action == "supprimer_sous_categorie_article" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $Supprimer = intval($_POST["Supprimer"]);
        if ($Supprimer == 1) {
            $retour = $db->sous_categorie_article()->mf_supprimer($Code_sous_categorie_article);
            if ($retour['code_erreur'] == 0) {
                $mf_action = "-";
                $cache->clear();
                $Code_sous_categorie_article = 0;
            } else {
                $cache->clear_current_page();
            }
        } else {
            $mf_action = "apercu_sous_categorie_article";
            $cache->clear_current_page();
        }
    }
