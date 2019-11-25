<?php

/*
    +------------------------------+
    |  NE PAS MODIFIER CE FICHIER  |
    +------------------------------+
*/

class a_article_commande_monframework extends entite_monframework
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
            include_once __DIR__ . '/../../erreurs/erreurs__a_article_commande.php';
            self::$initialisation = false;
            Hook_a_article_commande::initialisation();
            self::$cache_db = new Mf_Cachedb('a_article_commande');
        }
        if (!self::$actualisation_en_cours)
        {
            self::$actualisation_en_cours=true;
            Hook_a_article_commande::actualisation();
            self::$actualisation_en_cours=false;
        }
    }

    static function mf_raz_instance()
    {
        self::$initialisation = true;
    }

    static function initialiser_structure()
    {
        if (! test_si_table_existe(inst('a_article_commande'))) {
            executer_requete_mysql('CREATE TABLE '.inst('a_article_commande').' (Code_commande INT NOT NULL, Code_article INT NOT NULL, PRIMARY KEY (Code_commande, Code_article)) ENGINE=MyISAM;', array_search('a_article_commande', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        $liste_colonnes = lister_les_colonnes(inst('a_article_commande'));

        unset($liste_colonnes['Code_commande']);
        unset($liste_colonnes['Code_article']);

        foreach ($liste_colonnes as $field => $value) {
            executer_requete_mysql('ALTER TABLE '.inst('a_article_commande').' DROP COLUMN '.$field.';', array_search('a_article_commande', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

    }

    public function mfi_ajouter_auto(array $interface)
    {
        if (isset($interface['Code_commande'])) {
            $liste_Code_commande = array($interface['Code_commande']);
            $liste_Code_commande = $this->__get_liste_Code_commande([OPTION_COND_MYSQL=>['Code_commande IN ' . Sql_Format_Liste($liste_Code_commande)]]);
        } elseif (isset($interface['liste_Code_commande'])) {
            $liste_Code_commande = $interface['liste_Code_commande'];
            $liste_Code_commande = $this->__get_liste_Code_commande([OPTION_COND_MYSQL=>['Code_commande IN ' . Sql_Format_Liste($liste_Code_commande)]]);
        } else {
            $liste_Code_commande = $this->get_liste_Code_commande();
        }
        if (isset($interface['Code_article'])) {
            $liste_Code_article = array($interface['Code_article']);
            $liste_Code_article = $this->__get_liste_Code_article([OPTION_COND_MYSQL=>['Code_article IN ' . Sql_Format_Liste($liste_Code_article)]]);
        } elseif (isset($interface['liste_Code_article'])) {
            $liste_Code_article = $interface['liste_Code_article'];
            $liste_Code_article = $this->__get_liste_Code_article([OPTION_COND_MYSQL=>['Code_article IN ' . Sql_Format_Liste($liste_Code_article)]]);
        } else {
            $liste_Code_article = $this->get_liste_Code_article();
        }
        $mf_index = [];
        $res_requete = executer_requete_mysql('SELECT Code_commande, Code_article FROM ' . inst('a_article_commande') . ' WHERE Code_commande IN ' . Sql_Format_Liste($liste_Code_commande) . ' AND Code_article IN ' . Sql_Format_Liste($liste_Code_article) . ';', false);
        while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
            $mf_index[(int) $row_requete['Code_commande']][(int) $row_requete['Code_article']] = 1;
        }
        mysqli_free_result($res_requete);
        $liste_a_article_commande = array();
        foreach ($liste_Code_commande as $Code_commande) {
            foreach ($liste_Code_article as $Code_article) {
                if (! isset($mf_index[$Code_commande][$Code_article])) {
                    $liste_a_article_commande[] = array('Code_commande'=>$Code_commande,'Code_article'=>$Code_article);
                }
            }
        }
        return $this->mf_ajouter_3($liste_a_article_commande);
    }

    public function mfi_supprimer_auto(array $interface)
    {
        if (isset($interface['Code_commande'])) {
            $liste_Code_commande = array($interface['Code_commande']);
        } elseif (isset($interface['liste_Code_commande'])) {
            $liste_Code_commande = $interface['liste_Code_commande'];
        } else {
            $liste_Code_commande = $this->get_liste_Code_commande();
        }
        if (isset($interface['Code_article'])) {
            $liste_Code_article = array($interface['Code_article']);
        } elseif (isset($interface['liste_Code_article'])) {
            $liste_Code_article = $interface['liste_Code_article'];
        } else {
            $liste_Code_article = $this->get_liste_Code_article();
        }
        $mf_index = [];
        $res_requete = executer_requete_mysql('SELECT Code_commande, Code_article FROM ' . inst('a_article_commande') . ' WHERE Code_commande IN ' . Sql_Format_Liste($liste_Code_commande) . ' AND Code_article IN ' . Sql_Format_Liste($liste_Code_article) . ';', false);
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

    public function mf_ajouter(int $Code_commande, int $Code_article, ?bool $force = null)
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        $Code_commande = round($Code_commande);
        $Code_article = round($Code_article);
        Hook_a_article_commande::pre_controller($Code_commande, $Code_article, true);
        if (! $force) {
            if (!self::$maj_droits_ajouter_en_cours)
            {
                self::$maj_droits_ajouter_en_cours = true;
                Hook_a_article_commande::hook_actualiser_les_droits_ajouter($Code_commande, $Code_article);
                self::$maj_droits_ajouter_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['a_article_commande__AJOUTER']) ) $code_erreur = REFUS_A_ARTICLE_COMMANDE__AJOUTER;
        elseif ( !$this->mf_tester_existance_Code_commande($Code_commande) ) $code_erreur = ERR_A_ARTICLE_COMMANDE__AJOUTER__CODE_COMMANDE_INEXISTANT;
        elseif ( !$this->mf_tester_existance_Code_article($Code_article) ) $code_erreur = ERR_A_ARTICLE_COMMANDE__AJOUTER__CODE_ARTICLE_INEXISTANT;
        elseif ( $this->mf_tester_existance_a_article_commande( $Code_commande, $Code_article ) ) $code_erreur = ERR_A_ARTICLE_COMMANDE__AJOUTER__DOUBLON;
        elseif (CONTROLE_ACCES_DONNEES_DEFAUT && ! Hook_mf_systeme::controle_acces_donnees('Code_commande', $Code_commande)) $code_erreur = ACCES_CODE_COMMANDE_REFUSE;
        elseif (CONTROLE_ACCES_DONNEES_DEFAUT && ! Hook_mf_systeme::controle_acces_donnees('Code_article', $Code_article)) $code_erreur = ACCES_CODE_ARTICLE_REFUSE;
        elseif ( !Hook_a_article_commande::autorisation_ajout($Code_commande, $Code_article) ) $code_erreur = REFUS_A_ARTICLE_COMMANDE__AJOUT_BLOQUEE;
        else
        {
            Hook_a_article_commande::data_controller($Code_commande, $Code_article, true);
            $requete = 'INSERT INTO '.inst('a_article_commande')." ( Code_commande, Code_article ) VALUES ( $Code_commande, $Code_article );";
            executer_requete_mysql($requete, array_search('a_article_commande', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            $n = requete_mysqli_affected_rows();
            if ($n == 0) {
                $code_erreur = ERR_A_ARTICLE_COMMANDE__AJOUTER__REFUSE;
            } else {
                self::$cache_db->clear();
                Hook_a_article_commande::ajouter($Code_commande, $Code_article);
            }
        }
        if ($code_erreur != 0) {
            global $mf_message_erreur_personalise, $mf_libelle_erreur;
            if ($mf_message_erreur_personalise != '') {
                $mf_libelle_erreur[$code_erreur] = $mf_message_erreur_personalise;
                $mf_message_erreur_personalise = '';
            }
        }
        return array('code_erreur' => $code_erreur, 'callback' => ( $code_erreur==0 ? Hook_a_article_commande::callback_post($Code_commande, $Code_article) : null ));
    }

    public function mf_ajouter_2(array $ligne, ?bool $force = null) // array('colonne1' => 'valeur1',  [...] )
    {
        if ($force === null) {
            $force = false;
        }
        global $mf_initialisation;
        $Code_commande = (int)(isset($ligne['Code_commande'])?round($ligne['Code_commande']):0);
        $Code_article = (int)(isset($ligne['Code_article'])?round($ligne['Code_article']):0);
        return $this->mf_ajouter($Code_commande, $Code_article, $force);
    }

    public function mf_ajouter_3(array $lignes) // array( array( 'colonne1' => 'valeur1', 'colonne2' => 'valeur2',  [...] ), [...] )
    {
        global $mf_initialisation;
        $code_erreur = 0;
        $values = '';
        foreach ($lignes as $ligne) {
            $Code_commande = (isset($ligne['Code_commande'])?round($ligne['Code_commande']):0);
            $Code_article = (isset($ligne['Code_article'])?round($ligne['Code_article']):0);
            if ($Code_commande != 0) {
                if ($Code_article != 0) {
                    $values .= ($values!='' ? ',' : '')."($Code_commande, $Code_article)";
                }
            }
        }
        if ($values != '') {
            $requete = "INSERT INTO ".inst('a_article_commande')." ( Code_commande, Code_article ) VALUES $values;";
            executer_requete_mysql($requete, array_search('a_article_commande', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            $n = requete_mysqli_affected_rows();
            if ($n < count($lignes)) {
                $code_erreur = ERR_A_ARTICLE_COMMANDE__AJOUTER_3__ECHEC_AJOUT;
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
        return array('code_erreur' => $code_erreur);
    }

    public function mf_supprimer(?int $Code_commande = null, ?int $Code_article = null, ?bool $force = null)
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        $Code_commande = round($Code_commande);
        $Code_article = round($Code_article);
        $copie__liste_a_article_commande = $this->mf_lister($Code_commande, $Code_article, array('autocompletion' => false));
        $liste_Code_commande = array();
        $liste_Code_article = array();
        foreach ( $copie__liste_a_article_commande as $copie__a_article_commande )
        {
            $Code_commande = $copie__a_article_commande['Code_commande'];
            $Code_article = $copie__a_article_commande['Code_article'];
            if (!$force)
            {
                if (!self::$maj_droits_supprimer_en_cours)
                {
                    self::$maj_droits_supprimer_en_cours = true;
                    Hook_a_article_commande::hook_actualiser_les_droits_supprimer($Code_commande, $Code_article);
                    self::$maj_droits_supprimer_en_cours = false;
                }
            }
            if ( !$force && !mf_matrice_droits(['a_article_commande__SUPPRIMER']) ) $code_erreur = REFUS_A_ARTICLE_COMMANDE__SUPPRIMER;
            elseif ( !Hook_a_article_commande::autorisation_suppression($Code_commande, $Code_article) ) $code_erreur = REFUS_A_ARTICLE_COMMANDE__SUPPRESSION_BLOQUEE;
            {
                $liste_Code_commande[] = $Code_commande;
                $liste_Code_article[] = $Code_article;
            }
        }
        if ($code_erreur == 0 && count($liste_Code_commande)>0 && count($liste_Code_article)>0) {
            $requete = 'DELETE IGNORE FROM ' . inst('a_article_commande') . " WHERE Code_commande IN ".Sql_Format_Liste($liste_Code_commande)." AND Code_article IN ".Sql_Format_Liste($liste_Code_article).";";
            executer_requete_mysql( $requete , array_search('a_article_commande', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            if (requete_mysqli_affected_rows() == 0) {
                $code_erreur = ERR_A_ARTICLE_COMMANDE__SUPPRIMER__REFUSE;
            } else {
                self::$cache_db->clear();
                Hook_a_article_commande::supprimer($copie__liste_a_article_commande);
            }
        }
        if ($code_erreur != 0) {
            global $mf_message_erreur_personalise, $mf_libelle_erreur;
            if ($mf_message_erreur_personalise != '') {
                $mf_libelle_erreur[$code_erreur] = $mf_message_erreur_personalise;
                $mf_message_erreur_personalise = '';
            }
        }
        return array('code_erreur' => $code_erreur);
    }

    public function mf_supprimer_2(?int $Code_commande = null, ?int $Code_article = null)
    {
        $code_erreur = 0;
        $Code_commande = round($Code_commande);
        $Code_article = round($Code_article);
        $copie__liste_a_article_commande = $this->mf_lister_2($Code_commande, $Code_article, array('autocompletion' => false));
        $requete = 'DELETE IGNORE FROM ' . inst('a_article_commande') . " WHERE 1".( $Code_commande!=0 ? " AND Code_commande=$Code_commande" : "" )."".( $Code_article!=0 ? " AND Code_article=$Code_article" : "" ).";";
        executer_requete_mysql( $requete , array_search('a_article_commande', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        if ( requete_mysqli_affected_rows()==0 )
        {
            $code_erreur = ERR_A_ARTICLE_COMMANDE__SUPPRIMER_2__REFUSE;
        } else {
            self::$cache_db->clear();
            Hook_a_article_commande::supprimer($copie__liste_a_article_commande);
        }
        if ($code_erreur != 0) {
            global $mf_message_erreur_personalise, $mf_libelle_erreur;
            if ($mf_message_erreur_personalise != '') {
                $mf_libelle_erreur[$code_erreur] = $mf_message_erreur_personalise;
                $mf_message_erreur_personalise = '';
            }
        }
        return array('code_erreur' => $code_erreur);
    }

    public function mf_lister_contexte(?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        global $mf_contexte, $est_charge;
        return $this->mf_lister(isset($est_charge['commande']) ? $mf_contexte['Code_commande'] : 0, isset($est_charge['article']) ? $mf_contexte['Code_article'] : 0, $options);
    }

    public function mf_lister(?int $Code_commande = null, ?int $Code_article = null, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
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

    public function mf_lister_2(?int $Code_commande = null, ?int $Code_article = null, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cle = 'a_article_commande__lister';
        $Code_commande = round($Code_commande);
        $cle .= "_{$Code_commande}";
        $Code_article = round($Code_article);
        $cle .= "_{$Code_article}";

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql'])) {
            foreach ($options['cond_mysql'] as &$condition) {
                $argument_cond .= ' AND (' . $condition . ')';
            }
            unset($condition);
        }
        $cle .= '_' . $argument_cond;

        // tris
        $argument_tris = '';
        if ( ! isset($options['tris']) )
        {
            $options['tris']=array();
        }
        if ( count($options['tris'])==0 )
        {
            global $mf_tri_defaut_table;
            if ( isset($mf_tri_defaut_table['a_article_commande']) )
            {
                $options['tris'] = $mf_tri_defaut_table['a_article_commande'];
            }
        }
        foreach ($options['tris'] as $colonne => $tri)
        {
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

        // afficher toutes les colonnes
        $toutes_colonnes = TOUTES_COLONNES_DEFAUT;
        if (isset($options['toutes_colonnes'])) {
            $toutes_colonnes = ( $options['toutes_colonnes']==true );
        }
        $cle .= '_'.( $toutes_colonnes ? '1' : '0' );

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
            }
            if (isset($options['tris'])) {
            }
            if (count($liste_colonnes_a_indexer) > 0) {
                if (false === $mf_liste_requete_index = self::$cache_db->read('a_article_commande__index')) {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('a_article_commande').'`;', false);
                    $mf_liste_requete_index = array();
                    while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    self::$cache_db->write('a_article_commande__index', $mf_liste_requete_index);
                }
                foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if (count($liste_colonnes_a_indexer) > 0) {
                    foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                        executer_requete_mysql('ALTER TABLE `'.inst('a_article_commande').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    self::$cache_db->clear();
                }
            }

            $liste = array();
            if ($toutes_colonnes) {
                $colonnes='Code_commande, Code_article';
            } else {
                $colonnes='Code_commande, Code_article';
            }
            $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM '.inst('a_article_commande')." WHERE 1{$argument_cond}".( $Code_commande!=0 ? " AND Code_commande=$Code_commande" : "" )."".( $Code_article!=0 ? " AND Code_article=$Code_article" : "" )."{$argument_tris}{$argument_limit};", false);
            while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                mf_formatage_db_type_php($row_requete);
                $liste[$row_requete['Code_commande'].'-'.$row_requete['Code_article']] = $row_requete;
            }
            mysqli_free_result($res_requete);
            if (count($options['tris'])==1)
            {
                foreach ($options['tris'] as $colonne => $tri)
                {
                    global $lang_standard;
                    if (isset($lang_standard[$colonne.'_']))
                    {
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
                Hook_a_article_commande::completion($element, self::$auto_completion - 1);
                self::$auto_completion --;
            }
        }
        unset($element);
        return $liste;
    }

    public function mf_lister_3(?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        return $this->mf_lister(null, null, $options);
    }

    public function mf_get(int $Code_commande, int $Code_article, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cle = "a_article_commande__get";
        $Code_commande = round($Code_commande);
        $cle .= "_{$Code_commande}";
        $Code_article = round($Code_article);
        $cle .= "_{$Code_article}";
        $retour = array();
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
                    $colonnes='Code_commande, Code_article';
                } else {
                    $colonnes='Code_commande, Code_article';
                }
                $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM ' . inst('a_article_commande')." WHERE Code_commande=$Code_commande AND Code_article=$Code_article;", false);
                if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                    mf_formatage_db_type_php($row_requete);
                    $retour = $row_requete;
                } else {
                    $retour = array();
                }
                mysqli_free_result($res_requete);
                self::$cache_db->write($cle, $retour);
            }
            if (isset($retour['Code_commande'])) {
                if (($autocompletion_recursive || self::$auto_completion < 1) && $autocompletion) {
                    self::$auto_completion ++;
                    Hook_a_article_commande::completion($retour, self::$auto_completion - 1);
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
        $cle = "a_article_commande__get";
        $Code_commande = round($Code_commande);
        $cle .= "_{$Code_commande}";
        $Code_article = round($Code_article);
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
                $colonnes='Code_commande, Code_article';
            } else {
                $colonnes='Code_commande, Code_article';
            }
            $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM ' . inst('a_article_commande')." WHERE Code_commande=$Code_commande AND Code_article=$Code_article;", false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                mf_formatage_db_type_php($row_requete);
                $retour = $row_requete;
            } else {
                $retour = array();
            }
            mysqli_free_result($res_requete);
            self::$cache_db->write($cle, $retour);
        }
        if (isset($retour['Code_commande'])) {
            if (($autocompletion_recursive || self::$auto_completion < 1) && $autocompletion) {
                self::$auto_completion ++;
                Hook_a_article_commande::completion($retour, self::$auto_completion - 1);
                self::$auto_completion --;
            }
        }
        return $retour;
    }

    public function mf_compter(?int $Code_commande = null, ?int $Code_article = null, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cle = 'a_article_commande__compter';
        $Code_commande = round($Code_commande);
        $cle .= '_{'.$Code_commande.'}';
        $Code_article = round($Code_article);
        $cle .= '_{'.$Code_article.'}';

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql'])) {
            foreach ($options['cond_mysql'] as &$condition) {
                $argument_cond .= ' AND (' . $condition . ')';
            }
            unset($condition);
        }
        $cle .= '_' . $argument_cond;

        if (false === $nb = self::$cache_db->read($cle)) {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ($argument_cond != '') {
            }
            if (count($liste_colonnes_a_indexer) > 0) {
                if (false === $mf_liste_requete_index = self::$cache_db->read('a_article_commande__index')) {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('a_article_commande').'`;', false);
                    $mf_liste_requete_index = array();
                    while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    self::$cache_db->write('a_article_commande__index', $mf_liste_requete_index);
                }
                foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if (count($liste_colonnes_a_indexer) > 0) {
                    foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                        executer_requete_mysql('ALTER TABLE `'.inst('a_article_commande').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    self::$cache_db->clear();
                }
            }

            $res_requete = executer_requete_mysql("SELECT COUNT(CONCAT(Code_commande,'|',Code_article)) as nb FROM ".inst('a_article_commande')." WHERE 1{$argument_cond}".( $Code_commande!=0 ? " AND Code_commande=$Code_commande" : "" )."".( $Code_article!=0 ? " AND Code_article=$Code_article" : "" ).";", false);
            $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC);
            mysqli_free_result($res_requete);
            $nb = (int) $row_requete['nb'];
            self::$cache_db->write($cle, $nb);
        }
        return $nb;
    }

    public function mf_liste_Code_commande_vers_liste_Code_article( array $liste_Code_commande, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ($options === null) {
            $options=[];
        }
        return $this->a_article_commande_liste_Code_commande_vers_liste_Code_article( $liste_Code_commande , $options );
    }

    public function mf_liste_Code_article_vers_liste_Code_commande( array $liste_Code_article, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ($options === null) {
            $options=[];
        }
        return $this->a_article_commande_liste_Code_article_vers_liste_Code_commande( $liste_Code_article , $options );
    }
}
