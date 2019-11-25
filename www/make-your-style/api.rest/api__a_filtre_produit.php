<?php
include __DIR__ . '/../../../systeme/make-your-style/acces_api_rest/a_filtre_produit.php';

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
        if (API_REST_ACCESS_GET_A_FILTRE_PRODUIT == 'none') {
            return array('code_erreur' => 1); // erreur de connexion
        }
        elseif (API_REST_ACCESS_GET_A_FILTRE_PRODUIT == 'user') {
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
        elseif ( API_REST_ACCESS_GET_A_FILTRE_PRODUIT!='all' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
    }

    session_write_close();

    $table_a_filtre_produit = new a_filtre_produit();
    if ($id != '') {
        $table_id = explode('-', $id);
        $code_filtre = isset($table_id[0]) ? $table_id[0] : -1;
        $code_article = isset($table_id[1]) ? $table_id[1] : -1;
    } else {
        $code_filtre = isset($options['code_filtre']) ? $options['code_filtre'] : 0;
        $code_article = isset($options['code_article']) ? $options['code_article'] : 0;
    }
    $l = $table_a_filtre_produit->mf_lister($code_filtre, $code_article, array( 'autocompletion' => true ));
    foreach ($l as $k => &$v) {
        $v = array_merge(['Code_a_filtre_produit'=>$k], $v);
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
        if (API_REST_ACCESS_POST_A_FILTRE_PRODUIT == 'none') {
            return array('code_erreur' => 1); // erreur de connexion
        }
        elseif (API_REST_ACCESS_POST_A_FILTRE_PRODUIT == 'user') {
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
        elseif ( API_REST_ACCESS_POST_A_FILTRE_PRODUIT!='all' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
    }

    session_write_close();

    $table_a_filtre_produit = new a_filtre_produit();
    if (is_array(current($data))) {
        $retour = $table_a_filtre_produit -> mf_supprimer( ( isset($options['code_filtre']) ? $options['code_filtre'] : 0 ), ( isset($options['code_article']) ? $options['code_article'] : 0 ) );
        if ($retour['code_erreur'] == 0) {
            foreach ($data as $value) {
                if (isset($options['code_filtre'])) $value['Code_filtre'] = $options['code_filtre'];
                if (isset($options['code_article'])) $value['Code_article'] = $options['code_article'];
                $retour = $table_a_filtre_produit->mf_ajouter_2($value);
                if ($retour['code_erreur'] != 0) {
                    return $retour;
                }
            }
        }
    } else {
        if (isset($options['code_filtre'])) {
            $data['Code_filtre'] = $options['code_filtre'];
        }
        if (isset($options['code_article'])) {
            $data['Code_article'] = $options['code_article'];
        }
        $a_filtre_produit = $table_a_filtre_produit->mf_get( $data['Code_filtre'], $data['Code_article'] );
        if (isset($a_filtre_produit['Code_filtre'])) {
            $retour['code_erreur'] = 0;
            $table_a_filtre_produit->mf_modifier_2([$data]);
            $retour['callback'] = Hook_a_filtre_produit::callback_post( $data['Code_filtre'], $data['Code_article'] );
        } else {
            $retour = $table_a_filtre_produit->mf_ajouter_2($data);
        }
        if ($retour['code_erreur'] == 0) {
            $retour['id'] = $data['Code_filtre'].'-'.$data['Code_article'];
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
        if (API_REST_ACCESS_PUT_A_FILTRE_PRODUIT == 'none') {
            return array('code_erreur' => 1); // erreur de connexion
        }
        elseif (API_REST_ACCESS_PUT_A_FILTRE_PRODUIT == 'user') {
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
        elseif ( API_REST_ACCESS_PUT_A_FILTRE_PRODUIT!='all' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
    }

    session_write_close();

    $table_a_filtre_produit = new a_filtre_produit();
    $codes = explode('-', $id);
    $data['Code_filtre']=$codes[0];
    $data['Code_article']=$codes[1];
    return $table_a_filtre_produit->mf_modifier_2([$data]);
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
        if (API_REST_ACCESS_DELETE_A_FILTRE_PRODUIT == 'none') {
            return array('code_erreur' => 1); // erreur de connexion
        }
        elseif (API_REST_ACCESS_DELETE_A_FILTRE_PRODUIT == 'user') {
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
        elseif ( API_REST_ACCESS_DELETE_A_FILTRE_PRODUIT!='all' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
    }

    session_write_close();

    if ( $id!='' )
    {
        $table_a_filtre_produit = new a_filtre_produit();
        $codes = explode('-', $id);
        return $table_a_filtre_produit->mf_supprimer((isset($codes[0]) && round($codes[0])!=0 ? $codes[0] : -1), (isset($codes[1]) && round($codes[1])!=0 ? $codes[1] : -1));
    }
    else
    {
        $table_a_filtre_produit = new a_filtre_produit();
        $Code_filtre = ( isset($options['code_filtre']) ? $options['code_filtre'] : 0 );
        $Code_article = ( isset($options['code_article']) ? $options['code_article'] : 0 );
        return $table_a_filtre_produit->mf_supprimer($Code_filtre, $Code_article, array( 'autocompletion' => false ));
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
        if (API_REST_ACCESS_OPTIONS_A_FILTRE_PRODUIT == 'none') {
            return array('code_erreur' => 1); // erreur de connexion
        }
        elseif (API_REST_ACCESS_OPTIONS_A_FILTRE_PRODUIT == 'user') {
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
        elseif ( API_REST_ACCESS_OPTIONS_A_FILTRE_PRODUIT!='all' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
    }

    session_write_close();

    $table_a_filtre_produit = new a_filtre_produit();
    if ($id!='')
    {
        $table_id = explode('-', $id);
        $code_filtre = isset($table_id[0]) ? $table_id[0] : -1;
        $code_article = isset($table_id[1]) ? $table_id[1] : -1;
    }
    else
    {
        $code_filtre = isset($options['code_filtre']) ? $options['code_filtre'] : 0;
        $code_article = isset($options['code_article']) ? $options['code_article'] : 0;
    }
    Hook_a_filtre_produit::hook_actualiser_les_droits_ajouter($code_filtre, $code_article);
    Hook_a_filtre_produit::hook_actualiser_les_droits_modifier($code_filtre, $code_article);
    Hook_a_filtre_produit::hook_actualiser_les_droits_supprimer($code_filtre, $code_article);
    $authorization = array();
    global $mf_droits_defaut;
    $authorization['POST'] = $mf_droits_defaut['a_filtre_produit__AJOUTER'];
    $authorization['PUT'] = $mf_droits_defaut['a_filtre_produit__MODIFIER'];
    $authorization['PUT:a_filtre_produit_Actif'] = $mf_droits_defaut['api_modifier__a_filtre_produit_Actif'];
    $authorization['DELETE'] = $mf_droits_defaut['a_filtre_produit__SUPPRIMER'];
    return array('code_erreur' => 0, 'authorization' => $authorization);
}
