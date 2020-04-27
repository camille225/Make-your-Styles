<?php declare(strict_types=1);

    include __DIR__ . '/../../../../systeme/make-your-style/acces_api_rest/commande.php';
    if (API_REST_ACCESS_POST_COMMANDE == 'all') {
        include __DIR__ . '/../../../../systeme/make-your-style/api_espace_publique.php';
    } else {
        include __DIR__ . '/../../../../systeme/make-your-style/api_espace_privee.php';
    }

    $db = new DB();

/*
    +-----------+
    |  Ajouter  |
    +-----------+
*/
    $commande_Prix_total = (float) lecture_parametre_api("commande_Prix_total", '');
    $commande_Date_livraison = (string) lecture_parametre_api("commande_Date_livraison", '');
    $commande_Date_creation = (string) lecture_parametre_api("commande_Date_creation", '');
    $Code_utilisateur = (int) lecture_parametre_api("Code_utilisateur", $utilisateur_courant['Code_utilisateur']);
    $retour = $db->commande()->mf_ajouter($commande_Prix_total, $commande_Date_livraison, $commande_Date_creation, $Code_utilisateur);
    if ( $retour['code_erreur']==0 )
    {
        $cache = new Cachehtml();
        $cache->clear();
    }
    $retour_json = [];
    $retour_json['code_erreur'] = $retour['code_erreur'];
    $retour_json['message_erreur'] = ( (isset($retour) && $retour['code_erreur']>0) ? (isset($mf_libelle_erreur[$retour['code_erreur']]) ? $mf_libelle_erreur[$retour['code_erreur']] : 'ERREUR N_'.$retour['code_erreur'] ) : '' );
    $retour_json['Code_commande'] = $retour['Code_commande'];
    fermeture_connexion_db();
    $retour_json['duree'] = get_execution_time(4);
    vue_api_echo($retour_json);
