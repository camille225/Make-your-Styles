<?php declare(strict_types=1);

    include __DIR__ . '/../../../../systeme/make-your-style/acces_api_rest/conseil.php';
    if (API_REST_ACCESS_POST_CONSEIL == 'all') {
        include __DIR__ . '/../../../../systeme/make-your-style/api_espace_publique.php';
    } else {
        include __DIR__ . '/../../../../systeme/make-your-style/api_espace_privee.php';
    }

    $db = new DB();

/*
    +-----------+
    |  Ajouter  |
    +-----------+
*/
    $conseil_Libelle = (string) lecture_parametre_api("conseil_Libelle", '');
    $conseil_Description = (string) lecture_parametre_api("conseil_Description", '');
    $conseil_Actif = (bool) lecture_parametre_api("conseil_Actif", '');
    $retour = $db->conseil()->mf_ajouter($conseil_Libelle, $conseil_Description, $conseil_Actif);
    if ( $retour['code_erreur']==0 )
    {
        $cache = new Cachehtml();
        $cache->clear();
    }
    $retour_json = [];
    $retour_json['code_erreur'] = $retour['code_erreur'];
    $retour_json['message_erreur'] = ( (isset($retour) && $retour['code_erreur']>0) ? (isset($mf_libelle_erreur[$retour['code_erreur']]) ? $mf_libelle_erreur[$retour['code_erreur']] : 'ERREUR N_'.$retour['code_erreur'] ) : '' );
    $retour_json['Code_conseil'] = $retour['Code_conseil'];
    fermeture_connexion_db();
    $retour_json['duree'] = get_execution_time(4);
    vue_api_echo($retour_json);
