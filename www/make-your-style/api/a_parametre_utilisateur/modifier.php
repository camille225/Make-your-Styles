<?php declare(strict_types=1);

    include __DIR__ . '/../../../../systeme/make-your-style/acces_api_rest/a_parametre_utilisateur.php';
    if (API_REST_ACCESS_PUT_A_PARAMETRE_UTILISATEUR == 'all') {
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
    $Code_utilisateur = lecture_parametre_api("Code_utilisateur", $utilisateur_courant['Code_utilisateur'] );
    $Code_parametre = lecture_parametre_api("Code_parametre", 0 );
    $champs = ['Code_utilisateur'=>$Code_utilisateur, 'Code_parametre'=>$Code_parametre];
    if ( isset_parametre_api("a_parametre_utilisateur_Valeur") ) $champs['a_parametre_utilisateur_Valeur'] = lecture_parametre_api("a_parametre_utilisateur_Valeur");
    if ( isset_parametre_api("a_parametre_utilisateur_Actif") ) $champs['a_parametre_utilisateur_Actif'] = lecture_parametre_api("a_parametre_utilisateur_Actif");
    $retour = $db->a_parametre_utilisateur()->mf_modifier_2([$champs]);
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
