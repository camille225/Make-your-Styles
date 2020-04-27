<?php declare(strict_types=1);

/*
    +------------------------------+
    |  NE PAS MODIFIER CE FICHIER  |
    +------------------------------+
*/

class table_categorie_article_monframework extends entite
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
            include_once __DIR__ . '/../../erreurs/erreurs__categorie_article.php';
            self::$initialisation = false;
            Hook_categorie_article::initialisation();
            self::$cache_db = new Mf_Cachedb('categorie_article');
        }
        if (! self::$actualisation_en_cours) {
            self::$actualisation_en_cours=true;
            Hook_categorie_article::actualisation();
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

        if (! test_si_table_existe(inst('categorie_article'))) {
            executer_requete_mysql('CREATE TABLE '.inst('categorie_article').'(Code_categorie_article BIGINT UNSIGNED NOT NULL AUTO_INCREMENT, PRIMARY KEY (Code_categorie_article)) ENGINE=MyISAM;', array_search('categorie_article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        $liste_colonnes = lister_les_colonnes('categorie_article');

        if (isset($liste_colonnes['categorie_article_Libelle'])) {
            if (typeMyql2Sql($liste_colonnes['categorie_article_Libelle']['Type'])!='VARCHAR') {
                executer_requete_mysql('ALTER TABLE '.inst('categorie_article').' CHANGE categorie_article_Libelle categorie_article_Libelle VARCHAR(255);', array_search('categorie_article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['categorie_article_Libelle']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('categorie_article').' ADD categorie_article_Libelle VARCHAR(255);', array_search('categorie_article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE '.inst('categorie_article').' SET categorie_article_Libelle=' . format_sql('categorie_article_Libelle', $mf_initialisation['categorie_article_Libelle']) . ';', array_search('categorie_article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        $liste_colonnes_a_indexer = [];

        if (isset($liste_colonnes['mf_signature'])) {
            unset($liste_colonnes['mf_signature']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('categorie_article').' ADD mf_signature VARCHAR(255);', array_search('categorie_article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }
        $liste_colonnes_a_indexer['mf_signature'] = 'mf_signature';

        if (isset($liste_colonnes['mf_cle_unique'])) {
            unset($liste_colonnes['mf_cle_unique']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('categorie_article').' ADD mf_cle_unique VARCHAR(255);', array_search('categorie_article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }
        $liste_colonnes_a_indexer['mf_cle_unique'] = 'mf_cle_unique';

        if (isset($liste_colonnes['mf_date_creation'])) {
            unset($liste_colonnes['mf_date_creation']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('categorie_article').' ADD mf_date_creation DATETIME;', array_search('categorie_article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }
        $liste_colonnes_a_indexer['mf_date_creation'] = 'mf_date_creation';

        if (isset($liste_colonnes['mf_date_modification'])) {
            unset($liste_colonnes['mf_date_modification']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('categorie_article').' ADD mf_date_modification DATETIME;', array_search('categorie_article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }
        $liste_colonnes_a_indexer['mf_date_modification'] = 'mf_date_modification';

        unset($liste_colonnes['Code_categorie_article']);

        foreach ($liste_colonnes as $field => $value) {
            executer_requete_mysql('ALTER TABLE '.inst('categorie_article').' DROP COLUMN '.$field.';', array_search('categorie_article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `' . inst('categorie_article') . '`;', false);
        $mf_liste_requete_index = [];
        while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
            $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
        }
        mysqli_free_result($res_requete_index);
        foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
            if (isset($liste_colonnes_a_indexer[$mf_colonne_indexee])) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
        }
        foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
            executer_requete_mysql('ALTER TABLE `' . inst('categorie_article') . '` ADD INDEX(`' . $colonnes_a_indexer . '`);', array_search('categorie_article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }
    }

    /**
     * Retourne la tructure de la table « categorie_article » avec les valeurs initialisées par défaut.
     * @return array
     */
    public function mf_get_structure(): array
    {
        global $mf_initialisation;
        $struc = [
            'Code_categorie_article' => null, // ID
            'categorie_article_Libelle' => $mf_initialisation['categorie_article_Libelle'],
        ];
        mf_formatage_db_type_php($struc);
        Hook_categorie_article::pre_controller($struc['categorie_article_Libelle'], $struc['Code_categorie_article']);
        return $struc;
    }

    public function mf_ajouter(string $categorie_article_Libelle, ?bool $force = false)
    {
        if ($force === null) {
            $force = false;
        }
        $Code_categorie_article = 0;
        $code_erreur = 0;
        // Typage
        $categorie_article_Libelle = (string) $categorie_article_Libelle;
        // Fin typage
        Hook_categorie_article::pre_controller($categorie_article_Libelle);
        if (! $force) {
            if (! self::$maj_droits_ajouter_en_cours) {
                self::$maj_droits_ajouter_en_cours = true;
                Hook_categorie_article::hook_actualiser_les_droits_ajouter();
                self::$maj_droits_ajouter_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['categorie_article__AJOUTER']) ) $code_erreur = REFUS_CATEGORIE_ARTICLE__AJOUTER;
        elseif (! Hook_categorie_article::autorisation_ajout($categorie_article_Libelle) ) $code_erreur = REFUS_CATEGORIE_ARTICLE__AJOUT_BLOQUEE;
        else {
            Hook_categorie_article::data_controller($categorie_article_Libelle);
            $mf_signature = text_sql(Hook_categorie_article::calcul_signature($categorie_article_Libelle));
            $mf_cle_unique = text_sql(Hook_categorie_article::calcul_cle_unique($categorie_article_Libelle));
            $categorie_article_Libelle = text_sql($categorie_article_Libelle);
            $requete = "INSERT INTO " . inst('categorie_article') . " ( mf_signature, mf_cle_unique, mf_date_creation, mf_date_modification, categorie_article_Libelle ) VALUES ( '$mf_signature', '$mf_cle_unique', '".get_now()."', '".get_now()."', '$categorie_article_Libelle' );";
            executer_requete_mysql($requete, array_search('categorie_article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            $Code_categorie_article = requete_mysql_insert_id();
            if ($Code_categorie_article == 0) {
                $code_erreur = ERR_CATEGORIE_ARTICLE__AJOUTER__AJOUT_REFUSE;
            } else {
                self::$cache_db->clear();
                Hook_categorie_article::ajouter( $Code_categorie_article );
            }
        }
        if ($code_erreur != 0) {
            global $mf_message_erreur_personalise, $mf_libelle_erreur;
            if ($mf_message_erreur_personalise != '') {
                $mf_libelle_erreur[$code_erreur] = $mf_message_erreur_personalise;
                $mf_message_erreur_personalise = '';
            }
        }
        return ['code_erreur' => $code_erreur, 'Code_categorie_article' => $Code_categorie_article, 'callback' => ( $code_erreur==0 ? Hook_categorie_article::callback_post($Code_categorie_article) : null )];
    }

    public function mf_creer(?bool $force = null)
    {
        if ($force === null) {
            $force = false;
        }
        global $mf_initialisation;
        $categorie_article_Libelle = $mf_initialisation['categorie_article_Libelle'];
        // Typage
        $categorie_article_Libelle = (string) $categorie_article_Libelle;
        // Fin typage
        return $this->mf_ajouter($categorie_article_Libelle, $force);
    }

    public function mf_ajouter_2(array $ligne, bool $force = null) // array('colonne1' => 'valeur1',  [...] )
    {
        if ($force === null) {
            $force = false;
        }
        global $mf_initialisation;
        $categorie_article_Libelle = (isset($ligne['categorie_article_Libelle'])?$ligne['categorie_article_Libelle']:$mf_initialisation['categorie_article_Libelle']);
        // Typage
        $categorie_article_Libelle = (string) $categorie_article_Libelle;
        // Fin typage
        return $this->mf_ajouter($categorie_article_Libelle, $force);
    }

    public function mf_ajouter_3(array $lignes) // array( array( 'colonne1' => 'valeur1', 'colonne2' => 'valeur2',  [...] ), [...] )
    {
        global $mf_initialisation;
        $code_erreur = 0;
        $values = '';
        foreach ($lignes as $ligne) {
            $categorie_article_Libelle = text_sql((isset($ligne['categorie_article_Libelle']) ? $ligne['categorie_article_Libelle'] : $mf_initialisation['categorie_article_Libelle']));
            $values .= ($values != '' ? ',' : '') . "('$categorie_article_Libelle')";
        }
        if ($values != '') {
            $requete = "INSERT INTO " . inst('categorie_article') . " ( categorie_article_Libelle ) VALUES $values;";
            executer_requete_mysql( $requete , array_search('categorie_article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            $n = requete_mysqli_affected_rows();
            if ($n < count($lignes)) {
                $code_erreur = ERR_CATEGORIE_ARTICLE__AJOUTER_3__ECHEC_AJOUT;
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

    public function mf_actualiser_signature(int $Code_categorie_article)
    {
        $categorie_article = $this->mf_get_2($Code_categorie_article, ['autocompletion' => false]);
        $mf_signature = text_sql(Hook_categorie_article::calcul_signature($categorie_article['categorie_article_Libelle']));
        $mf_cle_unique = text_sql(Hook_categorie_article::calcul_cle_unique($categorie_article['categorie_article_Libelle']));
        $table = inst('categorie_article');
        executer_requete_mysql("UPDATE $table SET mf_signature='$mf_signature', mf_cle_unique='$mf_cle_unique' WHERE Code_categorie_article=$Code_categorie_article;", array_search('categorie_article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        if (requete_mysqli_affected_rows() == 1) {
            self::$cache_db->clear();
        }
    }

    public function mf_modifier( int $Code_categorie_article, string $categorie_article_Libelle, ?bool $force = null)
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        // Typage
        $categorie_article_Libelle = (string) $categorie_article_Libelle;
        // Fin typage
        Hook_categorie_article::pre_controller($categorie_article_Libelle, $Code_categorie_article);
        if (! $force) {
            if (! self::$maj_droits_modifier_en_cours) {
                self::$maj_droits_modifier_en_cours = true;
                Hook_categorie_article::hook_actualiser_les_droits_modifier($Code_categorie_article);
                self::$maj_droits_modifier_en_cours = false;
            }
        }
        $categorie_article = $this->mf_get_2( $Code_categorie_article, ['autocompletion' => false, 'masquer_mdp' => false]);
        if ( !$force && !mf_matrice_droits(['categorie_article__MODIFIER']) ) $code_erreur = REFUS_CATEGORIE_ARTICLE__MODIFIER;
        elseif (! $this->mf_tester_existance_Code_categorie_article($Code_categorie_article)) $code_erreur = ERR_CATEGORIE_ARTICLE__MODIFIER__CODE_CATEGORIE_ARTICLE_INEXISTANT;
        elseif (CONTROLE_ACCES_DONNEES_DEFAUT && ! Hook_mf_systeme::controle_acces_donnees('Code_categorie_article', $Code_categorie_article)) $code_erreur = ACCES_CODE_CATEGORIE_ARTICLE_REFUSE;
        elseif ( !Hook_categorie_article::autorisation_modification($Code_categorie_article, $categorie_article_Libelle) ) $code_erreur = REFUS_CATEGORIE_ARTICLE__MODIFICATION_BLOQUEE;
        else {
            if (! isset(self::$lock[$Code_categorie_article])) {
                self::$lock[$Code_categorie_article] = 0;
            }
            if (self::$lock[$Code_categorie_article] == 0) {
                self::$cache_db->add_lock((string) $Code_categorie_article);
            }
            self::$lock[$Code_categorie_article]++;
            Hook_categorie_article::data_controller($categorie_article_Libelle, $Code_categorie_article);
            $mf_colonnes_a_modifier=[];
            $bool__categorie_article_Libelle = false; if ($categorie_article_Libelle !== $categorie_article['categorie_article_Libelle']) {Hook_categorie_article::data_controller__categorie_article_Libelle($categorie_article['categorie_article_Libelle'], $categorie_article_Libelle, $Code_categorie_article); if ( $categorie_article_Libelle !== $categorie_article['categorie_article_Libelle'] ) { $mf_colonnes_a_modifier[] = 'categorie_article_Libelle=' . format_sql('categorie_article_Libelle', $categorie_article_Libelle); $bool__categorie_article_Libelle = true;}}
            if (count($mf_colonnes_a_modifier) > 0) {
                $mf_signature = text_sql(Hook_categorie_article::calcul_signature($categorie_article_Libelle));
                $mf_cle_unique = text_sql(Hook_categorie_article::calcul_cle_unique($categorie_article_Libelle));
                $mf_colonnes_a_modifier[] = 'mf_signature=\'' . $mf_signature . '\'';
                $mf_colonnes_a_modifier[] = 'mf_cle_unique=\'' . $mf_cle_unique . '\'';
                $mf_colonnes_a_modifier[] = 'mf_date_modification=\'' . get_now() . '\'';
                $requete = 'UPDATE '.inst('categorie_article').' SET ' . enumeration($mf_colonnes_a_modifier) . ' WHERE Code_categorie_article = ' . $Code_categorie_article . ';';
                executer_requete_mysql($requete, array_search('categorie_article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
                if (requete_mysqli_affected_rows() == 0) {
                    $code_erreur = ERR_CATEGORIE_ARTICLE__MODIFIER__AUCUN_CHANGEMENT;
                } else {
                    self::$cache_db->clear();
                    Hook_categorie_article::modifier($Code_categorie_article, $bool__categorie_article_Libelle);
                }
            } else {
                $code_erreur = ERR_CATEGORIE_ARTICLE__MODIFIER__AUCUN_CHANGEMENT;
            }
            self::$lock[$Code_categorie_article]--;
            if (self::$lock[$Code_categorie_article] == 0) {
                self::$cache_db->release_lock((string) $Code_categorie_article);
                unset(self::$lock[$Code_categorie_article]);
            }
        }
        if ($code_erreur != 0) {
            global $mf_message_erreur_personalise, $mf_libelle_erreur;
            if ($mf_message_erreur_personalise != '') {
                $mf_libelle_erreur[$code_erreur] = $mf_message_erreur_personalise;
                $mf_message_erreur_personalise = '';
            }
        }
        return ['code_erreur' => $code_erreur, 'callback' => ($code_erreur == 0 ? Hook_categorie_article::callback_put($Code_categorie_article) : null)];
    }

    public function mf_modifier_2(array $lignes, ?bool $force = null) // array( $Code_categorie_article => array('colonne1' => 'valeur1',  [...] ) )
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        foreach ($lignes as $Code_categorie_article => $colonnes) {
            if ($code_erreur == 0) {
                $Code_categorie_article = intval($Code_categorie_article);
                $categorie_article = $this->mf_get_2($Code_categorie_article, ['autocompletion' => false]);
                if (! $force) {
                    if (! self::$maj_droits_modifier_en_cours) {
                        self::$maj_droits_modifier_en_cours = true;
                        Hook_categorie_article::hook_actualiser_les_droits_modifier($Code_categorie_article);
                        self::$maj_droits_modifier_en_cours = false;
                    }
                }
                $categorie_article_Libelle = (isset($colonnes['categorie_article_Libelle']) && ( $force || mf_matrice_droits(['api_modifier__categorie_article_Libelle', 'categorie_article__MODIFIER']) ) ? $colonnes['categorie_article_Libelle'] : ( isset($categorie_article['categorie_article_Libelle']) ? $categorie_article['categorie_article_Libelle'] : '' ) );
                // Typage
                $categorie_article_Libelle = (string) $categorie_article_Libelle;
                // Fin typage
                $retour = $this->mf_modifier($Code_categorie_article, $categorie_article_Libelle, true);
                if ($retour['code_erreur'] != 0 && $retour['code_erreur'] != ERR_CATEGORIE_ARTICLE__MODIFIER__AUCUN_CHANGEMENT) {
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

    public function mf_modifier_3(array $lignes) // array( $Code_categorie_article => array('colonne1' => 'valeur1',  [...] ) )
    {
        $code_erreur = 0;
        $modifs = false;

        // transformation des lignes en colonnes
        $valeurs_en_colonnes = [];
        $indices_par_colonne = [];
        $liste_valeurs_indexees = [];
        foreach ($lignes as $Code_categorie_article => $colonnes) {
            foreach ($colonnes as $colonne => $valeur) {
                if ($colonne == 'categorie_article_Libelle') {
                    $valeurs_en_colonnes[$colonne][$Code_categorie_article] = $valeur;
                    $indices_par_colonne[$colonne][] = $Code_categorie_article;
                    $liste_valeurs_indexees[$colonne]["$valeur"][] = $Code_categorie_article;
                }
            }
        }

        // fabrication des requetes
        foreach ($valeurs_en_colonnes as $colonne => $valeurs) {
            if (count($liste_valeurs_indexees[$colonne]) > 3) {
                $modification_sql = $colonne . ' = CASE Code_categorie_article';
                foreach ($valeurs as $Code_categorie_article => $valeur) {
                    $modification_sql .= ' WHEN ' . $Code_categorie_article . ' THEN ' . format_sql($colonne, $valeur);
                }
                $modification_sql .= ' END';
                $perimetre = Sql_Format_Liste($indices_par_colonne[$colonne]);
                executer_requete_mysql('UPDATE ' . inst('categorie_article') . ' SET ' . $modification_sql . ' WHERE Code_categorie_article IN ' . $perimetre . ';', array_search('categorie_article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
                if (requete_mysqli_affected_rows() != 0) {
                    $modifs = true;
                }
            } else {
                foreach ($liste_valeurs_indexees[$colonne] as $valeur => $indices_par_valeur) {
                    $perimetre = Sql_Format_Liste($indices_par_valeur);
                    executer_requete_mysql('UPDATE ' . inst('categorie_article') . ' SET ' . $colonne . ' = ' . format_sql($colonne, $valeur) . ' WHERE Code_categorie_article IN ' . $perimetre . ';', array_search('categorie_article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
                    if (requete_mysqli_affected_rows() != 0) {
                        $modifs = true;
                    }
                }
            }
        }

        if (! $modifs && $code_erreur == 0) {
            $code_erreur = ERR_CATEGORIE_ARTICLE__MODIFIER_3__AUCUN_CHANGEMENT;
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
        if (isset($data['categorie_article_Libelle']) || array_key_exists('categorie_article_Libelle', $data)) { $mf_colonnes_a_modifier[] = 'categorie_article_Libelle = ' . format_sql('categorie_article_Libelle', $data['categorie_article_Libelle']); }
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

            $requete = 'UPDATE ' . inst('categorie_article') . ' SET ' . enumeration($mf_colonnes_a_modifier) . " WHERE 1$argument_cond" . ( $limit>0 ? ' LIMIT ' . $limit : '' ) . ";";
            executer_requete_mysql( $requete , array_search('categorie_article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            if (requete_mysqli_affected_rows() == 0) {
                $code_erreur = ERR_CATEGORIE_ARTICLE__MODIFIER_4__AUCUN_CHANGEMENT;
            } else {
                self::$cache_db->clear();
            }
        }
        return ['code_erreur' => $code_erreur];
    }

    public function mf_supprimer(int $Code_categorie_article, ?bool $force = null)
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        $Code_categorie_article = intval($Code_categorie_article);
        if (! $force) {
            if (!self::$maj_droits_supprimer_en_cours)
            {
                self::$maj_droits_supprimer_en_cours = true;
                Hook_categorie_article::hook_actualiser_les_droits_supprimer($Code_categorie_article);
                self::$maj_droits_supprimer_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['categorie_article__SUPPRIMER']) ) $code_erreur = REFUS_CATEGORIE_ARTICLE__SUPPRIMER;
        elseif (! $this->mf_tester_existance_Code_categorie_article($Code_categorie_article) ) $code_erreur = ERR_CATEGORIE_ARTICLE__SUPPRIMER_2__CODE_CATEGORIE_ARTICLE_INEXISTANT;
        elseif (CONTROLE_ACCES_DONNEES_DEFAUT && ! Hook_mf_systeme::controle_acces_donnees('Code_categorie_article', $Code_categorie_article)) $code_erreur = ACCES_CODE_CATEGORIE_ARTICLE_REFUSE;
        elseif ( !Hook_categorie_article::autorisation_suppression($Code_categorie_article) ) $code_erreur = REFUS_CATEGORIE_ARTICLE__SUPPRESSION_BLOQUEE;
        else
        {
            $copie__categorie_article = $this->mf_get($Code_categorie_article, ['autocompletion' => false]);
            $this->supprimer_donnes_en_cascade("categorie_article", [$Code_categorie_article]);
            $requete = 'DELETE IGNORE FROM ' . inst('categorie_article') . ' WHERE Code_categorie_article=' . $Code_categorie_article . ';';
            executer_requete_mysql($requete, array_search('categorie_article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            if (requete_mysqli_affected_rows() == 0) {
                $code_erreur = ERR_CATEGORIE_ARTICLE__SUPPRIMER__REFUSEE;
            } else {
                self::$cache_db->clear();
                Hook_categorie_article::supprimer($copie__categorie_article);
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

    public function mf_supprimer_2(array $liste_Code_categorie_article, ?bool $force = null)
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        $copie__liste_categorie_article = $this->mf_lister_2($liste_Code_categorie_article, ['autocompletion' => false]);
        $liste_Code_categorie_article=[];
        foreach ( $copie__liste_categorie_article as $copie__categorie_article )
        {
            $Code_categorie_article = $copie__categorie_article['Code_categorie_article'];
            if (! $force) {
                if (!self::$maj_droits_supprimer_en_cours)
                {
                    self::$maj_droits_supprimer_en_cours = true;
                    Hook_categorie_article::hook_actualiser_les_droits_supprimer($Code_categorie_article);
                    self::$maj_droits_supprimer_en_cours = false;
                }
            }
            if ( !$force && !mf_matrice_droits(['categorie_article__SUPPRIMER']) ) $code_erreur = REFUS_CATEGORIE_ARTICLE__SUPPRIMER;
            elseif ( !Hook_categorie_article::autorisation_suppression($Code_categorie_article) ) $code_erreur = REFUS_CATEGORIE_ARTICLE__SUPPRESSION_BLOQUEE;
            {
                $liste_Code_categorie_article[] = $Code_categorie_article;
            }
        }
        if ($code_erreur == 0 && count($liste_Code_categorie_article) > 0) {
            $this->supprimer_donnes_en_cascade("categorie_article", $liste_Code_categorie_article);
            $requete = 'DELETE IGNORE FROM ' . inst('categorie_article') . ' WHERE Code_categorie_article IN ' . Sql_Format_Liste($liste_Code_categorie_article) . ';';
            executer_requete_mysql( $requete , array_search('categorie_article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            if (requete_mysqli_affected_rows() == 0) {
                $code_erreur = ERR_CATEGORIE_ARTICLE__SUPPRIMER_2__REFUSEE;
            } else {
                self::$cache_db->clear();
                Hook_categorie_article::supprimer_2($copie__liste_categorie_article);
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

    public function mf_supprimer_3(array $liste_Code_categorie_article)
    {
        $code_erreur = 0;
        if (count($liste_Code_categorie_article) > 0) {
            $this->supprimer_donnes_en_cascade("categorie_article", $liste_Code_categorie_article);
            $requete = 'DELETE IGNORE FROM ' . inst('categorie_article') . ' WHERE Code_categorie_article IN ' . Sql_Format_Liste($liste_Code_categorie_article) . ';';
            executer_requete_mysql( $requete , array_search('categorie_article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            if (requete_mysqli_affected_rows() == 0) {
                $code_erreur = ERR_CATEGORIE_ARTICLE__SUPPRIMER_3__REFUSEE;
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
        if (! $contexte_parent && $mf_contexte['Code_categorie_article'] != 0) {
            $categorie_article = $this->mf_get( $mf_contexte['Code_categorie_article'], $options);
            return [$categorie_article['Code_categorie_article'] => $categorie_article];
        } else {
            return $this->mf_lister($options);
        }
    }

    public function mf_lister(?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'liste_colonnes_a_selectionner' => [], 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cle = "categorie_article__lister";

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
            if (isset($mf_tri_defaut_table['categorie_article'])) {
                $options['tris'] = $mf_tri_defaut_table['categorie_article'];
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
            $liste_categorie_article_pas_a_jour = [];
            if (false === $liste = self::$cache_db->read($cle)) {

                // Indexes
                $liste_colonnes_a_indexer = [];
                if ($argument_cond != '') {
                    if ( strpos($argument_cond, 'categorie_article_Libelle')!==false ) { $liste_colonnes_a_indexer['categorie_article_Libelle'] = 'categorie_article_Libelle'; }
                }
                if (isset($options['tris'])) {
                    if ( isset($options['tris']['categorie_article_Libelle']) ) { $liste_colonnes_a_indexer['categorie_article_Libelle'] = 'categorie_article_Libelle'; }
                }
                if (count($liste_colonnes_a_indexer) > 0) {
                    if (false === $mf_liste_requete_index = self::$cache_db->read('categorie_article__index')) {
                        $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('categorie_article').'`;', false);
                        $mf_liste_requete_index = [];
                        while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                            $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                        }
                        mysqli_free_result($res_requete_index);
                        self::$cache_db->write('categorie_article__index', $mf_liste_requete_index);
                    }
                    foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                        if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                    }
                    if (count($liste_colonnes_a_indexer) > 0) {
                        foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                            executer_requete_mysql('ALTER TABLE `'.inst('categorie_article').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                        }
                        self::$cache_db->clear();
                    }
                }

                if (count($liste_colonnes_a_selectionner) == 0) {
                    if ($toutes_colonnes) {
                        $colonnes = 'Code_categorie_article, categorie_article_Libelle';
                    } else {
                        $colonnes = 'Code_categorie_article, categorie_article_Libelle';
                    }
                } else {
                    $liste_colonnes_a_selectionner[] = 'Code_categorie_article';
                    $colonnes = enumeration($liste_colonnes_a_selectionner, ',');
                }

                $liste = [];
                $liste_categorie_article_pas_a_jour = [];
                $res_requete = executer_requete_mysql("SELECT $colonnes FROM " . inst('categorie_article') . " WHERE 1{$argument_cond}{$argument_tris}{$argument_limit};", false);
                while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                    mf_formatage_db_type_php($row_requete);
                    $liste[$row_requete['Code_categorie_article']] = $row_requete;
                    if ($maj && ! Hook_categorie_article::est_a_jour($row_requete)) {
                        $liste_categorie_article_pas_a_jour[$row_requete['Code_categorie_article']] = $row_requete;
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
                Hook_categorie_article::mettre_a_jour( $liste_categorie_article_pas_a_jour );
            }
        }

        foreach ($liste as $elem) {
            if ($controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_categorie_article', $elem['Code_categorie_article'])) {
                unset($liste[$elem['Code_categorie_article']]);
            } else {
                if (($autocompletion_recursive || self::$auto_completion < 1) && $autocompletion) {
                    self::$auto_completion ++;
                    Hook_categorie_article::completion($liste[$elem['Code_categorie_article']], self::$auto_completion - 1);
                    self::$auto_completion --;
                }
            }
        }

        return $liste;
    }

    public function mf_lister_2(array $liste_Code_categorie_article, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'liste_colonnes_a_selectionner' => [], 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        if (count($liste_Code_categorie_article) > 0) {
            $cle = "categorie_article__mf_lister_2_".Sql_Format_Liste($liste_Code_categorie_article);

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
                if (isset($mf_tri_defaut_table['categorie_article'])) {
                    $options['tris'] = $mf_tri_defaut_table['categorie_article'];
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
                $liste_categorie_article_pas_a_jour = [];
                if (false === $liste = self::$cache_db->read($cle)) {

                    // Indexes
                    $liste_colonnes_a_indexer = [];
                    if ($argument_cond != '') {
                        if ( strpos($argument_cond, 'categorie_article_Libelle')!==false ) { $liste_colonnes_a_indexer['categorie_article_Libelle'] = 'categorie_article_Libelle'; }
                    }
                    if (isset($options['tris'])) {
                        if ( isset($options['tris']['categorie_article_Libelle']) ) { $liste_colonnes_a_indexer['categorie_article_Libelle'] = 'categorie_article_Libelle'; }
                    }
                    if (count($liste_colonnes_a_indexer) > 0) {
                        if (false === $mf_liste_requete_index = self::$cache_db->read('categorie_article__index')) {
                            $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('categorie_article').'`;', false);
                            $mf_liste_requete_index = [];
                            while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                                $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                            }
                            mysqli_free_result($res_requete_index);
                            self::$cache_db->write('categorie_article__index', $mf_liste_requete_index);
                        }
                        foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                            if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                        }
                        if (count($liste_colonnes_a_indexer) > 0) {
                            foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                                executer_requete_mysql('ALTER TABLE `'.inst('categorie_article').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                            }
                            self::$cache_db->clear();
                        }
                    }

                    if (count($liste_colonnes_a_selectionner) == 0) {
                        if ($toutes_colonnes) {
                            $colonnes = 'Code_categorie_article, categorie_article_Libelle';
                        } else {
                            $colonnes = 'Code_categorie_article, categorie_article_Libelle';
                        }
                    } else {
                        $liste_colonnes_a_selectionner[] = 'Code_categorie_article';
                        $colonnes = enumeration($liste_colonnes_a_selectionner, ',');
                    }

                    $liste = [];
                    $liste_categorie_article_pas_a_jour = [];
                    $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM ' . inst('categorie_article') . " WHERE 1{$argument_cond} AND Code_categorie_article IN ".Sql_Format_Liste($liste_Code_categorie_article)."{$argument_tris}{$argument_limit};", false);
                    while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                        mf_formatage_db_type_php($row_requete);
                        $liste[$row_requete['Code_categorie_article']] = $row_requete;
                        if ($maj && ! Hook_categorie_article::est_a_jour($row_requete)) {
                            $liste_categorie_article_pas_a_jour[$row_requete['Code_categorie_article']] = $row_requete;
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
                    Hook_categorie_article::mettre_a_jour( $liste_categorie_article_pas_a_jour );
                }
            }

            foreach ($liste as $elem) {
                if ($controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_categorie_article', $elem['Code_categorie_article'])) {
                    unset($liste[$elem['Code_categorie_article']]);
                } else {
                    if (($autocompletion_recursive || self::$auto_completion < 1) && $autocompletion) {
                        self::$auto_completion ++;
                        Hook_categorie_article::completion($liste[$elem['Code_categorie_article']], self::$auto_completion - 1);
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

    public function mf_get(int $Code_categorie_article, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $Code_categorie_article = intval($Code_categorie_article);
        $retour = [];
        if ( ! CONTROLE_ACCES_DONNEES_DEFAUT || Hook_mf_systeme::controle_acces_donnees('Code_categorie_article', $Code_categorie_article) ) {
            $cle = 'categorie_article__get_'.$Code_categorie_article;

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
                        $colonnes='Code_categorie_article, categorie_article_Libelle';
                    } else {
                        $colonnes='Code_categorie_article, categorie_article_Libelle';
                    }
                    $res_requete = executer_requete_mysql("SELECT $colonnes FROM " . inst('categorie_article') . ' WHERE Code_categorie_article = ' . $Code_categorie_article . ';', false);
                    if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                        mf_formatage_db_type_php($row_requete);
                        $retour = $row_requete;
                        if ($maj && ! Hook_categorie_article::est_a_jour($row_requete)) {
                            $nouvelle_lecture = true;
                        }
                    } else {
                        $retour = [];
                    }
                    mysqli_free_result($res_requete);
                    if (! $nouvelle_lecture) {
                        self::$cache_db->write($cle, $retour);
                    } else {
                        Hook_categorie_article::mettre_a_jour([$row_requete['Code_categorie_article'] => $row_requete]);
                    }
                }
            }
            if (isset($retour['Code_categorie_article'])) {
                if (($autocompletion_recursive || self::$auto_completion < 1) && $autocompletion) {
                    self::$auto_completion ++;
                    Hook_categorie_article::completion($retour, self::$auto_completion - 1);
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
        $cle = "categorie_article__get_last";
        if (false === $retour = self::$cache_db->read($cle)) {
            $Code_categorie_article = 0;
            $res_requete = executer_requete_mysql('SELECT Code_categorie_article FROM ' . inst('categorie_article') . " WHERE 1 ORDER BY mf_date_creation DESC, Code_categorie_article DESC LIMIT 0 , 1;", false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $Code_categorie_article = intval($row_requete['Code_categorie_article']);
            }
            mysqli_free_result($res_requete);
            $retour = $this->mf_get($Code_categorie_article, $options);
            self::$cache_db->write($cle, $retour);
        }
        return $retour;
    }

    public function mf_get_2(int $Code_categorie_article, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cle = "categorie_article__get_$Code_categorie_article";

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
                $colonnes='Code_categorie_article, categorie_article_Libelle';
            } else {
                $colonnes='Code_categorie_article, categorie_article_Libelle';
            }
            $res_requete = executer_requete_mysql("SELECT $colonnes FROM " . inst('categorie_article') . " WHERE Code_categorie_article = $Code_categorie_article;", false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                mf_formatage_db_type_php($row_requete);
                $retour = $row_requete;
            } else {
                $retour = [];
            }
            mysqli_free_result($res_requete);
            self::$cache_db->write($cle, $retour);
        }
        if (isset($retour['Code_categorie_article'])) {
            if (($autocompletion_recursive || self::$auto_completion < 1) && $autocompletion) {
                self::$auto_completion ++;
                Hook_categorie_article::completion($retour, self::$auto_completion - 1);
                self::$auto_completion --;
            }
        }
        return $retour;
    }

    public function mf_prec_et_suiv( int $Code_categorie_article, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'liste_colonnes_a_selectionner' => [], 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $Code_categorie_article = intval($Code_categorie_article);
        $liste = $this->mf_lister($options);
        return prec_suiv($liste, $Code_categorie_article);
    }

    public function mf_compter(?array $options = null /* $options = [ 'cond_mysql' => [] ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cle = 'categorie_article__compter';

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
                if ( strpos($argument_cond, 'categorie_article_Libelle')!==false ) { $liste_colonnes_a_indexer['categorie_article_Libelle'] = 'categorie_article_Libelle'; }
            }
            if (count($liste_colonnes_a_indexer) > 0) {
                if (false === $mf_liste_requete_index = self::$cache_db->read('categorie_article__index')) {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('categorie_article').'`;', false);
                    $mf_liste_requete_index = [];
                    while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    self::$cache_db->write('categorie_article__index', $mf_liste_requete_index);
                }
                foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if (count($liste_colonnes_a_indexer) > 0) {
                    foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                        executer_requete_mysql('ALTER TABLE `'.inst('categorie_article').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    self::$cache_db->clear();
                }
            }

            $res_requete = executer_requete_mysql('SELECT count(Code_categorie_article) as nb FROM ' . inst('categorie_article')." WHERE 1{$argument_cond};", false);
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

    public function mf_liste_Code_categorie_article(?array $options = null /* $options = [ 'cond_mysql' => [] ] */)
    {
        if ($options === null) {
            $options=[];
        }
        return $this->get_liste_Code_categorie_article($options);
    }

    public function mf_get_liste_tables_parents()
    {
        return [];
    }

    public function mf_search_categorie_article_Libelle(string $categorie_article_Libelle): int
    {
        return $this->rechercher_categorie_article_Libelle($categorie_article_Libelle);
    }

    public function mf_search__colonne(string $colonne_db, $recherche): int
    {
        switch ($colonne_db) {
            case 'categorie_article_Libelle': return $this->mf_search_categorie_article_Libelle($recherche); break;
            default: return 0;
        }
    }

    public function mf_get_next_id(): int
    {
        $res_requete = executer_requete_mysql('SELECT AUTO_INCREMENT as next_id FROM INFORMATION_SCHEMA.TABLES WHERE table_name = \'' . inst('categorie_article') . '\';', false);
        $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC);
        mysqli_free_result($res_requete);
        return intval($row_requete['next_id']);
    }

    public function mf_search(array $ligne): int // array('colonne1' => 'valeur1',  [...] )
    {
        global $mf_initialisation;
        $categorie_article_Libelle = (isset($ligne['categorie_article_Libelle']) ? $ligne['categorie_article_Libelle'] : $mf_initialisation['categorie_article_Libelle']);
        // Typage
        $categorie_article_Libelle = (string) $categorie_article_Libelle;
        // Fin typage
        Hook_categorie_article::pre_controller($categorie_article_Libelle);
        $mf_cle_unique = Hook_categorie_article::calcul_cle_unique($categorie_article_Libelle);
        $res_requete = executer_requete_mysql('SELECT Code_categorie_article FROM ' . inst('categorie_article') . ' WHERE mf_cle_unique = \'' . $mf_cle_unique . '\'', false);
        if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
            $r = intval($row_requete['Code_categorie_article']);
        } else {
            $r = 0;
        }
        mysqli_free_result($res_requete);
        return $r;
    }
}
