<?php

$lang_standard['Code_article'] = 'article';

$lang_standard['article_Libelle'] = 'article_Libelle';
$lang_standard['article_Photo_Fichier'] = 'article_Photo_Fichier';
$lang_standard['article_Prix'] = 'article_Prix';
$lang_standard['article_Actif'] = 'article_Actif';
$lang_standard['article_Actif_'] = array( 1 => 'Oui', 0 => 'Non' );

$lang_standard['bouton_ajouter_article'] = 'Ajouter';
$lang_standard['bouton_creer_article'] = 'Creer';
$lang_standard['bouton_modifier_article'] = 'Modifier';
$lang_standard['bouton_supprimer_article'] = 'Supprimer';
$lang_standard['bouton_modifier_article_Libelle'] = 'Modifier';
$lang_standard['bouton_modifier_article_Photo_Fichier'] = 'Modifier';
$lang_standard['bouton_modifier_article_Prix'] = 'Modifier';
$lang_standard['bouton_modifier_article_Actif'] = 'Modifier';
$lang_standard['bouton_modifier_article__Code_type_produit'] = 'Modifier';

$lang_standard['form_add_article'] = 'form_add_article';
$lang_standard['form_edit_article'] = 'form_edit_article';
$lang_standard['form_delete_article'] = 'form_delete_article';

$mf_titre_ligne_table['article'] = '{article_Libelle}';

$mf_tri_defaut_table['article'] = array( 'article_Libelle' => 'ASC' );

$lang_standard['libelle_liste_article'] = 'libelle_liste_article';

$mf_initialisation['article_Libelle'] = '';
$mf_initialisation['article_Photo_Fichier'] = '';
$mf_initialisation['article_Prix'] = 0;
$mf_initialisation['article_Actif'] = 0;

// code_erreur

$mf_libelle_erreur[REFUS_ARTICLE__AJOUTER] = 'REFUS_article__AJOUTER';
$mf_libelle_erreur[ERR_ARTICLE__AJOUTER__CODE_TYPE_PRODUIT_INEXISTANT] = 'ERR_article__AJOUTER__Code_type_produit_INEXISTANT';
$mf_libelle_erreur[ACCES_CODE_TYPE_PRODUIT_REFUSE] = 'Tentative d\'accès \'Code_type_produit\' non autorisé';
$mf_libelle_erreur[REFUS_ARTICLE__AJOUT_BLOQUEE] = 'REFUS_article__AJOUT_BLOQUEE';
$mf_libelle_erreur[ERR_ARTICLE__AJOUTER__AJOUT_REFUSE] = 'ERR_article__AJOUTER__AJOUT_REFUSE';
$mf_libelle_erreur[ERR_ARTICLE__AJOUTER_3__ECHEC_AJOUT] = 'ERR_article__AJOUTER_3__ECHEC_AJOUT';
$mf_libelle_erreur[ERR_ARTICLE__MODIFIER__CODE_ARTICLE_INEXISTANT] = 'ERR_article__MODIFIER__Code_article_INEXISTANT';
$mf_libelle_erreur[REFUS_ARTICLE__MODIFIER] = 'REFUS_article__MODIFIER';
$mf_libelle_erreur[ERR_ARTICLE__MODIFIER__CODE_TYPE_PRODUIT_INEXISTANT] = 'ERR_article__MODIFIER__Code_type_produit_INEXISTANT';
$mf_libelle_erreur[ACCES_CODE_ARTICLE_REFUSE] = 'Tentative d\'accès \'Code_article\' non autorisé';
$mf_libelle_erreur[REFUS_ARTICLE__MODIFICATION_BLOQUEE] = 'REFUS_article__MODIFICATION_BLOQUEE';
$mf_libelle_erreur[ERR_ARTICLE__MODIFIER__AUCUN_CHANGEMENT] = 'ERR_article__MODIFIER__AUCUN_CHANGEMENT';
$mf_libelle_erreur[ERR_ARTICLE__MODIFIER_3__AUCUN_CHANGEMENT] = 'ERR_article__MODIFIER_3__AUCUN_CHANGEMENT';
$mf_libelle_erreur[ERR_ARTICLE__MODIFIER_4__AUCUN_CHANGEMENT] = 'ERR_article__MODIFIER_4__AUCUN_CHANGEMENT';
$mf_libelle_erreur[ERR_ARTICLE__SUPPRIMER_2__CODE_ARTICLE_INEXISTANT] = 'ERR_article__SUPPRIMER_2__Code_article_INEXISTANT';
$mf_libelle_erreur[REFUS_ARTICLE__SUPPRIMER] = 'REFUS_article__SUPPRIMER';
$mf_libelle_erreur[REFUS_ARTICLE__SUPPRESSION_BLOQUEE] = 'REFUS_article__SUPPRESSION_BLOQUEE';
$mf_libelle_erreur[ERR_ARTICLE__SUPPRIMER__REFUSEE] = 'ERR_article__SUPPRIMER__REFUSEE';
$mf_libelle_erreur[ERR_ARTICLE__SUPPRIMER_2__REFUSEE] = 'ERR_article__SUPPRIMER_2__REFUSEE';
$mf_libelle_erreur[ERR_ARTICLE__SUPPRIMER_3__REFUSEE] = 'ERR_article__SUPPRIMER_3__REFUSEE';
