<?php declare(strict_types=1);

    include __DIR__ . '/../../../../systeme/make-your-style/acces_api_rest/vue_utilisateur.php';
    if (API_REST_ACCESS_PUT_VUE_UTILISATEUR == 'all') {
        include __DIR__ . '/../../../../systeme/make-your-style/api_espace_publique.php';
    } else {
        include __DIR__ . '/../../../../systeme/make-your-style/api_espace_privee.php';
    }

    $db = new DB();

/*
    +------------+
    |  Modifier  |
    +------------+
*/
    $Code_vue_utilisateur = lecture_parametre_api("Code_vue_utilisateur", 0 );
    $champs = [];
    if ( isset_parametre_api("vue_utilisateur_Recherche") ) $champs['vue_utilisateur_Recherche'] = lecture_parametre_api("vue_utilisateur_Recherche");
    if ( isset_parametre_api("vue_utilisateur_Filtre_Saison_Type") ) $champs['vue_utilisateur_Filtre_Saison_Type'] = lecture_parametre_api("vue_utilisateur_Filtre_Saison_Type");
    if ( isset_parametre_api("vue_utilisateur_Filtre_Couleur") ) $champs['vue_utilisateur_Filtre_Couleur'] = lecture_parametre_api("vue_utilisateur_Filtre_Couleur");
    if ( isset_parametre_api("vue_utilisateur_Filtre_Taille_Pays_Type") ) $champs['vue_utilisateur_Filtre_Taille_Pays_Type'] = lecture_parametre_api("vue_utilisateur_Filtre_Taille_Pays_Type");
    if ( isset_parametre_api("vue_utilisateur_Filtre_Taille_Max") ) $champs['vue_utilisateur_Filtre_Taille_Max'] = lecture_parametre_api("vue_utilisateur_Filtre_Taille_Max");
    if ( isset_parametre_api("vue_utilisateur_Filtre_Taille_Min") ) $champs['vue_utilisateur_Filtre_Taille_Min'] = lecture_parametre_api("vue_utilisateur_Filtre_Taille_Min");
    $retour = $db->vue_utilisateur()->mf_modifier_2([$Code_vue_utilisateur => $champs]);
    if ($retour['code_erreur'] == 0) {
        $cache = new Cachehtml();
        $cache->clear();
    }
    $retour_json = [];
    $retour_json['code_erreur'] = $retour['code_erreur'];
    $retour_json['message_erreur'] = ( (isset($retour) && $retour['code_erreur']>0) ? (isset($mf_libelle_erreur[$retour['code_erreur']]) ? $mf_libelle_erreur[$retour['code_erreur']] : 'ERREUR N_'.$retour['code_erreur'] ) : '' );
    fermeture_connexion_db();
    $retour_json['duree'] = get_execution_time(4);
    vue_api_echo($retour_json);
