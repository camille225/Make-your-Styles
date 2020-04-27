<?php declare(strict_types=1);

/*
    +------------------------------+
    |  NE PAS MODIFIER CE FICHIER  |
    +------------------------------+
*/

class table_a_filtrer_monframework extends entite
{

    private static $initialisation = true;
    private static $auto_completion = 0;
    private static $actualisation_en_cours = false;
    private static $cache_db;
    private static $maj_droits_ajouter_en_cours = false;
    private static $maj_droits_supprimer_en_cours = false;

    public function __construct()
    {
        if (self::$initialisation) {
            include_once __DIR__ . '/../../erreurs/erreurs__a_filtrer.php';
            self::$initialisation = false;
            Hook_a_filtrer::initialisation();
            self::$cache_db = new Mf_Cachedb('a_filtrer');
        }
        if (! self::$actualisation_en_cours) {
            self::$actualisation_en_cours=true;
            Hook_a_filtrer::actualisation();
            self::$actualisation_en_cours=false;
        }
    }

    public static function mf_raz_instance()
    {
        self::$initialisation = true;
    }

    public static function initialiser_structure()
    {
        if (! test_si_table_existe(inst('a_filtrer'))) {
            executer_requete_mysql('CREATE TABLE '.inst('a_filtrer').' (Code_utilisateur BIGINT UNSIGNED NOT NULL, Code_vue_utilisateur BIGINT UNSIGNED NOT NULL, PRIMARY KEY (Code_utilisateur, Code_vue_utilisateur)) ENGINE=MyISAM;', array_search('a_filtrer', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        $liste_colonnes = lister_les_colonnes('a_filtrer');

        $raz_index = false;
        if (isset($liste_colonnes['Code_utilisateur'])) {
            unset($liste_colonnes['Code_utilisateur']);
        } else {
            $raz_index = true;
            executer_requete_mysql('ALTER TABLE ' . inst('a_filtrer') . ' ADD Code_utilisateur BIGINT UNSIGNED NOT NULL;', array_search('a_filtrer', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }
        if (isset($liste_colonnes['Code_vue_utilisateur'])) {
            unset($liste_colonnes['Code_vue_utilisateur']);
        } else {
            $raz_index = true;
            executer_requete_mysql('ALTER TABLE ' . inst('a_filtrer') . ' ADD Code_vue_utilisateur BIGINT UNSIGNED NOT NULL;', array_search('a_filtrer', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }
        if ($raz_index) {
            executer_requete_mysql('ALTER TABLE ' . inst('a_filtrer') . ' DROP PRIMARY KEY;', array_search('a_filtrer', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }
        $liste_colonnes_primaires = lister_les_colonnes_primaires('a_filtrer');
        foreach ($liste_colonnes as $field => $value) {
            if (! $raz_index && isset($liste_colonnes_primaires[$field])) {
                executer_requete_mysql('ALTER TABLE ' . inst('a_filtrer') . ' DROP PRIMARY KEY;', array_search('a_filtrer', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
                $raz_index = true;
            }
            executer_requete_mysql('ALTER TABLE ' . inst('a_filtrer') . " DROP COLUMN $field;", array_search('a_filtrer', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }
        if ($raz_index) {
            executer_requete_mysql('DELETE FROM ' . inst('a_filtrer') . ';', array_search('a_filtrer', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('ALTER TABLE ' . inst('a_filtrer') . ' ADD PRIMARY KEY(Code_utilisateur, Code_vue_utilisateur);', array_search('a_filtrer', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }
    }

    /**
     * Retourne la tructure de la table « a_filtrer » avec les valeurs initialisées par défaut.
     * @return array
     */
    public function mf_get_structure(): array
    {
        $struc = [
            'Code_utilisateur' => 0, // ID
            'Code_vue_utilisateur' => 0, // ID
        ];
        mf_formatage_db_type_php($struc);
        Hook_a_filtrer::pre_controller($struc['Code_utilisateur'], $struc['Code_vue_utilisateur'], true);
        return $struc;
    }

    public function mfi_ajouter_auto(array $interface)
    {
        if (isset($interface['Code_utilisateur'])) {
            $liste_Code_utilisateur = [$interface['Code_utilisateur']];
            $liste_Code_utilisateur = $this->__get_liste_Code_utilisateur([OPTION_COND_MYSQL=>['Code_utilisateur IN ' . Sql_Format_Liste($liste_Code_utilisateur)]]);
        } elseif (isset($interface['liste_Code_utilisateur'])) {
            $liste_Code_utilisateur = $interface['liste_Code_utilisateur'];
            $liste_Code_utilisateur = $this->__get_liste_Code_utilisateur([OPTION_COND_MYSQL=>['Code_utilisateur IN ' . Sql_Format_Liste($liste_Code_utilisateur)]]);
        } else {
            $liste_Code_utilisateur = $this->get_liste_Code_utilisateur();
        }
        if (isset($interface['Code_vue_utilisateur'])) {
            $liste_Code_vue_utilisateur = [$interface['Code_vue_utilisateur']];
            $liste_Code_vue_utilisateur = $this->__get_liste_Code_vue_utilisateur([OPTION_COND_MYSQL=>['Code_vue_utilisateur IN ' . Sql_Format_Liste($liste_Code_vue_utilisateur)]]);
        } elseif (isset($interface['liste_Code_vue_utilisateur'])) {
            $liste_Code_vue_utilisateur = $interface['liste_Code_vue_utilisateur'];
            $liste_Code_vue_utilisateur = $this->__get_liste_Code_vue_utilisateur([OPTION_COND_MYSQL=>['Code_vue_utilisateur IN ' . Sql_Format_Liste($liste_Code_vue_utilisateur)]]);
        } else {
            $liste_Code_vue_utilisateur = $this->get_liste_Code_vue_utilisateur();
        }
        $mf_index = [];
        $res_requete = executer_requete_mysql('SELECT Code_utilisateur, Code_vue_utilisateur FROM ' . inst('a_filtrer') . ' WHERE Code_utilisateur IN ' . Sql_Format_Liste($liste_Code_utilisateur) . ' AND Code_vue_utilisateur IN ' . Sql_Format_Liste($liste_Code_vue_utilisateur) . ';', false);
        while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
            $mf_index[(int) $row_requete['Code_utilisateur']][(int) $row_requete['Code_vue_utilisateur']] = 1;
        }
        mysqli_free_result($res_requete);
        $liste_a_filtrer = [];
        foreach ($liste_Code_utilisateur as $Code_utilisateur) {
            foreach ($liste_Code_vue_utilisateur as $Code_vue_utilisateur) {
                if (! isset($mf_index[$Code_utilisateur][$Code_vue_utilisateur])) {
                    $liste_a_filtrer[] = ['Code_utilisateur'=>$Code_utilisateur,'Code_vue_utilisateur'=>$Code_vue_utilisateur];
                }
            }
        }
        return $this->mf_ajouter_3($liste_a_filtrer);
    }

    public function mfi_supprimer_auto(array $interface)
    {
        if (isset($interface['Code_utilisateur'])) {
            $liste_Code_utilisateur = [$interface['Code_utilisateur']];
        } elseif (isset($interface['liste_Code_utilisateur'])) {
            $liste_Code_utilisateur = $interface['liste_Code_utilisateur'];
        } else {
            $liste_Code_utilisateur = $this->get_liste_Code_utilisateur();
        }
        if (isset($interface['Code_vue_utilisateur'])) {
            $liste_Code_vue_utilisateur = [$interface['Code_vue_utilisateur']];
        } elseif (isset($interface['liste_Code_vue_utilisateur'])) {
            $liste_Code_vue_utilisateur = $interface['liste_Code_vue_utilisateur'];
        } else {
            $liste_Code_vue_utilisateur = $this->get_liste_Code_vue_utilisateur();
        }
        $mf_index = [];
        $res_requete = executer_requete_mysql('SELECT Code_utilisateur, Code_vue_utilisateur FROM ' . inst('a_filtrer') . ' WHERE Code_utilisateur IN ' . Sql_Format_Liste($liste_Code_utilisateur) . ' AND Code_vue_utilisateur IN ' . Sql_Format_Liste($liste_Code_vue_utilisateur) . ';', false);
        while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
            $mf_index[(int) $row_requete['Code_utilisateur']][(int) $row_requete['Code_vue_utilisateur']] = 1;
        }
        mysqli_free_result($res_requete);
        foreach ($liste_Code_utilisateur as &$Code_utilisateur) {
            if (isset($mf_index[$Code_utilisateur])) {
                foreach ($liste_Code_vue_utilisateur as &$Code_vue_utilisateur) {
                    if (isset($mf_index[$Code_utilisateur][$Code_vue_utilisateur])) {
                        $this->mf_supprimer_2($Code_utilisateur, $Code_vue_utilisateur);
                    }
                }
            }
        }
    }

    public function mf_ajouter(int $Code_utilisateur, int $Code_vue_utilisateur, ?bool $force = null)
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        // Typage
        // Fin typage
        Hook_a_filtrer::pre_controller($Code_utilisateur, $Code_vue_utilisateur, true);
        if (! $force) {
            if (! self::$maj_droits_ajouter_en_cours) {
                self::$maj_droits_ajouter_en_cours = true;
                Hook_a_filtrer::hook_actualiser_les_droits_ajouter($Code_utilisateur, $Code_vue_utilisateur);
                self::$maj_droits_ajouter_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['a_filtrer__AJOUTER']) ) $code_erreur = REFUS_A_FILTRER__AJOUTER;
        elseif ( !$this->mf_tester_existance_Code_utilisateur($Code_utilisateur) ) $code_erreur = ERR_A_FILTRER__AJOUTER__CODE_UTILISATEUR_INEXISTANT;
        elseif ( !$this->mf_tester_existance_Code_vue_utilisateur($Code_vue_utilisateur) ) $code_erreur = ERR_A_FILTRER__AJOUTER__CODE_VUE_UTILISATEUR_INEXISTANT;
        elseif ( $this->mf_tester_existance_a_filtrer( $Code_utilisateur, $Code_vue_utilisateur ) ) $code_erreur = ERR_A_FILTRER__AJOUTER__DOUBLON;
        elseif (CONTROLE_ACCES_DONNEES_DEFAUT && ! Hook_mf_systeme::controle_acces_donnees('Code_utilisateur', $Code_utilisateur)) $code_erreur = ACCES_CODE_UTILISATEUR_REFUSE;
        elseif (CONTROLE_ACCES_DONNEES_DEFAUT && ! Hook_mf_systeme::controle_acces_donnees('Code_vue_utilisateur', $Code_vue_utilisateur)) $code_erreur = ACCES_CODE_VUE_UTILISATEUR_REFUSE;
        elseif (! Hook_a_filtrer::autorisation_ajout($Code_utilisateur, $Code_vue_utilisateur) ) $code_erreur = REFUS_A_FILTRER__AJOUT_BLOQUEE;
        else {
            Hook_a_filtrer::data_controller($Code_utilisateur, $Code_vue_utilisateur, true);
            $requete = 'INSERT INTO '.inst('a_filtrer')." ( Code_utilisateur, Code_vue_utilisateur ) VALUES ( $Code_utilisateur, $Code_vue_utilisateur );";
            executer_requete_mysql($requete, array_search('a_filtrer', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            $n = requete_mysqli_affected_rows();
            if ($n == 0) {
                $code_erreur = ERR_A_FILTRER__AJOUTER__REFUSE;
            } else {
                self::$cache_db->clear();
                Hook_a_filtrer::ajouter($Code_utilisateur, $Code_vue_utilisateur);
            }
        }
        if ($code_erreur != 0) {
            global $mf_message_erreur_personalise, $mf_libelle_erreur;
            if ($mf_message_erreur_personalise != '') {
                $mf_libelle_erreur[$code_erreur] = $mf_message_erreur_personalise;
                $mf_message_erreur_personalise = '';
            }
        }
        return ['code_erreur' => $code_erreur, 'Code_utilisateur' => $Code_utilisateur, 'Code_vue_utilisateur' => $Code_vue_utilisateur, 'callback' => ( $code_erreur==0 ? Hook_a_filtrer::callback_post($Code_utilisateur, $Code_vue_utilisateur) : null)];
    }

    public function mf_ajouter_2(array $ligne, ?bool $force = null) // array('colonne1' => 'valeur1',  [...] )
    {
        if ($force === null) {
            $force = false;
        }
        $Code_utilisateur = (isset($ligne['Code_utilisateur']) ? intval($ligne['Code_utilisateur']) : get_utilisateur_courant('Code_utilisateur'));
        $Code_vue_utilisateur = (isset($ligne['Code_vue_utilisateur']) ? intval($ligne['Code_vue_utilisateur']) : 0);
        // Typage
        // Fin typage
        return $this->mf_ajouter($Code_utilisateur, $Code_vue_utilisateur, $force);
    }

    public function mf_ajouter_3(array $lignes) // array( array( 'colonne1' => 'valeur1', 'colonne2' => 'valeur2',  [...] ), [...] )
    {
        $code_erreur = 0;
        $values = '';
        foreach ($lignes as $ligne) {
            $Code_utilisateur = (isset($ligne['Code_utilisateur']) ? intval($ligne['Code_utilisateur']) : 0);
            $Code_vue_utilisateur = (isset($ligne['Code_vue_utilisateur']) ? intval($ligne['Code_vue_utilisateur']) : 0);
            if ($Code_utilisateur != 0) {
                if ($Code_vue_utilisateur != 0) {
                    $values .= ($values!='' ? ',' : '')."($Code_utilisateur, $Code_vue_utilisateur)";
                }
            }
        }
        if ($values != '') {
            $requete = "INSERT INTO " . inst('a_filtrer') . " (Code_utilisateur, Code_vue_utilisateur) VALUES $values;";
            executer_requete_mysql($requete, array_search('a_filtrer', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            $n = requete_mysqli_affected_rows();
            if ($n < count($lignes)) {
                $code_erreur = ERR_A_FILTRER__AJOUTER_3__ECHEC_AJOUT;
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

    public function mf_supprimer(?int $Code_utilisateur = null, ?int $Code_vue_utilisateur = null, ?bool $force = null)
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        $Code_utilisateur = intval($Code_utilisateur);
        $Code_vue_utilisateur = intval($Code_vue_utilisateur);
        $copie__liste_a_filtrer = $this->mf_lister($Code_utilisateur, $Code_vue_utilisateur, ['autocompletion' => false]);
        $liste_Code_utilisateur = [];
        $liste_Code_vue_utilisateur = [];
        foreach ( $copie__liste_a_filtrer as $copie__a_filtrer )
        {
            $Code_utilisateur = $copie__a_filtrer['Code_utilisateur'];
            $Code_vue_utilisateur = $copie__a_filtrer['Code_vue_utilisateur'];
            if (! $force) {
                if (!self::$maj_droits_supprimer_en_cours)
                {
                    self::$maj_droits_supprimer_en_cours = true;
                    Hook_a_filtrer::hook_actualiser_les_droits_supprimer($Code_utilisateur, $Code_vue_utilisateur);
                    self::$maj_droits_supprimer_en_cours = false;
                }
            }
            if ( !$force && !mf_matrice_droits(['a_filtrer__SUPPRIMER']) ) $code_erreur = REFUS_A_FILTRER__SUPPRIMER;
            elseif ( !Hook_a_filtrer::autorisation_suppression($Code_utilisateur, $Code_vue_utilisateur) ) $code_erreur = REFUS_A_FILTRER__SUPPRESSION_BLOQUEE;
            {
                $liste_Code_utilisateur[] = $Code_utilisateur;
                $liste_Code_vue_utilisateur[] = $Code_vue_utilisateur;
            }
        }
        if ($code_erreur == 0 && count($liste_Code_utilisateur)>0 && count($liste_Code_vue_utilisateur)>0) {
            $requete = 'DELETE IGNORE FROM ' . inst('a_filtrer') . " WHERE Code_utilisateur IN ".Sql_Format_Liste($liste_Code_utilisateur)." AND Code_vue_utilisateur IN ".Sql_Format_Liste($liste_Code_vue_utilisateur).";";
            executer_requete_mysql( $requete , array_search('a_filtrer', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            if (requete_mysqli_affected_rows() == 0) {
                $code_erreur = ERR_A_FILTRER__SUPPRIMER__REFUSE;
            } else {
                self::$cache_db->clear();
                Hook_a_filtrer::supprimer($copie__liste_a_filtrer);
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

    public function mf_supprimer_2(?int $Code_utilisateur = null, ?int $Code_vue_utilisateur = null)
    {
        $code_erreur = 0;
        $Code_utilisateur = intval($Code_utilisateur);
        $Code_vue_utilisateur = intval($Code_vue_utilisateur);
        $copie__liste_a_filtrer = $this->mf_lister_2($Code_utilisateur, $Code_vue_utilisateur, ['autocompletion' => false]);
        $requete = 'DELETE IGNORE FROM ' . inst('a_filtrer') . " WHERE 1".( $Code_utilisateur!=0 ? " AND Code_utilisateur=$Code_utilisateur" : "" )."".( $Code_vue_utilisateur!=0 ? " AND Code_vue_utilisateur=$Code_vue_utilisateur" : "" ).";";
        executer_requete_mysql( $requete , array_search('a_filtrer', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        if ( requete_mysqli_affected_rows()==0 )
        {
            $code_erreur = ERR_A_FILTRER__SUPPRIMER_2__REFUSE;
        } else {
            self::$cache_db->clear();
            Hook_a_filtrer::supprimer($copie__liste_a_filtrer);
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

    public function mf_lister_contexte(?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'liste_colonnes_a_selectionner' => [], 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        global $mf_contexte, $est_charge;
        return $this->mf_lister(isset($est_charge['utilisateur']) ? $mf_contexte['Code_utilisateur'] : 0, isset($est_charge['vue_utilisateur']) ? $mf_contexte['Code_vue_utilisateur'] : 0, $options);
    }

    public function mf_lister(?int $Code_utilisateur = null, ?int $Code_vue_utilisateur = null, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'liste_colonnes_a_selectionner' => [], 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $liste = $this->mf_lister_2($Code_utilisateur, $Code_vue_utilisateur, $options);

        // controle_acces_donnees
        $controle_acces_donnees = CONTROLE_ACCES_DONNEES_DEFAUT;
        if (isset($options['controle_acces_donnees']))
        {
            $controle_acces_donnees = ( $options['controle_acces_donnees']==true );
        }

        foreach ($liste as $key => $elem)
        {
            if ( $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_utilisateur', $elem['Code_utilisateur']) || $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_vue_utilisateur', $elem['Code_vue_utilisateur']) )
            {
                unset($liste[$key]);
            }
        }

        return $liste;
    }

    public function mf_lister_2(?int $Code_utilisateur = null, ?int $Code_vue_utilisateur = null, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'liste_colonnes_a_selectionner' => [], 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cle = 'a_filtrer__lister';
        $Code_utilisateur = intval($Code_utilisateur);
        $cle .= "_{$Code_utilisateur}";
        $Code_vue_utilisateur = intval($Code_vue_utilisateur);
        $cle .= "_{$Code_vue_utilisateur}";

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
            if (isset($mf_tri_defaut_table['a_filtrer'])) {
                $options['tris'] = $mf_tri_defaut_table['a_filtrer'];
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

        if (false === $liste = self::$cache_db->read($cle)) {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if (count($liste_colonnes_a_indexer) > 0) {
                if (false === $mf_liste_requete_index = self::$cache_db->read('a_filtrer__index')) {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('a_filtrer').'`;', false);
                    $mf_liste_requete_index = [];
                    while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    self::$cache_db->write('a_filtrer__index', $mf_liste_requete_index);
                }
                foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if (count($liste_colonnes_a_indexer) > 0) {
                    foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                        executer_requete_mysql('ALTER TABLE `'.inst('a_filtrer').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    self::$cache_db->clear();
                }
            }

            $liste = [];
            if (count($liste_colonnes_a_selectionner) == 0) {
                if ($toutes_colonnes) {
                    $colonnes = 'Code_utilisateur, Code_vue_utilisateur';
                } else {
                    $colonnes = 'Code_utilisateur, Code_vue_utilisateur';
                }
            } else {
                $liste_colonnes_a_selectionner[] = 'Code_utilisateur';
                $liste_colonnes_a_selectionner[] = 'Code_vue_utilisateur';
                $colonnes = enumeration($liste_colonnes_a_selectionner);
            }

            $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM '.inst('a_filtrer')." WHERE 1{$argument_cond}".( $Code_utilisateur!=0 ? " AND Code_utilisateur=$Code_utilisateur" : "" )."".( $Code_vue_utilisateur!=0 ? " AND Code_vue_utilisateur=$Code_vue_utilisateur" : "" )."{$argument_tris}{$argument_limit};", false);
            while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                mf_formatage_db_type_php($row_requete);
                $liste[$row_requete['Code_utilisateur'].'-'.$row_requete['Code_vue_utilisateur']] = $row_requete;
            }
            mysqli_free_result($res_requete);
            if (count($options['tris']) == 1) {
                foreach ($options['tris'] as $colonne => $tri) {
                    global $lang_standard;
                    if (isset($lang_standard[$colonne.'_'])) {
                        effectuer_tri_suivant_langue($liste, $colonne, $tri);
                    }
                }
            }
            self::$cache_db->write($cle, $liste);
        }
        foreach ($liste as &$element)
        {
            if (($autocompletion_recursive || self::$auto_completion < 1) && $autocompletion) {
                self::$auto_completion ++;
                Hook_a_filtrer::completion($element, self::$auto_completion - 1);
                self::$auto_completion --;
            }
        }
        unset($element);
        return $liste;
    }

    public function mf_lister_3(?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'liste_colonnes_a_selectionner' => [], 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        return $this->mf_lister(null, null, $options);
    }

    public function mf_get(int $Code_utilisateur, int $Code_vue_utilisateur, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cle = "a_filtrer__get";
        $Code_utilisateur = intval($Code_utilisateur);
        $cle .= "_{$Code_utilisateur}";
        $Code_vue_utilisateur = intval($Code_vue_utilisateur);
        $cle .= "_{$Code_vue_utilisateur}";
        $retour = [];
        if (! CONTROLE_ACCES_DONNEES_DEFAUT || Hook_mf_systeme::controle_acces_donnees('Code_utilisateur', $Code_utilisateur) && Hook_mf_systeme::controle_acces_donnees('Code_vue_utilisateur', $Code_vue_utilisateur)) {

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
                    $colonnes='Code_utilisateur, Code_vue_utilisateur';
                } else {
                    $colonnes='Code_utilisateur, Code_vue_utilisateur';
                }
                $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM ' . inst('a_filtrer')." WHERE Code_utilisateur=$Code_utilisateur AND Code_vue_utilisateur=$Code_vue_utilisateur;", false);
                if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                    mf_formatage_db_type_php($row_requete);
                    $retour = $row_requete;
                } else {
                    $retour = [];
                }
                mysqli_free_result($res_requete);
                self::$cache_db->write($cle, $retour);
            }
            if (isset($retour['Code_utilisateur'])) {
                if (($autocompletion_recursive || self::$auto_completion < 1) && $autocompletion) {
                    self::$auto_completion ++;
                    Hook_a_filtrer::completion($retour, self::$auto_completion - 1);
                    self::$auto_completion --;
                }
            }
        }
        return $retour;
    }

    public function mf_get_2(int $Code_utilisateur, int $Code_vue_utilisateur, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cle = "a_filtrer__get";
        $Code_utilisateur = intval($Code_utilisateur);
        $cle .= "_{$Code_utilisateur}";
        $Code_vue_utilisateur = intval($Code_vue_utilisateur);
        $cle .= "_{$Code_vue_utilisateur}";

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
                $colonnes='Code_utilisateur, Code_vue_utilisateur';
            } else {
                $colonnes='Code_utilisateur, Code_vue_utilisateur';
            }
            $res_requete = executer_requete_mysql("SELECT $colonnes FROM " . inst('a_filtrer')." WHERE Code_utilisateur=$Code_utilisateur AND Code_vue_utilisateur=$Code_vue_utilisateur;", false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                mf_formatage_db_type_php($row_requete);
                $retour = $row_requete;
            } else {
                $retour = [];
            }
            mysqli_free_result($res_requete);
            self::$cache_db->write($cle, $retour);
        }
        if (isset($retour['Code_utilisateur'])) {
            if (($autocompletion_recursive || self::$auto_completion < 1) && $autocompletion) {
                self::$auto_completion ++;
                Hook_a_filtrer::completion($retour, self::$auto_completion - 1);
                self::$auto_completion --;
            }
        }
        return $retour;
    }

    public function mf_compter(?int $Code_utilisateur = null, ?int $Code_vue_utilisateur = null, ?array $options = null /* $options = [ 'cond_mysql' => [] ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cle = 'a_filtrer__compter';
        $Code_utilisateur = intval($Code_utilisateur);
        $cle .= '_{'.$Code_utilisateur.'}';
        $Code_vue_utilisateur = intval($Code_vue_utilisateur);
        $cle .= '_{'.$Code_vue_utilisateur.'}';

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
            if (count($liste_colonnes_a_indexer) > 0) {
                if (false === $mf_liste_requete_index = self::$cache_db->read('a_filtrer__index')) {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('a_filtrer').'`;', false);
                    $mf_liste_requete_index = [];
                    while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    self::$cache_db->write('a_filtrer__index', $mf_liste_requete_index);
                }
                foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if (count($liste_colonnes_a_indexer) > 0) {
                    foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                        executer_requete_mysql('ALTER TABLE `'.inst('a_filtrer').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    self::$cache_db->clear();
                }
            }

            $res_requete = executer_requete_mysql("SELECT COUNT(CONCAT(Code_utilisateur,'|',Code_vue_utilisateur)) as nb FROM " . inst('a_filtrer') . " WHERE 1{$argument_cond}".( $Code_utilisateur!=0 ? " AND Code_utilisateur=$Code_utilisateur" : "" )."".( $Code_vue_utilisateur!=0 ? " AND Code_vue_utilisateur=$Code_vue_utilisateur" : "" ).";", false);
            $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC);
            mysqli_free_result($res_requete);
            $nb = (int) $row_requete['nb'];
            self::$cache_db->write($cle, $nb);
        }
        return $nb;
    }

    public function mf_liste_Code_utilisateur_vers_liste_Code_vue_utilisateur( array $liste_Code_utilisateur, ?array $options = null /* $options = [ 'cond_mysql' => [] ] */)
    {
        if ($options === null) {
            $options=[];
        }
        return $this->a_filtrer_liste_Code_utilisateur_vers_liste_Code_vue_utilisateur( $liste_Code_utilisateur , $options );
    }

    public function mf_liste_Code_vue_utilisateur_vers_liste_Code_utilisateur( array $liste_Code_vue_utilisateur, ?array $options = null /* $options = [ 'cond_mysql' => [] ] */)
    {
        if ($options === null) {
            $options=[];
        }
        return $this->a_filtrer_liste_Code_vue_utilisateur_vers_liste_Code_utilisateur( $liste_Code_vue_utilisateur , $options );
    }

    public function mf_get_liste_tables_parents()
    {
        return ['utilisateur','vue_utilisateur'];
    }

}
