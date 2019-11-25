<?php
include __DIR__ . '/../../../systeme/make-your-style/acces_api_rest/parametre.php';

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
        if (API_REST_ACCESS_GET_PARAMETRE == 'none') {
            return array('code_erreur' => 1); // erreur de connexion
        }
        elseif (API_REST_ACCESS_GET_PARAMETRE == 'user') {
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
        elseif ( API_REST_ACCESS_GET_PARAMETRE!='all' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
    }

    session_write_close();

    $id = round($id);
    $table_parametre = new parametre();
    if ($id == 0) {
        return array_merge( array_values($table_parametre->mf_lister(array('autocompletion' => true))), ['code_erreur' => 0] );
    } else {
        $r = $table_parametre->mf_get($id, array( 'autocompletion' => true ));
        if ( $r===false ) { return array(); } else { return array_merge( array($r), ['code_erreur' => 0] ); }
    }
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
        if (API_REST_ACCESS_POST_PARAMETRE == 'none') {
            return array('code_erreur' => 1); // erreur de connexion
        }
        elseif (API_REST_ACCESS_POST_PARAMETRE == 'user') {
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
        elseif ( API_REST_ACCESS_POST_PARAMETRE!='all' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
    }

    session_write_close();

    $table_parametre = new parametre();
    if (is_array(current($data))) {
        $liste_Code_parametre = $table_parametre->mf_liste_Code_parametre(  );
        $retour = $table_parametre -> mf_supprimer_2($liste_Code_parametre);
        if ($retour['code_erreur'] == 0) {
            foreach ($data as $value) {
                $retour = $table_parametre->mf_ajouter_2($value);
                unset($retour['Code_parametre']);
                if ($retour['code_erreur'] != 0) {
                    return $retour;
                }
            }
        }
    } else {
        if ($retour['Code_parametre'] = $table_parametre->mf_search($data)) {
            $retour['code_erreur'] = 0;
            $table_parametre->mf_modifier_2([$retour['Code_parametre']=>$data]);
            $retour['callback'] = Hook_parametre::callback_post($retour['Code_parametre']);
        } else {
            $retour = $table_parametre->mf_ajouter_2($data);
        }
        $retour['id'] = ( $retour['Code_parametre']!=0 ? $retour['Code_parametre'] : '' );
        unset($retour['Code_parametre']);
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
        if (API_REST_ACCESS_PUT_PARAMETRE == 'none') {
            return array('code_erreur' => 1); // erreur de connexion
        }
        elseif (API_REST_ACCESS_PUT_PARAMETRE == 'user') {
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
        elseif ( API_REST_ACCESS_PUT_PARAMETRE!='all' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
    }

    session_write_close();

    $table_parametre = new parametre();
    return $table_parametre->mf_modifier_2([$id=>$data]);
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
        if (API_REST_ACCESS_DELETE_PARAMETRE == 'none') {
            return array('code_erreur' => 1); // erreur de connexion
        }
        elseif (API_REST_ACCESS_DELETE_PARAMETRE == 'user') {
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
        elseif ( API_REST_ACCESS_DELETE_PARAMETRE!='all' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
    }

    session_write_close();

    if ( $id!='' )
    {
        $table_parametre = new parametre();
        return $table_parametre->mf_supprimer($id);
    }
    else
    {
        $table_parametre = new parametre();
        $liste_parametre = $table_parametre->mf_lister();
        return $table_parametre->mf_supprimer_2(lister_cles($liste_parametre));
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
        if (API_REST_ACCESS_OPTIONS_PARAMETRE == 'none') {
            return array('code_erreur' => 1); // erreur de connexion
        }
        elseif (API_REST_ACCESS_OPTIONS_PARAMETRE == 'user') {
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
        elseif ( API_REST_ACCESS_OPTIONS_PARAMETRE!='all' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
    }

    session_write_close();

    $id = round($id);
    $table_parametre = new parametre();
    Hook_parametre::hook_actualiser_les_droits_ajouter();
    Hook_parametre::hook_actualiser_les_droits_modifier($id);
    Hook_parametre::hook_actualiser_les_droits_supprimer($id);
    $authorization = array();
    global $mf_droits_defaut;
    $authorization['POST'] = $mf_droits_defaut['parametre__AJOUTER'];
    $authorization['PUT'] = $mf_droits_defaut['parametre__MODIFIER'];
    $authorization['PUT:parametre_Libelle'] = $mf_droits_defaut['api_modifier__parametre_Libelle'];
    $authorization['DELETE'] = $mf_droits_defaut['parametre__SUPPRIMER'];
    return array('code_erreur' => 0, 'authorization' => $authorization);
}
