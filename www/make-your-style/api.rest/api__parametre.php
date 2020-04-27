<?php declare(strict_types=1);
include __DIR__ . '/../../../systeme/make-your-style/acces_api_rest/parametre.php';

function get($id, $options)
{
    // Contrôle d'accès
    $r = mf_api_droits($options, API_REST_ACCESS_GET_PARAMETRE);
    if ($r['code_erreur'] != 0) return $r;

    $id = (int) $id;
    $db = new DB();
    if ($id == 0) {
        $l = array_values($db->parametre()->mf_lister(['autocompletion' => true, 'limit' => [0, NB_RESULT_MAX_API], 'toutes_colonnes' => true]));
        return array_merge($l, ['code_erreur' => (count($l) == NB_RESULT_MAX_API ? 8 : 0 )]);
    } else {
        $r = $db->parametre()->mf_get($id, ['autocompletion' => true]);
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
    $r = mf_api_droits($options, API_REST_ACCESS_POST_PARAMETRE);
    if ($r['code_erreur'] != 0) return $r;

    $db = new DB();
    if (is_array(current($data))) {
        $liste_Code_parametre = $db->parametre()->mf_liste_Code_parametre(  );
        $retour = $db->parametre()->mf_supprimer_2($liste_Code_parametre);
        if ($retour['code_erreur'] == 0) {
            foreach ($data as $value) {
                $retour = $db->parametre()->mf_ajouter_2($value);
                unset($retour['Code_parametre']);
                if ($retour['code_erreur'] != 0) {
                    return $retour;
                }
            }
        }
    } else {
        if ($retour['Code_parametre'] = $db->parametre()->mf_search($data)) {
            $retour['code_erreur'] = 0;
            $db->parametre()->mf_modifier_2([$retour['Code_parametre']=>$data]);
            $retour['callback'] = Hook_parametre::callback_post($retour['Code_parametre']);
        } else {
            $retour = $db->parametre()->mf_ajouter_2($data);
        }
        $retour['id'] = ( $retour['Code_parametre']!=0 ? $retour['Code_parametre'] : '' );
        unset($retour['Code_parametre']);
    }
    return $retour;
}

function put($id, $data, $options)
{
    // Contrôle d'accès
    $r = mf_api_droits($options, API_REST_ACCESS_PUT_PARAMETRE);
    if ($r['code_erreur'] != 0) return $r;

    $db = new DB();
    return $db->parametre()->mf_modifier_2([$id=>$data]);
}

function delete($id, $options)
{
    // Contrôle d'accès
    $r = mf_api_droits($options, API_REST_ACCESS_DELETE_PARAMETRE);
    if ($r['code_erreur'] != 0) return $r;

    if ($id != '') {
        $db = new DB();
        return $db->parametre()->mf_supprimer($id);
    } else {
        $db = new DB();
        $liste_Code_parametre = $db->parametre()->mf_liste_Code_parametre();
        return $db->parametre()->mf_supprimer_2($liste_Code_parametre);
    }
}

function options($id, $options)
{
    // Contrôle d'accès
    $r = mf_api_droits($options, API_REST_ACCESS_OPTIONS_PARAMETRE);
    if ($r['code_erreur'] != 0) return $r;

    $id = (int) $id;
    Hook_parametre::hook_actualiser_les_droits_ajouter();
    Hook_parametre::hook_actualiser_les_droits_modifier($id);
    Hook_parametre::hook_actualiser_les_droits_supprimer($id);
    $authorization = [];
    global $mf_droits_defaut;
    $authorization['POST'] = $mf_droits_defaut['parametre__AJOUTER'];
    $authorization['PUT'] = $mf_droits_defaut['parametre__MODIFIER'];
    $authorization['PUT:parametre_Libelle'] = $mf_droits_defaut['api_modifier__parametre_Libelle'];
    $authorization['DELETE'] = $mf_droits_defaut['parametre__SUPPRIMER'];
    return ['code_erreur' => 0, 'authorization' => $authorization];
}
