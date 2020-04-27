<?php declare(strict_types=1);
include __DIR__ . '/../../../systeme/make-your-style/acces_api_rest/article.php';

function get($id, $options)
{
    // Contrôle d'accès
    $r = mf_api_droits($options, API_REST_ACCESS_GET_ARTICLE);
    if ($r['code_erreur'] != 0) return $r;

    $id = (int) $id;
    $db = new DB();
    if ($id == 0) {
        $code_sous_categorie_article = isset($options['code_sous_categorie_article']) ? (int) $options['code_sous_categorie_article'] : 0;
        $l = array_values($db->article()->mf_lister($code_sous_categorie_article, ['autocompletion' => true, 'limit' => [0, NB_RESULT_MAX_API], 'toutes_colonnes' => true]));
        return array_merge($l, ['code_erreur' => (count($l) == NB_RESULT_MAX_API ? 8 : 0 )]);
    } else {
        $r = $db->article()->mf_get($id, ['autocompletion' => true]);
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
    $r = mf_api_droits($options, API_REST_ACCESS_POST_ARTICLE);
    if ($r['code_erreur'] != 0) return $r;

    $db = new DB();
    if (is_array(current($data))) {
        $liste_Code_article = $db->article()->mf_liste_Code_article( ( isset($options['code_sous_categorie_article']) ? $options['code_sous_categorie_article'] : 0 ) );
        $retour = $db->article()->mf_supprimer_2($liste_Code_article);
        if ($retour['code_erreur'] == 0) {
            foreach ($data as $value) {
                if (isset($options['code_sous_categorie_article'])) $value['Code_sous_categorie_article'] = $options['code_sous_categorie_article'];
                if (isset($value['article_Photo_Fichier'])) {
                    $fichier = new Fichier();
                    $value['article_Photo_Fichier'] = $fichier->set( base64_decode( $value['article_Photo_Fichier'] ) );
                }
                $retour = $db->article()->mf_ajouter_2($value);
                unset($retour['Code_article']);
                if ($retour['code_erreur'] != 0) {
                    return $retour;
                }
            }
        }
    } else {
        if (isset($options['code_sous_categorie_article'])) {
            $data['Code_sous_categorie_article'] = $options['code_sous_categorie_article'];
        } elseif(! isset($data['Code_sous_categorie_article'])) {
            $data['Code_sous_categorie_article'] = 0;
        }
        if (isset($data['article_Photo_Fichier'])) {
            $fichier = new Fichier();
            $data['article_Photo_Fichier'] = $fichier->set( base64_decode( $data['article_Photo_Fichier'] ) );
        }
        if ($retour['Code_article'] = $db->article()->mf_search($data)) {
            $retour['code_erreur'] = 0;
            $db->article()->mf_modifier_2([$retour['Code_article']=>$data]);
            $retour['callback'] = Hook_article::callback_post($retour['Code_article']);
        } else {
            $retour = $db->article()->mf_ajouter_2($data);
        }
        $retour['id'] = ( $retour['Code_article']!=0 ? $retour['Code_article'] : '' );
        unset($retour['Code_article']);
    }
    return $retour;
}

function put($id, $data, $options)
{
    // Contrôle d'accès
    $r = mf_api_droits($options, API_REST_ACCESS_PUT_ARTICLE);
    if ($r['code_erreur'] != 0) return $r;

    $db = new DB();
    return $db->article()->mf_modifier_2([$id=>$data]);
}

function delete($id, $options)
{
    // Contrôle d'accès
    $r = mf_api_droits($options, API_REST_ACCESS_DELETE_ARTICLE);
    if ($r['code_erreur'] != 0) return $r;

    if ($id != '') {
        $db = new DB();
        return $db->article()->mf_supprimer($id);
    } else {
        $db = new DB();
        $Code_sous_categorie_article = ( isset($options['code_sous_categorie_article']) ? $options['code_sous_categorie_article'] : 0 );
        $liste_Code_article = $db->article()->mf_liste_Code_article($Code_sous_categorie_article);
        return $db->article()->mf_supprimer_2($liste_Code_article);
    }
}

function options($id, $options)
{
    // Contrôle d'accès
    $r = mf_api_droits($options, API_REST_ACCESS_OPTIONS_ARTICLE);
    if ($r['code_erreur'] != 0) return $r;

    $id = (int) $id;
    $code_sous_categorie_article = isset($options['code_sous_categorie_article']) ? $options['code_sous_categorie_article'] : 0;
    Hook_article::hook_actualiser_les_droits_ajouter($code_sous_categorie_article);
    Hook_article::hook_actualiser_les_droits_modifier($id);
    Hook_article::hook_actualiser_les_droits_supprimer($id);
    $authorization = [];
    global $mf_droits_defaut;
    $authorization['POST'] = $mf_droits_defaut['article__AJOUTER'];
    $authorization['PUT'] = $mf_droits_defaut['article__MODIFIER'];
    $authorization['PUT:article_Libelle'] = $mf_droits_defaut['api_modifier__article_Libelle'];
    $authorization['PUT:article_Description'] = $mf_droits_defaut['api_modifier__article_Description'];
    $authorization['PUT:article_Saison_Type'] = $mf_droits_defaut['api_modifier__article_Saison_Type'];
    $authorization['PUT:article_Nom_fournisseur'] = $mf_droits_defaut['api_modifier__article_Nom_fournisseur'];
    $authorization['PUT:article_Url'] = $mf_droits_defaut['api_modifier__article_Url'];
    $authorization['PUT:article_Reference'] = $mf_droits_defaut['api_modifier__article_Reference'];
    $authorization['PUT:article_Couleur'] = $mf_droits_defaut['api_modifier__article_Couleur'];
    $authorization['PUT:article_Code_couleur_svg'] = $mf_droits_defaut['api_modifier__article_Code_couleur_svg'];
    $authorization['PUT:article_Taille_Pays_Type'] = $mf_droits_defaut['api_modifier__article_Taille_Pays_Type'];
    $authorization['PUT:article_Taille'] = $mf_droits_defaut['api_modifier__article_Taille'];
    $authorization['PUT:article_Matiere'] = $mf_droits_defaut['api_modifier__article_Matiere'];
    $authorization['PUT:article_Photo_Fichier'] = $mf_droits_defaut['api_modifier__article_Photo_Fichier'];
    $authorization['PUT:article_Prix'] = $mf_droits_defaut['api_modifier__article_Prix'];
    $authorization['PUT:article_Actif'] = $mf_droits_defaut['api_modifier__article_Actif'];
    $authorization['PUT:Code_sous_categorie_article'] = $mf_droits_defaut['api_modifier_ref__article__Code_sous_categorie_article'];
    $authorization['DELETE'] = $mf_droits_defaut['article__SUPPRIMER'];
    return ['code_erreur' => 0, 'authorization' => $authorization];
}
