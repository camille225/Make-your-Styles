<?php declare(strict_types=1);
include __DIR__ . '/../../../systeme/make-your-style/acces_api_rest/conseil.php';

function get($id, $options)
{
    // Contrôle d'accès
    $r = mf_api_droits($options, API_REST_ACCESS_GET_CONSEIL);
    if ($r['code_erreur'] != 0) return $r;

    $id = (int) $id;
    $db = new DB();
    if ($id == 0) {
        $l = array_values($db->conseil()->mf_lister(['autocompletion' => true, 'limit' => [0, NB_RESULT_MAX_API], 'toutes_colonnes' => true]));
        return array_merge($l, ['code_erreur' => (count($l) == NB_RESULT_MAX_API ? 8 : 0 )]);
    } else {
        $r = $db->conseil()->mf_get($id, ['autocompletion' => true]);
        if ($r === []) {
            return ['http_response_code' => 404, 'code_erreur' => 0];
        } else {
            return array_merge( [$r], ['code_erreur' => 0] );
        }
    }
}

function post($data, $options)
{
    // Contrôle d'accès
    $r = mf_api_droits($options, API_REST_ACCESS_POST_CONSEIL);
    if ($r['code_erreur'] != 0) return $r;

    $db = new DB();
    if (is_array(current($data))) {
        $liste_Code_conseil = $db->conseil()->mf_liste_Code_conseil(  );
        $retour = $db->conseil()->mf_supprimer_2($liste_Code_conseil);
        if ($retour['code_erreur'] == 0) {
            foreach ($data as $value) {
                $retour = $db->conseil()->mf_ajouter_2($value);
                unset($retour['Code_conseil']);
                if ($retour['code_erreur'] != 0) {
                    return $retour;
                }
            }
        }
    } else {
        if ($retour['Code_conseil'] = $db->conseil()->mf_search($data)) {
            $retour['code_erreur'] = 0;
            $db->conseil()->mf_modifier_2([$retour['Code_conseil']=>$data]);
            $retour['callback'] = Hook_conseil::callback_post($retour['Code_conseil']);
        } else {
            $retour = $db->conseil()->mf_ajouter_2($data);
        }
        $retour['id'] = ( $retour['Code_conseil']!=0 ? $retour['Code_conseil'] : '' );
        unset($retour['Code_conseil']);
    }
    return $retour;
}

function put($id, $data, $options)
{
    // Contrôle d'accès
    $r = mf_api_droits($options, API_REST_ACCESS_PUT_CONSEIL);
    if ($r['code_erreur'] != 0) return $r;

    $db = new DB();
    return $db->conseil()->mf_modifier_2([$id=>$data]);
}

function delete($id, $options)
{
    // Contrôle d'accès
    $r = mf_api_droits($options, API_REST_ACCESS_DELETE_CONSEIL);
    if ($r['code_erreur'] != 0) return $r;

    if ($id != '') {
        $db = new DB();
        return $db->conseil()->mf_supprimer($id);
    } else {
        $db = new DB();
        $liste_Code_conseil = $db->conseil()->mf_liste_Code_conseil();
        return $db->conseil()->mf_supprimer_2($liste_Code_conseil);
    }
}

function options($id, $options)
{
    // Contrôle d'accès
    $r = mf_api_droits($options, API_REST_ACCESS_OPTIONS_CONSEIL);
    if ($r['code_erreur'] != 0) return $r;

    $id = (int) $id;
    Hook_conseil::hook_actualiser_les_droits_ajouter();
    Hook_conseil::hook_actualiser_les_droits_modifier($id);
    Hook_conseil::hook_actualiser_les_droits_supprimer($id);
    $authorization = [];
    global $mf_droits_defaut;
    $authorization['POST'] = $mf_droits_defaut['conseil__AJOUTER'];
    $authorization['PUT'] = $mf_droits_defaut['conseil__MODIFIER'];
    $authorization['PUT:conseil_Libelle'] = $mf_droits_defaut['api_modifier__conseil_Libelle'];
    $authorization['PUT:conseil_Description'] = $mf_droits_defaut['api_modifier__conseil_Description'];
    $authorization['PUT:conseil_Actif'] = $mf_droits_defaut['api_modifier__conseil_Actif'];
    $authorization['DELETE'] = $mf_droits_defaut['conseil__SUPPRIMER'];
    return ['code_erreur' => 0, 'authorization' => $authorization];
}
