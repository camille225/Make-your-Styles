<?php declare(strict_types=1);

    include __DIR__ . '/../../../../systeme/make-your-style/acces_api_rest/commande.php';
    if (API_REST_ACCESS_PUT_COMMANDE == 'all') {
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
    $Code_commande = lecture_parametre_api("Code_commande", 0 );
    $champs = [];
    if ( isset_parametre_api("commande_Prix_total") ) $champs['commande_Prix_total'] = lecture_parametre_api("commande_Prix_total");
    if ( isset_parametre_api("commande_Date_livraison") ) $champs['commande_Date_livraison'] = lecture_parametre_api("commande_Date_livraison");
    if ( isset_parametre_api("commande_Date_creation") ) $champs['commande_Date_creation'] = lecture_parametre_api("commande_Date_creation");
    if ( isset_parametre_api("Code_utilisateur") ) $champs['Code_utilisateur'] = lecture_parametre_api("Code_utilisateur");
    $retour = $db->commande()->mf_modifier_2([$Code_commande => $champs]);
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
