<?php declare(strict_types=1);
include __DIR__ . '/../../../systeme/make-your-style/acces_api_rest/utilisateur.php';

function get($id, $options)
{
    // Contrôle d'accès
    $r = mf_api_droits($options, API_REST_ACCESS_GET_UTILISATEUR);
    if ($r['code_erreur'] != 0) return $r;

    $id = (int) $id;
    $db = new DB();
    if ($id == 0) {
        $l = array_values($db->utilisateur()->mf_lister(['autocompletion' => true, 'limit' => [0, NB_RESULT_MAX_API], 'toutes_colonnes' => true]));
        return array_merge($l, ['code_erreur' => (count($l) == NB_RESULT_MAX_API ? 8 : 0 )]);
    } else {
        $r = $db->utilisateur()->mf_get($id, ['autocompletion' => true]);
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
    $r = mf_api_droits($options, API_REST_ACCESS_POST_UTILISATEUR);
    if ($r['code_erreur'] != 0) return $r;

    $db = new DB();
    if (is_array(current($data))) {
        $liste_Code_utilisateur = $db->utilisateur()->mf_liste_Code_utilisateur(  );
        $retour = $db->utilisateur()->mf_supprimer_2($liste_Code_utilisateur);
        if ($retour['code_erreur'] == 0) {
            foreach ($data as $value) {
                $retour = $db->utilisateur()->mf_ajouter_2($value);
                unset($retour['Code_utilisateur']);
                if ($retour['code_erreur'] != 0) {
                    return $retour;
                }
            }
        }
    } else {
        if ($retour['Code_utilisateur'] = $db->utilisateur()->mf_search($data)) {
            $retour['code_erreur'] = 0;
            $db->utilisateur()->mf_modifier_2([$retour['Code_utilisateur']=>$data]);
            $retour['callback'] = Hook_utilisateur::callback_post($retour['Code_utilisateur']);
        } else {
            $retour = $db->utilisateur()->mf_ajouter_2($data);
        }
        $retour['id'] = ( $retour['Code_utilisateur']!=0 ? $retour['Code_utilisateur'] : '' );
        unset($retour['Code_utilisateur']);
    }
    return $retour;
}

function put($id, $data, $options)
{
    // Contrôle d'accès
    $r = mf_api_droits($options, API_REST_ACCESS_PUT_UTILISATEUR);
    if ($r['code_erreur'] != 0) return $r;

    $db = new DB();
    return $db->utilisateur()->mf_modifier_2([$id=>$data]);
}

function delete($id, $options)
{
    // Contrôle d'accès
    $r = mf_api_droits($options, API_REST_ACCESS_DELETE_UTILISATEUR);
    if ($r['code_erreur'] != 0) return $r;

    if ($id != '') {
        $db = new DB();
        return $db->utilisateur()->mf_supprimer($id);
    } else {
        $db = new DB();
        $liste_Code_utilisateur = $db->utilisateur()->mf_liste_Code_utilisateur();
        return $db->utilisateur()->mf_supprimer_2($liste_Code_utilisateur);
    }
}

function options($id, $options)
{
    // Contrôle d'accès
    $r = mf_api_droits($options, API_REST_ACCESS_OPTIONS_UTILISATEUR);
    if ($r['code_erreur'] != 0) return $r;

    $id = (int) $id;
    Hook_utilisateur::hook_actualiser_les_droits_ajouter();
    Hook_utilisateur::hook_actualiser_les_droits_modifier($id);
    Hook_utilisateur::hook_actualiser_les_droits_supprimer($id);
    $authorization = [];
    global $mf_droits_defaut;
    $authorization['POST'] = $mf_droits_defaut['utilisateur__AJOUTER'];
    $authorization['PUT'] = $mf_droits_defaut['utilisateur__MODIFIER'];
    $authorization['PUT:utilisateur_Identifiant'] = $mf_droits_defaut['api_modifier__utilisateur_Identifiant'];
    $authorization['PUT:utilisateur_Password'] = $mf_droits_defaut['api_modifier__utilisateur_Password'];
    $authorization['PUT:utilisateur_Email'] = $mf_droits_defaut['api_modifier__utilisateur_Email'];
    $authorization['PUT:utilisateur_Civilite_Type'] = $mf_droits_defaut['api_modifier__utilisateur_Civilite_Type'];
    $authorization['PUT:utilisateur_Prenom'] = $mf_droits_defaut['api_modifier__utilisateur_Prenom'];
    $authorization['PUT:utilisateur_Nom'] = $mf_droits_defaut['api_modifier__utilisateur_Nom'];
    $authorization['PUT:utilisateur_Adresse_1'] = $mf_droits_defaut['api_modifier__utilisateur_Adresse_1'];
    $authorization['PUT:utilisateur_Adresse_2'] = $mf_droits_defaut['api_modifier__utilisateur_Adresse_2'];
    $authorization['PUT:utilisateur_Ville'] = $mf_droits_defaut['api_modifier__utilisateur_Ville'];
    $authorization['PUT:utilisateur_Code_postal'] = $mf_droits_defaut['api_modifier__utilisateur_Code_postal'];
    $authorization['PUT:utilisateur_Date_naissance'] = $mf_droits_defaut['api_modifier__utilisateur_Date_naissance'];
    $authorization['PUT:utilisateur_Accepte_mail_publicitaire'] = $mf_droits_defaut['api_modifier__utilisateur_Accepte_mail_publicitaire'];
    $authorization['PUT:utilisateur_Administrateur'] = $mf_droits_defaut['api_modifier__utilisateur_Administrateur'];
    $authorization['PUT:utilisateur_Fournisseur'] = $mf_droits_defaut['api_modifier__utilisateur_Fournisseur'];
    $authorization['DELETE'] = $mf_droits_defaut['utilisateur__SUPPRIMER'];
    return ['code_erreur' => 0, 'authorization' => $authorization];
}
