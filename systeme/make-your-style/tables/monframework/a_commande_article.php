<?php declare(strict_types=1);

/*
    +------------------------------+
    |  NE PAS MODIFIER CE FICHIER  |
    +------------------------------+
*/

class table_a_commande_article_monframework extends entite
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
            include_once __DIR__ . '/../../erreurs/erreurs__a_commande_article.php';
            self::$initialisation = false;
            Hook_a_commande_article::initialisation();
            self::$cache_db = new Mf_Cachedb('a_commande_article');
        }
        if (! self::$actualisation_en_cours) {
            self::$actualisation_en_cours=true;
            Hook_a_commande_article::actualisation();
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

        if (! test_si_table_existe(inst('a_commande_article'))) {
            executer_requete_mysql('CREATE TABLE '.inst('a_commande_article').' (Code_commande BIGINT UNSIGNED NOT NULL, Code_article BIGINT UNSIGNED NOT NULL, PRIMARY KEY (Code_commande, Code_article)) ENGINE=MyISAM;', array_search('a_commande_article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        $liste_colonnes = lister_les_colonnes('a_commande_article');

        if (isset($liste_colonnes['a_commande_article_Quantite'])) {
            if (typeMyql2Sql($liste_colonnes['a_commande_article_Quantite']['Type'])!='INT') {
                executer_requete_mysql('ALTER TABLE '.inst('a_commande_article').' CHANGE a_commande_article_Quantite a_commande_article_Quantite INT;', array_search('a_commande_article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['a_commande_article_Quantite']);
        } else {
            executer_requete_mysql('ALTER TABLE ' . inst('a_commande_article') . ' ADD a_commande_article_Quantite INT;', array_search('a_commande_article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE ' . inst('a_commande_article') . ' SET a_commande_article_Quantite=' . format_sql('a_commande_article_Quantite', $mf_initialisation['a_commande_article_Quantite']) . ';', array_search('a_commande_article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if (isset($liste_colonnes['a_commande_article_Prix_ligne'])) {
            if (typeMyql2Sql($liste_colonnes['a_commande_article_Prix_ligne']['Type'])!='FLOAT') {
                executer_requete_mysql('ALTER TABLE '.inst('a_commande_article').' CHANGE a_commande_article_Prix_ligne a_commande_article_Prix_ligne FLOAT;', array_search('a_commande_article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['a_commande_article_Prix_ligne']);
        } else {
            executer_requete_mysql('ALTER TABLE ' . inst('a_commande_article') . ' ADD a_commande_article_Prix_ligne FLOAT;', array_search('a_commande_article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE ' . inst('a_commande_article') . ' SET a_commande_article_Prix_ligne=' . format_sql('a_commande_article_Prix_ligne', $mf_initialisation['a_commande_article_Prix_ligne']) . ';', array_search('a_commande_article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        $raz_index = false;
        if (isset($liste_colonnes['Code_commande'])) {
            unset($liste_colonnes['Code_commande']);
        } else {
            $raz_index = true;
            executer_requete_mysql('ALTER TABLE ' . inst('a_commande_article') . ' ADD Code_commande BIGINT UNSIGNED NOT NULL;', array_search('a_commande_article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }
        if (isset($liste_colonnes['Code_article'])) {
            unset($liste_colonnes['Code_article']);
        } else {
            $raz_index = true;
            executer_requete_mysql('ALTER TABLE ' . inst('a_commande_article') . ' ADD Code_article BIGINT UNSIGNED NOT NULL;', array_search('a_commande_article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }
        if ($raz_index) {
            executer_requete_mysql('ALTER TABLE ' . inst('a_commande_article') . ' DROP PRIMARY KEY;', array_search('a_commande_article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }
        $liste_colonnes_primaires = lister_les_colonnes_primaires('a_commande_article');
        foreach ($liste_colonnes as $field => $value) {
            if (! $raz_index && isset($liste_colonnes_primaires[$field])) {
                executer_requete_mysql('ALTER TABLE ' . inst('a_commande_article') . ' DROP PRIMARY KEY;', array_search('a_commande_article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
                $raz_index = true;
            }
            executer_requete_mysql('ALTER TABLE ' . inst('a_commande_article') . " DROP COLUMN $field;", array_search('a_commande_article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }
        if ($raz_index) {
            executer_requete_mysql('DELETE FROM ' . inst('a_commande_article') . ';', array_search('a_commande_article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('ALTER TABLE ' . inst('a_commande_article') . ' ADD PRIMARY KEY(Code_commande, Code_article);', array_search('a_commande_article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }
    }

    /**
     * Retourne la tructure de la table « a_commande_article » avec les valeurs initialisées par défaut.
     * @return array
     */
    public function mf_get_structure(): array
    {
        global $mf_initialisation;
        $struc = [
            'Code_commande' => 0, // ID
            'Code_article' => 0, // ID
            'a_commande_article_Quantite' => $mf_initialisation['a_commande_article_Quantite'],
            'a_commande_article_Prix_ligne' => $mf_initialisation['a_commande_article_Prix_ligne'],
        ];
        mf_formatage_db_type_php($struc);
        Hook_a_commande_article::pre_controller($struc['a_commande_article_Quantite'], $struc['a_commande_article_Prix_ligne'], $struc['Code_commande'], $struc['Code_article'], true);
        return $struc;
    }

    public function mfi_ajouter_auto(array $interface)
    {
        if (isset($interface['Code_commande'])) {
            $liste_Code_commande = [$interface['Code_commande']];
            $liste_Code_commande = $this->__get_liste_Code_commande([OPTION_COND_MYSQL=>['Code_commande IN ' . Sql_Format_Liste($liste_Code_commande)]]);
        } elseif (isset($interface['liste_Code_commande'])) {
            $liste_Code_commande = $interface['liste_Code_commande'];
            $liste_Code_commande = $this->__get_liste_Code_commande([OPTION_COND_MYSQL=>['Code_commande IN ' . Sql_Format_Liste($liste_Code_commande)]]);
        } else {
            $liste_Code_commande = $this->get_liste_Code_commande();
        }
        if (isset($interface['Code_article'])) {
            $liste_Code_article = [$interface['Code_article']];
            $liste_Code_article = $this->__get_liste_Code_article([OPTION_COND_MYSQL=>['Code_article IN ' . Sql_Format_Liste($liste_Code_article)]]);
        } elseif (isset($interface['liste_Code_article'])) {
            $liste_Code_article = $interface['liste_Code_article'];
            $liste_Code_article = $this->__get_liste_Code_article([OPTION_COND_MYSQL=>['Code_article IN ' . Sql_Format_Liste($liste_Code_article)]]);
        } else {
            $liste_Code_article = $this->get_liste_Code_article();
        }
        $mf_index = [];
        $res_requete = executer_requete_mysql('SELECT Code_commande, Code_article FROM ' . inst('a_commande_article') . ' WHERE Code_commande IN ' . Sql_Format_Liste($liste_Code_commande) . ' AND Code_article IN ' . Sql_Format_Liste($liste_Code_article) . ';', false);
        while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
            $mf_index[(int) $row_requete['Code_commande']][(int) $row_requete['Code_article']] = 1;
        }
        mysqli_free_result($res_requete);
        $liste_a_commande_article = [];
        foreach ($liste_Code_commande as $Code_commande) {
            foreach ($liste_Code_article as $Code_article) {
                if (! isset($mf_index[$Code_commande][$Code_article])) {
                    $liste_a_commande_article[] = ['Code_commande'=>$Code_commande,'Code_article'=>$Code_article];
                }
            }
        }
        if (isset($interface['a_commande_article_Quantite'])) {
            foreach ($liste_a_commande_article as &$a_commande_article) {
                $a_commande_article['a_commande_article_Quantite'] = $interface['a_commande_article_Quantite'];
            }
            unset($a_commande_article);
        }
        if (isset($interface['a_commande_article_Prix_ligne'])) {
            foreach ($liste_a_commande_article as &$a_commande_article) {
                $a_commande_article['a_commande_article_Prix_ligne'] = $interface['a_commande_article_Prix_ligne'];
            }
            unset($a_commande_article);
        }
        return $this->mf_ajouter_3($liste_a_commande_article);
    }

    public function mfi_supprimer_auto(array $interface)
    {
        if (isset($interface['Code_commande'])) {
            $liste_Code_commande = [$interface['Code_commande']];
        } elseif (isset($interface['liste_Code_commande'])) {
            $liste_Code_commande = $interface['liste_Code_commande'];
        } else {
            $liste_Code_commande = $this->get_liste_Code_commande();
        }
        if (isset($interface['Code_article'])) {
            $liste_Code_article = [$interface['Code_article']];
        } elseif (isset($interface['liste_Code_article'])) {
            $liste_Code_article = $interface['liste_Code_article'];
        } else {
            $liste_Code_article = $this->get_liste_Code_article();
        }
        $mf_index = [];
        $res_requete = executer_requete_mysql('SELECT Code_commande, Code_article FROM ' . inst('a_commande_article') . ' WHERE Code_commande IN ' . Sql_Format_Liste($liste_Code_commande) . ' AND Code_article IN ' . Sql_Format_Liste($liste_Code_article) . ';', false);
        while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
            $mf_index[(int) $row_requete['Code_commande']][(int) $row_requete['Code_article']] = 1;
        }
        mysqli_free_result($res_requete);
        foreach ($liste_Code_commande as &$Code_commande) {
            if (isset($mf_index[$Code_commande])) {
                foreach ($liste_Code_article as &$Code_article) {
                    if (isset($mf_index[$Code_commande][$Code_article])) {
                        $this->mf_supprimer_2($Code_commande, $Code_article);
                    }
                }
            }
        }
    }

    public function mf_ajouter(int $Code_commande, int $Code_article, ?int $a_commande_article_Quantite, ?float $a_commande_article_Prix_ligne, ?bool $force = null)
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        // Typage
        $a_commande_article_Quantite = is_null($a_commande_article_Quantite) || $a_commande_article_Quantite === '' ? null : (int) $a_commande_article_Quantite;
        $a_commande_article_Prix_ligne = is_null($a_commande_article_Prix_ligne) || $a_commande_article_Prix_ligne === '' ? null : mf_significantDigit((float) str_replace(' ', '', str_replace(',', '.', $a_commande_article_Prix_ligne)), 6);
        // Fin typage
        Hook_a_commande_article::pre_controller($a_commande_article_Quantite, $a_commande_article_Prix_ligne, $Code_commande, $Code_article, true);
        if (! $force) {
            if (! self::$maj_droits_ajouter_en_cours) {
                self::$maj_droits_ajouter_en_cours = true;
                Hook_a_commande_article::hook_actualiser_les_droits_ajouter($Code_commande, $Code_article);
                self::$maj_droits_ajouter_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['a_commande_article__AJOUTER']) ) $code_erreur = REFUS_A_COMMANDE_ARTICLE__AJOUTER;
        elseif ( !$this->mf_tester_existance_Code_commande($Code_commande) ) $code_erreur = ERR_A_COMMANDE_ARTICLE__AJOUTER__CODE_COMMANDE_INEXISTANT;
        elseif ( !$this->mf_tester_existance_Code_article($Code_article) ) $code_erreur = ERR_A_COMMANDE_ARTICLE__AJOUTER__CODE_ARTICLE_INEXISTANT;
        elseif ( $this->mf_tester_existance_a_commande_article( $Code_commande, $Code_article ) ) $code_erreur = ERR_A_COMMANDE_ARTICLE__AJOUTER__DOUBLON;
        elseif (CONTROLE_ACCES_DONNEES_DEFAUT && ! Hook_mf_systeme::controle_acces_donnees('Code_commande', $Code_commande)) $code_erreur = ACCES_CODE_COMMANDE_REFUSE;
        elseif (CONTROLE_ACCES_DONNEES_DEFAUT && ! Hook_mf_systeme::controle_acces_donnees('Code_article', $Code_article)) $code_erreur = ACCES_CODE_ARTICLE_REFUSE;
        elseif (! Hook_a_commande_article::autorisation_ajout($a_commande_article_Quantite, $a_commande_article_Prix_ligne, $Code_commande, $Code_article) ) $code_erreur = REFUS_A_COMMANDE_ARTICLE__AJOUT_BLOQUEE;
        else {
            Hook_a_commande_article::data_controller($a_commande_article_Quantite, $a_commande_article_Prix_ligne, $Code_commande, $Code_article, true);
            $a_commande_article_Quantite = is_null($a_commande_article_Quantite) ? 'NULL' : (int) $a_commande_article_Quantite;
            $a_commande_article_Prix_ligne = is_null($a_commande_article_Prix_ligne) ? 'NULL' : (float) $a_commande_article_Prix_ligne;
            $requete = 'INSERT INTO '.inst('a_commande_article')." ( a_commande_article_Quantite, a_commande_article_Prix_ligne, Code_commande, Code_article ) VALUES ( $a_commande_article_Quantite, $a_commande_article_Prix_ligne, $Code_commande, $Code_article );";
            executer_requete_mysql($requete, array_search('a_commande_article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            $n = requete_mysqli_affected_rows();
            if ($n == 0) {
                $code_erreur = ERR_A_COMMANDE_ARTICLE__AJOUTER__REFUSE;
            } else {
                self::$cache_db->clear();
                Hook_a_commande_article::ajouter($Code_commande, $Code_article);
            }
        }
        if ($code_erreur != 0) {
            global $mf_message_erreur_personalise, $mf_libelle_erreur;
            if ($mf_message_erreur_personalise != '') {
                $mf_libelle_erreur[$code_erreur] = $mf_message_erreur_personalise;
                $mf_message_erreur_personalise = '';
            }
        }
        return ['code_erreur' => $code_erreur, 'Code_commande' => $Code_commande, 'Code_article' => $Code_article, 'callback' => ( $code_erreur==0 ? Hook_a_commande_article::callback_post($Code_commande, $Code_article) : null)];
    }

    public function mf_ajouter_2(array $ligne, ?bool $force = null) // array('colonne1' => 'valeur1',  [...] )
    {
        if ($force === null) {
            $force = false;
        }
        global $mf_initialisation;
        $Code_commande = (isset($ligne['Code_commande']) ? intval($ligne['Code_commande']) : 0);
        $Code_article = (isset($ligne['Code_article']) ? intval($ligne['Code_article']) : 0);
        $a_commande_article_Quantite = (isset($ligne['a_commande_article_Quantite'])?$ligne['a_commande_article_Quantite']:$mf_initialisation['a_commande_article_Quantite']);
        $a_commande_article_Prix_ligne = (isset($ligne['a_commande_article_Prix_ligne'])?$ligne['a_commande_article_Prix_ligne']:$mf_initialisation['a_commande_article_Prix_ligne']);
        // Typage
        $a_commande_article_Quantite = is_null($a_commande_article_Quantite) || $a_commande_article_Quantite === '' ? null : (int) $a_commande_article_Quantite;
        $a_commande_article_Prix_ligne = is_null($a_commande_article_Prix_ligne) || $a_commande_article_Prix_ligne === '' ? null : mf_significantDigit((float) str_replace(' ', '', str_replace(',', '.', $a_commande_article_Prix_ligne)), 6);
        // Fin typage
        return $this->mf_ajouter($Code_commande, $Code_article, $a_commande_article_Quantite, $a_commande_article_Prix_ligne, $force);
    }

    public function mf_ajouter_3(array $lignes) // array( array( 'colonne1' => 'valeur1', 'colonne2' => 'valeur2',  [...] ), [...] )
    {
        global $mf_initialisation;
        $code_erreur = 0;
        $values = '';
        foreach ($lignes as $ligne) {
            $Code_commande = (isset($ligne['Code_commande']) ? intval($ligne['Code_commande']) : 0);
            $Code_article = (isset($ligne['Code_article']) ? intval($ligne['Code_article']) : 0);
            $a_commande_article_Quantite = is_null((isset($ligne['a_commande_article_Quantite']) ? $ligne['a_commande_article_Quantite'] : $mf_initialisation['a_commande_article_Quantite'])) ? 'NULL' : (int) (isset($ligne['a_commande_article_Quantite']) ? $ligne['a_commande_article_Quantite'] : $mf_initialisation['a_commande_article_Quantite']);
            $a_commande_article_Prix_ligne = is_null((isset($ligne['a_commande_article_Prix_ligne']) ? $ligne['a_commande_article_Prix_ligne'] : $mf_initialisation['a_commande_article_Prix_ligne'])) ? 'NULL' : (float) (isset($ligne['a_commande_article_Prix_ligne']) ? $ligne['a_commande_article_Prix_ligne'] : $mf_initialisation['a_commande_article_Prix_ligne']);
            if ($Code_commande != 0) {
                if ($Code_article != 0) {
                    $values .= ($values!='' ? ',' : '')."($a_commande_article_Quantite, $a_commande_article_Prix_ligne, $Code_commande, $Code_article)";
                }
            }
        }
        if ($values != '') {
            $requete = "INSERT INTO " . inst('a_commande_article') . " (a_commande_article_Quantite, a_commande_article_Prix_ligne, Code_commande, Code_article) VALUES $values;";
            executer_requete_mysql($requete, array_search('a_commande_article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            $n = requete_mysqli_affected_rows();
            if ($n < count($lignes)) {
                $code_erreur = ERR_A_COMMANDE_ARTICLE__AJOUTER_3__ECHEC_AJOUT;
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

    public function mf_modifier(int $Code_commande, int $Code_article, ?int $a_commande_article_Quantite, ?float $a_commande_article_Prix_ligne, ?bool $force = null)
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        // Typage
        $a_commande_article_Quantite = is_null($a_commande_article_Quantite) || $a_commande_article_Quantite === '' ? null : (int) $a_commande_article_Quantite;
        $a_commande_article_Prix_ligne = is_null($a_commande_article_Prix_ligne) || $a_commande_article_Prix_ligne === '' ? null : mf_significantDigit((float) str_replace(' ', '', str_replace(',', '.', $a_commande_article_Prix_ligne)), 6);
        // Fin typage
        Hook_a_commande_article::pre_controller($a_commande_article_Quantite, $a_commande_article_Prix_ligne, $Code_commande, $Code_article, false);
        if (! $force) {
            if (! self::$maj_droits_modifier_en_cours) {
                self::$maj_droits_modifier_en_cours = true;
                Hook_a_commande_article::hook_actualiser_les_droits_modifier($Code_commande, $Code_article);
                self::$maj_droits_modifier_en_cours = false;
            }
        }
        $a_commande_article = $this->mf_get_2( $Code_commande, $Code_article, ['autocompletion' => false]);
        if ( !$force && !mf_matrice_droits(['a_commande_article__MODIFIER']) ) $code_erreur = REFUS_A_COMMANDE_ARTICLE__MODIFIER;
        elseif ( !$this->mf_tester_existance_Code_commande($Code_commande) ) $code_erreur = ERR_A_COMMANDE_ARTICLE__MODIFIER__CODE_COMMANDE_INEXISTANT;
        elseif ( !$this->mf_tester_existance_Code_article($Code_article) ) $code_erreur = ERR_A_COMMANDE_ARTICLE__MODIFIER__CODE_ARTICLE_INEXISTANT;
        elseif ( !$this->mf_tester_existance_a_commande_article( $Code_commande, $Code_article ) ) $code_erreur = ERR_A_COMMANDE_ARTICLE__MODIFIER__INEXISTANT;
        elseif (CONTROLE_ACCES_DONNEES_DEFAUT && ! Hook_mf_systeme::controle_acces_donnees('Code_commande', $Code_commande)) $code_erreur = ACCES_CODE_COMMANDE_REFUSE;
        elseif (CONTROLE_ACCES_DONNEES_DEFAUT && ! Hook_mf_systeme::controle_acces_donnees('Code_article', $Code_article)) $code_erreur = ACCES_CODE_ARTICLE_REFUSE;
        elseif ( !Hook_a_commande_article::autorisation_modification($Code_commande, $Code_article, $a_commande_article_Quantite, $a_commande_article_Prix_ligne) ) $code_erreur = REFUS_A_COMMANDE_ARTICLE__MODIFICATION_BLOQUEE;
        else {
            if (! isset(self::$lock["$Code_commande-$Code_article"])) {
                self::$lock["$Code_commande-$Code_article"] = 0;
            }
            if (self::$lock["$Code_commande-$Code_article"] == 0) {
                self::$cache_db->add_lock("$Code_commande-$Code_article");
            }
            self::$lock["$Code_commande-$Code_article"]++;
            Hook_a_commande_article::data_controller($a_commande_article_Quantite, $a_commande_article_Prix_ligne, $Code_commande, $Code_article, false);
            $mf_colonnes_a_modifier=[];
            $bool__a_commande_article_Quantite = false; if ($a_commande_article_Quantite !== $a_commande_article['a_commande_article_Quantite']) {Hook_a_commande_article::data_controller__a_commande_article_Quantite($a_commande_article['a_commande_article_Quantite'], $a_commande_article_Quantite, $Code_commande, $Code_article); if ( $a_commande_article_Quantite !== $a_commande_article['a_commande_article_Quantite'] ) { $mf_colonnes_a_modifier[] = 'a_commande_article_Quantite=' . format_sql('a_commande_article_Quantite', $a_commande_article_Quantite); $bool__a_commande_article_Quantite = true;}}
            $bool__a_commande_article_Prix_ligne = false; if ($a_commande_article_Prix_ligne !== $a_commande_article['a_commande_article_Prix_ligne']) {Hook_a_commande_article::data_controller__a_commande_article_Prix_ligne($a_commande_article['a_commande_article_Prix_ligne'], $a_commande_article_Prix_ligne, $Code_commande, $Code_article); if ( $a_commande_article_Prix_ligne !== $a_commande_article['a_commande_article_Prix_ligne'] ) { $mf_colonnes_a_modifier[] = 'a_commande_article_Prix_ligne=' . format_sql('a_commande_article_Prix_ligne', $a_commande_article_Prix_ligne); $bool__a_commande_article_Prix_ligne = true;}}
            if (count($mf_colonnes_a_modifier)>0) {
                $requete = 'UPDATE ' . inst('a_commande_article') . ' SET ' . enumeration($mf_colonnes_a_modifier) . " WHERE Code_commande=$Code_commande AND Code_article=$Code_article;";
                executer_requete_mysql($requete, array_search('a_commande_article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
                if (requete_mysqli_affected_rows() == 0) {
                    $code_erreur = ERR_A_COMMANDE_ARTICLE__MODIFIER__AUCUN_CHANGEMENT;
                } else {
                    self::$cache_db->clear();
                    Hook_a_commande_article::modifier($Code_commande, $Code_article, $bool__a_commande_article_Quantite, $bool__a_commande_article_Prix_ligne);
                }
            } else {
                $code_erreur = ERR_A_COMMANDE_ARTICLE__MODIFIER__AUCUN_CHANGEMENT;
            }
            self::$lock["$Code_commande-$Code_article"]--;
            if (self::$lock["$Code_commande-$Code_article"] == 0) {
                self::$cache_db->release_lock("$Code_commande-$Code_article");
                unset(self::$lock["$Code_commande-$Code_article"]);
            }
        }
        if ($code_erreur != 0) {
            global $mf_message_erreur_personalise, $mf_libelle_erreur;
            if ($mf_message_erreur_personalise != '') {
                $mf_libelle_erreur[$code_erreur] = $mf_message_erreur_personalise;
                $mf_message_erreur_personalise = '';
            }
        }
        return ['code_erreur' => $code_erreur, 'callback' => ( $code_erreur == 0 ? Hook_a_commande_article::callback_put($Code_commande, $Code_article) : null )];
    }

    public function mf_modifier_2(array $lignes, ?bool $force = null) // array( array('Code_' => $Code, ..., 'colonne1' => 'valeur1', [...] ), [...] )
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        foreach ($lignes as $colonnes) {
            if ($code_erreur == 0) {
                $Code_commande = (int) (isset($colonnes['Code_commande']) ? $colonnes['Code_commande'] : 0 );
                $Code_article = (int) (isset($colonnes['Code_article']) ? $colonnes['Code_article'] : 0 );
                $a_commande_article = $this->mf_get_2($Code_commande, $Code_article, ['autocompletion' => false]);
                if (! $force) {
                    if (! self::$maj_droits_modifier_en_cours) {
                        self::$maj_droits_modifier_en_cours = true;
                        Hook_a_commande_article::hook_actualiser_les_droits_modifier($Code_commande, $Code_article);
                        self::$maj_droits_modifier_en_cours = false;
                    }
                }
                $a_commande_article_Quantite = (int) ( isset($colonnes['a_commande_article_Quantite']) && ( $force || mf_matrice_droits(['api_modifier__a_commande_article_Quantite', 'a_commande_article__MODIFIER']) ) ? $colonnes['a_commande_article_Quantite'] : ( isset($a_commande_article['a_commande_article_Quantite']) ? $a_commande_article['a_commande_article_Quantite'] : '' ) );
                $a_commande_article_Prix_ligne = (float) ( isset($colonnes['a_commande_article_Prix_ligne']) && ( $force || mf_matrice_droits(['api_modifier__a_commande_article_Prix_ligne', 'a_commande_article__MODIFIER']) ) ? str_replace(',', '.', $colonnes['a_commande_article_Prix_ligne']) : ( isset($a_commande_article['a_commande_article_Prix_ligne']) ? $a_commande_article['a_commande_article_Prix_ligne'] : '' ) );
                $retour = $this->mf_modifier($Code_commande, $Code_article, $a_commande_article_Quantite, $a_commande_article_Prix_ligne, true);
                if ($retour['code_erreur'] != 0 && $retour['code_erreur'] != ERR_A_COMMANDE_ARTICLE__MODIFIER__AUCUN_CHANGEMENT) {
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

    public function mf_modifier_3(array $lignes) // array( array('Code_' => $Code, ..., 'colonne1' => 'valeur1', [...] ), [...] )
    {
        $code_erreur = 0;
        $modifs = false;

        // transformation des lignes en colonnes
        $valeurs_en_colonnes = [];
        $liste_valeurs_indexees = [];
        foreach ($lignes as $colonnes) {
            foreach ($colonnes as $colonne => $valeur)
            {
                if ($colonne == 'a_commande_article_Quantite' || $colonne == 'a_commande_article_Prix_ligne') {
                    if (isset($colonnes['Code_commande']) && isset($colonnes['Code_article'])) {
                        $valeurs_en_colonnes[$colonne]['Code_commande='.$colonnes['Code_commande'] . ' AND ' . 'Code_article='.$colonnes['Code_article']]=$valeur;
                        $liste_valeurs_indexees[$colonne]["$valeur"][]='Code_commande='.$colonnes['Code_commande'] . ' AND ' . 'Code_article='.$colonnes['Code_article'];
                    }
                }
            }
        }

        // fabrication des requetes
        foreach ($valeurs_en_colonnes as $colonne => $valeurs) {
            if (count($liste_valeurs_indexees[$colonne]) > 3) {
                $perimetre = '';
                $modification_sql = 'CASE';
                foreach ($valeurs as $conditions => $valeur) {
                    $modification_sql .= ' WHEN ' . $conditions . ' THEN ' . format_sql($colonne, $valeur);
                    $perimetre .= ( $perimetre!='' ? ' OR ' : '' ) . $conditions;
                }
                $modification_sql .= ' END';
                executer_requete_mysql('UPDATE ' . inst('a_commande_article') . ' SET ' . $colonne . ' = ' . $modification_sql . ' WHERE ' . $perimetre . ';', array_search('a_commande_article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
                if (requete_mysqli_affected_rows() != 0) {
                    $modifs = true;
                }
            } else {
                foreach ($liste_valeurs_indexees[$colonne] as $valeur => $indices_par_valeur) {
                    $perimetre = '';
                    foreach ($indices_par_valeur as $conditions) {
                        $perimetre .= ($perimetre!='' ? ' OR ' : '') . $conditions;
                    }
                    executer_requete_mysql('UPDATE ' . inst('a_commande_article') . ' SET ' . $colonne . ' = ' . format_sql($colonne, $valeur) . ' WHERE ' . $perimetre . ';', array_search('a_commande_article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
                    if (requete_mysqli_affected_rows() != 0) {
                        $modifs = true;
                    }
                }
            }
        }

        if (! $modifs && $code_erreur == 0) {
            $code_erreur = ERR_A_COMMANDE_ARTICLE__MODIFIER_3__AUCUN_CHANGEMENT;
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

    public function mf_modifier_4(int $Code_commande, int $Code_article, array $data, ?array $options = null ) // $data = array('colonne1' => 'valeur1', ... ) / $options = [ 'cond_mysql' => [], 'limit' => 0 ]
    {
        if ($options === null) {
            $options=[];
        }
        $code_erreur = 0;
        $Code_commande = intval($Code_commande);
        $Code_article = intval($Code_article);
        $mf_colonnes_a_modifier = [];
        if ( isset($data['a_commande_article_Quantite']) ) { $mf_colonnes_a_modifier[] = 'a_commande_article_Quantite = ' . format_sql('a_commande_article_Quantite', $data['a_commande_article_Quantite']); }
        if ( isset($data['a_commande_article_Prix_ligne']) ) { $mf_colonnes_a_modifier[] = 'a_commande_article_Prix_ligne = ' . format_sql('a_commande_article_Prix_ligne', $data['a_commande_article_Prix_ligne']); }
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

            $requete = 'UPDATE ' . inst('a_commande_article') . ' SET ' . enumeration($mf_colonnes_a_modifier) . " WHERE 1".( $Code_commande!=0 ? " AND Code_commande=$Code_commande" : "" )."".( $Code_article!=0 ? " AND Code_article=$Code_article" : "" )."$argument_cond" . ( $limit>0 ? ' LIMIT ' . $limit : '' ) . ";";
            executer_requete_mysql( $requete , array_search('a_commande_article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            if (requete_mysqli_affected_rows() == 0) {
                $code_erreur = ERR_A_COMMANDE_ARTICLE__MODIFIER_4__AUCUN_CHANGEMENT;
            } else {
                self::$cache_db->clear();
            }
        }
        return ['code_erreur' => $code_erreur];
    }

    public function mf_supprimer(?int $Code_commande = null, ?int $Code_article = null, ?bool $force = null)
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        $Code_commande = intval($Code_commande);
        $Code_article = intval($Code_article);
        $copie__liste_a_commande_article = $this->mf_lister($Code_commande, $Code_article, ['autocompletion' => false]);
        $liste_Code_commande = [];
        $liste_Code_article = [];
        foreach ( $copie__liste_a_commande_article as $copie__a_commande_article )
        {
            $Code_commande = $copie__a_commande_article['Code_commande'];
            $Code_article = $copie__a_commande_article['Code_article'];
            if (! $force) {
                if (!self::$maj_droits_supprimer_en_cours)
                {
                    self::$maj_droits_supprimer_en_cours = true;
                    Hook_a_commande_article::hook_actualiser_les_droits_supprimer($Code_commande, $Code_article);
                    self::$maj_droits_supprimer_en_cours = false;
                }
            }
            if ( !$force && !mf_matrice_droits(['a_commande_article__SUPPRIMER']) ) $code_erreur = REFUS_A_COMMANDE_ARTICLE__SUPPRIMER;
            elseif ( !Hook_a_commande_article::autorisation_suppression($Code_commande, $Code_article) ) $code_erreur = REFUS_A_COMMANDE_ARTICLE__SUPPRESSION_BLOQUEE;
            {
                $liste_Code_commande[] = $Code_commande;
                $liste_Code_article[] = $Code_article;
            }
        }
        if ($code_erreur == 0 && count($liste_Code_commande)>0 && count($liste_Code_article)>0) {
            $requete = 'DELETE IGNORE FROM ' . inst('a_commande_article') . " WHERE Code_commande IN ".Sql_Format_Liste($liste_Code_commande)." AND Code_article IN ".Sql_Format_Liste($liste_Code_article).";";
            executer_requete_mysql( $requete , array_search('a_commande_article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            if (requete_mysqli_affected_rows() == 0) {
                $code_erreur = ERR_A_COMMANDE_ARTICLE__SUPPRIMER__REFUSE;
            } else {
                self::$cache_db->clear();
                Hook_a_commande_article::supprimer($copie__liste_a_commande_article);
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

    public function mf_supprimer_2(?int $Code_commande = null, ?int $Code_article = null)
    {
        $code_erreur = 0;
        $Code_commande = intval($Code_commande);
        $Code_article = intval($Code_article);
        $copie__liste_a_commande_article = $this->mf_lister_2($Code_commande, $Code_article, ['autocompletion' => false]);
        $requete = 'DELETE IGNORE FROM ' . inst('a_commande_article') . " WHERE 1".( $Code_commande!=0 ? " AND Code_commande=$Code_commande" : "" )."".( $Code_article!=0 ? " AND Code_article=$Code_article" : "" ).";";
        executer_requete_mysql( $requete , array_search('a_commande_article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        if ( requete_mysqli_affected_rows()==0 )
        {
            $code_erreur = ERR_A_COMMANDE_ARTICLE__SUPPRIMER_2__REFUSE;
        } else {
            self::$cache_db->clear();
            Hook_a_commande_article::supprimer($copie__liste_a_commande_article);
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
        return $this->mf_lister(isset($est_charge['commande']) ? $mf_contexte['Code_commande'] : 0, isset($est_charge['article']) ? $mf_contexte['Code_article'] : 0, $options);
    }

    public function mf_lister(?int $Code_commande = null, ?int $Code_article = null, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'liste_colonnes_a_selectionner' => [], 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $liste = $this->mf_lister_2($Code_commande, $Code_article, $options);

        // controle_acces_donnees
        $controle_acces_donnees = CONTROLE_ACCES_DONNEES_DEFAUT;
        if (isset($options['controle_acces_donnees']))
        {
            $controle_acces_donnees = ( $options['controle_acces_donnees']==true );
        }

        foreach ($liste as $key => $elem)
        {
            if ( $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_commande', $elem['Code_commande']) || $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_article', $elem['Code_article']) )
            {
                unset($liste[$key]);
            }
        }

        return $liste;
    }

    public function mf_lister_2(?int $Code_commande = null, ?int $Code_article = null, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'liste_colonnes_a_selectionner' => [], 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cle = 'a_commande_article__lister';
        $Code_commande = intval($Code_commande);
        $cle .= "_{$Code_commande}";
        $Code_article = intval($Code_article);
        $cle .= "_{$Code_article}";

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
            if (isset($mf_tri_defaut_table['a_commande_article'])) {
                $options['tris'] = $mf_tri_defaut_table['a_commande_article'];
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
            if ($argument_cond != '') {
                if ( strpos($argument_cond, 'a_commande_article_Quantite')!==false ) { $liste_colonnes_a_indexer['a_commande_article_Quantite'] = 'a_commande_article_Quantite'; }
                if ( strpos($argument_cond, 'a_commande_article_Prix_ligne')!==false ) { $liste_colonnes_a_indexer['a_commande_article_Prix_ligne'] = 'a_commande_article_Prix_ligne'; }
            }
            if (isset($options['tris'])) {
                if ( isset($options['tris']['a_commande_article_Quantite']) ) { $liste_colonnes_a_indexer['a_commande_article_Quantite'] = 'a_commande_article_Quantite'; }
                if ( isset($options['tris']['a_commande_article_Prix_ligne']) ) { $liste_colonnes_a_indexer['a_commande_article_Prix_ligne'] = 'a_commande_article_Prix_ligne'; }
            }
            if (count($liste_colonnes_a_indexer) > 0) {
                if (false === $mf_liste_requete_index = self::$cache_db->read('a_commande_article__index')) {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('a_commande_article').'`;', false);
                    $mf_liste_requete_index = [];
                    while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    self::$cache_db->write('a_commande_article__index', $mf_liste_requete_index);
                }
                foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if (count($liste_colonnes_a_indexer) > 0) {
                    foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                        executer_requete_mysql('ALTER TABLE `'.inst('a_commande_article').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    self::$cache_db->clear();
                }
            }

            $liste = [];
            if (count($liste_colonnes_a_selectionner) == 0) {
                if ($toutes_colonnes) {
                    $colonnes = 'a_commande_article_Quantite, a_commande_article_Prix_ligne, Code_commande, Code_article';
                } else {
                    $colonnes = 'a_commande_article_Quantite, a_commande_article_Prix_ligne, Code_commande, Code_article';
                }
            } else {
                $liste_colonnes_a_selectionner[] = 'Code_commande';
                $liste_colonnes_a_selectionner[] = 'Code_article';
                $colonnes = enumeration($liste_colonnes_a_selectionner);
            }

            $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM '.inst('a_commande_article')." WHERE 1{$argument_cond}".( $Code_commande!=0 ? " AND Code_commande=$Code_commande" : "" )."".( $Code_article!=0 ? " AND Code_article=$Code_article" : "" )."{$argument_tris}{$argument_limit};", false);
            while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                mf_formatage_db_type_php($row_requete);
                $liste[$row_requete['Code_commande'].'-'.$row_requete['Code_article']] = $row_requete;
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
                Hook_a_commande_article::completion($element, self::$auto_completion - 1);
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

    public function mf_get(int $Code_commande, int $Code_article, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cle = "a_commande_article__get";
        $Code_commande = intval($Code_commande);
        $cle .= "_{$Code_commande}";
        $Code_article = intval($Code_article);
        $cle .= "_{$Code_article}";
        $retour = [];
        if (! CONTROLE_ACCES_DONNEES_DEFAUT || Hook_mf_systeme::controle_acces_donnees('Code_commande', $Code_commande) && Hook_mf_systeme::controle_acces_donnees('Code_article', $Code_article)) {

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
                    $colonnes='a_commande_article_Quantite, a_commande_article_Prix_ligne, Code_commande, Code_article';
                } else {
                    $colonnes='a_commande_article_Quantite, a_commande_article_Prix_ligne, Code_commande, Code_article';
                }
                $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM ' . inst('a_commande_article')." WHERE Code_commande=$Code_commande AND Code_article=$Code_article;", false);
                if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                    mf_formatage_db_type_php($row_requete);
                    $retour = $row_requete;
                } else {
                    $retour = [];
                }
                mysqli_free_result($res_requete);
                self::$cache_db->write($cle, $retour);
            }
            if (isset($retour['Code_commande'])) {
                if (($autocompletion_recursive || self::$auto_completion < 1) && $autocompletion) {
                    self::$auto_completion ++;
                    Hook_a_commande_article::completion($retour, self::$auto_completion - 1);
                    self::$auto_completion --;
                }
            }
        }
        return $retour;
    }

    public function mf_get_2(int $Code_commande, int $Code_article, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cle = "a_commande_article__get";
        $Code_commande = intval($Code_commande);
        $cle .= "_{$Code_commande}";
        $Code_article = intval($Code_article);
        $cle .= "_{$Code_article}";

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
                $colonnes='a_commande_article_Quantite, a_commande_article_Prix_ligne, Code_commande, Code_article';
            } else {
                $colonnes='a_commande_article_Quantite, a_commande_article_Prix_ligne, Code_commande, Code_article';
            }
            $res_requete = executer_requete_mysql("SELECT $colonnes FROM " . inst('a_commande_article')." WHERE Code_commande=$Code_commande AND Code_article=$Code_article;", false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                mf_formatage_db_type_php($row_requete);
                $retour = $row_requete;
            } else {
                $retour = [];
            }
            mysqli_free_result($res_requete);
            self::$cache_db->write($cle, $retour);
        }
        if (isset($retour['Code_commande'])) {
            if (($autocompletion_recursive || self::$auto_completion < 1) && $autocompletion) {
                self::$auto_completion ++;
                Hook_a_commande_article::completion($retour, self::$auto_completion - 1);
                self::$auto_completion --;
            }
        }
        return $retour;
    }

    public function mf_compter(?int $Code_commande = null, ?int $Code_article = null, ?array $options = null /* $options = [ 'cond_mysql' => [] ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cle = 'a_commande_article__compter';
        $Code_commande = intval($Code_commande);
        $cle .= '_{'.$Code_commande.'}';
        $Code_article = intval($Code_article);
        $cle .= '_{'.$Code_article.'}';

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
                if ( strpos($argument_cond, 'a_commande_article_Quantite')!==false ) { $liste_colonnes_a_indexer['a_commande_article_Quantite'] = 'a_commande_article_Quantite'; }
                if ( strpos($argument_cond, 'a_commande_article_Prix_ligne')!==false ) { $liste_colonnes_a_indexer['a_commande_article_Prix_ligne'] = 'a_commande_article_Prix_ligne'; }
            }
            if (count($liste_colonnes_a_indexer) > 0) {
                if (false === $mf_liste_requete_index = self::$cache_db->read('a_commande_article__index')) {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('a_commande_article').'`;', false);
                    $mf_liste_requete_index = [];
                    while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    self::$cache_db->write('a_commande_article__index', $mf_liste_requete_index);
                }
                foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if (count($liste_colonnes_a_indexer) > 0) {
                    foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                        executer_requete_mysql('ALTER TABLE `'.inst('a_commande_article').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    self::$cache_db->clear();
                }
            }

            $res_requete = executer_requete_mysql("SELECT COUNT(CONCAT(Code_commande,'|',Code_article)) as nb FROM " . inst('a_commande_article') . " WHERE 1{$argument_cond}".( $Code_commande!=0 ? " AND Code_commande=$Code_commande" : "" )."".( $Code_article!=0 ? " AND Code_article=$Code_article" : "" ).";", false);
            $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC);
            mysqli_free_result($res_requete);
            $nb = (int) $row_requete['nb'];
            self::$cache_db->write($cle, $nb);
        }
        return $nb;
    }

    public function mf_liste_Code_commande_vers_liste_Code_article( array $liste_Code_commande, ?array $options = null /* $options = [ 'cond_mysql' => [] ] */)
    {
        if ($options === null) {
            $options=[];
        }
        return $this->a_commande_article_liste_Code_commande_vers_liste_Code_article( $liste_Code_commande , $options );
    }

    public function mf_liste_Code_article_vers_liste_Code_commande( array $liste_Code_article, ?array $options = null /* $options = [ 'cond_mysql' => [] ] */)
    {
        if ($options === null) {
            $options=[];
        }
        return $this->a_commande_article_liste_Code_article_vers_liste_Code_commande( $liste_Code_article , $options );
    }

    public function mf_get_liste_tables_parents()
    {
        return ['commande','article'];
    }

}
