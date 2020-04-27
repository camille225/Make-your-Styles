<?php declare(strict_types=1);

    include __DIR__ . '/../../../../systeme/make-your-style/acces_api_rest/vue_utilisateur.php';
    if (API_REST_ACCESS_POST_VUE_UTILISATEUR == 'all') {
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
    $vue_utilisateur_Recherche = (string) lecture_parametre_api("vue_utilisateur_Recherche", '');
    $vue_utilisateur_Filtre_Saison_Type = (int) lecture_parametre_api("vue_utilisateur_Filtre_Saison_Type", '');
    $vue_utilisateur_Filtre_Couleur = (string) lecture_parametre_api("vue_utilisateur_Filtre_Couleur", '');
    $vue_utilisateur_Filtre_Taille_Pays_Type = (int) lecture_parametre_api("vue_utilisateur_Filtre_Taille_Pays_Type", '');
    $vue_utilisateur_Filtre_Taille_Max = (int) lecture_parametre_api("vue_utilisateur_Filtre_Taille_Max", '');
    $vue_utilisateur_Filtre_Taille_Min = (int) lecture_parametre_api("vue_utilisateur_Filtre_Taille_Min", '');
    $retour = $db->vue_utilisateur()->mf_ajouter($vue_utilisateur_Recherche, $vue_utilisateur_Filtre_Saison_Type, $vue_utilisateur_Filtre_Couleur, $vue_utilisateur_Filtre_Taille_Pays_Type, $vue_utilisateur_Filtre_Taille_Max, $vue_utilisateur_Filtre_Taille_Min);
    if ( $retour['code_erreur']==0 )
    {
        $cache = new Cachehtml();
        $cache->clear();
    }
    $retour_json = [];
    $retour_json['code_erreur'] = $retour['code_erreur'];
    $retour_json['message_erreur'] = ( (isset($retour) && $retour['code_erreur']>0) ? (isset($mf_libelle_erreur[$retour['code_erreur']]) ? $mf_libelle_erreur[$retour['code_erreur']] : 'ERREUR N_'.$retour['code_erreur'] ) : '' );
    $retour_json['Code_vue_utilisateur'] = $retour['Code_vue_utilisateur'];
    fermeture_connexion_db();
    $retour_json['duree'] = get_execution_time(4);
    vue_api_echo($retour_json);
