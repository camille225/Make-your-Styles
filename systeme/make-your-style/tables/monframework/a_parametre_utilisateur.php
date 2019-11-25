<?php

/*
    +------------------------------+
    |  NE PAS MODIFIER CE FICHIER  |
    +------------------------------+
*/

class a_parametre_utilisateur_monframework extends entite_monframework
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
            include_once __DIR__ . '/../../erreurs/erreurs__a_parametre_utilisateur.php';
            self::$initialisation = false;
            Hook_a_parametre_utilisateur::initialisation();
            self::$cache_db = new Mf_Cachedb('a_parametre_utilisateur');
        }
        if (!self::$actualisation_en_cours)
        {
            self::$actualisation_en_cours=true;
            Hook_a_parametre_utilisateur::actualisation();
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

        if (! test_si_table_existe(inst('a_parametre_utilisateur'))) {
            executer_requete_mysql('CREATE TABLE '.inst('a_parametre_utilisateur').' (Code_utilisateur INT NOT NULL, Code_parametre INT NOT NULL, PRIMARY KEY (Code_utilisateur, Code_parametre)) ENGINE=MyISAM;', array_search('a_parametre_utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        $liste_colonnes = lister_les_colonnes(inst('a_parametre_utilisateur'));

        if (isset($liste_colonnes['a_parametre_utilisateur_Valeur'])) {
            if (typeMyql2Sql($liste_colonnes['a_parametre_utilisateur_Valeur']['Type'])!='INT') {
                executer_requete_mysql('ALTER TABLE '.inst('a_parametre_utilisateur').' CHANGE a_parametre_utilisateur_Valeur a_parametre_utilisateur_Valeur INT;', array_search('a_parametre_utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['a_parametre_utilisateur_Valeur']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('a_parametre_utilisateur').' ADD a_parametre_utilisateur_Valeur INT;', array_search('a_parametre_utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE '.inst('a_parametre_utilisateur').' SET a_parametre_utilisateur_Valeur=' . format_sql('a_parametre_utilisateur_Valeur', $mf_initialisation['a_parametre_utilisateur_Valeur']) . ';', array_search('a_parametre_utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if (isset($liste_colonnes['a_parametre_utilisateur_Actif'])) {
            if (typeMyql2Sql($liste_colonnes['a_parametre_utilisateur_Actif']['Type'])!='INT') {
                executer_requete_mysql('ALTER TABLE '.inst('a_parametre_utilisateur').' CHANGE a_parametre_utilisateur_Actif a_parametre_utilisateur_Actif INT;', array_search('a_parametre_utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['a_parametre_utilisateur_Actif']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('a_parametre_utilisateur').' ADD a_parametre_utilisateur_Actif INT;', array_search('a_parametre_utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE '.inst('a_parametre_utilisateur').' SET a_parametre_utilisateur_Actif=' . format_sql('a_parametre_utilisateur_Actif', $mf_initialisation['a_parametre_utilisateur_Actif']) . ';', array_search('a_parametre_utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        unset($liste_colonnes['Code_utilisateur']);
        unset($liste_colonnes['Code_parametre']);

        foreach ($liste_colonnes as $field => $value) {
            executer_requete_mysql('ALTER TABLE '.inst('a_parametre_utilisateur').' DROP COLUMN '.$field.';', array_search('a_parametre_utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

    }

    public function mfi_ajouter_auto(array $interface)
    {
        if (isset($interface['Code_utilisateur'])) {
            $liste_Code_utilisateur = array($interface['Code_utilisateur']);
            $liste_Code_utilisateur = $this->__get_liste_Code_utilisateur([OPTION_COND_MYSQL=>['Code_utilisateur IN ' . Sql_Format_Liste($liste_Code_utilisateur)]]);
        } elseif (isset($interface['liste_Code_utilisateur'])) {
            $liste_Code_utilisateur = $interface['liste_Code_utilisateur'];
            $liste_Code_utilisateur = $this->__get_liste_Code_utilisateur([OPTION_COND_MYSQL=>['Code_utilisateur IN ' . Sql_Format_Liste($liste_Code_utilisateur)]]);
        } else {
            $liste_Code_utilisateur = $this->get_liste_Code_utilisateur();
        }
        if (isset($interface['Code_parametre'])) {
            $liste_Code_parametre = array($interface['Code_parametre']);
            $liste_Code_parametre = $this->__get_liste_Code_parametre([OPTION_COND_MYSQL=>['Code_parametre IN ' . Sql_Format_Liste($liste_Code_parametre)]]);
        } elseif (isset($interface['liste_Code_parametre'])) {
            $liste_Code_parametre = $interface['liste_Code_parametre'];
            $liste_Code_parametre = $this->__get_liste_Code_parametre([OPTION_COND_MYSQL=>['Code_parametre IN ' . Sql_Format_Liste($liste_Code_parametre)]]);
        } else {
            $liste_Code_parametre = $this->get_liste_Code_parametre();
        }
        $mf_index = [];
        $res_requete = executer_requete_mysql('SELECT Code_utilisateur, Code_parametre FROM ' . inst('a_parametre_utilisateur') . ' WHERE Code_utilisateur IN ' . Sql_Format_Liste($liste_Code_utilisateur) . ' AND Code_parametre IN ' . Sql_Format_Liste($liste_Code_parametre) . ';', false);
        while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
            $mf_index[(int) $row_requete['Code_utilisateur']][(int) $row_requete['Code_parametre']] = 1;
        }
        mysqli_free_result($res_requete);
        $liste_a_parametre_utilisateur = array();
        foreach ($liste_Code_utilisateur as $Code_utilisateur) {
            foreach ($liste_Code_parametre as $Code_parametre) {
                if (! isset($mf_index[$Code_utilisateur][$Code_parametre])) {
                    $liste_a_parametre_utilisateur[] = array('Code_utilisateur'=>$Code_utilisateur,'Code_parametre'=>$Code_parametre);
                }
            }
        }
        if (isset($interface['a_parametre_utilisateur_Valeur'])) {
            foreach ($liste_a_parametre_utilisateur as &$a_parametre_utilisateur) {
                $a_parametre_utilisateur['a_parametre_utilisateur_Valeur'] = $interface['a_parametre_utilisateur_Valeur'];
            }
            unset($a_parametre_utilisateur);
        }
        if (isset($interface['a_parametre_utilisateur_Actif'])) {
            foreach ($liste_a_parametre_utilisateur as &$a_parametre_utilisateur) {
                $a_parametre_utilisateur['a_parametre_utilisateur_Actif'] = $interface['a_parametre_utilisateur_Actif'];
            }
            unset($a_parametre_utilisateur);
        }
        return $this->mf_ajouter_3($liste_a_parametre_utilisateur);
    }

    public function mfi_supprimer_auto(array $interface)
    {
        if (isset($interface['Code_utilisateur'])) {
            $liste_Code_utilisateur = array($interface['Code_utilisateur']);
        } elseif (isset($interface['liste_Code_utilisateur'])) {
            $liste_Code_utilisateur = $interface['liste_Code_utilisateur'];
        } else {
            $liste_Code_utilisateur = $this->get_liste_Code_utilisateur();
        }
        if (isset($interface['Code_parametre'])) {
            $liste_Code_parametre = array($interface['Code_parametre']);
        } elseif (isset($interface['liste_Code_parametre'])) {
            $liste_Code_parametre = $interface['liste_Code_parametre'];
        } else {
            $liste_Code_parametre = $this->get_liste_Code_parametre();
        }
        $mf_index = [];
        $res_requete = executer_requete_mysql('SELECT Code_utilisateur, Code_parametre FROM ' . inst('a_parametre_utilisateur') . ' WHERE Code_utilisateur IN ' . Sql_Format_Liste($liste_Code_utilisateur) . ' AND Code_parametre IN ' . Sql_Format_Liste($liste_Code_parametre) . ';', false);
        while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
            $mf_index[(int) $row_requete['Code_utilisateur']][(int) $row_requete['Code_parametre']] = 1;
        }
        mysqli_free_result($res_requete);
        foreach ($liste_Code_utilisateur as &$Code_utilisateur) {
            if (isset($mf_index[$Code_utilisateur])) {
                foreach ($liste_Code_parametre as &$Code_parametre) {
                    if (isset($mf_index[$Code_utilisateur][$Code_parametre])) {
                        $this->mf_supprimer_2($Code_utilisateur, $Code_parametre);
                    }
                }
            }
        }
    }

    public function mf_ajouter(int $Code_utilisateur, int $Code_parametre, int $a_parametre_utilisateur_Valeur, int $a_parametre_utilisateur_Actif, ?bool $force = null)
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        $Code_utilisateur = round($Code_utilisateur);
        $Code_parametre = round($Code_parametre);
        $a_parametre_utilisateur_Valeur = round($a_parametre_utilisateur_Valeur);
        $a_parametre_utilisateur_Actif = round($a_parametre_utilisateur_Actif);
        Hook_a_parametre_utilisateur::pre_controller($a_parametre_utilisateur_Valeur, $a_parametre_utilisateur_Actif, $Code_utilisateur, $Code_parametre, true);
        if (! $force) {
            if (!self::$maj_droits_ajouter_en_cours)
            {
                self::$maj_droits_ajouter_en_cours = true;
                Hook_a_parametre_utilisateur::hook_actualiser_les_droits_ajouter($Code_utilisateur, $Code_parametre);
                self::$maj_droits_ajouter_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['a_parametre_utilisateur__AJOUTER']) ) $code_erreur = REFUS_A_PARAMETRE_UTILISATEUR__AJOUTER;
        elseif ( !$this->mf_tester_existance_Code_utilisateur($Code_utilisateur) ) $code_erreur = ERR_A_PARAMETRE_UTILISATEUR__AJOUTER__CODE_UTILISATEUR_INEXISTANT;
        elseif ( !$this->mf_tester_existance_Code_parametre($Code_parametre) ) $code_erreur = ERR_A_PARAMETRE_UTILISATEUR__AJOUTER__CODE_PARAMETRE_INEXISTANT;
        elseif ( $this->mf_tester_existance_a_parametre_utilisateur( $Code_utilisateur, $Code_parametre ) ) $code_erreur = ERR_A_PARAMETRE_UTILISATEUR__AJOUTER__DOUBLON;
        elseif (CONTROLE_ACCES_DONNEES_DEFAUT && ! Hook_mf_systeme::controle_acces_donnees('Code_utilisateur', $Code_utilisateur)) $code_erreur = ACCES_CODE_UTILISATEUR_REFUSE;
        elseif (CONTROLE_ACCES_DONNEES_DEFAUT && ! Hook_mf_systeme::controle_acces_donnees('Code_parametre', $Code_parametre)) $code_erreur = ACCES_CODE_PARAMETRE_REFUSE;
        elseif ( !Hook_a_parametre_utilisateur::autorisation_ajout($a_parametre_utilisateur_Valeur, $a_parametre_utilisateur_Actif, $Code_utilisateur, $Code_parametre) ) $code_erreur = REFUS_A_PARAMETRE_UTILISATEUR__AJOUT_BLOQUEE;
        else
        {
            Hook_a_parametre_utilisateur::data_controller($a_parametre_utilisateur_Valeur, $a_parametre_utilisateur_Actif, $Code_utilisateur, $Code_parametre, true);
            $a_parametre_utilisateur_Valeur = round($a_parametre_utilisateur_Valeur);
            $a_parametre_utilisateur_Actif = round($a_parametre_utilisateur_Actif);
            $requete = 'INSERT INTO '.inst('a_parametre_utilisateur')." ( a_parametre_utilisateur_Valeur, a_parametre_utilisateur_Actif, Code_utilisateur, Code_parametre ) VALUES ( $a_parametre_utilisateur_Valeur, $a_parametre_utilisateur_Actif, $Code_utilisateur, $Code_parametre );";
            executer_requete_mysql($requete, array_search('a_parametre_utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            $n = requete_mysqli_affected_rows();
            if ($n == 0) {
                $code_erreur = ERR_A_PARAMETRE_UTILISATEUR__AJOUTER__REFUSE;
            } else {
                self::$cache_db->clear();
                Hook_a_parametre_utilisateur::ajouter($Code_utilisateur, $Code_parametre);
            }
        }
        if ($code_erreur != 0) {
            global $mf_message_erreur_personalise, $mf_libelle_erreur;
            if ($mf_message_erreur_personalise != '') {
                $mf_libelle_erreur[$code_erreur] = $mf_message_erreur_personalise;
                $mf_message_erreur_personalise = '';
            }
        }
        return array('code_erreur' => $code_erreur, 'callback' => ( $code_erreur==0 ? Hook_a_parametre_utilisateur::callback_post($Code_utilisateur, $Code_parametre) : null ));
    }

    public function mf_ajouter_2(array $ligne, ?bool $force = null) // array('colonne1' => 'valeur1',  [...] )
    {
        if ($force === null) {
            $force = false;
        }
        global $mf_initialisation;
        $Code_utilisateur = (int)(isset($ligne['Code_utilisateur'])?round($ligne['Code_utilisateur']):get_utilisateur_courant('Code_utilisateur'));
        $Code_parametre = (int)(isset($ligne['Code_parametre'])?round($ligne['Code_parametre']):0);
        $a_parametre_utilisateur_Valeur = (int)(isset($ligne['a_parametre_utilisateur_Valeur'])?$ligne['a_parametre_utilisateur_Valeur']:$mf_initialisation['a_parametre_utilisateur_Valeur']);
        $a_parametre_utilisateur_Actif = (int)(isset($ligne['a_parametre_utilisateur_Actif'])?$ligne['a_parametre_utilisateur_Actif']:$mf_initialisation['a_parametre_utilisateur_Actif']);
        return $this->mf_ajouter($Code_utilisateur, $Code_parametre, $a_parametre_utilisateur_Valeur, $a_parametre_utilisateur_Actif, $force);
    }

    public function mf_ajouter_3(array $lignes) // array( array( 'colonne1' => 'valeur1', 'colonne2' => 'valeur2',  [...] ), [...] )
    {
        global $mf_initialisation;
        $code_erreur = 0;
        $values = '';
        foreach ($lignes as $ligne) {
            $Code_utilisateur = (isset($ligne['Code_utilisateur'])?round($ligne['Code_utilisateur']):0);
            $Code_parametre = (isset($ligne['Code_parametre'])?round($ligne['Code_parametre']):0);
            $a_parametre_utilisateur_Valeur = round(isset($ligne['a_parametre_utilisateur_Valeur'])?$ligne['a_parametre_utilisateur_Valeur']:$mf_initialisation['a_parametre_utilisateur_Valeur']);
            $a_parametre_utilisateur_Actif = round(isset($ligne['a_parametre_utilisateur_Actif'])?$ligne['a_parametre_utilisateur_Actif']:$mf_initialisation['a_parametre_utilisateur_Actif']);
            if ($Code_utilisateur != 0) {
                if ($Code_parametre != 0) {
                    $values .= ($values!='' ? ',' : '')."($a_parametre_utilisateur_Valeur, $a_parametre_utilisateur_Actif, $Code_utilisateur, $Code_parametre)";
                }
            }
        }
        if ($values != '') {
            $requete = "INSERT INTO ".inst('a_parametre_utilisateur')." ( a_parametre_utilisateur_Valeur, a_parametre_utilisateur_Actif, Code_utilisateur, Code_parametre ) VALUES $values;";
            executer_requete_mysql($requete, array_search('a_parametre_utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            $n = requete_mysqli_affected_rows();
            if ($n < count($lignes)) {
                $code_erreur = ERR_A_PARAMETRE_UTILISATEUR__AJOUTER_3__ECHEC_AJOUT;
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

    public function mf_modifier(int $Code_utilisateur, int $Code_parametre, int $a_parametre_utilisateur_Valeur, int $a_parametre_utilisateur_Actif, ?bool $force = null)
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        $Code_utilisateur = round($Code_utilisateur);
        $Code_parametre = round($Code_parametre);
        $a_parametre_utilisateur_Valeur = round($a_parametre_utilisateur_Valeur);
        $a_parametre_utilisateur_Actif = round($a_parametre_utilisateur_Actif);
        Hook_a_parametre_utilisateur::pre_controller($a_parametre_utilisateur_Valeur, $a_parametre_utilisateur_Actif, $Code_utilisateur, $Code_parametre, false);
        if (!$force)
        {
            if (!self::$maj_droits_modifier_en_cours)
            {
                self::$maj_droits_modifier_en_cours = true;
                Hook_a_parametre_utilisateur::hook_actualiser_les_droits_modifier($Code_utilisateur, $Code_parametre);
                self::$maj_droits_modifier_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['a_parametre_utilisateur__MODIFIER']) ) $code_erreur = REFUS_A_PARAMETRE_UTILISATEUR__MODIFIER;
        elseif ( !$this->mf_tester_existance_Code_utilisateur($Code_utilisateur) ) $code_erreur = ERR_A_PARAMETRE_UTILISATEUR__MODIFIER__CODE_UTILISATEUR_INEXISTANT;
        elseif ( !$this->mf_tester_existance_Code_parametre($Code_parametre) ) $code_erreur = ERR_A_PARAMETRE_UTILISATEUR__MODIFIER__CODE_PARAMETRE_INEXISTANT;
        elseif ( !$this->mf_tester_existance_a_parametre_utilisateur( $Code_utilisateur, $Code_parametre ) ) $code_erreur = ERR_A_PARAMETRE_UTILISATEUR__MODIFIER__INEXISTANT;
        elseif (CONTROLE_ACCES_DONNEES_DEFAUT && ! Hook_mf_systeme::controle_acces_donnees('Code_utilisateur', $Code_utilisateur)) $code_erreur = ACCES_CODE_UTILISATEUR_REFUSE;
        elseif (CONTROLE_ACCES_DONNEES_DEFAUT && ! Hook_mf_systeme::controle_acces_donnees('Code_parametre', $Code_parametre)) $code_erreur = ACCES_CODE_PARAMETRE_REFUSE;
        elseif ( !Hook_a_parametre_utilisateur::autorisation_modification($Code_utilisateur, $Code_parametre, $a_parametre_utilisateur_Valeur, $a_parametre_utilisateur_Actif) ) $code_erreur = REFUS_A_PARAMETRE_UTILISATEUR__MODIFICATION_BLOQUEE;
        else
        {
            if (! isset(self::$lock[$Code_utilisateur . '-' . $Code_parametre])) {
                self::$lock[$Code_utilisateur . '-' . $Code_parametre] = 0;
            }
            if (self::$lock[$Code_utilisateur . '-' . $Code_parametre] == 0) {
                self::$cache_db->add_lock($Code_utilisateur . '-' . $Code_parametre);
            }
            self::$lock[$Code_utilisateur . '-' . $Code_parametre]++;
            Hook_a_parametre_utilisateur::data_controller($a_parametre_utilisateur_Valeur, $a_parametre_utilisateur_Actif, $Code_utilisateur, $Code_parametre, false);
            $a_parametre_utilisateur = $this->mf_get_2( $Code_utilisateur, $Code_parametre, array('autocompletion' => false) );
            $mf_colonnes_a_modifier=[];
            $bool__a_parametre_utilisateur_Valeur = false; if ( $a_parametre_utilisateur_Valeur!=$a_parametre_utilisateur['a_parametre_utilisateur_Valeur'] ) { Hook_a_parametre_utilisateur::data_controller__a_parametre_utilisateur_Valeur($a_parametre_utilisateur['a_parametre_utilisateur_Valeur'], $a_parametre_utilisateur_Valeur, $Code_utilisateur, $Code_parametre); if ( $a_parametre_utilisateur_Valeur!=$a_parametre_utilisateur['a_parametre_utilisateur_Valeur'] ) { $mf_colonnes_a_modifier[] = 'a_parametre_utilisateur_Valeur=' . format_sql('a_parametre_utilisateur_Valeur', $a_parametre_utilisateur_Valeur); $bool__a_parametre_utilisateur_Valeur = true; } }
            $bool__a_parametre_utilisateur_Actif = false; if ( $a_parametre_utilisateur_Actif!=$a_parametre_utilisateur['a_parametre_utilisateur_Actif'] ) { Hook_a_parametre_utilisateur::data_controller__a_parametre_utilisateur_Actif($a_parametre_utilisateur['a_parametre_utilisateur_Actif'], $a_parametre_utilisateur_Actif, $Code_utilisateur, $Code_parametre); if ( $a_parametre_utilisateur_Actif!=$a_parametre_utilisateur['a_parametre_utilisateur_Actif'] ) { $mf_colonnes_a_modifier[] = 'a_parametre_utilisateur_Actif=' . format_sql('a_parametre_utilisateur_Actif', $a_parametre_utilisateur_Actif); $bool__a_parametre_utilisateur_Actif = true; } }
            if (count($mf_colonnes_a_modifier)>0) {
                $requete = 'UPDATE ' . inst('a_parametre_utilisateur') . ' SET ' . enumeration($mf_colonnes_a_modifier) . " WHERE Code_utilisateur=$Code_utilisateur AND Code_parametre=$Code_parametre;";
                executer_requete_mysql($requete, array_search('a_parametre_utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
                if (requete_mysqli_affected_rows() == 0) {
                    $code_erreur = ERR_A_PARAMETRE_UTILISATEUR__MODIFIER__AUCUN_CHANGEMENT;
                } else {
                    self::$cache_db->clear();
                    Hook_a_parametre_utilisateur::modifier($Code_utilisateur, $Code_parametre, $bool__a_parametre_utilisateur_Valeur, $bool__a_parametre_utilisateur_Actif);
                }
            } else {
                $code_erreur = ERR_A_PARAMETRE_UTILISATEUR__MODIFIER__AUCUN_CHANGEMENT;
            }
            self::$lock[$Code_utilisateur . '-' . $Code_parametre]--;
            if (self::$lock[$Code_utilisateur . '-' . $Code_parametre] == 0) {
                self::$cache_db->release_lock($Code_utilisateur . '-' . $Code_parametre);
                unset(self::$lock[$Code_utilisateur . '-' . $Code_parametre]);
            }
        }
        if ($code_erreur != 0) {
            global $mf_message_erreur_personalise, $mf_libelle_erreur;
            if ($mf_message_erreur_personalise != '') {
                $mf_libelle_erreur[$code_erreur] = $mf_message_erreur_personalise;
                $mf_message_erreur_personalise = '';
            }
        }
        return array('code_erreur' => $code_erreur, 'callback' => ( $code_erreur == 0 ? Hook_a_parametre_utilisateur::callback_put($Code_utilisateur, $Code_parametre) : null ));
    }

    public function mf_modifier_2(array $lignes, ?bool $force = null) // array( array('Code_' => $Code, ..., 'colonne1' => 'valeur1', [...] ), [...] )
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        foreach ($lignes as $colonnes) {
            if ($code_erreur == 0) {
                $Code_utilisateur = (int) ( isset($colonnes['Code_utilisateur']) ? $colonnes['Code_utilisateur'] : 0 );
                $Code_parametre = (int) ( isset($colonnes['Code_parametre']) ? $colonnes['Code_parametre'] : 0 );
                $a_parametre_utilisateur = $this->mf_get_2($Code_utilisateur, $Code_parametre, array('autocompletion' => false));
                if (!$force)
                {
                    if (!self::$maj_droits_modifier_en_cours)
                    {
                        self::$maj_droits_modifier_en_cours = true;
                        Hook_a_parametre_utilisateur::hook_actualiser_les_droits_modifier($Code_utilisateur, $Code_parametre);
                        self::$maj_droits_modifier_en_cours = false;
                    }
                }
                $a_parametre_utilisateur_Valeur = (int) ( isset($colonnes['a_parametre_utilisateur_Valeur']) && ( $force || mf_matrice_droits(['api_modifier__a_parametre_utilisateur_Valeur', 'a_parametre_utilisateur__MODIFIER']) ) ? $colonnes['a_parametre_utilisateur_Valeur'] : ( isset($a_parametre_utilisateur['a_parametre_utilisateur_Valeur']) ? $a_parametre_utilisateur['a_parametre_utilisateur_Valeur'] : '' ) );
                $a_parametre_utilisateur_Actif = (int) ( isset($colonnes['a_parametre_utilisateur_Actif']) && ( $force || mf_matrice_droits(['api_modifier__a_parametre_utilisateur_Actif', 'a_parametre_utilisateur__MODIFIER']) ) ? $colonnes['a_parametre_utilisateur_Actif'] : ( isset($a_parametre_utilisateur['a_parametre_utilisateur_Actif']) ? $a_parametre_utilisateur['a_parametre_utilisateur_Actif'] : '' ) );
                $retour = $this->mf_modifier($Code_utilisateur, $Code_parametre, $a_parametre_utilisateur_Valeur, $a_parametre_utilisateur_Actif, true);
                if ($retour['code_erreur'] != 0 && $retour['code_erreur'] != ERR_A_PARAMETRE_UTILISATEUR__MODIFIER__AUCUN_CHANGEMENT) {
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

    public function mf_modifier_3(array $lignes) // array( array('Code_' => $Code, ..., 'colonne1' => 'valeur1', [...] ), [...] )
    {
        $code_erreur = 0;
        $modifs = false;

        // transformation des lignes en colonnes
        $valeurs_en_colonnes=array();
        $liste_valeurs_indexees=array();
        foreach ( $lignes as $colonnes )
        {
            foreach ($colonnes as $colonne => $valeur)
            {
                if ( $colonne=='a_parametre_utilisateur_Valeur' || $colonne=='a_parametre_utilisateur_Actif' )
                {
                    if ( isset($colonnes['Code_utilisateur']) && isset($colonnes['Code_parametre']) )
                    {
                        $valeurs_en_colonnes[$colonne]['Code_utilisateur='.$colonnes['Code_utilisateur'] . ' AND ' . 'Code_parametre='.$colonnes['Code_parametre']]=$valeur;
                        $liste_valeurs_indexees[$colonne][''.$valeur][]='Code_utilisateur='.$colonnes['Code_utilisateur'] . ' AND ' . 'Code_parametre='.$colonnes['Code_parametre'];
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
                executer_requete_mysql('UPDATE ' . inst('a_parametre_utilisateur') . ' SET ' . $colonne . ' = ' . $modification_sql . ' WHERE ' . $perimetre . ';', array_search('a_parametre_utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
                if (requete_mysqli_affected_rows() != 0) {
                    $modifs = true;
                }
            } else {
                foreach ($liste_valeurs_indexees[$colonne] as $valeur => $indices_par_valeur) {
                    $perimetre = '';
                    foreach ($indices_par_valeur as $conditions) {
                        $perimetre .= ($perimetre!='' ? ' OR ' : '') . $conditions;
                    }
                    executer_requete_mysql('UPDATE ' . inst('a_parametre_utilisateur') . ' SET ' . $colonne . ' = ' . format_sql($colonne, $valeur) . ' WHERE ' . $perimetre . ';', array_search('a_parametre_utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
                    if (requete_mysqli_affected_rows() != 0) {
                        $modifs = true;
                    }
                }
            }
        }

        if (! $modifs && $code_erreur == 0) {
            $code_erreur = ERR_A_PARAMETRE_UTILISATEUR__MODIFIER_3__AUCUN_CHANGEMENT;
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

    public function mf_modifier_4(int $Code_utilisateur, int $Code_parametre, array $data, ?array $options = null ) // $data = array('colonne1' => 'valeur1', ... ) / $options = [ 'cond_mysql' => [], 'limit' => 0 ]
    {
        if ($options === null) {
            $options=[];
        }
        $code_erreur = 0;
        $Code_utilisateur = round($Code_utilisateur);
        $Code_parametre = round($Code_parametre);
        $mf_colonnes_a_modifier=[];
        if ( isset($data['a_parametre_utilisateur_Valeur']) ) { $mf_colonnes_a_modifier[] = 'a_parametre_utilisateur_Valeur = ' . format_sql('a_parametre_utilisateur_Valeur', $data['a_parametre_utilisateur_Valeur']); }
        if ( isset($data['a_parametre_utilisateur_Actif']) ) { $mf_colonnes_a_modifier[] = 'a_parametre_utilisateur_Actif = ' . format_sql('a_parametre_utilisateur_Actif', $data['a_parametre_utilisateur_Actif']); }
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

            $requete = 'UPDATE ' . inst('a_parametre_utilisateur') . ' SET ' . enumeration($mf_colonnes_a_modifier) . " WHERE 1".( $Code_utilisateur!=0 ? " AND Code_utilisateur=$Code_utilisateur" : "" )."".( $Code_parametre!=0 ? " AND Code_parametre=$Code_parametre" : "" )."$argument_cond" . ( $limit>0 ? ' LIMIT ' . $limit : '' ) . ";";
            executer_requete_mysql( $requete , array_search('a_parametre_utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            if (requete_mysqli_affected_rows() == 0) {
                $code_erreur = ERR_A_PARAMETRE_UTILISATEUR__MODIFIER_4__AUCUN_CHANGEMENT;
            } else {
                self::$cache_db->clear();
            }
        }
        return array('code_erreur' => $code_erreur);
    }

    public function mf_supprimer(?int $Code_utilisateur = null, ?int $Code_parametre = null, ?bool $force = null)
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        $Code_utilisateur = round($Code_utilisateur);
        $Code_parametre = round($Code_parametre);
        $copie__liste_a_parametre_utilisateur = $this->mf_lister($Code_utilisateur, $Code_parametre, array('autocompletion' => false));
        $liste_Code_utilisateur = array();
        $liste_Code_parametre = array();
        foreach ( $copie__liste_a_parametre_utilisateur as $copie__a_parametre_utilisateur )
        {
            $Code_utilisateur = $copie__a_parametre_utilisateur['Code_utilisateur'];
            $Code_parametre = $copie__a_parametre_utilisateur['Code_parametre'];
            if (!$force)
            {
                if (!self::$maj_droits_supprimer_en_cours)
                {
                    self::$maj_droits_supprimer_en_cours = true;
                    Hook_a_parametre_utilisateur::hook_actualiser_les_droits_supprimer($Code_utilisateur, $Code_parametre);
                    self::$maj_droits_supprimer_en_cours = false;
                }
            }
            if ( !$force && !mf_matrice_droits(['a_parametre_utilisateur__SUPPRIMER']) ) $code_erreur = REFUS_A_PARAMETRE_UTILISATEUR__SUPPRIMER;
            elseif ( !Hook_a_parametre_utilisateur::autorisation_suppression($Code_utilisateur, $Code_parametre) ) $code_erreur = REFUS_A_PARAMETRE_UTILISATEUR__SUPPRESSION_BLOQUEE;
            {
                $liste_Code_utilisateur[] = $Code_utilisateur;
                $liste_Code_parametre[] = $Code_parametre;
            }
        }
        if ($code_erreur == 0 && count($liste_Code_utilisateur)>0 && count($liste_Code_parametre)>0) {
            $requete = 'DELETE IGNORE FROM ' . inst('a_parametre_utilisateur') . " WHERE Code_utilisateur IN ".Sql_Format_Liste($liste_Code_utilisateur)." AND Code_parametre IN ".Sql_Format_Liste($liste_Code_parametre).";";
            executer_requete_mysql( $requete , array_search('a_parametre_utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            if (requete_mysqli_affected_rows() == 0) {
                $code_erreur = ERR_A_PARAMETRE_UTILISATEUR__SUPPRIMER__REFUSE;
            } else {
                self::$cache_db->clear();
                Hook_a_parametre_utilisateur::supprimer($copie__liste_a_parametre_utilisateur);
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

    public function mf_supprimer_2(?int $Code_utilisateur = null, ?int $Code_parametre = null)
    {
        $code_erreur = 0;
        $Code_utilisateur = round($Code_utilisateur);
        $Code_parametre = round($Code_parametre);
        $copie__liste_a_parametre_utilisateur = $this->mf_lister_2($Code_utilisateur, $Code_parametre, array('autocompletion' => false));
        $requete = 'DELETE IGNORE FROM ' . inst('a_parametre_utilisateur') . " WHERE 1".( $Code_utilisateur!=0 ? " AND Code_utilisateur=$Code_utilisateur" : "" )."".( $Code_parametre!=0 ? " AND Code_parametre=$Code_parametre" : "" ).";";
        executer_requete_mysql( $requete , array_search('a_parametre_utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        if ( requete_mysqli_affected_rows()==0 )
        {
            $code_erreur = ERR_A_PARAMETRE_UTILISATEUR__SUPPRIMER_2__REFUSE;
        } else {
            self::$cache_db->clear();
            Hook_a_parametre_utilisateur::supprimer($copie__liste_a_parametre_utilisateur);
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
        return $this->mf_lister(isset($est_charge['utilisateur']) ? $mf_contexte['Code_utilisateur'] : 0, isset($est_charge['parametre']) ? $mf_contexte['Code_parametre'] : 0, $options);
    }

    public function mf_lister(?int $Code_utilisateur = null, ?int $Code_parametre = null, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $liste = $this->mf_lister_2($Code_utilisateur, $Code_parametre, $options);

        // controle_acces_donnees
        $controle_acces_donnees = CONTROLE_ACCES_DONNEES_DEFAUT;
        if (isset($options['controle_acces_donnees']))
        {
            $controle_acces_donnees = ( $options['controle_acces_donnees']==true );
        }

        foreach ($liste as $key => $elem)
        {
            if ( $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_utilisateur', $elem['Code_utilisateur']) || $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_parametre', $elem['Code_parametre']) )
            {
                unset($liste[$key]);
            }
        }

        return $liste;
    }

    public function mf_lister_2(?int $Code_utilisateur = null, ?int $Code_parametre = null, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cle = 'a_parametre_utilisateur__lister';
        $Code_utilisateur = round($Code_utilisateur);
        $cle .= "_{$Code_utilisateur}";
        $Code_parametre = round($Code_parametre);
        $cle .= "_{$Code_parametre}";

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
            if ( isset($mf_tri_defaut_table['a_parametre_utilisateur']) )
            {
                $options['tris'] = $mf_tri_defaut_table['a_parametre_utilisateur'];
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
                if ( strpos($argument_cond, 'a_parametre_utilisateur_Valeur')!==false ) { $liste_colonnes_a_indexer['a_parametre_utilisateur_Valeur'] = 'a_parametre_utilisateur_Valeur'; }
                if ( strpos($argument_cond, 'a_parametre_utilisateur_Actif')!==false ) { $liste_colonnes_a_indexer['a_parametre_utilisateur_Actif'] = 'a_parametre_utilisateur_Actif'; }
            }
            if (isset($options['tris'])) {
                if ( isset($options['tris']['a_parametre_utilisateur_Valeur']) ) { $liste_colonnes_a_indexer['a_parametre_utilisateur_Valeur'] = 'a_parametre_utilisateur_Valeur'; }
                if ( isset($options['tris']['a_parametre_utilisateur_Actif']) ) { $liste_colonnes_a_indexer['a_parametre_utilisateur_Actif'] = 'a_parametre_utilisateur_Actif'; }
            }
            if (count($liste_colonnes_a_indexer) > 0) {
                if (false === $mf_liste_requete_index = self::$cache_db->read('a_parametre_utilisateur__index')) {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('a_parametre_utilisateur').'`;', false);
                    $mf_liste_requete_index = array();
                    while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    self::$cache_db->write('a_parametre_utilisateur__index', $mf_liste_requete_index);
                }
                foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if (count($liste_colonnes_a_indexer) > 0) {
                    foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                        executer_requete_mysql('ALTER TABLE `'.inst('a_parametre_utilisateur').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    self::$cache_db->clear();
                }
            }

            $liste = array();
            if ($toutes_colonnes) {
                $colonnes='a_parametre_utilisateur_Valeur, a_parametre_utilisateur_Actif, Code_utilisateur, Code_parametre';
            } else {
                $colonnes='a_parametre_utilisateur_Valeur, a_parametre_utilisateur_Actif, Code_utilisateur, Code_parametre';
            }
            $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM '.inst('a_parametre_utilisateur')." WHERE 1{$argument_cond}".( $Code_utilisateur!=0 ? " AND Code_utilisateur=$Code_utilisateur" : "" )."".( $Code_parametre!=0 ? " AND Code_parametre=$Code_parametre" : "" )."{$argument_tris}{$argument_limit};", false);
            while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                mf_formatage_db_type_php($row_requete);
                $liste[$row_requete['Code_utilisateur'].'-'.$row_requete['Code_parametre']] = $row_requete;
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
                Hook_a_parametre_utilisateur::completion($element, self::$auto_completion - 1);
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

    public function mf_get(int $Code_utilisateur, int $Code_parametre, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cle = "a_parametre_utilisateur__get";
        $Code_utilisateur = round($Code_utilisateur);
        $cle .= "_{$Code_utilisateur}";
        $Code_parametre = round($Code_parametre);
        $cle .= "_{$Code_parametre}";
        $retour = array();
        if (! CONTROLE_ACCES_DONNEES_DEFAUT || Hook_mf_systeme::controle_acces_donnees('Code_utilisateur', $Code_utilisateur) && Hook_mf_systeme::controle_acces_donnees('Code_parametre', $Code_parametre)) {

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
                    $colonnes='a_parametre_utilisateur_Valeur, a_parametre_utilisateur_Actif, Code_utilisateur, Code_parametre';
                } else {
                    $colonnes='a_parametre_utilisateur_Valeur, a_parametre_utilisateur_Actif, Code_utilisateur, Code_parametre';
                }
                $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM ' . inst('a_parametre_utilisateur')." WHERE Code_utilisateur=$Code_utilisateur AND Code_parametre=$Code_parametre;", false);
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
                    Hook_a_parametre_utilisateur::completion($retour, self::$auto_completion - 1);
                    self::$auto_completion --;
                }
            }
        }
        return $retour;
    }

    public function mf_get_2(int $Code_utilisateur, int $Code_parametre, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cle = "a_parametre_utilisateur__get";
        $Code_utilisateur = round($Code_utilisateur);
        $cle .= "_{$Code_utilisateur}";
        $Code_parametre = round($Code_parametre);
        $cle .= "_{$Code_parametre}";

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
                $colonnes='a_parametre_utilisateur_Valeur, a_parametre_utilisateur_Actif, Code_utilisateur, Code_parametre';
            } else {
                $colonnes='a_parametre_utilisateur_Valeur, a_parametre_utilisateur_Actif, Code_utilisateur, Code_parametre';
            }
            $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM ' . inst('a_parametre_utilisateur')." WHERE Code_utilisateur=$Code_utilisateur AND Code_parametre=$Code_parametre;", false);
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
                Hook_a_parametre_utilisateur::completion($retour, self::$auto_completion - 1);
                self::$auto_completion --;
            }
        }
        return $retour;
    }

    public function mf_compter(?int $Code_utilisateur = null, ?int $Code_parametre = null, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cle = 'a_parametre_utilisateur__compter';
        $Code_utilisateur = round($Code_utilisateur);
        $cle .= '_{'.$Code_utilisateur.'}';
        $Code_parametre = round($Code_parametre);
        $cle .= '_{'.$Code_parametre.'}';

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
                if ( strpos($argument_cond, 'a_parametre_utilisateur_Valeur')!==false ) { $liste_colonnes_a_indexer['a_parametre_utilisateur_Valeur'] = 'a_parametre_utilisateur_Valeur'; }
                if ( strpos($argument_cond, 'a_parametre_utilisateur_Actif')!==false ) { $liste_colonnes_a_indexer['a_parametre_utilisateur_Actif'] = 'a_parametre_utilisateur_Actif'; }
            }
            if (count($liste_colonnes_a_indexer) > 0) {
                if (false === $mf_liste_requete_index = self::$cache_db->read('a_parametre_utilisateur__index')) {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('a_parametre_utilisateur').'`;', false);
                    $mf_liste_requete_index = array();
                    while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    self::$cache_db->write('a_parametre_utilisateur__index', $mf_liste_requete_index);
                }
                foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if (count($liste_colonnes_a_indexer) > 0) {
                    foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                        executer_requete_mysql('ALTER TABLE `'.inst('a_parametre_utilisateur').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    self::$cache_db->clear();
                }
            }

            $res_requete = executer_requete_mysql("SELECT COUNT(CONCAT(Code_utilisateur,'|',Code_parametre)) as nb FROM ".inst('a_parametre_utilisateur')." WHERE 1{$argument_cond}".( $Code_utilisateur!=0 ? " AND Code_utilisateur=$Code_utilisateur" : "" )."".( $Code_parametre!=0 ? " AND Code_parametre=$Code_parametre" : "" ).";", false);
            $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC);
            mysqli_free_result($res_requete);
            $nb = (int) $row_requete['nb'];
            self::$cache_db->write($cle, $nb);
        }
        return $nb;
    }

    public function mf_liste_Code_utilisateur_vers_liste_Code_parametre( array $liste_Code_utilisateur, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ($options === null) {
            $options=[];
        }
        return $this->a_parametre_utilisateur_liste_Code_utilisateur_vers_liste_Code_parametre( $liste_Code_utilisateur , $options );
    }

    public function mf_liste_Code_parametre_vers_liste_Code_utilisateur( array $liste_Code_parametre, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ($options === null) {
            $options=[];
        }
        return $this->a_parametre_utilisateur_liste_Code_parametre_vers_liste_Code_utilisateur( $liste_Code_parametre , $options );
    }
}
