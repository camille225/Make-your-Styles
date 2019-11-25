<?php

/*
    +------------------------------+
    |  NE PAS MODIFIER CE FICHIER  |
    +------------------------------+
*/

class filtre_monframework extends entite_monframework
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
            include_once __DIR__ . '/../../erreurs/erreurs__filtre.php';
            self::$initialisation = false;
            Hook_filtre::initialisation();
            self::$cache_db = new Mf_Cachedb('filtre');
        }
        if (!self::$actualisation_en_cours)
        {
            self::$actualisation_en_cours=true;
            Hook_filtre::actualisation();
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

        if ( ! test_si_table_existe(inst('filtre')) )
        {
            executer_requete_mysql('CREATE TABLE '.inst('filtre').'(Code_filtre INT AUTO_INCREMENT NOT NULL, PRIMARY KEY (Code_filtre)) ENGINE=MyISAM;', array_search('filtre', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        $liste_colonnes = lister_les_colonnes(inst('filtre'));

        if ( isset($liste_colonnes['filtre_Libelle']) )
        {
            if ( typeMyql2Sql($liste_colonnes['filtre_Libelle']['Type'])!='VARCHAR' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('filtre').' CHANGE filtre_Libelle filtre_Libelle VARCHAR(255);', array_search('filtre', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['filtre_Libelle']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('filtre').' ADD filtre_Libelle VARCHAR(255);', array_search('filtre', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE '.inst('filtre').' SET filtre_Libelle=' . format_sql('filtre_Libelle', $mf_initialisation['filtre_Libelle']) . ';', array_search('filtre', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if ( isset($liste_colonnes['mf_signature']) )
        {
            unset($liste_colonnes['mf_signature']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('filtre').' ADD mf_signature VARCHAR(255);', array_search('filtre', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('ALTER TABLE '.inst('filtre').' ADD INDEX( mf_signature );', array_search('filtre', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if ( isset($liste_colonnes['mf_cle_unique']) )
        {
            unset($liste_colonnes['mf_cle_unique']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('filtre').' ADD mf_cle_unique VARCHAR(255);', array_search('filtre', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('ALTER TABLE '.inst('filtre').' ADD INDEX( mf_cle_unique );', array_search('filtre', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if ( isset($liste_colonnes['mf_date_creation']) )
        {
            unset($liste_colonnes['mf_date_creation']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('filtre').' ADD mf_date_creation DATETIME;', array_search('filtre', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('ALTER TABLE '.inst('filtre').' ADD INDEX( mf_date_creation );', array_search('filtre', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if ( isset($liste_colonnes['mf_date_modification']) )
        {
            unset($liste_colonnes['mf_date_modification']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('filtre').' ADD mf_date_modification DATETIME;', array_search('filtre', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('ALTER TABLE '.inst('filtre').' ADD INDEX( mf_date_modification );', array_search('filtre', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        unset($liste_colonnes['Code_filtre']);

        foreach ($liste_colonnes as $field => $value)
        {
            executer_requete_mysql('ALTER TABLE '.inst('filtre').' DROP COLUMN '.$field.';', array_search('filtre', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

    }

    public function mf_ajouter(string $filtre_Libelle, ?bool $force = false)
    {
        if ($force === null) {
            $force = false;
        }
        $Code_filtre = 0;
        $code_erreur = 0;
        Hook_filtre::pre_controller($filtre_Libelle);
        if (!$force)
        {
            if (!self::$maj_droits_ajouter_en_cours)
            {
                self::$maj_droits_ajouter_en_cours = true;
                Hook_filtre::hook_actualiser_les_droits_ajouter();
                self::$maj_droits_ajouter_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['filtre__AJOUTER']) ) $code_erreur = REFUS_FILTRE__AJOUTER;
        elseif ( !Hook_filtre::autorisation_ajout($filtre_Libelle) ) $code_erreur = REFUS_FILTRE__AJOUT_BLOQUEE;
        else
        {
            Hook_filtre::data_controller($filtre_Libelle);
            $mf_signature = text_sql(Hook_filtre::calcul_signature($filtre_Libelle));
            $mf_cle_unique = text_sql(Hook_filtre::calcul_cle_unique($filtre_Libelle));
            $filtre_Libelle = text_sql($filtre_Libelle);
            $requete = "INSERT INTO ".inst('filtre')." ( mf_signature, mf_cle_unique, mf_date_creation, mf_date_modification, filtre_Libelle ) VALUES ( '$mf_signature', '$mf_cle_unique', '".get_now()."', '".get_now()."', '$filtre_Libelle' );";
            executer_requete_mysql($requete, array_search('filtre', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            $Code_filtre = requete_mysql_insert_id();
            if ($Code_filtre==0)
            {
                $code_erreur = ERR_FILTRE__AJOUTER__AJOUT_REFUSE;
            } else {
                self::$cache_db->clear();
                Hook_filtre::ajouter( $Code_filtre );
            }
        }
        if ($code_erreur != 0) {
            global $mf_message_erreur_personalise, $mf_libelle_erreur;
            if ($mf_message_erreur_personalise != '') {
                $mf_libelle_erreur[$code_erreur] = $mf_message_erreur_personalise;
                $mf_message_erreur_personalise = '';
            }
        }
        return array('code_erreur' => $code_erreur, 'Code_filtre' => $Code_filtre, 'callback' => ( $code_erreur==0 ? Hook_filtre::callback_post($Code_filtre) : null ));
    }

    public function mf_creer(?bool $force = null)
    {
        if ($force === null) {
            $force = false;
        }
        global $mf_initialisation;
        $filtre_Libelle = $mf_initialisation['filtre_Libelle'];
        return $this->mf_ajouter($filtre_Libelle, $force);
    }

    public function mf_ajouter_2(array $ligne, bool $force = null) // array('colonne1' => 'valeur1',  [...] )
    {
        if ($force === null) {
            $force = false;
        }
        global $mf_initialisation;
        $filtre_Libelle = (string)(isset($ligne['filtre_Libelle'])?$ligne['filtre_Libelle']:$mf_initialisation['filtre_Libelle']);
        return $this->mf_ajouter($filtre_Libelle, $force);
    }

    public function mf_ajouter_3(array $lignes) // array( array( 'colonne1' => 'valeur1', 'colonne2' => 'valeur2',  [...] ), [...] )
    {
        global $mf_initialisation;
        $code_erreur = 0;
        $values = '';
        foreach ($lignes as $ligne)
        {
            $filtre_Libelle = text_sql(isset($ligne['filtre_Libelle'])?$ligne['filtre_Libelle']:$mf_initialisation['filtre_Libelle']);
            $values .= ($values!="" ? "," : "")."('$filtre_Libelle')";
        }
        if ($values!='')
        {
            $requete = "INSERT INTO ".inst('filtre')." ( filtre_Libelle ) VALUES $values;";
            executer_requete_mysql( $requete , array_search('filtre', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            $n = requete_mysqli_affected_rows();
            if ($n < count($lignes))
            {
                $code_erreur = ERR_FILTRE__AJOUTER_3__ECHEC_AJOUT;
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

    public function mf_actualiser_signature(int $Code_filtre)
    {
        $filtre = $this->mf_get_2($Code_filtre, array('autocompletion' => false));
        $mf_signature = text_sql(Hook_filtre::calcul_signature($filtre['filtre_Libelle']));
        $mf_cle_unique = text_sql(Hook_filtre::calcul_cle_unique($filtre['filtre_Libelle']));
        $table = inst('filtre');
        executer_requete_mysql("UPDATE $table SET mf_signature='$mf_signature', mf_cle_unique='$mf_cle_unique' WHERE Code_filtre=$Code_filtre;", array_search('filtre', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        if (requete_mysqli_affected_rows() == 1) {
            self::$cache_db->clear();
        }
    }

    public function mf_modifier( int $Code_filtre, string $filtre_Libelle, ?bool $force = null)
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        $Code_filtre = round($Code_filtre);
        Hook_filtre::pre_controller($filtre_Libelle, $Code_filtre);
        if (!$force)
        {
            if (!self::$maj_droits_modifier_en_cours)
            {
                self::$maj_droits_modifier_en_cours = true;
                Hook_filtre::hook_actualiser_les_droits_modifier($Code_filtre);
                self::$maj_droits_modifier_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['filtre__MODIFIER']) ) $code_erreur = REFUS_FILTRE__MODIFIER;
        elseif ( !$this->mf_tester_existance_Code_filtre($Code_filtre) ) $code_erreur = ERR_FILTRE__MODIFIER__CODE_FILTRE_INEXISTANT;
        elseif (CONTROLE_ACCES_DONNEES_DEFAUT && ! Hook_mf_systeme::controle_acces_donnees('Code_filtre', $Code_filtre)) $code_erreur = ACCES_CODE_FILTRE_REFUSE;
        elseif ( !Hook_filtre::autorisation_modification($Code_filtre, $filtre_Libelle) ) $code_erreur = REFUS_FILTRE__MODIFICATION_BLOQUEE;
        else
        {
            if (! isset(self::$lock[$Code_filtre])) {
                self::$lock[$Code_filtre] = 0;
            }
            if (self::$lock[$Code_filtre] == 0) {
                self::$cache_db->add_lock($Code_filtre);
            }
            self::$lock[$Code_filtre]++;
            Hook_filtre::data_controller($filtre_Libelle, $Code_filtre);
            $filtre = $this->mf_get_2( $Code_filtre, array('autocompletion' => false, 'masquer_mdp' => false) );
            $mf_colonnes_a_modifier=[];
            $bool__filtre_Libelle = false; if ( $filtre_Libelle!=$filtre['filtre_Libelle'] ) { Hook_filtre::data_controller__filtre_Libelle($filtre['filtre_Libelle'], $filtre_Libelle, $Code_filtre); if ( $filtre_Libelle!=$filtre['filtre_Libelle'] ) { $mf_colonnes_a_modifier[] = 'filtre_Libelle=' . format_sql('filtre_Libelle', $filtre_Libelle); $bool__filtre_Libelle = true; } }
            if (count($mf_colonnes_a_modifier) > 0) {
                $mf_signature = text_sql(Hook_filtre::calcul_signature($filtre_Libelle));
                $mf_cle_unique = text_sql(Hook_filtre::calcul_cle_unique($filtre_Libelle));
                $mf_colonnes_a_modifier[] = 'mf_signature=\'' . $mf_signature . '\'';
                $mf_colonnes_a_modifier[] = 'mf_cle_unique=\'' . $mf_cle_unique . '\'';
                $mf_colonnes_a_modifier[] = 'mf_date_modification=\'' . get_now() . '\'';
                $requete = 'UPDATE '.inst('filtre').' SET ' . enumeration($mf_colonnes_a_modifier) . ' WHERE Code_filtre = ' . $Code_filtre . ';';
                executer_requete_mysql($requete, array_search('filtre', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
                if (requete_mysqli_affected_rows() == 0) {
                    $code_erreur = ERR_FILTRE__MODIFIER__AUCUN_CHANGEMENT;
                } else {
                    self::$cache_db->clear();
                    Hook_filtre::modifier($Code_filtre, $bool__filtre_Libelle);
                }
            } else {
                $code_erreur = ERR_FILTRE__MODIFIER__AUCUN_CHANGEMENT;
            }
            self::$lock[$Code_filtre]--;
            if (self::$lock[$Code_filtre] == 0) {
                self::$cache_db->release_lock($Code_filtre);
                unset(self::$lock[$Code_filtre]);
            }
        }
        if ($code_erreur != 0) {
            global $mf_message_erreur_personalise, $mf_libelle_erreur;
            if ($mf_message_erreur_personalise != '') {
                $mf_libelle_erreur[$code_erreur] = $mf_message_erreur_personalise;
                $mf_message_erreur_personalise = '';
            }
        }
        return array('code_erreur' => $code_erreur, 'callback' => ( $code_erreur == 0 ? Hook_filtre::callback_put($Code_filtre) : null ));
    }

    public function mf_modifier_2(array $lignes, ?bool $force = null) // array( $Code_filtre => array('colonne1' => 'valeur1',  [...] ) )
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        foreach ( $lignes as $Code_filtre => $colonnes )
        {
            if ( $code_erreur==0 )
            {
                $Code_filtre = (int) round($Code_filtre);
                $filtre = $this->mf_get_2($Code_filtre, array('autocompletion' => false));
                if (!$force)
                {
                    if (!self::$maj_droits_modifier_en_cours)
                    {
                        self::$maj_droits_modifier_en_cours = true;
                        Hook_filtre::hook_actualiser_les_droits_modifier($Code_filtre);
                        self::$maj_droits_modifier_en_cours = false;
                    }
                }
                $filtre_Libelle = (string) ( isset($colonnes['filtre_Libelle']) && ( $force || mf_matrice_droits(['api_modifier__filtre_Libelle', 'filtre__MODIFIER']) ) ? $colonnes['filtre_Libelle'] : ( isset($filtre['filtre_Libelle']) ? $filtre['filtre_Libelle'] : '' ) );
                $retour = $this->mf_modifier($Code_filtre, $filtre_Libelle, true);
                if ($retour['code_erreur'] != 0 && $retour['code_erreur'] != ERR_FILTRE__MODIFIER__AUCUN_CHANGEMENT) {
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

    public function mf_modifier_3(array $lignes) // array( $Code_filtre => array('colonne1' => 'valeur1',  [...] ) )
    {
        $code_erreur = 0;
        $modifs = false;

        // transformation des lignes en colonnes
        $valeurs_en_colonnes=array();
        $indices_par_colonne=array();
        $liste_valeurs_indexees=array();
        foreach ( $lignes as $Code_filtre => $colonnes )
        {
            foreach ($colonnes as $colonne => $valeur)
            {
                if ( $colonne=='filtre_Libelle' )
                {
                    $valeurs_en_colonnes[$colonne][$Code_filtre]=$valeur;
                    $indices_par_colonne[$colonne][]=$Code_filtre;
                    $liste_valeurs_indexees[$colonne][''.$valeur][]=$Code_filtre;
                }
            }
        }

        // fabrication des requetes
        foreach ( $valeurs_en_colonnes as $colonne => $valeurs )
        {
            if ( count($liste_valeurs_indexees[$colonne]) > 3 )
            {
                $modification_sql = $colonne . ' = CASE Code_filtre';
                foreach ( $valeurs as $Code_filtre => $valeur )
                {
                    $modification_sql .= ' WHEN ' . $Code_filtre . ' THEN ' . format_sql($colonne, $valeur);
                }
                $modification_sql .= ' END';
                $perimetre = Sql_Format_Liste($indices_par_colonne[$colonne]);
                executer_requete_mysql('UPDATE ' . inst('filtre') . ' SET ' . $modification_sql . ' WHERE Code_filtre IN ' . $perimetre . ';', array_search('filtre', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
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
                    executer_requete_mysql('UPDATE ' . inst('filtre') . ' SET ' . $colonne . ' = ' . format_sql($colonne, $valeur) . ' WHERE Code_filtre IN ' . $perimetre . ';', array_search('filtre', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
                    if ( requete_mysqli_affected_rows()!=0 )
                    {
                        $modifs = true;
                    }
                }
            }
        }

        if ( ! $modifs && $code_erreur==0 )
        {
            $code_erreur = ERR_FILTRE__MODIFIER_3__AUCUN_CHANGEMENT;
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
        if ( isset($data['filtre_Libelle']) ) { $mf_colonnes_a_modifier[] = 'filtre_Libelle = ' . format_sql('filtre_Libelle', $data['filtre_Libelle']); }
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

            $requete = 'UPDATE ' . inst('filtre') . ' SET ' . enumeration($mf_colonnes_a_modifier) . " WHERE 1$argument_cond" . ( $limit>0 ? ' LIMIT ' . $limit : '' ) . ";";
            executer_requete_mysql( $requete , array_search('filtre', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_FILTRE__MODIFIER_4__AUCUN_CHANGEMENT;
            } else {
                self::$cache_db->clear();
            }
        }
        return array('code_erreur' => $code_erreur);
    }

    public function mf_supprimer(int $Code_filtre, ?bool $force = null)
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        $Code_filtre = round($Code_filtre);
        if (! $force) {
            if (!self::$maj_droits_supprimer_en_cours)
            {
                self::$maj_droits_supprimer_en_cours = true;
                Hook_filtre::hook_actualiser_les_droits_supprimer($Code_filtre);
                self::$maj_droits_supprimer_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['filtre__SUPPRIMER']) ) $code_erreur = REFUS_FILTRE__SUPPRIMER;
        elseif (! $this->mf_tester_existance_Code_filtre($Code_filtre) ) $code_erreur = ERR_FILTRE__SUPPRIMER_2__CODE_FILTRE_INEXISTANT;
        elseif (CONTROLE_ACCES_DONNEES_DEFAUT && ! Hook_mf_systeme::controle_acces_donnees('Code_filtre', $Code_filtre)) $code_erreur = ACCES_CODE_FILTRE_REFUSE;
        elseif ( !Hook_filtre::autorisation_suppression($Code_filtre) ) $code_erreur = REFUS_FILTRE__SUPPRESSION_BLOQUEE;
        else
        {
            $copie__filtre = $this->mf_get($Code_filtre, array('autocompletion' => false));
            $this->supprimer_donnes_en_cascade("filtre", array($Code_filtre));
            $requete = 'DELETE IGNORE FROM ' . inst('filtre') . ' WHERE Code_filtre=' . $Code_filtre . ';';
            executer_requete_mysql($requete, array_search('filtre', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            if (requete_mysqli_affected_rows() == 0) {
                $code_erreur = ERR_FILTRE__SUPPRIMER__REFUSEE;
            } else {
                self::$cache_db->clear();
                Hook_filtre::supprimer($copie__filtre);
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

    public function mf_supprimer_2(array $liste_Code_filtre, ?bool $force = null)
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        $copie__liste_filtre = $this->mf_lister_2($liste_Code_filtre, array('autocompletion' => false));
        $liste_Code_filtre=array();
        foreach ( $copie__liste_filtre as $copie__filtre )
        {
            $Code_filtre = $copie__filtre['Code_filtre'];
            if (!$force)
            {
                if (!self::$maj_droits_supprimer_en_cours)
                {
                    self::$maj_droits_supprimer_en_cours = true;
                    Hook_filtre::hook_actualiser_les_droits_supprimer($Code_filtre);
                    self::$maj_droits_supprimer_en_cours = false;
                }
            }
            if ( !$force && !mf_matrice_droits(['filtre__SUPPRIMER']) ) $code_erreur = REFUS_FILTRE__SUPPRIMER;
            elseif ( !Hook_filtre::autorisation_suppression($Code_filtre) ) $code_erreur = REFUS_FILTRE__SUPPRESSION_BLOQUEE;
            {
                $liste_Code_filtre[] = $Code_filtre;
            }
        }
        if ( $code_erreur==0 && count($liste_Code_filtre)>0 )
        {
            $this->supprimer_donnes_en_cascade("filtre", $liste_Code_filtre);
            $requete = 'DELETE IGNORE FROM ' . inst('filtre') . ' WHERE Code_filtre IN ' . Sql_Format_Liste($liste_Code_filtre) . ';';
            executer_requete_mysql( $requete , array_search('filtre', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            if (requete_mysqli_affected_rows() == 0) {
                $code_erreur = ERR_FILTRE__SUPPRIMER_2__REFUSEE;
            } else {
                self::$cache_db->clear();
                Hook_filtre::supprimer_2($copie__liste_filtre);
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

    public function mf_supprimer_3(array $liste_Code_filtre)
    {
        $code_erreur=0;
        if ( count($liste_Code_filtre)>0 )
        {
            $this->supprimer_donnes_en_cascade("filtre", $liste_Code_filtre);
            $requete = 'DELETE IGNORE FROM ' . inst('filtre') . ' WHERE Code_filtre IN ' . Sql_Format_Liste($liste_Code_filtre) . ';';
            executer_requete_mysql( $requete , array_search('filtre', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            if (requete_mysqli_affected_rows() == 0) {
                $code_erreur = ERR_FILTRE__SUPPRIMER_3__REFUSEE;
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
        if (! $contexte_parent && $mf_contexte['Code_filtre'] != 0) {
            $filtre = $this->mf_get( $mf_contexte['Code_filtre'], $options);
            return array( $filtre['Code_filtre'] => $filtre );
        } else {
            return $this->mf_lister($options);
        }
    }

    public function mf_lister(?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cle = "filtre__lister";

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
            if ( isset($mf_tri_defaut_table['filtre']) )
            {
                $options['tris'] = $mf_tri_defaut_table['filtre'];
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
                    if ( strpos($argument_cond, 'filtre_Libelle')!==false ) { $liste_colonnes_a_indexer['filtre_Libelle'] = 'filtre_Libelle'; }
                }
                if (isset($options['tris'])) {
                    if ( isset($options['tris']['filtre_Libelle']) ) { $liste_colonnes_a_indexer['filtre_Libelle'] = 'filtre_Libelle'; }
                }
                if (count($liste_colonnes_a_indexer) > 0) {
                    if (false === $mf_liste_requete_index = self::$cache_db->read('filtre__index')) {
                        $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('filtre').'`;', false);
                        $mf_liste_requete_index = array();
                        while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                            $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                        }
                        mysqli_free_result($res_requete_index);
                        self::$cache_db->write('filtre__index', $mf_liste_requete_index);
                    }
                    foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                        if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                    }
                    if (count($liste_colonnes_a_indexer) > 0) {
                        foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                            executer_requete_mysql('ALTER TABLE `'.inst('filtre').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                        }
                        self::$cache_db->clear();
                    }
                }

                $liste = array();
                $liste_filtre_pas_a_jour = array();
                if ($toutes_colonnes)
                {
                    $colonnes='Code_filtre, filtre_Libelle';
                }
                else
                {
                    $colonnes='Code_filtre, filtre_Libelle';
                }
                $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM ' . inst('filtre')." WHERE 1{$argument_cond}{$argument_tris}{$argument_limit};", false);
                while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                {
                    mf_formatage_db_type_php($row_requete);
                    $liste[$row_requete['Code_filtre']] = $row_requete;
                    if ( $maj && ! Hook_filtre::est_a_jour( $row_requete ) )
                    {
                        $liste_filtre_pas_a_jour[$row_requete['Code_filtre']] = $row_requete;
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
                Hook_filtre::mettre_a_jour( $liste_filtre_pas_a_jour );
            }
        }

        foreach ($liste as $elem)
        {
            if ( $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_filtre', $elem['Code_filtre']) )
            {
                unset($liste[$elem['Code_filtre']]);
            }
            else
            {
                if (($autocompletion_recursive || self::$auto_completion < 1) && $autocompletion) {
                    self::$auto_completion ++;
                    Hook_filtre::completion($liste[$elem['Code_filtre']], self::$auto_completion - 1);
                    self::$auto_completion --;
                }
            }
        }

        return $liste;
    }

    public function mf_lister_2(array $liste_Code_filtre, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        if (count($liste_Code_filtre) > 0) {
            $cle = "filtre__mf_lister_2_".Sql_Format_Liste($liste_Code_filtre);

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
                if ( isset($mf_tri_defaut_table['filtre']) )
                {
                    $options['tris'] = $mf_tri_defaut_table['filtre'];
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
                        if ( strpos($argument_cond, 'filtre_Libelle')!==false ) { $liste_colonnes_a_indexer['filtre_Libelle'] = 'filtre_Libelle'; }
                    }
                    if (isset($options['tris'])) {
                        if ( isset($options['tris']['filtre_Libelle']) ) { $liste_colonnes_a_indexer['filtre_Libelle'] = 'filtre_Libelle'; }
                    }
                    if (count($liste_colonnes_a_indexer) > 0) {
                        if (false === $mf_liste_requete_index = self::$cache_db->read('filtre__index')) {
                            $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('filtre').'`;', false);
                            $mf_liste_requete_index = array();
                            while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                                $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                            }
                            mysqli_free_result($res_requete_index);
                            self::$cache_db->write('filtre__index', $mf_liste_requete_index);
                        }
                        foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                            if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                        }
                        if (count($liste_colonnes_a_indexer) > 0) {
                            foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                                executer_requete_mysql('ALTER TABLE `'.inst('filtre').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                            }
                            self::$cache_db->clear();
                        }
                    }

                    $liste = array();
                    $liste_filtre_pas_a_jour = array();
                    if ($toutes_colonnes) {
                        $colonnes='Code_filtre, filtre_Libelle';
                    } else {
                        $colonnes='Code_filtre, filtre_Libelle';
                    }
                    $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM ' . inst('filtre') . " WHERE 1{$argument_cond} AND Code_filtre IN ".Sql_Format_Liste($liste_Code_filtre)."{$argument_tris}{$argument_limit};", false);
                    while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                        mf_formatage_db_type_php($row_requete);
                        $liste[$row_requete['Code_filtre']] = $row_requete;
                        if ($maj && ! Hook_filtre::est_a_jour($row_requete)) {
                            $liste_filtre_pas_a_jour[$row_requete['Code_filtre']] = $row_requete;
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
                    Hook_filtre::mettre_a_jour( $liste_filtre_pas_a_jour );
                }
            }

            foreach ($liste as $elem) {
                if ( $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_filtre', $elem['Code_filtre']) )
                {
                    unset($liste[$elem['Code_filtre']]);
                }
                else
                {
                    if (($autocompletion_recursive || self::$auto_completion < 1) && $autocompletion) {
                        self::$auto_completion ++;
                        Hook_filtre::completion($liste[$elem['Code_filtre']], self::$auto_completion - 1);
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

    public function mf_get(int $Code_filtre, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $Code_filtre = round($Code_filtre);
        $retour = array();
        if ( ! CONTROLE_ACCES_DONNEES_DEFAUT || Hook_mf_systeme::controle_acces_donnees('Code_filtre', $Code_filtre) )
        {
            $cle = 'filtre__get_'.$Code_filtre;

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
                        $colonnes='Code_filtre, filtre_Libelle';
                    } else {
                        $colonnes='Code_filtre, filtre_Libelle';
                    }
                    $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM ' . inst('filtre') . ' WHERE Code_filtre = ' . $Code_filtre . ';', false);
                    if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                    {
                        mf_formatage_db_type_php($row_requete);
                        $retour = $row_requete;
                        if ( $maj && ! Hook_filtre::est_a_jour( $row_requete ) )
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
                    Hook_filtre::mettre_a_jour( array( $row_requete['Code_filtre'] => $row_requete ) );
                }
            }
            if ( isset( $retour['Code_filtre'] ) )
            {
                if (($autocompletion_recursive || self::$auto_completion < 1) && $autocompletion) {
                    self::$auto_completion ++;
                    Hook_filtre::completion($retour, self::$auto_completion - 1);
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
        $cle = "filtre__get_last";
        if (false === $retour = self::$cache_db->read($cle)) {
            $Code_filtre = 0;
            $res_requete = executer_requete_mysql('SELECT Code_filtre FROM ' . inst('filtre') . " WHERE 1 ORDER BY mf_date_creation DESC, Code_filtre DESC LIMIT 0 , 1;", false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $Code_filtre = $row_requete['Code_filtre'];
            }
            mysqli_free_result($res_requete);
            $retour = $this->mf_get($Code_filtre, $options);
            self::$cache_db->write($cle, $retour);
        }
        return $retour;
    }

    public function mf_get_2(int $Code_filtre, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $Code_filtre = round($Code_filtre);
        $retour = array();
        $cle = 'filtre__get_'.$Code_filtre;

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
                $colonnes='Code_filtre, filtre_Libelle';
            } else {
                $colonnes='Code_filtre, filtre_Libelle';
            }
            $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM ' . inst('filtre') . ' WHERE Code_filtre = ' . $Code_filtre . ';', false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                mf_formatage_db_type_php($row_requete);
                $retour = $row_requete;
            } else {
                $retour = array();
            }
            mysqli_free_result($res_requete);
            self::$cache_db->write($cle, $retour);
        }
        if (isset($retour['Code_filtre'])) {
            if (($autocompletion_recursive || self::$auto_completion < 1) && $autocompletion) {
                self::$auto_completion ++;
                Hook_filtre::completion($retour, self::$auto_completion - 1);
                self::$auto_completion --;
            }
        }
        return $retour;
    }

    public function mf_prec_et_suiv( int $Code_filtre, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $Code_filtre = round($Code_filtre);
        $liste = $this->mf_lister($options);
        return prec_suiv($liste, $Code_filtre);
    }

    public function mf_compter(?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cle = 'filtre__compter';

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
                if ( strpos($argument_cond, 'filtre_Libelle')!==false ) { $liste_colonnes_a_indexer['filtre_Libelle'] = 'filtre_Libelle'; }
            }
            if (count($liste_colonnes_a_indexer) > 0) {
                if (false === $mf_liste_requete_index = self::$cache_db->read('filtre__index')) {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('filtre').'`;', false);
                    $mf_liste_requete_index = array();
                    while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    self::$cache_db->write('filtre__index', $mf_liste_requete_index);
                }
                foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if (count($liste_colonnes_a_indexer) > 0) {
                    foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                        executer_requete_mysql('ALTER TABLE `'.inst('filtre').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    self::$cache_db->clear();
                }
            }

            $res_requete = executer_requete_mysql('SELECT count(Code_filtre) as nb FROM ' . inst('filtre')." WHERE 1{$argument_cond};", false);
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

    public function mf_liste_Code_filtre(?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ($options === null) {
            $options=[];
        }
        return $this->get_liste_Code_filtre($options);
    }

    public function mf_get_liste_tables_enfants()
    {
        return $this->get_liste_tables_enfants( 'filtre' );
    }

    public function mf_get_liste_tables_parents()
    {
        return array();
    }

    public function mf_search_filtre_Libelle( string $filtre_Libelle )
    {
        return $this->rechercher_filtre_Libelle( $filtre_Libelle );
    }

    public function mf_search__colonne( string $colonne_db, $recherche )
    {
        switch ($colonne_db) {
            case 'filtre_Libelle': return $this->mf_search_filtre_Libelle( $recherche ); break;
        }
    }

    public function mf_get_next_id()
    {
        $res_requete = executer_requete_mysql('SELECT AUTO_INCREMENT as next_id FROM INFORMATION_SCHEMA.TABLES WHERE table_name = \'filtre\';', false);
        $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC);
        mysqli_free_result($res_requete);
        return round($row_requete['next_id']);
    }

    public function mf_search(array $ligne) // array('colonne1' => 'valeur1',  [...] )
    {
        global $mf_initialisation;
        $filtre_Libelle = (string)(isset($ligne['filtre_Libelle'])?$ligne['filtre_Libelle']:$mf_initialisation['filtre_Libelle']);
        Hook_filtre::pre_controller($filtre_Libelle);
        $mf_cle_unique = Hook_filtre::calcul_cle_unique($filtre_Libelle);
        $res_requete = executer_requete_mysql('SELECT Code_filtre FROM ' . inst('filtre') . ' WHERE mf_cle_unique = \''.$mf_cle_unique.'\'', false);
        if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
        {
            $r = round($row_requete['Code_filtre']);
        }
        else
        {
            $r = false;
        }
        mysqli_free_result($res_requete);
        return $r;
    }
}
