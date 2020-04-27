<?php declare(strict_types=1);

$lang_standard['Code_vue_utilisateur'] = 'vue_utilisateur';

$lang_standard['vue_utilisateur_Recherche'] = 'vue_utilisateur_Recherche';
$lang_standard['vue_utilisateur_Filtre_Saison_Type'] = 'vue_utilisateur_Filtre_Saison_Type';
$lang_standard['vue_utilisateur_Filtre_Saison_Type_'] = [1 => "Etat 1", 2 => "Etat 2", 3 => "Etat 3"];
$lang_standard['vue_utilisateur_Filtre_Couleur'] = 'vue_utilisateur_Filtre_Couleur';
$lang_standard['vue_utilisateur_Filtre_Taille_Pays_Type'] = 'vue_utilisateur_Filtre_Taille_Pays_Type';
$lang_standard['vue_utilisateur_Filtre_Taille_Pays_Type_'] = [1 => "Etat 1", 2 => "Etat 2", 3 => "Etat 3"];
$lang_standard['vue_utilisateur_Filtre_Taille_Max'] = 'vue_utilisateur_Filtre_Taille_Max';
$lang_standard['vue_utilisateur_Filtre_Taille_Min'] = 'vue_utilisateur_Filtre_Taille_Min';

$lang_standard['bouton_ajouter_vue_utilisateur'] = 'Ajouter';
$lang_standard['bouton_creer_vue_utilisateur'] = 'Créer';
$lang_standard['bouton_modifier_vue_utilisateur'] = 'Modifier';
$lang_standard['bouton_supprimer_vue_utilisateur'] = 'Supprimer';
$lang_standard['bouton_modifier_vue_utilisateur_Recherche'] = 'Modifier';
$lang_standard['bouton_modifier_vue_utilisateur_Filtre_Saison_Type'] = 'Modifier';
$lang_standard['bouton_modifier_vue_utilisateur_Filtre_Couleur'] = 'Modifier';
$lang_standard['bouton_modifier_vue_utilisateur_Filtre_Taille_Pays_Type'] = 'Modifier';
$lang_standard['bouton_modifier_vue_utilisateur_Filtre_Taille_Max'] = 'Modifier';
$lang_standard['bouton_modifier_vue_utilisateur_Filtre_Taille_Min'] = 'Modifier';

$lang_standard['form_add_vue_utilisateur'] = 'Ajout d\'un nouvel enregistrement';
$lang_standard['form_edit_vue_utilisateur'] = 'Edition de l\'enregistrement';
$lang_standard['form_delete_vue_utilisateur'] = 'Confirmation de suppression de l\'enregistrement';

$mf_titre_ligne_table['vue_utilisateur'] = '{vue_utilisateur_Recherche}';

$mf_tri_defaut_table['vue_utilisateur'] = ['vue_utilisateur_Recherche' => 'ASC'];

$lang_standard['libelle_liste_vue_utilisateur'] = 'Enregistrement(s)';

$mf_initialisation['vue_utilisateur_Recherche'] = '';
$mf_initialisation['vue_utilisateur_Filtre_Saison_Type'] = 1;
$mf_initialisation['vue_utilisateur_Filtre_Couleur'] = '';
$mf_initialisation['vue_utilisateur_Filtre_Taille_Pays_Type'] = 1;
$mf_initialisation['vue_utilisateur_Filtre_Taille_Max'] = null;
$mf_initialisation['vue_utilisateur_Filtre_Taille_Min'] = null;

// code_erreur

