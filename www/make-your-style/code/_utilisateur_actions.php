<?php declare(strict_types=1);

/** @var TYPE_NAME $mf_action */

    $est_charge['utilisateur'] = 1;

/*
    +-----------+
    |  Ajouter  |
    +-----------+
*/
    if ($mf_action == 'ajouter_utilisateur' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $mf_add = [];
        if (isset($_POST['utilisateur_Identifiant'])) {$mf_add['utilisateur_Identifiant'] = $_POST['utilisateur_Identifiant'];}
        if (isset($_POST['utilisateur_Password'])) {$mf_add['utilisateur_Password'] = $_POST['utilisateur_Password'];}
        if (isset($_POST['utilisateur_Email'])) {$mf_add['utilisateur_Email'] = $_POST['utilisateur_Email'];}
        if (isset($_POST['utilisateur_Civilite_Type'])) {$mf_add['utilisateur_Civilite_Type'] = $_POST['utilisateur_Civilite_Type'];}
        if (isset($_POST['utilisateur_Prenom'])) {$mf_add['utilisateur_Prenom'] = $_POST['utilisateur_Prenom'];}
        if (isset($_POST['utilisateur_Nom'])) {$mf_add['utilisateur_Nom'] = $_POST['utilisateur_Nom'];}
        if (isset($_POST['utilisateur_Adresse_1'])) {$mf_add['utilisateur_Adresse_1'] = $_POST['utilisateur_Adresse_1'];}
        if (isset($_POST['utilisateur_Adresse_2'])) {$mf_add['utilisateur_Adresse_2'] = $_POST['utilisateur_Adresse_2'];}
        if (isset($_POST['utilisateur_Ville'])) {$mf_add['utilisateur_Ville'] = $_POST['utilisateur_Ville'];}
        if (isset($_POST['utilisateur_Code_postal'])) {$mf_add['utilisateur_Code_postal'] = $_POST['utilisateur_Code_postal'];}
        if (isset($_POST['utilisateur_Date_naissance'])) {$mf_add['utilisateur_Date_naissance'] = $_POST['utilisateur_Date_naissance'];}
        if (isset($_POST['utilisateur_Accepte_mail_publicitaire'])) {$mf_add['utilisateur_Accepte_mail_publicitaire'] = $_POST['utilisateur_Accepte_mail_publicitaire'];}
        if (isset($_POST['utilisateur_Administrateur'])) {$mf_add['utilisateur_Administrateur'] = $_POST['utilisateur_Administrateur'];}
        if (isset($_POST['utilisateur_Fournisseur'])) {$mf_add['utilisateur_Fournisseur'] = $_POST['utilisateur_Fournisseur'];}
        $retour = $db->utilisateur()->mf_ajouter_2($mf_add);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_utilisateur';
            $Code_utilisateur = $retour['Code_utilisateur'];
            $mf_contexte['Code_utilisateur'] = $retour['Code_utilisateur'];
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
    if ($mf_action == 'modifier_utilisateur' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $mf_update = [];
        if (isset($_POST['utilisateur_Identifiant'])) { $mf_update['utilisateur_Identifiant'] = $_POST['utilisateur_Identifiant']; }
        // if (isset($_POST['utilisateur_Password'])) { $mf_update['utilisateur_Password'] = $_POST['utilisateur_Password']; }
        if (isset($_POST['utilisateur_Email'])) { $mf_update['utilisateur_Email'] = $_POST['utilisateur_Email']; }
        if (isset($_POST['utilisateur_Civilite_Type'])) { $mf_update['utilisateur_Civilite_Type'] = $_POST['utilisateur_Civilite_Type']; }
        if (isset($_POST['utilisateur_Prenom'])) { $mf_update['utilisateur_Prenom'] = $_POST['utilisateur_Prenom']; }
        if (isset($_POST['utilisateur_Nom'])) { $mf_update['utilisateur_Nom'] = $_POST['utilisateur_Nom']; }
        if (isset($_POST['utilisateur_Adresse_1'])) { $mf_update['utilisateur_Adresse_1'] = $_POST['utilisateur_Adresse_1']; }
        if (isset($_POST['utilisateur_Adresse_2'])) { $mf_update['utilisateur_Adresse_2'] = $_POST['utilisateur_Adresse_2']; }
        if (isset($_POST['utilisateur_Ville'])) { $mf_update['utilisateur_Ville'] = $_POST['utilisateur_Ville']; }
        if (isset($_POST['utilisateur_Code_postal'])) { $mf_update['utilisateur_Code_postal'] = $_POST['utilisateur_Code_postal']; }
        if (isset($_POST['utilisateur_Date_naissance'])) { $mf_update['utilisateur_Date_naissance'] = $_POST['utilisateur_Date_naissance']; }
        if (isset($_POST['utilisateur_Accepte_mail_publicitaire'])) { $mf_update['utilisateur_Accepte_mail_publicitaire'] = $_POST['utilisateur_Accepte_mail_publicitaire']; }
        if (isset($_POST['utilisateur_Administrateur'])) { $mf_update['utilisateur_Administrateur'] = $_POST['utilisateur_Administrateur']; }
        if (isset($_POST['utilisateur_Fournisseur'])) { $mf_update['utilisateur_Fournisseur'] = $_POST['utilisateur_Fournisseur']; }
        $retour = $db->utilisateur()->mf_modifier_2([$Code_utilisateur => $mf_update]);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_utilisateur';
            $cache->clear();
        } else {
            $cache->clear_current_page();
        }
    }

    if ($mf_action == 'modifier_utilisateur_Identifiant' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $utilisateur_Identifiant = $_POST['utilisateur_Identifiant'];
        $retour = $db->utilisateur()->mf_modifier_2([$Code_utilisateur => ['utilisateur_Identifiant' => $utilisateur_Identifiant]]);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_utilisateur';
            $cache->clear();
        } else {
            $cache->clear_current_page();
        }
    }

    if ($mf_action == 'modifier_utilisateur_Email' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $utilisateur_Email = $_POST['utilisateur_Email'];
        $retour = $db->utilisateur()->mf_modifier_2([$Code_utilisateur => ['utilisateur_Email' => $utilisateur_Email]]);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_utilisateur';
            $cache->clear();
        } else {
            $cache->clear_current_page();
        }
    }

    if ($mf_action == 'modifier_utilisateur_Civilite_Type' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $utilisateur_Civilite_Type = $_POST['utilisateur_Civilite_Type'];
        $retour = $db->utilisateur()->mf_modifier_2([$Code_utilisateur => ['utilisateur_Civilite_Type' => $utilisateur_Civilite_Type]]);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_utilisateur';
            $cache->clear();
        } else {
            $cache->clear_current_page();
        }
    }

    if ($mf_action == 'modifier_utilisateur_Prenom' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $utilisateur_Prenom = $_POST['utilisateur_Prenom'];
        $retour = $db->utilisateur()->mf_modifier_2([$Code_utilisateur => ['utilisateur_Prenom' => $utilisateur_Prenom]]);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_utilisateur';
            $cache->clear();
        } else {
            $cache->clear_current_page();
        }
    }

    if ($mf_action == 'modifier_utilisateur_Nom' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $utilisateur_Nom = $_POST['utilisateur_Nom'];
        $retour = $db->utilisateur()->mf_modifier_2([$Code_utilisateur => ['utilisateur_Nom' => $utilisateur_Nom]]);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_utilisateur';
            $cache->clear();
        } else {
            $cache->clear_current_page();
        }
    }

    if ($mf_action == 'modifier_utilisateur_Adresse_1' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $utilisateur_Adresse_1 = $_POST['utilisateur_Adresse_1'];
        $retour = $db->utilisateur()->mf_modifier_2([$Code_utilisateur => ['utilisateur_Adresse_1' => $utilisateur_Adresse_1]]);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_utilisateur';
            $cache->clear();
        } else {
            $cache->clear_current_page();
        }
    }

    if ($mf_action == 'modifier_utilisateur_Adresse_2' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $utilisateur_Adresse_2 = $_POST['utilisateur_Adresse_2'];
        $retour = $db->utilisateur()->mf_modifier_2([$Code_utilisateur => ['utilisateur_Adresse_2' => $utilisateur_Adresse_2]]);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_utilisateur';
            $cache->clear();
        } else {
            $cache->clear_current_page();
        }
    }

    if ($mf_action == 'modifier_utilisateur_Ville' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $utilisateur_Ville = $_POST['utilisateur_Ville'];
        $retour = $db->utilisateur()->mf_modifier_2([$Code_utilisateur => ['utilisateur_Ville' => $utilisateur_Ville]]);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_utilisateur';
            $cache->clear();
        } else {
            $cache->clear_current_page();
        }
    }

    if ($mf_action == 'modifier_utilisateur_Code_postal' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $utilisateur_Code_postal = $_POST['utilisateur_Code_postal'];
        $retour = $db->utilisateur()->mf_modifier_2([$Code_utilisateur => ['utilisateur_Code_postal' => $utilisateur_Code_postal]]);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_utilisateur';
            $cache->clear();
        } else {
            $cache->clear_current_page();
        }
    }

    if ($mf_action == 'modifier_utilisateur_Date_naissance' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $utilisateur_Date_naissance = $_POST['utilisateur_Date_naissance'];
        $retour = $db->utilisateur()->mf_modifier_2([$Code_utilisateur => ['utilisateur_Date_naissance' => $utilisateur_Date_naissance]]);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_utilisateur';
            $cache->clear();
        } else {
            $cache->clear_current_page();
        }
    }

    if ($mf_action == 'modifier_utilisateur_Accepte_mail_publicitaire' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $utilisateur_Accepte_mail_publicitaire = $_POST['utilisateur_Accepte_mail_publicitaire'];
        $retour = $db->utilisateur()->mf_modifier_2([$Code_utilisateur => ['utilisateur_Accepte_mail_publicitaire' => $utilisateur_Accepte_mail_publicitaire]]);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_utilisateur';
            $cache->clear();
        } else {
            $cache->clear_current_page();
        }
    }

    if ($mf_action == 'modifier_utilisateur_Administrateur' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $utilisateur_Administrateur = $_POST['utilisateur_Administrateur'];
        $retour = $db->utilisateur()->mf_modifier_2([$Code_utilisateur => ['utilisateur_Administrateur' => $utilisateur_Administrateur]]);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_utilisateur';
            $cache->clear();
        } else {
            $cache->clear_current_page();
        }
    }

    if ($mf_action == 'modifier_utilisateur_Fournisseur' && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $utilisateur_Fournisseur = $_POST['utilisateur_Fournisseur'];
        $retour = $db->utilisateur()->mf_modifier_2([$Code_utilisateur => ['utilisateur_Fournisseur' => $utilisateur_Fournisseur]]);
        if ($retour['code_erreur'] == 0) {
            $mf_action = 'apercu_utilisateur';
            $cache->clear();
        } else {
            $cache->clear_current_page();
        }
    }

