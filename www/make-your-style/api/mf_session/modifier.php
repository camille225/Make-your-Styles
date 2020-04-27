<?php declare(strict_types=1);

    include __DIR__ . '/../../../../systeme/make-your-style/api_espace_publique.php';

    fermeture_connexion_db();

/*
    +------------+
    |  Modifier  |
    +------------+
*/
    $name = (string) lecture_parametre_api('name', '');
    $value = lecture_parametre_api($name);
    if ($value !== null) {
        Hook_mf_systeme::controle_parametres_session($name, $value);
    }
    if ($value !== null) {
        mf_set_value_session($name, $value);
    }
    $retour_json = [];
    $retour_json['code_erreur'] = 0;
    $retour_json['message_erreur'] = 0;
    $retour_json['duree'] = get_execution_time(4);
    vue_api_echo($retour_json);
