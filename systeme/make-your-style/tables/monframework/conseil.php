<?php declare(strict_types=1);

/*
    +------------------------------+
    |  NE PAS MODIFIER CE FICHIER  |
    +------------------------------+
*/

class table_conseil_monframework extends entite
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
            include_once __DIR__ . '/../../erreurs/erreurs__conseil.php';
            self::$initialisation = false;
            Hook_conseil::initialisation();
            self::$cache_db = new Mf_Cachedb('conseil');
        }
        if (! self::$actualisation_en_cours) {
            self::$actualisation_en_cours=true;
            Hook_conseil::actualisation();
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

        if (! test_si_table_existe(inst('conseil'))) {
            executer_requete_mysql('CREATE TABLE '.inst('conseil').'(Code_conseil BIGINT UNSIGNED NOT NULL AUTO_INCREMENT, PRIMARY KEY (Code_conseil)) ENGINE=MyISAM;', array_search('conseil', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        $liste_colonnes = lister_les_colonnes('conseil');

        if (isset($liste_colonnes['conseil_Libelle'])) {
            if (typeMyql2Sql($liste_colonnes['conseil_Libelle']['Type'])!='VARCHAR') {
                executer_requete_mysql('ALTER TABLE '.inst('conseil').' CHANGE conseil_Libelle conseil_Libelle VARCHAR(255);', array_search('conseil', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['conseil_Libelle']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('conseil').' ADD conseil_Libelle VARCHAR(255);', array_search('conseil', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE '.inst('conseil').' SET conseil_Libelle=' . format_sql('conseil_Libelle', $mf_initialisation['conseil_Libelle']) . ';', array_search('conseil', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if (isset($liste_colonnes['conseil_Description'])) {
            if (typeMyql2Sql($liste_colonnes['conseil_Description']['Type'])!='TEXT') {
                executer_requete_mysql('ALTER TABLE '.inst('conseil').' CHANGE conseil_Description conseil_Description TEXT;', array_search('conseil', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['conseil_Description']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('conseil').' ADD conseil_Description TEXT;', array_search('conseil', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE '.inst('conseil').' SET conseil_Description=' . format_sql('conseil_Description', $mf_initialisation['conseil_Description']) . ';', array_search('conseil', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if (isset($liste_colonnes['conseil_Actif'])) {
            if (typeMyql2Sql($liste_colonnes['conseil_Actif']['Type'])!='BOOL') {
                executer_requete_mysql('ALTER TABLE '.inst('conseil').' CHANGE conseil_Actif conseil_Actif BOOL;', array_search('conseil', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['conseil_Actif']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('conseil').' ADD conseil_Actif BOOL;', array_search('conseil', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE '.inst('conseil').' SET conseil_Actif=' . format_sql('conseil_Actif', $mf_initialisation['conseil_Actif']) . ';', array_search('conseil', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        $liste_colonnes_a_indexer = [];

        if (isset($liste_colonnes['mf_signature'])) {
            unset($liste_colonnes['mf_signature']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('conseil').' ADD mf_signature VARCHAR(255);', array_search('conseil', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }
        $liste_colonnes_a_indexer['mf_signature'] = 'mf_signature';

        if (isset($liste_colonnes['mf_cle_unique'])) {
            unset($liste_colonnes['mf_cle_unique']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('conseil').' ADD mf_cle_unique VARCHAR(255);', array_search('conseil', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }
        $liste_colonnes_a_indexer['mf_cle_unique'] = 'mf_cle_unique';

        if (isset($liste_colonnes['mf_date_creation'])) {
            unset($liste_colonnes['mf_date_creation']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('conseil').' ADD mf_date_creation DATETIME;', array_search('conseil', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }
        $liste_colonnes_a_indexer['mf_date_creation'] = 'mf_date_creation';

        if (isset($liste_colonnes['mf_date_modification'])) {
            unset($liste_colonnes['mf_date_modification']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('conseil').' ADD mf_date_modification DATETIME;', array_search('conseil', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }
        $liste_colonnes_a_indexer['mf_date_modification'] = 'mf_date_modification';

        unset($liste_colonnes['Code_conseil']);

        foreach ($liste_colonnes as $field => $value) {
            executer_requete_mysql('ALTER TABLE '.inst('conseil').' DROP COLUMN '.$field.';', array_search('conseil', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `' . inst('conseil') . '`;', false);
        $mf_liste_requete_index = [];
        while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
            $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
        }
        mysqli_free_result($res_requete_index);
        foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
            if (isset($liste_colonnes_a_indexer[$mf_colonne_indexee])) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
        }
        foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
            executer_requete_mysql('ALTER TABLE `' . inst('conseil') . '` ADD INDEX(`' . $colonnes_a_indexer . '`);', array_search('conseil', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }
    }

    /**
     * Retourne la tructure de la table « conseil » avec les valeurs initialisées par défaut.
     * @return array
     */
    public function mf_get_structure(): array
    {
        global $mf_initialisation;
        $struc = [
            'Code_conseil' => null, // ID
            'conseil_Libelle' => $mf_initialisation['conseil_Libelle'],
            'conseil_Description' => $mf_initialisation['conseil_Description'],
            'conseil_Actif' => $mf_initialisation['conseil_Actif'],
        ];
        mf_formatage_db_type_php($struc);
        Hook_conseil::pre_controller($struc['conseil_Libelle'], $struc['conseil_Description'], $struc['conseil_Actif'], $struc['Code_conseil']);
        return $struc;
    }

    public function mf_ajouter(string $conseil_Libelle, string $conseil_Description, bool $conseil_Actif, ?bool $force = false)
    {
        if ($force === null) {
            $force = false;
        }
        $Code_conseil = 0;
        $code_erreur = 0;
        // Typage
        $conseil_Libelle = (string) $conseil_Libelle;
        $conseil_Description = (string) $conseil_Description;
        $conseil_Actif = ($conseil_Actif == true);
        // Fin typage
        Hook_conseil::pre_controller($conseil_Libelle, $conseil_Description, $conseil_Actif);
        if (! $force) {
            if (! self::$maj_droits_ajouter_en_cours) {
                self::$maj_droits_ajouter_en_cours = true;
                Hook_conseil::hook_actualiser_les_droits_ajouter();
                self::$maj_droits_ajouter_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['conseil__AJOUTER']) ) $code_erreur = REFUS_CONSEIL__AJOUTER;
        elseif (! Hook_conseil::autorisation_ajout($conseil_Libelle, $conseil_Description, $conseil_Actif) ) $code_erreur = REFUS_CONSEIL__AJOUT_BLOQUEE;
        else {
            Hook_conseil::data_controller($conseil_Libelle, $conseil_Description, $conseil_Actif);
            $mf_signature = text_sql(Hook_conseil::calcul_signature($conseil_Libelle, $conseil_Description, $conseil_Actif));
            $mf_cle_unique = text_sql(Hook_conseil::calcul_cle_unique($conseil_Libelle, $conseil_Description, $conseil_Actif));
            $conseil_Libelle = text_sql($conseil_Libelle);
            $conseil_Description = text_sql($conseil_Description);
            $conseil_Actif = ($conseil_Actif == true ? 1 : 0);
            $requete = "INSERT INTO " . inst('conseil') . " ( mf_signature, mf_cle_unique, mf_date_creation, mf_date_modification, conseil_Libelle, conseil_Description, conseil_Actif ) VALUES ( '$mf_signature', '$mf_cle_unique', '".get_now()."', '".get_now()."', '$conseil_Libelle', '$conseil_Description', $conseil_Actif );";
            executer_requete_mysql($requete, array_search('conseil', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            $Code_conseil = requete_mysql_insert_id();
            if ($Code_conseil == 0) {
                $code_erreur = ERR_CONSEIL__AJOUTER__AJOUT_REFUSE;
            } else {
                self::$cache_db->clear();
                Hook_conseil::ajouter( $Code_conseil );
            }
        }
        if ($code_erreur != 0) {
            global $mf_message_erreur_personalise, $mf_libelle_erreur;
            if ($mf_message_erreur_personalise != '') {
                $mf_libelle_erreur[$code_erreur] = $mf_message_erreur_personalise;
                $mf_message_erreur_personalise = '';
            }
        }
        return ['code_erreur' => $code_erreur, 'Code_conseil' => $Code_conseil, 'callback' => ( $code_erreur==0 ? Hook_conseil::callback_post($Code_conseil) : null )];
    }

    public function mf_creer(?bool $force = null)
    {
        if ($force === null) {
            $force = false;
        }
        global $mf_initialisation;
        $conseil_Libelle = $mf_initialisation['conseil_Libelle'];
        $conseil_Description = $mf_initialisation['conseil_Description'];
        $conseil_Actif = $mf_initialisation['conseil_Actif'];
        // Typage
        $conseil_Libelle = (string) $conseil_Libelle;
        $conseil_Description = (string) $conseil_Description;
        $conseil_Actif = ($conseil_Actif == true);
        // Fin typage
        return $this->mf_ajouter($conseil_Libelle, $conseil_Description, $conseil_Actif, $force);
    }

    public function mf_ajouter_2(array $ligne, bool $force = null) // array('colonne1' => 'valeur1',  [...] )
    {
        if ($force === null) {
            $force = false;
        }
        global $mf_initialisation;
        $conseil_Libelle = (isset($ligne['conseil_Libelle'])?$ligne['conseil_Libelle']:$mf_initialisation['conseil_Libelle']);
        $conseil_Description = (isset($ligne['conseil_Description'])?$ligne['conseil_Description']:$mf_initialisation['conseil_Description']);
        $conseil_Actif = (isset($ligne['conseil_Actif'])?$ligne['conseil_Actif']:$mf_initialisation['conseil_Actif']);
        // Typage
        $conseil_Libelle = (string) $conseil_Libelle;
        $conseil_Description = (string) $conseil_Description;
        $conseil_Actif = ($conseil_Actif == true);
        // Fin typage
        return $this->mf_ajouter($conseil_Libelle, $conseil_Description, $conseil_Actif, $force);
    }

    public function mf_ajouter_3(array $lignes) // array( array( 'colonne1' => 'valeur1', 'colonne2' => 'valeur2',  [...] ), [...] )
    {
        global $mf_initialisation;
        $code_erreur = 0;
        $values = '';
        foreach ($lignes as $ligne) {
            $conseil_Libelle = text_sql((isset($ligne['conseil_Libelle']) ? $ligne['conseil_Libelle'] : $mf_initialisation['conseil_Libelle']));
            $conseil_Description = text_sql((isset($ligne['conseil_Description']) ? $ligne['conseil_Description'] : $mf_initialisation['conseil_Description']));
            $conseil_Actif = ((isset($ligne['conseil_Actif']) ? $ligne['conseil_Actif'] : $mf_initialisation['conseil_Actif']) == true ? 1 : 0);
            $values .= ($values != '' ? ',' : '') . "('$conseil_Libelle', '$conseil_Description', $conseil_Actif)";
        }
        if ($values != '') {
            $requete = "INSERT INTO " . inst('conseil') . " ( conseil_Libelle, conseil_Description, conseil_Actif ) VALUES $values;";
            executer_requete_mysql( $requete , array_search('conseil', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            $n = requete_mysqli_affected_rows();
            if ($n < count($lignes)) {
                $code_erreur = ERR_CONSEIL__AJOUTER_3__ECHEC_AJOUT;
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

    public function mf_actualiser_signature(int $Code_conseil)
    {
        $conseil = $this->mf_get_2($Code_conseil, ['autocompletion' => false]);
        $mf_signature = text_sql(Hook_conseil::calcul_signature($conseil['conseil_Libelle'], $conseil['conseil_Description'], $conseil['conseil_Actif']));
        $mf_cle_unique = text_sql(Hook_conseil::calcul_cle_unique($conseil['conseil_Libelle'], $conseil['conseil_Description'], $conseil['conseil_Actif']));
        $table = inst('conseil');
        executer_requete_mysql("UPDATE $table SET mf_signature='$mf_signature', mf_cle_unique='$mf_cle_unique' WHERE Code_conseil=$Code_conseil;", array_search('conseil', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        if (requete_mysqli_affected_rows() == 1) {
            self::$cache_db->clear();
        }
    }

    public function mf_modifier( int $Code_conseil, string $conseil_Libelle, string $conseil_Description, bool $conseil_Actif, ?bool $force = null)
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        // Typage
        $conseil_Libelle = (string) $conseil_Libelle;
        $conseil_Description = (string) $conseil_Description;
        $conseil_Actif = ($conseil_Actif == true);
        // Fin typage
        Hook_conseil::pre_controller($conseil_Libelle, $conseil_Description, $conseil_Actif, $Code_conseil);
        if (! $force) {
            if (! self::$maj_droits_modifier_en_cours) {
                self::$maj_droits_modifier_en_cours = true;
                Hook_conseil::hook_actualiser_les_droits_modifier($Code_conseil);
                self::$maj_droits_modifier_en_cours = false;
            }
        }
        $conseil = $this->mf_get_2( $Code_conseil, ['autocompletion' => false, 'masquer_mdp' => false]);
        if ( !$force && !mf_matrice_droits(['conseil__MODIFIER']) ) $code_erreur = REFUS_CONSEIL__MODIFIER;
        elseif (! $this->mf_tester_existance_Code_conseil($Code_conseil)) $code_erreur = ERR_CONSEIL__MODIFIER__CODE_CONSEIL_INEXISTANT;
        elseif (CONTROLE_ACCES_DONNEES_DEFAUT && ! Hook_mf_systeme::controle_acces_donnees('Code_conseil', $Code_conseil)) $code_erreur = ACCES_CODE_CONSEIL_REFUSE;
        elseif ( !Hook_conseil::autorisation_modification($Code_conseil, $conseil_Libelle, $conseil_Description, $conseil_Actif) ) $code_erreur = REFUS_CONSEIL__MODIFICATION_BLOQUEE;
        else {
            if (! isset(self::$lock[$Code_conseil])) {
                self::$lock[$Code_conseil] = 0;
            }
            if (self::$lock[$Code_conseil] == 0) {
                self::$cache_db->add_lock((string) $Code_conseil);
            }
            self::$lock[$Code_conseil]++;
            Hook_conseil::data_controller($conseil_Libelle, $conseil_Description, $conseil_Actif, $Code_conseil);
            $mf_colonnes_a_modifier=[];
            $bool__conseil_Libelle = false; if ($conseil_Libelle !== $conseil['conseil_Libelle']) {Hook_conseil::data_controller__conseil_Libelle($conseil['conseil_Libelle'], $conseil_Libelle, $Code_conseil); if ( $conseil_Libelle !== $conseil['conseil_Libelle'] ) { $mf_colonnes_a_modifier[] = 'conseil_Libelle=' . format_sql('conseil_Libelle', $conseil_Libelle); $bool__conseil_Libelle = true;}}
            $bool__conseil_Description = false; if ($conseil_Description !== $conseil['conseil_Description']) {Hook_conseil::data_controller__conseil_Description($conseil['conseil_Description'], $conseil_Description, $Code_conseil); if ( $conseil_Description !== $conseil['conseil_Description'] ) { $mf_colonnes_a_modifier[] = 'conseil_Description=' . format_sql('conseil_Description', $conseil_Description); $bool__conseil_Description = true;}}
            $bool__conseil_Actif = false; if ($conseil_Actif !== $conseil['conseil_Actif']) {Hook_conseil::data_controller__conseil_Actif($conseil['conseil_Actif'], $conseil_Actif, $Code_conseil); if ( $conseil_Actif !== $conseil['conseil_Actif'] ) { $mf_colonnes_a_modifier[] = 'conseil_Actif=' . format_sql('conseil_Actif', $conseil_Actif); $bool__conseil_Actif = true;}}
            if (count($mf_colonnes_a_modifier) > 0) {
                $mf_signature = text_sql(Hook_conseil::calcul_signature($conseil_Libelle, $conseil_Description, $conseil_Actif));
                $mf_cle_unique = text_sql(Hook_conseil::calcul_cle_unique($conseil_Libelle, $conseil_Description, $conseil_Actif));
                $mf_colonnes_a_modifier[] = 'mf_signature=\'' . $mf_signature . '\'';
                $mf_colonnes_a_modifier[] = 'mf_cle_unique=\'' . $mf_cle_unique . '\'';
                $mf_colonnes_a_modifier[] = 'mf_date_modification=\'' . get_now() . '\'';
                $requete = 'UPDATE '.inst('conseil').' SET ' . enumeration($mf_colonnes_a_modifier) . ' WHERE Code_conseil = ' . $Code_conseil . ';';
                executer_requete_mysql($requete, array_search('conseil', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
                if (requete_mysqli_affected_rows() == 0) {
                    $code_erreur = ERR_CONSEIL__MODIFIER__AUCUN_CHANGEMENT;
                } else {
                    self::$cache_db->clear();
                    Hook_conseil::modifier($Code_conseil, $bool__conseil_Libelle, $bool__conseil_Description, $bool__conseil_Actif);
                }
            } else {
                $code_erreur = ERR_CONSEIL__MODIFIER__AUCUN_CHANGEMENT;
            }
            self::$lock[$Code_conseil]--;
            if (self::$lock[$Code_conseil] == 0) {
                self::$cache_db->release_lock((string) $Code_conseil);
                unset(self::$lock[$Code_conseil]);
            }
        }
        if ($code_erreur != 0) {
            global $mf_message_erreur_personalise, $mf_libelle_erreur;
            if ($mf_message_erreur_personalise != '') {
                $mf_libelle_erreur[$code_erreur] = $mf_message_erreur_personalise;
                $mf_message_erreur_personalise = '';
            }
        }
        return ['code_erreur' => $code_erreur, 'callback' => ($code_erreur == 0 ? Hook_conseil::callback_put($Code_conseil) : null)];
    }

    public function mf_modifier_2(array $lignes, ?bool $force = null) // array( $Code_conseil => array('colonne1' => 'valeur1',  [...] ) )
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        foreach ($lignes as $Code_conseil => $colonnes) {
            if ($code_erreur == 0) {
                $Code_conseil = intval($Code_conseil);
                $conseil = $this->mf_get_2($Code_conseil, ['autocompletion' => false]);
                if (! $force) {
                    if (! self::$maj_droits_modifier_en_cours) {
                        self::$maj_droits_modifier_en_cours = true;
                        Hook_conseil::hook_actualiser_les_droits_modifier($Code_conseil);
                        self::$maj_droits_modifier_en_cours = false;
                    }
                }
                $conseil_Libelle = (isset($colonnes['conseil_Libelle']) && ( $force || mf_matrice_droits(['api_modifier__conseil_Libelle', 'conseil__MODIFIER']) ) ? $colonnes['conseil_Libelle'] : ( isset($conseil['conseil_Libelle']) ? $conseil['conseil_Libelle'] : '' ) );
                $conseil_Description = (isset($colonnes['conseil_Description']) && ( $force || mf_matrice_droits(['api_modifier__conseil_Description', 'conseil__MODIFIER']) ) ? $colonnes['conseil_Description'] : ( isset($conseil['conseil_Description']) ? $conseil['conseil_Description'] : '' ) );
                $conseil_Actif = (isset($colonnes['conseil_Actif']) && ( $force || mf_matrice_droits(['api_modifier__conseil_Actif', 'conseil__MODIFIER']) ) ? $colonnes['conseil_Actif'] : ( isset($conseil['conseil_Actif']) ? $conseil['conseil_Actif'] : '' ) );
                // Typage
                $conseil_Libelle = (string) $conseil_Libelle;
                $conseil_Description = (string) $conseil_Description;
                $conseil_Actif = ($conseil_Actif == true);
                // Fin typage
                $retour = $this->mf_modifier($Code_conseil, $conseil_Libelle, $conseil_Description, $conseil_Actif, true);
                if ($retour['code_erreur'] != 0 && $retour['code_erreur'] != ERR_CONSEIL__MODIFIER__AUCUN_CHANGEMENT) {
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

    public function mf_modifier_3(array $lignes) // array( $Code_conseil => array('colonne1' => 'valeur1',  [...] ) )
    {
        $code_erreur = 0;
        $modifs = false;

        // transformation des lignes en colonnes
        $valeurs_en_colonnes = [];
        $indices_par_colonne = [];
        $liste_valeurs_indexees = [];
        foreach ($lignes as $Code_conseil => $colonnes) {
            foreach ($colonnes as $colonne => $valeur) {
                if ($colonne == 'conseil_Libelle' || $colonne == 'conseil_Description' || $colonne == 'conseil_Actif') {
                    $valeurs_en_colonnes[$colonne][$Code_conseil] = $valeur;
                    $indices_par_colonne[$colonne][] = $Code_conseil;
                    $liste_valeurs_indexees[$colonne]["$valeur"][] = $Code_conseil;
                }
            }
        }

        // fabrication des requetes
        foreach ($valeurs_en_colonnes as $colonne => $valeurs) {
            if (count($liste_valeurs_indexees[$colonne]) > 3) {
                $modification_sql = $colonne . ' = CASE Code_conseil';
                foreach ($valeurs as $Code_conseil => $valeur) {
                    $modification_sql .= ' WHEN ' . $Code_conseil . ' THEN ' . format_sql($colonne, $valeur);
                }
                $modification_sql .= ' END';
                $perimetre = Sql_Format_Liste($indices_par_colonne[$colonne]);
                executer_requete_mysql('UPDATE ' . inst('conseil') . ' SET ' . $modification_sql . ' WHERE Code_conseil IN ' . $perimetre . ';', array_search('conseil', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
                if (requete_mysqli_affected_rows() != 0) {
                    $modifs = true;
                }
            } else {
                foreach ($liste_valeurs_indexees[$colonne] as $valeur => $indices_par_valeur) {
                    $perimetre = Sql_Format_Liste($indices_par_valeur);
                    executer_requete_mysql('UPDATE ' . inst('conseil') . ' SET ' . $colonne . ' = ' . format_sql($colonne, $valeur) . ' WHERE Code_conseil IN ' . $perimetre . ';', array_search('conseil', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
                    if (requete_mysqli_affected_rows() != 0) {
                        $modifs = true;
                    }
                }
            }
        }

        if (! $modifs && $code_erreur == 0) {
            $code_erreur = ERR_CONSEIL__MODIFIER_3__AUCUN_CHANGEMENT;
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
        if (isset($data['conseil_Libelle']) || array_key_exists('conseil_Libelle', $data)) { $mf_colonnes_a_modifier[] = 'conseil_Libelle = ' . format_sql('conseil_Libelle', $data['conseil_Libelle']); }
        if (isset($data['conseil_Description']) || array_key_exists('conseil_Description', $data)) { $mf_colonnes_a_modifier[] = 'conseil_Description = ' . format_sql('conseil_Description', $data['conseil_Description']); }
        if (isset($data['conseil_Actif']) || array_key_exists('conseil_Actif', $data)) { $mf_colonnes_a_modifier[] = 'conseil_Actif = ' . format_sql('conseil_Actif', $data['conseil_Actif']); }
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

            $requete = 'UPDATE ' . inst('conseil') . ' SET ' . enumeration($mf_colonnes_a_modifier) . " WHERE 1$argument_cond" . ( $limit>0 ? ' LIMIT ' . $limit : '' ) . ";";
            executer_requete_mysql( $requete , array_search('conseil', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            if (requete_mysqli_affected_rows() == 0) {
                $code_erreur = ERR_CONSEIL__MODIFIER_4__AUCUN_CHANGEMENT;
            } else {
                self::$cache_db->clear();
            }
        }
        return ['code_erreur' => $code_erreur];
    }

    public function mf_supprimer(int $Code_conseil, ?bool $force = null)
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        $Code_conseil = intval($Code_conseil);
        if (! $force) {
            if (!self::$maj_droits_supprimer_en_cours)
            {
                self::$maj_droits_supprimer_en_cours = true;
                Hook_conseil::hook_actualiser_les_droits_supprimer($Code_conseil);
                self::$maj_droits_supprimer_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['conseil__SUPPRIMER']) ) $code_erreur = REFUS_CONSEIL__SUPPRIMER;
        elseif (! $this->mf_tester_existance_Code_conseil($Code_conseil) ) $code_erreur = ERR_CONSEIL__SUPPRIMER_2__CODE_CONSEIL_INEXISTANT;
        elseif (CONTROLE_ACCES_DONNEES_DEFAUT && ! Hook_mf_systeme::controle_acces_donnees('Code_conseil', $Code_conseil)) $code_erreur = ACCES_CODE_CONSEIL_REFUSE;
        elseif ( !Hook_conseil::autorisation_suppression($Code_conseil) ) $code_erreur = REFUS_CONSEIL__SUPPRESSION_BLOQUEE;
        else
        {
            $copie__conseil = $this->mf_get($Code_conseil, ['autocompletion' => false]);
            $this->supprimer_donnes_en_cascade("conseil", [$Code_conseil]);
            $requete = 'DELETE IGNORE FROM ' . inst('conseil') . ' WHERE Code_conseil=' . $Code_conseil . ';';
            executer_requete_mysql($requete, array_search('conseil', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            if (requete_mysqli_affected_rows() == 0) {
                $code_erreur = ERR_CONSEIL__SUPPRIMER__REFUSEE;
            } else {
                self::$cache_db->clear();
                Hook_conseil::supprimer($copie__conseil);
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

    public function mf_supprimer_2(array $liste_Code_conseil, ?bool $force = null)
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        $copie__liste_conseil = $this->mf_lister_2($liste_Code_conseil, ['autocompletion' => false]);
        $liste_Code_conseil=[];
        foreach ( $copie__liste_conseil as $copie__conseil )
        {
            $Code_conseil = $copie__conseil['Code_conseil'];
            if (! $force) {
                if (!self::$maj_droits_supprimer_en_cours)
                {
                    self::$maj_droits_supprimer_en_cours = true;
                    Hook_conseil::hook_actualiser_les_droits_supprimer($Code_conseil);
                    self::$maj_droits_supprimer_en_cours = false;
                }
            }
            if ( !$force && !mf_matrice_droits(['conseil__SUPPRIMER']) ) $code_erreur = REFUS_CONSEIL__SUPPRIMER;
            elseif ( !Hook_conseil::autorisation_suppression($Code_conseil) ) $code_erreur = REFUS_CONSEIL__SUPPRESSION_BLOQUEE;
            {
                $liste_Code_conseil[] = $Code_conseil;
            }
        }
        if ($code_erreur == 0 && count($liste_Code_conseil) > 0) {
            $this->supprimer_donnes_en_cascade("conseil", $liste_Code_conseil);
            $requete = 'DELETE IGNORE FROM ' . inst('conseil') . ' WHERE Code_conseil IN ' . Sql_Format_Liste($liste_Code_conseil) . ';';
            executer_requete_mysql( $requete , array_search('conseil', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            if (requete_mysqli_affected_rows() == 0) {
                $code_erreur = ERR_CONSEIL__SUPPRIMER_2__REFUSEE;
            } else {
                self::$cache_db->clear();
                Hook_conseil::supprimer_2($copie__liste_conseil);
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

    public function mf_supprimer_3(array $liste_Code_conseil)
    {
        $code_erreur = 0;
        if (count($liste_Code_conseil) > 0) {
            $this->supprimer_donnes_en_cascade("conseil", $liste_Code_conseil);
            $requete = 'DELETE IGNORE FROM ' . inst('conseil') . ' WHERE Code_conseil IN ' . Sql_Format_Liste($liste_Code_conseil) . ';';
            executer_requete_mysql( $requete , array_search('conseil', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            if (requete_mysqli_affected_rows() == 0) {
                $code_erreur = ERR_CONSEIL__SUPPRIMER_3__REFUSEE;
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
        if (! $contexte_parent && $mf_contexte['Code_conseil'] != 0) {
            $conseil = $this->mf_get( $mf_contexte['Code_conseil'], $options);
            return [$conseil['Code_conseil'] => $conseil];
        } else {
            return $this->mf_lister($options);
        }
    }

    public function mf_lister(?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'liste_colonnes_a_selectionner' => [], 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cle = "conseil__lister";

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
            if (isset($mf_tri_defaut_table['conseil'])) {
                $options['tris'] = $mf_tri_defaut_table['conseil'];
            }
        }
        foreach ($options['tris'] as $colonne => $tri) {
            if ($colonne != 'conseil_Description') {
                if ( $argument_tris=='' ) { $argument_tris = ' ORDER BY '; } else { $argument_tris .= ', '; }
                if ( $tri!='DESC' ) $tri = 'ASC';
                $argument_tris .= $colonne.' '.$tri;
            }
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
            $liste_conseil_pas_a_jour = [];
            if (false === $liste = self::$cache_db->read($cle)) {

                // Indexes
                $liste_colonnes_a_indexer = [];
                if ($argument_cond != '') {
                    if ( strpos($argument_cond, 'conseil_Libelle')!==false ) { $liste_colonnes_a_indexer['conseil_Libelle'] = 'conseil_Libelle'; }
                    if ( strpos($argument_cond, 'conseil_Actif')!==false ) { $liste_colonnes_a_indexer['conseil_Actif'] = 'conseil_Actif'; }
                }
                if (isset($options['tris'])) {
                    if ( isset($options['tris']['conseil_Libelle']) ) { $liste_colonnes_a_indexer['conseil_Libelle'] = 'conseil_Libelle'; }
                    if ( isset($options['tris']['conseil_Actif']) ) { $liste_colonnes_a_indexer['conseil_Actif'] = 'conseil_Actif'; }
                }
                if (count($liste_colonnes_a_indexer) > 0) {
                    if (false === $mf_liste_requete_index = self::$cache_db->read('conseil__index')) {
                        $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('conseil').'`;', false);
                        $mf_liste_requete_index = [];
                        while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                            $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                        }
                        mysqli_free_result($res_requete_index);
                        self::$cache_db->write('conseil__index', $mf_liste_requete_index);
                    }
                    foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                        if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                    }
                    if (count($liste_colonnes_a_indexer) > 0) {
                        foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                            executer_requete_mysql('ALTER TABLE `'.inst('conseil').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                        }
                        self::$cache_db->clear();
                    }
                }

                if (count($liste_colonnes_a_selectionner) == 0) {
                    if ($toutes_colonnes) {
                        $colonnes = 'Code_conseil, conseil_Libelle, conseil_Description, conseil_Actif';
                    } else {
                        $colonnes = 'Code_conseil, conseil_Libelle, conseil_Actif';
                    }
                } else {
                    $liste_colonnes_a_selectionner[] = 'Code_conseil';
                    $colonnes = enumeration($liste_colonnes_a_selectionner, ',');
                }

                $liste = [];
                $liste_conseil_pas_a_jour = [];
                $res_requete = executer_requete_mysql("SELECT $colonnes FROM " . inst('conseil') . " WHERE 1{$argument_cond}{$argument_tris}{$argument_limit};", false);
                while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                    mf_formatage_db_type_php($row_requete);
                    $liste[$row_requete['Code_conseil']] = $row_requete;
                    if ($maj && ! Hook_conseil::est_a_jour($row_requete)) {
                        $liste_conseil_pas_a_jour[$row_requete['Code_conseil']] = $row_requete;
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
                Hook_conseil::mettre_a_jour( $liste_conseil_pas_a_jour );
            }
        }

        foreach ($liste as $elem) {
            if ($controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_conseil', $elem['Code_conseil'])) {
                unset($liste[$elem['Code_conseil']]);
            } else {
                if (($autocompletion_recursive || self::$auto_completion < 1) && $autocompletion) {
                    self::$auto_completion ++;
                    Hook_conseil::completion($liste[$elem['Code_conseil']], self::$auto_completion - 1);
                    self::$auto_completion --;
                }
            }
        }

        return $liste;
    }

    public function mf_lister_2(array $liste_Code_conseil, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'liste_colonnes_a_selectionner' => [], 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        if (count($liste_Code_conseil) > 0) {
            $cle = "conseil__mf_lister_2_".Sql_Format_Liste($liste_Code_conseil);

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
                if (isset($mf_tri_defaut_table['conseil'])) {
                    $options['tris'] = $mf_tri_defaut_table['conseil'];
                }
            }
            foreach ($options['tris'] as $colonne => $tri) {
                if ($colonne != 'conseil_Description') {
                    if ( $argument_tris=='' ) { $argument_tris = ' ORDER BY '; } else { $argument_tris .= ', '; }
                    if ( $tri!='DESC' ) $tri = 'ASC';
                    $argument_tris .= $colonne.' '.$tri;
                }
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
                $liste_conseil_pas_a_jour = [];
                if (false === $liste = self::$cache_db->read($cle)) {

                    // Indexes
                    $liste_colonnes_a_indexer = [];
                    if ($argument_cond != '') {
                        if ( strpos($argument_cond, 'conseil_Libelle')!==false ) { $liste_colonnes_a_indexer['conseil_Libelle'] = 'conseil_Libelle'; }
                        if ( strpos($argument_cond, 'conseil_Actif')!==false ) { $liste_colonnes_a_indexer['conseil_Actif'] = 'conseil_Actif'; }
                    }
                    if (isset($options['tris'])) {
                        if ( isset($options['tris']['conseil_Libelle']) ) { $liste_colonnes_a_indexer['conseil_Libelle'] = 'conseil_Libelle'; }
                        if ( isset($options['tris']['conseil_Actif']) ) { $liste_colonnes_a_indexer['conseil_Actif'] = 'conseil_Actif'; }
                    }
                    if (count($liste_colonnes_a_indexer) > 0) {
                        if (false === $mf_liste_requete_index = self::$cache_db->read('conseil__index')) {
                            $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('conseil').'`;', false);
                            $mf_liste_requete_index = [];
                            while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                                $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                            }
                            mysqli_free_result($res_requete_index);
                            self::$cache_db->write('conseil__index', $mf_liste_requete_index);
                        }
                        foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                            if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                        }
                        if (count($liste_colonnes_a_indexer) > 0) {
                            foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                                executer_requete_mysql('ALTER TABLE `'.inst('conseil').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                            }
                            self::$cache_db->clear();
                        }
                    }

                    if (count($liste_colonnes_a_selectionner) == 0) {
                        if ($toutes_colonnes) {
                            $colonnes = 'Code_conseil, conseil_Libelle, conseil_Description, conseil_Actif';
                        } else {
                            $colonnes = 'Code_conseil, conseil_Libelle, conseil_Actif';
                        }
                    } else {
                        $liste_colonnes_a_selectionner[] = 'Code_conseil';
                        $colonnes = enumeration($liste_colonnes_a_selectionner, ',');
                    }

                    $liste = [];
                    $liste_conseil_pas_a_jour = [];
                    $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM ' . inst('conseil') . " WHERE 1{$argument_cond} AND Code_conseil IN ".Sql_Format_Liste($liste_Code_conseil)."{$argument_tris}{$argument_limit};", false);
                    while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                        mf_formatage_db_type_php($row_requete);
                        $liste[$row_requete['Code_conseil']] = $row_requete;
                        if ($maj && ! Hook_conseil::est_a_jour($row_requete)) {
                            $liste_conseil_pas_a_jour[$row_requete['Code_conseil']] = $row_requete;
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
                    Hook_conseil::mettre_a_jour( $liste_conseil_pas_a_jour );
                }
            }

            foreach ($liste as $elem) {
                if ($controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_conseil', $elem['Code_conseil'])) {
                    unset($liste[$elem['Code_conseil']]);
                } else {
                    if (($autocompletion_recursive || self::$auto_completion < 1) && $autocompletion) {
                        self::$auto_completion ++;
                        Hook_conseil::completion($liste[$elem['Code_conseil']], self::$auto_completion - 1);
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

    public function mf_get(int $Code_conseil, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $Code_conseil = intval($Code_conseil);
        $retour = [];
        if ( ! CONTROLE_ACCES_DONNEES_DEFAUT || Hook_mf_systeme::controle_acces_donnees('Code_conseil', $Code_conseil) ) {
            $cle = 'conseil__get_'.$Code_conseil;

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
                        $colonnes='Code_conseil, conseil_Libelle, conseil_Description, conseil_Actif';
                    } else {
                        $colonnes='Code_conseil, conseil_Libelle, conseil_Actif';
                    }
                    $res_requete = executer_requete_mysql("SELECT $colonnes FROM " . inst('conseil') . ' WHERE Code_conseil = ' . $Code_conseil . ';', false);
                    if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                        mf_formatage_db_type_php($row_requete);
                        $retour = $row_requete;
                        if ($maj && ! Hook_conseil::est_a_jour($row_requete)) {
                            $nouvelle_lecture = true;
                        }
                    } else {
                        $retour = [];
                    }
                    mysqli_free_result($res_requete);
                    if (! $nouvelle_lecture) {
                        self::$cache_db->write($cle, $retour);
                    } else {
                        Hook_conseil::mettre_a_jour([$row_requete['Code_conseil'] => $row_requete]);
                    }
                }
            }
            if (isset($retour['Code_conseil'])) {
                if (($autocompletion_recursive || self::$auto_completion < 1) && $autocompletion) {
                    self::$auto_completion ++;
                    Hook_conseil::completion($retour, self::$auto_completion - 1);
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
        $cle = "conseil__get_last";
        if (false === $retour = self::$cache_db->read($cle)) {
            $Code_conseil = 0;
            $res_requete = executer_requete_mysql('SELECT Code_conseil FROM ' . inst('conseil') . " WHERE 1 ORDER BY mf_date_creation DESC, Code_conseil DESC LIMIT 0 , 1;", false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $Code_conseil = intval($row_requete['Code_conseil']);
            }
            mysqli_free_result($res_requete);
            $retour = $this->mf_get($Code_conseil, $options);
            self::$cache_db->write($cle, $retour);
        }
        return $retour;
    }

    public function mf_get_2(int $Code_conseil, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cle = "conseil__get_$Code_conseil";

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
                $colonnes='Code_conseil, conseil_Libelle, conseil_Description, conseil_Actif';
            } else {
                $colonnes='Code_conseil, conseil_Libelle, conseil_Actif';
            }
            $res_requete = executer_requete_mysql("SELECT $colonnes FROM " . inst('conseil') . " WHERE Code_conseil = $Code_conseil;", false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                mf_formatage_db_type_php($row_requete);
                $retour = $row_requete;
            } else {
                $retour = [];
            }
            mysqli_free_result($res_requete);
            self::$cache_db->write($cle, $retour);
        }
        if (isset($retour['Code_conseil'])) {
            if (($autocompletion_recursive || self::$auto_completion < 1) && $autocompletion) {
                self::$auto_completion ++;
                Hook_conseil::completion($retour, self::$auto_completion - 1);
                self::$auto_completion --;
            }
        }
        return $retour;
    }

    public function mf_prec_et_suiv( int $Code_conseil, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'liste_colonnes_a_selectionner' => [], 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $Code_conseil = intval($Code_conseil);
        $liste = $this->mf_lister($options);
        return prec_suiv($liste, $Code_conseil);
    }

    public function mf_compter(?array $options = null /* $options = [ 'cond_mysql' => [] ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cle = 'conseil__compter';

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
                if ( strpos($argument_cond, 'conseil_Libelle')!==false ) { $liste_colonnes_a_indexer['conseil_Libelle'] = 'conseil_Libelle'; }
                if ( strpos($argument_cond, 'conseil_Actif')!==false ) { $liste_colonnes_a_indexer['conseil_Actif'] = 'conseil_Actif'; }
            }
            if (count($liste_colonnes_a_indexer) > 0) {
                if (false === $mf_liste_requete_index = self::$cache_db->read('conseil__index')) {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('conseil').'`;', false);
                    $mf_liste_requete_index = [];
                    while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    self::$cache_db->write('conseil__index', $mf_liste_requete_index);
                }
                foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if (count($liste_colonnes_a_indexer) > 0) {
                    foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                        executer_requete_mysql('ALTER TABLE `'.inst('conseil').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    self::$cache_db->clear();
                }
            }

            $res_requete = executer_requete_mysql('SELECT count(Code_conseil) as nb FROM ' . inst('conseil')." WHERE 1{$argument_cond};", false);
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

    public function mf_liste_Code_conseil(?array $options = null /* $options = [ 'cond_mysql' => [] ] */)
    {
        if ($options === null) {
            $options=[];
        }
        return $this->get_liste_Code_conseil($options);
    }

    public function mf_get_liste_tables_parents()
    {
        return [];
    }

    public function mf_search_conseil_Libelle(string $conseil_Libelle): int
    {
        return $this->rechercher_conseil_Libelle($conseil_Libelle);
    }

    public function mf_search_conseil_Actif(bool $conseil_Actif): int
    {
        return $this->rechercher_conseil_Actif($conseil_Actif);
    }

    public function mf_search__colonne(string $colonne_db, $recherche): int
    {
        switch ($colonne_db) {
            case 'conseil_Libelle': return $this->mf_search_conseil_Libelle($recherche); break;
            case 'conseil_Actif': return $this->mf_search_conseil_Actif($recherche); break;
            default: return 0;
        }
    }

    public function mf_get_next_id(): int
    {
        $res_requete = executer_requete_mysql('SELECT AUTO_INCREMENT as next_id FROM INFORMATION_SCHEMA.TABLES WHERE table_name = \'' . inst('conseil') . '\';', false);
        $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC);
        mysqli_free_result($res_requete);
        return intval($row_requete['next_id']);
    }

    public function mf_search(array $ligne): int // array('colonne1' => 'valeur1',  [...] )
    {
        global $mf_initialisation;
        $conseil_Libelle = (isset($ligne['conseil_Libelle']) ? $ligne['conseil_Libelle'] : $mf_initialisation['conseil_Libelle']);
        $conseil_Description = (isset($ligne['conseil_Description']) ? $ligne['conseil_Description'] : $mf_initialisation['conseil_Description']);
        $conseil_Actif = (isset($ligne['conseil_Actif']) ? $ligne['conseil_Actif'] : $mf_initialisation['conseil_Actif']);
        // Typage
        $conseil_Libelle = (string) $conseil_Libelle;
        $conseil_Description = (string) $conseil_Description;
        $conseil_Actif = ($conseil_Actif == true);
        // Fin typage
        Hook_conseil::pre_controller($conseil_Libelle, $conseil_Description, $conseil_Actif);
        $mf_cle_unique = Hook_conseil::calcul_cle_unique($conseil_Libelle, $conseil_Description, $conseil_Actif);
        $res_requete = executer_requete_mysql('SELECT Code_conseil FROM ' . inst('conseil') . ' WHERE mf_cle_unique = \'' . $mf_cle_unique . '\'', false);
        if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
            $r = intval($row_requete['Code_conseil']);
        } else {
            $r = 0;
        }
        mysqli_free_result($res_requete);
        return $r;
    }
}
