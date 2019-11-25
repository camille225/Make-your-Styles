<?php

function mise_a_jour_fichier_developpeur()
{

    global $est_charge, $desactivation_actualisation_outils_developpeur, $mf_liste_gabarits;

    if (!isset($desactivation_actualisation_outils_developpeur))
    {
        $filename = __DIR__ . '/../../outil_developpeur.php';
        $txt = "<?php\n\n";
        $txt .= "// +-------------------+\n";
        $txt .= "// | Outil développeur |\n";
        $txt .= "// +-------------------+\n\n";

        function test_constante_definie($const_name) {if (!defined($const_name)) return '// constante "'.$const_name.'" introuvable !!!'."\n\n"; return '';}

        $txt .= test_constante_definie('ADRESSE_SITE');
        $txt .= test_constante_definie('ADRESSE_API');
        $txt .= test_constante_definie('FIN_ADRESSE_RACINE');
        $txt .= test_constante_definie('REPERTOIRE_WWW');
        $txt .= test_constante_definie('NOM_PROJET');
        $txt .= test_constante_definie('HTTPS_ON');
        $txt .= test_constante_definie('MODE_PROD');
        $txt .= test_constante_definie('DB_HOST');
        $txt .= test_constante_definie('DB_USER');
        $txt .= test_constante_definie('DB_PASSWORD');
        $txt .= test_constante_definie('DB_NAME');
        $txt .= test_constante_definie('DB_PORT');
        $txt .= test_constante_definie('LNG_TOKEN');
        $txt .= test_constante_definie('TABLE_INSTANCE');
        $txt .= test_constante_definie('PREFIXE_DB_INSTANCE');
        $txt .= test_constante_definie('TITRE_DB_INSTANCE');
        $txt .= test_constante_definie('LISTE_TABLES_GLOBALES');
        $txt .= test_constante_definie('CONNECTEUR_API_TABLE');
        $txt .= test_constante_definie('CONNECTEUR_API_COLONNE_DATE_START');
        $txt .= test_constante_definie('CONNECTEUR_API_COLONNE_DATE_STOP');
        $txt .= test_constante_definie('CONNECTEUR_API_COLONNE_TOKEN');
        $txt .= test_constante_definie('DUREE_HISTORIQUE');
        $txt .= test_constante_definie('LISTE_TABLES_HISTORIQUE_DESACTIVE');
        $txt .= test_constante_definie('DB_CACHE_HOST');
        $txt .= test_constante_definie('DB_CACHE_USER');
        $txt .= test_constante_definie('DB_CACHE_PASSWORD');
        $txt .= test_constante_definie('DB_CACHE_NAME');
        $txt .= test_constante_definie('DB_CACHE_PORT');
        $txt .= test_constante_definie('PREFIXE_SESSION');
        $txt .= test_constante_definie('PREFIXE_COOKIE');
        $txt .= test_constante_definie('DUREE_CACHE_MINUTES');
        $txt .= test_constante_definie('DELAI_RAFRAICHISSEMENT');
        $txt .= test_constante_definie('DELAI_RAFRAICHISSEMENT_COURT');
        $txt .= test_constante_definie('DELAI_EXECUTION_WORKER');
        $txt .= test_constante_definie('BOUTON_VALIDATION_SOUS_FORMULAIRE');
        $txt .= test_constante_definie('BOUTON_INTEGRABLE');
        $txt .= test_constante_definie('NB_ELEMENTS_MAX_PAR_TABLEAU');
        $txt .= test_constante_definie('FORM_SUPPR_DEFAUT');
        $txt .= test_constante_definie('IMAGES_LARGEUR_MAXI');
        $txt .= test_constante_definie('IMAGES_HAUTEUR_MAXI');
        $txt .= test_constante_definie('USE_BOOTSTRAP');
        $txt .= test_constante_definie('VERSION_BOOTSTRAP');
        $txt .= test_constante_definie('AUTOCOMPLETION_DEFAUT');
        $txt .= test_constante_definie('AUTOCOMPLETION_RECURSIVE_DEFAUT');
        $txt .= test_constante_definie('TOUTES_COLONNES_DEFAUT');
        $txt .= test_constante_definie('MAIL_NOREPLY');
        $txt .= test_constante_definie('MAIL_ADMIN');
        $txt .= test_constante_definie('DUREE_CACHE_NAV_CLIENT_EN_JOURS');
        $txt .= test_constante_definie('ACTIVER_FORMULAIRE_INSCRIPTION');
        $txt .= test_constante_definie('ACTIVER_CONNEXION_EMAIL');
        $txt .= test_constante_definie('MULTI_BLOCS');
        $txt .= test_constante_definie('MODE_DESIGN');
        $txt .= test_constante_definie('ALERTE_INFOS_NON_ENREGISTREES');
        $txt .= test_constante_definie('PREFIXE_ASSIST_LOGIN');
        $txt .= test_constante_definie('PREFIXE_ASSIST_PWD');
        $txt .= test_constante_definie('GOOGLE_CLIENT_ID');
        $txt .= test_constante_definie('GOOGLE_CLIENT_SECRET');
        $txt .= test_constante_definie('FACEBOOK_CLIENT_ID');
        $txt .= test_constante_definie('FACEBOOK_CLIENT_SECRET');

        $txt .= "// Système\n";
        $txt .= "    include 'systeme/make-your-style/constantes_systeme.php';                        // Les constantes globales\n";
        $txt .= "    include 'systeme/make-your-style/fonctions_additionnelles.php';                  // Les fonctions globales\n";
        $txt .= "    include 'systeme/make-your-style/tables/monframework/hooks/Hook_mf_systeme.php'; // Contrôle d'accès aux données, scripts à la connexion et à la déconnexion\n";
        $txt .= "\n";

        $debug = debug_backtrace();
        $controleur = '';
        foreach ($debug as $t)
        {
            $controleur = $t['file'];
        }
        $txt .= "// Controleur\n";
        $txt .= "    include '{$controleur}';\n";

        if (isset($est_charge))
        {
            foreach ($est_charge as $nom => $etat)
            {
                if ($etat==1)
                {
                    $txt .= "\n";
                    $txt .= "// {$nom}\n";
                    $txt .= "    include 'systeme/make-your-style/langues/fr/{$nom}.php';                     // Fichier de langue française et initialisation automatique des valeurs des colonnes\n";
                    $txt .= "    include 'systeme/make-your-style/tables/{$nom}.php';                         // Ajout des fonctions personalisées liées à la table {$nom}\n";
                    $txt .= "    include 'systeme/make-your-style/tables/monframework/hooks/Hook_{$nom}.php'; // Evénements, data controller et completion\n";
                    $txt .= "    include 'www/make-your-style/code/_{$nom}_form.php';                         // Appels aux formulaires « ajouter », « modifier » et « supprimer ». Chargements de « _{$nom}_get.php » et  « _{$nom}_list.php »\n";
                    $txt .= "        include 'www/make-your-style/code/_{$nom}_get.php';                      // « _{$nom}_get.php » : Génération des éléments positiionnés dans un gabarit\n";
                    $txt .= "        include 'www/make-your-style/code/_{$nom}_list.php';                     // « _{$nom}_list.php » : Génération d'un tableau positiionné dans un gabarit\n";
                    $txt .= "    include 'www/make-your-style/code/_{$nom}_actions.php';                      // Récupération des données en provenance des formulaires et appels aux méthodes associées\n";
                }
            }
        }

        $txt .= "\n/* Gabarits chargés :\n\n";
        $d = count($mf_liste_gabarits);
        for ( $i = $d-1; $i>=0; $i-- )
        {
            $gabarits = $mf_liste_gabarits[$i];
            foreach ($gabarits as $value) {
                $txt .= $value."\n";
            }
            $txt .= "\n";
        }
        $txt .= "*/\n";

        file_put_contents($filename, $txt);

    }

}
