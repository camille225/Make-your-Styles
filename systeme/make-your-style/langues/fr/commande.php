<?php declare(strict_types=1);

$lang_standard['Code_commande'] = 'commande';

$lang_standard['commande_Prix_total'] = 'commande_Prix_total';
$lang_standard['commande_Date_livraison'] = 'commande_Date_livraison';
$lang_standard['commande_Date_creation'] = 'commande_Date_creation';

$lang_standard['bouton_ajouter_commande'] = 'Ajouter';
$lang_standard['bouton_creer_commande'] = 'Créer';
$lang_standard['bouton_modifier_commande'] = 'Modifier';
$lang_standard['bouton_supprimer_commande'] = 'Supprimer';
$lang_standard['bouton_modifier_commande_Prix_total'] = 'Modifier';
$lang_standard['bouton_modifier_commande_Date_livraison'] = 'Modifier';
$lang_standard['bouton_modifier_commande_Date_creation'] = 'Modifier';
$lang_standard['bouton_modifier_commande__Code_utilisateur'] = 'Modifier';

$lang_standard['form_add_commande'] = 'Ajout d\'un nouvel enregistrement';
$lang_standard['form_edit_commande'] = 'Edition de l\'enregistrement';
$lang_standard['form_delete_commande'] = 'Confirmation de suppression de l\'enregistrement';

$mf_titre_ligne_table['commande'] = '{commande_Prix_total}';

$mf_tri_defaut_table['commande'] = ['commande_Prix_total' => 'ASC'];

$lang_standard['libelle_liste_commande'] = 'Enregistrement(s)';

$mf_initialisation['commande_Prix_total'] = null;
$mf_initialisation['commande_Date_livraison'] = '';
$mf_initialisation['commande_Date_creation'] = '';

// code_erreur

$mf_libelle_erreur[REFUS_COMMANDE__AJOUTER] = 'REFUS_commande__AJOUTER';
$mf_libelle_erreur[ERR_COMMANDE__AJOUTER__CODE_UTILISATEUR_INEXISTANT] = 'ERR_commande__AJOUTER__Code_utilisateur_INEXISTANT';
$mf_libelle_erreur[REFUS_COMMANDE__AJOUT_BLOQUEE] = 'REFUS_commande__AJOUT_BLOQUEE';
$mf_libelle_erreur[ERR_COMMANDE__AJOUTER__AJOUT_REFUSE] = 'ERR_commande__AJOUTER__AJOUT_REFUSE';
$mf_libelle_erreur[ERR_COMMANDE__AJOUTER_3__ECHEC_AJOUT] = 'ERR_commande__AJOUTER_3__ECHEC_AJOUT';
$mf_libelle_erreur[ERR_COMMANDE__MODIFIER__CODE_COMMANDE_INEXISTANT] = 'ERR_commande__MODIFIER__Code_commande_INEXISTANT';
$mf_libelle_erreur[REFUS_COMMANDE__MODIFIER] = 'REFUS_commande__MODIFIER';
$mf_libelle_erreur[ERR_COMMANDE__MODIFIER__CODE_UTILISATEUR_INEXISTANT] = 'ERR_commande__MODIFIER__Code_utilisateur_INEXISTANT';
$mf_libelle_erreur[ACCES_CODE_COMMANDE_REFUSE] = 'Tentative d\'accès \'Code_commande\' non autorisé';
$mf_libelle_erreur[REFUS_COMMANDE__MODIFICATION_BLOQUEE] = 'REFUS_commande__MODIFICATION_BLOQUEE';
$mf_libelle_erreur[ERR_COMMANDE__MODIFIER__AUCUN_CHANGEMENT] = 'ERR_commande__MODIFIER__AUCUN_CHANGEMENT';
$mf_libelle_erreur[ERR_COMMANDE__MODIFIER_3__AUCUN_CHANGEMENT] = 'ERR_commande__MODIFIER_3__AUCUN_CHANGEMENT';
$mf_libelle_erreur[ERR_COMMANDE__MODIFIER_4__AUCUN_CHANGEMENT] = 'ERR_commande__MODIFIER_4__AUCUN_CHANGEMENT';
$mf_libelle_erreur[ERR_COMMANDE__SUPPRIMER_2__CODE_COMMANDE_INEXISTANT] = 'ERR_commande__SUPPRIMER_2__Code_commande_INEXISTANT';
$mf_libelle_erreur[REFUS_COMMANDE__SUPPRIMER] = 'REFUS_commande__SUPPRIMER';
$mf_libelle_erreur[REFUS_COMMANDE__SUPPRESSION_BLOQUEE] = 'REFUS_commande__SUPPRESSION_BLOQUEE';
$mf_libelle_erreur[ERR_COMMANDE__SUPPRIMER__REFUSEE] = 'ERR_commande__SUPPRIMER__REFUSEE';
$mf_libelle_erreur[ERR_COMMANDE__SUPPRIMER_2__REFUSEE] = 'ERR_commande__SUPPRIMER_2__REFUSEE';
$mf_libelle_erreur[ERR_COMMANDE__SUPPRIMER_3__REFUSEE] = 'ERR_commande__SUPPRIMER_3__REFUSEE';
