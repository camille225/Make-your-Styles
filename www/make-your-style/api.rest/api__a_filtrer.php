<?php declare(strict_types=1);
include __DIR__ . '/../../../systeme/make-your-style/acces_api_rest/a_filtrer.php';

function get($id, $options)
{
    // Contrôle d'accès
    $r = mf_api_droits($options, API_REST_ACCESS_GET_A_FILTRER);
    if ($r['code_erreur'] != 0) return $r;

    $db = new DB();
    if ($id != '') {
        $table_id = explode('-', $id);
        $code_utilisateur = isset($table_id[0]) ? (int) $table_id[0] : -1;
        $code_vue_utilisateur = isset($table_id[1]) ? (int) $table_id[1] : -1;
    } else {
        $code_utilisateur = isset($options['code_utilisateur']) ? $options['code_utilisateur'] : 0;
        $code_vue_utilisateur = isset($options['code_vue_utilisateur']) ? $options['code_vue_utilisateur'] : 0;
    }
    $l = $db->a_filtrer()->mf_lister($code_utilisateur, $code_vue_utilisateur, ['autocompletion' => true, 'limit' => [0, NB_RESULT_MAX_API]]);
    foreach ($l as $k => &$v) {
        $v = array_merge(['Code_a_filtrer'=>$k], $v);
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
    $r = mf_api_droits($options, API_REST_ACCESS_POST_A_FILTRER);
    if ($r['code_erreur'] != 0) return $r;

    $db = new DB();
    if (is_array(current($data))) {
        $retour = $db->a_filtrer()->mf_supprimer( ( isset($options['code_utilisateur']) ? $options['code_utilisateur'] : 0 ), ( isset($options['code_vue_utilisateur']) ? $options['code_vue_utilisateur'] : 0 ) );
        if ($retour['code_erreur'] == 0) {
            foreach ($data as $value) {
                if (isset($options['code_utilisateur'])) $value['Code_utilisateur'] = $options['code_utilisateur'];
                if (isset($options['code_vue_utilisateur'])) $value['Code_vue_utilisateur'] = $options['code_vue_utilisateur'];
                $retour = $db->a_filtrer()->mf_ajouter_2($value);
                if ($retour['code_erreur'] != 0) {
                    return $retour;
                }
            }
        }
    } else {
        if (isset($options['code_utilisateur'])) {
            $data['Code_utilisateur'] = $options['code_utilisateur'];
        } elseif(! isset($data['Code_utilisateur'])) {
            $data['Code_utilisateur'] = 0;
        }
        if (isset($options['code_vue_utilisateur'])) {
            $data['Code_vue_utilisateur'] = $options['code_vue_utilisateur'];
        } elseif(! isset($data['Code_vue_utilisateur'])) {
            $data['Code_vue_utilisateur'] = 0;
        }
        $a_filtrer = $db->a_filtrer()->mf_get( $data['Code_utilisateur'], $data['Code_vue_utilisateur'] );
        if (isset($a_filtrer['Code_utilisateur'])) {
            $retour['code_erreur'] = 0;
            $retour['callback'] = Hook_a_filtrer::callback_post( $data['Code_utilisateur'], $data['Code_vue_utilisateur'] );
        } else {
            $retour = $db->a_filtrer()->mf_ajouter_2($data);
        }
        if ($retour['code_erreur'] == 0) {
            if (isset($retour['Code_utilisateur'])) {
                $retour['id'] = $retour['Code_utilisateur'] . '-' . $retour['Code_vue_utilisateur'];
            } else {
                $retour['id'] = $data['Code_utilisateur'] . '-' . $data['Code_vue_utilisateur'];
            }
        } else {
            $retour['id'] = '';
        }
        unset($retour['Code_utilisateur']);
        unset($retour['Code_vue_utilisateur']);
    }
    return $retour;
}

function put($id, $data, $options)
{
    // Contrôle d'accès
    $r = mf_api_droits($options, API_REST_ACCESS_PUT_A_FILTRER);
    if ($r['code_erreur'] != 0) return $r;

    return ['code_erreur' => 0];
}

function delete($id, $options)
{
    // Contrôle d'accès
    $r = mf_api_droits($options, API_REST_ACCESS_DELETE_A_FILTRER);
    if ($r['code_erreur'] != 0) return $r;

    if ($id != '') {
        $db = new DB();
        $codes = explode('-', $id);
        return $db->a_filtrer()->mf_supprimer((isset($codes[0]) && intval($codes[0])!=0 ? intval($codes[0]) : -1), (isset($codes[1]) && intval($codes[1])!=0 ? intval($codes[1]) : -1));
    } else {
        $db = new DB();
        $Code_utilisateur = ( isset($options['code_utilisateur']) ? $options['code_utilisateur'] : 0 );
        $Code_vue_utilisateur = ( isset($options['code_vue_utilisateur']) ? $options['code_vue_utilisateur'] : 0 );
        return $db->a_filtrer()->mf_supprimer($Code_utilisateur, $Code_vue_utilisateur);
    }
}

function options($id, $options)
{
    // Contrôle d'accès
    $r = mf_api_droits($options, API_REST_ACCESS_OPTIONS_A_FILTRER);
    if ($r['code_erreur'] != 0) return $r;

    if ($id != '') {
        $table_id = explode('-', $id);
        $code_utilisateur = isset($table_id[0]) ? (int) $table_id[0] : -1;
        $code_vue_utilisateur = isset($table_id[1]) ? (int) $table_id[1] : -1;
    } else {
        $code_utilisateur = isset($options['code_utilisateur']) ? $options['code_utilisateur'] : 0;
        $code_vue_utilisateur = isset($options['code_vue_utilisateur']) ? $options['code_vue_utilisateur'] : 0;
    }
    Hook_a_filtrer::hook_actualiser_les_droits_ajouter($code_utilisateur, $code_vue_utilisateur);
    Hook_a_filtrer::hook_actualiser_les_droits_supprimer($code_utilisateur, $code_vue_utilisateur);
    $authorization = [];
    global $mf_droits_defaut;
    $authorization['POST'] = $mf_droits_defaut['a_filtrer__AJOUTER'];
    $authorization['PUT'] = $mf_droits_defaut['a_filtrer__MODIFIER'];
    $authorization['DELETE'] = $mf_droits_defaut['a_filtrer__SUPPRIMER'];
    return ['code_erreur' => 0, 'authorization' => $authorization];
}
