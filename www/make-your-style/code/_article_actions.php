<?php declare(strict_types=1);

/** @var TYPE_NAME $mf_action */

    $est_charge['article'] = 1;

    if (! isset($lang_standard['Code_sous_categorie_article_'])) {
        $liste = $db->sous_categorie_article()->mf_lister_contexte(null, ['liste_colonnes_a_selectionner' => mf_liste_colonnes_titre('sous_categorie_article'), OPTION_LIMIT => [0, NB_ELEM_MAX_LANGUE]]);
        if (count($liste) < NB_ELEM_MAX_LANGUE) {
            $lang_standard['Code_sous_categorie_article_'] = [];
            foreach ($liste as $code => $value) {
                $lang_standard['Code_sous_categorie_article_'][$code] = get_titre_ligne_table('sous_categorie_article', $value);
            }
        }
        unset($liste);
    }

/*
    +-----------+
    |  Ajouter  |
    +-----------+
*/
    if ($mf_action == 'ajouter_article' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $mf_add = [];
        if (isset($_POST['article_Libelle'])) {$mf_add['article_Libelle'] = $_POST['article_Libelle'];}
        if (isset($_POST['article_Description'])) {$mf_add['article_Description'] = $_POST['article_Description'];}
        if (isset($_POST['article_Saison_Type'])) {$mf_add['article_Saison_Type'] = $_POST['article_Saison_Type'];}
        if (isset($_POST['article_Nom_fournisseur'])) {$mf_add['article_Nom_fournisseur'] = $_POST['article_Nom_fournisseur'];}
        if (isset($_POST['article_Url'])) {$mf_add['article_Url'] = $_POST['article_Url'];}
        if (isset($_POST['article_Reference'])) {$mf_add['article_Reference'] = $_POST['article_Reference'];}
        if (isset($_POST['article_Couleur'])) {$mf_add['article_Couleur'] = $_POST['article_Couleur'];}
        if (isset($_POST['article_Code_couleur_svg'])) {$mf_add['article_Code_couleur_svg'] = $_POST['article_Code_couleur_svg'];}
        if (isset($_POST['article_Taille_Pays_Type'])) {$mf_add['article_Taille_Pays_Type'] = $_POST['article_Taille_Pays_Type'];}
        if (isset($_POST['article_Taille'])) {$mf_add['article_Taille'] = $_POST['article_Taille'];}
        if (isset($_POST['article_Matiere'])) {$mf_add['article_Matiere'] = $_POST['article_Matiere'];}
        if (isset($_FILES['article_Photo_Fichier'])) {$fichier = new Fichier(); $mf_add['article_Photo_Fichier'] = $fichier->importer($_FILES['article_Photo_Fichier']);}
        if (isset($_POST['article_Prix'])) {$mf_add['article_Prix'] = $_POST['article_Prix'];}
        if (isset($_POST['article_Actif'])) {$mf_add['article_Actif'] = $_POST['article_Actif'];}
        $mf_add['Code_sous_categorie_article'] = (isset($_POST['Code_sous_categorie_article']) ? (int) $_POST['Code_sous_categorie_article'] : $Code_sous_categorie_article);
        $retour = $db->article()->mf_ajouter_2($mf_add);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_article';
            $Code_article = $retour['Code_article'];
            $mf_contexte['Code_article'] = $retour['Code_article'];
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
    if ($mf_action == 'creer_article') {
        $retour = $db->article()->mf_creer(mf_Code_sous_categorie_article());
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_article';
            $Code_article =  $retour['Code_article'];
            $mf_contexte['Code_article'] = $retour['Code_article'];
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
    if ($mf_action == 'modifier_article' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $mf_update = [];
        if (isset($_POST['article_Libelle'])) { $mf_update['article_Libelle'] = $_POST['article_Libelle']; }
        if (isset($_POST['article_Description'])) { $mf_update['article_Description'] = $_POST['article_Description']; }
        if (isset($_POST['article_Saison_Type'])) { $mf_update['article_Saison_Type'] = $_POST['article_Saison_Type']; }
        if (isset($_POST['article_Nom_fournisseur'])) { $mf_update['article_Nom_fournisseur'] = $_POST['article_Nom_fournisseur']; }
        if (isset($_POST['article_Url'])) { $mf_update['article_Url'] = $_POST['article_Url']; }
        if (isset($_POST['article_Reference'])) { $mf_update['article_Reference'] = $_POST['article_Reference']; }
        if (isset($_POST['article_Couleur'])) { $mf_update['article_Couleur'] = $_POST['article_Couleur']; }
        if (isset($_POST['article_Code_couleur_svg'])) { $mf_update['article_Code_couleur_svg'] = $_POST['article_Code_couleur_svg']; }
        if (isset($_POST['article_Taille_Pays_Type'])) { $mf_update['article_Taille_Pays_Type'] = $_POST['article_Taille_Pays_Type']; }
        if (isset($_POST['article_Taille'])) { $mf_update['article_Taille'] = $_POST['article_Taille']; }
        if (isset($_POST['article_Matiere'])) { $mf_update['article_Matiere'] = $_POST['article_Matiere']; }
        if (isset($_FILES['article_Photo_Fichier'])) { $fichier = new Fichier(); $mf_update['article_Photo_Fichier'] = $fichier->importer($_FILES['article_Photo_Fichier']); }
        if (isset($_POST['article_Prix'])) { $mf_update['article_Prix'] = $_POST['article_Prix']; }
        if (isset($_POST['article_Actif'])) { $mf_update['article_Actif'] = $_POST['article_Actif']; }
        if (isset($_POST['Code_sous_categorie_article'])) { $mf_update['Code_sous_categorie_article'] = (int) $_POST['Code_sous_categorie_article']; }
        $retour = $db->article()->mf_modifier_2([$Code_article => $mf_update]);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_article';
            $cache->clear();
        } else {
            $cache->clear_current_page();
        }
    }

    if ($mf_action == 'modifier_article_Libelle' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $article_Libelle = $_POST['article_Libelle'];
        $retour = $db->article()->mf_modifier_2([$Code_article => ['article_Libelle' => $article_Libelle]]);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_article';
            $cache->clear();
        } else {
            $cache->clear_current_page();
        }
    }

    if ($mf_action == 'modifier_article_Description' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $article_Description = $_POST['article_Description'];
        $retour = $db->article()->mf_modifier_2([$Code_article => ['article_Description' => $article_Description]]);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_article';
            $cache->clear();
        } else {
            $cache->clear_current_page();
        }
    }

    if ($mf_action == 'modifier_article_Saison_Type' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $article_Saison_Type = $_POST['article_Saison_Type'];
        $retour = $db->article()->mf_modifier_2([$Code_article => ['article_Saison_Type' => $article_Saison_Type]]);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_article';
            $cache->clear();
        } else {
            $cache->clear_current_page();
        }
    }

    if ($mf_action == 'modifier_article_Nom_fournisseur' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $article_Nom_fournisseur = $_POST['article_Nom_fournisseur'];
        $retour = $db->article()->mf_modifier_2([$Code_article => ['article_Nom_fournisseur' => $article_Nom_fournisseur]]);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_article';
            $cache->clear();
        } else {
            $cache->clear_current_page();
        }
    }

    if ($mf_action == 'modifier_article_Url' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $article_Url = $_POST['article_Url'];
        $retour = $db->article()->mf_modifier_2([$Code_article => ['article_Url' => $article_Url]]);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_article';
            $cache->clear();
        } else {
            $cache->clear_current_page();
        }
    }

    if ($mf_action == 'modifier_article_Reference' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $article_Reference = $_POST['article_Reference'];
        $retour = $db->article()->mf_modifier_2([$Code_article => ['article_Reference' => $article_Reference]]);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_article';
            $cache->clear();
        } else {
            $cache->clear_current_page();
        }
    }

    if ($mf_action == 'modifier_article_Couleur' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $article_Couleur = $_POST['article_Couleur'];
        $retour = $db->article()->mf_modifier_2([$Code_article => ['article_Couleur' => $article_Couleur]]);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_article';
            $cache->clear();
        } else {
            $cache->clear_current_page();
        }
    }

    if ($mf_action == 'modifier_article_Code_couleur_svg' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $article_Code_couleur_svg = $_POST['article_Code_couleur_svg'];
        $retour = $db->article()->mf_modifier_2([$Code_article => ['article_Code_couleur_svg' => $article_Code_couleur_svg]]);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_article';
            $cache->clear();
        } else {
            $cache->clear_current_page();
        }
    }

    if ($mf_action == 'modifier_article_Taille_Pays_Type' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $article_Taille_Pays_Type = $_POST['article_Taille_Pays_Type'];
        $retour = $db->article()->mf_modifier_2([$Code_article => ['article_Taille_Pays_Type' => $article_Taille_Pays_Type]]);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_article';
            $cache->clear();
        } else {
            $cache->clear_current_page();
        }
    }

    if ($mf_action == 'modifier_article_Taille' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $article_Taille = $_POST['article_Taille'];
        $retour = $db->article()->mf_modifier_2([$Code_article => ['article_Taille' => $article_Taille]]);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_article';
            $cache->clear();
        } else {
            $cache->clear_current_page();
        }
    }

    if ($mf_action == 'modifier_article_Matiere' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $article_Matiere = $_POST['article_Matiere'];
        $retour = $db->article()->mf_modifier_2([$Code_article => ['article_Matiere' => $article_Matiere]]);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_article';
            $cache->clear();
        } else {
            $cache->clear_current_page();
        }
    }

    if ($mf_action == 'modifier_article_Photo_Fichier' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $fichier = new Fichier();
        $article_Photo_Fichier = $fichier->importer($_FILES['article_Photo_Fichier']);
        if ($article_Photo_Fichier == '') {$temp = $db->article()->mf_get($Code_article); $article_Photo_Fichier = $temp['article_Photo_Fichier']; }
        $retour = $db->article()->mf_modifier_2([$Code_article => ['article_Photo_Fichier' => $article_Photo_Fichier]]);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_article';
            $cache->clear();
        } else {
            $cache->clear_current_page();
        }
    }

    if ($mf_action == 'modifier_article_Prix' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $article_Prix = $_POST['article_Prix'];
        $retour = $db->article()->mf_modifier_2([$Code_article => ['article_Prix' => $article_Prix]]);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_article';
            $cache->clear();
        } else {
            $cache->clear_current_page();
        }
    }

    if ($mf_action == 'modifier_article_Actif' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $article_Actif = $_POST['article_Actif'];
        $retour = $db->article()->mf_modifier_2([$Code_article => ['article_Actif' => $article_Actif]]);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_article';
            $cache->clear();
        } else {
            $cache->clear_current_page();
        }
    }

    if ($mf_action == 'modifier_article__Code_sous_categorie_article' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $retour = $db->article()->mf_modifier_2([$Code_article => ['Code_sous_categorie_article' => (isset($_POST['Code_sous_categorie_article']) ? (int) $_POST['Code_sous_categorie_article'] : $Code_sous_categorie_article)]]);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_article';
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
    if ($mf_action == "supprimer_article" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $Supprimer = intval($_POST["Supprimer"]);
        if ($Supprimer == 1) {
            $retour = $db->article()->mf_supprimer($Code_article);
            if ($retour['code_erreur'] == 0) {
                $mf_action = "-";
                $cache->clear();
                $Code_article = 0;
            } else {
                $cache->clear_current_page();
            }
        } else {
            $mf_action = "apercu_article";
            $cache->clear_current_page();
        }
    }
