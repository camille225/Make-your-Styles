<?php declare(strict_types=1);

error_reporting(E_ALL);

header("Content-Type: text/plain");

$mf_host = 'localhost';

include __DIR__ . '/../dblayer_light.php';

$db = new DB();

$last_execution_time_max = 0;
while (get_execution_time() < 3559 - $last_execution_time_max * 1.5) {
    echo PHP_EOL;
    echo '+--------------------------------------------------------' . PHP_EOL;
    echo '| WORKER - Time from start : ' . get_execution_time() . ' s' . PHP_EOL;
    echo '+--------------------------------------------------------' . PHP_EOL;
    $start = microtime(true);
    if (TABLE_INSTANCE == '') {
        // Lancement du worker
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, ADRESSE_SITE . "mf_worker_run.php");
        curl_setopt( $ch, CURLOPT_COOKIESESSION, true );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false);
        $r = curl_exec( $ch );
        curl_close( $ch );
    } else {
        // Lancement successif des workers
        // Liste des sessions
        $liste_ession = $db -> mf_table(TABLE_INSTANCE) -> mf_lister();
        // Run
        while (count($liste_ession) > 0) {
            foreach ($liste_ession as $k => $session) {
                $instance = $session[MF_INSTANCE_DE_FACTURATION__ID];
                // Lancement du worker
                $ch = curl_init();
                curl_setopt( $ch, CURLOPT_URL, ADRESSE_SITE . "mf_worker_run.php?mf_instance=$instance");
                curl_setopt( $ch, CURLOPT_COOKIESESSION, true );
                curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
                curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false);
                $r = curl_exec( $ch );
                curl_close( $ch );
                if (substr($r, 0, 15) != 'already updated') {
                    unset($liste_ession[$k]);
                    echo "Session n°$instance : $r";
                }
                usleep(100000);
            }
            sleep(1);
        }
    }
    // Statistiques
    $last_execution_time = microtime(true) - $start;
    echo " => Execution time : $last_execution_time s" . PHP_EOL;
    if ($last_execution_time > $last_execution_time_max) {
        $last_execution_time_max = $last_execution_time;
    }
    // Relance après DELAI_EXECUTION_WORKER + 1 seconde
    while (microtime(true) - $start < DELAI_EXECUTION_WORKER + 1) {
        sleep(1);
    }
}

fermeture_connexion_db();