/*
    +----------------------------+
    |  Modifier le mot de passe  |
    +----------------------------+
*/
    if ($mf_action == "modpwd" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $utilisateur_Password_old=$_POST["utilisateur_Password_old"];
        $utilisateur_Password_new=$_POST["utilisateur_Password_new"];
        $utilisateur_Password_verif=$_POST["utilisateur_Password_verif"];
        $retour = $mf_connexion->changer_mot_de_passe($Code_utilisateur, $utilisateur_Password_old, $utilisateur_Password_new, $utilisateur_Password_verif);
        if ($retour['code_erreur'] == 0) {
            $mf_action = "apercu_utilisateur";
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
    if ($mf_action == "supprimer_utilisateur" && isset($_POST['validation_formulaire']) && formulaire_valide($_POST['validation_formulaire'])) {
        $Supprimer = intval($_POST["Supprimer"]);
        if ($Supprimer == 1) {
            $retour = $db->utilisateur()->mf_supprimer($Code_utilisateur);
            if ($retour['code_erreur'] == 0) {
                $mf_action = "-";
                $cache->clear();
                $Code_utilisateur = 0;
            } else {
                $cache->clear_current_page();
            }
        } else {
            $mf_action = "apercu_utilisateur";
            $cache->clear_current_page();
        }
    }
