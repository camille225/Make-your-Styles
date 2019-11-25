<?php

/*
    +------------------------------+
    |  NE PAS MODIFIER CE FICHIER  |
    +------------------------------+
*/

class commande_monframework extends entite_monframework
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
            include_once __DIR__ . '/../../erreurs/erreurs__commande.php';
            self::$initialisation = false;
            Hook_commande::initialisation();
            self::$cache_db = new Mf_Cachedb('commande');
        }
        if (!self::$actualisation_en_cours)
        {
            self::$actualisation_en_cours=true;
            Hook_commande::actualisation();
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

        if ( ! test_si_table_existe(inst('commande')) )
        {
            executer_requete_mysql('CREATE TABLE '.inst('commande').'(Code_commande INT AUTO_INCREMENT NOT NULL, PRIMARY KEY (Code_commande)) ENGINE=MyISAM;', array_search('commande', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        $liste_colonnes = lister_les_colonnes(inst('commande'));

        if ( isset($liste_colonnes['commande_Prix_total']) )
        {
            if ( typeMyql2Sql($liste_colonnes['commande_Prix_total']['Type'])!='FLOAT' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('commande').' CHANGE commande_Prix_total commande_Prix_total FLOAT;', array_search('commande', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['commande_Prix_total']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('commande').' ADD commande_Prix_total FLOAT;', array_search('commande', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE '.inst('commande').' SET commande_Prix_total=' . format_sql('commande_Prix_total', $mf_initialisation['commande_Prix_total']) . ';', array_search('commande', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if ( isset($liste_colonnes['commande_Date_livraison']) )
        {
            if ( typeMyql2Sql($liste_colonnes['commande_Date_livraison']['Type'])!='DATE' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('commande').' CHANGE commande_Date_livraison commande_Date_livraison DATE;', array_search('commande', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['commande_Date_livraison']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('commande').' ADD commande_Date_livraison DATE;', array_search('commande', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE '.inst('commande').' SET commande_Date_livraison=' . format_sql('commande_Date_livraison', $mf_initialisation['commande_Date_livraison']) . ';', array_search('commande', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if ( isset($liste_colonnes['commande_Date_creation']) )
        {
            if ( typeMyql2Sql($liste_colonnes['commande_Date_creation']['Type'])!='DATE' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('commande').' CHANGE commande_Date_creation commande_Date_creation DATE;', array_search('commande', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['commande_Date_creation']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('commande').' ADD commande_Date_creation DATE;', array_search('commande', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE '.inst('commande').' SET commande_Date_creation=' . format_sql('commande_Date_creation', $mf_initialisation['commande_Date_creation']) . ';', array_search('commande', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if ( isset($liste_colonnes['Code_utilisateur']) )
        {
            unset($liste_colonnes['Code_utilisateur']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('commande').' ADD Code_utilisateur int NOT NULL;', array_search('commande', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if ( isset($liste_colonnes['mf_signature']) )
        {
            unset($liste_colonnes['mf_signature']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('commande').' ADD mf_signature VARCHAR(255);', array_search('commande', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('ALTER TABLE '.inst('commande').' ADD INDEX( mf_signature );', array_search('commande', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if ( isset($liste_colonnes['mf_cle_unique']) )
        {
            unset($liste_colonnes['mf_cle_unique']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('commande').' ADD mf_cle_unique VARCHAR(255);', array_search('commande', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('ALTER TABLE '.inst('commande').' ADD INDEX( mf_cle_unique );', array_search('commande', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if ( isset($liste_colonnes['mf_date_creation']) )
        {
            unset($liste_colonnes['mf_date_creation']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('commande').' ADD mf_date_creation DATETIME;', array_search('commande', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('ALTER TABLE '.inst('commande').' ADD INDEX( mf_date_creation );', array_search('commande', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if ( isset($liste_colonnes['mf_date_modification']) )
        {
            unset($liste_colonnes['mf_date_modification']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('commande').' ADD mf_date_modification DATETIME;', array_search('commande', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('ALTER TABLE '.inst('commande').' ADD INDEX( mf_date_modification );', array_search('commande', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        unset($liste_colonnes['Code_commande']);

        foreach ($liste_colonnes as $field => $value)
        {
            executer_requete_mysql('ALTER TABLE '.inst('commande').' DROP COLUMN '.$field.';', array_search('commande', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

    }

    public function mf_ajouter(float $commande_Prix_total, string $commande_Date_livraison, string $commande_Date_creation, int $Code_utilisateur, ?bool $force = false)
    {
        if ($force === null) {
            $force = false;
        }
        $Code_commande = 0;
        $code_erreur = 0;
        $Code_utilisateur = round($Code_utilisateur);
        $commande_Prix_total = floatval(str_replace(' ','',str_replace(',','.',$commande_Prix_total)));
        $commande_Date_livraison = format_date($commande_Date_livraison);
        $commande_Date_creation = format_date($commande_Date_creation);
        Hook_commande::pre_controller($commande_Prix_total, $commande_Date_livraison, $commande_Date_creation, $Code_utilisateur);
        if (!$force)
        {
            if (!self::$maj_droits_ajouter_en_cours)
            {
                self::$maj_droits_ajouter_en_cours = true;
                Hook_commande::hook_actualiser_les_droits_ajouter($Code_utilisateur);
                self::$maj_droits_ajouter_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['commande__AJOUTER']) ) $code_erreur = REFUS_COMMANDE__AJOUTER;
        elseif ( !$this->mf_tester_existance_Code_utilisateur($Code_utilisateur) ) $code_erreur = ERR_COMMANDE__AJOUTER__CODE_UTILISATEUR_INEXISTANT;
        elseif (CONTROLE_ACCES_DONNEES_DEFAUT && ! Hook_mf_systeme::controle_acces_donnees('Code_utilisateur', $Code_utilisateur)) $code_erreur = ACCES_CODE_UTILISATEUR_REFUSE;
        elseif ( !Hook_commande::autorisation_ajout($commande_Prix_total, $commande_Date_livraison, $commande_Date_creation, $Code_utilisateur) ) $code_erreur = REFUS_COMMANDE__AJOUT_BLOQUEE;
        else
        {
            Hook_commande::data_controller($commande_Prix_total, $commande_Date_livraison, $commande_Date_creation, $Code_utilisateur);
            $mf_signature = text_sql(Hook_commande::calcul_signature($commande_Prix_total, $commande_Date_livraison, $commande_Date_creation, $Code_utilisateur));
            $mf_cle_unique = text_sql(Hook_commande::calcul_cle_unique($commande_Prix_total, $commande_Date_livraison, $commande_Date_creation, $Code_utilisateur));
            $commande_Prix_total = floatval($commande_Prix_total);
            $commande_Date_livraison = format_date($commande_Date_livraison);
            $commande_Date_creation = format_date($commande_Date_creation);
            $requete = "INSERT INTO ".inst('commande')." ( mf_signature, mf_cle_unique, mf_date_creation, mf_date_modification, commande_Prix_total, commande_Date_livraison, commande_Date_creation, Code_utilisateur ) VALUES ( '$mf_signature', '$mf_cle_unique', '".get_now()."', '".get_now()."', $commande_Prix_total, ".( $commande_Date_livraison!='' ? "'$commande_Date_livraison'" : 'NULL' ).", ".( $commande_Date_creation!='' ? "'$commande_Date_creation'" : 'NULL' ).", $Code_utilisateur );";
            executer_requete_mysql($requete, array_search('commande', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            $Code_commande = requete_mysql_insert_id();
            if ($Code_commande==0)
            {
                $code_erreur = ERR_COMMANDE__AJOUTER__AJOUT_REFUSE;
            } else {
                self::$cache_db->clear();
                Hook_commande::ajouter( $Code_commande );
            }
        }
        if ($code_erreur != 0) {
            global $mf_message_erreur_personalise, $mf_libelle_erreur;
            if ($mf_message_erreur_personalise != '') {
                $mf_libelle_erreur[$code_erreur] = $mf_message_erreur_personalise;
                $mf_message_erreur_personalise = '';
            }
        }
        return array('code_erreur' => $code_erreur, 'Code_commande' => $Code_commande, 'callback' => ( $code_erreur==0 ? Hook_commande::callback_post($Code_commande) : null ));
    }

    public function mf_creer(int $Code_utilisateur, ?bool $force = null)
    {
        if ($force === null) {
            $force = false;
        }
        global $mf_initialisation;
        $commande_Prix_total = $mf_initialisation['commande_Prix_total'];
        $commande_Date_livraison = $mf_initialisation['commande_Date_livraison'];
        $commande_Date_creation = $mf_initialisation['commande_Date_creation'];
        return $this->mf_ajouter($commande_Prix_total, $commande_Date_livraison, $commande_Date_creation, $Code_utilisateur, $force);
    }

    public function mf_ajouter_2(array $ligne, bool $force = null) // array('colonne1' => 'valeur1',  [...] )
    {
        if ($force === null) {
            $force = false;
        }
        global $mf_initialisation;
        $Code_utilisateur = (int)(isset($ligne['Code_utilisateur'])?round($ligne['Code_utilisateur']):get_utilisateur_courant('Code_utilisateur'));
        $commande_Prix_total = (float)(isset($ligne['commande_Prix_total'])?$ligne['commande_Prix_total']:$mf_initialisation['commande_Prix_total']);
        $commande_Date_livraison = (string)(isset($ligne['commande_Date_livraison'])?$ligne['commande_Date_livraison']:$mf_initialisation['commande_Date_livraison']);
        $commande_Date_creation = (string)(isset($ligne['commande_Date_creation'])?$ligne['commande_Date_creation']:$mf_initialisation['commande_Date_creation']);
        return $this->mf_ajouter($commande_Prix_total, $commande_Date_livraison, $commande_Date_creation, $Code_utilisateur, $force);
    }

    public function mf_ajouter_3(array $lignes) // array( array( 'colonne1' => 'valeur1', 'colonne2' => 'valeur2',  [...] ), [...] )
    {
        global $mf_initialisation;
        $code_erreur = 0;
        $values = '';
        foreach ($lignes as $ligne)
        {
            $Code_utilisateur = (int)(isset($ligne['Code_utilisateur'])?round($ligne['Code_utilisateur']):0);
            $commande_Prix_total = floatval(isset($ligne['commande_Prix_total'])?$ligne['commande_Prix_total']:$mf_initialisation['commande_Prix_total']);
            $commande_Date_livraison = format_date(isset($ligne['commande_Date_livraison'])?$ligne['commande_Date_livraison']:$mf_initialisation['commande_Date_livraison']);
            $commande_Date_creation = format_date(isset($ligne['commande_Date_creation'])?$ligne['commande_Date_creation']:$mf_initialisation['commande_Date_creation']);
            if ($Code_utilisateur != 0)
            {
                $values .= ($values!="" ? "," : "")."($commande_Prix_total, ".( $commande_Date_livraison!='' ? "'$commande_Date_livraison'" : 'NULL' ).", ".( $commande_Date_creation!='' ? "'$commande_Date_creation'" : 'NULL' ).", $Code_utilisateur)";
            }
        }
        if ($values!='')
        {
            $requete = "INSERT INTO ".inst('commande')." ( commande_Prix_total, commande_Date_livraison, commande_Date_creation, Code_utilisateur ) VALUES $values;";
            executer_requete_mysql( $requete , array_search('commande', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            $n = requete_mysqli_affected_rows();
            if ($n < count($lignes))
            {
                $code_erreur = ERR_COMMANDE__AJOUTER_3__ECHEC_AJOUT;
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

    public function mf_actualiser_signature(int $Code_commande)
    {
        $commande = $this->mf_get_2($Code_commande, array('autocompletion' => false));
        $mf_signature = text_sql(Hook_commande::calcul_signature($commande['commande_Prix_total'], $commande['commande_Date_livraison'], $commande['commande_Date_creation'], $commande['Code_utilisateur']));
        $mf_cle_unique = text_sql(Hook_commande::calcul_cle_unique($commande['commande_Prix_total'], $commande['commande_Date_livraison'], $commande['commande_Date_creation'], $commande['Code_utilisateur']));
        $table = inst('commande');
        executer_requete_mysql("UPDATE $table SET mf_signature='$mf_signature', mf_cle_unique='$mf_cle_unique' WHERE Code_commande=$Code_commande;", array_search('commande', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        if (requete_mysqli_affected_rows() == 1) {
            self::$cache_db->clear();
        }
    }

    public function mf_modifier( int $Code_commande, float $commande_Prix_total, string $commande_Date_livraison, string $commande_Date_creation, ?int $Code_utilisateur = null, ?bool $force = null)
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        $Code_commande = round($Code_commande);
        $Code_utilisateur = round($Code_utilisateur);
        $commande_Prix_total = floatval(str_replace(' ','',str_replace(',','.',$commande_Prix_total)));
        $commande_Date_livraison = format_date($commande_Date_livraison);
        $commande_Date_creation = format_date($commande_Date_creation);
        Hook_commande::pre_controller($commande_Prix_total, $commande_Date_livraison, $commande_Date_creation, $Code_utilisateur, $Code_commande);
        if (!$force)
        {
            if (!self::$maj_droits_modifier_en_cours)
            {
                self::$maj_droits_modifier_en_cours = true;
                Hook_commande::hook_actualiser_les_droits_modifier($Code_commande);
                self::$maj_droits_modifier_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['commande__MODIFIER']) ) $code_erreur = REFUS_COMMANDE__MODIFIER;
        elseif ( !$this->mf_tester_existance_Code_commande($Code_commande) ) $code_erreur = ERR_COMMANDE__MODIFIER__CODE_COMMANDE_INEXISTANT;
        elseif ($Code_utilisateur != 0 && ! $this->mf_tester_existance_Code_utilisateur($Code_utilisateur)) $code_erreur = ERR_COMMANDE__MODIFIER__CODE_UTILISATEUR_INEXISTANT;
        elseif (CONTROLE_ACCES_DONNEES_DEFAUT && ! Hook_mf_systeme::controle_acces_donnees('Code_commande', $Code_commande)) $code_erreur = ACCES_CODE_COMMANDE_REFUSE;
        elseif ($Code_utilisateur != 0 && CONTROLE_ACCES_DONNEES_DEFAUT && ! Hook_mf_systeme::controle_acces_donnees('Code_utilisateur', $Code_utilisateur)) $code_erreur = ACCES_CODE_UTILISATEUR_REFUSE;
        elseif ( !Hook_commande::autorisation_modification($Code_commande, $commande_Prix_total, $commande_Date_livraison, $commande_Date_creation, $Code_utilisateur) ) $code_erreur = REFUS_COMMANDE__MODIFICATION_BLOQUEE;
        else
        {
            if (! isset(self::$lock[$Code_commande])) {
                self::$lock[$Code_commande] = 0;
            }
            if (self::$lock[$Code_commande] == 0) {
                self::$cache_db->add_lock($Code_commande);
            }
            self::$lock[$Code_commande]++;
            Hook_commande::data_controller($commande_Prix_total, $commande_Date_livraison, $commande_Date_creation, $Code_utilisateur, $Code_commande);
            $commande = $this->mf_get_2( $Code_commande, array('autocompletion' => false, 'masquer_mdp' => false) );
            $mf_colonnes_a_modifier=[];
            $bool__commande_Prix_total = false; if ( $commande_Prix_total!=$commande['commande_Prix_total'] ) { Hook_commande::data_controller__commande_Prix_total($commande['commande_Prix_total'], $commande_Prix_total, $Code_commande); if ( $commande_Prix_total!=$commande['commande_Prix_total'] ) { $mf_colonnes_a_modifier[] = 'commande_Prix_total=' . format_sql('commande_Prix_total', $commande_Prix_total); $bool__commande_Prix_total = true; } }
            $bool__commande_Date_livraison = false; if ( $commande_Date_livraison!=$commande['commande_Date_livraison'] ) { Hook_commande::data_controller__commande_Date_livraison($commande['commande_Date_livraison'], $commande_Date_livraison, $Code_commande); if ( $commande_Date_livraison!=$commande['commande_Date_livraison'] ) { $mf_colonnes_a_modifier[] = 'commande_Date_livraison=' . format_sql('commande_Date_livraison', $commande_Date_livraison); $bool__commande_Date_livraison = true; } }
            $bool__commande_Date_creation = false; if ( $commande_Date_creation!=$commande['commande_Date_creation'] ) { Hook_commande::data_controller__commande_Date_creation($commande['commande_Date_creation'], $commande_Date_creation, $Code_commande); if ( $commande_Date_creation!=$commande['commande_Date_creation'] ) { $mf_colonnes_a_modifier[] = 'commande_Date_creation=' . format_sql('commande_Date_creation', $commande_Date_creation); $bool__commande_Date_creation = true; } }
            $bool__Code_utilisateur = false; if ($Code_utilisateur != 0 && $Code_utilisateur != $commande['Code_utilisateur'] ) { Hook_commande::data_controller__Code_utilisateur($commande['Code_utilisateur'], $Code_utilisateur, $Code_commande); if ( $Code_utilisateur != 0 && $Code_utilisateur != $commande['Code_utilisateur'] ) { $mf_colonnes_a_modifier[] = 'Code_utilisateur = ' . $Code_utilisateur; $bool__Code_utilisateur = true; } }
            if (count($mf_colonnes_a_modifier) > 0) {
                $mf_signature = text_sql(Hook_commande::calcul_signature($commande_Prix_total, $commande_Date_livraison, $commande_Date_creation, $Code_utilisateur));
                $mf_cle_unique = text_sql(Hook_commande::calcul_cle_unique($commande_Prix_total, $commande_Date_livraison, $commande_Date_creation, $Code_utilisateur));
                $mf_colonnes_a_modifier[] = 'mf_signature=\'' . $mf_signature . '\'';
                $mf_colonnes_a_modifier[] = 'mf_cle_unique=\'' . $mf_cle_unique . '\'';
                $mf_colonnes_a_modifier[] = 'mf_date_modification=\'' . get_now() . '\'';
                $requete = 'UPDATE '.inst('commande').' SET ' . enumeration($mf_colonnes_a_modifier) . ' WHERE Code_commande = ' . $Code_commande . ';';
                executer_requete_mysql($requete, array_search('commande', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
                if (requete_mysqli_affected_rows() == 0) {
                    $code_erreur = ERR_COMMANDE__MODIFIER__AUCUN_CHANGEMENT;
                } else {
                    self::$cache_db->clear();
                    Hook_commande::modifier($Code_commande, $bool__commande_Prix_total, $bool__commande_Date_livraison, $bool__commande_Date_creation, $bool__Code_utilisateur);
                }
            } else {
                $code_erreur = ERR_COMMANDE__MODIFIER__AUCUN_CHANGEMENT;
            }
            self::$lock[$Code_commande]--;
            if (self::$lock[$Code_commande] == 0) {
                self::$cache_db->release_lock($Code_commande);
                unset(self::$lock[$Code_commande]);
            }
        }
        if ($code_erreur != 0) {
            global $mf_message_erreur_personalise, $mf_libelle_erreur;
            if ($mf_message_erreur_personalise != '') {
                $mf_libelle_erreur[$code_erreur] = $mf_message_erreur_personalise;
                $mf_message_erreur_personalise = '';
            }
        }
        return array('code_erreur' => $code_erreur, 'callback' => ( $code_erreur == 0 ? Hook_commande::callback_put($Code_commande) : null ));
    }

    public function mf_modifier_2(array $lignes, ?bool $force = null) // array( $Code_commande => array('colonne1' => 'valeur1',  [...] ) )
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        foreach ( $lignes as $Code_commande => $colonnes )
        {
            if ( $code_erreur==0 )
            {
                $Code_commande = (int) round($Code_commande);
                $commande = $this->mf_get_2($Code_commande, array('autocompletion' => false));
                if (!$force)
                {
                    if (!self::$maj_droits_modifier_en_cours)
                    {
                        self::$maj_droits_modifier_en_cours = true;
                        Hook_commande::hook_actualiser_les_droits_modifier($Code_commande);
                        self::$maj_droits_modifier_en_cours = false;
                    }
                }
                $Code_utilisateur = (int) ( isset($colonnes['Code_utilisateur']) && ( $force || mf_matrice_droits(['api_modifier_ref__commande__Code_utilisateur', 'commande__MODIFIER']) ) ? $colonnes['Code_utilisateur'] : (isset($commande['Code_utilisateur']) ? $commande['Code_utilisateur'] : 0 ));
                $commande_Prix_total = (float) ( isset($colonnes['commande_Prix_total']) && ( $force || mf_matrice_droits(['api_modifier__commande_Prix_total', 'commande__MODIFIER']) ) ? $colonnes['commande_Prix_total'] : ( isset($commande['commande_Prix_total']) ? $commande['commande_Prix_total'] : '' ) );
                $commande_Date_livraison = (string) ( isset($colonnes['commande_Date_livraison']) && ( $force || mf_matrice_droits(['api_modifier__commande_Date_livraison', 'commande__MODIFIER']) ) ? $colonnes['commande_Date_livraison'] : ( isset($commande['commande_Date_livraison']) ? $commande['commande_Date_livraison'] : '' ) );
                $commande_Date_creation = (string) ( isset($colonnes['commande_Date_creation']) && ( $force || mf_matrice_droits(['api_modifier__commande_Date_creation', 'commande__MODIFIER']) ) ? $colonnes['commande_Date_creation'] : ( isset($commande['commande_Date_creation']) ? $commande['commande_Date_creation'] : '' ) );
                $retour = $this->mf_modifier($Code_commande, $commande_Prix_total, $commande_Date_livraison, $commande_Date_creation, $Code_utilisateur, true);
                if ($retour['code_erreur'] != 0 && $retour['code_erreur'] != ERR_COMMANDE__MODIFIER__AUCUN_CHANGEMENT) {
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

    public function mf_modifier_3(array $lignes) // array( $Code_commande => array('colonne1' => 'valeur1',  [...] ) )
    {
        $code_erreur = 0;
        $modifs = false;

        // transformation des lignes en colonnes
        $valeurs_en_colonnes=array();
        $indices_par_colonne=array();
        $liste_valeurs_indexees=array();
        foreach ( $lignes as $Code_commande => $colonnes )
        {
            foreach ($colonnes as $colonne => $valeur)
            {
                if ( $colonne=='commande_Prix_total' || $colonne=='commande_Date_livraison' || $colonne=='commande_Date_creation' || $colonne=='Code_utilisateur' )
                {
                    $valeurs_en_colonnes[$colonne][$Code_commande]=$valeur;
                    $indices_par_colonne[$colonne][]=$Code_commande;
                    $liste_valeurs_indexees[$colonne][''.$valeur][]=$Code_commande;
                }
            }
        }

        // fabrication des requetes
        foreach ( $valeurs_en_colonnes as $colonne => $valeurs )
        {
            if ( count($liste_valeurs_indexees[$colonne]) > 3 )
            {
                $modification_sql = $colonne . ' = CASE Code_commande';
                foreach ( $valeurs as $Code_commande => $valeur )
                {
                    $modification_sql .= ' WHEN ' . $Code_commande . ' THEN ' . format_sql($colonne, $valeur);
                }
                $modification_sql .= ' END';
                $perimetre = Sql_Format_Liste($indices_par_colonne[$colonne]);
                executer_requete_mysql('UPDATE ' . inst('commande') . ' SET ' . $modification_sql . ' WHERE Code_commande IN ' . $perimetre . ';', array_search('commande', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
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
                    executer_requete_mysql('UPDATE ' . inst('commande') . ' SET ' . $colonne . ' = ' . format_sql($colonne, $valeur) . ' WHERE Code_commande IN ' . $perimetre . ';', array_search('commande', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
                    if ( requete_mysqli_affected_rows()!=0 )
                    {
                        $modifs = true;
                    }
                }
            }
        }

        if ( ! $modifs && $code_erreur==0 )
        {
            $code_erreur = ERR_COMMANDE__MODIFIER_3__AUCUN_CHANGEMENT;
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

    public function mf_modifier_4( int $Code_utilisateur, array $data, ?array $options = null /* $options = array( 'cond_mysql' => array(), 'limit' => 0 ) */ ) // $data = array('colonne1' => 'valeur1', ... )
    {
        if ($options === null) {
            $force = [];
        }
        $code_erreur = 0;
        $Code_utilisateur = round($Code_utilisateur);
        $mf_colonnes_a_modifier=[];
        if ( isset($data['commande_Prix_total']) ) { $mf_colonnes_a_modifier[] = 'commande_Prix_total = ' . format_sql('commande_Prix_total', $data['commande_Prix_total']); }
        if ( isset($data['commande_Date_livraison']) ) { $mf_colonnes_a_modifier[] = 'commande_Date_livraison = ' . format_sql('commande_Date_livraison', $data['commande_Date_livraison']); }
        if ( isset($data['commande_Date_creation']) ) { $mf_colonnes_a_modifier[] = 'commande_Date_creation = ' . format_sql('commande_Date_creation', $data['commande_Date_creation']); }
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

            $requete = 'UPDATE ' . inst('commande') . ' SET ' . enumeration($mf_colonnes_a_modifier) . " WHERE 1".( $Code_utilisateur!=0 ? " AND Code_utilisateur=$Code_utilisateur" : "" )."$argument_cond" . ( $limit>0 ? ' LIMIT ' . $limit : '' ) . ";";
            executer_requete_mysql( $requete , array_search('commande', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_COMMANDE__MODIFIER_4__AUCUN_CHANGEMENT;
            } else {
                self::$cache_db->clear();
            }
        }
        return array('code_erreur' => $code_erreur);
    }

    public function mf_supprimer(int $Code_commande, ?bool $force = null)
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        $Code_commande = round($Code_commande);
        if (! $force) {
            if (!self::$maj_droits_supprimer_en_cours)
            {
                self::$maj_droits_supprimer_en_cours = true;
                Hook_commande::hook_actualiser_les_droits_supprimer($Code_commande);
                self::$maj_droits_supprimer_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['commande__SUPPRIMER']) ) $code_erreur = REFUS_COMMANDE__SUPPRIMER;
        elseif (! $this->mf_tester_existance_Code_commande($Code_commande) ) $code_erreur = ERR_COMMANDE__SUPPRIMER_2__CODE_COMMANDE_INEXISTANT;
        elseif (CONTROLE_ACCES_DONNEES_DEFAUT && ! Hook_mf_systeme::controle_acces_donnees('Code_commande', $Code_commande)) $code_erreur = ACCES_CODE_COMMANDE_REFUSE;
        elseif ( !Hook_commande::autorisation_suppression($Code_commande) ) $code_erreur = REFUS_COMMANDE__SUPPRESSION_BLOQUEE;
        else
        {
            $copie__commande = $this->mf_get($Code_commande, array('autocompletion' => false));
            $this->supprimer_donnes_en_cascade("commande", array($Code_commande));
            $requete = 'DELETE IGNORE FROM ' . inst('commande') . ' WHERE Code_commande=' . $Code_commande . ';';
            executer_requete_mysql($requete, array_search('commande', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            if (requete_mysqli_affected_rows() == 0) {
                $code_erreur = ERR_COMMANDE__SUPPRIMER__REFUSEE;
            } else {
                self::$cache_db->clear();
                Hook_commande::supprimer($copie__commande);
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

    public function mf_supprimer_2(array $liste_Code_commande, ?bool $force = null)
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        $copie__liste_commande = $this->mf_lister_2($liste_Code_commande, array('autocompletion' => false));
        $liste_Code_commande=array();
        foreach ( $copie__liste_commande as $copie__commande )
        {
            $Code_commande = $copie__commande['Code_commande'];
            if (!$force)
            {
                if (!self::$maj_droits_supprimer_en_cours)
                {
                    self::$maj_droits_supprimer_en_cours = true;
                    Hook_commande::hook_actualiser_les_droits_supprimer($Code_commande);
                    self::$maj_droits_supprimer_en_cours = false;
                }
            }
            if ( !$force && !mf_matrice_droits(['commande__SUPPRIMER']) ) $code_erreur = REFUS_COMMANDE__SUPPRIMER;
            elseif ( !Hook_commande::autorisation_suppression($Code_commande) ) $code_erreur = REFUS_COMMANDE__SUPPRESSION_BLOQUEE;
            {
                $liste_Code_commande[] = $Code_commande;
            }
        }
        if ( $code_erreur==0 && count($liste_Code_commande)>0 )
        {
            $this->supprimer_donnes_en_cascade("commande", $liste_Code_commande);
            $requete = 'DELETE IGNORE FROM ' . inst('commande') . ' WHERE Code_commande IN ' . Sql_Format_Liste($liste_Code_commande) . ';';
            executer_requete_mysql( $requete , array_search('commande', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            if (requete_mysqli_affected_rows() == 0) {
                $code_erreur = ERR_COMMANDE__SUPPRIMER_2__REFUSEE;
            } else {
                self::$cache_db->clear();
                Hook_commande::supprimer_2($copie__liste_commande);
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

    public function mf_supprimer_3(array $liste_Code_commande)
    {
        $code_erreur=0;
        if ( count($liste_Code_commande)>0 )
        {
            $this->supprimer_donnes_en_cascade("commande", $liste_Code_commande);
            $requete = 'DELETE IGNORE FROM ' . inst('commande') . ' WHERE Code_commande IN ' . Sql_Format_Liste($liste_Code_commande) . ';';
            executer_requete_mysql( $requete , array_search('commande', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            if (requete_mysqli_affected_rows() == 0) {
                $code_erreur = ERR_COMMANDE__SUPPRIMER_3__REFUSEE;
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
        if (! $contexte_parent && $mf_contexte['Code_commande'] != 0) {
            $commande = $this->mf_get( $mf_contexte['Code_commande'], $options);
            return array( $commande['Code_commande'] => $commande );
        } else {
            return $this->mf_lister(isset($est_charge['utilisateur']) ? $mf_contexte['Code_utilisateur'] : 0, $options);
        }
    }

    public function mf_lister(?int $Code_utilisateur = null, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cle = "commande__lister";
        $Code_utilisateur = round($Code_utilisateur);
        $cle .= "_{$Code_utilisateur}";

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
            if ( isset($mf_tri_defaut_table['commande']) )
            {
                $options['tris'] = $mf_tri_defaut_table['commande'];
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
                    if ( strpos($argument_cond, 'commande_Prix_total')!==false ) { $liste_colonnes_a_indexer['commande_Prix_total'] = 'commande_Prix_total'; }
                    if ( strpos($argument_cond, 'commande_Date_livraison')!==false ) { $liste_colonnes_a_indexer['commande_Date_livraison'] = 'commande_Date_livraison'; }
                    if ( strpos($argument_cond, 'commande_Date_creation')!==false ) { $liste_colonnes_a_indexer['commande_Date_creation'] = 'commande_Date_creation'; }
                }
                if (isset($options['tris'])) {
                    if ( isset($options['tris']['commande_Prix_total']) ) { $liste_colonnes_a_indexer['commande_Prix_total'] = 'commande_Prix_total'; }
                    if ( isset($options['tris']['commande_Date_livraison']) ) { $liste_colonnes_a_indexer['commande_Date_livraison'] = 'commande_Date_livraison'; }
                    if ( isset($options['tris']['commande_Date_creation']) ) { $liste_colonnes_a_indexer['commande_Date_creation'] = 'commande_Date_creation'; }
                }
                if (count($liste_colonnes_a_indexer) > 0) {
                    if (false === $mf_liste_requete_index = self::$cache_db->read('commande__index')) {
                        $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('commande').'`;', false);
                        $mf_liste_requete_index = array();
                        while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                            $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                        }
                        mysqli_free_result($res_requete_index);
                        self::$cache_db->write('commande__index', $mf_liste_requete_index);
                    }
                    foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                        if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                    }
                    if (count($liste_colonnes_a_indexer) > 0) {
                        foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                            executer_requete_mysql('ALTER TABLE `'.inst('commande').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                        }
                        self::$cache_db->clear();
                    }
                }

                $liste = array();
                $liste_commande_pas_a_jour = array();
                if ($toutes_colonnes)
                {
                    $colonnes='Code_commande, commande_Prix_total, commande_Date_livraison, commande_Date_creation, Code_utilisateur';
                }
                else
                {
                    $colonnes='Code_commande, commande_Prix_total, commande_Date_livraison, commande_Date_creation, Code_utilisateur';
                }
                $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM ' . inst('commande')." WHERE 1{$argument_cond}".( $Code_utilisateur!=0 ? " AND Code_utilisateur=$Code_utilisateur" : "" )."{$argument_tris}{$argument_limit};", false);
                while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                {
                    mf_formatage_db_type_php($row_requete);
                    $liste[$row_requete['Code_commande']] = $row_requete;
                    if ( $maj && ! Hook_commande::est_a_jour( $row_requete ) )
                    {
                        $liste_commande_pas_a_jour[$row_requete['Code_commande']] = $row_requete;
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
                Hook_commande::mettre_a_jour( $liste_commande_pas_a_jour );
            }
        }

        foreach ($liste as $elem)
        {
            if ( $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_commande', $elem['Code_commande']) )
            {
                unset($liste[$elem['Code_commande']]);
            }
            else
            {
                if (($autocompletion_recursive || self::$auto_completion < 1) && $autocompletion) {
                    self::$auto_completion ++;
                    Hook_commande::completion($liste[$elem['Code_commande']], self::$auto_completion - 1);
                    self::$auto_completion --;
                }
            }
        }

        return $liste;
    }

    public function mf_lister_2(array $liste_Code_commande, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        if (count($liste_Code_commande) > 0) {
            $cle = "commande__mf_lister_2_".Sql_Format_Liste($liste_Code_commande);

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
                if ( isset($mf_tri_defaut_table['commande']) )
                {
                    $options['tris'] = $mf_tri_defaut_table['commande'];
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
                        if ( strpos($argument_cond, 'commande_Prix_total')!==false ) { $liste_colonnes_a_indexer['commande_Prix_total'] = 'commande_Prix_total'; }
                        if ( strpos($argument_cond, 'commande_Date_livraison')!==false ) { $liste_colonnes_a_indexer['commande_Date_livraison'] = 'commande_Date_livraison'; }
                        if ( strpos($argument_cond, 'commande_Date_creation')!==false ) { $liste_colonnes_a_indexer['commande_Date_creation'] = 'commande_Date_creation'; }
                    }
                    if (isset($options['tris'])) {
                        if ( isset($options['tris']['commande_Prix_total']) ) { $liste_colonnes_a_indexer['commande_Prix_total'] = 'commande_Prix_total'; }
                        if ( isset($options['tris']['commande_Date_livraison']) ) { $liste_colonnes_a_indexer['commande_Date_livraison'] = 'commande_Date_livraison'; }
                        if ( isset($options['tris']['commande_Date_creation']) ) { $liste_colonnes_a_indexer['commande_Date_creation'] = 'commande_Date_creation'; }
                    }
                    if (count($liste_colonnes_a_indexer) > 0) {
                        if (false === $mf_liste_requete_index = self::$cache_db->read('commande__index')) {
                            $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('commande').'`;', false);
                            $mf_liste_requete_index = array();
                            while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                                $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                            }
                            mysqli_free_result($res_requete_index);
                            self::$cache_db->write('commande__index', $mf_liste_requete_index);
                        }
                        foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                            if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                        }
                        if (count($liste_colonnes_a_indexer) > 0) {
                            foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                                executer_requete_mysql('ALTER TABLE `'.inst('commande').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                            }
                            self::$cache_db->clear();
                        }
                    }

                    $liste = array();
                    $liste_commande_pas_a_jour = array();
                    if ($toutes_colonnes) {
                        $colonnes='Code_commande, commande_Prix_total, commande_Date_livraison, commande_Date_creation, Code_utilisateur';
                    } else {
                        $colonnes='Code_commande, commande_Prix_total, commande_Date_livraison, commande_Date_creation, Code_utilisateur';
                    }
                    $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM ' . inst('commande') . " WHERE 1{$argument_cond} AND Code_commande IN ".Sql_Format_Liste($liste_Code_commande)."{$argument_tris}{$argument_limit};", false);
                    while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                        mf_formatage_db_type_php($row_requete);
                        $liste[$row_requete['Code_commande']] = $row_requete;
                        if ($maj && ! Hook_commande::est_a_jour($row_requete)) {
                            $liste_commande_pas_a_jour[$row_requete['Code_commande']] = $row_requete;
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
                    Hook_commande::mettre_a_jour( $liste_commande_pas_a_jour );
                }
            }

            foreach ($liste as $elem) {
                if ( $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_commande', $elem['Code_commande']) )
                {
                    unset($liste[$elem['Code_commande']]);
                }
                else
                {
                    if (($autocompletion_recursive || self::$auto_completion < 1) && $autocompletion) {
                        self::$auto_completion ++;
                        Hook_commande::completion($liste[$elem['Code_commande']], self::$auto_completion - 1);
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
        return $this->mf_lister(null, $options);
    }

    public function mf_get(int $Code_commande, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $Code_commande = round($Code_commande);
        $retour = array();
        if ( ! CONTROLE_ACCES_DONNEES_DEFAUT || Hook_mf_systeme::controle_acces_donnees('Code_commande', $Code_commande) )
        {
            $cle = 'commande__get_'.$Code_commande;

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
                        $colonnes='Code_commande, commande_Prix_total, commande_Date_livraison, commande_Date_creation, Code_utilisateur';
                    } else {
                        $colonnes='Code_commande, commande_Prix_total, commande_Date_livraison, commande_Date_creation, Code_utilisateur';
                    }
                    $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM ' . inst('commande') . ' WHERE Code_commande = ' . $Code_commande . ';', false);
                    if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                    {
                        mf_formatage_db_type_php($row_requete);
                        $retour = $row_requete;
                        if ( $maj && ! Hook_commande::est_a_jour( $row_requete ) )
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
                    Hook_commande::mettre_a_jour( array( $row_requete['Code_commande'] => $row_requete ) );
                }
            }
            if ( isset( $retour['Code_commande'] ) )
            {
                if (($autocompletion_recursive || self::$auto_completion < 1) && $autocompletion) {
                    self::$auto_completion ++;
                    Hook_commande::completion($retour, self::$auto_completion - 1);
                    self::$auto_completion --;
                }
            }
        }
        return $retour;
    }

    public function mf_get_last(?int $Code_utilisateur = null, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cle = "commande__get_last";
        $Code_utilisateur = round($Code_utilisateur);
        $cle .= '_' . $Code_utilisateur;
        if (false === $retour = self::$cache_db->read($cle)) {
            $Code_commande = 0;
            $res_requete = executer_requete_mysql('SELECT Code_commande FROM ' . inst('commande') . " WHERE 1".( $Code_utilisateur!=0 ? " AND Code_utilisateur=$Code_utilisateur" : "" )." ORDER BY mf_date_creation DESC, Code_commande DESC LIMIT 0 , 1;", false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $Code_commande = $row_requete['Code_commande'];
            }
            mysqli_free_result($res_requete);
            $retour = $this->mf_get($Code_commande, $options);
            self::$cache_db->write($cle, $retour);
        }
        return $retour;
    }

    public function mf_get_2(int $Code_commande, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $Code_commande = round($Code_commande);
        $retour = array();
        $cle = 'commande__get_'.$Code_commande;

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
                $colonnes='Code_commande, commande_Prix_total, commande_Date_livraison, commande_Date_creation, Code_utilisateur';
            } else {
                $colonnes='Code_commande, commande_Prix_total, commande_Date_livraison, commande_Date_creation, Code_utilisateur';
            }
            $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM ' . inst('commande') . ' WHERE Code_commande = ' . $Code_commande . ';', false);
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
                Hook_commande::completion($retour, self::$auto_completion - 1);
                self::$auto_completion --;
            }
        }
        return $retour;
    }

    public function mf_prec_et_suiv( int $Code_commande, ?int $Code_utilisateur = null, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $Code_commande = round($Code_commande);
        $liste = $this->mf_lister($Code_utilisateur, $options);
        return prec_suiv($liste, $Code_commande);
    }

    public function mf_compter(?int $Code_utilisateur = null, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cle = 'commande__compter';
        $Code_utilisateur = round($Code_utilisateur);
        $cle .= '_{'.$Code_utilisateur.'}';

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
                if ( strpos($argument_cond, 'commande_Prix_total')!==false ) { $liste_colonnes_a_indexer['commande_Prix_total'] = 'commande_Prix_total'; }
                if ( strpos($argument_cond, 'commande_Date_livraison')!==false ) { $liste_colonnes_a_indexer['commande_Date_livraison'] = 'commande_Date_livraison'; }
                if ( strpos($argument_cond, 'commande_Date_creation')!==false ) { $liste_colonnes_a_indexer['commande_Date_creation'] = 'commande_Date_creation'; }
            }
            if (count($liste_colonnes_a_indexer) > 0) {
                if (false === $mf_liste_requete_index = self::$cache_db->read('commande__index')) {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('commande').'`;', false);
                    $mf_liste_requete_index = array();
                    while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    self::$cache_db->write('commande__index', $mf_liste_requete_index);
                }
                foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if (count($liste_colonnes_a_indexer) > 0) {
                    foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                        executer_requete_mysql('ALTER TABLE `'.inst('commande').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    self::$cache_db->clear();
                }
            }

            $res_requete = executer_requete_mysql('SELECT count(Code_commande) as nb FROM ' . inst('commande')." WHERE 1{$argument_cond}".( $Code_utilisateur!=0 ? " AND Code_utilisateur=$Code_utilisateur" : "" ).";", false);
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
        $Code_utilisateur = isset($interface['Code_utilisateur']) ? round($interface['Code_utilisateur']) : 0;
        return $this->mf_compter( $Code_utilisateur, $options );
    }

    public function mf_liste_Code_commande(?int $Code_utilisateur = null, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ($options === null) {
            $options=[];
        }
        return $this->get_liste_Code_commande($Code_utilisateur, $options);
    }

    public function mf_convertir_Code_commande_vers_Code_utilisateur( int $Code_commande )
    {
        return $this->Code_commande_vers_Code_utilisateur( $Code_commande );
    }

    public function mf_liste_Code_utilisateur_vers_liste_Code_commande( array $liste_Code_utilisateur, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ($options === null) {
            $options=[];
        }
        return $this->liste_Code_utilisateur_vers_liste_Code_commande( $liste_Code_utilisateur, $options );
    }

    public function mf_liste_Code_commande_vers_liste_Code_utilisateur( array $liste_Code_commande, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ($options === null) {
            $options=[];
        }
        return $this->commande__liste_Code_commande_vers_liste_Code_utilisateur( $liste_Code_commande, $options );
    }

    public function mf_get_liste_tables_enfants()
    {
        return $this->get_liste_tables_enfants( 'commande' );
    }

    public function mf_get_liste_tables_parents()
    {
        return array('Code_utilisateur');
    }

    public function mf_search_commande_Prix_total( float $commande_Prix_total, ?int $Code_utilisateur = null )
    {
        return $this->rechercher_commande_Prix_total( $commande_Prix_total, $Code_utilisateur );
    }

    public function mf_search_commande_Date_livraison( string $commande_Date_livraison, ?int $Code_utilisateur = null )
    {
        return $this->rechercher_commande_Date_livraison( $commande_Date_livraison, $Code_utilisateur );
    }

    public function mf_search_commande_Date_creation( string $commande_Date_creation, ?int $Code_utilisateur = null )
    {
        return $this->rechercher_commande_Date_creation( $commande_Date_creation, $Code_utilisateur );
    }

    public function mf_search__colonne( string $colonne_db, $recherche, ?int $Code_utilisateur = null )
    {
        switch ($colonne_db) {
            case 'commande_Prix_total': return $this->mf_search_commande_Prix_total( $recherche, $Code_utilisateur ); break;
            case 'commande_Date_livraison': return $this->mf_search_commande_Date_livraison( $recherche, $Code_utilisateur ); break;
            case 'commande_Date_creation': return $this->mf_search_commande_Date_creation( $recherche, $Code_utilisateur ); break;
        }
    }

    public function mf_get_next_id()
    {
        $res_requete = executer_requete_mysql('SELECT AUTO_INCREMENT as next_id FROM INFORMATION_SCHEMA.TABLES WHERE table_name = \'commande\';', false);
        $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC);
        mysqli_free_result($res_requete);
        return round($row_requete['next_id']);
    }

    public function mf_search(array $ligne) // array('colonne1' => 'valeur1',  [...] )
    {
        global $mf_initialisation;
        $Code_utilisateur = (int)(isset($ligne['Code_utilisateur'])?round($ligne['Code_utilisateur']):get_utilisateur_courant('Code_utilisateur'));
        $commande_Prix_total = (float)(isset($ligne['commande_Prix_total'])?$ligne['commande_Prix_total']:$mf_initialisation['commande_Prix_total']);
        $commande_Date_livraison = (string)(isset($ligne['commande_Date_livraison'])?$ligne['commande_Date_livraison']:$mf_initialisation['commande_Date_livraison']);
        $commande_Date_creation = (string)(isset($ligne['commande_Date_creation'])?$ligne['commande_Date_creation']:$mf_initialisation['commande_Date_creation']);
        $commande_Prix_total = floatval(str_replace(' ','',str_replace(',','.',$commande_Prix_total)));
        $commande_Date_livraison = format_date($commande_Date_livraison);
        $commande_Date_creation = format_date($commande_Date_creation);
        Hook_commande::pre_controller($commande_Prix_total, $commande_Date_livraison, $commande_Date_creation, $Code_utilisateur);
        $mf_cle_unique = Hook_commande::calcul_cle_unique($commande_Prix_total, $commande_Date_livraison, $commande_Date_creation, $Code_utilisateur);
        $res_requete = executer_requete_mysql('SELECT Code_commande FROM ' . inst('commande') . ' WHERE mf_cle_unique = \''.$mf_cle_unique.'\'', false);
        if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
        {
            $r = round($row_requete['Code_commande']);
        }
        else
        {
            $r = false;
        }
        mysqli_free_result($res_requete);
        return $r;
    }
}
