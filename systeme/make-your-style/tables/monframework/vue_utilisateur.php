<?php declare(strict_types=1);

/*
    +------------------------------+
    |  NE PAS MODIFIER CE FICHIER  |
    +------------------------------+
*/

class table_vue_utilisateur_monframework extends entite
{

    private static $initialisation = true;
    private static $auto_completion = 0;
    private static $actualisation_en_cours = false;
    private static $cache_db;
    private static $maj_droits_ajouter_en_cours = false;
    private static $maj_droits_modifier_en_cours = false;
    private static $maj_droits_supprimer_en_cours = false;
    private static $lock = [];

    public function __construct()
    {
        if (self::$initialisation) {
            include_once __DIR__ . '/../../erreurs/erreurs__vue_utilisateur.php';
            self::$initialisation = false;
            Hook_vue_utilisateur::initialisation();
            self::$cache_db = new Mf_Cachedb('vue_utilisateur');
        }
        if (! self::$actualisation_en_cours) {
            self::$actualisation_en_cours=true;
            Hook_vue_utilisateur::actualisation();
            self::$actualisation_en_cours=false;
        }
    }

    public static function mf_raz_instance()
    {
        self::$initialisation = true;
    }

    public static function initialiser_structure()
    {
        global $mf_initialisation;

        if (! test_si_table_existe(inst('vue_utilisateur'))) {
            executer_requete_mysql('CREATE TABLE '.inst('vue_utilisateur').'(Code_vue_utilisateur BIGINT UNSIGNED NOT NULL AUTO_INCREMENT, PRIMARY KEY (Code_vue_utilisateur)) ENGINE=MyISAM;', array_search('vue_utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        $liste_colonnes = lister_les_colonnes('vue_utilisateur');

        if (isset($liste_colonnes['vue_utilisateur_Recherche'])) {
            if (typeMyql2Sql($liste_colonnes['vue_utilisateur_Recherche']['Type'])!='VARCHAR') {
                executer_requete_mysql('ALTER TABLE '.inst('vue_utilisateur').' CHANGE vue_utilisateur_Recherche vue_utilisateur_Recherche VARCHAR(255);', array_search('vue_utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['vue_utilisateur_Recherche']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('vue_utilisateur').' ADD vue_utilisateur_Recherche VARCHAR(255);', array_search('vue_utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE '.inst('vue_utilisateur').' SET vue_utilisateur_Recherche=' . format_sql('vue_utilisateur_Recherche', $mf_initialisation['vue_utilisateur_Recherche']) . ';', array_search('vue_utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if (isset($liste_colonnes['vue_utilisateur_Filtre_Saison_Type'])) {
            if (typeMyql2Sql($liste_colonnes['vue_utilisateur_Filtre_Saison_Type']['Type'])!='INT') {
                executer_requete_mysql('ALTER TABLE '.inst('vue_utilisateur').' CHANGE vue_utilisateur_Filtre_Saison_Type vue_utilisateur_Filtre_Saison_Type INT;', array_search('vue_utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['vue_utilisateur_Filtre_Saison_Type']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('vue_utilisateur').' ADD vue_utilisateur_Filtre_Saison_Type INT;', array_search('vue_utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE '.inst('vue_utilisateur').' SET vue_utilisateur_Filtre_Saison_Type=' . format_sql('vue_utilisateur_Filtre_Saison_Type', $mf_initialisation['vue_utilisateur_Filtre_Saison_Type']) . ';', array_search('vue_utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if (isset($liste_colonnes['vue_utilisateur_Filtre_Couleur'])) {
            if (typeMyql2Sql($liste_colonnes['vue_utilisateur_Filtre_Couleur']['Type'])!='VARCHAR') {
                executer_requete_mysql('ALTER TABLE '.inst('vue_utilisateur').' CHANGE vue_utilisateur_Filtre_Couleur vue_utilisateur_Filtre_Couleur VARCHAR(255);', array_search('vue_utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['vue_utilisateur_Filtre_Couleur']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('vue_utilisateur').' ADD vue_utilisateur_Filtre_Couleur VARCHAR(255);', array_search('vue_utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE '.inst('vue_utilisateur').' SET vue_utilisateur_Filtre_Couleur=' . format_sql('vue_utilisateur_Filtre_Couleur', $mf_initialisation['vue_utilisateur_Filtre_Couleur']) . ';', array_search('vue_utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if (isset($liste_colonnes['vue_utilisateur_Filtre_Taille_Pays_Type'])) {
            if (typeMyql2Sql($liste_colonnes['vue_utilisateur_Filtre_Taille_Pays_Type']['Type'])!='INT') {
                executer_requete_mysql('ALTER TABLE '.inst('vue_utilisateur').' CHANGE vue_utilisateur_Filtre_Taille_Pays_Type vue_utilisateur_Filtre_Taille_Pays_Type INT;', array_search('vue_utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['vue_utilisateur_Filtre_Taille_Pays_Type']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('vue_utilisateur').' ADD vue_utilisateur_Filtre_Taille_Pays_Type INT;', array_search('vue_utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE '.inst('vue_utilisateur').' SET vue_utilisateur_Filtre_Taille_Pays_Type=' . format_sql('vue_utilisateur_Filtre_Taille_Pays_Type', $mf_initialisation['vue_utilisateur_Filtre_Taille_Pays_Type']) . ';', array_search('vue_utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if (isset($liste_colonnes['vue_utilisateur_Filtre_Taille_Max'])) {
            if (typeMyql2Sql($liste_colonnes['vue_utilisateur_Filtre_Taille_Max']['Type'])!='INT') {
                executer_requete_mysql('ALTER TABLE '.inst('vue_utilisateur').' CHANGE vue_utilisateur_Filtre_Taille_Max vue_utilisateur_Filtre_Taille_Max INT;', array_search('vue_utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['vue_utilisateur_Filtre_Taille_Max']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('vue_utilisateur').' ADD vue_utilisateur_Filtre_Taille_Max INT;', array_search('vue_utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE '.inst('vue_utilisateur').' SET vue_utilisateur_Filtre_Taille_Max=' . format_sql('vue_utilisateur_Filtre_Taille_Max', $mf_initialisation['vue_utilisateur_Filtre_Taille_Max']) . ';', array_search('vue_utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if (isset($liste_colonnes['vue_utilisateur_Filtre_Taille_Min'])) {
            if (typeMyql2Sql($liste_colonnes['vue_utilisateur_Filtre_Taille_Min']['Type'])!='INT') {
                executer_requete_mysql('ALTER TABLE '.inst('vue_utilisateur').' CHANGE vue_utilisateur_Filtre_Taille_Min vue_utilisateur_Filtre_Taille_Min INT;', array_search('vue_utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['vue_utilisateur_Filtre_Taille_Min']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('vue_utilisateur').' ADD vue_utilisateur_Filtre_Taille_Min INT;', array_search('vue_utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE '.inst('vue_utilisateur').' SET vue_utilisateur_Filtre_Taille_Min=' . format_sql('vue_utilisateur_Filtre_Taille_Min', $mf_initialisation['vue_utilisateur_Filtre_Taille_Min']) . ';', array_search('vue_utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        $liste_colonnes_a_indexer = [];

        if (isset($liste_colonnes['mf_signature'])) {
            unset($liste_colonnes['mf_signature']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('vue_utilisateur').' ADD mf_signature VARCHAR(255);', array_search('vue_utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }
        $liste_colonnes_a_indexer['mf_signature'] = 'mf_signature';

        if (isset($liste_colonnes['mf_cle_unique'])) {
            unset($liste_colonnes['mf_cle_unique']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('vue_utilisateur').' ADD mf_cle_unique VARCHAR(255);', array_search('vue_utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }
        $liste_colonnes_a_indexer['mf_cle_unique'] = 'mf_cle_unique';

        if (isset($liste_colonnes['mf_date_creation'])) {
            unset($liste_colonnes['mf_date_creation']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('vue_utilisateur').' ADD mf_date_creation DATETIME;', array_search('vue_utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }
        $liste_colonnes_a_indexer['mf_date_creation'] = 'mf_date_creation';

        if (isset($liste_colonnes['mf_date_modification'])) {
            unset($liste_colonnes['mf_date_modification']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('vue_utilisateur').' ADD mf_date_modification DATETIME;', array_search('vue_utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }
        $liste_colonnes_a_indexer['mf_date_modification'] = 'mf_date_modification';

        unset($liste_colonnes['Code_vue_utilisateur']);

        foreach ($liste_colonnes as $field => $value) {
            executer_requete_mysql('ALTER TABLE '.inst('vue_utilisateur').' DROP COLUMN '.$field.';', array_search('vue_utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `' . inst('vue_utilisateur') . '`;', false);
        $mf_liste_requete_index = [];
        while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
            $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
        }
        mysqli_free_result($res_requete_index);
        foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
            if (isset($liste_colonnes_a_indexer[$mf_colonne_indexee])) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
        }
        foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
            executer_requete_mysql('ALTER TABLE `' . inst('vue_utilisateur') . '` ADD INDEX(`' . $colonnes_a_indexer . '`);', array_search('vue_utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }
    }

    /**
     * Retourne la tructure de la table « vue_utilisateur » avec les valeurs initialisées par défaut.
     * @return array
     */
    public function mf_get_structure(): array
    {
        global $mf_initialisation;
        $struc = [
            'Code_vue_utilisateur' => null, // ID
            'vue_utilisateur_Recherche' => $mf_initialisation['vue_utilisateur_Recherche'],
            'vue_utilisateur_Filtre_Saison_Type' => $mf_initialisation['vue_utilisateur_Filtre_Saison_Type'],
            'vue_utilisateur_Filtre_Couleur' => $mf_initialisation['vue_utilisateur_Filtre_Couleur'],
            'vue_utilisateur_Filtre_Taille_Pays_Type' => $mf_initialisation['vue_utilisateur_Filtre_Taille_Pays_Type'],
            'vue_utilisateur_Filtre_Taille_Max' => $mf_initialisation['vue_utilisateur_Filtre_Taille_Max'],
            'vue_utilisateur_Filtre_Taille_Min' => $mf_initialisation['vue_utilisateur_Filtre_Taille_Min'],
        ];
        mf_formatage_db_type_php($struc);
        Hook_vue_utilisateur::pre_controller($struc['vue_utilisateur_Recherche'], $struc['vue_utilisateur_Filtre_Saison_Type'], $struc['vue_utilisateur_Filtre_Couleur'], $struc['vue_utilisateur_Filtre_Taille_Pays_Type'], $struc['vue_utilisateur_Filtre_Taille_Max'], $struc['vue_utilisateur_Filtre_Taille_Min'], $struc['Code_vue_utilisateur']);
        return $struc;
    }

    public function mf_ajouter(string $vue_utilisateur_Recherche, ?int $vue_utilisateur_Filtre_Saison_Type, string $vue_utilisateur_Filtre_Couleur, ?int $vue_utilisateur_Filtre_Taille_Pays_Type, ?int $vue_utilisateur_Filtre_Taille_Max, ?int $vue_utilisateur_Filtre_Taille_Min, ?bool $force = false)
    {
        if ($force === null) {
            $force = false;
        }
        $Code_vue_utilisateur = 0;
        $code_erreur = 0;
        // Typage
        $vue_utilisateur_Recherche = (string) $vue_utilisateur_Recherche;
        $vue_utilisateur_Filtre_Saison_Type = is_null($vue_utilisateur_Filtre_Saison_Type) || $vue_utilisateur_Filtre_Saison_Type === '' ? null : (int) $vue_utilisateur_Filtre_Saison_Type;
        $vue_utilisateur_Filtre_Couleur = (string) $vue_utilisateur_Filtre_Couleur;
        $vue_utilisateur_Filtre_Taille_Pays_Type = is_null($vue_utilisateur_Filtre_Taille_Pays_Type) || $vue_utilisateur_Filtre_Taille_Pays_Type === '' ? null : (int) $vue_utilisateur_Filtre_Taille_Pays_Type;
        $vue_utilisateur_Filtre_Taille_Max = is_null($vue_utilisateur_Filtre_Taille_Max) || $vue_utilisateur_Filtre_Taille_Max === '' ? null : (int) $vue_utilisateur_Filtre_Taille_Max;
        $vue_utilisateur_Filtre_Taille_Min = is_null($vue_utilisateur_Filtre_Taille_Min) || $vue_utilisateur_Filtre_Taille_Min === '' ? null : (int) $vue_utilisateur_Filtre_Taille_Min;
        // Fin typage
        Hook_vue_utilisateur::pre_controller($vue_utilisateur_Recherche, $vue_utilisateur_Filtre_Saison_Type, $vue_utilisateur_Filtre_Couleur, $vue_utilisateur_Filtre_Taille_Pays_Type, $vue_utilisateur_Filtre_Taille_Max, $vue_utilisateur_Filtre_Taille_Min);
        if (! $force) {
            if (! self::$maj_droits_ajouter_en_cours) {
                self::$maj_droits_ajouter_en_cours = true;
                Hook_vue_utilisateur::hook_actualiser_les_droits_ajouter();
                self::$maj_droits_ajouter_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['vue_utilisateur__AJOUTER']) ) $code_erreur = REFUS_VUE_UTILISATEUR__AJOUTER;
        elseif (! Hook_vue_utilisateur::autorisation_ajout($vue_utilisateur_Recherche, $vue_utilisateur_Filtre_Saison_Type, $vue_utilisateur_Filtre_Couleur, $vue_utilisateur_Filtre_Taille_Pays_Type, $vue_utilisateur_Filtre_Taille_Max, $vue_utilisateur_Filtre_Taille_Min) ) $code_erreur = REFUS_VUE_UTILISATEUR__AJOUT_BLOQUEE;
        elseif (! controle_parametre("vue_utilisateur_Filtre_Saison_Type", $vue_utilisateur_Filtre_Saison_Type) ) $code_erreur = ERR_VUE_UTILISATEUR__AJOUTER__VUE_UTILISATEUR_FILTRE_SAISON_TYPE_NON_VALIDE;
        elseif (! controle_parametre("vue_utilisateur_Filtre_Taille_Pays_Type", $vue_utilisateur_Filtre_Taille_Pays_Type) ) $code_erreur = ERR_VUE_UTILISATEUR__AJOUTER__VUE_UTILISATEUR_FILTRE_TAILLE_PAYS_TYPE_NON_VALIDE;
        else {
            Hook_vue_utilisateur::data_controller($vue_utilisateur_Recherche, $vue_utilisateur_Filtre_Saison_Type, $vue_utilisateur_Filtre_Couleur, $vue_utilisateur_Filtre_Taille_Pays_Type, $vue_utilisateur_Filtre_Taille_Max, $vue_utilisateur_Filtre_Taille_Min);
            $mf_signature = text_sql(Hook_vue_utilisateur::calcul_signature($vue_utilisateur_Recherche, $vue_utilisateur_Filtre_Saison_Type, $vue_utilisateur_Filtre_Couleur, $vue_utilisateur_Filtre_Taille_Pays_Type, $vue_utilisateur_Filtre_Taille_Max, $vue_utilisateur_Filtre_Taille_Min));
            $mf_cle_unique = text_sql(Hook_vue_utilisateur::calcul_cle_unique($vue_utilisateur_Recherche, $vue_utilisateur_Filtre_Saison_Type, $vue_utilisateur_Filtre_Couleur, $vue_utilisateur_Filtre_Taille_Pays_Type, $vue_utilisateur_Filtre_Taille_Max, $vue_utilisateur_Filtre_Taille_Min));
            $vue_utilisateur_Recherche = text_sql($vue_utilisateur_Recherche);
            $vue_utilisateur_Filtre_Saison_Type = is_null($vue_utilisateur_Filtre_Saison_Type) ? 'NULL' : (int) $vue_utilisateur_Filtre_Saison_Type;
            $vue_utilisateur_Filtre_Couleur = text_sql($vue_utilisateur_Filtre_Couleur);
            $vue_utilisateur_Filtre_Taille_Pays_Type = is_null($vue_utilisateur_Filtre_Taille_Pays_Type) ? 'NULL' : (int) $vue_utilisateur_Filtre_Taille_Pays_Type;
            $vue_utilisateur_Filtre_Taille_Max = is_null($vue_utilisateur_Filtre_Taille_Max) ? 'NULL' : (int) $vue_utilisateur_Filtre_Taille_Max;
            $vue_utilisateur_Filtre_Taille_Min = is_null($vue_utilisateur_Filtre_Taille_Min) ? 'NULL' : (int) $vue_utilisateur_Filtre_Taille_Min;
            $requete = "INSERT INTO " . inst('vue_utilisateur') . " ( mf_signature, mf_cle_unique, mf_date_creation, mf_date_modification, vue_utilisateur_Recherche, vue_utilisateur_Filtre_Saison_Type, vue_utilisateur_Filtre_Couleur, vue_utilisateur_Filtre_Taille_Pays_Type, vue_utilisateur_Filtre_Taille_Max, vue_utilisateur_Filtre_Taille_Min ) VALUES ( '$mf_signature', '$mf_cle_unique', '".get_now()."', '".get_now()."', '$vue_utilisateur_Recherche', $vue_utilisateur_Filtre_Saison_Type, '$vue_utilisateur_Filtre_Couleur', $vue_utilisateur_Filtre_Taille_Pays_Type, $vue_utilisateur_Filtre_Taille_Max, $vue_utilisateur_Filtre_Taille_Min );";
            executer_requete_mysql($requete, array_search('vue_utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            $Code_vue_utilisateur = requete_mysql_insert_id();
            if ($Code_vue_utilisateur == 0) {
                $code_erreur = ERR_VUE_UTILISATEUR__AJOUTER__AJOUT_REFUSE;
            } else {
                self::$cache_db->clear();
                Hook_vue_utilisateur::ajouter( $Code_vue_utilisateur );
            }
        }
        if ($code_erreur != 0) {
            global $mf_message_erreur_personalise, $mf_libelle_erreur;
            if ($mf_message_erreur_personalise != '') {
                $mf_libelle_erreur[$code_erreur] = $mf_message_erreur_personalise;
                $mf_message_erreur_personalise = '';
            }
        }
        return ['code_erreur' => $code_erreur, 'Code_vue_utilisateur' => $Code_vue_utilisateur, 'callback' => ( $code_erreur==0 ? Hook_vue_utilisateur::callback_post($Code_vue_utilisateur) : null )];
    }

    public function mf_creer(?bool $force = null)
    {
        if ($force === null) {
            $force = false;
        }
        global $mf_initialisation;
        $vue_utilisateur_Recherche = $mf_initialisation['vue_utilisateur_Recherche'];
        $vue_utilisateur_Filtre_Saison_Type = $mf_initialisation['vue_utilisateur_Filtre_Saison_Type'];
        $vue_utilisateur_Filtre_Couleur = $mf_initialisation['vue_utilisateur_Filtre_Couleur'];
        $vue_utilisateur_Filtre_Taille_Pays_Type = $mf_initialisation['vue_utilisateur_Filtre_Taille_Pays_Type'];
        $vue_utilisateur_Filtre_Taille_Max = $mf_initialisation['vue_utilisateur_Filtre_Taille_Max'];
        $vue_utilisateur_Filtre_Taille_Min = $mf_initialisation['vue_utilisateur_Filtre_Taille_Min'];
        // Typage
        $vue_utilisateur_Recherche = (string) $vue_utilisateur_Recherche;
        $vue_utilisateur_Filtre_Saison_Type = is_null($vue_utilisateur_Filtre_Saison_Type) || $vue_utilisateur_Filtre_Saison_Type === '' ? null : (int) $vue_utilisateur_Filtre_Saison_Type;
        $vue_utilisateur_Filtre_Couleur = (string) $vue_utilisateur_Filtre_Couleur;
        $vue_utilisateur_Filtre_Taille_Pays_Type = is_null($vue_utilisateur_Filtre_Taille_Pays_Type) || $vue_utilisateur_Filtre_Taille_Pays_Type === '' ? null : (int) $vue_utilisateur_Filtre_Taille_Pays_Type;
        $vue_utilisateur_Filtre_Taille_Max = is_null($vue_utilisateur_Filtre_Taille_Max) || $vue_utilisateur_Filtre_Taille_Max === '' ? null : (int) $vue_utilisateur_Filtre_Taille_Max;
        $vue_utilisateur_Filtre_Taille_Min = is_null($vue_utilisateur_Filtre_Taille_Min) || $vue_utilisateur_Filtre_Taille_Min === '' ? null : (int) $vue_utilisateur_Filtre_Taille_Min;
        // Fin typage
        return $this->mf_ajouter($vue_utilisateur_Recherche, $vue_utilisateur_Filtre_Saison_Type, $vue_utilisateur_Filtre_Couleur, $vue_utilisateur_Filtre_Taille_Pays_Type, $vue_utilisateur_Filtre_Taille_Max, $vue_utilisateur_Filtre_Taille_Min, $force);
    }

    public function mf_ajouter_2(array $ligne, bool $force = null) // array('colonne1' => 'valeur1',  [...] )
    {
        if ($force === null) {
            $force = false;
        }
        global $mf_initialisation;
        $vue_utilisateur_Recherche = (isset($ligne['vue_utilisateur_Recherche'])?$ligne['vue_utilisateur_Recherche']:$mf_initialisation['vue_utilisateur_Recherche']);
        $vue_utilisateur_Filtre_Saison_Type = (isset($ligne['vue_utilisateur_Filtre_Saison_Type'])?$ligne['vue_utilisateur_Filtre_Saison_Type']:$mf_initialisation['vue_utilisateur_Filtre_Saison_Type']);
        $vue_utilisateur_Filtre_Couleur = (isset($ligne['vue_utilisateur_Filtre_Couleur'])?$ligne['vue_utilisateur_Filtre_Couleur']:$mf_initialisation['vue_utilisateur_Filtre_Couleur']);
        $vue_utilisateur_Filtre_Taille_Pays_Type = (isset($ligne['vue_utilisateur_Filtre_Taille_Pays_Type'])?$ligne['vue_utilisateur_Filtre_Taille_Pays_Type']:$mf_initialisation['vue_utilisateur_Filtre_Taille_Pays_Type']);
        $vue_utilisateur_Filtre_Taille_Max = (isset($ligne['vue_utilisateur_Filtre_Taille_Max'])?$ligne['vue_utilisateur_Filtre_Taille_Max']:$mf_initialisation['vue_utilisateur_Filtre_Taille_Max']);
        $vue_utilisateur_Filtre_Taille_Min = (isset($ligne['vue_utilisateur_Filtre_Taille_Min'])?$ligne['vue_utilisateur_Filtre_Taille_Min']:$mf_initialisation['vue_utilisateur_Filtre_Taille_Min']);
        // Typage
        $vue_utilisateur_Recherche = (string) $vue_utilisateur_Recherche;
        $vue_utilisateur_Filtre_Saison_Type = is_null($vue_utilisateur_Filtre_Saison_Type) || $vue_utilisateur_Filtre_Saison_Type === '' ? null : (int) $vue_utilisateur_Filtre_Saison_Type;
        $vue_utilisateur_Filtre_Couleur = (string) $vue_utilisateur_Filtre_Couleur;
        $vue_utilisateur_Filtre_Taille_Pays_Type = is_null($vue_utilisateur_Filtre_Taille_Pays_Type) || $vue_utilisateur_Filtre_Taille_Pays_Type === '' ? null : (int) $vue_utilisateur_Filtre_Taille_Pays_Type;
        $vue_utilisateur_Filtre_Taille_Max = is_null($vue_utilisateur_Filtre_Taille_Max) || $vue_utilisateur_Filtre_Taille_Max === '' ? null : (int) $vue_utilisateur_Filtre_Taille_Max;
        $vue_utilisateur_Filtre_Taille_Min = is_null($vue_utilisateur_Filtre_Taille_Min) || $vue_utilisateur_Filtre_Taille_Min === '' ? null : (int) $vue_utilisateur_Filtre_Taille_Min;
        // Fin typage
        return $this->mf_ajouter($vue_utilisateur_Recherche, $vue_utilisateur_Filtre_Saison_Type, $vue_utilisateur_Filtre_Couleur, $vue_utilisateur_Filtre_Taille_Pays_Type, $vue_utilisateur_Filtre_Taille_Max, $vue_utilisateur_Filtre_Taille_Min, $force);
    }

    public function mf_ajouter_3(array $lignes) // array( array( 'colonne1' => 'valeur1', 'colonne2' => 'valeur2',  [...] ), [...] )
    {
        global $mf_initialisation;
        $code_erreur = 0;
        $values = '';
        foreach ($lignes as $ligne) {
            $vue_utilisateur_Recherche = text_sql((isset($ligne['vue_utilisateur_Recherche']) ? $ligne['vue_utilisateur_Recherche'] : $mf_initialisation['vue_utilisateur_Recherche']));
            $vue_utilisateur_Filtre_Saison_Type = is_null((isset($ligne['vue_utilisateur_Filtre_Saison_Type']) ? $ligne['vue_utilisateur_Filtre_Saison_Type'] : $mf_initialisation['vue_utilisateur_Filtre_Saison_Type'])) ? 'NULL' : (int) (isset($ligne['vue_utilisateur_Filtre_Saison_Type']) ? $ligne['vue_utilisateur_Filtre_Saison_Type'] : $mf_initialisation['vue_utilisateur_Filtre_Saison_Type']);
            $vue_utilisateur_Filtre_Couleur = text_sql((isset($ligne['vue_utilisateur_Filtre_Couleur']) ? $ligne['vue_utilisateur_Filtre_Couleur'] : $mf_initialisation['vue_utilisateur_Filtre_Couleur']));
            $vue_utilisateur_Filtre_Taille_Pays_Type = is_null((isset($ligne['vue_utilisateur_Filtre_Taille_Pays_Type']) ? $ligne['vue_utilisateur_Filtre_Taille_Pays_Type'] : $mf_initialisation['vue_utilisateur_Filtre_Taille_Pays_Type'])) ? 'NULL' : (int) (isset($ligne['vue_utilisateur_Filtre_Taille_Pays_Type']) ? $ligne['vue_utilisateur_Filtre_Taille_Pays_Type'] : $mf_initialisation['vue_utilisateur_Filtre_Taille_Pays_Type']);
            $vue_utilisateur_Filtre_Taille_Max = is_null((isset($ligne['vue_utilisateur_Filtre_Taille_Max']) ? $ligne['vue_utilisateur_Filtre_Taille_Max'] : $mf_initialisation['vue_utilisateur_Filtre_Taille_Max'])) ? 'NULL' : (int) (isset($ligne['vue_utilisateur_Filtre_Taille_Max']) ? $ligne['vue_utilisateur_Filtre_Taille_Max'] : $mf_initialisation['vue_utilisateur_Filtre_Taille_Max']);
            $vue_utilisateur_Filtre_Taille_Min = is_null((isset($ligne['vue_utilisateur_Filtre_Taille_Min']) ? $ligne['vue_utilisateur_Filtre_Taille_Min'] : $mf_initialisation['vue_utilisateur_Filtre_Taille_Min'])) ? 'NULL' : (int) (isset($ligne['vue_utilisateur_Filtre_Taille_Min']) ? $ligne['vue_utilisateur_Filtre_Taille_Min'] : $mf_initialisation['vue_utilisateur_Filtre_Taille_Min']);
            $values .= ($values != '' ? ',' : '') . "('$vue_utilisateur_Recherche', $vue_utilisateur_Filtre_Saison_Type, '$vue_utilisateur_Filtre_Couleur', $vue_utilisateur_Filtre_Taille_Pays_Type, $vue_utilisateur_Filtre_Taille_Max, $vue_utilisateur_Filtre_Taille_Min)";
        }
        if ($values != '') {
            $requete = "INSERT INTO " . inst('vue_utilisateur') . " ( vue_utilisateur_Recherche, vue_utilisateur_Filtre_Saison_Type, vue_utilisateur_Filtre_Couleur, vue_utilisateur_Filtre_Taille_Pays_Type, vue_utilisateur_Filtre_Taille_Max, vue_utilisateur_Filtre_Taille_Min ) VALUES $values;";
            executer_requete_mysql( $requete , array_search('vue_utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            $n = requete_mysqli_affected_rows();
            if ($n < count($lignes)) {
                $code_erreur = ERR_VUE_UTILISATEUR__AJOUTER_3__ECHEC_AJOUT;
            }
            if ($n > 0) {
                self::$cache_db->clear();
            }
        }
        if ($code_erreur != 0) {
            global $mf_message_erreur_personalise, $mf_libelle_erreur;
            if ($mf_message_erreur_personalise != '') {
                $mf_libelle_erreur[$code_erreur] = $mf_message_erreur_personalise;
                $mf_message_erreur_personalise = '';
            }
        }
        return ['code_erreur' => $code_erreur];
    }

    public function mf_actualiser_signature(int $Code_vue_utilisateur)
    {
        $vue_utilisateur = $this->mf_get_2($Code_vue_utilisateur, ['autocompletion' => false]);
        $mf_signature = text_sql(Hook_vue_utilisateur::calcul_signature($vue_utilisateur['vue_utilisateur_Recherche'], $vue_utilisateur['vue_utilisateur_Filtre_Saison_Type'], $vue_utilisateur['vue_utilisateur_Filtre_Couleur'], $vue_utilisateur['vue_utilisateur_Filtre_Taille_Pays_Type'], $vue_utilisateur['vue_utilisateur_Filtre_Taille_Max'], $vue_utilisateur['vue_utilisateur_Filtre_Taille_Min']));
        $mf_cle_unique = text_sql(Hook_vue_utilisateur::calcul_cle_unique($vue_utilisateur['vue_utilisateur_Recherche'], $vue_utilisateur['vue_utilisateur_Filtre_Saison_Type'], $vue_utilisateur['vue_utilisateur_Filtre_Couleur'], $vue_utilisateur['vue_utilisateur_Filtre_Taille_Pays_Type'], $vue_utilisateur['vue_utilisateur_Filtre_Taille_Max'], $vue_utilisateur['vue_utilisateur_Filtre_Taille_Min']));
        $table = inst('vue_utilisateur');
        executer_requete_mysql("UPDATE $table SET mf_signature='$mf_signature', mf_cle_unique='$mf_cle_unique' WHERE Code_vue_utilisateur=$Code_vue_utilisateur;", array_search('vue_utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        if (requete_mysqli_affected_rows() == 1) {
            self::$cache_db->clear();
        }
    }

    public function mf_modifier( int $Code_vue_utilisateur, string $vue_utilisateur_Recherche, ?int $vue_utilisateur_Filtre_Saison_Type, string $vue_utilisateur_Filtre_Couleur, ?int $vue_utilisateur_Filtre_Taille_Pays_Type, ?int $vue_utilisateur_Filtre_Taille_Max, ?int $vue_utilisateur_Filtre_Taille_Min, ?bool $force = null)
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        // Typage
        $vue_utilisateur_Recherche = (string) $vue_utilisateur_Recherche;
        $vue_utilisateur_Filtre_Saison_Type = is_null($vue_utilisateur_Filtre_Saison_Type) || $vue_utilisateur_Filtre_Saison_Type === '' ? null : (int) $vue_utilisateur_Filtre_Saison_Type;
        $vue_utilisateur_Filtre_Couleur = (string) $vue_utilisateur_Filtre_Couleur;
        $vue_utilisateur_Filtre_Taille_Pays_Type = is_null($vue_utilisateur_Filtre_Taille_Pays_Type) || $vue_utilisateur_Filtre_Taille_Pays_Type === '' ? null : (int) $vue_utilisateur_Filtre_Taille_Pays_Type;
        $vue_utilisateur_Filtre_Taille_Max = is_null($vue_utilisateur_Filtre_Taille_Max) || $vue_utilisateur_Filtre_Taille_Max === '' ? null : (int) $vue_utilisateur_Filtre_Taille_Max;
        $vue_utilisateur_Filtre_Taille_Min = is_null($vue_utilisateur_Filtre_Taille_Min) || $vue_utilisateur_Filtre_Taille_Min === '' ? null : (int) $vue_utilisateur_Filtre_Taille_Min;
        // Fin typage
        Hook_vue_utilisateur::pre_controller($vue_utilisateur_Recherche, $vue_utilisateur_Filtre_Saison_Type, $vue_utilisateur_Filtre_Couleur, $vue_utilisateur_Filtre_Taille_Pays_Type, $vue_utilisateur_Filtre_Taille_Max, $vue_utilisateur_Filtre_Taille_Min, $Code_vue_utilisateur);
        if (! $force) {
            if (! self::$maj_droits_modifier_en_cours) {
                self::$maj_droits_modifier_en_cours = true;
                Hook_vue_utilisateur::hook_actualiser_les_droits_modifier($Code_vue_utilisateur);
                self::$maj_droits_modifier_en_cours = false;
            }
        }
        $vue_utilisateur = $this->mf_get_2( $Code_vue_utilisateur, ['autocompletion' => false, 'masquer_mdp' => false]);
        if ( !$force && !mf_matrice_droits(['vue_utilisateur__MODIFIER']) ) $code_erreur = REFUS_VUE_UTILISATEUR__MODIFIER;
        elseif (! $this->mf_tester_existance_Code_vue_utilisateur($Code_vue_utilisateur)) $code_erreur = ERR_VUE_UTILISATEUR__MODIFIER__CODE_VUE_UTILISATEUR_INEXISTANT;
        elseif (CONTROLE_ACCES_DONNEES_DEFAUT && ! Hook_mf_systeme::controle_acces_donnees('Code_vue_utilisateur', $Code_vue_utilisateur)) $code_erreur = ACCES_CODE_VUE_UTILISATEUR_REFUSE;
        elseif ( !Hook_vue_utilisateur::autorisation_modification($Code_vue_utilisateur, $vue_utilisateur_Recherche, $vue_utilisateur_Filtre_Saison_Type, $vue_utilisateur_Filtre_Couleur, $vue_utilisateur_Filtre_Taille_Pays_Type, $vue_utilisateur_Filtre_Taille_Max, $vue_utilisateur_Filtre_Taille_Min) ) $code_erreur = REFUS_VUE_UTILISATEUR__MODIFICATION_BLOQUEE;
        elseif (! in_array($vue_utilisateur_Filtre_Saison_Type, liste_union_A_et_B([$vue_utilisateur_Filtre_Saison_Type], Hook_vue_utilisateur::workflow__vue_utilisateur_Filtre_Saison_Type($vue_utilisateur['vue_utilisateur_Filtre_Saison_Type'])))) $code_erreur = ERR_VUE_UTILISATEUR__MODIFIER__VUE_UTILISATEUR_FILTRE_SAISON_TYPE__HORS_WORKFLOW;
        elseif (! controle_parametre("vue_utilisateur_Filtre_Saison_Type", $vue_utilisateur_Filtre_Saison_Type)) $code_erreur = ERR_VUE_UTILISATEUR__MODIFIER__VUE_UTILISATEUR_FILTRE_SAISON_TYPE_NON_VALIDE;
        elseif (! in_array($vue_utilisateur_Filtre_Taille_Pays_Type, liste_union_A_et_B([$vue_utilisateur_Filtre_Taille_Pays_Type], Hook_vue_utilisateur::workflow__vue_utilisateur_Filtre_Taille_Pays_Type($vue_utilisateur['vue_utilisateur_Filtre_Taille_Pays_Type'])))) $code_erreur = ERR_VUE_UTILISATEUR__MODIFIER__VUE_UTILISATEUR_FILTRE_TAILLE_PAYS_TYPE__HORS_WORKFLOW;
        elseif (! controle_parametre("vue_utilisateur_Filtre_Taille_Pays_Type", $vue_utilisateur_Filtre_Taille_Pays_Type)) $code_erreur = ERR_VUE_UTILISATEUR__MODIFIER__VUE_UTILISATEUR_FILTRE_TAILLE_PAYS_TYPE_NON_VALIDE;
        else {
            if (! isset(self::$lock[$Code_vue_utilisateur])) {
                self::$lock[$Code_vue_utilisateur] = 0;
            }
            if (self::$lock[$Code_vue_utilisateur] == 0) {
                self::$cache_db->add_lock((string) $Code_vue_utilisateur);
            }
            self::$lock[$Code_vue_utilisateur]++;
            Hook_vue_utilisateur::data_controller($vue_utilisateur_Recherche, $vue_utilisateur_Filtre_Saison_Type, $vue_utilisateur_Filtre_Couleur, $vue_utilisateur_Filtre_Taille_Pays_Type, $vue_utilisateur_Filtre_Taille_Max, $vue_utilisateur_Filtre_Taille_Min, $Code_vue_utilisateur);
            $mf_colonnes_a_modifier=[];
            $bool__vue_utilisateur_Recherche = false; if ($vue_utilisateur_Recherche !== $vue_utilisateur['vue_utilisateur_Recherche']) {Hook_vue_utilisateur::data_controller__vue_utilisateur_Recherche($vue_utilisateur['vue_utilisateur_Recherche'], $vue_utilisateur_Recherche, $Code_vue_utilisateur); if ( $vue_utilisateur_Recherche !== $vue_utilisateur['vue_utilisateur_Recherche'] ) { $mf_colonnes_a_modifier[] = 'vue_utilisateur_Recherche=' . format_sql('vue_utilisateur_Recherche', $vue_utilisateur_Recherche); $bool__vue_utilisateur_Recherche = true;}}
            $bool__vue_utilisateur_Filtre_Saison_Type = false; if ($vue_utilisateur_Filtre_Saison_Type !== $vue_utilisateur['vue_utilisateur_Filtre_Saison_Type']) {Hook_vue_utilisateur::data_controller__vue_utilisateur_Filtre_Saison_Type($vue_utilisateur['vue_utilisateur_Filtre_Saison_Type'], $vue_utilisateur_Filtre_Saison_Type, $Code_vue_utilisateur); if ( $vue_utilisateur_Filtre_Saison_Type !== $vue_utilisateur['vue_utilisateur_Filtre_Saison_Type'] ) { $mf_colonnes_a_modifier[] = 'vue_utilisateur_Filtre_Saison_Type=' . format_sql('vue_utilisateur_Filtre_Saison_Type', $vue_utilisateur_Filtre_Saison_Type); $bool__vue_utilisateur_Filtre_Saison_Type = true;}}
            $bool__vue_utilisateur_Filtre_Couleur = false; if ($vue_utilisateur_Filtre_Couleur !== $vue_utilisateur['vue_utilisateur_Filtre_Couleur']) {Hook_vue_utilisateur::data_controller__vue_utilisateur_Filtre_Couleur($vue_utilisateur['vue_utilisateur_Filtre_Couleur'], $vue_utilisateur_Filtre_Couleur, $Code_vue_utilisateur); if ( $vue_utilisateur_Filtre_Couleur !== $vue_utilisateur['vue_utilisateur_Filtre_Couleur'] ) { $mf_colonnes_a_modifier[] = 'vue_utilisateur_Filtre_Couleur=' . format_sql('vue_utilisateur_Filtre_Couleur', $vue_utilisateur_Filtre_Couleur); $bool__vue_utilisateur_Filtre_Couleur = true;}}
            $bool__vue_utilisateur_Filtre_Taille_Pays_Type = false; if ($vue_utilisateur_Filtre_Taille_Pays_Type !== $vue_utilisateur['vue_utilisateur_Filtre_Taille_Pays_Type']) {Hook_vue_utilisateur::data_controller__vue_utilisateur_Filtre_Taille_Pays_Type($vue_utilisateur['vue_utilisateur_Filtre_Taille_Pays_Type'], $vue_utilisateur_Filtre_Taille_Pays_Type, $Code_vue_utilisateur); if ( $vue_utilisateur_Filtre_Taille_Pays_Type !== $vue_utilisateur['vue_utilisateur_Filtre_Taille_Pays_Type'] ) { $mf_colonnes_a_modifier[] = 'vue_utilisateur_Filtre_Taille_Pays_Type=' . format_sql('vue_utilisateur_Filtre_Taille_Pays_Type', $vue_utilisateur_Filtre_Taille_Pays_Type); $bool__vue_utilisateur_Filtre_Taille_Pays_Type = true;}}
            $bool__vue_utilisateur_Filtre_Taille_Max = false; if ($vue_utilisateur_Filtre_Taille_Max !== $vue_utilisateur['vue_utilisateur_Filtre_Taille_Max']) {Hook_vue_utilisateur::data_controller__vue_utilisateur_Filtre_Taille_Max($vue_utilisateur['vue_utilisateur_Filtre_Taille_Max'], $vue_utilisateur_Filtre_Taille_Max, $Code_vue_utilisateur); if ( $vue_utilisateur_Filtre_Taille_Max !== $vue_utilisateur['vue_utilisateur_Filtre_Taille_Max'] ) { $mf_colonnes_a_modifier[] = 'vue_utilisateur_Filtre_Taille_Max=' . format_sql('vue_utilisateur_Filtre_Taille_Max', $vue_utilisateur_Filtre_Taille_Max); $bool__vue_utilisateur_Filtre_Taille_Max = true;}}
            $bool__vue_utilisateur_Filtre_Taille_Min = false; if ($vue_utilisateur_Filtre_Taille_Min !== $vue_utilisateur['vue_utilisateur_Filtre_Taille_Min']) {Hook_vue_utilisateur::data_controller__vue_utilisateur_Filtre_Taille_Min($vue_utilisateur['vue_utilisateur_Filtre_Taille_Min'], $vue_utilisateur_Filtre_Taille_Min, $Code_vue_utilisateur); if ( $vue_utilisateur_Filtre_Taille_Min !== $vue_utilisateur['vue_utilisateur_Filtre_Taille_Min'] ) { $mf_colonnes_a_modifier[] = 'vue_utilisateur_Filtre_Taille_Min=' . format_sql('vue_utilisateur_Filtre_Taille_Min', $vue_utilisateur_Filtre_Taille_Min); $bool__vue_utilisateur_Filtre_Taille_Min = true;}}
            if (count($mf_colonnes_a_modifier) > 0) {
                $mf_signature = text_sql(Hook_vue_utilisateur::calcul_signature($vue_utilisateur_Recherche, $vue_utilisateur_Filtre_Saison_Type, $vue_utilisateur_Filtre_Couleur, $vue_utilisateur_Filtre_Taille_Pays_Type, $vue_utilisateur_Filtre_Taille_Max, $vue_utilisateur_Filtre_Taille_Min));
                $mf_cle_unique = text_sql(Hook_vue_utilisateur::calcul_cle_unique($vue_utilisateur_Recherche, $vue_utilisateur_Filtre_Saison_Type, $vue_utilisateur_Filtre_Couleur, $vue_utilisateur_Filtre_Taille_Pays_Type, $vue_utilisateur_Filtre_Taille_Max, $vue_utilisateur_Filtre_Taille_Min));
                $mf_colonnes_a_modifier[] = 'mf_signature=\'' . $mf_signature . '\'';
                $mf_colonnes_a_modifier[] = 'mf_cle_unique=\'' . $mf_cle_unique . '\'';
                $mf_colonnes_a_modifier[] = 'mf_date_modification=\'' . get_now() . '\'';
                $requete = 'UPDATE '.inst('vue_utilisateur').' SET ' . enumeration($mf_colonnes_a_modifier) . ' WHERE Code_vue_utilisateur = ' . $Code_vue_utilisateur . ';';
                executer_requete_mysql($requete, array_search('vue_utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
                if (requete_mysqli_affected_rows() == 0) {
                    $code_erreur = ERR_VUE_UTILISATEUR__MODIFIER__AUCUN_CHANGEMENT;
                } else {
                    self::$cache_db->clear();
                    Hook_vue_utilisateur::modifier($Code_vue_utilisateur, $bool__vue_utilisateur_Recherche, $bool__vue_utilisateur_Filtre_Saison_Type, $bool__vue_utilisateur_Filtre_Couleur, $bool__vue_utilisateur_Filtre_Taille_Pays_Type, $bool__vue_utilisateur_Filtre_Taille_Max, $bool__vue_utilisateur_Filtre_Taille_Min);
                }
            } else {
                $code_erreur = ERR_VUE_UTILISATEUR__MODIFIER__AUCUN_CHANGEMENT;
            }
            self::$lock[$Code_vue_utilisateur]--;
            if (self::$lock[$Code_vue_utilisateur] == 0) {
                self::$cache_db->release_lock((string) $Code_vue_utilisateur);
                unset(self::$lock[$Code_vue_utilisateur]);
            }
        }
        if ($code_erreur != 0) {
            global $mf_message_erreur_personalise, $mf_libelle_erreur;
            if ($mf_message_erreur_personalise != '') {
                $mf_libelle_erreur[$code_erreur] = $mf_message_erreur_personalise;
                $mf_message_erreur_personalise = '';
            }
        }
        return ['code_erreur' => $code_erreur, 'callback' => ($code_erreur == 0 ? Hook_vue_utilisateur::callback_put($Code_vue_utilisateur) : null)];
    }

    public function mf_modifier_2(array $lignes, ?bool $force = null) // array( $Code_vue_utilisateur => array('colonne1' => 'valeur1',  [...] ) )
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        foreach ($lignes as $Code_vue_utilisateur => $colonnes) {
            if ($code_erreur == 0) {
                $Code_vue_utilisateur = intval($Code_vue_utilisateur);
                $vue_utilisateur = $this->mf_get_2($Code_vue_utilisateur, ['autocompletion' => false]);
                if (! $force) {
                    if (! self::$maj_droits_modifier_en_cours) {
                        self::$maj_droits_modifier_en_cours = true;
                        Hook_vue_utilisateur::hook_actualiser_les_droits_modifier($Code_vue_utilisateur);
                        self::$maj_droits_modifier_en_cours = false;
                    }
                }
                $vue_utilisateur_Recherche = (isset($colonnes['vue_utilisateur_Recherche']) && ( $force || mf_matrice_droits(['api_modifier__vue_utilisateur_Recherche', 'vue_utilisateur__MODIFIER']) ) ? $colonnes['vue_utilisateur_Recherche'] : ( isset($vue_utilisateur['vue_utilisateur_Recherche']) ? $vue_utilisateur['vue_utilisateur_Recherche'] : '' ) );
                $vue_utilisateur_Filtre_Saison_Type = (isset($colonnes['vue_utilisateur_Filtre_Saison_Type']) && ( $force || mf_matrice_droits(['api_modifier__vue_utilisateur_Filtre_Saison_Type', 'vue_utilisateur__MODIFIER']) ) ? $colonnes['vue_utilisateur_Filtre_Saison_Type'] : ( isset($vue_utilisateur['vue_utilisateur_Filtre_Saison_Type']) ? $vue_utilisateur['vue_utilisateur_Filtre_Saison_Type'] : '' ) );
                $vue_utilisateur_Filtre_Couleur = (isset($colonnes['vue_utilisateur_Filtre_Couleur']) && ( $force || mf_matrice_droits(['api_modifier__vue_utilisateur_Filtre_Couleur', 'vue_utilisateur__MODIFIER']) ) ? $colonnes['vue_utilisateur_Filtre_Couleur'] : ( isset($vue_utilisateur['vue_utilisateur_Filtre_Couleur']) ? $vue_utilisateur['vue_utilisateur_Filtre_Couleur'] : '' ) );
                $vue_utilisateur_Filtre_Taille_Pays_Type = (isset($colonnes['vue_utilisateur_Filtre_Taille_Pays_Type']) && ( $force || mf_matrice_droits(['api_modifier__vue_utilisateur_Filtre_Taille_Pays_Type', 'vue_utilisateur__MODIFIER']) ) ? $colonnes['vue_utilisateur_Filtre_Taille_Pays_Type'] : ( isset($vue_utilisateur['vue_utilisateur_Filtre_Taille_Pays_Type']) ? $vue_utilisateur['vue_utilisateur_Filtre_Taille_Pays_Type'] : '' ) );
                $vue_utilisateur_Filtre_Taille_Max = (isset($colonnes['vue_utilisateur_Filtre_Taille_Max']) && ( $force || mf_matrice_droits(['api_modifier__vue_utilisateur_Filtre_Taille_Max', 'vue_utilisateur__MODIFIER']) ) ? $colonnes['vue_utilisateur_Filtre_Taille_Max'] : ( isset($vue_utilisateur['vue_utilisateur_Filtre_Taille_Max']) ? $vue_utilisateur['vue_utilisateur_Filtre_Taille_Max'] : '' ) );
                $vue_utilisateur_Filtre_Taille_Min = (isset($colonnes['vue_utilisateur_Filtre_Taille_Min']) && ( $force || mf_matrice_droits(['api_modifier__vue_utilisateur_Filtre_Taille_Min', 'vue_utilisateur__MODIFIER']) ) ? $colonnes['vue_utilisateur_Filtre_Taille_Min'] : ( isset($vue_utilisateur['vue_utilisateur_Filtre_Taille_Min']) ? $vue_utilisateur['vue_utilisateur_Filtre_Taille_Min'] : '' ) );
                // Typage
                $vue_utilisateur_Recherche = (string) $vue_utilisateur_Recherche;
                $vue_utilisateur_Filtre_Saison_Type = is_null($vue_utilisateur_Filtre_Saison_Type) || $vue_utilisateur_Filtre_Saison_Type === '' ? null : (int) $vue_utilisateur_Filtre_Saison_Type;
                $vue_utilisateur_Filtre_Couleur = (string) $vue_utilisateur_Filtre_Couleur;
                $vue_utilisateur_Filtre_Taille_Pays_Type = is_null($vue_utilisateur_Filtre_Taille_Pays_Type) || $vue_utilisateur_Filtre_Taille_Pays_Type === '' ? null : (int) $vue_utilisateur_Filtre_Taille_Pays_Type;
                $vue_utilisateur_Filtre_Taille_Max = is_null($vue_utilisateur_Filtre_Taille_Max) || $vue_utilisateur_Filtre_Taille_Max === '' ? null : (int) $vue_utilisateur_Filtre_Taille_Max;
                $vue_utilisateur_Filtre_Taille_Min = is_null($vue_utilisateur_Filtre_Taille_Min) || $vue_utilisateur_Filtre_Taille_Min === '' ? null : (int) $vue_utilisateur_Filtre_Taille_Min;
                // Fin typage
                $retour = $this->mf_modifier($Code_vue_utilisateur, $vue_utilisateur_Recherche, $vue_utilisateur_Filtre_Saison_Type, $vue_utilisateur_Filtre_Couleur, $vue_utilisateur_Filtre_Taille_Pays_Type, $vue_utilisateur_Filtre_Taille_Max, $vue_utilisateur_Filtre_Taille_Min, true);
                if ($retour['code_erreur'] != 0 && $retour['code_erreur'] != ERR_VUE_UTILISATEUR__MODIFIER__AUCUN_CHANGEMENT) {
                    $code_erreur = $retour['code_erreur'];
                }
                if (count($lignes) == 1) {
                    return $retour;
                }
            }
        }
        if ($code_erreur != 0) {
            global $mf_message_erreur_personalise, $mf_libelle_erreur;
            if ($mf_message_erreur_personalise != '') {
                $mf_libelle_erreur[$code_erreur] = $mf_message_erreur_personalise;
                $mf_message_erreur_personalise = '';
            }
        }
        return ['code_erreur' => $code_erreur];
    }

    public function mf_modifier_3(array $lignes) // array( $Code_vue_utilisateur => array('colonne1' => 'valeur1',  [...] ) )
    {
        $code_erreur = 0;
        $modifs = false;

        // transformation des lignes en colonnes
        $valeurs_en_colonnes = [];
        $indices_par_colonne = [];
        $liste_valeurs_indexees = [];
        foreach ($lignes as $Code_vue_utilisateur => $colonnes) {
            foreach ($colonnes as $colonne => $valeur) {
                if ($colonne == 'vue_utilisateur_Recherche' || $colonne == 'vue_utilisateur_Filtre_Saison_Type' || $colonne == 'vue_utilisateur_Filtre_Couleur' || $colonne == 'vue_utilisateur_Filtre_Taille_Pays_Type' || $colonne == 'vue_utilisateur_Filtre_Taille_Max' || $colonne == 'vue_utilisateur_Filtre_Taille_Min') {
                    $valeurs_en_colonnes[$colonne][$Code_vue_utilisateur] = $valeur;
                    $indices_par_colonne[$colonne][] = $Code_vue_utilisateur;
                    $liste_valeurs_indexees[$colonne]["$valeur"][] = $Code_vue_utilisateur;
                }
            }
        }

        // fabrication des requetes
        foreach ($valeurs_en_colonnes as $colonne => $valeurs) {
            if (count($liste_valeurs_indexees[$colonne]) > 3) {
                $modification_sql = $colonne . ' = CASE Code_vue_utilisateur';
                foreach ($valeurs as $Code_vue_utilisateur => $valeur) {
                    $modification_sql .= ' WHEN ' . $Code_vue_utilisateur . ' THEN ' . format_sql($colonne, $valeur);
                }
                $modification_sql .= ' END';
                $perimetre = Sql_Format_Liste($indices_par_colonne[$colonne]);
                executer_requete_mysql('UPDATE ' . inst('vue_utilisateur') . ' SET ' . $modification_sql . ' WHERE Code_vue_utilisateur IN ' . $perimetre . ';', array_search('vue_utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
                if (requete_mysqli_affected_rows() != 0) {
                    $modifs = true;
                }
            } else {
                foreach ($liste_valeurs_indexees[$colonne] as $valeur => $indices_par_valeur) {
                    $perimetre = Sql_Format_Liste($indices_par_valeur);
                    executer_requete_mysql('UPDATE ' . inst('vue_utilisateur') . ' SET ' . $colonne . ' = ' . format_sql($colonne, $valeur) . ' WHERE Code_vue_utilisateur IN ' . $perimetre . ';', array_search('vue_utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
                    if (requete_mysqli_affected_rows() != 0) {
                        $modifs = true;
                    }
                }
            }
        }

        if (! $modifs && $code_erreur == 0) {
            $code_erreur = ERR_VUE_UTILISATEUR__MODIFIER_3__AUCUN_CHANGEMENT;
        }
        if ($modifs) {
            self::$cache_db->clear();
        }
        if ($code_erreur != 0) {
            global $mf_message_erreur_personalise, $mf_libelle_erreur;
            if ($mf_message_erreur_personalise != '') {
                $mf_libelle_erreur[$code_erreur] = $mf_message_erreur_personalise;
                $mf_message_erreur_personalise = '';
            }
        }
        return ['code_erreur' => $code_erreur];
    }

    public function mf_modifier_4( array $data, ?array $options = null /* $options = array( 'cond_mysql' => [], 'limit' => 0 ) */ ) // $data = array('colonne1' => 'valeur1', ... )
    {
        $code_erreur = 0;
        $mf_colonnes_a_modifier=[];
        if (isset($data['vue_utilisateur_Recherche']) || array_key_exists('vue_utilisateur_Recherche', $data)) { $mf_colonnes_a_modifier[] = 'vue_utilisateur_Recherche = ' . format_sql('vue_utilisateur_Recherche', $data['vue_utilisateur_Recherche']); }
        if (isset($data['vue_utilisateur_Filtre_Saison_Type']) || array_key_exists('vue_utilisateur_Filtre_Saison_Type', $data)) { $mf_colonnes_a_modifier[] = 'vue_utilisateur_Filtre_Saison_Type = ' . format_sql('vue_utilisateur_Filtre_Saison_Type', $data['vue_utilisateur_Filtre_Saison_Type']); }
        if (isset($data['vue_utilisateur_Filtre_Couleur']) || array_key_exists('vue_utilisateur_Filtre_Couleur', $data)) { $mf_colonnes_a_modifier[] = 'vue_utilisateur_Filtre_Couleur = ' . format_sql('vue_utilisateur_Filtre_Couleur', $data['vue_utilisateur_Filtre_Couleur']); }
        if (isset($data['vue_utilisateur_Filtre_Taille_Pays_Type']) || array_key_exists('vue_utilisateur_Filtre_Taille_Pays_Type', $data)) { $mf_colonnes_a_modifier[] = 'vue_utilisateur_Filtre_Taille_Pays_Type = ' . format_sql('vue_utilisateur_Filtre_Taille_Pays_Type', $data['vue_utilisateur_Filtre_Taille_Pays_Type']); }
        if (isset($data['vue_utilisateur_Filtre_Taille_Max']) || array_key_exists('vue_utilisateur_Filtre_Taille_Max', $data)) { $mf_colonnes_a_modifier[] = 'vue_utilisateur_Filtre_Taille_Max = ' . format_sql('vue_utilisateur_Filtre_Taille_Max', $data['vue_utilisateur_Filtre_Taille_Max']); }
        if (isset($data['vue_utilisateur_Filtre_Taille_Min']) || array_key_exists('vue_utilisateur_Filtre_Taille_Min', $data)) { $mf_colonnes_a_modifier[] = 'vue_utilisateur_Filtre_Taille_Min = ' . format_sql('vue_utilisateur_Filtre_Taille_Min', $data['vue_utilisateur_Filtre_Taille_Min']); }
        if (count($mf_colonnes_a_modifier) > 0) {
            // cond_mysql
            $argument_cond = '';
            if (isset($options['cond_mysql'])) {
                foreach ($options['cond_mysql'] as &$condition) {
                    $argument_cond .= ' AND ('.$condition.')';
                }
                unset($condition);
            }

            // limit
            $limit = 0;
            if (isset($options['limit'])) {
                $limit = intval($options['limit']);
            }

            $requete = 'UPDATE ' . inst('vue_utilisateur') . ' SET ' . enumeration($mf_colonnes_a_modifier) . " WHERE 1$argument_cond" . ( $limit>0 ? ' LIMIT ' . $limit : '' ) . ";";
            executer_requete_mysql( $requete , array_search('vue_utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            if (requete_mysqli_affected_rows() == 0) {
                $code_erreur = ERR_VUE_UTILISATEUR__MODIFIER_4__AUCUN_CHANGEMENT;
            } else {
                self::$cache_db->clear();
            }
        }
        return ['code_erreur' => $code_erreur];
    }

    public function mf_supprimer(int $Code_vue_utilisateur, ?bool $force = null)
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        $Code_vue_utilisateur = intval($Code_vue_utilisateur);
        if (! $force) {
            if (!self::$maj_droits_supprimer_en_cours)
            {
                self::$maj_droits_supprimer_en_cours = true;
                Hook_vue_utilisateur::hook_actualiser_les_droits_supprimer($Code_vue_utilisateur);
                self::$maj_droits_supprimer_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['vue_utilisateur__SUPPRIMER']) ) $code_erreur = REFUS_VUE_UTILISATEUR__SUPPRIMER;
        elseif (! $this->mf_tester_existance_Code_vue_utilisateur($Code_vue_utilisateur) ) $code_erreur = ERR_VUE_UTILISATEUR__SUPPRIMER_2__CODE_VUE_UTILISATEUR_INEXISTANT;
        elseif (CONTROLE_ACCES_DONNEES_DEFAUT && ! Hook_mf_systeme::controle_acces_donnees('Code_vue_utilisateur', $Code_vue_utilisateur)) $code_erreur = ACCES_CODE_VUE_UTILISATEUR_REFUSE;
        elseif ( !Hook_vue_utilisateur::autorisation_suppression($Code_vue_utilisateur) ) $code_erreur = REFUS_VUE_UTILISATEUR__SUPPRESSION_BLOQUEE;
        else
        {
            $copie__vue_utilisateur = $this->mf_get($Code_vue_utilisateur, ['autocompletion' => false]);
            $this->supprimer_donnes_en_cascade("vue_utilisateur", [$Code_vue_utilisateur]);
            $requete = 'DELETE IGNORE FROM ' . inst('vue_utilisateur') . ' WHERE Code_vue_utilisateur=' . $Code_vue_utilisateur . ';';
            executer_requete_mysql($requete, array_search('vue_utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            if (requete_mysqli_affected_rows() == 0) {
                $code_erreur = ERR_VUE_UTILISATEUR__SUPPRIMER__REFUSEE;
            } else {
                self::$cache_db->clear();
                Hook_vue_utilisateur::supprimer($copie__vue_utilisateur);
            }
        }
        if ($code_erreur != 0) {
            global $mf_message_erreur_personalise, $mf_libelle_erreur;
            if ($mf_message_erreur_personalise != '') {
                $mf_libelle_erreur[$code_erreur] = $mf_message_erreur_personalise;
                $mf_message_erreur_personalise = '';
            }
        }
        return ['code_erreur' => $code_erreur];
    }

    public function mf_supprimer_2(array $liste_Code_vue_utilisateur, ?bool $force = null)
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        $copie__liste_vue_utilisateur = $this->mf_lister_2($liste_Code_vue_utilisateur, ['autocompletion' => false]);
        $liste_Code_vue_utilisateur=[];
        foreach ( $copie__liste_vue_utilisateur as $copie__vue_utilisateur )
        {
            $Code_vue_utilisateur = $copie__vue_utilisateur['Code_vue_utilisateur'];
            if (! $force) {
                if (!self::$maj_droits_supprimer_en_cours)
                {
                    self::$maj_droits_supprimer_en_cours = true;
                    Hook_vue_utilisateur::hook_actualiser_les_droits_supprimer($Code_vue_utilisateur);
                    self::$maj_droits_supprimer_en_cours = false;
                }
            }
            if ( !$force && !mf_matrice_droits(['vue_utilisateur__SUPPRIMER']) ) $code_erreur = REFUS_VUE_UTILISATEUR__SUPPRIMER;
            elseif ( !Hook_vue_utilisateur::autorisation_suppression($Code_vue_utilisateur) ) $code_erreur = REFUS_VUE_UTILISATEUR__SUPPRESSION_BLOQUEE;
            {
                $liste_Code_vue_utilisateur[] = $Code_vue_utilisateur;
            }
        }
        if ($code_erreur == 0 && count($liste_Code_vue_utilisateur) > 0) {
            $this->supprimer_donnes_en_cascade("vue_utilisateur", $liste_Code_vue_utilisateur);
            $requete = 'DELETE IGNORE FROM ' . inst('vue_utilisateur') . ' WHERE Code_vue_utilisateur IN ' . Sql_Format_Liste($liste_Code_vue_utilisateur) . ';';
            executer_requete_mysql( $requete , array_search('vue_utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            if (requete_mysqli_affected_rows() == 0) {
                $code_erreur = ERR_VUE_UTILISATEUR__SUPPRIMER_2__REFUSEE;
            } else {
                self::$cache_db->clear();
                Hook_vue_utilisateur::supprimer_2($copie__liste_vue_utilisateur);
            }
        }
        if ($code_erreur != 0) {
            global $mf_message_erreur_personalise, $mf_libelle_erreur;
            if ($mf_message_erreur_personalise != '') {
                $mf_libelle_erreur[$code_erreur] = $mf_message_erreur_personalise;
                $mf_message_erreur_personalise = '';
            }
        }
        return ['code_erreur' => $code_erreur];
    }

    public function mf_supprimer_3(array $liste_Code_vue_utilisateur)
    {
        $code_erreur = 0;
        if (count($liste_Code_vue_utilisateur) > 0) {
            $this->supprimer_donnes_en_cascade("vue_utilisateur", $liste_Code_vue_utilisateur);
            $requete = 'DELETE IGNORE FROM ' . inst('vue_utilisateur') . ' WHERE Code_vue_utilisateur IN ' . Sql_Format_Liste($liste_Code_vue_utilisateur) . ';';
            executer_requete_mysql( $requete , array_search('vue_utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            if (requete_mysqli_affected_rows() == 0) {
                $code_erreur = ERR_VUE_UTILISATEUR__SUPPRIMER_3__REFUSEE;
            } else {
                self::$cache_db->clear();
            }
        }
        if ($code_erreur != 0) {
            global $mf_message_erreur_personalise, $mf_libelle_erreur;
            if ($mf_message_erreur_personalise != '') {
                $mf_libelle_erreur[$code_erreur] = $mf_message_erreur_personalise;
                $mf_message_erreur_personalise = '';
            }
        }
        return ['code_erreur' => $code_erreur];
    }

    public function mf_lister_contexte(?bool $contexte_parent = null, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'liste_colonnes_a_selectionner' => [], 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ($contexte_parent === null) {
            $contexte_parent = true;
        }
        if ($options === null) {
            $options=[];
        }
        global $mf_contexte;
        if (! $contexte_parent && $mf_contexte['Code_vue_utilisateur'] != 0) {
            $vue_utilisateur = $this->mf_get( $mf_contexte['Code_vue_utilisateur'], $options);
            return [$vue_utilisateur['Code_vue_utilisateur'] => $vue_utilisateur];
        } else {
            return $this->mf_lister($options);
        }
    }

    public function mf_lister(?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'liste_colonnes_a_selectionner' => [], 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cle = "vue_utilisateur__lister";

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql'])) {
            foreach ($options['cond_mysql'] as &$condition) {
                $argument_cond .= " AND ($condition)";
            }
            unset($condition);
        }
        $cle .= "_$argument_cond";

        // tris
        $argument_tris = '';
        if (! isset($options['tris'])) {
            $options['tris']=[];
        }
        if (count($options['tris']) == 0) {
            global $mf_tri_defaut_table;
            if (isset($mf_tri_defaut_table['vue_utilisateur'])) {
                $options['tris'] = $mf_tri_defaut_table['vue_utilisateur'];
            }
        }
        foreach ($options['tris'] as $colonne => $tri) {
            if ( $argument_tris=='' ) { $argument_tris = ' ORDER BY '; } else { $argument_tris .= ', '; }
            if ( $tri!='DESC' ) $tri = 'ASC';
            $argument_tris .= $colonne.' '.$tri;
        }
        $cle .= '_' . $argument_tris;

        // limit
        $argument_limit = '';
        if (isset($options['limit'][0]) && isset($options['limit'][1])) {
            $argument_limit = ' LIMIT ' . $options['limit'][0] . ',' . $options['limit'][1];
        }
        $cle .= '_'.$argument_limit;

        // autocompletion
        $autocompletion = AUTOCOMPLETION_DEFAUT;
        if (isset($options['autocompletion'])) {
            $autocompletion = ($options['autocompletion'] == true);
        }

        // autocompletion_recursive
        $autocompletion_recursive = AUTOCOMPLETION_RECURSIVE_DEFAUT;
        if (isset($options['autocompletion_recursive'])) {
            $autocompletion_recursive = ($options['autocompletion_recursive'] == true);
        }

        // controle_acces_donnees
        $controle_acces_donnees = CONTROLE_ACCES_DONNEES_DEFAUT;
        if (isset($options['controle_acces_donnees'])) {
            $controle_acces_donnees = ($options['controle_acces_donnees'] == true);
        }

        // liste_colonnes_a_selectionner
        $liste_colonnes_a_selectionner = [];
        if (isset($options['liste_colonnes_a_selectionner'])) {
            $liste_colonnes_a_selectionner = $options['liste_colonnes_a_selectionner'];
        }
        $cle .= '_' . enumeration($liste_colonnes_a_selectionner);

        // afficher toutes les colonnes
        $toutes_colonnes = TOUTES_COLONNES_DEFAUT;
        if (count($liste_colonnes_a_selectionner) == 0) {
            if (isset($options['toutes_colonnes'])) {
                $toutes_colonnes = ($options['toutes_colonnes'] == true);
            }
            $cle .= '_' . ($toutes_colonnes ? '1' : '0');
        }

        // maj
        $maj = true;
        if (isset($options['maj'])) {
            $maj = ($options['maj'] == true);
        }
        $cle .= '_'.( $maj ? '1' : '0' );

        $nouvelle_lecture = true;
        $liste = [];
        while ($nouvelle_lecture) {
            $nouvelle_lecture = false;
            $liste_vue_utilisateur_pas_a_jour = [];
            if (false === $liste = self::$cache_db->read($cle)) {

                // Indexes
                $liste_colonnes_a_indexer = [];
                if ($argument_cond != '') {
                    if ( strpos($argument_cond, 'vue_utilisateur_Recherche')!==false ) { $liste_colonnes_a_indexer['vue_utilisateur_Recherche'] = 'vue_utilisateur_Recherche'; }
                    if ( strpos($argument_cond, 'vue_utilisateur_Filtre_Saison_Type')!==false ) { $liste_colonnes_a_indexer['vue_utilisateur_Filtre_Saison_Type'] = 'vue_utilisateur_Filtre_Saison_Type'; }
                    if ( strpos($argument_cond, 'vue_utilisateur_Filtre_Couleur')!==false ) { $liste_colonnes_a_indexer['vue_utilisateur_Filtre_Couleur'] = 'vue_utilisateur_Filtre_Couleur'; }
                    if ( strpos($argument_cond, 'vue_utilisateur_Filtre_Taille_Pays_Type')!==false ) { $liste_colonnes_a_indexer['vue_utilisateur_Filtre_Taille_Pays_Type'] = 'vue_utilisateur_Filtre_Taille_Pays_Type'; }
                    if ( strpos($argument_cond, 'vue_utilisateur_Filtre_Taille_Max')!==false ) { $liste_colonnes_a_indexer['vue_utilisateur_Filtre_Taille_Max'] = 'vue_utilisateur_Filtre_Taille_Max'; }
                    if ( strpos($argument_cond, 'vue_utilisateur_Filtre_Taille_Min')!==false ) { $liste_colonnes_a_indexer['vue_utilisateur_Filtre_Taille_Min'] = 'vue_utilisateur_Filtre_Taille_Min'; }
                }
                if (isset($options['tris'])) {
                    if ( isset($options['tris']['vue_utilisateur_Recherche']) ) { $liste_colonnes_a_indexer['vue_utilisateur_Recherche'] = 'vue_utilisateur_Recherche'; }
                    if ( isset($options['tris']['vue_utilisateur_Filtre_Saison_Type']) ) { $liste_colonnes_a_indexer['vue_utilisateur_Filtre_Saison_Type'] = 'vue_utilisateur_Filtre_Saison_Type'; }
                    if ( isset($options['tris']['vue_utilisateur_Filtre_Couleur']) ) { $liste_colonnes_a_indexer['vue_utilisateur_Filtre_Couleur'] = 'vue_utilisateur_Filtre_Couleur'; }
                    if ( isset($options['tris']['vue_utilisateur_Filtre_Taille_Pays_Type']) ) { $liste_colonnes_a_indexer['vue_utilisateur_Filtre_Taille_Pays_Type'] = 'vue_utilisateur_Filtre_Taille_Pays_Type'; }
                    if ( isset($options['tris']['vue_utilisateur_Filtre_Taille_Max']) ) { $liste_colonnes_a_indexer['vue_utilisateur_Filtre_Taille_Max'] = 'vue_utilisateur_Filtre_Taille_Max'; }
                    if ( isset($options['tris']['vue_utilisateur_Filtre_Taille_Min']) ) { $liste_colonnes_a_indexer['vue_utilisateur_Filtre_Taille_Min'] = 'vue_utilisateur_Filtre_Taille_Min'; }
                }
                if (count($liste_colonnes_a_indexer) > 0) {
                    if (false === $mf_liste_requete_index = self::$cache_db->read('vue_utilisateur__index')) {
                        $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('vue_utilisateur').'`;', false);
                        $mf_liste_requete_index = [];
                        while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                            $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                        }
                        mysqli_free_result($res_requete_index);
                        self::$cache_db->write('vue_utilisateur__index', $mf_liste_requete_index);
                    }
                    foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                        if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                    }
                    if (count($liste_colonnes_a_indexer) > 0) {
                        foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                            executer_requete_mysql('ALTER TABLE `'.inst('vue_utilisateur').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                        }
                        self::$cache_db->clear();
                    }
                }

                if (count($liste_colonnes_a_selectionner) == 0) {
                    if ($toutes_colonnes) {
                        $colonnes = 'Code_vue_utilisateur, vue_utilisateur_Recherche, vue_utilisateur_Filtre_Saison_Type, vue_utilisateur_Filtre_Couleur, vue_utilisateur_Filtre_Taille_Pays_Type, vue_utilisateur_Filtre_Taille_Max, vue_utilisateur_Filtre_Taille_Min';
                    } else {
                        $colonnes = 'Code_vue_utilisateur, vue_utilisateur_Recherche, vue_utilisateur_Filtre_Saison_Type, vue_utilisateur_Filtre_Couleur, vue_utilisateur_Filtre_Taille_Pays_Type, vue_utilisateur_Filtre_Taille_Max, vue_utilisateur_Filtre_Taille_Min';
                    }
                } else {
                    $liste_colonnes_a_selectionner[] = 'Code_vue_utilisateur';
                    $colonnes = enumeration($liste_colonnes_a_selectionner, ',');
                }

                $liste = [];
                $liste_vue_utilisateur_pas_a_jour = [];
                $res_requete = executer_requete_mysql("SELECT $colonnes FROM " . inst('vue_utilisateur') . " WHERE 1{$argument_cond}{$argument_tris}{$argument_limit};", false);
                while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                    mf_formatage_db_type_php($row_requete);
                    $liste[$row_requete['Code_vue_utilisateur']] = $row_requete;
                    if ($maj && ! Hook_vue_utilisateur::est_a_jour($row_requete)) {
                        $liste_vue_utilisateur_pas_a_jour[$row_requete['Code_vue_utilisateur']] = $row_requete;
                        $nouvelle_lecture = true;
                    }
                }
                mysqli_free_result($res_requete);
                if (count($options['tris'])==1 && ! $nouvelle_lecture) {
                    foreach ($options['tris'] as $colonne => $tri) {
                        global $lang_standard;
                        if (isset($lang_standard[$colonne.'_'])) {
                            effectuer_tri_suivant_langue($liste, $colonne, $tri);
                        }
                    }
                }
                if (! $nouvelle_lecture) {
                    self::$cache_db->write($cle, $liste);
                }
            }
            if ($nouvelle_lecture) {
                Hook_vue_utilisateur::mettre_a_jour( $liste_vue_utilisateur_pas_a_jour );
            }
        }

        foreach ($liste as $elem) {
            if ($controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_vue_utilisateur', $elem['Code_vue_utilisateur'])) {
                unset($liste[$elem['Code_vue_utilisateur']]);
            } else {
                if (($autocompletion_recursive || self::$auto_completion < 1) && $autocompletion) {
                    self::$auto_completion ++;
                    Hook_vue_utilisateur::completion($liste[$elem['Code_vue_utilisateur']], self::$auto_completion - 1);
                    self::$auto_completion --;
                }
            }
        }

        return $liste;
    }

    public function mf_lister_2(array $liste_Code_vue_utilisateur, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'liste_colonnes_a_selectionner' => [], 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        if (count($liste_Code_vue_utilisateur) > 0) {
            $cle = "vue_utilisateur__mf_lister_2_".Sql_Format_Liste($liste_Code_vue_utilisateur);

            // cond_mysql
            $argument_cond = '';
            if (isset($options['cond_mysql'])) {
                foreach ($options['cond_mysql'] as &$condition) {
                    $argument_cond .= " AND ($condition)";
                }
                unset($condition);
            }
            $cle .= "_$argument_cond";

            // tris
            $argument_tris = '';
            if (! isset($options['tris'])) {
                $options['tris']=[];
            }
            if (count($options['tris']) == 0) {
                global $mf_tri_defaut_table;
                if (isset($mf_tri_defaut_table['vue_utilisateur'])) {
                    $options['tris'] = $mf_tri_defaut_table['vue_utilisateur'];
                }
            }
            foreach ($options['tris'] as $colonne => $tri) {
                if ( $argument_tris=='' ) { $argument_tris = ' ORDER BY '; } else { $argument_tris .= ', '; }
                if ( $tri!='DESC' ) $tri = 'ASC';
                $argument_tris .= $colonne.' '.$tri;
            }
            $cle .= '_' . $argument_tris;

            // limit
            $argument_limit = '';
            if (isset($options['limit'][0]) && isset($options['limit'][1])) {
                $argument_limit = ' LIMIT ' . $options['limit'][0] . ',' . $options['limit'][1];
            }
            $cle .= '_'.$argument_limit;

            // autocompletion
            $autocompletion = AUTOCOMPLETION_DEFAUT;
            if (isset($options['autocompletion'])) {
                $autocompletion = ($options['autocompletion'] == true);
            }

            // autocompletion_recursive
            $autocompletion_recursive = AUTOCOMPLETION_RECURSIVE_DEFAUT;
            if (isset($options['autocompletion_recursive'])) {
                $autocompletion_recursive = ($options['autocompletion_recursive'] == true);
            }

            // controle_acces_donnees
            $controle_acces_donnees = CONTROLE_ACCES_DONNEES_DEFAUT;
            if (isset($options['controle_acces_donnees'])) {
                $controle_acces_donnees = ($options['controle_acces_donnees'] == true);
            }

            // liste_colonnes_a_selectionner
            $liste_colonnes_a_selectionner = [];
            if (isset($options['liste_colonnes_a_selectionner'])) {
                $liste_colonnes_a_selectionner = $options['liste_colonnes_a_selectionner'];
            }
            $cle .= '_' . enumeration($liste_colonnes_a_selectionner);

            // afficher toutes les colonnes
            $toutes_colonnes = TOUTES_COLONNES_DEFAUT;
            if (count($liste_colonnes_a_selectionner) == 0) {
                if (isset($options['toutes_colonnes'])) {
                    $toutes_colonnes = ($options['toutes_colonnes'] == true);
                }
                $cle .= '_' . ($toutes_colonnes ? '1' : '0');
            }

            // maj
            $maj = true;
            if (isset($options['maj'])) {
                $maj = ($options['maj'] == true);
            }
            $cle .= '_'.( $maj ? '1' : '0' );

            $nouvelle_lecture = true;
            $liste = [];
            while ($nouvelle_lecture) {
                $nouvelle_lecture = false;
                $liste_vue_utilisateur_pas_a_jour = [];
                if (false === $liste = self::$cache_db->read($cle)) {

                    // Indexes
                    $liste_colonnes_a_indexer = [];
                    if ($argument_cond != '') {
                        if ( strpos($argument_cond, 'vue_utilisateur_Recherche')!==false ) { $liste_colonnes_a_indexer['vue_utilisateur_Recherche'] = 'vue_utilisateur_Recherche'; }
                        if ( strpos($argument_cond, 'vue_utilisateur_Filtre_Saison_Type')!==false ) { $liste_colonnes_a_indexer['vue_utilisateur_Filtre_Saison_Type'] = 'vue_utilisateur_Filtre_Saison_Type'; }
                        if ( strpos($argument_cond, 'vue_utilisateur_Filtre_Couleur')!==false ) { $liste_colonnes_a_indexer['vue_utilisateur_Filtre_Couleur'] = 'vue_utilisateur_Filtre_Couleur'; }
                        if ( strpos($argument_cond, 'vue_utilisateur_Filtre_Taille_Pays_Type')!==false ) { $liste_colonnes_a_indexer['vue_utilisateur_Filtre_Taille_Pays_Type'] = 'vue_utilisateur_Filtre_Taille_Pays_Type'; }
                        if ( strpos($argument_cond, 'vue_utilisateur_Filtre_Taille_Max')!==false ) { $liste_colonnes_a_indexer['vue_utilisateur_Filtre_Taille_Max'] = 'vue_utilisateur_Filtre_Taille_Max'; }
                        if ( strpos($argument_cond, 'vue_utilisateur_Filtre_Taille_Min')!==false ) { $liste_colonnes_a_indexer['vue_utilisateur_Filtre_Taille_Min'] = 'vue_utilisateur_Filtre_Taille_Min'; }
                    }
                    if (isset($options['tris'])) {
                        if ( isset($options['tris']['vue_utilisateur_Recherche']) ) { $liste_colonnes_a_indexer['vue_utilisateur_Recherche'] = 'vue_utilisateur_Recherche'; }
                        if ( isset($options['tris']['vue_utilisateur_Filtre_Saison_Type']) ) { $liste_colonnes_a_indexer['vue_utilisateur_Filtre_Saison_Type'] = 'vue_utilisateur_Filtre_Saison_Type'; }
                        if ( isset($options['tris']['vue_utilisateur_Filtre_Couleur']) ) { $liste_colonnes_a_indexer['vue_utilisateur_Filtre_Couleur'] = 'vue_utilisateur_Filtre_Couleur'; }
                        if ( isset($options['tris']['vue_utilisateur_Filtre_Taille_Pays_Type']) ) { $liste_colonnes_a_indexer['vue_utilisateur_Filtre_Taille_Pays_Type'] = 'vue_utilisateur_Filtre_Taille_Pays_Type'; }
                        if ( isset($options['tris']['vue_utilisateur_Filtre_Taille_Max']) ) { $liste_colonnes_a_indexer['vue_utilisateur_Filtre_Taille_Max'] = 'vue_utilisateur_Filtre_Taille_Max'; }
                        if ( isset($options['tris']['vue_utilisateur_Filtre_Taille_Min']) ) { $liste_colonnes_a_indexer['vue_utilisateur_Filtre_Taille_Min'] = 'vue_utilisateur_Filtre_Taille_Min'; }
                    }
                    if (count($liste_colonnes_a_indexer) > 0) {
                        if (false === $mf_liste_requete_index = self::$cache_db->read('vue_utilisateur__index')) {
                            $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('vue_utilisateur').'`;', false);
                            $mf_liste_requete_index = [];
                            while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                                $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                            }
                            mysqli_free_result($res_requete_index);
                            self::$cache_db->write('vue_utilisateur__index', $mf_liste_requete_index);
                        }
                        foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                            if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                        }
                        if (count($liste_colonnes_a_indexer) > 0) {
                            foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                                executer_requete_mysql('ALTER TABLE `'.inst('vue_utilisateur').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                            }
                            self::$cache_db->clear();
                        }
                    }

                    if (count($liste_colonnes_a_selectionner) == 0) {
                        if ($toutes_colonnes) {
                            $colonnes = 'Code_vue_utilisateur, vue_utilisateur_Recherche, vue_utilisateur_Filtre_Saison_Type, vue_utilisateur_Filtre_Couleur, vue_utilisateur_Filtre_Taille_Pays_Type, vue_utilisateur_Filtre_Taille_Max, vue_utilisateur_Filtre_Taille_Min';
                        } else {
                            $colonnes = 'Code_vue_utilisateur, vue_utilisateur_Recherche, vue_utilisateur_Filtre_Saison_Type, vue_utilisateur_Filtre_Couleur, vue_utilisateur_Filtre_Taille_Pays_Type, vue_utilisateur_Filtre_Taille_Max, vue_utilisateur_Filtre_Taille_Min';
                        }
                    } else {
                        $liste_colonnes_a_selectionner[] = 'Code_vue_utilisateur';
                        $colonnes = enumeration($liste_colonnes_a_selectionner, ',');
                    }

                    $liste = [];
                    $liste_vue_utilisateur_pas_a_jour = [];
                    $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM ' . inst('vue_utilisateur') . " WHERE 1{$argument_cond} AND Code_vue_utilisateur IN ".Sql_Format_Liste($liste_Code_vue_utilisateur)."{$argument_tris}{$argument_limit};", false);
                    while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                        mf_formatage_db_type_php($row_requete);
                        $liste[$row_requete['Code_vue_utilisateur']] = $row_requete;
                        if ($maj && ! Hook_vue_utilisateur::est_a_jour($row_requete)) {
                            $liste_vue_utilisateur_pas_a_jour[$row_requete['Code_vue_utilisateur']] = $row_requete;
                            $nouvelle_lecture = true;
                        }
                    }
                    mysqli_free_result($res_requete);
                    if (count($options['tris']) == 1 && ! $nouvelle_lecture) {
                        foreach ($options['tris'] as $colonne => $tri) {
                            global $lang_standard;
                            if (isset($lang_standard[$colonne.'_'])) {
                                effectuer_tri_suivant_langue($liste, $colonne, $tri);
                            }
                        }
                    }
                    if (! $nouvelle_lecture) {
                        self::$cache_db->write($cle, $liste);
                    }
                }
                if ($nouvelle_lecture) {
                    Hook_vue_utilisateur::mettre_a_jour( $liste_vue_utilisateur_pas_a_jour );
                }
            }

            foreach ($liste as $elem) {
                if ($controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_vue_utilisateur', $elem['Code_vue_utilisateur'])) {
                    unset($liste[$elem['Code_vue_utilisateur']]);
                } else {
                    if (($autocompletion_recursive || self::$auto_completion < 1) && $autocompletion) {
                        self::$auto_completion ++;
                        Hook_vue_utilisateur::completion($liste[$elem['Code_vue_utilisateur']], self::$auto_completion - 1);
                        self::$auto_completion --;
                    }
                }
            }

            return $liste;
        } else {
            return [];
        }
    }

    public function mf_lister_3(?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'liste_colonnes_a_selectionner' => [], 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        return $this->mf_lister($options);
    }

    public function mf_get(int $Code_vue_utilisateur, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $Code_vue_utilisateur = intval($Code_vue_utilisateur);
        $retour = [];
        if ( ! CONTROLE_ACCES_DONNEES_DEFAUT || Hook_mf_systeme::controle_acces_donnees('Code_vue_utilisateur', $Code_vue_utilisateur) ) {
            $cle = 'vue_utilisateur__get_'.$Code_vue_utilisateur;

            // autocompletion
            $autocompletion = AUTOCOMPLETION_DEFAUT;
            if (isset($options['autocompletion'])) {
                $autocompletion = ($options['autocompletion'] == true);
            }

            // autocompletion_recursive
            $autocompletion_recursive = AUTOCOMPLETION_RECURSIVE_DEFAUT;
            if (isset($options['autocompletion_recursive'])) {
                $autocompletion_recursive = ($options['autocompletion_recursive'] == true);
            }

            // afficher toutes les colonnes
            $toutes_colonnes = true;
            if (isset($options['toutes_colonnes'])) {
                $toutes_colonnes = ($options['toutes_colonnes'] == true);
            }
            $cle .= '_' . ($toutes_colonnes ? '1' : '0');

            // maj
            $maj = true;
            if (isset($options['maj'])) {
                $maj = ($options['maj'] == true);
            }
            $cle .= '_' . ($maj ? '1' : '0');

            $nouvelle_lecture = true;
            while ($nouvelle_lecture) {
                $nouvelle_lecture = false;
                if (false === $retour = self::$cache_db->read($cle)) {
                    if ($toutes_colonnes) {
                        $colonnes='Code_vue_utilisateur, vue_utilisateur_Recherche, vue_utilisateur_Filtre_Saison_Type, vue_utilisateur_Filtre_Couleur, vue_utilisateur_Filtre_Taille_Pays_Type, vue_utilisateur_Filtre_Taille_Max, vue_utilisateur_Filtre_Taille_Min';
                    } else {
                        $colonnes='Code_vue_utilisateur, vue_utilisateur_Recherche, vue_utilisateur_Filtre_Saison_Type, vue_utilisateur_Filtre_Couleur, vue_utilisateur_Filtre_Taille_Pays_Type, vue_utilisateur_Filtre_Taille_Max, vue_utilisateur_Filtre_Taille_Min';
                    }
                    $res_requete = executer_requete_mysql("SELECT $colonnes FROM " . inst('vue_utilisateur') . ' WHERE Code_vue_utilisateur = ' . $Code_vue_utilisateur . ';', false);
                    if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                        mf_formatage_db_type_php($row_requete);
                        $retour = $row_requete;
                        if ($maj && ! Hook_vue_utilisateur::est_a_jour($row_requete)) {
                            $nouvelle_lecture = true;
                        }
                    } else {
                        $retour = [];
                    }
                    mysqli_free_result($res_requete);
                    if (! $nouvelle_lecture) {
                        self::$cache_db->write($cle, $retour);
                    } else {
                        Hook_vue_utilisateur::mettre_a_jour([$row_requete['Code_vue_utilisateur'] => $row_requete]);
                    }
                }
            }
            if (isset($retour['Code_vue_utilisateur'])) {
                if (($autocompletion_recursive || self::$auto_completion < 1) && $autocompletion) {
                    self::$auto_completion ++;
                    Hook_vue_utilisateur::completion($retour, self::$auto_completion - 1);
                    self::$auto_completion --;
                }
            }
        }
        return $retour;
    }

    public function mf_get_last(?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cle = "vue_utilisateur__get_last";
        if (false === $retour = self::$cache_db->read($cle)) {
            $Code_vue_utilisateur = 0;
            $res_requete = executer_requete_mysql('SELECT Code_vue_utilisateur FROM ' . inst('vue_utilisateur') . " WHERE 1 ORDER BY mf_date_creation DESC, Code_vue_utilisateur DESC LIMIT 0 , 1;", false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $Code_vue_utilisateur = intval($row_requete['Code_vue_utilisateur']);
            }
            mysqli_free_result($res_requete);
            $retour = $this->mf_get($Code_vue_utilisateur, $options);
            self::$cache_db->write($cle, $retour);
        }
        return $retour;
    }

    public function mf_get_2(int $Code_vue_utilisateur, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cle = "vue_utilisateur__get_$Code_vue_utilisateur";

        // autocompletion
        $autocompletion = AUTOCOMPLETION_DEFAUT;
        if (isset($options['autocompletion'])) {
            $autocompletion = ($options['autocompletion'] == true);
        }

        // autocompletion_recursive
        $autocompletion_recursive = AUTOCOMPLETION_RECURSIVE_DEFAUT;
        if (isset($options['autocompletion_recursive'])) {
            $autocompletion_recursive = ($options['autocompletion_recursive'] == true);
        }

        // afficher toutes les colonnes
        $toutes_colonnes = true;
        if (isset($options['toutes_colonnes'])) {
            $toutes_colonnes = ($options['toutes_colonnes'] == true);
        }
        $cle .= '_' . ($toutes_colonnes ? '1' : '0');

        // maj
        $maj = true;
        if (isset($options['maj'])) {
            $maj = ($options['maj'] == true);
        }
        $cle .= '_' . ($maj ? '1' : '0');

        if (false === $retour = self::$cache_db->read($cle)) {
            if ($toutes_colonnes) {
                $colonnes='Code_vue_utilisateur, vue_utilisateur_Recherche, vue_utilisateur_Filtre_Saison_Type, vue_utilisateur_Filtre_Couleur, vue_utilisateur_Filtre_Taille_Pays_Type, vue_utilisateur_Filtre_Taille_Max, vue_utilisateur_Filtre_Taille_Min';
            } else {
                $colonnes='Code_vue_utilisateur, vue_utilisateur_Recherche, vue_utilisateur_Filtre_Saison_Type, vue_utilisateur_Filtre_Couleur, vue_utilisateur_Filtre_Taille_Pays_Type, vue_utilisateur_Filtre_Taille_Max, vue_utilisateur_Filtre_Taille_Min';
            }
            $res_requete = executer_requete_mysql("SELECT $colonnes FROM " . inst('vue_utilisateur') . " WHERE Code_vue_utilisateur = $Code_vue_utilisateur;", false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                mf_formatage_db_type_php($row_requete);
                $retour = $row_requete;
            } else {
                $retour = [];
            }
            mysqli_free_result($res_requete);
            self::$cache_db->write($cle, $retour);
        }
        if (isset($retour['Code_vue_utilisateur'])) {
            if (($autocompletion_recursive || self::$auto_completion < 1) && $autocompletion) {
                self::$auto_completion ++;
                Hook_vue_utilisateur::completion($retour, self::$auto_completion - 1);
                self::$auto_completion --;
            }
        }
        return $retour;
    }

    public function mf_prec_et_suiv( int $Code_vue_utilisateur, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'liste_colonnes_a_selectionner' => [], 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $Code_vue_utilisateur = intval($Code_vue_utilisateur);
        $liste = $this->mf_lister($options);
        return prec_suiv($liste, $Code_vue_utilisateur);
    }

    public function mf_compter(?array $options = null /* $options = [ 'cond_mysql' => [] ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cle = 'vue_utilisateur__compter';

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql'])) {
            foreach ($options['cond_mysql'] as &$condition) {
                $argument_cond .= " AND ($condition)";
            }
            unset($condition);
        }
        $cle .= "_$argument_cond";

        if (false === $nb = self::$cache_db->read($cle)) {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ($argument_cond != '') {
                if ( strpos($argument_cond, 'vue_utilisateur_Recherche')!==false ) { $liste_colonnes_a_indexer['vue_utilisateur_Recherche'] = 'vue_utilisateur_Recherche'; }
                if ( strpos($argument_cond, 'vue_utilisateur_Filtre_Saison_Type')!==false ) { $liste_colonnes_a_indexer['vue_utilisateur_Filtre_Saison_Type'] = 'vue_utilisateur_Filtre_Saison_Type'; }
                if ( strpos($argument_cond, 'vue_utilisateur_Filtre_Couleur')!==false ) { $liste_colonnes_a_indexer['vue_utilisateur_Filtre_Couleur'] = 'vue_utilisateur_Filtre_Couleur'; }
                if ( strpos($argument_cond, 'vue_utilisateur_Filtre_Taille_Pays_Type')!==false ) { $liste_colonnes_a_indexer['vue_utilisateur_Filtre_Taille_Pays_Type'] = 'vue_utilisateur_Filtre_Taille_Pays_Type'; }
                if ( strpos($argument_cond, 'vue_utilisateur_Filtre_Taille_Max')!==false ) { $liste_colonnes_a_indexer['vue_utilisateur_Filtre_Taille_Max'] = 'vue_utilisateur_Filtre_Taille_Max'; }
                if ( strpos($argument_cond, 'vue_utilisateur_Filtre_Taille_Min')!==false ) { $liste_colonnes_a_indexer['vue_utilisateur_Filtre_Taille_Min'] = 'vue_utilisateur_Filtre_Taille_Min'; }
            }
            if (count($liste_colonnes_a_indexer) > 0) {
                if (false === $mf_liste_requete_index = self::$cache_db->read('vue_utilisateur__index')) {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('vue_utilisateur').'`;', false);
                    $mf_liste_requete_index = [];
                    while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    self::$cache_db->write('vue_utilisateur__index', $mf_liste_requete_index);
                }
                foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if (count($liste_colonnes_a_indexer) > 0) {
                    foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                        executer_requete_mysql('ALTER TABLE `'.inst('vue_utilisateur').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    self::$cache_db->clear();
                }
            }

            $res_requete = executer_requete_mysql('SELECT count(Code_vue_utilisateur) as nb FROM ' . inst('vue_utilisateur')." WHERE 1{$argument_cond};", false);
            $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC);
            mysqli_free_result($res_requete);
            $nb = (int) $row_requete['nb'];
            self::$cache_db->write($cle, $nb);
        }
        return $nb;
    }

    public function mfi_compter( array $interface, ?array $options = null /* $options = [ 'cond_mysql' => [] ] */ )
    {
        if ($options === null) {
            $options=[];
        }
        return $this->mf_compter( $options );
    }

    public function mf_liste_Code_vue_utilisateur(?array $options = null /* $options = [ 'cond_mysql' => [] ] */)
    {
        if ($options === null) {
            $options=[];
        }
        return $this->get_liste_Code_vue_utilisateur($options);
    }

    public function mf_get_liste_tables_parents()
    {
        return [];
    }

    public function mf_search_vue_utilisateur_Recherche(string $vue_utilisateur_Recherche): int
    {
        return $this->rechercher_vue_utilisateur_Recherche($vue_utilisateur_Recherche);
    }

    public function mf_search_vue_utilisateur_Filtre_Saison_Type(int $vue_utilisateur_Filtre_Saison_Type): int
    {
        return $this->rechercher_vue_utilisateur_Filtre_Saison_Type($vue_utilisateur_Filtre_Saison_Type);
    }

    public function mf_search_vue_utilisateur_Filtre_Couleur(string $vue_utilisateur_Filtre_Couleur): int
    {
        return $this->rechercher_vue_utilisateur_Filtre_Couleur($vue_utilisateur_Filtre_Couleur);
    }

    public function mf_search_vue_utilisateur_Filtre_Taille_Pays_Type(int $vue_utilisateur_Filtre_Taille_Pays_Type): int
    {
        return $this->rechercher_vue_utilisateur_Filtre_Taille_Pays_Type($vue_utilisateur_Filtre_Taille_Pays_Type);
    }

    public function mf_search_vue_utilisateur_Filtre_Taille_Max(int $vue_utilisateur_Filtre_Taille_Max): int
    {
        return $this->rechercher_vue_utilisateur_Filtre_Taille_Max($vue_utilisateur_Filtre_Taille_Max);
    }

    public function mf_search_vue_utilisateur_Filtre_Taille_Min(int $vue_utilisateur_Filtre_Taille_Min): int
    {
        return $this->rechercher_vue_utilisateur_Filtre_Taille_Min($vue_utilisateur_Filtre_Taille_Min);
    }

    public function mf_search__colonne(string $colonne_db, $recherche): int
    {
        switch ($colonne_db) {
            case 'vue_utilisateur_Recherche': return $this->mf_search_vue_utilisateur_Recherche($recherche); break;
            case 'vue_utilisateur_Filtre_Saison_Type': return $this->mf_search_vue_utilisateur_Filtre_Saison_Type($recherche); break;
            case 'vue_utilisateur_Filtre_Couleur': return $this->mf_search_vue_utilisateur_Filtre_Couleur($recherche); break;
            case 'vue_utilisateur_Filtre_Taille_Pays_Type': return $this->mf_search_vue_utilisateur_Filtre_Taille_Pays_Type($recherche); break;
            case 'vue_utilisateur_Filtre_Taille_Max': return $this->mf_search_vue_utilisateur_Filtre_Taille_Max($recherche); break;
            case 'vue_utilisateur_Filtre_Taille_Min': return $this->mf_search_vue_utilisateur_Filtre_Taille_Min($recherche); break;
            default: return 0;
        }
    }

    public function mf_get_next_id(): int
    {
        $res_requete = executer_requete_mysql('SELECT AUTO_INCREMENT as next_id FROM INFORMATION_SCHEMA.TABLES WHERE table_name = \'' . inst('vue_utilisateur') . '\';', false);
        $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC);
        mysqli_free_result($res_requete);
        return intval($row_requete['next_id']);
    }

    public function mf_search(array $ligne): int // array('colonne1' => 'valeur1',  [...] )
    {
        global $mf_initialisation;
        $vue_utilisateur_Recherche = (isset($ligne['vue_utilisateur_Recherche']) ? $ligne['vue_utilisateur_Recherche'] : $mf_initialisation['vue_utilisateur_Recherche']);
        $vue_utilisateur_Filtre_Saison_Type = (isset($ligne['vue_utilisateur_Filtre_Saison_Type']) ? $ligne['vue_utilisateur_Filtre_Saison_Type'] : $mf_initialisation['vue_utilisateur_Filtre_Saison_Type']);
        $vue_utilisateur_Filtre_Couleur = (isset($ligne['vue_utilisateur_Filtre_Couleur']) ? $ligne['vue_utilisateur_Filtre_Couleur'] : $mf_initialisation['vue_utilisateur_Filtre_Couleur']);
        $vue_utilisateur_Filtre_Taille_Pays_Type = (isset($ligne['vue_utilisateur_Filtre_Taille_Pays_Type']) ? $ligne['vue_utilisateur_Filtre_Taille_Pays_Type'] : $mf_initialisation['vue_utilisateur_Filtre_Taille_Pays_Type']);
        $vue_utilisateur_Filtre_Taille_Max = (isset($ligne['vue_utilisateur_Filtre_Taille_Max']) ? $ligne['vue_utilisateur_Filtre_Taille_Max'] : $mf_initialisation['vue_utilisateur_Filtre_Taille_Max']);
        $vue_utilisateur_Filtre_Taille_Min = (isset($ligne['vue_utilisateur_Filtre_Taille_Min']) ? $ligne['vue_utilisateur_Filtre_Taille_Min'] : $mf_initialisation['vue_utilisateur_Filtre_Taille_Min']);
        // Typage
        $vue_utilisateur_Recherche = (string) $vue_utilisateur_Recherche;
        $vue_utilisateur_Filtre_Saison_Type = is_null($vue_utilisateur_Filtre_Saison_Type) || $vue_utilisateur_Filtre_Saison_Type === '' ? null : (int) $vue_utilisateur_Filtre_Saison_Type;
        $vue_utilisateur_Filtre_Couleur = (string) $vue_utilisateur_Filtre_Couleur;
        $vue_utilisateur_Filtre_Taille_Pays_Type = is_null($vue_utilisateur_Filtre_Taille_Pays_Type) || $vue_utilisateur_Filtre_Taille_Pays_Type === '' ? null : (int) $vue_utilisateur_Filtre_Taille_Pays_Type;
        $vue_utilisateur_Filtre_Taille_Max = is_null($vue_utilisateur_Filtre_Taille_Max) || $vue_utilisateur_Filtre_Taille_Max === '' ? null : (int) $vue_utilisateur_Filtre_Taille_Max;
        $vue_utilisateur_Filtre_Taille_Min = is_null($vue_utilisateur_Filtre_Taille_Min) || $vue_utilisateur_Filtre_Taille_Min === '' ? null : (int) $vue_utilisateur_Filtre_Taille_Min;
        // Fin typage
        Hook_vue_utilisateur::pre_controller($vue_utilisateur_Recherche, $vue_utilisateur_Filtre_Saison_Type, $vue_utilisateur_Filtre_Couleur, $vue_utilisateur_Filtre_Taille_Pays_Type, $vue_utilisateur_Filtre_Taille_Max, $vue_utilisateur_Filtre_Taille_Min);
        $mf_cle_unique = Hook_vue_utilisateur::calcul_cle_unique($vue_utilisateur_Recherche, $vue_utilisateur_Filtre_Saison_Type, $vue_utilisateur_Filtre_Couleur, $vue_utilisateur_Filtre_Taille_Pays_Type, $vue_utilisateur_Filtre_Taille_Max, $vue_utilisateur_Filtre_Taille_Min);
        $res_requete = executer_requete_mysql('SELECT Code_vue_utilisateur FROM ' . inst('vue_utilisateur') . ' WHERE mf_cle_unique = \'' . $mf_cle_unique . '\'', false);
        if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
            $r = intval($row_requete['Code_vue_utilisateur']);
        } else {
            $r = 0;
        }
        mysqli_free_result($res_requete);
        return $r;
    }
}