$mf_libelle_erreur[REFUS_VUE_UTILISATEUR__AJOUTER] = 'REFUS_vue_utilisateur__AJOUTER';
$mf_libelle_erreur[REFUS_VUE_UTILISATEUR__AJOUT_BLOQUEE] = 'REFUS_vue_utilisateur__AJOUT_BLOQUEE';
$mf_libelle_erreur[ERR_VUE_UTILISATEUR__AJOUTER__VUE_UTILISATEUR_FILTRE_SAISON_TYPE_NON_VALIDE] = 'ERR_vue_utilisateur__AJOUTER__vue_utilisateur_Filtre_Saison_Type_NON_VALIDE';
$mf_libelle_erreur[ERR_VUE_UTILISATEUR__AJOUTER__VUE_UTILISATEUR_FILTRE_TAILLE_PAYS_TYPE_NON_VALIDE] = 'ERR_vue_utilisateur__AJOUTER__vue_utilisateur_Filtre_Taille_Pays_Type_NON_VALIDE';
$mf_libelle_erreur[ERR_VUE_UTILISATEUR__AJOUTER__AJOUT_REFUSE] = 'ERR_vue_utilisateur__AJOUTER__AJOUT_REFUSE';
$mf_libelle_erreur[ERR_VUE_UTILISATEUR__AJOUTER_3__ECHEC_AJOUT] = 'ERR_vue_utilisateur__AJOUTER_3__ECHEC_AJOUT';
$mf_libelle_erreur[ERR_VUE_UTILISATEUR__MODIFIER__CODE_VUE_UTILISATEUR_INEXISTANT] = 'ERR_vue_utilisateur__MODIFIER__Code_vue_utilisateur_INEXISTANT';
$mf_libelle_erreur[REFUS_VUE_UTILISATEUR__MODIFIER] = 'REFUS_vue_utilisateur__MODIFIER';
$mf_libelle_erreur[ACCES_CODE_VUE_UTILISATEUR_REFUSE] = 'Tentative d\'accès \'Code_vue_utilisateur\' non autorisé';
$mf_libelle_erreur[REFUS_VUE_UTILISATEUR__MODIFICATION_BLOQUEE] = 'REFUS_vue_utilisateur__MODIFICATION_BLOQUEE';
$mf_libelle_erreur[ERR_VUE_UTILISATEUR__MODIFIER__VUE_UTILISATEUR_FILTRE_SAISON_TYPE_NON_VALIDE] = 'ERR_vue_utilisateur__MODIFIER__vue_utilisateur_Filtre_Saison_Type_NON_VALIDE';
$mf_libelle_erreur[ERR_VUE_UTILISATEUR__MODIFIER__VUE_UTILISATEUR_FILTRE_SAISON_TYPE__HORS_WORKFLOW] = 'ERR_vue_utilisateur__MODIFIER__vue_utilisateur_Filtre_Saison_Type__HORS_WORKFLOW';
$mf_libelle_erreur[ERR_VUE_UTILISATEUR__MODIFIER__VUE_UTILISATEUR_FILTRE_TAILLE_PAYS_TYPE_NON_VALIDE] = 'ERR_vue_utilisateur__MODIFIER__vue_utilisateur_Filtre_Taille_Pays_Type_NON_VALIDE';
$mf_libelle_erreur[ERR_VUE_UTILISATEUR__MODIFIER__VUE_UTILISATEUR_FILTRE_TAILLE_PAYS_TYPE__HORS_WORKFLOW] = 'ERR_vue_utilisateur__MODIFIER__vue_utilisateur_Filtre_Taille_Pays_Type__HORS_WORKFLOW';
$mf_libelle_erreur[ERR_VUE_UTILISATEUR__MODIFIER__AUCUN_CHANGEMENT] = 'ERR_vue_utilisateur__MODIFIER__AUCUN_CHANGEMENT';
$mf_libelle_erreur[ERR_VUE_UTILISATEUR__MODIFIER_3__AUCUN_CHANGEMENT] = 'ERR_vue_utilisateur__MODIFIER_3__AUCUN_CHANGEMENT';
$mf_libelle_erreur[ERR_VUE_UTILISATEUR__MODIFIER_4__AUCUN_CHANGEMENT] = 'ERR_vue_utilisateur__MODIFIER_4__AUCUN_CHANGEMENT';
$mf_libelle_erreur[ERR_VUE_UTILISATEUR__SUPPRIMER_2__CODE_VUE_UTILISATEUR_INEXISTANT] = 'ERR_vue_utilisateur__SUPPRIMER_2__Code_vue_utilisateur_INEXISTANT';
$mf_libelle_erreur[REFUS_VUE_UTILISATEUR__SUPPRIMER] = 'REFUS_vue_utilisateur__SUPPRIMER';
$mf_libelle_erreur[REFUS_VUE_UTILISATEUR__SUPPRESSION_BLOQUEE] = 'REFUS_vue_utilisateur__SUPPRESSION_BLOQUEE';
$mf_libelle_erreur[ERR_VUE_UTILISATEUR__SUPPRIMER__REFUSEE] = 'ERR_vue_utilisateur__SUPPRIMER__REFUSEE';
$mf_libelle_erreur[ERR_VUE_UTILISATEUR__SUPPRIMER_2__REFUSEE] = 'ERR_vue_utilisateur__SUPPRIMER_2__REFUSEE';
$mf_libelle_erreur[ERR_VUE_UTILISATEUR__SUPPRIMER_3__REFUSEE] = 'ERR_vue_utilisateur__SUPPRIMER_3__REFUSEE';
