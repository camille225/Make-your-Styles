<?php
include __DIR__ . '/../../../systeme/make-your-style/acces_api_rest/article.php';

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
        if (API_REST_ACCESS_GET_ARTICLE == 'none') {
            return array('code_erreur' => 1); // erreur de connexion
        }
        elseif (API_REST_ACCESS_GET_ARTICLE == 'user') {
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
        elseif ( API_REST_ACCESS_GET_ARTICLE!='all' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
    }

    session_write_close();

    $id = round($id);
    $table_article = new article();
    if ($id == 0) {
        $code_type_produit = isset($options['code_type_produit']) ? $options['code_type_produit'] : 0;
        return array_merge( array_values($table_article->mf_lister($code_type_produit, array('autocompletion' => true))), ['code_erreur' => 0] );
    } else {
        $r = $table_article->mf_get($id, array( 'autocompletion' => true ));
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
        if (API_REST_ACCESS_POST_ARTICLE == 'none') {
            return array('code_erreur' => 1); // erreur de connexion
        }
        elseif (API_REST_ACCESS_POST_ARTICLE == 'user') {
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
        elseif ( API_REST_ACCESS_POST_ARTICLE!='all' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
    }

    session_write_close();

    $table_article = new article();
    if (is_array(current($data))) {
        $liste_Code_article = $table_article->mf_liste_Code_article( ( isset($options['code_type_produit']) ? $options['code_type_produit'] : 0 ) );
        $retour = $table_article -> mf_supprimer_2($liste_Code_article);
        if ($retour['code_erreur'] == 0) {
            foreach ($data as $value) {
                if (isset($options['code_type_produit'])) $value['Code_type_produit'] = $options['code_type_produit'];
                if (isset($value['article_Photo_Fichier'])) {
                    $fichier = new Fichier();
                    $value['article_Photo_Fichier'] = $fichier->set( base64_decode( $value['article_Photo_Fichier'] ) );
                }
                $retour = $table_article->mf_ajouter_2($value);
                unset($retour['Code_article']);
                if ($retour['code_erreur'] != 0) {
                    return $retour;
                }
            }
        }
    } else {
        if (isset($options['code_type_produit'])) {
            $data['Code_type_produit'] = $options['code_type_produit'];
        }
        if (isset($data['article_Photo_Fichier'])) {
            $fichier = new Fichier();
            $data['article_Photo_Fichier'] = $fichier->set( base64_decode( $data['article_Photo_Fichier'] ) );
        }
        if ($retour['Code_article'] = $table_article->mf_search($data)) {
            $retour['code_erreur'] = 0;
            $table_article->mf_modifier_2([$retour['Code_article']=>$data]);
            $retour['callback'] = Hook_article::callback_post($retour['Code_article']);
        } else {
            $retour = $table_article->mf_ajouter_2($data);
        }
        $retour['id'] = ( $retour['Code_article']!=0 ? $retour['Code_article'] : '' );
        unset($retour['Code_article']);
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
        if (API_REST_ACCESS_PUT_ARTICLE == 'none') {
            return array('code_erreur' => 1); // erreur de connexion
        }
        elseif (API_REST_ACCESS_PUT_ARTICLE == 'user') {
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
        elseif ( API_REST_ACCESS_PUT_ARTICLE!='all' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
    }

    session_write_close();

    $table_article = new article();
    return $table_article->mf_modifier_2([$id=>$data]);
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
        if (API_REST_ACCESS_DELETE_ARTICLE == 'none') {
            return array('code_erreur' => 1); // erreur de connexion
        }
        elseif (API_REST_ACCESS_DELETE_ARTICLE == 'user') {
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
        elseif ( API_REST_ACCESS_DELETE_ARTICLE!='all' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
    }

    session_write_close();

    if ( $id!='' )
    {
        $table_article = new article();
        return $table_article->mf_supprimer($id);
    }
    else
    {
        $table_article = new article();
        $Code_type_produit = ( isset($options['code_type_produit']) ? $options['code_type_produit'] : 0 );
        $liste_article = $table_article->mf_lister($Code_type_produit, array( 'autocompletion' => false ));
        return $table_article->mf_supprimer_2(lister_cles($liste_article));
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
        if (API_REST_ACCESS_OPTIONS_ARTICLE == 'none') {
            return array('code_erreur' => 1); // erreur de connexion
        }
        elseif (API_REST_ACCESS_OPTIONS_ARTICLE == 'user') {
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
        elseif ( API_REST_ACCESS_OPTIONS_ARTICLE!='all' )
        {
            return array('code_erreur' => 1); // erreur de connexion
        }
    }

    session_write_close();

    $id = round($id);
    $table_article = new article();
    $code_type_produit = isset($options['code_type_produit']) ? $options['code_type_produit'] : 0;
    Hook_article::hook_actualiser_les_droits_ajouter($code_type_produit);
    Hook_article::hook_actualiser_les_droits_modifier($id);
    Hook_article::hook_actualiser_les_droits_supprimer($id);
    $authorization = array();
    global $mf_droits_defaut;
    $authorization['POST'] = $mf_droits_defaut['article__AJOUTER'];
    $authorization['PUT'] = $mf_droits_defaut['article__MODIFIER'];
    $authorization['PUT:article_Libelle'] = $mf_droits_defaut['api_modifier__article_Libelle'];
    $authorization['PUT:article_Photo_Fichier'] = $mf_droits_defaut['api_modifier__article_Photo_Fichier'];
    $authorization['PUT:article_Prix'] = $mf_droits_defaut['api_modifier__article_Prix'];
    $authorization['PUT:article_Actif'] = $mf_droits_defaut['api_modifier__article_Actif'];
    $authorization['PUT:Code_type_produit'] = $mf_droits_defaut['api_modifier_ref__article__Code_type_produit'];
    $authorization['DELETE'] = $mf_droits_defaut['article__SUPPRIMER'];
    return array('code_erreur' => 0, 'authorization' => $authorization);
}
