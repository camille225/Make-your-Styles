<?php
include __DIR__ . '/../../../systeme/make-your-style/acces_api_rest/type_produit.php';

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
        if (API_REST_ACCESS_GET_TYPE_PRODUIT == 'none') {
            return array('code_erreur' => 1); // erreur de connexion
        }
        elseif (API_REST_ACCESS_GET_TYPE_PRODUIT == 'user') {
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
        elseif ( API_REST_ACCESS_GET_TYPE_PRODUIT!='all' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
    }

    session_write_close();

    $id = round($id);
    $table_type_produit = new type_produit();
    if ($id == 0) {
        return array_merge( array_values($table_type_produit->mf_lister(array('autocompletion' => true))), ['code_erreur' => 0] );
    } else {
        $r = $table_type_produit->mf_get($id, array( 'autocompletion' => true ));
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
        if (API_REST_ACCESS_POST_TYPE_PRODUIT == 'none') {
            return array('code_erreur' => 1); // erreur de connexion
        }
        elseif (API_REST_ACCESS_POST_TYPE_PRODUIT == 'user') {
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
        elseif ( API_REST_ACCESS_POST_TYPE_PRODUIT!='all' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
    }

    session_write_close();

    $table_type_produit = new type_produit();
    if (is_array(current($data))) {
        $liste_Code_type_produit = $table_type_produit->mf_liste_Code_type_produit(  );
        $retour = $table_type_produit -> mf_supprimer_2($liste_Code_type_produit);
        if ($retour['code_erreur'] == 0) {
            foreach ($data as $value) {
                $retour = $table_type_produit->mf_ajouter_2($value);
                unset($retour['Code_type_produit']);
                if ($retour['code_erreur'] != 0) {
                    return $retour;
                }
            }
        }
    } else {
        if ($retour['Code_type_produit'] = $table_type_produit->mf_search($data)) {
            $retour['code_erreur'] = 0;
            $table_type_produit->mf_modifier_2([$retour['Code_type_produit']=>$data]);
            $retour['callback'] = Hook_type_produit::callback_post($retour['Code_type_produit']);
        } else {
            $retour = $table_type_produit->mf_ajouter_2($data);
        }
        $retour['id'] = ( $retour['Code_type_produit']!=0 ? $retour['Code_type_produit'] : '' );
        unset($retour['Code_type_produit']);
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
        if (API_REST_ACCESS_PUT_TYPE_PRODUIT == 'none') {
            return array('code_erreur' => 1); // erreur de connexion
        }
        elseif (API_REST_ACCESS_PUT_TYPE_PRODUIT == 'user') {
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
        elseif ( API_REST_ACCESS_PUT_TYPE_PRODUIT!='all' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
    }

    session_write_close();

    $table_type_produit = new type_produit();
    return $table_type_produit->mf_modifier_2([$id=>$data]);
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
        if (API_REST_ACCESS_DELETE_TYPE_PRODUIT == 'none') {
            return array('code_erreur' => 1); // erreur de connexion
        }
        elseif (API_REST_ACCESS_DELETE_TYPE_PRODUIT == 'user') {
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
        elseif ( API_REST_ACCESS_DELETE_TYPE_PRODUIT!='all' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
    }

    session_write_close();

    if ( $id!='' )
    {
        $table_type_produit = new type_produit();
        return $table_type_produit->mf_supprimer($id);
    }
    else
    {
        $table_type_produit = new type_produit();
        $liste_type_produit = $table_type_produit->mf_lister();
        return $table_type_produit->mf_supprimer_2(lister_cles($liste_type_produit));
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
        if (API_REST_ACCESS_OPTIONS_TYPE_PRODUIT == 'none') {
            return array('code_erreur' => 1); // erreur de connexion
        }
        elseif (API_REST_ACCESS_OPTIONS_TYPE_PRODUIT == 'user') {
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
        elseif ( API_REST_ACCESS_OPTIONS_TYPE_PRODUIT!='all' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
    }

    session_write_close();

    $id = round($id);
    $table_type_produit = new type_produit();
    Hook_type_produit::hook_actualiser_les_droits_ajouter();
    Hook_type_produit::hook_actualiser_les_droits_modifier($id);
    Hook_type_produit::hook_actualiser_les_droits_supprimer($id);
    $authorization = array();
    global $mf_droits_defaut;
    $authorization['POST'] = $mf_droits_defaut['type_produit__AJOUTER'];
    $authorization['PUT'] = $mf_droits_defaut['type_produit__MODIFIER'];
    $authorization['PUT:type_produit_Libelle'] = $mf_droits_defaut['api_modifier__type_produit_Libelle'];
    $authorization['DELETE'] = $mf_droits_defaut['type_produit__SUPPRIMER'];
    return array('code_erreur' => 0, 'authorization' => $authorization);
}
