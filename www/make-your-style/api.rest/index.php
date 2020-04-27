<?php
include __DIR__ . '/../../../systeme/make-your-style/dblayer_light.php';

$method = $_SERVER['REQUEST_METHOD']; // GET, PUT, POST, DELETE
$_url = '';
$input = file_get_contents('php://input');
$s = 0; // nouvelles tentatives en cas d'échec
while ($input === false && $s < 9) {
    sleep(1);
    $input = file_get_contents('php://input');
    $s ++;
}

$options = array();
foreach ($_GET as $key => $value) {
    if ($key == '_url') {
        $_url = $value;
    } elseif ($key != 'api_token') {
        $options[strtolower($key)] = $value;
    }
}

$url_tableau = explode('/', substr($_url, 1));

$max = count($url_tableau);
if ($max % 2 == 0) {
    $fonction_api = $url_tableau[$max - 2];
    $id = $url_tableau[$max - 1];
    $max -= 2;
} else {
    $fonction_api = $url_tableau[$max - 1];
    $id = '';
    $max -= 1;
}
for ($i = 0; $i < $max; $i += 2) {
    $options['code_' . strtolower($url_tableau[$i])] = $url_tableau[$i + 1];
}

$retour_json = array();

$log = '';

$mf_get_update = true;

if (file_exists("api__$fonction_api.php")) {
    include __DIR__ . "/api__$fonction_api.php";
    // log
    if ($fonction_api != 'mf_connexion.php' && ($method == 'POST' || $method == 'PUT' || $method == 'DELETE')) {
        $log = "[$method] $_url $input";
    }
    // exécution
    switch ($method) {
        case 'GET':
            // Configuraition du long pulling
            if (isset($options['mf_lp']) && $options['mf_lp'] == 1) {
                $lim_execution_time = 60;
            } else {
                $lim_execution_time = -1;
            }
            unset($options['mf_lp']);
            // Get
            $retour_json['data'] = [];
            $nouvelle_lecture = false;
            if (isset($options['mf_connector_token']) && $options['mf_connector_token'] != '') {
                $cache_session_id = $options['mf_connector_token'];
            } elseif (isset($options['mf_token']) && $options['mf_token'] != '') {
                $cache_session_id = $options['mf_token'];
            } else {
                $cache_session_id = session_id();
            }
            $cache = new Cache('mf_signature', $cache_session_id);
            $cle = "@get($id, " . serialize($options) . ")";
            $signature = (string) $cache->read($cle);
            while (! $nouvelle_lecture) {
                $retour_json['data'] = @get($id, $options);
                if ($retour_json['data']['code_erreur'] != 0) {
                    $nouvelle_lecture = true;
                } else {
                    $signature_2 = md5(serialize($retour_json['data']));
                    if ($signature != $signature_2) {
                        $nouvelle_lecture = true;
                        $cache->write($cle, $signature_2);
                    } elseif (get_execution_time() > $lim_execution_time) {
                        $nouvelle_lecture = true;
                        $mf_get_update = false;
                    } else {
                        usleep(WEBSOCKET_PERIOD_US);
                    }
                }
            }
            if (isset($retour_json['data']['http_response_code'])) {
                http_response_code($retour_json['data']['http_response_code']);
                unset($retour_json['data']['http_response_code']);
            }
            break; // renvoie des données
        case 'POST':
            $retour_json['data'] = @post(json_decode($input, true), $options);
            if (isset($retour_json['data']['code_erreur']) && $retour_json['data']['code_erreur'] == 0) {
                if ($fonction_api != 'mf_connexion') {
                    http_response_code(201);
                    if (isset($retour_json['data']['id'])) {
                        if ($fonction_api == 'mf_inscription') {
                            $fonction_api = 'utilisateur';
                        }
                        header('Location: ' . ADRESSE_API . "$fonction_api/{$retour_json['data']['id']}");
                    }
                }
            }
            $cache = new Cachehtml();
            $cache->clear();
            break; // ajoute des données
        case 'PUT':
            $retour_json['data'] = @put($id, json_decode($input, true), $options);
            $cache = new Cachehtml();
            $cache->clear();
            break; // modifie des données
        case 'DELETE':
            $retour_json['data'] = @delete($id, $options);
            $cache = new Cachehtml();
            $cache->clear();
            break; // supprime des données
        case 'OPTIONS':
            $retour_json['options'] = @options($id, json_decode($input, true), $options);
            $cache = new Cachehtml();
            $cache->clear();
            break; // accès aux options
    }
}

if (isset($retour_json['data']['code_erreur'])) {
    $retour_json['error']['number'] = $retour_json['data']['code_erreur'];
    unset($retour_json['data']['code_erreur']);
    $retour_json['error']['label'] = ($mf_message_erreur_personalise == '' ? $mf_libelle_erreur[$retour_json['error']['number']] : $mf_message_erreur_personalise);
} elseif (isset($retour_json['options']['code_erreur'])) {
    $retour_json['error']['number'] = $retour_json['options']['code_erreur'];
    unset($retour_json['options']['code_erreur']);
    $retour_json['error']['label'] = $mf_libelle_erreur[$retour_json['error']['number']];
}

