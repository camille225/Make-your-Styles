<?php declare(strict_types=1);
include __DIR__ . '/../../../systeme/make-your-style/acces_api_rest/a_parametre_utilisateur.php';

function get($id, $options)
{
    // Contrôle d'accès
    $r = mf_api_droits($options, API_REST_ACCESS_GET_A_PARAMETRE_UTILISATEUR);
    if ($r['code_erreur'] != 0) return $r;

    $db = new DB();
    if ($id != '') {
        $table_id = explode('-', $id);
        $code_utilisateur = isset($table_id[0]) ? (int) $table_id[0] : -1;
        $code_parametre = isset($table_id[1]) ? (int) $table_id[1] : -1;
    } else {
        $code_utilisateur = isset($options['code_utilisateur']) ? $options['code_utilisateur'] : 0;
        $code_parametre = isset($options['code_parametre']) ? $options['code_parametre'] : 0;
    }
    $l = $db->a_parametre_utilisateur()->mf_lister($code_utilisateur, $code_parametre, ['autocompletion' => true, 'limit' => [0, NB_RESULT_MAX_API]]);
    foreach ($l as $k => &$v) {
        $v = array_merge(['Code_a_parametre_utilisateur'=>$k], $v);
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
    $r = mf_api_droits($options, API_REST_ACCESS_POST_A_PARAMETRE_UTILISATEUR);
    if ($r['code_erreur'] != 0) return $r;

    $db = new DB();
    if (is_array(current($data))) {
        $retour = $db->a_parametre_utilisateur()->mf_supprimer( ( isset($options['code_utilisateur']) ? $options['code_utilisateur'] : 0 ), ( isset($options['code_parametre']) ? $options['code_parametre'] : 0 ) );
        if ($retour['code_erreur'] == 0) {
            foreach ($data as $value) {
                if (isset($options['code_utilisateur'])) $value['Code_utilisateur'] = $options['code_utilisateur'];
                if (isset($options['code_parametre'])) $value['Code_parametre'] = $options['code_parametre'];
                $retour = $db->a_parametre_utilisateur()->mf_ajouter_2($value);
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
        if (isset($options['code_parametre'])) {
            $data['Code_parametre'] = $options['code_parametre'];
        } elseif(! isset($data['Code_parametre'])) {
            $data['Code_parametre'] = 0;
        }
        $a_parametre_utilisateur = $db->a_parametre_utilisateur()->mf_get( $data['Code_utilisateur'], $data['Code_parametre'] );
        if (isset($a_parametre_utilisateur['Code_utilisateur'])) {
            $retour['code_erreur'] = 0;
            $db->a_parametre_utilisateur()->mf_modifier_2([$data]);
            $retour['callback'] = Hook_a_parametre_utilisateur::callback_post( $data['Code_utilisateur'], $data['Code_parametre'] );
        } else {
            $retour = $db->a_parametre_utilisateur()->mf_ajouter_2($data);
        }
        if ($retour['code_erreur'] == 0) {
            if (isset($retour['Code_utilisateur'])) {
                $retour['id'] = $retour['Code_utilisateur'] . '-' . $retour['Code_parametre'];
            } else {
                $retour['id'] = $data['Code_utilisateur'] . '-' . $data['Code_parametre'];
            }
        } else {
            $retour['id'] = '';
        }
        unset($retour['Code_utilisateur']);
        unset($retour['Code_parametre']);
    }
    return $retour;
}

function put($id, $data, $options)
{
    // Contrôle d'accès
    $r = mf_api_droits($options, API_REST_ACCESS_PUT_A_PARAMETRE_UTILISATEUR);
    if ($r['code_erreur'] != 0) return $r;

    $db = new DB();
    $codes = explode('-', $id);
    $data['Code_utilisateur']=$codes[0];
    $data['Code_parametre']=$codes[1];
    return $db->a_parametre_utilisateur()->mf_modifier_2([$data]);
}

function delete($id, $options)
{
    // Contrôle d'accès
    $r = mf_api_droits($options, API_REST_ACCESS_DELETE_A_PARAMETRE_UTILISATEUR);
    if ($r['code_erreur'] != 0) return $r;

    if ($id != '') {
        $db = new DB();
        $codes = explode('-', $id);
        return $db->a_parametre_utilisateur()->mf_supprimer((isset($codes[0]) && intval($codes[0])!=0 ? intval($codes[0]) : -1), (isset($codes[1]) && intval($codes[1])!=0 ? intval($codes[1]) : -1));
    } else {
        $db = new DB();
        $Code_utilisateur = ( isset($options['code_utilisateur']) ? $options['code_utilisateur'] : 0 );
        $Code_parametre = ( isset($options['code_parametre']) ? $options['code_parametre'] : 0 );
        return $db->a_parametre_utilisateur()->mf_supprimer($Code_utilisateur, $Code_parametre);
    }
}

function options($id, $options)
{
    // Contrôle d'accès
    $r = mf_api_droits($options, API_REST_ACCESS_OPTIONS_A_PARAMETRE_UTILISATEUR);
    if ($r['code_erreur'] != 0) return $r;

    if ($id != '') {
        $table_id = explode('-', $id);
        $code_utilisateur = isset($table_id[0]) ? (int) $table_id[0] : -1;
        $code_parametre = isset($table_id[1]) ? (int) $table_id[1] : -1;
    } else {
        $code_utilisateur = isset($options['code_utilisateur']) ? $options['code_utilisateur'] : 0;
        $code_parametre = isset($options['code_parametre']) ? $options['code_parametre'] : 0;
    }
    Hook_a_parametre_utilisateur::hook_actualiser_les_droits_ajouter($code_utilisateur, $code_parametre);
    Hook_a_parametre_utilisateur::hook_actualiser_les_droits_modifier($code_utilisateur, $code_parametre);
    Hook_a_parametre_utilisateur::hook_actualiser_les_droits_supprimer($code_utilisateur, $code_parametre);
    $authorization = [];
    global $mf_droits_defaut;
    $authorization['POST'] = $mf_droits_defaut['a_parametre_utilisateur__AJOUTER'];
    $authorization['PUT'] = $mf_droits_defaut['a_parametre_utilisateur__MODIFIER'];
    $authorization['PUT:a_parametre_utilisateur_Valeur'] = $mf_droits_defaut['api_modifier__a_parametre_utilisateur_Valeur'];
    $authorization['PUT:a_parametre_utilisateur_Actif'] = $mf_droits_defaut['api_modifier__a_parametre_utilisateur_Actif'];
    $authorization['DELETE'] = $mf_droits_defaut['a_parametre_utilisateur__SUPPRIMER'];
    return ['code_erreur' => 0, 'authorization' => $authorization];
}
