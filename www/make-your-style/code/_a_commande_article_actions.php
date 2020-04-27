<?php declare(strict_types=1);

    $est_charge['a_commande_article'] = 1;

    if (! isset($lang_standard['Code_commande_'])) {
        $liste = $db->commande()->mf_lister_contexte(null, ['liste_colonnes_a_selectionner' => mf_liste_colonnes_titre('commande'), OPTION_LIMIT => [0, NB_ELEM_MAX_LANGUE]]);
        if (count($liste) < NB_ELEM_MAX_LANGUE) {
            $lang_standard['Code_commande_'] = [];
            foreach ($liste as $code => $value) {
                $lang_standard['Code_commande_'][$code] = get_titre_ligne_table('commande', $value);
            }
        }
        unset($liste);
    }
    if (! isset($lang_standard['Code_article_'])) {
        $liste = $db->article()->mf_lister_contexte(null, ['liste_colonnes_a_selectionner' => mf_liste_colonnes_titre('article'), OPTION_LIMIT => [0, NB_ELEM_MAX_LANGUE]]);
        if (count($liste) < NB_ELEM_MAX_LANGUE) {
            $lang_standard['Code_article_'] = [];
            foreach ($liste as $code => $value) {
                $lang_standard['Code_article_'][$code] = get_titre_ligne_table('article', $value);
            }
        }
        unset($liste);
    }

/*
    +-----------+
    |  Ajouter  |
    +-----------+
*/
    if ($mf_action == 'ajouter_a_commande_article' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $mf_add = [];
        $mf_add['Code_commande'] = (isset($_POST['Code_commande']) ? (int) $_POST['Code_commande'] : $Code_commande );
        $mf_add['Code_article'] = (isset($_POST['Code_article']) ? (int) $_POST['Code_article'] : $Code_article );
        if (isset($_POST['a_commande_article_Quantite'])) {
            $mf_add['a_commande_article_Quantite'] = $_POST['a_commande_article_Quantite'];
        }
        if (isset($_POST['a_commande_article_Prix_ligne'])) {
            $mf_add['a_commande_article_Prix_ligne'] = $_POST['a_commande_article_Prix_ligne'];
        }
        $retour = $db->a_commande_article()->mf_ajouter_2( $mf_add );
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_a_commande_article';
            if (! isset($est_charge['commande'])) {
                $Code_commande = (isset($_POST['Code_commande']) ? (int) $_POST['Code_commande'] : 0);
            }
            if (! isset($est_charge['article'])) {
                $Code_article = (isset($_POST['Code_article']) ? (int) $_POST['Code_article'] : 0);
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
    if ($mf_action == 'modifier_a_commande_article' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $mf_update = [];
        $mf_update['Code_commande'] = $Code_commande;
        $mf_update['Code_article'] = $Code_article;
        if (isset($_POST['a_commande_article_Quantite'])) {
            $mf_update['a_commande_article_Quantite'] = $_POST['a_commande_article_Quantite'];
        }
        if (isset($_POST['a_commande_article_Prix_ligne'])) {
            $mf_update['a_commande_article_Prix_ligne'] = $_POST['a_commande_article_Prix_ligne'];
        }
        $retour = $db->a_commande_article()->mf_modifier_2($mf_update);
        if ($retour['code_erreur'] == 0) {
            $mf_action = "apercu_a_commande_article";
            $cache->clear();
        } else {
            $cache->clear_current_page();
        }
    }

    if ($mf_action == 'modifier_a_commande_article_Quantite' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $a_commande_article_Quantite = $_POST['a_commande_article_Quantite'];
        $retour = $db->a_commande_article()->mf_modifier_2([['Code_commande' => $Code_commande , 'Code_article' => $Code_article , 'a_commande_article_Quantite' => $a_commande_article_Quantite]]);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_a_commande_article';
            $cache->clear();
        } else {
            $cache->clear_current_page();
        }
    }

    if ($mf_action == 'modifier_a_commande_article_Prix_ligne' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $a_commande_article_Prix_ligne = $_POST['a_commande_article_Prix_ligne'];
        $retour = $db->a_commande_article()->mf_modifier_2([['Code_commande' => $Code_commande , 'Code_article' => $Code_article , 'a_commande_article_Prix_ligne' => $a_commande_article_Prix_ligne]]);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_a_commande_article';
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
    if ($mf_action == 'supprimer_a_commande_article' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $Supprimer = intval($_POST["Supprimer"]);
        if ($Supprimer == 1) {
            $retour = $db->a_commande_article()->mf_supprimer($Code_commande, $Code_article);
            if ($retour['code_erreur'] == 0) {
                $mf_action = "-";
                $cache->clear();
            } else {
                $cache->clear_current_page();
            }
        } else {
            $mf_action = "apercu_a_commande_article";
            $cache->clear_current_page();
        }
    }