// Suppression des caractères non supportés par le format json
mf_verification_avant_conversion_json($retour_json);

$http_res_code = http_response_code();
$retour_json['resp'] = [
    'status' => $http_res_code,
    'status_msg' => mf_message_http_response_code($http_res_code),
    'execution_time' => get_execution_time()
];

if ($method = 'GET' && isset($retour_json['error']['number']) && $retour_json['error']['number'] != 1) {
    $retour_json['updated'] = ($mf_get_update ? true : false);
}

// log
if ($log != '') {
    log_api($log . PHP_EOL . json_encode($retour_json));
}

fermeture_connexion_db();

// format
$format = isset($_GET['format']) ? $_GET['format'] : 'json';

switch ($format) {
    case 'json':
        header('Content-Type: application/json');
        echo json_encode($retour_json);
        break;
    case 'table':
        echo '<!DOCTYPE html><html lang=""><head><meta charset="UTF-8"><title></title></head><body>' . vue_tableau_html($retour_json) . '</body></html>';
        break;
    case 'excel':
        echo '<!DOCTYPE html><html lang=""><head><meta charset="UTF-8"><title></title></head><body>' . vue_tableau_html($retour_json, '\'') . '</body></html>';
        break;
}

/**
 * Contrôle des droits API
 * @param array $options
 * @param string $droit_methode_api
 * @return array
 */
function mf_api_droits(array &$options, string $droit_methode_api) {
    $code_erreur = 0;
    if (isset($options['mf_connector_token']) && $options['mf_connector_token'] != '') {
        $db = new DB();
        $code = $db -> mf_table(CONNECTEUR_API_TABLE) -> mf_search__colonne(CONNECTEUR_API_COLONNE_TOKEN, $options['mf_connector_token']);
        $r = $db -> mf_table(CONNECTEUR_API_TABLE) -> mf_get($code);
        $totay = substr(get_now(), 0, 10);
        if (! ($code != 0 && $r[CONNECTEUR_API_COLONNE_DATE_START] <= $totay && $totay <= $r[CONNECTEUR_API_COLONNE_DATE_STOP])) {
            $code_erreur = 1; // erreur de connexion
        } elseif (isset($r['Code_utilisateur'])) {
            global $utilisateur_courant;
            $utilisateur_courant = $db -> utilisateur() -> mf_get_2($r['Code_utilisateur']);
        }
    } else {
        if ($droit_methode_api == 'none') {
            $code_erreur = 1; // erreur de connexion
        } elseif ($droit_methode_api == 'user') {
            $auth = isset($_GET['auth']) ? $_GET['auth'] : 'api';
            if ($auth == 'api') {
                $mf_connexion = new Mf_Connexion(true);
                $mf_token = isset($options['mf_token']) ? $options['mf_token'] : '';
                if (! $mf_connexion->est_connecte($mf_token)) {
                    $code_erreur = 1; // erreur de connexion
                }
                if (! isset($options['code_utilisateur'])) {
                    $options['code_utilisateur'] = get_utilisateur_courant('Code_utilisateur');
                }
            } elseif ($auth == 'main') {
                $mf_connexion = new Mf_Connexion();
                if (isset($_SESSION[NOM_PROJET]['token'])) {
                    if (! $mf_connexion->est_connecte($_SESSION[NOM_PROJET]['token'])) {
                        unset($_SESSION[NOM_PROJET]['token']);
                    }
                }
                if (! isset($_SESSION[NOM_PROJET]['token'])) {
                    $code_erreur = 1; // erreur de connexion
                }
            } else {
                $code_erreur = 1;
            }
        } elseif ($droit_methode_api == 'all') {
            $auth = isset($_GET['auth']) ? $_GET['auth'] : 'api';
            if ($auth == 'api') {
                $mf_connexion = new Mf_Connexion(true);
                $mf_token = isset($options['mf_token']) ? $options['mf_token'] : '';
                $mf_connexion->est_connecte($mf_token, false);
                if (! isset($options['code_utilisateur'])) {
                    $options['code_utilisateur'] = get_utilisateur_courant('Code_utilisateur');
                }
            } elseif ($auth == 'main') {
                $mf_connexion = new Mf_Connexion();
                if (isset($_SESSION[NOM_PROJET]['token'])) {
                    if (! $mf_connexion->est_connecte($_SESSION[NOM_PROJET]['token'], false)) {
                        unset($_SESSION[NOM_PROJET]['token']);
                    }
                }
            } else {
                $code_erreur = 1;
            }
        } else {
            $code_erreur = 1; // erreur de connexion
        }
    }
    session_write_close();
    return ['code_erreur' => $code_erreur];
}

