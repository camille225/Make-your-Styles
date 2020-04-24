<?php declare(strict_types=1);

    include __DIR__ . '/../../../../systeme/make-your-style/api_espace_publique.php';

    fermeture_connexion_db();

/*
    +-------+
    |  Get  |
    +-------+
*/
    $retour_json = [];
    $nouvelle_lecture = false;
    $cache = new Cache('mf_signature', session_id());
    $cle = md5("get_mf_session");
    $signature = (string) $cache->read($cle);
    while (! $nouvelle_lecture) {
        $retour_json['get'] = mf_get_list_session_values();
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
