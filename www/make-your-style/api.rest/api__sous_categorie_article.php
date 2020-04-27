<?php declare(strict_types=1);
include __DIR__ . '/../../../systeme/make-your-style/acces_api_rest/sous_categorie_article.php';

function get($id, $options)
{
    // Contrôle d'accès
    $r = mf_api_droits($options, API_REST_ACCESS_GET_SOUS_CATEGORIE_ARTICLE);
    if ($r['code_erreur'] != 0) return $r;

    $id = (int) $id;
    $db = new DB();
    if ($id == 0) {
        $code_categorie_article = isset($options['code_categorie_article']) ? (int) $options['code_categorie_article'] : 0;
        $l = array_values($db->sous_categorie_article()->mf_lister($code_categorie_article, ['autocompletion' => true, 'limit' => [0, NB_RESULT_MAX_API], 'toutes_colonnes' => true]));
        return array_merge($l, ['code_erreur' => (count($l) == NB_RESULT_MAX_API ? 8 : 0 )]);
    } else {
        $r = $db->sous_categorie_article()->mf_get($id, ['autocompletion' => true]);
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
    $r = mf_api_droits($options, API_REST_ACCESS_POST_SOUS_CATEGORIE_ARTICLE);
    if ($r['code_erreur'] != 0) return $r;

    $db = new DB();
    if (is_array(current($data))) {
        $liste_Code_sous_categorie_article = $db->sous_categorie_article()->mf_liste_Code_sous_categorie_article( ( isset($options['code_categorie_article']) ? $options['code_categorie_article'] : 0 ) );
        $retour = $db->sous_categorie_article()->mf_supprimer_2($liste_Code_sous_categorie_article);
        if ($retour['code_erreur'] == 0) {
            foreach ($data as $value) {
                if (isset($options['code_categorie_article'])) $value['Code_categorie_article'] = $options['code_categorie_article'];
                $retour = $db->sous_categorie_article()->mf_ajouter_2($value);
                unset($retour['Code_sous_categorie_article']);
                if ($retour['code_erreur'] != 0) {
                    return $retour;
                }
            }
        }
    } else {
        if (isset($options['code_categorie_article'])) {
            $data['Code_categorie_article'] = $options['code_categorie_article'];
        } elseif(! isset($data['Code_categorie_article'])) {
            $data['Code_categorie_article'] = 0;
        }
        if ($retour['Code_sous_categorie_article'] = $db->sous_categorie_article()->mf_search($data)) {
            $retour['code_erreur'] = 0;
            $db->sous_categorie_article()->mf_modifier_2([$retour['Code_sous_categorie_article']=>$data]);
            $retour['callback'] = Hook_sous_categorie_article::callback_post($retour['Code_sous_categorie_article']);
        } else {
            $retour = $db->sous_categorie_article()->mf_ajouter_2($data);
        }
        $retour['id'] = ( $retour['Code_sous_categorie_article']!=0 ? $retour['Code_sous_categorie_article'] : '' );
        unset($retour['Code_sous_categorie_article']);
    }
    return $retour;
}

function put($id, $data, $options)
{
    // Contrôle d'accès
    $r = mf_api_droits($options, API_REST_ACCESS_PUT_SOUS_CATEGORIE_ARTICLE);
    if ($r['code_erreur'] != 0) return $r;

    $db = new DB();
    return $db->sous_categorie_article()->mf_modifier_2([$id=>$data]);
}

function delete($id, $options)
{
    // Contrôle d'accès
    $r = mf_api_droits($options, API_REST_ACCESS_DELETE_SOUS_CATEGORIE_ARTICLE);
    if ($r['code_erreur'] != 0) return $r;

    if ($id != '') {
        $db = new DB();
        return $db->sous_categorie_article()->mf_supprimer($id);
    } else {
        $db = new DB();
        $Code_categorie_article = ( isset($options['code_categorie_article']) ? $options['code_categorie_article'] : 0 );
        $liste_Code_sous_categorie_article = $db->sous_categorie_article()->mf_liste_Code_sous_categorie_article($Code_categorie_article);
        return $db->sous_categorie_article()->mf_supprimer_2($liste_Code_sous_categorie_article);
    }
}

function options($id, $options)
{
    // Contrôle d'accès
    $r = mf_api_droits($options, API_REST_ACCESS_OPTIONS_SOUS_CATEGORIE_ARTICLE);
    if ($r['code_erreur'] != 0) return $r;

    $id = (int) $id;
    $code_categorie_article = isset($options['code_categorie_article']) ? $options['code_categorie_article'] : 0;
    Hook_sous_categorie_article::hook_actualiser_les_droits_ajouter($code_categorie_article);
    Hook_sous_categorie_article::hook_actualiser_les_droits_modifier($id);
    Hook_sous_categorie_article::hook_actualiser_les_droits_supprimer($id);
    $authorization = [];
    global $mf_droits_defaut;
    $authorization['POST'] = $mf_droits_defaut['sous_categorie_article__AJOUTER'];
    $authorization['PUT'] = $mf_droits_defaut['sous_categorie_article__MODIFIER'];
    $authorization['PUT:sous_categorie_article_Libelle'] = $mf_droits_defaut['api_modifier__sous_categorie_article_Libelle'];
    $authorization['PUT:Code_categorie_article'] = $mf_droits_defaut['api_modifier_ref__sous_categorie_article__Code_categorie_article'];
    $authorization['DELETE'] = $mf_droits_defaut['sous_categorie_article__SUPPRIMER'];
    return ['code_erreur' => 0, 'authorization' => $authorization];
}
