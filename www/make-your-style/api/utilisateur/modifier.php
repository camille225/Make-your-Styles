<?php declare(strict_types=1);

    include __DIR__ . '/../../../../systeme/make-your-style/acces_api_rest/utilisateur.php';
    if (API_REST_ACCESS_PUT_UTILISATEUR == 'all') {
        include __DIR__ . '/../../../../systeme/make-your-style/api_espace_publique.php';
    } else {
        include __DIR__ . '/../../../../systeme/make-your-style/api_espace_privee.php';
    }

    $db = new DB();

/*
    +------------+
    |  Modifier  |
    +------------+
*/
    $Code_utilisateur = lecture_parametre_api("Code_utilisateur", 0 );
    $champs = [];
    if ( isset_parametre_api("utilisateur_Identifiant") ) $champs['utilisateur_Identifiant'] = lecture_parametre_api("utilisateur_Identifiant");
    if ( isset_parametre_api("utilisateur_Email") ) $champs['utilisateur_Email'] = lecture_parametre_api("utilisateur_Email");
    if ( isset_parametre_api("utilisateur_Civilite_Type") ) $champs['utilisateur_Civilite_Type'] = lecture_parametre_api("utilisateur_Civilite_Type");
    if ( isset_parametre_api("utilisateur_Prenom") ) $champs['utilisateur_Prenom'] = lecture_parametre_api("utilisateur_Prenom");
    if ( isset_parametre_api("utilisateur_Nom") ) $champs['utilisateur_Nom'] = lecture_parametre_api("utilisateur_Nom");
    if ( isset_parametre_api("utilisateur_Adresse_1") ) $champs['utilisateur_Adresse_1'] = lecture_parametre_api("utilisateur_Adresse_1");
    if ( isset_parametre_api("utilisateur_Adresse_2") ) $champs['utilisateur_Adresse_2'] = lecture_parametre_api("utilisateur_Adresse_2");
    if ( isset_parametre_api("utilisateur_Ville") ) $champs['utilisateur_Ville'] = lecture_parametre_api("utilisateur_Ville");
    if ( isset_parametre_api("utilisateur_Code_postal") ) $champs['utilisateur_Code_postal'] = lecture_parametre_api("utilisateur_Code_postal");
    if ( isset_parametre_api("utilisateur_Date_naissance") ) $champs['utilisateur_Date_naissance'] = lecture_parametre_api("utilisateur_Date_naissance");
    if ( isset_parametre_api("utilisateur_Accepte_mail_publicitaire") ) $champs['utilisateur_Accepte_mail_publicitaire'] = lecture_parametre_api("utilisateur_Accepte_mail_publicitaire");
    if ( isset_parametre_api("utilisateur_Administrateur") ) $champs['utilisateur_Administrateur'] = lecture_parametre_api("utilisateur_Administrateur");
    if ( isset_parametre_api("utilisateur_Fournisseur") ) $champs['utilisateur_Fournisseur'] = lecture_parametre_api("utilisateur_Fournisseur");
    $retour = $db->utilisateur()->mf_modifier_2([$Code_utilisateur => $champs]);
    if ($retour['code_erreur'] == 0) {
        $cache = new Cachehtml();
        $cache->clear();
    }
    $retour_json = [];
    $retour_json['code_erreur'] = $retour['code_erreur'];
    $retour_json['message_erreur'] = ( (isset($retour) && $retour['code_erreur']>0) ? (isset($mf_libelle_erreur[$retour['code_erreur']]) ? $mf_libelle_erreur[$retour['code_erreur']] : 'ERREUR N_'.$retour['code_erreur'] ) : '' );
    fermeture_connexion_db();
    $retour_json['duree'] = get_execution_time(4);
    vue_api_echo($retour_json);
