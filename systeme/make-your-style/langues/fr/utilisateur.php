<?php declare(strict_types=1);

$lang_standard['Code_utilisateur'] = 'utilisateur';

$lang_standard['utilisateur_Identifiant'] = 'utilisateur_Identifiant';
$lang_standard['utilisateur_Password'] = 'utilisateur_Password';
$lang_standard['utilisateur_Email'] = 'utilisateur_Email';
$lang_standard['utilisateur_Civilite_Type'] = 'utilisateur_Civilite_Type';
$lang_standard['utilisateur_Civilite_Type_'] = [1 => "Etat 1", 2 => "Etat 2", 3 => "Etat 3"];
$lang_standard['utilisateur_Prenom'] = 'utilisateur_Prenom';
$lang_standard['utilisateur_Nom'] = 'utilisateur_Nom';
$lang_standard['utilisateur_Adresse_1'] = 'utilisateur_Adresse_1';
$lang_standard['utilisateur_Adresse_2'] = 'utilisateur_Adresse_2';
$lang_standard['utilisateur_Ville'] = 'utilisateur_Ville';
$lang_standard['utilisateur_Code_postal'] = 'utilisateur_Code_postal';
$lang_standard['utilisateur_Date_naissance'] = 'utilisateur_Date_naissance';
$lang_standard['utilisateur_Accepte_mail_publicitaire'] = 'utilisateur_Accepte_mail_publicitaire';
$lang_standard['utilisateur_Accepte_mail_publicitaire_'] = [1 => "Oui", 0 => "Non"];
$lang_standard['utilisateur_Administrateur'] = 'utilisateur_Administrateur';
$lang_standard['utilisateur_Administrateur_'] = [1 => "Oui", 0 => "Non"];
$lang_standard['utilisateur_Fournisseur'] = 'utilisateur_Fournisseur';
$lang_standard['utilisateur_Fournisseur_'] = [1 => "Oui", 0 => "Non"];

$lang_standard['bouton_ajouter_utilisateur'] = 'Ajouter';
$lang_standard['bouton_creer_utilisateur'] = 'Créer';
$lang_standard['bouton_modifier_utilisateur'] = 'Modifier';
$lang_standard['bouton_supprimer_utilisateur'] = 'Supprimer';
$lang_standard['bouton_modpwd_utilisateur'] = 'Modifier le mot de passe';
$lang_standard['bouton_modifier_utilisateur_Identifiant'] = 'Modifier';
$lang_standard['bouton_modifier_utilisateur_Password'] = 'Modifier';
$lang_standard['bouton_modifier_utilisateur_Email'] = 'Modifier';
$lang_standard['bouton_modifier_utilisateur_Civilite_Type'] = 'Modifier';
$lang_standard['bouton_modifier_utilisateur_Prenom'] = 'Modifier';
$lang_standard['bouton_modifier_utilisateur_Nom'] = 'Modifier';
$lang_standard['bouton_modifier_utilisateur_Adresse_1'] = 'Modifier';
$lang_standard['bouton_modifier_utilisateur_Adresse_2'] = 'Modifier';
$lang_standard['bouton_modifier_utilisateur_Ville'] = 'Modifier';
$lang_standard['bouton_modifier_utilisateur_Code_postal'] = 'Modifier';
$lang_standard['bouton_modifier_utilisateur_Date_naissance'] = 'Modifier';
$lang_standard['bouton_modifier_utilisateur_Accepte_mail_publicitaire'] = 'Modifier';
$lang_standard['bouton_modifier_utilisateur_Administrateur'] = 'Modifier';
$lang_standard['bouton_modifier_utilisateur_Fournisseur'] = 'Modifier';

$lang_standard['form_add_utilisateur'] = 'Ajout d\'un nouvel enregistrement';
$lang_standard['form_edit_utilisateur'] = 'Edition de l\'enregistrement';
$lang_standard['form_delete_utilisateur'] = 'Confirmation de suppression de l\'enregistrement';
$lang_standard['formulaire_modpwd_utilisateur'] = 'Modifier le mot de passe';

$mf_titre_ligne_table['utilisateur'] = '{utilisateur_Identifiant}';

$mf_tri_defaut_table['utilisateur'] = ['utilisateur_Identifiant' => 'ASC'];

$lang_standard['libelle_liste_utilisateur'] = 'Enregistrement(s)';

$mf_initialisation['utilisateur_Identifiant'] = '';
$mf_initialisation['utilisateur_Password'] = '';
$mf_initialisation['utilisateur_Email'] = '';
$mf_initialisation['utilisateur_Civilite_Type'] = 1;
$mf_initialisation['utilisateur_Prenom'] = '';
$mf_initialisation['utilisateur_Nom'] = '';
$mf_initialisation['utilisateur_Adresse_1'] = '';
$mf_initialisation['utilisateur_Adresse_2'] = '';
$mf_initialisation['utilisateur_Ville'] = '';
$mf_initialisation['utilisateur_Code_postal'] = '';
$mf_initialisation['utilisateur_Date_naissance'] = '';
$mf_initialisation['utilisateur_Accepte_mail_publicitaire'] = 0;
$mf_initialisation['utilisateur_Administrateur'] = 0;
$mf_initialisation['utilisateur_Fournisseur'] = 0;

