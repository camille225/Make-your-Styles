<?php declare(strict_types=1);

$lang_standard['a_commande_article'] = 'a_commande_article';

/* debut developpement */
$lang_standard['a_commande_article_Quantite'] = 'Quantité';
$lang_standard['a_commande_article_Prix_ligne'] = 'Prix de la ligne';
/* fin developpement */

$lang_standard['bouton_ajouter_a_commande_article'] = 'Ajouter';
$lang_standard['bouton_creer_a_commande_article'] = 'Créer';
$lang_standard['bouton_modifier_a_commande_article'] = 'Modifier';
$lang_standard['bouton_supprimer_a_commande_article'] = 'Supprimer';
$lang_standard['bouton_modifier_a_commande_article_Quantite'] = 'Modifier';
$lang_standard['bouton_modifier_a_commande_article_Prix_ligne'] = 'Modifier';

$lang_standard['form_add_a_commande_article'] = 'Ajout d\'un nouvel enregistrement';
$lang_standard['form_edit_a_commande_article'] = 'Edition de l\'enregistrement';
$lang_standard['form_delete_a_commande_article'] = 'Confirmation de suppression de l\'enregistrement';

$mf_titre_ligne_table['a_commande_article'] = '{Code_commande} - {Code_article}';

$mf_tri_defaut_table['a_commande_article'] = ['a_commande_article_Quantite' => 'ASC'];

$lang_standard['libelle_liste_a_commande_article'] = 'Enregistrement(s)';

$mf_initialisation['a_commande_article_Quantite'] = null;
$mf_initialisation['a_commande_article_Prix_ligne'] = null;

// code_erreur

$mf_libelle_erreur[REFUS_A_COMMANDE_ARTICLE__AJOUTER] = 'REFUS_a_commande_article__AJOUTER';
$mf_libelle_erreur[ERR_A_COMMANDE_ARTICLE__AJOUTER__CODE_COMMANDE_INEXISTANT] = 'ERR_a_commande_article__AJOUTER__Code_commande_INEXISTANT';
$mf_libelle_erreur[ERR_A_COMMANDE_ARTICLE__AJOUTER__CODE_ARTICLE_INEXISTANT] = 'ERR_a_commande_article__AJOUTER__Code_article_INEXISTANT';
$mf_libelle_erreur[ERR_A_COMMANDE_ARTICLE__AJOUTER__DOUBLON] = 'ERR_a_commande_article__AJOUTER__DOUBLON';
$mf_libelle_erreur[REFUS_A_COMMANDE_ARTICLE__AJOUT_BLOQUEE] = 'REFUS_a_commande_article__AJOUT_BLOQUEE';
$mf_libelle_erreur[ERR_A_COMMANDE_ARTICLE__AJOUTER__REFUSE] = 'ERR_a_commande_article__AJOUTER__REFUSE';
$mf_libelle_erreur[ERR_A_COMMANDE_ARTICLE__AJOUTER_3__ECHEC_AJOUT] = 'ERR_a_commande_article__AJOUTER_3__ECHEC_AJOUT';
$mf_libelle_erreur[REFUS_A_COMMANDE_ARTICLE__MODIFIER] = 'REFUS_a_commande_article__MODIFIER';
$mf_libelle_erreur[ERR_A_COMMANDE_ARTICLE__MODIFIER__CODE_COMMANDE_INEXISTANT] = 'ERR_a_commande_article__MODIFIER__Code_commande_INEXISTANT';
$mf_libelle_erreur[ERR_A_COMMANDE_ARTICLE__MODIFIER__CODE_ARTICLE_INEXISTANT] = 'ERR_a_commande_article__MODIFIER__Code_article_INEXISTANT';
$mf_libelle_erreur[ERR_A_COMMANDE_ARTICLE__MODIFIER__INEXISTANT] = 'ERR_a_commande_article__MODIFIER__INEXISTANT';
$mf_libelle_erreur[REFUS_A_COMMANDE_ARTICLE__MODIFICATION_BLOQUEE] = 'REFUS_a_commande_article__MODIFICATION_BLOQUEE';
$mf_libelle_erreur[ERR_A_COMMANDE_ARTICLE__MODIFIER__AUCUN_CHANGEMENT] = 'ERR_a_commande_article__MODIFIER__AUCUN_CHANGEMENT';
$mf_libelle_erreur[ERR_A_COMMANDE_ARTICLE__MODIFIER_3__AUCUN_CHANGEMENT] = 'ERR_a_commande_article__MODIFIER_3__AUCUN_CHANGEMENT';
$mf_libelle_erreur[ERR_A_COMMANDE_ARTICLE__MODIFIER_4__AUCUN_CHANGEMENT] = 'ERR_a_commande_article__MODIFIER_4__AUCUN_CHANGEMENT';
$mf_libelle_erreur[REFUS_A_COMMANDE_ARTICLE__SUPPRIMER] = 'REFUS_a_commande_article__SUPPRIMER';
$mf_libelle_erreur[REFUS_A_COMMANDE_ARTICLE__SUPPRESSION_BLOQUEE] = 'REFUS_a_commande_article__SUPPRESSION_BLOQUEE';
$mf_libelle_erreur[ERR_A_COMMANDE_ARTICLE__SUPPRIMER__REFUSE] = 'ERR_a_commande_article__SUPPRIMER__REFUSE';
$mf_libelle_erreur[ERR_A_COMMANDE_ARTICLE__SUPPRIMER_2__REFUSE] = 'ERR_a_commande_article__SUPPRIMER_2__REFUSE';
