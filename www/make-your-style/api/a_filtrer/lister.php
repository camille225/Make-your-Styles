<?php declare(strict_types=1);

    include __DIR__ . '/../../../../systeme/make-your-style/acces_api_rest/a_filtrer.php';
    if (API_REST_ACCESS_GET_A_FILTRER == 'all') {
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
    $Code_utilisateur = (int) lecture_parametre_api("Code_utilisateur", $utilisateur_courant['Code_utilisateur'] );
    $Code_vue_utilisateur = (int) lecture_parametre_api("Code_vue_utilisateur", 0 );
    $retour_json = [];
    $retour_json['liste'] = $db->a_filtrer()->mf_lister($Code_utilisateur, $Code_vue_utilisateur, ['autocompletion' => true]);
    fermeture_connexion_db();
    $retour_json['duree'] = get_execution_time(4);
    vue_api_echo($retour_json);
