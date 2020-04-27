<?php declare(strict_types=1);

    include __DIR__ . '/../../../../systeme/make-your-style/acces_api_rest/conseil.php';
    if (API_REST_ACCESS_GET_CONSEIL == 'all') {
        include __DIR__ . '/../../../../systeme/make-your-style/api_espace_publique.php';
    } else {
        include __DIR__ . '/../../../../systeme/make-your-style/api_espace_privee.php';
    }

    $db = new DB();

/*
    +----------+
    |  Lister  |
    +----------+
*/
    $retour_json = [];
    $retour_json['liste'] = $db->conseil()->mf_lister(['autocompletion' => true]);
    fermeture_connexion_db();
    $retour_json['duree'] = get_execution_time(4);
    vue_api_echo($retour_json);
