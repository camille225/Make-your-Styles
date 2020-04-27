<?php declare(strict_types=1);

$lang_standard['Code_article'] = 'article';

$lang_standard['article_Libelle'] = 'article_Libelle';
$lang_standard['article_Description'] = 'article_Description';
$lang_standard['article_Saison_Type'] = 'article_Saison_Type';
$lang_standard['article_Saison_Type_'] = [1 => "Etat 1", 2 => "Etat 2", 3 => "Etat 3"];
$lang_standard['article_Nom_fournisseur'] = 'article_Nom_fournisseur';
$lang_standard['article_Url'] = 'article_Url';
$lang_standard['article_Reference'] = 'article_Reference';
$lang_standard['article_Couleur'] = 'article_Couleur';
$lang_standard['article_Code_couleur_svg'] = 'article_Code_couleur_svg';
$lang_standard['article_Taille_Pays_Type'] = 'article_Taille_Pays_Type';
$lang_standard['article_Taille_Pays_Type_'] = [1 => "Etat 1", 2 => "Etat 2", 3 => "Etat 3"];
$lang_standard['article_Taille'] = 'article_Taille';
$lang_standard['article_Matiere'] = 'article_Matiere';
$lang_standard['article_Photo_Fichier'] = 'article_Photo_Fichier';
$lang_standard['article_Prix'] = 'article_Prix';
$lang_standard['article_Actif'] = 'article_Actif';
$lang_standard['article_Actif_'] = [1 => "Oui", 0 => "Non"];

$lang_standard['bouton_ajouter_article'] = 'Ajouter';
$lang_standard['bouton_creer_article'] = 'Créer';
$lang_standard['bouton_modifier_article'] = 'Modifier';
$lang_standard['bouton_supprimer_article'] = 'Supprimer';
$lang_standard['bouton_modifier_article_Libelle'] = 'Modifier';
$lang_standard['bouton_modifier_article_Description'] = 'Modifier';
$lang_standard['bouton_modifier_article_Saison_Type'] = 'Modifier';
$lang_standard['bouton_modifier_article_Nom_fournisseur'] = 'Modifier';
$lang_standard['bouton_modifier_article_Url'] = 'Modifier';
$lang_standard['bouton_modifier_article_Reference'] = 'Modifier';
$lang_standard['bouton_modifier_article_Couleur'] = 'Modifier';
$lang_standard['bouton_modifier_article_Code_couleur_svg'] = 'Modifier';
$lang_standard['bouton_modifier_article_Taille_Pays_Type'] = 'Modifier';
$lang_standard['bouton_modifier_article_Taille'] = 'Modifier';
$lang_standard['bouton_modifier_article_Matiere'] = 'Modifier';
$lang_standard['bouton_modifier_article_Photo_Fichier'] = 'Modifier';
$lang_standard['bouton_modifier_article_Prix'] = 'Modifier';
$lang_standard['bouton_modifier_article_Actif'] = 'Modifier';
$lang_standard['bouton_modifier_article__Code_sous_categorie_article'] = 'Modifier';

$lang_standard['form_add_article'] = 'Ajout d\'un nouvel enregistrement';
$lang_standard['form_edit_article'] = 'Edition de l\'enregistrement';
$lang_standard['form_delete_article'] = 'Confirmation de suppression de l\'enregistrement';

$mf_titre_ligne_table['article'] = '{article_Libelle}';

$mf_tri_defaut_table['article'] = ['article_Libelle' => 'ASC'];

$lang_standard['libelle_liste_article'] = 'Enregistrement(s)';

$mf_initialisation['article_Libelle'] = '';
$mf_initialisation['article_Description'] = '';
$mf_initialisation['article_Saison_Type'] = 1;
$mf_initialisation['article_Nom_fournisseur'] = '';
$mf_initialisation['article_Url'] = '';
$mf_initialisation['article_Reference'] = '';
$mf_initialisation['article_Couleur'] = '';
$mf_initialisation['article_Code_couleur_svg'] = '';
$mf_initialisation['article_Taille_Pays_Type'] = 1;
$mf_initialisation['article_Taille'] = null;
$mf_initialisation['article_Matiere'] = '';
$mf_initialisation['article_Photo_Fichier'] = '';
$mf_initialisation['article_Prix'] = null;
$mf_initialisation['article_Actif'] = 0;

// code_erreur

