<?php declare(strict_types=1);
include __DIR__ . '/../../../systeme/make-your-style/acces_api_rest/a_commande_article.php';

function get($id, $options)
{
    // Contrôle d'accès
    $r = mf_api_droits($options, API_REST_ACCESS_GET_A_COMMANDE_ARTICLE);
    if ($r['code_erreur'] != 0) return $r;

    $db = new DB();
    if ($id != '') {
        $table_id = explode('-', $id);
        $code_commande = isset($table_id[0]) ? (int) $table_id[0] : -1;
        $code_article = isset($table_id[1]) ? (int) $table_id[1] : -1;
    } else {
        $code_commande = isset($options['code_commande']) ? $options['code_commande'] : 0;
        $code_article = isset($options['code_article']) ? $options['code_article'] : 0;
    }
    $l = $db->a_commande_article()->mf_lister($code_commande, $code_article, ['autocompletion' => true, 'limit' => [0, NB_RESULT_MAX_API]]);
    foreach ($l as $k => &$v) {
        $v = array_merge(['Code_a_commande_article'=>$k], $v);
    }
    unset($v);
    $l = array_values($l);
    if ($id != '' && count($l) == 0) {
        $l['http_response_code'] = 404;
    }
    $l['code_erreur'] = (count($l) == NB_RESULT_MAX_API ? 8 : 0);
    return $l;
}

function post($data, $options)
{
    // Contrôle d'accès
    $r = mf_api_droits($options, API_REST_ACCESS_POST_A_COMMANDE_ARTICLE);
    if ($r['code_erreur'] != 0) return $r;

    $db = new DB();
    if (is_array(current($data))) {
        $retour = $db->a_commande_article()->mf_supprimer( ( isset($options['code_commande']) ? $options['code_commande'] : 0 ), ( isset($options['code_article']) ? $options['code_article'] : 0 ) );
        if ($retour['code_erreur'] == 0) {
            foreach ($data as $value) {
                if (isset($options['code_commande'])) $value['Code_commande'] = $options['code_commande'];
                if (isset($options['code_article'])) $value['Code_article'] = $options['code_article'];
                $retour = $db->a_commande_article()->mf_ajouter_2($value);
                if ($retour['code_erreur'] != 0) {
                    return $retour;
                }
            }
        }
    } else {
        if (isset($options['code_commande'])) {
            $data['Code_commande'] = $options['code_commande'];
        } elseif(! isset($data['Code_commande'])) {
            $data['Code_commande'] = 0;
        }
        if (isset($options['code_article'])) {
            $data['Code_article'] = $options['code_article'];
        } elseif(! isset($data['Code_article'])) {
            $data['Code_article'] = 0;
        }
        $a_commande_article = $db->a_commande_article()->mf_get( $data['Code_commande'], $data['Code_article'] );
        if (isset($a_commande_article['Code_commande'])) {
            $retour['code_erreur'] = 0;
            $db->a_commande_article()->mf_modifier_2([$data]);
            $retour['callback'] = Hook_a_commande_article::callback_post( $data['Code_commande'], $data['Code_article'] );
        } else {
            $retour = $db->a_commande_article()->mf_ajouter_2($data);
        }
        if ($retour['code_erreur'] == 0) {
            if (isset($retour['Code_commande'])) {
                $retour['id'] = $retour['Code_commande'] . '-' . $retour['Code_article'];
            } else {
                $retour['id'] = $data['Code_commande'] . '-' . $data['Code_article'];
            }
        } else {
            $retour['id'] = '';
        }
        unset($retour['Code_commande']);
        unset($retour['Code_article']);
    }
    return $retour;
}

function put($id, $data, $options)
{
    // Contrôle d'accès
    $r = mf_api_droits($options, API_REST_ACCESS_PUT_A_COMMANDE_ARTICLE);
    if ($r['code_erreur'] != 0) return $r;

    $db = new DB();
    $codes = explode('-', $id);
    $data['Code_commande']=$codes[0];
    $data['Code_article']=$codes[1];
    return $db->a_commande_article()->mf_modifier_2([$data]);
}

function delete($id, $options)
{
    // Contrôle d'accès
    $r = mf_api_droits($options, API_REST_ACCESS_DELETE_A_COMMANDE_ARTICLE);
    if ($r['code_erreur'] != 0) return $r;

    if ($id != '') {
        $db = new DB();
        $codes = explode('-', $id);
        return $db->a_commande_article()->mf_supprimer((isset($codes[0]) && intval($codes[0])!=0 ? intval($codes[0]) : -1), (isset($codes[1]) && intval($codes[1])!=0 ? intval($codes[1]) : -1));
    } else {
        $db = new DB();
        $Code_commande = ( isset($options['code_commande']) ? $options['code_commande'] : 0 );
        $Code_article = ( isset($options['code_article']) ? $options['code_article'] : 0 );
        return $db->a_commande_article()->mf_supprimer($Code_commande, $Code_article);
    }
}

function options($id, $options)
{
    // Contrôle d'accès
    $r = mf_api_droits($options, API_REST_ACCESS_OPTIONS_A_COMMANDE_ARTICLE);
    if ($r['code_erreur'] != 0) return $r;

    if ($id != '') {
        $table_id = explode('-', $id);
        $code_commande = isset($table_id[0]) ? (int) $table_id[0] : -1;
        $code_article = isset($table_id[1]) ? (int) $table_id[1] : -1;
    } else {
        $code_commande = isset($options['code_commande']) ? $options['code_commande'] : 0;
        $code_article = isset($options['code_article']) ? $options['code_article'] : 0;
    }
    Hook_a_commande_article::hook_actualiser_les_droits_ajouter($code_commande, $code_article);
    Hook_a_commande_article::hook_actualiser_les_droits_modifier($code_commande, $code_article);
    Hook_a_commande_article::hook_actualiser_les_droits_supprimer($code_commande, $code_article);
    $authorization = [];
    global $mf_droits_defaut;
    $authorization['POST'] = $mf_droits_defaut['a_commande_article__AJOUTER'];
    $authorization['PUT'] = $mf_droits_defaut['a_commande_article__MODIFIER'];
    $authorization['PUT:a_commande_article_Quantite'] = $mf_droits_defaut['api_modifier__a_commande_article_Quantite'];
    $authorization['PUT:a_commande_article_Prix_ligne'] = $mf_droits_defaut['api_modifier__a_commande_article_Prix_ligne'];
    $authorization['DELETE'] = $mf_droits_defaut['a_commande_article__SUPPRIMER'];
    return ['code_erreur' => 0, 'authorization' => $authorization];
}
