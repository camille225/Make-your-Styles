<?php declare(strict_types=1);
include __DIR__ . '/../../../systeme/make-your-style/acces_api_rest/commande.php';

function get($id, $options)
{
    // Contrôle d'accès
    $r = mf_api_droits($options, API_REST_ACCESS_GET_COMMANDE);
    if ($r['code_erreur'] != 0) return $r;

    $id = (int) $id;
    $db = new DB();
    if ($id == 0) {
        $code_utilisateur = isset($options['code_utilisateur']) ? (int) $options['code_utilisateur'] : 0;
        $l = array_values($db->commande()->mf_lister($code_utilisateur, ['autocompletion' => true, 'limit' => [0, NB_RESULT_MAX_API], 'toutes_colonnes' => true]));
        return array_merge($l, ['code_erreur' => (count($l) == NB_RESULT_MAX_API ? 8 : 0 )]);
    } else {
        $r = $db->commande()->mf_get($id, ['autocompletion' => true]);
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
    $r = mf_api_droits($options, API_REST_ACCESS_POST_COMMANDE);
    if ($r['code_erreur'] != 0) return $r;

    $db = new DB();
    if (is_array(current($data))) {
        $liste_Code_commande = $db->commande()->mf_liste_Code_commande( ( isset($options['code_utilisateur']) ? $options['code_utilisateur'] : 0 ) );
        $retour = $db->commande()->mf_supprimer_2($liste_Code_commande);
        if ($retour['code_erreur'] == 0) {
            foreach ($data as $value) {
                if (isset($options['code_utilisateur'])) $value['Code_utilisateur'] = $options['code_utilisateur'];
                $retour = $db->commande()->mf_ajouter_2($value);
                unset($retour['Code_commande']);
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
        if ($retour['Code_commande'] = $db->commande()->mf_search($data)) {
            $retour['code_erreur'] = 0;
            $db->commande()->mf_modifier_2([$retour['Code_commande']=>$data]);
            $retour['callback'] = Hook_commande::callback_post($retour['Code_commande']);
        } else {
            $retour = $db->commande()->mf_ajouter_2($data);
        }
        $retour['id'] = ( $retour['Code_commande']!=0 ? $retour['Code_commande'] : '' );
        unset($retour['Code_commande']);
    }
    return $retour;
}

function put($id, $data, $options)
{
    // Contrôle d'accès
    $r = mf_api_droits($options, API_REST_ACCESS_PUT_COMMANDE);
    if ($r['code_erreur'] != 0) return $r;

    $db = new DB();
    return $db->commande()->mf_modifier_2([$id=>$data]);
}

function delete($id, $options)
{
    // Contrôle d'accès
    $r = mf_api_droits($options, API_REST_ACCESS_DELETE_COMMANDE);
    if ($r['code_erreur'] != 0) return $r;

    if ($id != '') {
        $db = new DB();
        return $db->commande()->mf_supprimer($id);
    } else {
        $db = new DB();
        $Code_utilisateur = ( isset($options['code_utilisateur']) ? $options['code_utilisateur'] : 0 );
        $liste_Code_commande = $db->commande()->mf_liste_Code_commande($Code_utilisateur);
        return $db->commande()->mf_supprimer_2($liste_Code_commande);
    }
}

function options($id, $options)
{
    // Contrôle d'accès
    $r = mf_api_droits($options, API_REST_ACCESS_OPTIONS_COMMANDE);
    if ($r['code_erreur'] != 0) return $r;

    $id = (int) $id;
    $code_utilisateur = isset($options['code_utilisateur']) ? $options['code_utilisateur'] : 0;
    Hook_commande::hook_actualiser_les_droits_ajouter($code_utilisateur);
    Hook_commande::hook_actualiser_les_droits_modifier($id);
    Hook_commande::hook_actualiser_les_droits_supprimer($id);
    $authorization = [];
    global $mf_droits_defaut;
    $authorization['POST'] = $mf_droits_defaut['commande__AJOUTER'];
    $authorization['PUT'] = $mf_droits_defaut['commande__MODIFIER'];
    $authorization['PUT:commande_Prix_total'] = $mf_droits_defaut['api_modifier__commande_Prix_total'];
    $authorization['PUT:commande_Date_livraison'] = $mf_droits_defaut['api_modifier__commande_Date_livraison'];
    $authorization['PUT:commande_Date_creation'] = $mf_droits_defaut['api_modifier__commande_Date_creation'];
    $authorization['PUT:Code_utilisateur'] = $mf_droits_defaut['api_modifier_ref__commande__Code_utilisateur'];
    $authorization['DELETE'] = $mf_droits_defaut['commande__SUPPRIMER'];
    return ['code_erreur' => 0, 'authorization' => $authorization];
}