$mf_libelle_erreur[REFUS_ARTICLE__AJOUTER] = 'REFUS_article__AJOUTER';
$mf_libelle_erreur[ERR_ARTICLE__AJOUTER__CODE_SOUS_CATEGORIE_ARTICLE_INEXISTANT] = 'ERR_article__AJOUTER__Code_sous_categorie_article_INEXISTANT';
$mf_libelle_erreur[ACCES_CODE_SOUS_CATEGORIE_ARTICLE_REFUSE] = 'Tentative d\'accès \'Code_sous_categorie_article\' non autorisé';
$mf_libelle_erreur[REFUS_ARTICLE__AJOUT_BLOQUEE] = 'REFUS_article__AJOUT_BLOQUEE';
$mf_libelle_erreur[ERR_ARTICLE__AJOUTER__ARTICLE_SAISON_TYPE_NON_VALIDE] = 'ERR_article__AJOUTER__article_Saison_Type_NON_VALIDE';
$mf_libelle_erreur[ERR_ARTICLE__AJOUTER__ARTICLE_TAILLE_PAYS_TYPE_NON_VALIDE] = 'ERR_article__AJOUTER__article_Taille_Pays_Type_NON_VALIDE';
$mf_libelle_erreur[ERR_ARTICLE__AJOUTER__AJOUT_REFUSE] = 'ERR_article__AJOUTER__AJOUT_REFUSE';
$mf_libelle_erreur[ERR_ARTICLE__AJOUTER_3__ECHEC_AJOUT] = 'ERR_article__AJOUTER_3__ECHEC_AJOUT';
$mf_libelle_erreur[ERR_ARTICLE__MODIFIER__CODE_ARTICLE_INEXISTANT] = 'ERR_article__MODIFIER__Code_article_INEXISTANT';
$mf_libelle_erreur[REFUS_ARTICLE__MODIFIER] = 'REFUS_article__MODIFIER';
$mf_libelle_erreur[ERR_ARTICLE__MODIFIER__CODE_SOUS_CATEGORIE_ARTICLE_INEXISTANT] = 'ERR_article__MODIFIER__Code_sous_categorie_article_INEXISTANT';
$mf_libelle_erreur[ACCES_CODE_ARTICLE_REFUSE] = 'Tentative d\'accès \'Code_article\' non autorisé';
$mf_libelle_erreur[REFUS_ARTICLE__MODIFICATION_BLOQUEE] = 'REFUS_article__MODIFICATION_BLOQUEE';
$mf_libelle_erreur[ERR_ARTICLE__MODIFIER__ARTICLE_SAISON_TYPE_NON_VALIDE] = 'ERR_article__MODIFIER__article_Saison_Type_NON_VALIDE';
$mf_libelle_erreur[ERR_ARTICLE__MODIFIER__ARTICLE_SAISON_TYPE__HORS_WORKFLOW] = 'ERR_article__MODIFIER__article_Saison_Type__HORS_WORKFLOW';
$mf_libelle_erreur[ERR_ARTICLE__MODIFIER__ARTICLE_TAILLE_PAYS_TYPE_NON_VALIDE] = 'ERR_article__MODIFIER__article_Taille_Pays_Type_NON_VALIDE';
$mf_libelle_erreur[ERR_ARTICLE__MODIFIER__ARTICLE_TAILLE_PAYS_TYPE__HORS_WORKFLOW] = 'ERR_article__MODIFIER__article_Taille_Pays_Type__HORS_WORKFLOW';
$mf_libelle_erreur[ERR_ARTICLE__MODIFIER__AUCUN_CHANGEMENT] = 'ERR_article__MODIFIER__AUCUN_CHANGEMENT';
$mf_libelle_erreur[ERR_ARTICLE__MODIFIER_3__AUCUN_CHANGEMENT] = 'ERR_article__MODIFIER_3__AUCUN_CHANGEMENT';
$mf_libelle_erreur[ERR_ARTICLE__MODIFIER_4__AUCUN_CHANGEMENT] = 'ERR_article__MODIFIER_4__AUCUN_CHANGEMENT';
$mf_libelle_erreur[ERR_ARTICLE__SUPPRIMER_2__CODE_ARTICLE_INEXISTANT] = 'ERR_article__SUPPRIMER_2__Code_article_INEXISTANT';
$mf_libelle_erreur[REFUS_ARTICLE__SUPPRIMER] = 'REFUS_article__SUPPRIMER';
$mf_libelle_erreur[REFUS_ARTICLE__SUPPRESSION_BLOQUEE] = 'REFUS_article__SUPPRESSION_BLOQUEE';
$mf_libelle_erreur[ERR_ARTICLE__SUPPRIMER__REFUSEE] = 'ERR_article__SUPPRIMER__REFUSEE';
$mf_libelle_erreur[ERR_ARTICLE__SUPPRIMER_2__REFUSEE] = 'ERR_article__SUPPRIMER_2__REFUSEE';
$mf_libelle_erreur[ERR_ARTICLE__SUPPRIMER_3__REFUSEE] = 'ERR_article__SUPPRIMER_3__REFUSEE';
