<?php declare(strict_types=1);
include __DIR__ . '/../../../systeme/make-your-style/acces_api_rest/categorie_article.php';

function get($id, $options)
{
    // Contrôle d'accès
    $r = mf_api_droits($options, API_REST_ACCESS_GET_CATEGORIE_ARTICLE);
    if ($r['code_erreur'] != 0) return $r;

    $id = (int) $id;
    $db = new DB();
    if ($id == 0) {
        $l = array_values($db->categorie_article()->mf_lister(['autocompletion' => true, 'limit' => [0, NB_RESULT_MAX_API], 'toutes_colonnes' => true]));
        return array_merge($l, ['code_erreur' => (count($l) == NB_RESULT_MAX_API ? 8 : 0 )]);
    } else {
        $r = $db->categorie_article()->mf_get($id, ['autocompletion' => true]);
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
    $r = mf_api_droits($options, API_REST_ACCESS_POST_CATEGORIE_ARTICLE);
    if ($r['code_erreur'] != 0) return $r;

    $db = new DB();
    if (is_array(current($data))) {
        $liste_Code_categorie_article = $db->categorie_article()->mf_liste_Code_categorie_article(  );
        $retour = $db->categorie_article()->mf_supprimer_2($liste_Code_categorie_article);
        if ($retour['code_erreur'] == 0) {
            foreach ($data as $value) {
                $retour = $db->categorie_article()->mf_ajouter_2($value);
                unset($retour['Code_categorie_article']);
                if ($retour['code_erreur'] != 0) {
                    return $retour;
                }
            }
        }
    } else {
        if ($retour['Code_categorie_article'] = $db->categorie_article()->mf_search($data)) {
            $retour['code_erreur'] = 0;
            $db->categorie_article()->mf_modifier_2([$retour['Code_categorie_article']=>$data]);
            $retour['callback'] = Hook_categorie_article::callback_post($retour['Code_categorie_article']);
        } else {
            $retour = $db->categorie_article()->mf_ajouter_2($data);
        }
        $retour['id'] = ( $retour['Code_categorie_article']!=0 ? $retour['Code_categorie_article'] : '' );
        unset($retour['Code_categorie_article']);
    }
    return $retour;
}

function put($id, $data, $options)
{
    // Contrôle d'accès
    $r = mf_api_droits($options, API_REST_ACCESS_PUT_CATEGORIE_ARTICLE);
    if ($r['code_erreur'] != 0) return $r;

    $db = new DB();
    return $db->categorie_article()->mf_modifier_2([$id=>$data]);
}

function delete($id, $options)
{
    // Contrôle d'accès
    $r = mf_api_droits($options, API_REST_ACCESS_DELETE_CATEGORIE_ARTICLE);
    if ($r['code_erreur'] != 0) return $r;

    if ($id != '') {
        $db = new DB();
        return $db->categorie_article()->mf_supprimer($id);
    } else {
        $db = new DB();
        $liste_Code_categorie_article = $db->categorie_article()->mf_liste_Code_categorie_article();
        return $db->categorie_article()->mf_supprimer_2($liste_Code_categorie_article);
    }
}

function options($id, $options)
{
    // Contrôle d'accès
    $r = mf_api_droits($options, API_REST_ACCESS_OPTIONS_CATEGORIE_ARTICLE);
    if ($r['code_erreur'] != 0) return $r;

    $id = (int) $id;
    Hook_categorie_article::hook_actualiser_les_droits_ajouter();
    Hook_categorie_article::hook_actualiser_les_droits_modifier($id);
    Hook_categorie_article::hook_actualiser_les_droits_supprimer($id);
    $authorization = [];
    global $mf_droits_defaut;
    $authorization['POST'] = $mf_droits_defaut['categorie_article__AJOUTER'];
    $authorization['PUT'] = $mf_droits_defaut['categorie_article__MODIFIER'];
    $authorization['PUT:categorie_article_Libelle'] = $mf_droits_defaut['api_modifier__categorie_article_Libelle'];
    $authorization['DELETE'] = $mf_droits_defaut['categorie_article__SUPPRIMER'];
    return ['code_erreur' => 0, 'authorization' => $authorization];
}
