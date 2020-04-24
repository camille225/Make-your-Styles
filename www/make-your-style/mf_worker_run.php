<?php declare(strict_types=1);

header("Content-Type: text/plain");

include __DIR__ . '/../../systeme/make-your-style/dblayer_light.php';

session_write_close();

/* sauvegarde de la base de données */
$adresse_dossier_dump = get_dossier_data('dump');
$nom_fichier_sauvegarde = 'db_dump_' . NOM_PROJET . '_' . substr(get_now(), 0, 10) . '.sql.gz';
if (! file_exists("$adresse_dossier_dump$nom_fichier_sauvegarde")) {
    if (DB_PORT != null) {
        system('mysqldump --host=' . DB_HOST . ' --user=' . DB_USER . ' --port=' . DB_PORT . ' --password=' . DB_PASSWORD . ' ' . DB_NAME . ' ' . get_liste_dump() . ' | gzip > ' . $adresse_dossier_dump . $nom_fichier_sauvegarde);
    } else {
        system('mysqldump --host=' . DB_HOST . ' --user=' . DB_USER . ' --password=' . DB_PASSWORD . ' ' . DB_NAME . ' ' . get_liste_dump() . ' | gzip > ' . $adresse_dossier_dump . $nom_fichier_sauvegarde);
    }
}
/* Déclenchement du worker */
$r = mf_worker_run();
/* Si le worker s'est déclenché */
if ($r != '-') {
    // maj indexe session
    maj_mf_index_login();
    // clean
    $liste_table = [];
    foreach ($mf_dictionnaire_db as $item) {
        $liste_table[$item['entite']] = $item['entite'];
    }
    foreach ($liste_table as $table) {
        if (get_execution_time() < DELAI_EXECUTION_WORKER) {
            $cache_db = new Mf_Cachedb($table);
            $cache_db -> clean();
        }
    }
    /* Suppression des anciennes sauvegardes */
    $files = glob("$adresse_dossier_dump*");
    foreach ($files as $file) {
        if (time() - filemtime($file) > DUREE_HISTORIQUE * 86400) {
            unlink($file);
        }
    }
    echo $r;
} else {
    echo 'already updated' . PHP_EOL;
}
/* Fermeture de la connexion */
fermeture_connexion_db();
/* Restitution des logs */
mf_file_append_whrite();