// code_erreur

$mf_libelle_erreur[REFUS_UTILISATEUR__AJOUTER] = 'REFUS_utilisateur__AJOUTER';
$mf_libelle_erreur[REFUS_UTILISATEUR__AJOUT_BLOQUEE] = 'REFUS_utilisateur__AJOUT_BLOQUEE';
$mf_libelle_erreur[ERR_UTILISATEUR__AJOUTER__UTILISATEUR_IDENTIFIANT_DOUBLON] = 'ERR_utilisateur__AJOUTER__utilisateur_Identifiant_DOUBLON';
$mf_libelle_erreur[ERR_UTILISATEUR__AJOUTER__UTILISATEUR_EMAIL_DOUBLON] = 'ERR_utilisateur__AJOUTER__utilisateur_Email_DOUBLON';
$mf_libelle_erreur[ERR_UTILISATEUR__AJOUTER__UTILISATEUR_CIVILITE_TYPE_NON_VALIDE] = 'ERR_utilisateur__AJOUTER__utilisateur_Civilite_Type_NON_VALIDE';
$mf_libelle_erreur[ERR_UTILISATEUR__AJOUTER__AJOUT_REFUSE] = 'ERR_utilisateur__AJOUTER__AJOUT_REFUSE';
$mf_libelle_erreur[ERR_UTILISATEUR__AJOUTER_3__ECHEC_AJOUT] = 'ERR_utilisateur__AJOUTER_3__ECHEC_AJOUT';
$mf_libelle_erreur[ERR_UTILISATEUR__MODIFIER__CODE_UTILISATEUR_INEXISTANT] = 'ERR_utilisateur__MODIFIER__Code_utilisateur_INEXISTANT';
$mf_libelle_erreur[REFUS_UTILISATEUR__MODIFIER] = 'REFUS_utilisateur__MODIFIER';
$mf_libelle_erreur[ACCES_CODE_UTILISATEUR_REFUSE] = 'Tentative d\'accès \'Code_utilisateur\' non autorisé';
$mf_libelle_erreur[REFUS_UTILISATEUR__MODIFICATION_BLOQUEE] = 'REFUS_utilisateur__MODIFICATION_BLOQUEE';
$mf_libelle_erreur[ERR_UTILISATEUR__MODIFIER__UTILISATEUR_CIVILITE_TYPE_NON_VALIDE] = 'ERR_utilisateur__MODIFIER__utilisateur_Civilite_Type_NON_VALIDE';
$mf_libelle_erreur[ERR_UTILISATEUR__MODIFIER__UTILISATEUR_CIVILITE_TYPE__HORS_WORKFLOW] = 'ERR_utilisateur__MODIFIER__utilisateur_Civilite_Type__HORS_WORKFLOW';
$mf_libelle_erreur[ERR_UTILISATEUR__MODIFIER__AUCUN_CHANGEMENT] = 'ERR_utilisateur__MODIFIER__AUCUN_CHANGEMENT';
$mf_libelle_erreur[ERR_UTILISATEUR__MODIFIER_3__AUCUN_CHANGEMENT] = 'ERR_utilisateur__MODIFIER_3__AUCUN_CHANGEMENT';
$mf_libelle_erreur[ERR_UTILISATEUR__MODIFIER_4__AUCUN_CHANGEMENT] = 'ERR_utilisateur__MODIFIER_4__AUCUN_CHANGEMENT';
$mf_libelle_erreur[ERR_UTILISATEUR__SUPPRIMER_2__CODE_UTILISATEUR_INEXISTANT] = 'ERR_utilisateur__SUPPRIMER_2__Code_utilisateur_INEXISTANT';
$mf_libelle_erreur[REFUS_UTILISATEUR__SUPPRIMER] = 'REFUS_utilisateur__SUPPRIMER';
$mf_libelle_erreur[REFUS_UTILISATEUR__SUPPRESSION_BLOQUEE] = 'REFUS_utilisateur__SUPPRESSION_BLOQUEE';
$mf_libelle_erreur[ERR_UTILISATEUR__SUPPRIMER__REFUSEE] = 'ERR_utilisateur__SUPPRIMER__REFUSEE';
$mf_libelle_erreur[ERR_UTILISATEUR__SUPPRIMER_2__REFUSEE] = 'ERR_utilisateur__SUPPRIMER_2__REFUSEE';
$mf_libelle_erreur[ERR_UTILISATEUR__SUPPRIMER_3__REFUSEE] = 'ERR_utilisateur__SUPPRIMER_3__REFUSEE';
