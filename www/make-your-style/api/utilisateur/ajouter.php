<?php declare(strict_types=1);

    include __DIR__ . '/../../../../systeme/make-your-style/acces_api_rest/utilisateur.php';
    if (API_REST_ACCESS_POST_UTILISATEUR == 'all') {
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
    $utilisateur_Identifiant = (string) lecture_parametre_api("utilisateur_Identifiant", '');
    $utilisateur_Password = (string) lecture_parametre_api("utilisateur_Password", '');
    $utilisateur_Email = (string) lecture_parametre_api("utilisateur_Email", '');
    $utilisateur_Civilite_Type = (int) lecture_parametre_api("utilisateur_Civilite_Type", '');
    $utilisateur_Prenom = (string) lecture_parametre_api("utilisateur_Prenom", '');
    $utilisateur_Nom = (string) lecture_parametre_api("utilisateur_Nom", '');
    $utilisateur_Adresse_1 = (string) lecture_parametre_api("utilisateur_Adresse_1", '');
    $utilisateur_Adresse_2 = (string) lecture_parametre_api("utilisateur_Adresse_2", '');
    $utilisateur_Ville = (string) lecture_parametre_api("utilisateur_Ville", '');
    $utilisateur_Code_postal = (string) lecture_parametre_api("utilisateur_Code_postal", '');
    $utilisateur_Date_naissance = (string) lecture_parametre_api("utilisateur_Date_naissance", '');
    $utilisateur_Accepte_mail_publicitaire = (bool) lecture_parametre_api("utilisateur_Accepte_mail_publicitaire", '');
    $utilisateur_Administrateur = (bool) lecture_parametre_api("utilisateur_Administrateur", '');
    $utilisateur_Fournisseur = (bool) lecture_parametre_api("utilisateur_Fournisseur", '');
    $retour = $db->utilisateur()->mf_ajouter($utilisateur_Identifiant, $utilisateur_Password, $utilisateur_Email, $utilisateur_Civilite_Type, $utilisateur_Prenom, $utilisateur_Nom, $utilisateur_Adresse_1, $utilisateur_Adresse_2, $utilisateur_Ville, $utilisateur_Code_postal, $utilisateur_Date_naissance, $utilisateur_Accepte_mail_publicitaire, $utilisateur_Administrateur, $utilisateur_Fournisseur);
    if ( $retour['code_erreur']==0 )
    {
        $cache = new Cachehtml();
        $cache->clear();
    }
    $retour_json = [];
    $retour_json['code_erreur'] = $retour['code_erreur'];
    $retour_json['message_erreur'] = ( (isset($retour) && $retour['code_erreur']>0) ? (isset($mf_libelle_erreur[$retour['code_erreur']]) ? $mf_libelle_erreur[$retour['code_erreur']] : 'ERREUR N_'.$retour['code_erreur'] ) : '' );
    $retour_json['Code_utilisateur'] = $retour['Code_utilisateur'];
    fermeture_connexion_db();
    $retour_json['duree'] = get_execution_time(4);
    vue_api_echo($retour_json);
