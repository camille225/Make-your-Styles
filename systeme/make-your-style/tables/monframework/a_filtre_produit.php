<?php

/*
    +------------------------------+
    |  NE PAS MODIFIER CE FICHIER  |
    +------------------------------+
*/

class a_filtre_produit_monframework extends entite_monframework
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
            include_once __DIR__ . '/../../erreurs/erreurs__a_filtre_produit.php';
            self::$initialisation = false;
            Hook_a_filtre_produit::initialisation();
            self::$cache_db = new Mf_Cachedb('a_filtre_produit');
        }
        if (!self::$actualisation_en_cours)
        {
            self::$actualisation_en_cours=true;
            Hook_a_filtre_produit::actualisation();
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

        if (! test_si_table_existe(inst('a_filtre_produit'))) {
            executer_requete_mysql('CREATE TABLE '.inst('a_filtre_produit').' (Code_filtre INT NOT NULL, Code_article INT NOT NULL, PRIMARY KEY (Code_filtre, Code_article)) ENGINE=MyISAM;', array_search('a_filtre_produit', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        $liste_colonnes = lister_les_colonnes(inst('a_filtre_produit'));

        if (isset($liste_colonnes['a_filtre_produit_Actif'])) {
            if (typeMyql2Sql($liste_colonnes['a_filtre_produit_Actif']['Type'])!='INT') {
                executer_requete_mysql('ALTER TABLE '.inst('a_filtre_produit').' CHANGE a_filtre_produit_Actif a_filtre_produit_Actif INT;', array_search('a_filtre_produit', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['a_filtre_produit_Actif']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('a_filtre_produit').' ADD a_filtre_produit_Actif INT;', array_search('a_filtre_produit', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE '.inst('a_filtre_produit').' SET a_filtre_produit_Actif=' . format_sql('a_filtre_produit_Actif', $mf_initialisation['a_filtre_produit_Actif']) . ';', array_search('a_filtre_produit', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        unset($liste_colonnes['Code_filtre']);
        unset($liste_colonnes['Code_article']);

        foreach ($liste_colonnes as $field => $value) {
            executer_requete_mysql('ALTER TABLE '.inst('a_filtre_produit').' DROP COLUMN '.$field.';', array_search('a_filtre_produit', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

    }

    public function mfi_ajouter_auto(array $interface)
    {
        if (isset($interface['Code_filtre'])) {
            $liste_Code_filtre = array($interface['Code_filtre']);
            $liste_Code_filtre = $this->__get_liste_Code_filtre([OPTION_COND_MYSQL=>['Code_filtre IN ' . Sql_Format_Liste($liste_Code_filtre)]]);
        } elseif (isset($interface['liste_Code_filtre'])) {
            $liste_Code_filtre = $interface['liste_Code_filtre'];
            $liste_Code_filtre = $this->__get_liste_Code_filtre([OPTION_COND_MYSQL=>['Code_filtre IN ' . Sql_Format_Liste($liste_Code_filtre)]]);
        } else {
            $liste_Code_filtre = $this->get_liste_Code_filtre();
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
        $res_requete = executer_requete_mysql('SELECT Code_filtre, Code_article FROM ' . inst('a_filtre_produit') . ' WHERE Code_filtre IN ' . Sql_Format_Liste($liste_Code_filtre) . ' AND Code_article IN ' . Sql_Format_Liste($liste_Code_article) . ';', false);
        while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
            $mf_index[(int) $row_requete['Code_filtre']][(int) $row_requete['Code_article']] = 1;
        }
        mysqli_free_result($res_requete);
        $liste_a_filtre_produit = array();
        foreach ($liste_Code_filtre as $Code_filtre) {
            foreach ($liste_Code_article as $Code_article) {
                if (! isset($mf_index[$Code_filtre][$Code_article])) {
                    $liste_a_filtre_produit[] = array('Code_filtre'=>$Code_filtre,'Code_article'=>$Code_article);
                }
            }
        }
        if (isset($interface['a_filtre_produit_Actif'])) {
            foreach ($liste_a_filtre_produit as &$a_filtre_produit) {
                $a_filtre_produit['a_filtre_produit_Actif'] = $interface['a_filtre_produit_Actif'];
            }
            unset($a_filtre_produit);
        }
        return $this->mf_ajouter_3($liste_a_filtre_produit);
    }

    public function mfi_supprimer_auto(array $interface)
    {
        if (isset($interface['Code_filtre'])) {
            $liste_Code_filtre = array($interface['Code_filtre']);
        } elseif (isset($interface['liste_Code_filtre'])) {
            $liste_Code_filtre = $interface['liste_Code_filtre'];
        } else {
            $liste_Code_filtre = $this->get_liste_Code_filtre();
        }
        if (isset($interface['Code_article'])) {
            $liste_Code_article = array($interface['Code_article']);
        } elseif (isset($interface['liste_Code_article'])) {
            $liste_Code_article = $interface['liste_Code_article'];
        } else {
            $liste_Code_article = $this->get_liste_Code_article();
        }
        $mf_index = [];
        $res_requete = executer_requete_mysql('SELECT Code_filtre, Code_article FROM ' . inst('a_filtre_produit') . ' WHERE Code_filtre IN ' . Sql_Format_Liste($liste_Code_filtre) . ' AND Code_article IN ' . Sql_Format_Liste($liste_Code_article) . ';', false);
        while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
            $mf_index[(int) $row_requete['Code_filtre']][(int) $row_requete['Code_article']] = 1;
        }
        mysqli_free_result($res_requete);
        foreach ($liste_Code_filtre as &$Code_filtre) {
            if (isset($mf_index[$Code_filtre])) {
                foreach ($liste_Code_article as &$Code_article) {
                    if (isset($mf_index[$Code_filtre][$Code_article])) {
                        $this->mf_supprimer_2($Code_filtre, $Code_article);
                    }
                }
            }
        }
    }

    public function mf_ajouter(int $Code_filtre, int $Code_article, int $a_filtre_produit_Actif, ?bool $force = null)
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        $Code_filtre = round($Code_filtre);
        $Code_article = round($Code_article);
        $a_filtre_produit_Actif = round($a_filtre_produit_Actif);
        Hook_a_filtre_produit::pre_controller($a_filtre_produit_Actif, $Code_filtre, $Code_article, true);
        if (! $force) {
            if (!self::$maj_droits_ajouter_en_cours)
            {
                self::$maj_droits_ajouter_en_cours = true;
                Hook_a_filtre_produit::hook_actualiser_les_droits_ajouter($Code_filtre, $Code_article);
                self::$maj_droits_ajouter_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['a_filtre_produit__AJOUTER']) ) $code_erreur = REFUS_A_FILTRE_PRODUIT__AJOUTER;
        elseif ( !$this->mf_tester_existance_Code_filtre($Code_filtre) ) $code_erreur = ERR_A_FILTRE_PRODUIT__AJOUTER__CODE_FILTRE_INEXISTANT;
        elseif ( !$this->mf_tester_existance_Code_article($Code_article) ) $code_erreur = ERR_A_FILTRE_PRODUIT__AJOUTER__CODE_ARTICLE_INEXISTANT;
        elseif ( $this->mf_tester_existance_a_filtre_produit( $Code_filtre, $Code_article ) ) $code_erreur = ERR_A_FILTRE_PRODUIT__AJOUTER__DOUBLON;
        elseif (CONTROLE_ACCES_DONNEES_DEFAUT && ! Hook_mf_systeme::controle_acces_donnees('Code_filtre', $Code_filtre)) $code_erreur = ACCES_CODE_FILTRE_REFUSE;
        elseif (CONTROLE_ACCES_DONNEES_DEFAUT && ! Hook_mf_systeme::controle_acces_donnees('Code_article', $Code_article)) $code_erreur = ACCES_CODE_ARTICLE_REFUSE;
        elseif ( !Hook_a_filtre_produit::autorisation_ajout($a_filtre_produit_Actif, $Code_filtre, $Code_article) ) $code_erreur = REFUS_A_FILTRE_PRODUIT__AJOUT_BLOQUEE;
        else
        {
            Hook_a_filtre_produit::data_controller($a_filtre_produit_Actif, $Code_filtre, $Code_article, true);
            $a_filtre_produit_Actif = round($a_filtre_produit_Actif);
            $requete = 'INSERT INTO '.inst('a_filtre_produit')." ( a_filtre_produit_Actif, Code_filtre, Code_article ) VALUES ( $a_filtre_produit_Actif, $Code_filtre, $Code_article );";
            executer_requete_mysql($requete, array_search('a_filtre_produit', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            $n = requete_mysqli_affected_rows();
            if ($n == 0) {
                $code_erreur = ERR_A_FILTRE_PRODUIT__AJOUTER__REFUSE;
            } else {
                self::$cache_db->clear();
                Hook_a_filtre_produit::ajouter($Code_filtre, $Code_article);
            }
        }
        if ($code_erreur != 0) {
            global $mf_message_erreur_personalise, $mf_libelle_erreur;
            if ($mf_message_erreur_personalise != '') {
                $mf_libelle_erreur[$code_erreur] = $mf_message_erreur_personalise;
                $mf_message_erreur_personalise = '';
            }
        }
        return array('code_erreur' => $code_erreur, 'callback' => ( $code_erreur==0 ? Hook_a_filtre_produit::callback_post($Code_filtre, $Code_article) : null ));
    }

    public function mf_ajouter_2(array $ligne, ?bool $force = null) // array('colonne1' => 'valeur1',  [...] )
    {
        if ($force === null) {
            $force = false;
        }
        global $mf_initialisation;
        $Code_filtre = (int)(isset($ligne['Code_filtre'])?round($ligne['Code_filtre']):0);
        $Code_article = (int)(isset($ligne['Code_article'])?round($ligne['Code_article']):0);
        $a_filtre_produit_Actif = (int)(isset($ligne['a_filtre_produit_Actif'])?$ligne['a_filtre_produit_Actif']:$mf_initialisation['a_filtre_produit_Actif']);
        return $this->mf_ajouter($Code_filtre, $Code_article, $a_filtre_produit_Actif, $force);
    }

    public function mf_ajouter_3(array $lignes) // array( array( 'colonne1' => 'valeur1', 'colonne2' => 'valeur2',  [...] ), [...] )
    {
        global $mf_initialisation;
        $code_erreur = 0;
        $values = '';
        foreach ($lignes as $ligne) {
            $Code_filtre = (isset($ligne['Code_filtre'])?round($ligne['Code_filtre']):0);
            $Code_article = (isset($ligne['Code_article'])?round($ligne['Code_article']):0);
            $a_filtre_produit_Actif = round(isset($ligne['a_filtre_produit_Actif'])?$ligne['a_filtre_produit_Actif']:$mf_initialisation['a_filtre_produit_Actif']);
            if ($Code_filtre != 0) {
                if ($Code_article != 0) {
                    $values .= ($values!='' ? ',' : '')."($a_filtre_produit_Actif, $Code_filtre, $Code_article)";
                }
            }
        }
        if ($values != '') {
            $requete = "INSERT INTO ".inst('a_filtre_produit')." ( a_filtre_produit_Actif, Code_filtre, Code_article ) VALUES $values;";
            executer_requete_mysql($requete, array_search('a_filtre_produit', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            $n = requete_mysqli_affected_rows();
            if ($n < count($lignes)) {
                $code_erreur = ERR_A_FILTRE_PRODUIT__AJOUTER_3__ECHEC_AJOUT;
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

    public function mf_modifier(int $Code_filtre, int $Code_article, int $a_filtre_produit_Actif, ?bool $force = null)
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        $Code_filtre = round($Code_filtre);
        $Code_article = round($Code_article);
        $a_filtre_produit_Actif = round($a_filtre_produit_Actif);
        Hook_a_filtre_produit::pre_controller($a_filtre_produit_Actif, $Code_filtre, $Code_article, false);
        if (!$force)
        {
            if (!self::$maj_droits_modifier_en_cours)
            {
                self::$maj_droits_modifier_en_cours = true;
                Hook_a_filtre_produit::hook_actualiser_les_droits_modifier($Code_filtre, $Code_article);
                self::$maj_droits_modifier_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['a_filtre_produit__MODIFIER']) ) $code_erreur = REFUS_A_FILTRE_PRODUIT__MODIFIER;
        elseif ( !$this->mf_tester_existance_Code_filtre($Code_filtre) ) $code_erreur = ERR_A_FILTRE_PRODUIT__MODIFIER__CODE_FILTRE_INEXISTANT;
        elseif ( !$this->mf_tester_existance_Code_article($Code_article) ) $code_erreur = ERR_A_FILTRE_PRODUIT__MODIFIER__CODE_ARTICLE_INEXISTANT;
        elseif ( !$this->mf_tester_existance_a_filtre_produit( $Code_filtre, $Code_article ) ) $code_erreur = ERR_A_FILTRE_PRODUIT__MODIFIER__INEXISTANT;
        elseif (CONTROLE_ACCES_DONNEES_DEFAUT && ! Hook_mf_systeme::controle_acces_donnees('Code_filtre', $Code_filtre)) $code_erreur = ACCES_CODE_FILTRE_REFUSE;
        elseif (CONTROLE_ACCES_DONNEES_DEFAUT && ! Hook_mf_systeme::controle_acces_donnees('Code_article', $Code_article)) $code_erreur = ACCES_CODE_ARTICLE_REFUSE;
        elseif ( !Hook_a_filtre_produit::autorisation_modification($Code_filtre, $Code_article, $a_filtre_produit_Actif) ) $code_erreur = REFUS_A_FILTRE_PRODUIT__MODIFICATION_BLOQUEE;
        else
        {
            if (! isset(self::$lock[$Code_filtre . '-' . $Code_article])) {
                self::$lock[$Code_filtre . '-' . $Code_article] = 0;
            }
            if (self::$lock[$Code_filtre . '-' . $Code_article] == 0) {
                self::$cache_db->add_lock($Code_filtre . '-' . $Code_article);
            }
            self::$lock[$Code_filtre . '-' . $Code_article]++;
            Hook_a_filtre_produit::data_controller($a_filtre_produit_Actif, $Code_filtre, $Code_article, false);
            $a_filtre_produit = $this->mf_get_2( $Code_filtre, $Code_article, array('autocompletion' => false) );
            $mf_colonnes_a_modifier=[];
            $bool__a_filtre_produit_Actif = false; if ( $a_filtre_produit_Actif!=$a_filtre_produit['a_filtre_produit_Actif'] ) { Hook_a_filtre_produit::data_controller__a_filtre_produit_Actif($a_filtre_produit['a_filtre_produit_Actif'], $a_filtre_produit_Actif, $Code_filtre, $Code_article); if ( $a_filtre_produit_Actif!=$a_filtre_produit['a_filtre_produit_Actif'] ) { $mf_colonnes_a_modifier[] = 'a_filtre_produit_Actif=' . format_sql('a_filtre_produit_Actif', $a_filtre_produit_Actif); $bool__a_filtre_produit_Actif = true; } }
            if (count($mf_colonnes_a_modifier)>0) {
                $requete = 'UPDATE ' . inst('a_filtre_produit') . ' SET ' . enumeration($mf_colonnes_a_modifier) . " WHERE Code_filtre=$Code_filtre AND Code_article=$Code_article;";
                executer_requete_mysql($requete, array_search('a_filtre_produit', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
                if (requete_mysqli_affected_rows() == 0) {
                    $code_erreur = ERR_A_FILTRE_PRODUIT__MODIFIER__AUCUN_CHANGEMENT;
                } else {
                    self::$cache_db->clear();
                    Hook_a_filtre_produit::modifier($Code_filtre, $Code_article, $bool__a_filtre_produit_Actif);
                }
            } else {
                $code_erreur = ERR_A_FILTRE_PRODUIT__MODIFIER__AUCUN_CHANGEMENT;
            }
            self::$lock[$Code_filtre . '-' . $Code_article]--;
            if (self::$lock[$Code_filtre . '-' . $Code_article] == 0) {
                self::$cache_db->release_lock($Code_filtre . '-' . $Code_article);
                unset(self::$lock[$Code_filtre . '-' . $Code_article]);
            }
        }
        if ($code_erreur != 0) {
            global $mf_message_erreur_personalise, $mf_libelle_erreur;
            if ($mf_message_erreur_personalise != '') {
                $mf_libelle_erreur[$code_erreur] = $mf_message_erreur_personalise;
                $mf_message_erreur_personalise = '';
            }
        }
        return array('code_erreur' => $code_erreur, 'callback' => ( $code_erreur == 0 ? Hook_a_filtre_produit::callback_put($Code_filtre, $Code_article) : null ));
    }

    public function mf_modifier_2(array $lignes, ?bool $force = null) // array( array('Code_' => $Code, ..., 'colonne1' => 'valeur1', [...] ), [...] )
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        foreach ($lignes as $colonnes) {
            if ($code_erreur == 0) {
                $Code_filtre = (int) ( isset($colonnes['Code_filtre']) ? $colonnes['Code_filtre'] : 0 );
                $Code_article = (int) ( isset($colonnes['Code_article']) ? $colonnes['Code_article'] : 0 );
                $a_filtre_produit = $this->mf_get_2($Code_filtre, $Code_article, array('autocompletion' => false));
                if (!$force)
                {
                    if (!self::$maj_droits_modifier_en_cours)
                    {
                        self::$maj_droits_modifier_en_cours = true;
                        Hook_a_filtre_produit::hook_actualiser_les_droits_modifier($Code_filtre, $Code_article);
                        self::$maj_droits_modifier_en_cours = false;
                    }
                }
                $a_filtre_produit_Actif = (int) ( isset($colonnes['a_filtre_produit_Actif']) && ( $force || mf_matrice_droits(['api_modifier__a_filtre_produit_Actif', 'a_filtre_produit__MODIFIER']) ) ? $colonnes['a_filtre_produit_Actif'] : ( isset($a_filtre_produit['a_filtre_produit_Actif']) ? $a_filtre_produit['a_filtre_produit_Actif'] : '' ) );
                $retour = $this->mf_modifier($Code_filtre, $Code_article, $a_filtre_produit_Actif, true);
                if ($retour['code_erreur'] != 0 && $retour['code_erreur'] != ERR_A_FILTRE_PRODUIT__MODIFIER__AUCUN_CHANGEMENT) {
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
                if ( $colonne=='a_filtre_produit_Actif' )
                {
                    if ( isset($colonnes['Code_filtre']) && isset($colonnes['Code_article']) )
                    {
                        $valeurs_en_colonnes[$colonne]['Code_filtre='.$colonnes['Code_filtre'] . ' AND ' . 'Code_article='.$colonnes['Code_article']]=$valeur;
                        $liste_valeurs_indexees[$colonne][''.$valeur][]='Code_filtre='.$colonnes['Code_filtre'] . ' AND ' . 'Code_article='.$colonnes['Code_article'];
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
                executer_requete_mysql('UPDATE ' . inst('a_filtre_produit') . ' SET ' . $colonne . ' = ' . $modification_sql . ' WHERE ' . $perimetre . ';', array_search('a_filtre_produit', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
                if (requete_mysqli_affected_rows() != 0) {
                    $modifs = true;
                }
            } else {
                foreach ($liste_valeurs_indexees[$colonne] as $valeur => $indices_par_valeur) {
                    $perimetre = '';
                    foreach ($indices_par_valeur as $conditions) {
                        $perimetre .= ($perimetre!='' ? ' OR ' : '') . $conditions;
                    }
                    executer_requete_mysql('UPDATE ' . inst('a_filtre_produit') . ' SET ' . $colonne . ' = ' . format_sql($colonne, $valeur) . ' WHERE ' . $perimetre . ';', array_search('a_filtre_produit', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
                    if (requete_mysqli_affected_rows() != 0) {
                        $modifs = true;
                    }
                }
            }
        }

        if (! $modifs && $code_erreur == 0) {
            $code_erreur = ERR_A_FILTRE_PRODUIT__MODIFIER_3__AUCUN_CHANGEMENT;
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

    public function mf_modifier_4(int $Code_filtre, int $Code_article, array $data, ?array $options = null ) // $data = array('colonne1' => 'valeur1', ... ) / $options = [ 'cond_mysql' => [], 'limit' => 0 ]
    {
        if ($options === null) {
            $options=[];
        }
        $code_erreur = 0;
        $Code_filtre = round($Code_filtre);
        $Code_article = round($Code_article);
        $mf_colonnes_a_modifier=[];
        if ( isset($data['a_filtre_produit_Actif']) ) { $mf_colonnes_a_modifier[] = 'a_filtre_produit_Actif = ' . format_sql('a_filtre_produit_Actif', $data['a_filtre_produit_Actif']); }
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

            $requete = 'UPDATE ' . inst('a_filtre_produit') . ' SET ' . enumeration($mf_colonnes_a_modifier) . " WHERE 1".( $Code_filtre!=0 ? " AND Code_filtre=$Code_filtre" : "" )."".( $Code_article!=0 ? " AND Code_article=$Code_article" : "" )."$argument_cond" . ( $limit>0 ? ' LIMIT ' . $limit : '' ) . ";";
            executer_requete_mysql( $requete , array_search('a_filtre_produit', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            if (requete_mysqli_affected_rows() == 0) {
                $code_erreur = ERR_A_FILTRE_PRODUIT__MODIFIER_4__AUCUN_CHANGEMENT;
            } else {
                self::$cache_db->clear();
            }
        }
        return array('code_erreur' => $code_erreur);
    }

    public function mf_supprimer(?int $Code_filtre = null, ?int $Code_article = null, ?bool $force = null)
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        $Code_filtre = round($Code_filtre);
        $Code_article = round($Code_article);
        $copie__liste_a_filtre_produit = $this->mf_lister($Code_filtre, $Code_article, array('autocompletion' => false));
        $liste_Code_filtre = array();
        $liste_Code_article = array();
        foreach ( $copie__liste_a_filtre_produit as $copie__a_filtre_produit )
        {
            $Code_filtre = $copie__a_filtre_produit['Code_filtre'];
            $Code_article = $copie__a_filtre_produit['Code_article'];
            if (!$force)
            {
                if (!self::$maj_droits_supprimer_en_cours)
                {
                    self::$maj_droits_supprimer_en_cours = true;
                    Hook_a_filtre_produit::hook_actualiser_les_droits_supprimer($Code_filtre, $Code_article);
                    self::$maj_droits_supprimer_en_cours = false;
                }
            }
            if ( !$force && !mf_matrice_droits(['a_filtre_produit__SUPPRIMER']) ) $code_erreur = REFUS_A_FILTRE_PRODUIT__SUPPRIMER;
            elseif ( !Hook_a_filtre_produit::autorisation_suppression($Code_filtre, $Code_article) ) $code_erreur = REFUS_A_FILTRE_PRODUIT__SUPPRESSION_BLOQUEE;
            {
                $liste_Code_filtre[] = $Code_filtre;
                $liste_Code_article[] = $Code_article;
            }
        }
        if ($code_erreur == 0 && count($liste_Code_filtre)>0 && count($liste_Code_article)>0) {
            $requete = 'DELETE IGNORE FROM ' . inst('a_filtre_produit') . " WHERE Code_filtre IN ".Sql_Format_Liste($liste_Code_filtre)." AND Code_article IN ".Sql_Format_Liste($liste_Code_article).";";
            executer_requete_mysql( $requete , array_search('a_filtre_produit', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            if (requete_mysqli_affected_rows() == 0) {
                $code_erreur = ERR_A_FILTRE_PRODUIT__SUPPRIMER__REFUSE;
            } else {
                self::$cache_db->clear();
                Hook_a_filtre_produit::supprimer($copie__liste_a_filtre_produit);
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

    public function mf_supprimer_2(?int $Code_filtre = null, ?int $Code_article = null)
    {
        $code_erreur = 0;
        $Code_filtre = round($Code_filtre);
        $Code_article = round($Code_article);
        $copie__liste_a_filtre_produit = $this->mf_lister_2($Code_filtre, $Code_article, array('autocompletion' => false));
        $requete = 'DELETE IGNORE FROM ' . inst('a_filtre_produit') . " WHERE 1".( $Code_filtre!=0 ? " AND Code_filtre=$Code_filtre" : "" )."".( $Code_article!=0 ? " AND Code_article=$Code_article" : "" ).";";
        executer_requete_mysql( $requete , array_search('a_filtre_produit', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        if ( requete_mysqli_affected_rows()==0 )
        {
            $code_erreur = ERR_A_FILTRE_PRODUIT__SUPPRIMER_2__REFUSE;
        } else {
            self::$cache_db->clear();
            Hook_a_filtre_produit::supprimer($copie__liste_a_filtre_produit);
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
        return $this->mf_lister(isset($est_charge['filtre']) ? $mf_contexte['Code_filtre'] : 0, isset($est_charge['article']) ? $mf_contexte['Code_article'] : 0, $options);
    }

    public function mf_lister(?int $Code_filtre = null, ?int $Code_article = null, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $liste = $this->mf_lister_2($Code_filtre, $Code_article, $options);

        // controle_acces_donnees
        $controle_acces_donnees = CONTROLE_ACCES_DONNEES_DEFAUT;
        if (isset($options['controle_acces_donnees']))
        {
            $controle_acces_donnees = ( $options['controle_acces_donnees']==true );
        }

        foreach ($liste as $key => $elem)
        {
            if ( $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_filtre', $elem['Code_filtre']) || $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_article', $elem['Code_article']) )
            {
                unset($liste[$key]);
            }
        }

        return $liste;
    }

    public function mf_lister_2(?int $Code_filtre = null, ?int $Code_article = null, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cle = 'a_filtre_produit__lister';
        $Code_filtre = round($Code_filtre);
        $cle .= "_{$Code_filtre}";
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
            if ( isset($mf_tri_defaut_table['a_filtre_produit']) )
            {
                $options['tris'] = $mf_tri_defaut_table['a_filtre_produit'];
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
                if ( strpos($argument_cond, 'a_filtre_produit_Actif')!==false ) { $liste_colonnes_a_indexer['a_filtre_produit_Actif'] = 'a_filtre_produit_Actif'; }
            }
            if (isset($options['tris'])) {
                if ( isset($options['tris']['a_filtre_produit_Actif']) ) { $liste_colonnes_a_indexer['a_filtre_produit_Actif'] = 'a_filtre_produit_Actif'; }
            }
            if (count($liste_colonnes_a_indexer) > 0) {
                if (false === $mf_liste_requete_index = self::$cache_db->read('a_filtre_produit__index')) {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('a_filtre_produit').'`;', false);
                    $mf_liste_requete_index = array();
                    while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    self::$cache_db->write('a_filtre_produit__index', $mf_liste_requete_index);
                }
                foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if (count($liste_colonnes_a_indexer) > 0) {
                    foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                        executer_requete_mysql('ALTER TABLE `'.inst('a_filtre_produit').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    self::$cache_db->clear();
                }
            }

            $liste = array();
            if ($toutes_colonnes) {
                $colonnes='a_filtre_produit_Actif, Code_filtre, Code_article';
            } else {
                $colonnes='a_filtre_produit_Actif, Code_filtre, Code_article';
            }
            $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM '.inst('a_filtre_produit')." WHERE 1{$argument_cond}".( $Code_filtre!=0 ? " AND Code_filtre=$Code_filtre" : "" )."".( $Code_article!=0 ? " AND Code_article=$Code_article" : "" )."{$argument_tris}{$argument_limit};", false);
            while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                mf_formatage_db_type_php($row_requete);
                $liste[$row_requete['Code_filtre'].'-'.$row_requete['Code_article']] = $row_requete;
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
                Hook_a_filtre_produit::completion($element, self::$auto_completion - 1);
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

    public function mf_get(int $Code_filtre, int $Code_article, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cle = "a_filtre_produit__get";
        $Code_filtre = round($Code_filtre);
        $cle .= "_{$Code_filtre}";
        $Code_article = round($Code_article);
        $cle .= "_{$Code_article}";
        $retour = array();
        if (! CONTROLE_ACCES_DONNEES_DEFAUT || Hook_mf_systeme::controle_acces_donnees('Code_filtre', $Code_filtre) && Hook_mf_systeme::controle_acces_donnees('Code_article', $Code_article)) {

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
                    $colonnes='a_filtre_produit_Actif, Code_filtre, Code_article';
                } else {
                    $colonnes='a_filtre_produit_Actif, Code_filtre, Code_article';
                }
                $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM ' . inst('a_filtre_produit')." WHERE Code_filtre=$Code_filtre AND Code_article=$Code_article;", false);
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
                    Hook_a_filtre_produit::completion($retour, self::$auto_completion - 1);
                    self::$auto_completion --;
                }
            }
        }
        return $retour;
    }

    public function mf_get_2(int $Code_filtre, int $Code_article, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cle = "a_filtre_produit__get";
        $Code_filtre = round($Code_filtre);
        $cle .= "_{$Code_filtre}";
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
                $colonnes='a_filtre_produit_Actif, Code_filtre, Code_article';
            } else {
                $colonnes='a_filtre_produit_Actif, Code_filtre, Code_article';
            }
            $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM ' . inst('a_filtre_produit')." WHERE Code_filtre=$Code_filtre AND Code_article=$Code_article;", false);
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
                Hook_a_filtre_produit::completion($retour, self::$auto_completion - 1);
                self::$auto_completion --;
            }
        }
        return $retour;
    }

    public function mf_compter(?int $Code_filtre = null, ?int $Code_article = null, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cle = 'a_filtre_produit__compter';
        $Code_filtre = round($Code_filtre);
        $cle .= '_{'.$Code_filtre.'}';
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
                if ( strpos($argument_cond, 'a_filtre_produit_Actif')!==false ) { $liste_colonnes_a_indexer['a_filtre_produit_Actif'] = 'a_filtre_produit_Actif'; }
            }
            if (count($liste_colonnes_a_indexer) > 0) {
                if (false === $mf_liste_requete_index = self::$cache_db->read('a_filtre_produit__index')) {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('a_filtre_produit').'`;', false);
                    $mf_liste_requete_index = array();
                    while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    self::$cache_db->write('a_filtre_produit__index', $mf_liste_requete_index);
                }
                foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if (count($liste_colonnes_a_indexer) > 0) {
                    foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                        executer_requete_mysql('ALTER TABLE `'.inst('a_filtre_produit').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    self::$cache_db->clear();
                }
            }

            $res_requete = executer_requete_mysql("SELECT COUNT(CONCAT(Code_filtre,'|',Code_article)) as nb FROM ".inst('a_filtre_produit')." WHERE 1{$argument_cond}".( $Code_filtre!=0 ? " AND Code_filtre=$Code_filtre" : "" )."".( $Code_article!=0 ? " AND Code_article=$Code_article" : "" ).";", false);
            $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC);
            mysqli_free_result($res_requete);
            $nb = (int) $row_requete['nb'];
            self::$cache_db->write($cle, $nb);
        }
        return $nb;
    }

    public function mf_liste_Code_filtre_vers_liste_Code_article( array $liste_Code_filtre, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ($options === null) {
            $options=[];
        }
        return $this->a_filtre_produit_liste_Code_filtre_vers_liste_Code_article( $liste_Code_filtre , $options );
    }

    public function mf_liste_Code_article_vers_liste_Code_filtre( array $liste_Code_article, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ($options === null) {
            $options=[];
        }
        return $this->a_filtre_produit_liste_Code_article_vers_liste_Code_filtre( $liste_Code_article , $options );
    }
}
