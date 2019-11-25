<?php

/*
    +------------------------------+
    |  NE PAS MODIFIER CE FICHIER  |
    +------------------------------+
*/

class type_produit_monframework extends entite_monframework
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
        if (self::$initialisation)
        {
            include_once __DIR__ . '/../../erreurs/erreurs__type_produit.php';
            self::$initialisation = false;
            Hook_type_produit::initialisation();
            self::$cache_db = new Mf_Cachedb('type_produit');
        }
        if (!self::$actualisation_en_cours)
        {
            self::$actualisation_en_cours=true;
            Hook_type_produit::actualisation();
            self::$actualisation_en_cours=false;
        }
    }

    static function mf_raz_instance()
    {
        self::$initialisation = true;
    }

    static function initialiser_structure()
    {
        global $mf_initialisation;

        if ( ! test_si_table_existe(inst('type_produit')) )
        {
            executer_requete_mysql('CREATE TABLE '.inst('type_produit').'(Code_type_produit INT AUTO_INCREMENT NOT NULL, PRIMARY KEY (Code_type_produit)) ENGINE=MyISAM;', array_search('type_produit', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        $liste_colonnes = lister_les_colonnes(inst('type_produit'));

        if ( isset($liste_colonnes['type_produit_Libelle']) )
        {
            if ( typeMyql2Sql($liste_colonnes['type_produit_Libelle']['Type'])!='VARCHAR' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('type_produit').' CHANGE type_produit_Libelle type_produit_Libelle VARCHAR(255);', array_search('type_produit', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['type_produit_Libelle']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('type_produit').' ADD type_produit_Libelle VARCHAR(255);', array_search('type_produit', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE '.inst('type_produit').' SET type_produit_Libelle=' . format_sql('type_produit_Libelle', $mf_initialisation['type_produit_Libelle']) . ';', array_search('type_produit', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if ( isset($liste_colonnes['mf_signature']) )
        {
            unset($liste_colonnes['mf_signature']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('type_produit').' ADD mf_signature VARCHAR(255);', array_search('type_produit', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('ALTER TABLE '.inst('type_produit').' ADD INDEX( mf_signature );', array_search('type_produit', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if ( isset($liste_colonnes['mf_cle_unique']) )
        {
            unset($liste_colonnes['mf_cle_unique']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('type_produit').' ADD mf_cle_unique VARCHAR(255);', array_search('type_produit', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('ALTER TABLE '.inst('type_produit').' ADD INDEX( mf_cle_unique );', array_search('type_produit', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if ( isset($liste_colonnes['mf_date_creation']) )
        {
            unset($liste_colonnes['mf_date_creation']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('type_produit').' ADD mf_date_creation DATETIME;', array_search('type_produit', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('ALTER TABLE '.inst('type_produit').' ADD INDEX( mf_date_creation );', array_search('type_produit', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if ( isset($liste_colonnes['mf_date_modification']) )
        {
            unset($liste_colonnes['mf_date_modification']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('type_produit').' ADD mf_date_modification DATETIME;', array_search('type_produit', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('ALTER TABLE '.inst('type_produit').' ADD INDEX( mf_date_modification );', array_search('type_produit', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        unset($liste_colonnes['Code_type_produit']);

        foreach ($liste_colonnes as $field => $value)
        {
            executer_requete_mysql('ALTER TABLE '.inst('type_produit').' DROP COLUMN '.$field.';', array_search('type_produit', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

    }

    public function mf_ajouter(string $type_produit_Libelle, ?bool $force = false)
    {
        if ($force === null) {
            $force = false;
        }
        $Code_type_produit = 0;
        $code_erreur = 0;
        Hook_type_produit::pre_controller($type_produit_Libelle);
        if (!$force)
        {
            if (!self::$maj_droits_ajouter_en_cours)
            {
                self::$maj_droits_ajouter_en_cours = true;
                Hook_type_produit::hook_actualiser_les_droits_ajouter();
                self::$maj_droits_ajouter_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['type_produit__AJOUTER']) ) $code_erreur = REFUS_TYPE_PRODUIT__AJOUTER;
        elseif ( !Hook_type_produit::autorisation_ajout($type_produit_Libelle) ) $code_erreur = REFUS_TYPE_PRODUIT__AJOUT_BLOQUEE;
        else
        {
            Hook_type_produit::data_controller($type_produit_Libelle);
            $mf_signature = text_sql(Hook_type_produit::calcul_signature($type_produit_Libelle));
            $mf_cle_unique = text_sql(Hook_type_produit::calcul_cle_unique($type_produit_Libelle));
            $type_produit_Libelle = text_sql($type_produit_Libelle);
            $requete = "INSERT INTO ".inst('type_produit')." ( mf_signature, mf_cle_unique, mf_date_creation, mf_date_modification, type_produit_Libelle ) VALUES ( '$mf_signature', '$mf_cle_unique', '".get_now()."', '".get_now()."', '$type_produit_Libelle' );";
            executer_requete_mysql($requete, array_search('type_produit', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            $Code_type_produit = requete_mysql_insert_id();
            if ($Code_type_produit==0)
            {
                $code_erreur = ERR_TYPE_PRODUIT__AJOUTER__AJOUT_REFUSE;
            } else {
                self::$cache_db->clear();
                Hook_type_produit::ajouter( $Code_type_produit );
            }
        }
        if ($code_erreur != 0) {
            global $mf_message_erreur_personalise, $mf_libelle_erreur;
            if ($mf_message_erreur_personalise != '') {
                $mf_libelle_erreur[$code_erreur] = $mf_message_erreur_personalise;
                $mf_message_erreur_personalise = '';
            }
        }
        return array('code_erreur' => $code_erreur, 'Code_type_produit' => $Code_type_produit, 'callback' => ( $code_erreur==0 ? Hook_type_produit::callback_post($Code_type_produit) : null ));
    }

    public function mf_creer(?bool $force = null)
    {
        if ($force === null) {
            $force = false;
        }
        global $mf_initialisation;
        $type_produit_Libelle = $mf_initialisation['type_produit_Libelle'];
        return $this->mf_ajouter($type_produit_Libelle, $force);
    }

    public function mf_ajouter_2(array $ligne, bool $force = null) // array('colonne1' => 'valeur1',  [...] )
    {
        if ($force === null) {
            $force = false;
        }
        global $mf_initialisation;
        $type_produit_Libelle = (string)(isset($ligne['type_produit_Libelle'])?$ligne['type_produit_Libelle']:$mf_initialisation['type_produit_Libelle']);
        return $this->mf_ajouter($type_produit_Libelle, $force);
    }

    public function mf_ajouter_3(array $lignes) // array( array( 'colonne1' => 'valeur1', 'colonne2' => 'valeur2',  [...] ), [...] )
    {
        global $mf_initialisation;
        $code_erreur = 0;
        $values = '';
        foreach ($lignes as $ligne)
        {
            $type_produit_Libelle = text_sql(isset($ligne['type_produit_Libelle'])?$ligne['type_produit_Libelle']:$mf_initialisation['type_produit_Libelle']);
            $values .= ($values!="" ? "," : "")."('$type_produit_Libelle')";
        }
        if ($values!='')
        {
            $requete = "INSERT INTO ".inst('type_produit')." ( type_produit_Libelle ) VALUES $values;";
            executer_requete_mysql( $requete , array_search('type_produit', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            $n = requete_mysqli_affected_rows();
            if ($n < count($lignes))
            {
                $code_erreur = ERR_TYPE_PRODUIT__AJOUTER_3__ECHEC_AJOUT;
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

    public function mf_actualiser_signature(int $Code_type_produit)
    {
        $type_produit = $this->mf_get_2($Code_type_produit, array('autocompletion' => false));
        $mf_signature = text_sql(Hook_type_produit::calcul_signature($type_produit['type_produit_Libelle']));
        $mf_cle_unique = text_sql(Hook_type_produit::calcul_cle_unique($type_produit['type_produit_Libelle']));
        $table = inst('type_produit');
        executer_requete_mysql("UPDATE $table SET mf_signature='$mf_signature', mf_cle_unique='$mf_cle_unique' WHERE Code_type_produit=$Code_type_produit;", array_search('type_produit', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        if (requete_mysqli_affected_rows() == 1) {
            self::$cache_db->clear();
        }
    }

    public function mf_modifier( int $Code_type_produit, string $type_produit_Libelle, ?bool $force = null)
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        $Code_type_produit = round($Code_type_produit);
        Hook_type_produit::pre_controller($type_produit_Libelle, $Code_type_produit);
        if (!$force)
        {
            if (!self::$maj_droits_modifier_en_cours)
            {
                self::$maj_droits_modifier_en_cours = true;
                Hook_type_produit::hook_actualiser_les_droits_modifier($Code_type_produit);
                self::$maj_droits_modifier_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['type_produit__MODIFIER']) ) $code_erreur = REFUS_TYPE_PRODUIT__MODIFIER;
        elseif ( !$this->mf_tester_existance_Code_type_produit($Code_type_produit) ) $code_erreur = ERR_TYPE_PRODUIT__MODIFIER__CODE_TYPE_PRODUIT_INEXISTANT;
        elseif (CONTROLE_ACCES_DONNEES_DEFAUT && ! Hook_mf_systeme::controle_acces_donnees('Code_type_produit', $Code_type_produit)) $code_erreur = ACCES_CODE_TYPE_PRODUIT_REFUSE;
        elseif ( !Hook_type_produit::autorisation_modification($Code_type_produit, $type_produit_Libelle) ) $code_erreur = REFUS_TYPE_PRODUIT__MODIFICATION_BLOQUEE;
        else
        {
            if (! isset(self::$lock[$Code_type_produit])) {
                self::$lock[$Code_type_produit] = 0;
            }
            if (self::$lock[$Code_type_produit] == 0) {
                self::$cache_db->add_lock($Code_type_produit);
            }
            self::$lock[$Code_type_produit]++;
            Hook_type_produit::data_controller($type_produit_Libelle, $Code_type_produit);
            $type_produit = $this->mf_get_2( $Code_type_produit, array('autocompletion' => false, 'masquer_mdp' => false) );
            $mf_colonnes_a_modifier=[];
            $bool__type_produit_Libelle = false; if ( $type_produit_Libelle!=$type_produit['type_produit_Libelle'] ) { Hook_type_produit::data_controller__type_produit_Libelle($type_produit['type_produit_Libelle'], $type_produit_Libelle, $Code_type_produit); if ( $type_produit_Libelle!=$type_produit['type_produit_Libelle'] ) { $mf_colonnes_a_modifier[] = 'type_produit_Libelle=' . format_sql('type_produit_Libelle', $type_produit_Libelle); $bool__type_produit_Libelle = true; } }
            if (count($mf_colonnes_a_modifier) > 0) {
                $mf_signature = text_sql(Hook_type_produit::calcul_signature($type_produit_Libelle));
                $mf_cle_unique = text_sql(Hook_type_produit::calcul_cle_unique($type_produit_Libelle));
                $mf_colonnes_a_modifier[] = 'mf_signature=\'' . $mf_signature . '\'';
                $mf_colonnes_a_modifier[] = 'mf_cle_unique=\'' . $mf_cle_unique . '\'';
                $mf_colonnes_a_modifier[] = 'mf_date_modification=\'' . get_now() . '\'';
                $requete = 'UPDATE '.inst('type_produit').' SET ' . enumeration($mf_colonnes_a_modifier) . ' WHERE Code_type_produit = ' . $Code_type_produit . ';';
                executer_requete_mysql($requete, array_search('type_produit', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
                if (requete_mysqli_affected_rows() == 0) {
                    $code_erreur = ERR_TYPE_PRODUIT__MODIFIER__AUCUN_CHANGEMENT;
                } else {
                    self::$cache_db->clear();
                    Hook_type_produit::modifier($Code_type_produit, $bool__type_produit_Libelle);
                }
            } else {
                $code_erreur = ERR_TYPE_PRODUIT__MODIFIER__AUCUN_CHANGEMENT;
            }
            self::$lock[$Code_type_produit]--;
            if (self::$lock[$Code_type_produit] == 0) {
                self::$cache_db->release_lock($Code_type_produit);
                unset(self::$lock[$Code_type_produit]);
            }
        }
        if ($code_erreur != 0) {
            global $mf_message_erreur_personalise, $mf_libelle_erreur;
            if ($mf_message_erreur_personalise != '') {
                $mf_libelle_erreur[$code_erreur] = $mf_message_erreur_personalise;
                $mf_message_erreur_personalise = '';
            }
        }
        return array('code_erreur' => $code_erreur, 'callback' => ( $code_erreur == 0 ? Hook_type_produit::callback_put($Code_type_produit) : null ));
    }

    public function mf_modifier_2(array $lignes, ?bool $force = null) // array( $Code_type_produit => array('colonne1' => 'valeur1',  [...] ) )
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        foreach ( $lignes as $Code_type_produit => $colonnes )
        {
            if ( $code_erreur==0 )
            {
                $Code_type_produit = (int) round($Code_type_produit);
                $type_produit = $this->mf_get_2($Code_type_produit, array('autocompletion' => false));
                if (!$force)
                {
                    if (!self::$maj_droits_modifier_en_cours)
                    {
                        self::$maj_droits_modifier_en_cours = true;
                        Hook_type_produit::hook_actualiser_les_droits_modifier($Code_type_produit);
                        self::$maj_droits_modifier_en_cours = false;
                    }
                }
                $type_produit_Libelle = (string) ( isset($colonnes['type_produit_Libelle']) && ( $force || mf_matrice_droits(['api_modifier__type_produit_Libelle', 'type_produit__MODIFIER']) ) ? $colonnes['type_produit_Libelle'] : ( isset($type_produit['type_produit_Libelle']) ? $type_produit['type_produit_Libelle'] : '' ) );
                $retour = $this->mf_modifier($Code_type_produit, $type_produit_Libelle, true);
                if ($retour['code_erreur'] != 0 && $retour['code_erreur'] != ERR_TYPE_PRODUIT__MODIFIER__AUCUN_CHANGEMENT) {
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
        return array('code_erreur' => $code_erreur);
    }

    public function mf_modifier_3(array $lignes) // array( $Code_type_produit => array('colonne1' => 'valeur1',  [...] ) )
    {
        $code_erreur = 0;
        $modifs = false;

        // transformation des lignes en colonnes
        $valeurs_en_colonnes=array();
        $indices_par_colonne=array();
        $liste_valeurs_indexees=array();
        foreach ( $lignes as $Code_type_produit => $colonnes )
        {
            foreach ($colonnes as $colonne => $valeur)
            {
                if ( $colonne=='type_produit_Libelle' )
                {
                    $valeurs_en_colonnes[$colonne][$Code_type_produit]=$valeur;
                    $indices_par_colonne[$colonne][]=$Code_type_produit;
                    $liste_valeurs_indexees[$colonne][''.$valeur][]=$Code_type_produit;
                }
            }
        }

        // fabrication des requetes
        foreach ( $valeurs_en_colonnes as $colonne => $valeurs )
        {
            if ( count($liste_valeurs_indexees[$colonne]) > 3 )
            {
                $modification_sql = $colonne . ' = CASE Code_type_produit';
                foreach ( $valeurs as $Code_type_produit => $valeur )
                {
                    $modification_sql .= ' WHEN ' . $Code_type_produit . ' THEN ' . format_sql($colonne, $valeur);
                }
                $modification_sql .= ' END';
                $perimetre = Sql_Format_Liste($indices_par_colonne[$colonne]);
                executer_requete_mysql('UPDATE ' . inst('type_produit') . ' SET ' . $modification_sql . ' WHERE Code_type_produit IN ' . $perimetre . ';', array_search('type_produit', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
                if ( requete_mysqli_affected_rows()!=0 )
                {
                    $modifs = true;
                }
            }
            else
            {
                foreach ( $liste_valeurs_indexees[$colonne] as $valeur => $indices_par_valeur )
                {
                    $perimetre = Sql_Format_Liste($indices_par_valeur);
                    executer_requete_mysql('UPDATE ' . inst('type_produit') . ' SET ' . $colonne . ' = ' . format_sql($colonne, $valeur) . ' WHERE Code_type_produit IN ' . $perimetre . ';', array_search('type_produit', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
                    if ( requete_mysqli_affected_rows()!=0 )
                    {
                        $modifs = true;
                    }
                }
            }
        }

        if ( ! $modifs && $code_erreur==0 )
        {
            $code_erreur = ERR_TYPE_PRODUIT__MODIFIER_3__AUCUN_CHANGEMENT;
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
        return array('code_erreur' => $code_erreur);
    }

    public function mf_modifier_4( array $data, ?array $options = null /* $options = array( 'cond_mysql' => array(), 'limit' => 0 ) */ ) // $data = array('colonne1' => 'valeur1', ... )
    {
        if ($options === null) {
            $force = [];
        }
        $code_erreur = 0;
        $mf_colonnes_a_modifier=[];
        if ( isset($data['type_produit_Libelle']) ) { $mf_colonnes_a_modifier[] = 'type_produit_Libelle = ' . format_sql('type_produit_Libelle', $data['type_produit_Libelle']); }
        if ( count($mf_colonnes_a_modifier)>0 )
        {
            // cond_mysql
            $argument_cond = '';
            if (isset($options['cond_mysql']))
            {
                foreach ($options['cond_mysql'] as &$condition)
                {
                    $argument_cond .= ' AND ('.$condition.')';
                }
                unset($condition);
            }

            // limit
            $limit = 0;
            if (isset($options['limit']))
            {
                $limit = round($options['limit']);
            }

            $requete = 'UPDATE ' . inst('type_produit') . ' SET ' . enumeration($mf_colonnes_a_modifier) . " WHERE 1$argument_cond" . ( $limit>0 ? ' LIMIT ' . $limit : '' ) . ";";
            executer_requete_mysql( $requete , array_search('type_produit', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_TYPE_PRODUIT__MODIFIER_4__AUCUN_CHANGEMENT;
            } else {
                self::$cache_db->clear();
            }
        }
        return array('code_erreur' => $code_erreur);
    }

    public function mf_supprimer(int $Code_type_produit, ?bool $force = null)
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        $Code_type_produit = round($Code_type_produit);
        if (! $force) {
            if (!self::$maj_droits_supprimer_en_cours)
            {
                self::$maj_droits_supprimer_en_cours = true;
                Hook_type_produit::hook_actualiser_les_droits_supprimer($Code_type_produit);
                self::$maj_droits_supprimer_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['type_produit__SUPPRIMER']) ) $code_erreur = REFUS_TYPE_PRODUIT__SUPPRIMER;
        elseif (! $this->mf_tester_existance_Code_type_produit($Code_type_produit) ) $code_erreur = ERR_TYPE_PRODUIT__SUPPRIMER_2__CODE_TYPE_PRODUIT_INEXISTANT;
        elseif (CONTROLE_ACCES_DONNEES_DEFAUT && ! Hook_mf_systeme::controle_acces_donnees('Code_type_produit', $Code_type_produit)) $code_erreur = ACCES_CODE_TYPE_PRODUIT_REFUSE;
        elseif ( !Hook_type_produit::autorisation_suppression($Code_type_produit) ) $code_erreur = REFUS_TYPE_PRODUIT__SUPPRESSION_BLOQUEE;
        else
        {
            $copie__type_produit = $this->mf_get($Code_type_produit, array('autocompletion' => false));
            $this->supprimer_donnes_en_cascade("type_produit", array($Code_type_produit));
            $requete = 'DELETE IGNORE FROM ' . inst('type_produit') . ' WHERE Code_type_produit=' . $Code_type_produit . ';';
            executer_requete_mysql($requete, array_search('type_produit', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            if (requete_mysqli_affected_rows() == 0) {
                $code_erreur = ERR_TYPE_PRODUIT__SUPPRIMER__REFUSEE;
            } else {
                self::$cache_db->clear();
                Hook_type_produit::supprimer($copie__type_produit);
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

    public function mf_supprimer_2(array $liste_Code_type_produit, ?bool $force = null)
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        $copie__liste_type_produit = $this->mf_lister_2($liste_Code_type_produit, array('autocompletion' => false));
        $liste_Code_type_produit=array();
        foreach ( $copie__liste_type_produit as $copie__type_produit )
        {
            $Code_type_produit = $copie__type_produit['Code_type_produit'];
            if (!$force)
            {
                if (!self::$maj_droits_supprimer_en_cours)
                {
                    self::$maj_droits_supprimer_en_cours = true;
                    Hook_type_produit::hook_actualiser_les_droits_supprimer($Code_type_produit);
                    self::$maj_droits_supprimer_en_cours = false;
                }
            }
            if ( !$force && !mf_matrice_droits(['type_produit__SUPPRIMER']) ) $code_erreur = REFUS_TYPE_PRODUIT__SUPPRIMER;
            elseif ( !Hook_type_produit::autorisation_suppression($Code_type_produit) ) $code_erreur = REFUS_TYPE_PRODUIT__SUPPRESSION_BLOQUEE;
            {
                $liste_Code_type_produit[] = $Code_type_produit;
            }
        }
        if ( $code_erreur==0 && count($liste_Code_type_produit)>0 )
        {
            $this->supprimer_donnes_en_cascade("type_produit", $liste_Code_type_produit);
            $requete = 'DELETE IGNORE FROM ' . inst('type_produit') . ' WHERE Code_type_produit IN ' . Sql_Format_Liste($liste_Code_type_produit) . ';';
            executer_requete_mysql( $requete , array_search('type_produit', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            if (requete_mysqli_affected_rows() == 0) {
                $code_erreur = ERR_TYPE_PRODUIT__SUPPRIMER_2__REFUSEE;
            } else {
                self::$cache_db->clear();
                Hook_type_produit::supprimer_2($copie__liste_type_produit);
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

    public function mf_supprimer_3(array $liste_Code_type_produit)
    {
        $code_erreur=0;
        if ( count($liste_Code_type_produit)>0 )
        {
            $this->supprimer_donnes_en_cascade("type_produit", $liste_Code_type_produit);
            $requete = 'DELETE IGNORE FROM ' . inst('type_produit') . ' WHERE Code_type_produit IN ' . Sql_Format_Liste($liste_Code_type_produit) . ';';
            executer_requete_mysql( $requete , array_search('type_produit', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            if (requete_mysqli_affected_rows() == 0) {
                $code_erreur = ERR_TYPE_PRODUIT__SUPPRIMER_3__REFUSEE;
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
        return array('code_erreur' => $code_erreur);
    }

    public function mf_lister_contexte(?bool $contexte_parent = null, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ($contexte_parent === null) {
            $contexte_parent = true;
        }
        if ($options === null) {
            $options=[];
        }
        global $mf_contexte, $est_charge;
        if (! $contexte_parent && $mf_contexte['Code_type_produit'] != 0) {
            $type_produit = $this->mf_get( $mf_contexte['Code_type_produit'], $options);
            return array( $type_produit['Code_type_produit'] => $type_produit );
        } else {
            return $this->mf_lister($options);
        }
    }

    public function mf_lister(?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cle = "type_produit__lister";

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
            if ( isset($mf_tri_defaut_table['type_produit']) )
            {
                $options['tris'] = $mf_tri_defaut_table['type_produit'];
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

        $nouvelle_lecture = true;
        while ($nouvelle_lecture) {
            $nouvelle_lecture = false;
            if (false === $liste = self::$cache_db->read($cle)) {

                // Indexes
                $liste_colonnes_a_indexer = [];
                if ($argument_cond != '') {
                    if ( strpos($argument_cond, 'type_produit_Libelle')!==false ) { $liste_colonnes_a_indexer['type_produit_Libelle'] = 'type_produit_Libelle'; }
                }
                if (isset($options['tris'])) {
                    if ( isset($options['tris']['type_produit_Libelle']) ) { $liste_colonnes_a_indexer['type_produit_Libelle'] = 'type_produit_Libelle'; }
                }
                if (count($liste_colonnes_a_indexer) > 0) {
                    if (false === $mf_liste_requete_index = self::$cache_db->read('type_produit__index')) {
                        $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('type_produit').'`;', false);
                        $mf_liste_requete_index = array();
                        while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                            $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                        }
                        mysqli_free_result($res_requete_index);
                        self::$cache_db->write('type_produit__index', $mf_liste_requete_index);
                    }
                    foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                        if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                    }
                    if (count($liste_colonnes_a_indexer) > 0) {
                        foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                            executer_requete_mysql('ALTER TABLE `'.inst('type_produit').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                        }
                        self::$cache_db->clear();
                    }
                }

                $liste = array();
                $liste_type_produit_pas_a_jour = array();
                if ($toutes_colonnes)
                {
                    $colonnes='Code_type_produit, type_produit_Libelle';
                }
                else
                {
                    $colonnes='Code_type_produit, type_produit_Libelle';
                }
                $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM ' . inst('type_produit')." WHERE 1{$argument_cond}{$argument_tris}{$argument_limit};", false);
                while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                {
                    mf_formatage_db_type_php($row_requete);
                    $liste[$row_requete['Code_type_produit']] = $row_requete;
                    if ( $maj && ! Hook_type_produit::est_a_jour( $row_requete ) )
                    {
                        $liste_type_produit_pas_a_jour[$row_requete['Code_type_produit']] = $row_requete;
                        $nouvelle_lecture = true;
                    }
                }
                mysqli_free_result($res_requete);
                if (count($options['tris'])==1 && ! $nouvelle_lecture)
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
                if ( ! $nouvelle_lecture )
                {
                    self::$cache_db->write($cle, $liste);
                }
            }
            if ( $nouvelle_lecture )
            {
                Hook_type_produit::mettre_a_jour( $liste_type_produit_pas_a_jour );
            }
        }

        foreach ($liste as $elem)
        {
            if ( $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_type_produit', $elem['Code_type_produit']) )
            {
                unset($liste[$elem['Code_type_produit']]);
            }
            else
            {
                if (($autocompletion_recursive || self::$auto_completion < 1) && $autocompletion) {
                    self::$auto_completion ++;
                    Hook_type_produit::completion($liste[$elem['Code_type_produit']], self::$auto_completion - 1);
                    self::$auto_completion --;
                }
            }
        }

        return $liste;
    }

    public function mf_lister_2(array $liste_Code_type_produit, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        if (count($liste_Code_type_produit) > 0) {
            $cle = "type_produit__mf_lister_2_".Sql_Format_Liste($liste_Code_type_produit);

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
                if ( isset($mf_tri_defaut_table['type_produit']) )
                {
                    $options['tris'] = $mf_tri_defaut_table['type_produit'];
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

            $nouvelle_lecture = true;
            while ($nouvelle_lecture) {
                $nouvelle_lecture = false;
                if (false === $liste = self::$cache_db->read($cle)) {

                    // Indexes
                    $liste_colonnes_a_indexer = [];
                    if ($argument_cond != '') {
                        if ( strpos($argument_cond, 'type_produit_Libelle')!==false ) { $liste_colonnes_a_indexer['type_produit_Libelle'] = 'type_produit_Libelle'; }
                    }
                    if (isset($options['tris'])) {
                        if ( isset($options['tris']['type_produit_Libelle']) ) { $liste_colonnes_a_indexer['type_produit_Libelle'] = 'type_produit_Libelle'; }
                    }
                    if (count($liste_colonnes_a_indexer) > 0) {
                        if (false === $mf_liste_requete_index = self::$cache_db->read('type_produit__index')) {
                            $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('type_produit').'`;', false);
                            $mf_liste_requete_index = array();
                            while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                                $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                            }
                            mysqli_free_result($res_requete_index);
                            self::$cache_db->write('type_produit__index', $mf_liste_requete_index);
                        }
                        foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                            if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                        }
                        if (count($liste_colonnes_a_indexer) > 0) {
                            foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                                executer_requete_mysql('ALTER TABLE `'.inst('type_produit').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                            }
                            self::$cache_db->clear();
                        }
                    }

                    $liste = array();
                    $liste_type_produit_pas_a_jour = array();
                    if ($toutes_colonnes) {
                        $colonnes='Code_type_produit, type_produit_Libelle';
                    } else {
                        $colonnes='Code_type_produit, type_produit_Libelle';
                    }
                    $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM ' . inst('type_produit') . " WHERE 1{$argument_cond} AND Code_type_produit IN ".Sql_Format_Liste($liste_Code_type_produit)."{$argument_tris}{$argument_limit};", false);
                    while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                        mf_formatage_db_type_php($row_requete);
                        $liste[$row_requete['Code_type_produit']] = $row_requete;
                        if ($maj && ! Hook_type_produit::est_a_jour($row_requete)) {
                            $liste_type_produit_pas_a_jour[$row_requete['Code_type_produit']] = $row_requete;
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
                    Hook_type_produit::mettre_a_jour( $liste_type_produit_pas_a_jour );
                }
            }

            foreach ($liste as $elem) {
                if ( $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_type_produit', $elem['Code_type_produit']) )
                {
                    unset($liste[$elem['Code_type_produit']]);
                }
                else
                {
                    if (($autocompletion_recursive || self::$auto_completion < 1) && $autocompletion) {
                        self::$auto_completion ++;
                        Hook_type_produit::completion($liste[$elem['Code_type_produit']], self::$auto_completion - 1);
                        self::$auto_completion --;
                    }
                }
            }

            return $liste;
        }
        else
        {
            return array();
        }
    }

    public function mf_lister_3(?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        return $this->mf_lister($options);
    }

    public function mf_get(int $Code_type_produit, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $Code_type_produit = round($Code_type_produit);
        $retour = array();
        if ( ! CONTROLE_ACCES_DONNEES_DEFAUT || Hook_mf_systeme::controle_acces_donnees('Code_type_produit', $Code_type_produit) )
        {
            $cle = 'type_produit__get_'.$Code_type_produit;

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
            while ( $nouvelle_lecture )
            {
                $nouvelle_lecture = false;
                if (false === $retour = self::$cache_db->read($cle)) {
                    if ($toutes_colonnes) {
                        $colonnes='Code_type_produit, type_produit_Libelle';
                    } else {
                        $colonnes='Code_type_produit, type_produit_Libelle';
                    }
                    $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM ' . inst('type_produit') . ' WHERE Code_type_produit = ' . $Code_type_produit . ';', false);
                    if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                    {
                        mf_formatage_db_type_php($row_requete);
                        $retour = $row_requete;
                        if ( $maj && ! Hook_type_produit::est_a_jour( $row_requete ) )
                        {
                            $nouvelle_lecture = true;
                        }
                    } else {
                        $retour = array();
                    }
                    mysqli_free_result($res_requete);
                    if ( ! $nouvelle_lecture )
                    {
                        self::$cache_db->write($cle, $retour);
                    }
                }
                if ( $nouvelle_lecture )
                {
                    Hook_type_produit::mettre_a_jour( array( $row_requete['Code_type_produit'] => $row_requete ) );
                }
            }
            if ( isset( $retour['Code_type_produit'] ) )
            {
                if (($autocompletion_recursive || self::$auto_completion < 1) && $autocompletion) {
                    self::$auto_completion ++;
                    Hook_type_produit::completion($retour, self::$auto_completion - 1);
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
        $cle = "type_produit__get_last";
        if (false === $retour = self::$cache_db->read($cle)) {
            $Code_type_produit = 0;
            $res_requete = executer_requete_mysql('SELECT Code_type_produit FROM ' . inst('type_produit') . " WHERE 1 ORDER BY mf_date_creation DESC, Code_type_produit DESC LIMIT 0 , 1;", false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $Code_type_produit = $row_requete['Code_type_produit'];
            }
            mysqli_free_result($res_requete);
            $retour = $this->mf_get($Code_type_produit, $options);
            self::$cache_db->write($cle, $retour);
        }
        return $retour;
    }

    public function mf_get_2(int $Code_type_produit, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $Code_type_produit = round($Code_type_produit);
        $retour = array();
        $cle = 'type_produit__get_'.$Code_type_produit;

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
                $colonnes='Code_type_produit, type_produit_Libelle';
            } else {
                $colonnes='Code_type_produit, type_produit_Libelle';
            }
            $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM ' . inst('type_produit') . ' WHERE Code_type_produit = ' . $Code_type_produit . ';', false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                mf_formatage_db_type_php($row_requete);
                $retour = $row_requete;
            } else {
                $retour = array();
            }
            mysqli_free_result($res_requete);
            self::$cache_db->write($cle, $retour);
        }
        if (isset($retour['Code_type_produit'])) {
            if (($autocompletion_recursive || self::$auto_completion < 1) && $autocompletion) {
                self::$auto_completion ++;
                Hook_type_produit::completion($retour, self::$auto_completion - 1);
                self::$auto_completion --;
            }
        }
        return $retour;
    }

    public function mf_prec_et_suiv( int $Code_type_produit, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $Code_type_produit = round($Code_type_produit);
        $liste = $this->mf_lister($options);
        return prec_suiv($liste, $Code_type_produit);
    }

    public function mf_compter(?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cle = 'type_produit__compter';

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
                if ( strpos($argument_cond, 'type_produit_Libelle')!==false ) { $liste_colonnes_a_indexer['type_produit_Libelle'] = 'type_produit_Libelle'; }
            }
            if (count($liste_colonnes_a_indexer) > 0) {
                if (false === $mf_liste_requete_index = self::$cache_db->read('type_produit__index')) {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('type_produit').'`;', false);
                    $mf_liste_requete_index = array();
                    while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    self::$cache_db->write('type_produit__index', $mf_liste_requete_index);
                }
                foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if (count($liste_colonnes_a_indexer) > 0) {
                    foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                        executer_requete_mysql('ALTER TABLE `'.inst('type_produit').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    self::$cache_db->clear();
                }
            }

            $res_requete = executer_requete_mysql('SELECT count(Code_type_produit) as nb FROM ' . inst('type_produit')." WHERE 1{$argument_cond};", false);
            $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC);
            mysqli_free_result($res_requete);
            $nb = (int) $row_requete['nb'];
            self::$cache_db->write($cle, $nb);
        }
        return $nb;
    }

    public function mfi_compter( array $interface, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ($options === null) {
            $options=[];
        }
        return $this->mf_compter( $options );
    }

    public function mf_liste_Code_type_produit(?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ($options === null) {
            $options=[];
        }
        return $this->get_liste_Code_type_produit($options);
    }

    public function mf_get_liste_tables_enfants()
    {
        return $this->get_liste_tables_enfants( 'type_produit' );
    }

    public function mf_get_liste_tables_parents()
    {
        return array();
    }

    public function mf_search_type_produit_Libelle( string $type_produit_Libelle )
    {
        return $this->rechercher_type_produit_Libelle( $type_produit_Libelle );
    }

    public function mf_search__colonne( string $colonne_db, $recherche )
    {
        switch ($colonne_db) {
            case 'type_produit_Libelle': return $this->mf_search_type_produit_Libelle( $recherche ); break;
        }
    }

    public function mf_get_next_id()
    {
        $res_requete = executer_requete_mysql('SELECT AUTO_INCREMENT as next_id FROM INFORMATION_SCHEMA.TABLES WHERE table_name = \'type_produit\';', false);
        $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC);
        mysqli_free_result($res_requete);
        return round($row_requete['next_id']);
    }

    public function mf_search(array $ligne) // array('colonne1' => 'valeur1',  [...] )
    {
        global $mf_initialisation;
        $type_produit_Libelle = (string)(isset($ligne['type_produit_Libelle'])?$ligne['type_produit_Libelle']:$mf_initialisation['type_produit_Libelle']);
        Hook_type_produit::pre_controller($type_produit_Libelle);
        $mf_cle_unique = Hook_type_produit::calcul_cle_unique($type_produit_Libelle);
        $res_requete = executer_requete_mysql('SELECT Code_type_produit FROM ' . inst('type_produit') . ' WHERE mf_cle_unique = \''.$mf_cle_unique.'\'', false);
        if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
        {
            $r = round($row_requete['Code_type_produit']);
        }
        else
        {
            $r = false;
        }
        mysqli_free_result($res_requete);
        return $r;
    }
}
