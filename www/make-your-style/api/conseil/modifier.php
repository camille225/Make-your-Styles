<?php declare(strict_types=1);

    include __DIR__ . '/../../../../systeme/make-your-style/acces_api_rest/conseil.php';
    if (API_REST_ACCESS_PUT_CONSEIL == 'all') {
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
    $Code_conseil = lecture_parametre_api("Code_conseil", 0 );
    $champs = [];
    if ( isset_parametre_api("conseil_Libelle") ) $champs['conseil_Libelle'] = lecture_parametre_api("conseil_Libelle");
    if ( isset_parametre_api("conseil_Description") ) $champs['conseil_Description'] = lecture_parametre_api("conseil_Description");
    if ( isset_parametre_api("conseil_Actif") ) $champs['conseil_Actif'] = lecture_parametre_api("conseil_Actif");
    $retour = $db->conseil()->mf_modifier_2([$Code_conseil => $champs]);
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
