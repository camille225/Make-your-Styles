<?php
include __DIR__ . '/../../../systeme/make-your-style/acces_api_rest/a_parametre_utilisateur.php';

function get($id, $options)
{
    if ( isset($options['mf_connector_token']) && $options['mf_connector_token']!='' )
    {
        $db = new DB();
        $code = $db -> mf_table(CONNECTEUR_API_TABLE) -> mf_search__colonne(CONNECTEUR_API_COLONNE_TOKEN, $options['mf_connector_token']);
        $r = $db -> mf_table(CONNECTEUR_API_TABLE) -> mf_get($code);
        $totay = substr(get_now(), 0, 10);
        if (! ($code != 0 && $r[CONNECTEUR_API_COLONNE_DATE_START] <= $totay && $totay <= $r[CONNECTEUR_API_COLONNE_DATE_STOP])) {
            return array('code_erreur' => 1); // erreur de connexion
        }
        if (isset($r['Code_utilisateur'])) {
            global $utilisateur_courant;
            $utilisateur_courant = $db -> utilisateur() -> mf_get_2($r['Code_utilisateur']);
        }
    }
    else
    {
        if (API_REST_ACCESS_GET_A_PARAMETRE_UTILISATEUR == 'none') {
            return array('code_erreur' => 1); // erreur de connexion
        }
        elseif (API_REST_ACCESS_GET_A_PARAMETRE_UTILISATEUR == 'user') {
            $auth = isset($_GET['auth']) ? $_GET['auth'] : 'api';
            if ($auth == 'api') {
                $mf_connexion = new Mf_Connexion(true);
                $mf_token = isset($options['mf_token']) ? $options['mf_token'] : '';
                if (! $mf_connexion->est_connecte($mf_token)) {
                    return array('code_erreur' => 1); // erreur de connexion
                }
                if (! isset($options['code_utilisateur'])) {
                    $options['code_utilisateur'] = get_utilisateur_courant('Code_utilisateur');
                }
            } elseif ($auth == 'main') {
                $mf_connexion = new Mf_Connexion();
                if (isset($_SESSION[PREFIXE_SESSION]['token'])) {
                    if (! $mf_connexion->est_connecte($_SESSION[PREFIXE_SESSION]['token'])) {
                        unset($_SESSION[PREFIXE_SESSION]['token']);
                    }
                }
                if (! isset($_SESSION[PREFIXE_SESSION]['token'])) {
                    return array('code_erreur' => 1); // erreur de connexion
                }
            }
        }
        elseif ( API_REST_ACCESS_GET_A_PARAMETRE_UTILISATEUR!='all' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
    }

    session_write_close();

    $table_a_parametre_utilisateur = new a_parametre_utilisateur();
    if ($id != '') {
        $table_id = explode('-', $id);
        $code_utilisateur = isset($table_id[0]) ? $table_id[0] : -1;
        $code_parametre = isset($table_id[1]) ? $table_id[1] : -1;
    } else {
        $code_utilisateur = isset($options['code_utilisateur']) ? $options['code_utilisateur'] : 0;
        $code_parametre = isset($options['code_parametre']) ? $options['code_parametre'] : 0;
    }
    $l = $table_a_parametre_utilisateur->mf_lister($code_utilisateur, $code_parametre, array( 'autocompletion' => true ));
    foreach ($l as $k => &$v) {
        $v = array_merge(['Code_a_parametre_utilisateur'=>$k], $v);
    }
    unset($v);
    $l = array_values($l);
    $l['code_erreur'] = 0;
    return $l;
}

function post($data, $options)
{
    if ( isset($options['mf_connector_token']) && $options['mf_connector_token']!='' )
    {
        $db = new DB();
        $code = $db -> mf_table(CONNECTEUR_API_TABLE) -> mf_search__colonne(CONNECTEUR_API_COLONNE_TOKEN, $options['mf_connector_token']);
        $r = $db -> mf_table(CONNECTEUR_API_TABLE) -> mf_get($code);
        $totay = substr(get_now(), 0, 10);
        if (! ($code != 0 && $r[CONNECTEUR_API_COLONNE_DATE_START] <= $totay && $totay <= $r[CONNECTEUR_API_COLONNE_DATE_STOP])) {
            return array('code_erreur' => 1); // erreur de connexion
        }
        if (isset($r['Code_utilisateur'])) {
            global $utilisateur_courant;
            $utilisateur_courant = $db -> utilisateur() -> mf_get_2($r['Code_utilisateur']);
        }
    }
    else
    {
        if (API_REST_ACCESS_POST_A_PARAMETRE_UTILISATEUR == 'none') {
            return array('code_erreur' => 1); // erreur de connexion
        }
        elseif (API_REST_ACCESS_POST_A_PARAMETRE_UTILISATEUR == 'user') {
            $auth = isset($_GET['auth']) ? $_GET['auth'] : 'api';
            if ($auth == 'api') {
                $mf_connexion = new Mf_Connexion(true);
                $mf_token = isset($options['mf_token']) ? $options['mf_token'] : '';
                if (! $mf_connexion->est_connecte($mf_token)) {
                    return array('code_erreur' => 1); // erreur de connexion
                }
                if (! isset($options['code_utilisateur']) && ! isset($data['Code_utilisateur'])) {
                    $options['code_utilisateur'] = get_utilisateur_courant('Code_utilisateur');
                }
            } elseif ($auth == 'main') {
                $mf_connexion = new Mf_Connexion();
                if (isset($_SESSION[PREFIXE_SESSION]['token'])) {
                    if (! $mf_connexion->est_connecte($_SESSION[PREFIXE_SESSION]['token'])) {
                        unset($_SESSION[PREFIXE_SESSION]['token']);
                    }
                }
                if (! isset($_SESSION[PREFIXE_SESSION]['token'])) {
                    return array('code_erreur' => 1); // erreur de connexion
                }
            }
        }
        elseif ( API_REST_ACCESS_POST_A_PARAMETRE_UTILISATEUR!='all' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
    }

    session_write_close();

    $table_a_parametre_utilisateur = new a_parametre_utilisateur();
    if (is_array(current($data))) {
        $retour = $table_a_parametre_utilisateur -> mf_supprimer( ( isset($options['code_utilisateur']) ? $options['code_utilisateur'] : 0 ), ( isset($options['code_parametre']) ? $options['code_parametre'] : 0 ) );
        if ($retour['code_erreur'] == 0) {
            foreach ($data as $value) {
                if (isset($options['code_utilisateur'])) $value['Code_utilisateur'] = $options['code_utilisateur'];
                if (isset($options['code_parametre'])) $value['Code_parametre'] = $options['code_parametre'];
                $retour = $table_a_parametre_utilisateur->mf_ajouter_2($value);
                if ($retour['code_erreur'] != 0) {
                    return $retour;
                }
            }
        }
    } else {
        if (isset($options['code_utilisateur'])) {
            $data['Code_utilisateur'] = $options['code_utilisateur'];
        }
        if (isset($options['code_parametre'])) {
            $data['Code_parametre'] = $options['code_parametre'];
        }
        $a_parametre_utilisateur = $table_a_parametre_utilisateur->mf_get( $data['Code_utilisateur'], $data['Code_parametre'] );
        if (isset($a_parametre_utilisateur['Code_utilisateur'])) {
            $retour['code_erreur'] = 0;
            $table_a_parametre_utilisateur->mf_modifier_2([$data]);
            $retour['callback'] = Hook_a_parametre_utilisateur::callback_post( $data['Code_utilisateur'], $data['Code_parametre'] );
        } else {
            $retour = $table_a_parametre_utilisateur->mf_ajouter_2($data);
        }
        if ($retour['code_erreur'] == 0) {
            $retour['id'] = $data['Code_utilisateur'].'-'.$data['Code_parametre'];
        } else {
            $retour['id'] = '';
        }
    }
    return $retour;
}

function put($id, $data, $options)
{
    if ( isset($options['mf_connector_token']) && $options['mf_connector_token']!='' )
    {
        $db = new DB();
        $code = $db -> mf_table(CONNECTEUR_API_TABLE) -> mf_search__colonne(CONNECTEUR_API_COLONNE_TOKEN, $options['mf_connector_token']);
        $r = $db -> mf_table(CONNECTEUR_API_TABLE) -> mf_get($code);
        $totay = substr(get_now(), 0, 10);
        if (! ($code != 0 && $r[CONNECTEUR_API_COLONNE_DATE_START] <= $totay && $totay <= $r[CONNECTEUR_API_COLONNE_DATE_STOP])) {
            return array('code_erreur' => 1); // erreur de connexion
        }
        if (isset($r['Code_utilisateur'])) {
            global $utilisateur_courant;
            $utilisateur_courant = $db -> utilisateur() -> mf_get_2($r['Code_utilisateur']);
        }
    }
    else
    {
        if (API_REST_ACCESS_PUT_A_PARAMETRE_UTILISATEUR == 'none') {
            return array('code_erreur' => 1); // erreur de connexion
        }
        elseif (API_REST_ACCESS_PUT_A_PARAMETRE_UTILISATEUR == 'user') {
            $auth = isset($_GET['auth']) ? $_GET['auth'] : 'api';
            if ($auth == 'api') {
                $mf_connexion = new Mf_Connexion(true);
                $mf_token = isset($options['mf_token']) ? $options['mf_token'] : '';
                if (! $mf_connexion->est_connecte($mf_token)) {
                    return array('code_erreur' => 1); // erreur de connexion
                }
                if (! isset($options['code_utilisateur']) && ! isset($data['Code_utilisateur'])) {
                    $options['code_utilisateur'] = get_utilisateur_courant('Code_utilisateur');
                }
            } elseif ($auth == 'main') {
                $mf_connexion = new Mf_Connexion();
                if (isset($_SESSION[PREFIXE_SESSION]['token'])) {
                    if (! $mf_connexion->est_connecte($_SESSION[PREFIXE_SESSION]['token'])) {
                        unset($_SESSION[PREFIXE_SESSION]['token']);
                    }
                }
                if (! isset($_SESSION[PREFIXE_SESSION]['token'])) {
                    return array('code_erreur' => 1); // erreur de connexion
                }
            }
        }
        elseif ( API_REST_ACCESS_PUT_A_PARAMETRE_UTILISATEUR!='all' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
    }

    session_write_close();

    $table_a_parametre_utilisateur = new a_parametre_utilisateur();
    $codes = explode('-', $id);
    $data['Code_utilisateur']=$codes[0];
    $data['Code_parametre']=$codes[1];
    return $table_a_parametre_utilisateur->mf_modifier_2([$data]);
}

function delete($id, $options)
{
    if ( isset($options['mf_connector_token']) && $options['mf_connector_token']!='' )
    {
        $db = new DB();
        $code = $db -> mf_table(CONNECTEUR_API_TABLE) -> mf_search__colonne(CONNECTEUR_API_COLONNE_TOKEN, $options['mf_connector_token']);
        $r = $db -> mf_table(CONNECTEUR_API_TABLE) -> mf_get($code);
        $totay = substr(get_now(), 0, 10);
        if (! ($code != 0 && $r[CONNECTEUR_API_COLONNE_DATE_START] <= $totay && $totay <= $r[CONNECTEUR_API_COLONNE_DATE_STOP])) {
            return array('code_erreur' => 1); // erreur de connexion
        }
        if (isset($r['Code_utilisateur'])) {
            global $utilisateur_courant;
            $utilisateur_courant = $db -> utilisateur() -> mf_get_2($r['Code_utilisateur']);
        }
    }
    else
    {
        if (API_REST_ACCESS_DELETE_A_PARAMETRE_UTILISATEUR == 'none') {
            return array('code_erreur' => 1); // erreur de connexion
        }
        elseif (API_REST_ACCESS_DELETE_A_PARAMETRE_UTILISATEUR == 'user') {
            $auth = isset($_GET['auth']) ? $_GET['auth'] : 'api';
            if ($auth == 'api') {
                $mf_connexion = new Mf_Connexion(true);
                $mf_token = isset($options['mf_token']) ? $options['mf_token'] : '';
                if (! $mf_connexion->est_connecte($mf_token)) {
                    return array('code_erreur' => 1); // erreur de connexion
                }
                if (! isset($options['code_utilisateur'])) {
                    $options['code_utilisateur'] = get_utilisateur_courant('Code_utilisateur');
                }
            } elseif ($auth == 'main') {
                $mf_connexion = new Mf_Connexion();
                if (isset($_SESSION[PREFIXE_SESSION]['token'])) {
                    if (! $mf_connexion->est_connecte($_SESSION[PREFIXE_SESSION]['token'])) {
                        unset($_SESSION[PREFIXE_SESSION]['token']);
                    }
                }
                if (! isset($_SESSION[PREFIXE_SESSION]['token'])) {
                    return array('code_erreur' => 1); // erreur de connexion
                }
            }
        }
        elseif ( API_REST_ACCESS_DELETE_A_PARAMETRE_UTILISATEUR!='all' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
    }

    session_write_close();

    if ( $id!='' )
    {
        $table_a_parametre_utilisateur = new a_parametre_utilisateur();
        $codes = explode('-', $id);
        return $table_a_parametre_utilisateur->mf_supprimer((isset($codes[0]) && round($codes[0])!=0 ? $codes[0] : -1), (isset($codes[1]) && round($codes[1])!=0 ? $codes[1] : -1));
    }
    else
    {
        $table_a_parametre_utilisateur = new a_parametre_utilisateur();
        $Code_utilisateur = ( isset($options['code_utilisateur']) ? $options['code_utilisateur'] : 0 );
        $Code_parametre = ( isset($options['code_parametre']) ? $options['code_parametre'] : 0 );
        return $table_a_parametre_utilisateur->mf_supprimer($Code_utilisateur, $Code_parametre, array( 'autocompletion' => false ));
    }
}

function options($id, $options)
{
    if ( isset($options['mf_connector_token']) && $options['mf_connector_token']!='' )
    {
        $db = new DB();
        $code = $db -> mf_table(CONNECTEUR_API_TABLE) -> mf_search__colonne(CONNECTEUR_API_COLONNE_TOKEN, $options['mf_connector_token']);
        $r = $db -> mf_table(CONNECTEUR_API_TABLE) -> mf_get($code);
        $totay = substr(get_now(), 0, 10);
        if (! ($code != 0 && $r[CONNECTEUR_API_COLONNE_DATE_START] <= $totay && $totay <= $r[CONNECTEUR_API_COLONNE_DATE_STOP])) {
            return array('code_erreur' => 1); // erreur de connexion
        }
        if (isset($r['Code_utilisateur'])) {
            global $utilisateur_courant;
            $utilisateur_courant = $db -> utilisateur() -> mf_get_2($r['Code_utilisateur']);
        }
    }
    else
    {
        if (API_REST_ACCESS_OPTIONS_A_PARAMETRE_UTILISATEUR == 'none') {
            return array('code_erreur' => 1); // erreur de connexion
        }
        elseif (API_REST_ACCESS_OPTIONS_A_PARAMETRE_UTILISATEUR == 'user') {
            $auth = isset($_GET['auth']) ? $_GET['auth'] : 'api';
            if ($auth == 'api') {
                $mf_connexion = new Mf_Connexion(true);
                $mf_token = isset($options['mf_token']) ? $options['mf_token'] : '';
                if (! $mf_connexion->est_connecte($mf_token)) {
                    return array('code_erreur' => 1); // erreur de connexion
                }
                if (! isset($options['code_utilisateur'])) {
                    $options['code_utilisateur'] = get_utilisateur_courant('Code_utilisateur');
                }
            } elseif ($auth == 'main') {
                $mf_connexion = new Mf_Connexion();
                if (isset($_SESSION[PREFIXE_SESSION]['token'])) {
                    if (! $mf_connexion->est_connecte($_SESSION[PREFIXE_SESSION]['token'])) {
                        unset($_SESSION[PREFIXE_SESSION]['token']);
                    }
                }
                if (! isset($_SESSION[PREFIXE_SESSION]['token'])) {
                    return array('code_erreur' => 1); // erreur de connexion
                }
            }
        }
        elseif ( API_REST_ACCESS_OPTIONS_A_PARAMETRE_UTILISATEUR!='all' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
    }

    session_write_close();

    $table_a_parametre_utilisateur = new a_parametre_utilisateur();
    if ($id!='')
    {
        $table_id = explode('-', $id);
        $code_utilisateur = isset($table_id[0]) ? $table_id[0] : -1;
        $code_parametre = isset($table_id[1]) ? $table_id[1] : -1;
    }
    else
    {
        $code_utilisateur = isset($options['code_utilisateur']) ? $options['code_utilisateur'] : 0;
        $code_parametre = isset($options['code_parametre']) ? $options['code_parametre'] : 0;
    }
    Hook_a_parametre_utilisateur::hook_actualiser_les_droits_ajouter($code_utilisateur, $code_parametre);
    Hook_a_parametre_utilisateur::hook_actualiser_les_droits_modifier($code_utilisateur, $code_parametre);
    Hook_a_parametre_utilisateur::hook_actualiser_les_droits_supprimer($code_utilisateur, $code_parametre);
    $authorization = array();
    global $mf_droits_defaut;
    $authorization['POST'] = $mf_droits_defaut['a_parametre_utilisateur__AJOUTER'];
    $authorization['PUT'] = $mf_droits_defaut['a_parametre_utilisateur__MODIFIER'];
    $authorization['PUT:a_parametre_utilisateur_Valeur'] = $mf_droits_defaut['api_modifier__a_parametre_utilisateur_Valeur'];
    $authorization['PUT:a_parametre_utilisateur_Actif'] = $mf_droits_defaut['api_modifier__a_parametre_utilisateur_Actif'];
    $authorization['DELETE'] = $mf_droits_defaut['a_parametre_utilisateur__SUPPRIMER'];
    return array('code_erreur' => 0, 'authorization' => $authorization);
}
