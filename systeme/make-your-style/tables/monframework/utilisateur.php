<?php

/*
    +------------------------------+
    |  NE PAS MODIFIER CE FICHIER  |
    +------------------------------+
*/

class utilisateur_monframework extends entite_monframework
{

    protected static $initialisation = true;
    private static $auto_completion = 0;
    private static $actualisation_en_cours = false;
    protected static $cache_db;
    private static $maj_droits_ajouter_en_cours = false;
    private static $maj_droits_modifier_en_cours = false;
    private static $maj_droits_supprimer_en_cours = false;
    private static $lock = [];

    public function __construct()
    {
        if (self::$initialisation)
        {
            include_once __DIR__ . '/../../erreurs/erreurs__utilisateur.php';
            self::$initialisation = false;
            Hook_utilisateur::initialisation();
            self::$cache_db = new Mf_Cachedb('utilisateur');
        }
        if (!self::$actualisation_en_cours)
        {
            self::$actualisation_en_cours=true;
            Hook_utilisateur::actualisation();
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

        if ( ! test_si_table_existe(inst('utilisateur')) )
        {
            executer_requete_mysql('CREATE TABLE '.inst('utilisateur').'(Code_utilisateur INT AUTO_INCREMENT NOT NULL, PRIMARY KEY (Code_utilisateur)) ENGINE=MyISAM;', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        $liste_colonnes = lister_les_colonnes(inst('utilisateur'));

        if ( isset($liste_colonnes['utilisateur_Identifiant']) )
        {
            if ( typeMyql2Sql($liste_colonnes['utilisateur_Identifiant']['Type'])!='VARCHAR' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('utilisateur').' CHANGE utilisateur_Identifiant utilisateur_Identifiant VARCHAR(255);', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['utilisateur_Identifiant']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('utilisateur').' ADD utilisateur_Identifiant VARCHAR(255);', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE '.inst('utilisateur').' SET utilisateur_Identifiant=' . format_sql('utilisateur_Identifiant', $mf_initialisation['utilisateur_Identifiant']) . ';', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if ( isset($liste_colonnes['utilisateur_Password']) )
        {
            if ( typeMyql2Sql($liste_colonnes['utilisateur_Password']['Type'])!='VARCHAR' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('utilisateur').' CHANGE utilisateur_Password utilisateur_Password VARCHAR(255);', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['utilisateur_Password']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('utilisateur').' ADD utilisateur_Password VARCHAR(255);', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE '.inst('utilisateur').' SET utilisateur_Password=' . format_sql('utilisateur_Password', $mf_initialisation['utilisateur_Password']) . ';', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if ( isset($liste_colonnes['utilisateur_Email']) )
        {
            if ( typeMyql2Sql($liste_colonnes['utilisateur_Email']['Type'])!='VARCHAR' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('utilisateur').' CHANGE utilisateur_Email utilisateur_Email VARCHAR(255);', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['utilisateur_Email']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('utilisateur').' ADD utilisateur_Email VARCHAR(255);', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE '.inst('utilisateur').' SET utilisateur_Email=' . format_sql('utilisateur_Email', $mf_initialisation['utilisateur_Email']) . ';', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if ( isset($liste_colonnes['utilisateur_Administrateur']) )
        {
            if ( typeMyql2Sql($liste_colonnes['utilisateur_Administrateur']['Type'])!='BOOL' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('utilisateur').' CHANGE utilisateur_Administrateur utilisateur_Administrateur BOOL;', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['utilisateur_Administrateur']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('utilisateur').' ADD utilisateur_Administrateur BOOL;', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE '.inst('utilisateur').' SET utilisateur_Administrateur=' . format_sql('utilisateur_Administrateur', $mf_initialisation['utilisateur_Administrateur']) . ';', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if ( isset($liste_colonnes['utilisateur_Developpeur']) )
        {
            if ( typeMyql2Sql($liste_colonnes['utilisateur_Developpeur']['Type'])!='BOOL' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('utilisateur').' CHANGE utilisateur_Developpeur utilisateur_Developpeur BOOL;', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['utilisateur_Developpeur']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('utilisateur').' ADD utilisateur_Developpeur BOOL;', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE '.inst('utilisateur').' SET utilisateur_Developpeur=' . format_sql('utilisateur_Developpeur', $mf_initialisation['utilisateur_Developpeur']) . ';', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if ( isset($liste_colonnes['mf_signature']) )
        {
            unset($liste_colonnes['mf_signature']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('utilisateur').' ADD mf_signature VARCHAR(255);', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('ALTER TABLE '.inst('utilisateur').' ADD INDEX( mf_signature );', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if ( isset($liste_colonnes['mf_cle_unique']) )
        {
            unset($liste_colonnes['mf_cle_unique']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('utilisateur').' ADD mf_cle_unique VARCHAR(255);', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('ALTER TABLE '.inst('utilisateur').' ADD INDEX( mf_cle_unique );', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if ( isset($liste_colonnes['mf_date_creation']) )
        {
            unset($liste_colonnes['mf_date_creation']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('utilisateur').' ADD mf_date_creation DATETIME;', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('ALTER TABLE '.inst('utilisateur').' ADD INDEX( mf_date_creation );', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if ( isset($liste_colonnes['mf_date_modification']) )
        {
            unset($liste_colonnes['mf_date_modification']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('utilisateur').' ADD mf_date_modification DATETIME;', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('ALTER TABLE '.inst('utilisateur').' ADD INDEX( mf_date_modification );', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        unset($liste_colonnes['Code_utilisateur']);

        foreach ($liste_colonnes as $field => $value)
        {
            executer_requete_mysql('ALTER TABLE '.inst('utilisateur').' DROP COLUMN '.$field.';', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

    }

    public function mf_ajouter(string $utilisateur_Identifiant, string $utilisateur_Password, string $utilisateur_Email, bool $utilisateur_Administrateur, bool $utilisateur_Developpeur, ?bool $force = false)
    {
        if ($force === null) {
            $force = false;
        }
        $Code_utilisateur = 0;
        $code_erreur = 0;
        Hook_utilisateur::pre_controller($utilisateur_Identifiant, $utilisateur_Password, $utilisateur_Email, $utilisateur_Administrateur, $utilisateur_Developpeur);
        if (!$force)
        {
            if (!self::$maj_droits_ajouter_en_cours)
            {
                self::$maj_droits_ajouter_en_cours = true;
                Hook_utilisateur::hook_actualiser_les_droits_ajouter();
                self::$maj_droits_ajouter_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['utilisateur__AJOUTER']) ) $code_erreur = REFUS_UTILISATEUR__AJOUTER;
        elseif ( !Hook_utilisateur::autorisation_ajout($utilisateur_Identifiant, $utilisateur_Password, $utilisateur_Email, $utilisateur_Administrateur, $utilisateur_Developpeur) ) $code_erreur = REFUS_UTILISATEUR__AJOUT_BLOQUEE;
        elseif ( $this->rechercher_utilisateur_Identifiant($utilisateur_Identifiant)!=0 ) $code_erreur = ERR_UTILISATEUR__AJOUTER__UTILISATEUR_IDENTIFIANT_DOUBLON;
        elseif ( ACTIVER_CONNEXION_EMAIL && $this->rechercher_utilisateur_Email($utilisateur_Email)!=0 ) $code_erreur = ERR_UTILISATEUR__AJOUTER__UTILISATEUR_EMAIL_DOUBLON;
        else
        {
            Hook_utilisateur::data_controller($utilisateur_Identifiant, $utilisateur_Password, $utilisateur_Email, $utilisateur_Administrateur, $utilisateur_Developpeur);
            $mf_signature = text_sql(Hook_utilisateur::calcul_signature($utilisateur_Identifiant, $utilisateur_Email, $utilisateur_Administrateur, $utilisateur_Developpeur));
            $mf_cle_unique = text_sql(Hook_utilisateur::calcul_cle_unique($utilisateur_Identifiant, $utilisateur_Email, $utilisateur_Administrateur, $utilisateur_Developpeur));
            $utilisateur_Identifiant = text_sql($utilisateur_Identifiant);
            $salt = salt(100);
            $utilisateur_Password = md5($utilisateur_Password.$salt).':'.$salt;
            $utilisateur_Email = text_sql($utilisateur_Email);
            $utilisateur_Administrateur = ($utilisateur_Administrateur==1 ? 1 : 0);
            $utilisateur_Developpeur = ($utilisateur_Developpeur==1 ? 1 : 0);
            $requete = "INSERT INTO ".inst('utilisateur')." ( mf_signature, mf_cle_unique, mf_date_creation, mf_date_modification, utilisateur_Identifiant, utilisateur_Password, utilisateur_Email, utilisateur_Administrateur, utilisateur_Developpeur ) VALUES ( '$mf_signature', '$mf_cle_unique', '".get_now()."', '".get_now()."', '$utilisateur_Identifiant', '$utilisateur_Password', '$utilisateur_Email', $utilisateur_Administrateur, $utilisateur_Developpeur );";
            executer_requete_mysql($requete, array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            $Code_utilisateur = requete_mysql_insert_id();
            if ($Code_utilisateur==0)
            {
                $code_erreur = ERR_UTILISATEUR__AJOUTER__AJOUT_REFUSE;
            } else {
                self::$cache_db->clear();
                Hook_utilisateur::ajouter( $Code_utilisateur );
            }
        }
        if ($code_erreur != 0) {
            global $mf_message_erreur_personalise, $mf_libelle_erreur;
            if ($mf_message_erreur_personalise != '') {
                $mf_libelle_erreur[$code_erreur] = $mf_message_erreur_personalise;
                $mf_message_erreur_personalise = '';
            }
        }
        return array('code_erreur' => $code_erreur, 'Code_utilisateur' => $Code_utilisateur, 'callback' => ( $code_erreur==0 ? Hook_utilisateur::callback_post($Code_utilisateur) : null ));
    }

    public function mf_ajouter_2(array $ligne, bool $force = null) // array('colonne1' => 'valeur1',  [...] )
    {
        if ($force === null) {
            $force = false;
        }
        global $mf_initialisation;
        $utilisateur_Identifiant = (string)(isset($ligne['utilisateur_Identifiant'])?$ligne['utilisateur_Identifiant']:$mf_initialisation['utilisateur_Identifiant']);
        $utilisateur_Password = (string)(isset($ligne['utilisateur_Password'])?$ligne['utilisateur_Password']:$mf_initialisation['utilisateur_Password']);
        $utilisateur_Email = (string)(isset($ligne['utilisateur_Email'])?$ligne['utilisateur_Email']:$mf_initialisation['utilisateur_Email']);
        $utilisateur_Administrateur = (bool)(isset($ligne['utilisateur_Administrateur'])?$ligne['utilisateur_Administrateur']:$mf_initialisation['utilisateur_Administrateur']);
        $utilisateur_Developpeur = (bool)(isset($ligne['utilisateur_Developpeur'])?$ligne['utilisateur_Developpeur']:$mf_initialisation['utilisateur_Developpeur']);
        return $this->mf_ajouter($utilisateur_Identifiant, $utilisateur_Password, $utilisateur_Email, $utilisateur_Administrateur, $utilisateur_Developpeur, $force);
    }

    public function mf_ajouter_3(array $lignes) // array( array( 'colonne1' => 'valeur1', 'colonne2' => 'valeur2',  [...] ), [...] )
    {
        global $mf_initialisation;
        $code_erreur = 0;
        $values = '';
        foreach ($lignes as $ligne)
        {
            $utilisateur_Identifiant = text_sql(isset($ligne['utilisateur_Identifiant'])?$ligne['utilisateur_Identifiant']:$mf_initialisation['utilisateur_Identifiant']);
            $salt = salt(100);
            $utilisateur_Password = md5(isset($ligne['utilisateur_Password'])?$ligne['utilisateur_Password']:$mf_initialisation['utilisateur_Password'].$salt).':'.$salt;
            $utilisateur_Email = text_sql(isset($ligne['utilisateur_Email'])?$ligne['utilisateur_Email']:$mf_initialisation['utilisateur_Email']);
            $utilisateur_Administrateur = (isset($ligne['utilisateur_Administrateur'])?$ligne['utilisateur_Administrateur']:$mf_initialisation['utilisateur_Administrateur']==1 ? 1 : 0);
            $utilisateur_Developpeur = (isset($ligne['utilisateur_Developpeur'])?$ligne['utilisateur_Developpeur']:$mf_initialisation['utilisateur_Developpeur']==1 ? 1 : 0);
            $values .= ($values!="" ? "," : "")."('$utilisateur_Identifiant', '$utilisateur_Password', '$utilisateur_Email', $utilisateur_Administrateur, $utilisateur_Developpeur)";
        }
        if ($values!='')
        {
            $requete = "INSERT INTO ".inst('utilisateur')." ( utilisateur_Identifiant, utilisateur_Password, utilisateur_Email, utilisateur_Administrateur, utilisateur_Developpeur ) VALUES $values;";
            executer_requete_mysql( $requete , array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            $n = requete_mysqli_affected_rows();
            if ($n < count($lignes))
            {
                $code_erreur = ERR_UTILISATEUR__AJOUTER_3__ECHEC_AJOUT;
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

    public function mf_actualiser_signature(int $Code_utilisateur)
    {
        $utilisateur = $this->mf_get_2($Code_utilisateur, array('autocompletion' => false));
        $mf_signature = text_sql(Hook_utilisateur::calcul_signature($utilisateur['utilisateur_Identifiant'], $utilisateur['utilisateur_Email'], $utilisateur['utilisateur_Administrateur'], $utilisateur['utilisateur_Developpeur']));
        $mf_cle_unique = text_sql(Hook_utilisateur::calcul_cle_unique($utilisateur['utilisateur_Identifiant'], $utilisateur['utilisateur_Email'], $utilisateur['utilisateur_Administrateur'], $utilisateur['utilisateur_Developpeur']));
        $table = inst('utilisateur');
        executer_requete_mysql("UPDATE $table SET mf_signature='$mf_signature', mf_cle_unique='$mf_cle_unique' WHERE Code_utilisateur=$Code_utilisateur;", array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        if (requete_mysqli_affected_rows() == 1) {
            self::$cache_db->clear();
        }
    }

    public function mf_modifier( int $Code_utilisateur, string $utilisateur_Identifiant, string $utilisateur_Password, string $utilisateur_Email, bool $utilisateur_Administrateur, bool $utilisateur_Developpeur, ?bool $force = null)
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        $Code_utilisateur = round($Code_utilisateur);
        Hook_utilisateur::pre_controller($utilisateur_Identifiant, $utilisateur_Password, $utilisateur_Email, $utilisateur_Administrateur, $utilisateur_Developpeur, $Code_utilisateur);
        if (!$force)
        {
            if (!self::$maj_droits_modifier_en_cours)
            {
                self::$maj_droits_modifier_en_cours = true;
                Hook_utilisateur::hook_actualiser_les_droits_modifier($Code_utilisateur);
                self::$maj_droits_modifier_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['utilisateur__MODIFIER']) ) $code_erreur = REFUS_UTILISATEUR__MODIFIER;
        elseif ( !$this->mf_tester_existance_Code_utilisateur($Code_utilisateur) ) $code_erreur = ERR_UTILISATEUR__MODIFIER__CODE_UTILISATEUR_INEXISTANT;
        elseif (CONTROLE_ACCES_DONNEES_DEFAUT && ! Hook_mf_systeme::controle_acces_donnees('Code_utilisateur', $Code_utilisateur)) $code_erreur = ACCES_CODE_UTILISATEUR_REFUSE;
        elseif ( !Hook_utilisateur::autorisation_modification($Code_utilisateur, $utilisateur_Identifiant, $utilisateur_Password, $utilisateur_Email, $utilisateur_Administrateur, $utilisateur_Developpeur) ) $code_erreur = REFUS_UTILISATEUR__MODIFICATION_BLOQUEE;
        elseif ($this->rechercher_utilisateur_Identifiant($utilisateur_Identifiant) != 0 && $this->rechercher_utilisateur_Identifiant($utilisateur_Identifiant)!=$Code_utilisateur) $code_erreur = ERR_UTILISATEUR__AJOUTER__UTILISATEUR_IDENTIFIANT_DOUBLON;
        else
        {
            if (! isset(self::$lock[$Code_utilisateur])) {
                self::$lock[$Code_utilisateur] = 0;
            }
            if (self::$lock[$Code_utilisateur] == 0) {
                self::$cache_db->add_lock($Code_utilisateur);
            }
            self::$lock[$Code_utilisateur]++;
            Hook_utilisateur::data_controller($utilisateur_Identifiant, $utilisateur_Password, $utilisateur_Email, $utilisateur_Administrateur, $utilisateur_Developpeur, $Code_utilisateur);
            $utilisateur = $this->mf_get_2( $Code_utilisateur, array('autocompletion' => false, 'masquer_mdp' => false) );
            $mf_colonnes_a_modifier=[];
            $bool__utilisateur_Identifiant = false; if ( $utilisateur_Identifiant!=$utilisateur['utilisateur_Identifiant'] ) { Hook_utilisateur::data_controller__utilisateur_Identifiant($utilisateur['utilisateur_Identifiant'], $utilisateur_Identifiant, $Code_utilisateur); if ( $utilisateur_Identifiant!=$utilisateur['utilisateur_Identifiant'] ) { $mf_colonnes_a_modifier[] = 'utilisateur_Identifiant=' . format_sql('utilisateur_Identifiant', $utilisateur_Identifiant); $bool__utilisateur_Identifiant = true; } }
            $bool__utilisateur_Password = false; if ( $utilisateur_Password!='' ) { $mf_colonnes_a_modifier[] = 'utilisateur_Password = ' . format_sql('utilisateur_Password', $utilisateur_Password); $bool__utilisateur_Password = true; }
            $bool__utilisateur_Email = false; if ( $utilisateur_Email!=$utilisateur['utilisateur_Email'] ) { Hook_utilisateur::data_controller__utilisateur_Email($utilisateur['utilisateur_Email'], $utilisateur_Email, $Code_utilisateur); if ( $utilisateur_Email!=$utilisateur['utilisateur_Email'] ) { $mf_colonnes_a_modifier[] = 'utilisateur_Email=' . format_sql('utilisateur_Email', $utilisateur_Email); $bool__utilisateur_Email = true; } }
            $bool__utilisateur_Administrateur = false; if ( $utilisateur_Administrateur!=$utilisateur['utilisateur_Administrateur'] ) { Hook_utilisateur::data_controller__utilisateur_Administrateur($utilisateur['utilisateur_Administrateur'], $utilisateur_Administrateur, $Code_utilisateur); if ( $utilisateur_Administrateur!=$utilisateur['utilisateur_Administrateur'] ) { $mf_colonnes_a_modifier[] = 'utilisateur_Administrateur=' . format_sql('utilisateur_Administrateur', $utilisateur_Administrateur); $bool__utilisateur_Administrateur = true; } }
            $bool__utilisateur_Developpeur = false; if ( $utilisateur_Developpeur!=$utilisateur['utilisateur_Developpeur'] ) { Hook_utilisateur::data_controller__utilisateur_Developpeur($utilisateur['utilisateur_Developpeur'], $utilisateur_Developpeur, $Code_utilisateur); if ( $utilisateur_Developpeur!=$utilisateur['utilisateur_Developpeur'] ) { $mf_colonnes_a_modifier[] = 'utilisateur_Developpeur=' . format_sql('utilisateur_Developpeur', $utilisateur_Developpeur); $bool__utilisateur_Developpeur = true; } }
            if (count($mf_colonnes_a_modifier) > 0) {
                $mf_signature = text_sql(Hook_utilisateur::calcul_signature($utilisateur_Identifiant, $utilisateur_Email, $utilisateur_Administrateur, $utilisateur_Developpeur));
                $mf_cle_unique = text_sql(Hook_utilisateur::calcul_cle_unique($utilisateur_Identifiant, $utilisateur_Email, $utilisateur_Administrateur, $utilisateur_Developpeur));
                $mf_colonnes_a_modifier[] = 'mf_signature=\'' . $mf_signature . '\'';
                $mf_colonnes_a_modifier[] = 'mf_cle_unique=\'' . $mf_cle_unique . '\'';
                $mf_colonnes_a_modifier[] = 'mf_date_modification=\'' . get_now() . '\'';
                $requete = 'UPDATE '.inst('utilisateur').' SET ' . enumeration($mf_colonnes_a_modifier) . ' WHERE Code_utilisateur = ' . $Code_utilisateur . ';';
                executer_requete_mysql($requete, array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
                if (requete_mysqli_affected_rows() == 0) {
                    $code_erreur = ERR_UTILISATEUR__MODIFIER__AUCUN_CHANGEMENT;
                } else {
                    self::$cache_db->clear();
                    Hook_utilisateur::modifier($Code_utilisateur, $bool__utilisateur_Identifiant, $bool__utilisateur_Password, $bool__utilisateur_Email, $bool__utilisateur_Administrateur, $bool__utilisateur_Developpeur);
                }
            } else {
                $code_erreur = ERR_UTILISATEUR__MODIFIER__AUCUN_CHANGEMENT;
            }
            self::$lock[$Code_utilisateur]--;
            if (self::$lock[$Code_utilisateur] == 0) {
                self::$cache_db->release_lock($Code_utilisateur);
                unset(self::$lock[$Code_utilisateur]);
            }
        }
        if ($code_erreur != 0) {
            global $mf_message_erreur_personalise, $mf_libelle_erreur;
            if ($mf_message_erreur_personalise != '') {
                $mf_libelle_erreur[$code_erreur] = $mf_message_erreur_personalise;
                $mf_message_erreur_personalise = '';
            }
        }
        return array('code_erreur' => $code_erreur, 'callback' => ( $code_erreur == 0 ? Hook_utilisateur::callback_put($Code_utilisateur) : null ));
    }

    public function mf_modifier_2(array $lignes, ?bool $force = null) // array( $Code_utilisateur => array('colonne1' => 'valeur1',  [...] ) )
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        foreach ( $lignes as $Code_utilisateur => $colonnes )
        {
            if ( $code_erreur==0 )
            {
                $Code_utilisateur = (int) round($Code_utilisateur);
                $utilisateur = $this->mf_get_2($Code_utilisateur, array('autocompletion' => false));
                if (!$force)
                {
                    if (!self::$maj_droits_modifier_en_cours)
                    {
                        self::$maj_droits_modifier_en_cours = true;
                        Hook_utilisateur::hook_actualiser_les_droits_modifier($Code_utilisateur);
                        self::$maj_droits_modifier_en_cours = false;
                    }
                }
                $utilisateur_Identifiant = (string) ( isset($colonnes['utilisateur_Identifiant']) && ( $force || mf_matrice_droits(['api_modifier__utilisateur_Identifiant', 'utilisateur__MODIFIER']) ) ? $colonnes['utilisateur_Identifiant'] : ( isset($utilisateur['utilisateur_Identifiant']) ? $utilisateur['utilisateur_Identifiant'] : '' ) );
                $utilisateur_Password = (string) ( isset($colonnes['utilisateur_Password']) && ( $force || mf_matrice_droits(['api_modifier__utilisateur_Password', 'utilisateur__MODIFIER']) ) ? $colonnes['utilisateur_Password'] : '' );
                $utilisateur_Email = (string) ( isset($colonnes['utilisateur_Email']) && ( $force || mf_matrice_droits(['api_modifier__utilisateur_Email', 'utilisateur__MODIFIER']) ) ? $colonnes['utilisateur_Email'] : ( isset($utilisateur['utilisateur_Email']) ? $utilisateur['utilisateur_Email'] : '' ) );
                $utilisateur_Administrateur = (bool) ( isset($colonnes['utilisateur_Administrateur']) && ( $force || mf_matrice_droits(['api_modifier__utilisateur_Administrateur', 'utilisateur__MODIFIER']) ) ? $colonnes['utilisateur_Administrateur'] : ( isset($utilisateur['utilisateur_Administrateur']) ? $utilisateur['utilisateur_Administrateur'] : '' ) );
                $utilisateur_Developpeur = (bool) ( isset($colonnes['utilisateur_Developpeur']) && ( $force || mf_matrice_droits(['api_modifier__utilisateur_Developpeur', 'utilisateur__MODIFIER']) ) ? $colonnes['utilisateur_Developpeur'] : ( isset($utilisateur['utilisateur_Developpeur']) ? $utilisateur['utilisateur_Developpeur'] : '' ) );
                $retour = $this->mf_modifier($Code_utilisateur, $utilisateur_Identifiant, $utilisateur_Password, $utilisateur_Email, $utilisateur_Administrateur, $utilisateur_Developpeur, true);
                if ($retour['code_erreur'] != 0 && $retour['code_erreur'] != ERR_UTILISATEUR__MODIFIER__AUCUN_CHANGEMENT) {
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

    public function mf_modifier_3(array $lignes) // array( $Code_utilisateur => array('colonne1' => 'valeur1',  [...] ) )
    {
        $code_erreur = 0;
        $modifs = false;

        // transformation des lignes en colonnes
        $valeurs_en_colonnes=array();
        $indices_par_colonne=array();
        $liste_valeurs_indexees=array();
        foreach ( $lignes as $Code_utilisateur => $colonnes )
        {
            foreach ($colonnes as $colonne => $valeur)
            {
                if ( $colonne=='utilisateur_Identifiant' || $colonne=='utilisateur_Password' || $colonne=='utilisateur_Email' || $colonne=='utilisateur_Administrateur' || $colonne=='utilisateur_Developpeur' )
                {
                    $valeurs_en_colonnes[$colonne][$Code_utilisateur]=$valeur;
                    $indices_par_colonne[$colonne][]=$Code_utilisateur;
                    $liste_valeurs_indexees[$colonne][''.$valeur][]=$Code_utilisateur;
                }
            }
        }

        // fabrication des requetes
        foreach ( $valeurs_en_colonnes as $colonne => $valeurs )
        {
            if ( count($liste_valeurs_indexees[$colonne]) > 3 )
            {
                $modification_sql = $colonne . ' = CASE Code_utilisateur';
                foreach ( $valeurs as $Code_utilisateur => $valeur )
                {
                    $modification_sql .= ' WHEN ' . $Code_utilisateur . ' THEN ' . format_sql($colonne, $valeur);
                }
                $modification_sql .= ' END';
                $perimetre = Sql_Format_Liste($indices_par_colonne[$colonne]);
                executer_requete_mysql('UPDATE ' . inst('utilisateur') . ' SET ' . $modification_sql . ' WHERE Code_utilisateur IN ' . $perimetre . ';', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
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
                    executer_requete_mysql('UPDATE ' . inst('utilisateur') . ' SET ' . $colonne . ' = ' . format_sql($colonne, $valeur) . ' WHERE Code_utilisateur IN ' . $perimetre . ';', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
                    if ( requete_mysqli_affected_rows()!=0 )
                    {
                        $modifs = true;
                    }
                }
            }
        }

        if ( ! $modifs && $code_erreur==0 )
        {
            $code_erreur = ERR_UTILISATEUR__MODIFIER_3__AUCUN_CHANGEMENT;
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
        if ( isset($data['utilisateur_Identifiant']) ) { $mf_colonnes_a_modifier[] = 'utilisateur_Identifiant = ' . format_sql('utilisateur_Identifiant', $data['utilisateur_Identifiant']); }
        if ( isset($data['utilisateur_Password']) ) { $mf_colonnes_a_modifier[] = 'utilisateur_Password = ' . format_sql('utilisateur_Password', $data['utilisateur_Password']); }
        if ( isset($data['utilisateur_Email']) ) { $mf_colonnes_a_modifier[] = 'utilisateur_Email = ' . format_sql('utilisateur_Email', $data['utilisateur_Email']); }
        if ( isset($data['utilisateur_Administrateur']) ) { $mf_colonnes_a_modifier[] = 'utilisateur_Administrateur = ' . format_sql('utilisateur_Administrateur', $data['utilisateur_Administrateur']); }
        if ( isset($data['utilisateur_Developpeur']) ) { $mf_colonnes_a_modifier[] = 'utilisateur_Developpeur = ' . format_sql('utilisateur_Developpeur', $data['utilisateur_Developpeur']); }
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

            $requete = 'UPDATE ' . inst('utilisateur') . ' SET ' . enumeration($mf_colonnes_a_modifier) . " WHERE 1$argument_cond" . ( $limit>0 ? ' LIMIT ' . $limit : '' ) . ";";
            executer_requete_mysql( $requete , array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_UTILISATEUR__MODIFIER_4__AUCUN_CHANGEMENT;
            } else {
                self::$cache_db->clear();
            }
        }
        return array('code_erreur' => $code_erreur);
    }

    public function mf_supprimer(int $Code_utilisateur, ?bool $force = null)
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        $Code_utilisateur = round($Code_utilisateur);
        if (! $force) {
            if (!self::$maj_droits_supprimer_en_cours)
            {
                self::$maj_droits_supprimer_en_cours = true;
                Hook_utilisateur::hook_actualiser_les_droits_supprimer($Code_utilisateur);
                self::$maj_droits_supprimer_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['utilisateur__SUPPRIMER']) ) $code_erreur = REFUS_UTILISATEUR__SUPPRIMER;
        elseif (! $this->mf_tester_existance_Code_utilisateur($Code_utilisateur) ) $code_erreur = ERR_UTILISATEUR__SUPPRIMER_2__CODE_UTILISATEUR_INEXISTANT;
        elseif (CONTROLE_ACCES_DONNEES_DEFAUT && ! Hook_mf_systeme::controle_acces_donnees('Code_utilisateur', $Code_utilisateur)) $code_erreur = ACCES_CODE_UTILISATEUR_REFUSE;
        elseif ( !Hook_utilisateur::autorisation_suppression($Code_utilisateur) ) $code_erreur = REFUS_UTILISATEUR__SUPPRESSION_BLOQUEE;
        else
        {
            $copie__utilisateur = $this->mf_get($Code_utilisateur, array('autocompletion' => false));
            $this->supprimer_donnes_en_cascade("utilisateur", array($Code_utilisateur));
            $requete = 'DELETE IGNORE FROM ' . inst('utilisateur') . ' WHERE Code_utilisateur=' . $Code_utilisateur . ';';
            executer_requete_mysql($requete, array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            if (requete_mysqli_affected_rows() == 0) {
                $code_erreur = ERR_UTILISATEUR__SUPPRIMER__REFUSEE;
            } else {
                self::$cache_db->clear();
                Hook_utilisateur::supprimer($copie__utilisateur);
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

    public function mf_supprimer_2(array $liste_Code_utilisateur, ?bool $force = null)
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        $copie__liste_utilisateur = $this->mf_lister_2($liste_Code_utilisateur, array('autocompletion' => false));
        $liste_Code_utilisateur=array();
        foreach ( $copie__liste_utilisateur as $copie__utilisateur )
        {
            $Code_utilisateur = $copie__utilisateur['Code_utilisateur'];
            if (!$force)
            {
                if (!self::$maj_droits_supprimer_en_cours)
                {
                    self::$maj_droits_supprimer_en_cours = true;
                    Hook_utilisateur::hook_actualiser_les_droits_supprimer($Code_utilisateur);
                    self::$maj_droits_supprimer_en_cours = false;
                }
            }
            if ( !$force && !mf_matrice_droits(['utilisateur__SUPPRIMER']) ) $code_erreur = REFUS_UTILISATEUR__SUPPRIMER;
            elseif ( !Hook_utilisateur::autorisation_suppression($Code_utilisateur) ) $code_erreur = REFUS_UTILISATEUR__SUPPRESSION_BLOQUEE;
            {
                $liste_Code_utilisateur[] = $Code_utilisateur;
            }
        }
        if ( $code_erreur==0 && count($liste_Code_utilisateur)>0 )
        {
            $this->supprimer_donnes_en_cascade("utilisateur", $liste_Code_utilisateur);
            $requete = 'DELETE IGNORE FROM ' . inst('utilisateur') . ' WHERE Code_utilisateur IN ' . Sql_Format_Liste($liste_Code_utilisateur) . ';';
            executer_requete_mysql( $requete , array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            if (requete_mysqli_affected_rows() == 0) {
                $code_erreur = ERR_UTILISATEUR__SUPPRIMER_2__REFUSEE;
            } else {
                self::$cache_db->clear();
                Hook_utilisateur::supprimer_2($copie__liste_utilisateur);
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

    public function mf_supprimer_3(array $liste_Code_utilisateur)
    {
        $code_erreur=0;
        if ( count($liste_Code_utilisateur)>0 )
        {
            $this->supprimer_donnes_en_cascade("utilisateur", $liste_Code_utilisateur);
            $requete = 'DELETE IGNORE FROM ' . inst('utilisateur') . ' WHERE Code_utilisateur IN ' . Sql_Format_Liste($liste_Code_utilisateur) . ';';
            executer_requete_mysql( $requete , array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            if (requete_mysqli_affected_rows() == 0) {
                $code_erreur = ERR_UTILISATEUR__SUPPRIMER_3__REFUSEE;
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
        if (! $contexte_parent && $mf_contexte['Code_utilisateur'] != 0) {
            $utilisateur = $this->mf_get( $mf_contexte['Code_utilisateur'], $options);
            return array( $utilisateur['Code_utilisateur'] => $utilisateur );
        } else {
            return $this->mf_lister($options);
        }
    }

    public function mf_lister(?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cle = "utilisateur__lister";

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
            if ( isset($mf_tri_defaut_table['utilisateur']) )
            {
                $options['tris'] = $mf_tri_defaut_table['utilisateur'];
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
                    if ( strpos($argument_cond, 'utilisateur_Identifiant')!==false ) { $liste_colonnes_a_indexer['utilisateur_Identifiant'] = 'utilisateur_Identifiant'; }
                    if ( strpos($argument_cond, 'utilisateur_Password')!==false ) { $liste_colonnes_a_indexer['utilisateur_Password'] = 'utilisateur_Password'; }
                    if ( strpos($argument_cond, 'utilisateur_Email')!==false ) { $liste_colonnes_a_indexer['utilisateur_Email'] = 'utilisateur_Email'; }
                    if ( strpos($argument_cond, 'utilisateur_Administrateur')!==false ) { $liste_colonnes_a_indexer['utilisateur_Administrateur'] = 'utilisateur_Administrateur'; }
                    if ( strpos($argument_cond, 'utilisateur_Developpeur')!==false ) { $liste_colonnes_a_indexer['utilisateur_Developpeur'] = 'utilisateur_Developpeur'; }
                }
                if (isset($options['tris'])) {
                    if ( isset($options['tris']['utilisateur_Identifiant']) ) { $liste_colonnes_a_indexer['utilisateur_Identifiant'] = 'utilisateur_Identifiant'; }
                    if ( isset($options['tris']['utilisateur_Password']) ) { $liste_colonnes_a_indexer['utilisateur_Password'] = 'utilisateur_Password'; }
                    if ( isset($options['tris']['utilisateur_Email']) ) { $liste_colonnes_a_indexer['utilisateur_Email'] = 'utilisateur_Email'; }
                    if ( isset($options['tris']['utilisateur_Administrateur']) ) { $liste_colonnes_a_indexer['utilisateur_Administrateur'] = 'utilisateur_Administrateur'; }
                    if ( isset($options['tris']['utilisateur_Developpeur']) ) { $liste_colonnes_a_indexer['utilisateur_Developpeur'] = 'utilisateur_Developpeur'; }
                }
                if (count($liste_colonnes_a_indexer) > 0) {
                    if (false === $mf_liste_requete_index = self::$cache_db->read('utilisateur__index')) {
                        $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('utilisateur').'`;', false);
                        $mf_liste_requete_index = array();
                        while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                            $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                        }
                        mysqli_free_result($res_requete_index);
                        self::$cache_db->write('utilisateur__index', $mf_liste_requete_index);
                    }
                    foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                        if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                    }
                    if (count($liste_colonnes_a_indexer) > 0) {
                        foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                            executer_requete_mysql('ALTER TABLE `'.inst('utilisateur').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                        }
                        self::$cache_db->clear();
                    }
                }

                $liste = array();
                $liste_utilisateur_pas_a_jour = array();
                if ($toutes_colonnes)
                {
                    $colonnes='Code_utilisateur, utilisateur_Identifiant, utilisateur_Password, utilisateur_Email, utilisateur_Administrateur, utilisateur_Developpeur';
                }
                else
                {
                    $colonnes='Code_utilisateur, utilisateur_Identifiant, utilisateur_Password, utilisateur_Email, utilisateur_Administrateur, utilisateur_Developpeur';
                }
                $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM ' . inst('utilisateur')." WHERE 1{$argument_cond}{$argument_tris}{$argument_limit};", false);
                while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                {
                    unset($row_requete['utilisateur_Password']);
                    mf_formatage_db_type_php($row_requete);
                    $liste[$row_requete['Code_utilisateur']] = $row_requete;
                    if ( $maj && ! Hook_utilisateur::est_a_jour( $row_requete ) )
                    {
                        $liste_utilisateur_pas_a_jour[$row_requete['Code_utilisateur']] = $row_requete;
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
                Hook_utilisateur::mettre_a_jour( $liste_utilisateur_pas_a_jour );
            }
        }

        foreach ($liste as $elem)
        {
            if ( $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_utilisateur', $elem['Code_utilisateur']) )
            {
                unset($liste[$elem['Code_utilisateur']]);
            }
            else
            {
                if (($autocompletion_recursive || self::$auto_completion < 1) && $autocompletion) {
                    self::$auto_completion ++;
                    Hook_utilisateur::completion($liste[$elem['Code_utilisateur']], self::$auto_completion - 1);
                    self::$auto_completion --;
                }
            }
        }

        return $liste;
    }

    public function mf_lister_2(array $liste_Code_utilisateur, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        if (count($liste_Code_utilisateur) > 0) {
            $cle = "utilisateur__mf_lister_2_".Sql_Format_Liste($liste_Code_utilisateur);

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
                if ( isset($mf_tri_defaut_table['utilisateur']) )
                {
                    $options['tris'] = $mf_tri_defaut_table['utilisateur'];
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
                        if ( strpos($argument_cond, 'utilisateur_Identifiant')!==false ) { $liste_colonnes_a_indexer['utilisateur_Identifiant'] = 'utilisateur_Identifiant'; }
                        if ( strpos($argument_cond, 'utilisateur_Password')!==false ) { $liste_colonnes_a_indexer['utilisateur_Password'] = 'utilisateur_Password'; }
                        if ( strpos($argument_cond, 'utilisateur_Email')!==false ) { $liste_colonnes_a_indexer['utilisateur_Email'] = 'utilisateur_Email'; }
                        if ( strpos($argument_cond, 'utilisateur_Administrateur')!==false ) { $liste_colonnes_a_indexer['utilisateur_Administrateur'] = 'utilisateur_Administrateur'; }
                        if ( strpos($argument_cond, 'utilisateur_Developpeur')!==false ) { $liste_colonnes_a_indexer['utilisateur_Developpeur'] = 'utilisateur_Developpeur'; }
                    }
                    if (isset($options['tris'])) {
                        if ( isset($options['tris']['utilisateur_Identifiant']) ) { $liste_colonnes_a_indexer['utilisateur_Identifiant'] = 'utilisateur_Identifiant'; }
                        if ( isset($options['tris']['utilisateur_Password']) ) { $liste_colonnes_a_indexer['utilisateur_Password'] = 'utilisateur_Password'; }
                        if ( isset($options['tris']['utilisateur_Email']) ) { $liste_colonnes_a_indexer['utilisateur_Email'] = 'utilisateur_Email'; }
                        if ( isset($options['tris']['utilisateur_Administrateur']) ) { $liste_colonnes_a_indexer['utilisateur_Administrateur'] = 'utilisateur_Administrateur'; }
                        if ( isset($options['tris']['utilisateur_Developpeur']) ) { $liste_colonnes_a_indexer['utilisateur_Developpeur'] = 'utilisateur_Developpeur'; }
                    }
                    if (count($liste_colonnes_a_indexer) > 0) {
                        if (false === $mf_liste_requete_index = self::$cache_db->read('utilisateur__index')) {
                            $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('utilisateur').'`;', false);
                            $mf_liste_requete_index = array();
                            while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                                $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                            }
                            mysqli_free_result($res_requete_index);
                            self::$cache_db->write('utilisateur__index', $mf_liste_requete_index);
                        }
                        foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                            if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                        }
                        if (count($liste_colonnes_a_indexer) > 0) {
                            foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                                executer_requete_mysql('ALTER TABLE `'.inst('utilisateur').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                            }
                            self::$cache_db->clear();
                        }
                    }

                    $liste = array();
                    $liste_utilisateur_pas_a_jour = array();
                    if ($toutes_colonnes) {
                        $colonnes='Code_utilisateur, utilisateur_Identifiant, utilisateur_Password, utilisateur_Email, utilisateur_Administrateur, utilisateur_Developpeur';
                    } else {
                        $colonnes='Code_utilisateur, utilisateur_Identifiant, utilisateur_Password, utilisateur_Email, utilisateur_Administrateur, utilisateur_Developpeur';
                    }
                    $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM ' . inst('utilisateur') . " WHERE 1{$argument_cond} AND Code_utilisateur IN ".Sql_Format_Liste($liste_Code_utilisateur)."{$argument_tris}{$argument_limit};", false);
                    while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                        unset($row_requete['utilisateur_Password']);
                        mf_formatage_db_type_php($row_requete);
                        $liste[$row_requete['Code_utilisateur']] = $row_requete;
                        if ($maj && ! Hook_utilisateur::est_a_jour($row_requete)) {
                            $liste_utilisateur_pas_a_jour[$row_requete['Code_utilisateur']] = $row_requete;
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
                    Hook_utilisateur::mettre_a_jour( $liste_utilisateur_pas_a_jour );
                }
            }

            foreach ($liste as $elem) {
                if ( $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_utilisateur', $elem['Code_utilisateur']) )
                {
                    unset($liste[$elem['Code_utilisateur']]);
                }
                else
                {
                    if (($autocompletion_recursive || self::$auto_completion < 1) && $autocompletion) {
                        self::$auto_completion ++;
                        Hook_utilisateur::completion($liste[$elem['Code_utilisateur']], self::$auto_completion - 1);
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

    public function mf_get(int $Code_utilisateur, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $masquer_mdp = true;
        if ( isset($options['masquer_mdp']) )
        {
            $masquer_mdp = ( $options['masquer_mdp']==true );
        }
        $Code_utilisateur = round($Code_utilisateur);
        $retour = array();
        if ( ! CONTROLE_ACCES_DONNEES_DEFAUT || Hook_mf_systeme::controle_acces_donnees('Code_utilisateur', $Code_utilisateur) )
        {
            $cle = 'utilisateur__get_'.$Code_utilisateur.'_'.( $masquer_mdp ? 'masquer=1' : 'masquer=0' );

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
                        $colonnes='Code_utilisateur, utilisateur_Identifiant, utilisateur_Password, utilisateur_Email, utilisateur_Administrateur, utilisateur_Developpeur';
                    } else {
                        $colonnes='Code_utilisateur, utilisateur_Identifiant, utilisateur_Password, utilisateur_Email, utilisateur_Administrateur, utilisateur_Developpeur';
                    }
                    $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM ' . inst('utilisateur') . ' WHERE Code_utilisateur = ' . $Code_utilisateur . ';', false);
                    if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                    {
                        if ( $masquer_mdp )
                        {
                            unset($row_requete['utilisateur_Password']);
                        }
                        mf_formatage_db_type_php($row_requete);
                        $retour = $row_requete;
                        if ( $maj && ! Hook_utilisateur::est_a_jour( $row_requete ) )
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
                    Hook_utilisateur::mettre_a_jour( array( $row_requete['Code_utilisateur'] => $row_requete ) );
                }
            }
            if ( isset( $retour['Code_utilisateur'] ) )
            {
                if (($autocompletion_recursive || self::$auto_completion < 1) && $autocompletion) {
                    self::$auto_completion ++;
                    Hook_utilisateur::completion($retour, self::$auto_completion - 1);
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
        $cle = "utilisateur__get_last";
        if (false === $retour = self::$cache_db->read($cle)) {
            $Code_utilisateur = 0;
            $res_requete = executer_requete_mysql('SELECT Code_utilisateur FROM ' . inst('utilisateur') . " WHERE 1 ORDER BY mf_date_creation DESC, Code_utilisateur DESC LIMIT 0 , 1;", false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $Code_utilisateur = $row_requete['Code_utilisateur'];
            }
            mysqli_free_result($res_requete);
            $retour = $this->mf_get($Code_utilisateur, $options);
            self::$cache_db->write($cle, $retour);
        }
        return $retour;
    }

    protected function mf_get_connexion(int $Code_utilisateur, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $Code_utilisateur = round($Code_utilisateur);
        $cle = "utilisateur__get_connexion_{$Code_utilisateur}";

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
                $colonnes='Code_utilisateur, utilisateur_Identifiant, utilisateur_Password, utilisateur_Email, utilisateur_Administrateur, utilisateur_Developpeur';
            } else {
                $colonnes='Code_utilisateur, utilisateur_Identifiant, utilisateur_Password, utilisateur_Email, utilisateur_Administrateur, utilisateur_Developpeur';
            }
            $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM ' . inst('utilisateur') . ' WHERE Code_utilisateur = ' . $Code_utilisateur . ';', false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                mf_formatage_db_type_php($row_requete);
                $retour = $row_requete;
            } else {
                $retour = array();
            }
            mysqli_free_result($res_requete);
            self::$cache_db->write($cle, $retour);
        }
        if (isset($retour['Code_utilisateur'])) {
            if (($autocompletion_recursive || self::$auto_completion < 1) && $autocompletion) {
                self::$auto_completion ++;
                Hook_utilisateur::completion($retour, self::$auto_completion - 1);
                self::$auto_completion --;
            }
        }
        return $retour;
    }

    public function mf_get_2(int $Code_utilisateur, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $masquer_mdp = true;
        if ( isset($options['masquer_mdp']) )
        {
            $masquer_mdp = ( $options['masquer_mdp']==true );
        }
        $Code_utilisateur = round($Code_utilisateur);
        $retour = array();
        $cle = 'utilisateur__get_'.$Code_utilisateur.'_'.( $masquer_mdp ? 'masquer=1' : 'masquer=0' );

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
                $colonnes='Code_utilisateur, utilisateur_Identifiant, utilisateur_Password, utilisateur_Email, utilisateur_Administrateur, utilisateur_Developpeur';
            } else {
                $colonnes='Code_utilisateur, utilisateur_Identifiant, utilisateur_Password, utilisateur_Email, utilisateur_Administrateur, utilisateur_Developpeur';
            }
            $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM ' . inst('utilisateur') . ' WHERE Code_utilisateur = ' . $Code_utilisateur . ';', false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                if ($masquer_mdp) {
                    unset($row_requete['utilisateur_Password']);
                }
                mf_formatage_db_type_php($row_requete);
                $retour = $row_requete;
            } else {
                $retour = array();
            }
            mysqli_free_result($res_requete);
            self::$cache_db->write($cle, $retour);
        }
        if (isset($retour['Code_utilisateur'])) {
            if (($autocompletion_recursive || self::$auto_completion < 1) && $autocompletion) {
                self::$auto_completion ++;
                Hook_utilisateur::completion($retour, self::$auto_completion - 1);
                self::$auto_completion --;
            }
        }
        return $retour;
    }

    public function mf_prec_et_suiv( int $Code_utilisateur, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $Code_utilisateur = round($Code_utilisateur);
        $liste = $this->mf_lister($options);
        return prec_suiv($liste, $Code_utilisateur);
    }

    public function mf_compter(?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cle = 'utilisateur__compter';

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
                if ( strpos($argument_cond, 'utilisateur_Identifiant')!==false ) { $liste_colonnes_a_indexer['utilisateur_Identifiant'] = 'utilisateur_Identifiant'; }
                if ( strpos($argument_cond, 'utilisateur_Password')!==false ) { $liste_colonnes_a_indexer['utilisateur_Password'] = 'utilisateur_Password'; }
                if ( strpos($argument_cond, 'utilisateur_Email')!==false ) { $liste_colonnes_a_indexer['utilisateur_Email'] = 'utilisateur_Email'; }
                if ( strpos($argument_cond, 'utilisateur_Administrateur')!==false ) { $liste_colonnes_a_indexer['utilisateur_Administrateur'] = 'utilisateur_Administrateur'; }
                if ( strpos($argument_cond, 'utilisateur_Developpeur')!==false ) { $liste_colonnes_a_indexer['utilisateur_Developpeur'] = 'utilisateur_Developpeur'; }
            }
            if (count($liste_colonnes_a_indexer) > 0) {
                if (false === $mf_liste_requete_index = self::$cache_db->read('utilisateur__index')) {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('utilisateur').'`;', false);
                    $mf_liste_requete_index = array();
                    while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    self::$cache_db->write('utilisateur__index', $mf_liste_requete_index);
                }
                foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if (count($liste_colonnes_a_indexer) > 0) {
                    foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                        executer_requete_mysql('ALTER TABLE `'.inst('utilisateur').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    self::$cache_db->clear();
                }
            }

            $res_requete = executer_requete_mysql('SELECT count(Code_utilisateur) as nb FROM ' . inst('utilisateur')." WHERE 1{$argument_cond};", false);
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

    public function mf_liste_Code_utilisateur(?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ($options === null) {
            $options=[];
        }
        return $this->get_liste_Code_utilisateur($options);
    }

    public function mf_get_liste_tables_enfants()
    {
        return $this->get_liste_tables_enfants( 'utilisateur' );
    }

    public function mf_get_liste_tables_parents()
    {
        return array();
    }

    public function mf_search_utilisateur_Identifiant( string $utilisateur_Identifiant )
    {
        return $this->rechercher_utilisateur_Identifiant( $utilisateur_Identifiant );
    }

    public function mf_search_utilisateur_Password( string $utilisateur_Password )
    {
        return $this->rechercher_utilisateur_Password( $utilisateur_Password );
    }

    public function mf_search_utilisateur_Email( string $utilisateur_Email )
    {
        return $this->rechercher_utilisateur_Email( $utilisateur_Email );
    }

    public function mf_search_utilisateur_Administrateur( bool $utilisateur_Administrateur )
    {
        return $this->rechercher_utilisateur_Administrateur( $utilisateur_Administrateur );
    }

    public function mf_search_utilisateur_Developpeur( bool $utilisateur_Developpeur )
    {
        return $this->rechercher_utilisateur_Developpeur( $utilisateur_Developpeur );
    }

    public function mf_search__colonne( string $colonne_db, $recherche )
    {
        switch ($colonne_db) {
            case 'utilisateur_Identifiant': return $this->mf_search_utilisateur_Identifiant( $recherche ); break;
            case 'utilisateur_Password': return $this->mf_search_utilisateur_Password( $recherche ); break;
            case 'utilisateur_Email': return $this->mf_search_utilisateur_Email( $recherche ); break;
            case 'utilisateur_Administrateur': return $this->mf_search_utilisateur_Administrateur( $recherche ); break;
            case 'utilisateur_Developpeur': return $this->mf_search_utilisateur_Developpeur( $recherche ); break;
        }
    }

    public function mf_get_next_id()
    {
        $res_requete = executer_requete_mysql('SELECT AUTO_INCREMENT as next_id FROM INFORMATION_SCHEMA.TABLES WHERE table_name = \'utilisateur\';', false);
        $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC);
        mysqli_free_result($res_requete);
        return round($row_requete['next_id']);
    }

    public function mf_search(array $ligne) // array('colonne1' => 'valeur1',  [...] )
    {
        global $mf_initialisation;
        $utilisateur_Identifiant = (string)(isset($ligne['utilisateur_Identifiant'])?$ligne['utilisateur_Identifiant']:$mf_initialisation['utilisateur_Identifiant']);
        $utilisateur_Password = (string)(isset($ligne['utilisateur_Password'])?$ligne['utilisateur_Password']:$mf_initialisation['utilisateur_Password']);
        $utilisateur_Email = (string)(isset($ligne['utilisateur_Email'])?$ligne['utilisateur_Email']:$mf_initialisation['utilisateur_Email']);
        $utilisateur_Administrateur = (bool)(isset($ligne['utilisateur_Administrateur'])?$ligne['utilisateur_Administrateur']:$mf_initialisation['utilisateur_Administrateur']);
        $utilisateur_Developpeur = (bool)(isset($ligne['utilisateur_Developpeur'])?$ligne['utilisateur_Developpeur']:$mf_initialisation['utilisateur_Developpeur']);
        Hook_utilisateur::pre_controller($utilisateur_Identifiant, $utilisateur_Password, $utilisateur_Email, $utilisateur_Administrateur, $utilisateur_Developpeur);
        $mf_cle_unique = Hook_utilisateur::calcul_cle_unique($utilisateur_Identifiant, $utilisateur_Password, $utilisateur_Email, $utilisateur_Administrateur, $utilisateur_Developpeur);
        $res_requete = executer_requete_mysql('SELECT Code_utilisateur FROM ' . inst('utilisateur') . ' WHERE mf_cle_unique = \''.$mf_cle_unique.'\'', false);
        if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
        {
            $r = round($row_requete['Code_utilisateur']);
        }
        else
        {
            $r = false;
        }
        mysqli_free_result($res_requete);
        return $r;
    }
}
