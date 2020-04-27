<?php declare(strict_types=1);

    include __DIR__ . '/../../../../systeme/make-your-style/acces_api_rest/vue_utilisateur.php';
    if (API_REST_ACCESS_GET_VUE_UTILISATEUR == 'all') {
        include __DIR__ . '/../../../../systeme/make-your-style/api_espace_publique.php';
    } else {
        include __DIR__ . '/../../../../systeme/make-your-style/api_espace_privee.php';
    }

    $db = new DB();

/*
    +-------+
    |  Get  |
    +-------+
*/
    $Code_vue_utilisateur = (int) lecture_parametre_api("Code_vue_utilisateur", 0);
    $retour_json = [];
    $nouvelle_lecture = false;
    $cache = new Cache('mf_signature', session_id());
    $cle = md5("get_vue_utilisateur_$Code_vue_utilisateur");
    $signature = (string) $cache->read($cle);
    while (! $nouvelle_lecture) {
        $mf_cache_volatil = new Mf_cache_volatil(); // suppression du cache volatil
        $retour_json['get'] = $db->vue_utilisateur()->mf_get( $Code_vue_utilisateur, ['autocompletion' => true]);
        fermeture_connexion_db();
        $signature_2 = md5(serialize($retour_json['get']));
        if ($signature != $signature_2) {
            $nouvelle_lecture = true;
            $cache->write($cle, $signature_2);
        } elseif (get_execution_time() > 3) {
            $nouvelle_lecture = true;
        } else {
            usleep(WEBSOCKET_PERIOD_US);
        }
    }
    $retour_json['duree'] = get_execution_time(4);
    vue_api_echo($retour_json);
