<?php
include __DIR__ . '/dblayer_light.php';

if (isset($_SESSION[NOM_PROJET]['token'])) {
    $mf_connexion = new Mf_Connexion(false);
    if (! $mf_connexion->est_connecte($_SESSION[NOM_PROJET]['token'], false)) {
        unset($_SESSION[NOM_PROJET]['token']);
    }
}

session_write_close();

if (! isset($_SESSION[NOM_PROJET]['token'])) {
    $mf_token = lecture_parametre_api('mf_token', '');

    $mf_connexion = new Mf_Connexion(true);
    $mf_connexion->est_connecte($mf_token, false);
}
