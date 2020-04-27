<?php declare(strict_types=1);
include __DIR__ . '/../../../systeme/make-your-style/acces_api_rest/vue_utilisateur.php';

function get($id, $options)
{
    // Contrôle d'accès
    $r = mf_api_droits($options, API_REST_ACCESS_GET_VUE_UTILISATEUR);
    if ($r['code_erreur'] != 0) return $r;

    $id = (int) $id;
    $db = new DB();
    if ($id == 0) {
        $l = array_values($db->vue_utilisateur()->mf_lister(['autocompletion' => true, 'limit' => [0, NB_RESULT_MAX_API], 'toutes_colonnes' => true]));
        return array_merge($l, ['code_erreur' => (count($l) == NB_RESULT_MAX_API ? 8 : 0 )]);
    } else {
        $r = $db->vue_utilisateur()->mf_get($id, ['autocompletion' => true]);
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
    $r = mf_api_droits($options, API_REST_ACCESS_POST_VUE_UTILISATEUR);
    if ($r['code_erreur'] != 0) return $r;

    $db = new DB();
    if (is_array(current($data))) {
        $liste_Code_vue_utilisateur = $db->vue_utilisateur()->mf_liste_Code_vue_utilisateur(  );
        $retour = $db->vue_utilisateur()->mf_supprimer_2($liste_Code_vue_utilisateur);
        if ($retour['code_erreur'] == 0) {
            foreach ($data as $value) {
                $retour = $db->vue_utilisateur()->mf_ajouter_2($value);
                unset($retour['Code_vue_utilisateur']);
                if ($retour['code_erreur'] != 0) {
                    return $retour;
                }
            }
        }
    } else {
        if ($retour['Code_vue_utilisateur'] = $db->vue_utilisateur()->mf_search($data)) {
            $retour['code_erreur'] = 0;
            $db->vue_utilisateur()->mf_modifier_2([$retour['Code_vue_utilisateur']=>$data]);
            $retour['callback'] = Hook_vue_utilisateur::callback_post($retour['Code_vue_utilisateur']);
        } else {
            $retour = $db->vue_utilisateur()->mf_ajouter_2($data);
        }
        $retour['id'] = ( $retour['Code_vue_utilisateur']!=0 ? $retour['Code_vue_utilisateur'] : '' );
        unset($retour['Code_vue_utilisateur']);
    }
    return $retour;
}

function put($id, $data, $options)
{
    // Contrôle d'accès
    $r = mf_api_droits($options, API_REST_ACCESS_PUT_VUE_UTILISATEUR);
    if ($r['code_erreur'] != 0) return $r;

    $db = new DB();
    return $db->vue_utilisateur()->mf_modifier_2([$id=>$data]);
}

function delete($id, $options)
{
    // Contrôle d'accès
    $r = mf_api_droits($options, API_REST_ACCESS_DELETE_VUE_UTILISATEUR);
    if ($r['code_erreur'] != 0) return $r;

    if ($id != '') {
        $db = new DB();
        return $db->vue_utilisateur()->mf_supprimer($id);
    } else {
        $db = new DB();
        $liste_Code_vue_utilisateur = $db->vue_utilisateur()->mf_liste_Code_vue_utilisateur();
        return $db->vue_utilisateur()->mf_supprimer_2($liste_Code_vue_utilisateur);
    }
}

function options($id, $options)
{
    // Contrôle d'accès
    $r = mf_api_droits($options, API_REST_ACCESS_OPTIONS_VUE_UTILISATEUR);
    if ($r['code_erreur'] != 0) return $r;

    $id = (int) $id;
    Hook_vue_utilisateur::hook_actualiser_les_droits_ajouter();
    Hook_vue_utilisateur::hook_actualiser_les_droits_modifier($id);
    Hook_vue_utilisateur::hook_actualiser_les_droits_supprimer($id);
    $authorization = [];
    global $mf_droits_defaut;
    $authorization['POST'] = $mf_droits_defaut['vue_utilisateur__AJOUTER'];
    $authorization['PUT'] = $mf_droits_defaut['vue_utilisateur__MODIFIER'];
    $authorization['PUT:vue_utilisateur_Recherche'] = $mf_droits_defaut['api_modifier__vue_utilisateur_Recherche'];
    $authorization['PUT:vue_utilisateur_Filtre_Saison_Type'] = $mf_droits_defaut['api_modifier__vue_utilisateur_Filtre_Saison_Type'];
    $authorization['PUT:vue_utilisateur_Filtre_Couleur'] = $mf_droits_defaut['api_modifier__vue_utilisateur_Filtre_Couleur'];
    $authorization['PUT:vue_utilisateur_Filtre_Taille_Pays_Type'] = $mf_droits_defaut['api_modifier__vue_utilisateur_Filtre_Taille_Pays_Type'];
    $authorization['PUT:vue_utilisateur_Filtre_Taille_Max'] = $mf_droits_defaut['api_modifier__vue_utilisateur_Filtre_Taille_Max'];
    $authorization['PUT:vue_utilisateur_Filtre_Taille_Min'] = $mf_droits_defaut['api_modifier__vue_utilisateur_Filtre_Taille_Min'];
    $authorization['DELETE'] = $mf_droits_defaut['vue_utilisateur__SUPPRIMER'];
    return ['code_erreur' => 0, 'authorization' => $authorization];
}
