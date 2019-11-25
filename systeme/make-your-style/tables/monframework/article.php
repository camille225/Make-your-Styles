<?php

/*
    +------------------------------+
    |  NE PAS MODIFIER CE FICHIER  |
    +------------------------------+
*/

class article_monframework extends entite_monframework
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
            include_once __DIR__ . '/../../erreurs/erreurs__article.php';
            self::$initialisation = false;
            Hook_article::initialisation();
            self::$cache_db = new Mf_Cachedb('article');
        }
        if (!self::$actualisation_en_cours)
        {
            self::$actualisation_en_cours=true;
            Hook_article::actualisation();
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

        if ( ! test_si_table_existe(inst('article')) )
        {
            executer_requete_mysql('CREATE TABLE '.inst('article').'(Code_article INT AUTO_INCREMENT NOT NULL, PRIMARY KEY (Code_article)) ENGINE=MyISAM;', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        $liste_colonnes = lister_les_colonnes(inst('article'));

        if ( isset($liste_colonnes['article_Libelle']) )
        {
            if ( typeMyql2Sql($liste_colonnes['article_Libelle']['Type'])!='VARCHAR' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('article').' CHANGE article_Libelle article_Libelle VARCHAR(255);', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['article_Libelle']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('article').' ADD article_Libelle VARCHAR(255);', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE '.inst('article').' SET article_Libelle=' . format_sql('article_Libelle', $mf_initialisation['article_Libelle']) . ';', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if ( isset($liste_colonnes['article_Photo_Fichier']) )
        {
            if ( typeMyql2Sql($liste_colonnes['article_Photo_Fichier']['Type'])!='VARCHAR' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('article').' CHANGE article_Photo_Fichier article_Photo_Fichier VARCHAR(255);', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['article_Photo_Fichier']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('article').' ADD article_Photo_Fichier VARCHAR(255);', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE '.inst('article').' SET article_Photo_Fichier=' . format_sql('article_Photo_Fichier', $mf_initialisation['article_Photo_Fichier']) . ';', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if ( isset($liste_colonnes['article_Prix']) )
        {
            if ( typeMyql2Sql($liste_colonnes['article_Prix']['Type'])!='FLOAT' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('article').' CHANGE article_Prix article_Prix FLOAT;', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['article_Prix']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('article').' ADD article_Prix FLOAT;', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE '.inst('article').' SET article_Prix=' . format_sql('article_Prix', $mf_initialisation['article_Prix']) . ';', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if ( isset($liste_colonnes['article_Actif']) )
        {
            if ( typeMyql2Sql($liste_colonnes['article_Actif']['Type'])!='BOOL' )
            {
                executer_requete_mysql('ALTER TABLE '.inst('article').' CHANGE article_Actif article_Actif BOOL;', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['article_Actif']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('article').' ADD article_Actif BOOL;', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE '.inst('article').' SET article_Actif=' . format_sql('article_Actif', $mf_initialisation['article_Actif']) . ';', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if ( isset($liste_colonnes['Code_type_produit']) )
        {
            unset($liste_colonnes['Code_type_produit']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('article').' ADD Code_type_produit int NOT NULL;', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if ( isset($liste_colonnes['mf_signature']) )
        {
            unset($liste_colonnes['mf_signature']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('article').' ADD mf_signature VARCHAR(255);', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('ALTER TABLE '.inst('article').' ADD INDEX( mf_signature );', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if ( isset($liste_colonnes['mf_cle_unique']) )
        {
            unset($liste_colonnes['mf_cle_unique']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('article').' ADD mf_cle_unique VARCHAR(255);', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('ALTER TABLE '.inst('article').' ADD INDEX( mf_cle_unique );', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if ( isset($liste_colonnes['mf_date_creation']) )
        {
            unset($liste_colonnes['mf_date_creation']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('article').' ADD mf_date_creation DATETIME;', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('ALTER TABLE '.inst('article').' ADD INDEX( mf_date_creation );', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if ( isset($liste_colonnes['mf_date_modification']) )
        {
            unset($liste_colonnes['mf_date_modification']);
        }
        else
        {
            executer_requete_mysql('ALTER TABLE '.inst('article').' ADD mf_date_modification DATETIME;', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('ALTER TABLE '.inst('article').' ADD INDEX( mf_date_modification );', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        unset($liste_colonnes['Code_article']);

        foreach ($liste_colonnes as $field => $value)
        {
            executer_requete_mysql('ALTER TABLE '.inst('article').' DROP COLUMN '.$field.';', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

    }

    public function mf_ajouter(string $article_Libelle, string $article_Photo_Fichier, float $article_Prix, bool $article_Actif, int $Code_type_produit, ?bool $force = false)
    {
        if ($force === null) {
            $force = false;
        }
        $Code_article = 0;
        $code_erreur = 0;
        $Code_type_produit = round($Code_type_produit);
        $article_Prix = floatval(str_replace(' ','',str_replace(',','.',$article_Prix)));
        Hook_article::pre_controller($article_Libelle, $article_Photo_Fichier, $article_Prix, $article_Actif, $Code_type_produit);
        if (!$force)
        {
            if (!self::$maj_droits_ajouter_en_cours)
            {
                self::$maj_droits_ajouter_en_cours = true;
                Hook_article::hook_actualiser_les_droits_ajouter($Code_type_produit);
                self::$maj_droits_ajouter_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['article__AJOUTER']) ) $code_erreur = REFUS_ARTICLE__AJOUTER;
        elseif ( !$this->mf_tester_existance_Code_type_produit($Code_type_produit) ) $code_erreur = ERR_ARTICLE__AJOUTER__CODE_TYPE_PRODUIT_INEXISTANT;
        elseif (CONTROLE_ACCES_DONNEES_DEFAUT && ! Hook_mf_systeme::controle_acces_donnees('Code_type_produit', $Code_type_produit)) $code_erreur = ACCES_CODE_TYPE_PRODUIT_REFUSE;
        elseif ( !Hook_article::autorisation_ajout($article_Libelle, $article_Photo_Fichier, $article_Prix, $article_Actif, $Code_type_produit) ) $code_erreur = REFUS_ARTICLE__AJOUT_BLOQUEE;
        else
        {
            Hook_article::data_controller($article_Libelle, $article_Photo_Fichier, $article_Prix, $article_Actif, $Code_type_produit);
            $mf_signature = text_sql(Hook_article::calcul_signature($article_Libelle, $article_Photo_Fichier, $article_Prix, $article_Actif, $Code_type_produit));
            $mf_cle_unique = text_sql(Hook_article::calcul_cle_unique($article_Libelle, $article_Photo_Fichier, $article_Prix, $article_Actif, $Code_type_produit));
            $article_Libelle = text_sql($article_Libelle);
            $article_Photo_Fichier = text_sql($article_Photo_Fichier);
            $article_Prix = floatval($article_Prix);
            $article_Actif = ($article_Actif==1 ? 1 : 0);
            $requete = "INSERT INTO ".inst('article')." ( mf_signature, mf_cle_unique, mf_date_creation, mf_date_modification, article_Libelle, article_Photo_Fichier, article_Prix, article_Actif, Code_type_produit ) VALUES ( '$mf_signature', '$mf_cle_unique', '".get_now()."', '".get_now()."', '$article_Libelle', '$article_Photo_Fichier', $article_Prix, $article_Actif, $Code_type_produit );";
            executer_requete_mysql($requete, array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            $Code_article = requete_mysql_insert_id();
            if ($Code_article==0)
            {
                $code_erreur = ERR_ARTICLE__AJOUTER__AJOUT_REFUSE;
            } else {
                self::$cache_db->clear();
                Hook_article::ajouter( $Code_article );
            }
        }
        if ($code_erreur != 0) {
            global $mf_message_erreur_personalise, $mf_libelle_erreur;
            if ($mf_message_erreur_personalise != '') {
                $mf_libelle_erreur[$code_erreur] = $mf_message_erreur_personalise;
                $mf_message_erreur_personalise = '';
            }
        }
        return array('code_erreur' => $code_erreur, 'Code_article' => $Code_article, 'callback' => ( $code_erreur==0 ? Hook_article::callback_post($Code_article) : null ));
    }

    public function mf_creer(int $Code_type_produit, ?bool $force = null)
    {
        if ($force === null) {
            $force = false;
        }
        global $mf_initialisation;
        $article_Libelle = $mf_initialisation['article_Libelle'];
        $article_Photo_Fichier = $mf_initialisation['article_Photo_Fichier'];
        $article_Prix = $mf_initialisation['article_Prix'];
        $article_Actif = $mf_initialisation['article_Actif'];
        return $this->mf_ajouter($article_Libelle, $article_Photo_Fichier, $article_Prix, $article_Actif, $Code_type_produit, $force);
    }

    public function mf_ajouter_2(array $ligne, bool $force = null) // array('colonne1' => 'valeur1',  [...] )
    {
        if ($force === null) {
            $force = false;
        }
        global $mf_initialisation;
        $Code_type_produit = (int)(isset($ligne['Code_type_produit'])?round($ligne['Code_type_produit']):0);
        $article_Libelle = (string)(isset($ligne['article_Libelle'])?$ligne['article_Libelle']:$mf_initialisation['article_Libelle']);
        $article_Photo_Fichier = (string)(isset($ligne['article_Photo_Fichier'])?$ligne['article_Photo_Fichier']:$mf_initialisation['article_Photo_Fichier']);
        $article_Prix = (float)(isset($ligne['article_Prix'])?$ligne['article_Prix']:$mf_initialisation['article_Prix']);
        $article_Actif = (bool)(isset($ligne['article_Actif'])?$ligne['article_Actif']:$mf_initialisation['article_Actif']);
        return $this->mf_ajouter($article_Libelle, $article_Photo_Fichier, $article_Prix, $article_Actif, $Code_type_produit, $force);
    }

    public function mf_ajouter_3(array $lignes) // array( array( 'colonne1' => 'valeur1', 'colonne2' => 'valeur2',  [...] ), [...] )
    {
        global $mf_initialisation;
        $code_erreur = 0;
        $values = '';
        foreach ($lignes as $ligne)
        {
            $Code_type_produit = (int)(isset($ligne['Code_type_produit'])?round($ligne['Code_type_produit']):0);
            $article_Libelle = text_sql(isset($ligne['article_Libelle'])?$ligne['article_Libelle']:$mf_initialisation['article_Libelle']);
            $article_Photo_Fichier = text_sql(isset($ligne['article_Photo_Fichier'])?$ligne['article_Photo_Fichier']:$mf_initialisation['article_Photo_Fichier']);
            $article_Prix = floatval(isset($ligne['article_Prix'])?$ligne['article_Prix']:$mf_initialisation['article_Prix']);
            $article_Actif = (isset($ligne['article_Actif'])?$ligne['article_Actif']:$mf_initialisation['article_Actif']==1 ? 1 : 0);
            if ($Code_type_produit != 0)
            {
                $values .= ($values!="" ? "," : "")."('$article_Libelle', '$article_Photo_Fichier', $article_Prix, $article_Actif, $Code_type_produit)";
            }
        }
        if ($values!='')
        {
            $requete = "INSERT INTO ".inst('article')." ( article_Libelle, article_Photo_Fichier, article_Prix, article_Actif, Code_type_produit ) VALUES $values;";
            executer_requete_mysql( $requete , array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            $n = requete_mysqli_affected_rows();
            if ($n < count($lignes))
            {
                $code_erreur = ERR_ARTICLE__AJOUTER_3__ECHEC_AJOUT;
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

    public function mf_actualiser_signature(int $Code_article)
    {
        $article = $this->mf_get_2($Code_article, array('autocompletion' => false));
        $mf_signature = text_sql(Hook_article::calcul_signature($article['article_Libelle'], $article['article_Photo_Fichier'], $article['article_Prix'], $article['article_Actif'], $article['Code_type_produit']));
        $mf_cle_unique = text_sql(Hook_article::calcul_cle_unique($article['article_Libelle'], $article['article_Photo_Fichier'], $article['article_Prix'], $article['article_Actif'], $article['Code_type_produit']));
        $table = inst('article');
        executer_requete_mysql("UPDATE $table SET mf_signature='$mf_signature', mf_cle_unique='$mf_cle_unique' WHERE Code_article=$Code_article;", array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        if (requete_mysqli_affected_rows() == 1) {
            self::$cache_db->clear();
        }
    }

    public function mf_modifier( int $Code_article, string $article_Libelle, string $article_Photo_Fichier, float $article_Prix, bool $article_Actif, ?int $Code_type_produit = null, ?bool $force = null)
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        $Code_article = round($Code_article);
        $Code_type_produit = round($Code_type_produit);
        $article_Prix = floatval(str_replace(' ','',str_replace(',','.',$article_Prix)));
        Hook_article::pre_controller($article_Libelle, $article_Photo_Fichier, $article_Prix, $article_Actif, $Code_type_produit, $Code_article);
        if (!$force)
        {
            if (!self::$maj_droits_modifier_en_cours)
            {
                self::$maj_droits_modifier_en_cours = true;
                Hook_article::hook_actualiser_les_droits_modifier($Code_article);
                self::$maj_droits_modifier_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['article__MODIFIER']) ) $code_erreur = REFUS_ARTICLE__MODIFIER;
        elseif ( !$this->mf_tester_existance_Code_article($Code_article) ) $code_erreur = ERR_ARTICLE__MODIFIER__CODE_ARTICLE_INEXISTANT;
        elseif ($Code_type_produit != 0 && ! $this->mf_tester_existance_Code_type_produit($Code_type_produit)) $code_erreur = ERR_ARTICLE__MODIFIER__CODE_TYPE_PRODUIT_INEXISTANT;
        elseif (CONTROLE_ACCES_DONNEES_DEFAUT && ! Hook_mf_systeme::controle_acces_donnees('Code_article', $Code_article)) $code_erreur = ACCES_CODE_ARTICLE_REFUSE;
        elseif ($Code_type_produit != 0 && CONTROLE_ACCES_DONNEES_DEFAUT && ! Hook_mf_systeme::controle_acces_donnees('Code_type_produit', $Code_type_produit)) $code_erreur = ACCES_CODE_TYPE_PRODUIT_REFUSE;
        elseif ( !Hook_article::autorisation_modification($Code_article, $article_Libelle, $article_Photo_Fichier, $article_Prix, $article_Actif, $Code_type_produit) ) $code_erreur = REFUS_ARTICLE__MODIFICATION_BLOQUEE;
        else
        {
            if (! isset(self::$lock[$Code_article])) {
                self::$lock[$Code_article] = 0;
            }
            if (self::$lock[$Code_article] == 0) {
                self::$cache_db->add_lock($Code_article);
            }
            self::$lock[$Code_article]++;
            Hook_article::data_controller($article_Libelle, $article_Photo_Fichier, $article_Prix, $article_Actif, $Code_type_produit, $Code_article);
            $article = $this->mf_get_2( $Code_article, array('autocompletion' => false, 'masquer_mdp' => false) );
            $mf_colonnes_a_modifier=[];
            $bool__article_Libelle = false; if ( $article_Libelle!=$article['article_Libelle'] ) { Hook_article::data_controller__article_Libelle($article['article_Libelle'], $article_Libelle, $Code_article); if ( $article_Libelle!=$article['article_Libelle'] ) { $mf_colonnes_a_modifier[] = 'article_Libelle=' . format_sql('article_Libelle', $article_Libelle); $bool__article_Libelle = true; } }
            $bool__article_Photo_Fichier = false; if ( $article_Photo_Fichier!=$article['article_Photo_Fichier'] ) { Hook_article::data_controller__article_Photo_Fichier($article['article_Photo_Fichier'], $article_Photo_Fichier, $Code_article); if ( $article_Photo_Fichier!=$article['article_Photo_Fichier'] ) { $mf_colonnes_a_modifier[] = 'article_Photo_Fichier=' . format_sql('article_Photo_Fichier', $article_Photo_Fichier); $bool__article_Photo_Fichier = true; } }
            $bool__article_Prix = false; if ( $article_Prix!=$article['article_Prix'] ) { Hook_article::data_controller__article_Prix($article['article_Prix'], $article_Prix, $Code_article); if ( $article_Prix!=$article['article_Prix'] ) { $mf_colonnes_a_modifier[] = 'article_Prix=' . format_sql('article_Prix', $article_Prix); $bool__article_Prix = true; } }
            $bool__article_Actif = false; if ( $article_Actif!=$article['article_Actif'] ) { Hook_article::data_controller__article_Actif($article['article_Actif'], $article_Actif, $Code_article); if ( $article_Actif!=$article['article_Actif'] ) { $mf_colonnes_a_modifier[] = 'article_Actif=' . format_sql('article_Actif', $article_Actif); $bool__article_Actif = true; } }
            $bool__Code_type_produit = false; if ($Code_type_produit != 0 && $Code_type_produit != $article['Code_type_produit'] ) { Hook_article::data_controller__Code_type_produit($article['Code_type_produit'], $Code_type_produit, $Code_article); if ( $Code_type_produit != 0 && $Code_type_produit != $article['Code_type_produit'] ) { $mf_colonnes_a_modifier[] = 'Code_type_produit = ' . $Code_type_produit; $bool__Code_type_produit = true; } }
            if (count($mf_colonnes_a_modifier) > 0) {
                $mf_signature = text_sql(Hook_article::calcul_signature($article_Libelle, $article_Photo_Fichier, $article_Prix, $article_Actif, $Code_type_produit));
                $mf_cle_unique = text_sql(Hook_article::calcul_cle_unique($article_Libelle, $article_Photo_Fichier, $article_Prix, $article_Actif, $Code_type_produit));
                $mf_colonnes_a_modifier[] = 'mf_signature=\'' . $mf_signature . '\'';
                $mf_colonnes_a_modifier[] = 'mf_cle_unique=\'' . $mf_cle_unique . '\'';
                $mf_colonnes_a_modifier[] = 'mf_date_modification=\'' . get_now() . '\'';
                $requete = 'UPDATE '.inst('article').' SET ' . enumeration($mf_colonnes_a_modifier) . ' WHERE Code_article = ' . $Code_article . ';';
                executer_requete_mysql($requete, array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
                if (requete_mysqli_affected_rows() == 0) {
                    $code_erreur = ERR_ARTICLE__MODIFIER__AUCUN_CHANGEMENT;
                } else {
                    self::$cache_db->clear();
                    Hook_article::modifier($Code_article, $bool__article_Libelle, $bool__article_Photo_Fichier, $bool__article_Prix, $bool__article_Actif, $bool__Code_type_produit);
                }
            } else {
                $code_erreur = ERR_ARTICLE__MODIFIER__AUCUN_CHANGEMENT;
            }
            self::$lock[$Code_article]--;
            if (self::$lock[$Code_article] == 0) {
                self::$cache_db->release_lock($Code_article);
                unset(self::$lock[$Code_article]);
            }
        }
        if ($code_erreur != 0) {
            global $mf_message_erreur_personalise, $mf_libelle_erreur;
            if ($mf_message_erreur_personalise != '') {
                $mf_libelle_erreur[$code_erreur] = $mf_message_erreur_personalise;
                $mf_message_erreur_personalise = '';
            }
        }
        return array('code_erreur' => $code_erreur, 'callback' => ( $code_erreur == 0 ? Hook_article::callback_put($Code_article) : null ));
    }

    public function mf_modifier_2(array $lignes, ?bool $force = null) // array( $Code_article => array('colonne1' => 'valeur1',  [...] ) )
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        foreach ( $lignes as $Code_article => $colonnes )
        {
            if ( $code_erreur==0 )
            {
                $Code_article = (int) round($Code_article);
                $article = $this->mf_get_2($Code_article, array('autocompletion' => false));
                if (!$force)
                {
                    if (!self::$maj_droits_modifier_en_cours)
                    {
                        self::$maj_droits_modifier_en_cours = true;
                        Hook_article::hook_actualiser_les_droits_modifier($Code_article);
                        self::$maj_droits_modifier_en_cours = false;
                    }
                }
                $Code_type_produit = (int) ( isset($colonnes['Code_type_produit']) && ( $force || mf_matrice_droits(['api_modifier_ref__article__Code_type_produit', 'article__MODIFIER']) ) ? $colonnes['Code_type_produit'] : (isset($article['Code_type_produit']) ? $article['Code_type_produit'] : 0 ));
                $article_Libelle = (string) ( isset($colonnes['article_Libelle']) && ( $force || mf_matrice_droits(['api_modifier__article_Libelle', 'article__MODIFIER']) ) ? $colonnes['article_Libelle'] : ( isset($article['article_Libelle']) ? $article['article_Libelle'] : '' ) );
                $article_Photo_Fichier = (string) ( isset($colonnes['article_Photo_Fichier']) && ( $force || mf_matrice_droits(['api_modifier__article_Photo_Fichier', 'article__MODIFIER']) ) ? $colonnes['article_Photo_Fichier'] : ( isset($article['article_Photo_Fichier']) ? $article['article_Photo_Fichier'] : '' ) );
                $article_Prix = (float) ( isset($colonnes['article_Prix']) && ( $force || mf_matrice_droits(['api_modifier__article_Prix', 'article__MODIFIER']) ) ? $colonnes['article_Prix'] : ( isset($article['article_Prix']) ? $article['article_Prix'] : '' ) );
                $article_Actif = (bool) ( isset($colonnes['article_Actif']) && ( $force || mf_matrice_droits(['api_modifier__article_Actif', 'article__MODIFIER']) ) ? $colonnes['article_Actif'] : ( isset($article['article_Actif']) ? $article['article_Actif'] : '' ) );
                $retour = $this->mf_modifier($Code_article, $article_Libelle, $article_Photo_Fichier, $article_Prix, $article_Actif, $Code_type_produit, true);
                if ($retour['code_erreur'] != 0 && $retour['code_erreur'] != ERR_ARTICLE__MODIFIER__AUCUN_CHANGEMENT) {
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

    public function mf_modifier_3(array $lignes) // array( $Code_article => array('colonne1' => 'valeur1',  [...] ) )
    {
        $code_erreur = 0;
        $modifs = false;

        // transformation des lignes en colonnes
        $valeurs_en_colonnes=array();
        $indices_par_colonne=array();
        $liste_valeurs_indexees=array();
        foreach ( $lignes as $Code_article => $colonnes )
        {
            foreach ($colonnes as $colonne => $valeur)
            {
                if ( $colonne=='article_Libelle' || $colonne=='article_Photo_Fichier' || $colonne=='article_Prix' || $colonne=='article_Actif' || $colonne=='Code_type_produit' )
                {
                    $valeurs_en_colonnes[$colonne][$Code_article]=$valeur;
                    $indices_par_colonne[$colonne][]=$Code_article;
                    $liste_valeurs_indexees[$colonne][''.$valeur][]=$Code_article;
                }
            }
        }

        // fabrication des requetes
        foreach ( $valeurs_en_colonnes as $colonne => $valeurs )
        {
            if ( count($liste_valeurs_indexees[$colonne]) > 3 )
            {
                $modification_sql = $colonne . ' = CASE Code_article';
                foreach ( $valeurs as $Code_article => $valeur )
                {
                    $modification_sql .= ' WHEN ' . $Code_article . ' THEN ' . format_sql($colonne, $valeur);
                }
                $modification_sql .= ' END';
                $perimetre = Sql_Format_Liste($indices_par_colonne[$colonne]);
                executer_requete_mysql('UPDATE ' . inst('article') . ' SET ' . $modification_sql . ' WHERE Code_article IN ' . $perimetre . ';', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
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
                    executer_requete_mysql('UPDATE ' . inst('article') . ' SET ' . $colonne . ' = ' . format_sql($colonne, $valeur) . ' WHERE Code_article IN ' . $perimetre . ';', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
                    if ( requete_mysqli_affected_rows()!=0 )
                    {
                        $modifs = true;
                    }
                }
            }
        }

        if ( ! $modifs && $code_erreur==0 )
        {
            $code_erreur = ERR_ARTICLE__MODIFIER_3__AUCUN_CHANGEMENT;
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

    public function mf_modifier_4( int $Code_type_produit, array $data, ?array $options = null /* $options = array( 'cond_mysql' => array(), 'limit' => 0 ) */ ) // $data = array('colonne1' => 'valeur1', ... )
    {
        if ($options === null) {
            $force = [];
        }
        $code_erreur = 0;
        $Code_type_produit = round($Code_type_produit);
        $mf_colonnes_a_modifier=[];
        if ( isset($data['article_Libelle']) ) { $mf_colonnes_a_modifier[] = 'article_Libelle = ' . format_sql('article_Libelle', $data['article_Libelle']); }
        if ( isset($data['article_Photo_Fichier']) ) { $mf_colonnes_a_modifier[] = 'article_Photo_Fichier = ' . format_sql('article_Photo_Fichier', $data['article_Photo_Fichier']); }
        if ( isset($data['article_Prix']) ) { $mf_colonnes_a_modifier[] = 'article_Prix = ' . format_sql('article_Prix', $data['article_Prix']); }
        if ( isset($data['article_Actif']) ) { $mf_colonnes_a_modifier[] = 'article_Actif = ' . format_sql('article_Actif', $data['article_Actif']); }
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

            $requete = 'UPDATE ' . inst('article') . ' SET ' . enumeration($mf_colonnes_a_modifier) . " WHERE 1".( $Code_type_produit!=0 ? " AND Code_type_produit=$Code_type_produit" : "" )."$argument_cond" . ( $limit>0 ? ' LIMIT ' . $limit : '' ) . ";";
            executer_requete_mysql( $requete , array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            if ( requete_mysqli_affected_rows()==0 )
            {
                $code_erreur = ERR_ARTICLE__MODIFIER_4__AUCUN_CHANGEMENT;
            } else {
                self::$cache_db->clear();
            }
        }
        return array('code_erreur' => $code_erreur);
    }

    public function mf_supprimer(int $Code_article, ?bool $force = null)
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        $Code_article = round($Code_article);
        if (! $force) {
            if (!self::$maj_droits_supprimer_en_cours)
            {
                self::$maj_droits_supprimer_en_cours = true;
                Hook_article::hook_actualiser_les_droits_supprimer($Code_article);
                self::$maj_droits_supprimer_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['article__SUPPRIMER']) ) $code_erreur = REFUS_ARTICLE__SUPPRIMER;
        elseif (! $this->mf_tester_existance_Code_article($Code_article) ) $code_erreur = ERR_ARTICLE__SUPPRIMER_2__CODE_ARTICLE_INEXISTANT;
        elseif (CONTROLE_ACCES_DONNEES_DEFAUT && ! Hook_mf_systeme::controle_acces_donnees('Code_article', $Code_article)) $code_erreur = ACCES_CODE_ARTICLE_REFUSE;
        elseif ( !Hook_article::autorisation_suppression($Code_article) ) $code_erreur = REFUS_ARTICLE__SUPPRESSION_BLOQUEE;
        else
        {
            $copie__article = $this->mf_get($Code_article, array('autocompletion' => false));
            $this->supprimer_donnes_en_cascade("article", array($Code_article));
            $requete = 'DELETE IGNORE FROM ' . inst('article') . ' WHERE Code_article=' . $Code_article . ';';
            executer_requete_mysql($requete, array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            if (requete_mysqli_affected_rows() == 0) {
                $code_erreur = ERR_ARTICLE__SUPPRIMER__REFUSEE;
            } else {
                self::$cache_db->clear();
                Hook_article::supprimer($copie__article);
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

    public function mf_supprimer_2(array $liste_Code_article, ?bool $force = null)
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        $copie__liste_article = $this->mf_lister_2($liste_Code_article, array('autocompletion' => false));
        $liste_Code_article=array();
        foreach ( $copie__liste_article as $copie__article )
        {
            $Code_article = $copie__article['Code_article'];
            if (!$force)
            {
                if (!self::$maj_droits_supprimer_en_cours)
                {
                    self::$maj_droits_supprimer_en_cours = true;
                    Hook_article::hook_actualiser_les_droits_supprimer($Code_article);
                    self::$maj_droits_supprimer_en_cours = false;
                }
            }
            if ( !$force && !mf_matrice_droits(['article__SUPPRIMER']) ) $code_erreur = REFUS_ARTICLE__SUPPRIMER;
            elseif ( !Hook_article::autorisation_suppression($Code_article) ) $code_erreur = REFUS_ARTICLE__SUPPRESSION_BLOQUEE;
            {
                $liste_Code_article[] = $Code_article;
            }
        }
        if ( $code_erreur==0 && count($liste_Code_article)>0 )
        {
            $this->supprimer_donnes_en_cascade("article", $liste_Code_article);
            $requete = 'DELETE IGNORE FROM ' . inst('article') . ' WHERE Code_article IN ' . Sql_Format_Liste($liste_Code_article) . ';';
            executer_requete_mysql( $requete , array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            if (requete_mysqli_affected_rows() == 0) {
                $code_erreur = ERR_ARTICLE__SUPPRIMER_2__REFUSEE;
            } else {
                self::$cache_db->clear();
                Hook_article::supprimer_2($copie__liste_article);
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

    public function mf_supprimer_3(array $liste_Code_article)
    {
        $code_erreur=0;
        if ( count($liste_Code_article)>0 )
        {
            $this->supprimer_donnes_en_cascade("article", $liste_Code_article);
            $requete = 'DELETE IGNORE FROM ' . inst('article') . ' WHERE Code_article IN ' . Sql_Format_Liste($liste_Code_article) . ';';
            executer_requete_mysql( $requete , array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            if (requete_mysqli_affected_rows() == 0) {
                $code_erreur = ERR_ARTICLE__SUPPRIMER_3__REFUSEE;
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
        if (! $contexte_parent && $mf_contexte['Code_article'] != 0) {
            $article = $this->mf_get( $mf_contexte['Code_article'], $options);
            return array( $article['Code_article'] => $article );
        } else {
            return $this->mf_lister(isset($est_charge['type_produit']) ? $mf_contexte['Code_type_produit'] : 0, $options);
        }
    }

    public function mf_lister(?int $Code_type_produit = null, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cle = "article__lister";
        $Code_type_produit = round($Code_type_produit);
        $cle .= "_{$Code_type_produit}";

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
            if ( isset($mf_tri_defaut_table['article']) )
            {
                $options['tris'] = $mf_tri_defaut_table['article'];
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
                    if ( strpos($argument_cond, 'article_Libelle')!==false ) { $liste_colonnes_a_indexer['article_Libelle'] = 'article_Libelle'; }
                    if ( strpos($argument_cond, 'article_Photo_Fichier')!==false ) { $liste_colonnes_a_indexer['article_Photo_Fichier'] = 'article_Photo_Fichier'; }
                    if ( strpos($argument_cond, 'article_Prix')!==false ) { $liste_colonnes_a_indexer['article_Prix'] = 'article_Prix'; }
                    if ( strpos($argument_cond, 'article_Actif')!==false ) { $liste_colonnes_a_indexer['article_Actif'] = 'article_Actif'; }
                }
                if (isset($options['tris'])) {
                    if ( isset($options['tris']['article_Libelle']) ) { $liste_colonnes_a_indexer['article_Libelle'] = 'article_Libelle'; }
                    if ( isset($options['tris']['article_Photo_Fichier']) ) { $liste_colonnes_a_indexer['article_Photo_Fichier'] = 'article_Photo_Fichier'; }
                    if ( isset($options['tris']['article_Prix']) ) { $liste_colonnes_a_indexer['article_Prix'] = 'article_Prix'; }
                    if ( isset($options['tris']['article_Actif']) ) { $liste_colonnes_a_indexer['article_Actif'] = 'article_Actif'; }
                }
                if (count($liste_colonnes_a_indexer) > 0) {
                    if (false === $mf_liste_requete_index = self::$cache_db->read('article__index')) {
                        $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('article').'`;', false);
                        $mf_liste_requete_index = array();
                        while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                            $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                        }
                        mysqli_free_result($res_requete_index);
                        self::$cache_db->write('article__index', $mf_liste_requete_index);
                    }
                    foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                        if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                    }
                    if (count($liste_colonnes_a_indexer) > 0) {
                        foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                            executer_requete_mysql('ALTER TABLE `'.inst('article').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                        }
                        self::$cache_db->clear();
                    }
                }

                $liste = array();
                $liste_article_pas_a_jour = array();
                if ($toutes_colonnes)
                {
                    $colonnes='Code_article, article_Libelle, article_Photo_Fichier, article_Prix, article_Actif, Code_type_produit';
                }
                else
                {
                    $colonnes='Code_article, article_Libelle, article_Photo_Fichier, article_Prix, article_Actif, Code_type_produit';
                }
                $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM ' . inst('article')." WHERE 1{$argument_cond}".( $Code_type_produit!=0 ? " AND Code_type_produit=$Code_type_produit" : "" )."{$argument_tris}{$argument_limit};", false);
                while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                {
                    mf_formatage_db_type_php($row_requete);
                    $liste[$row_requete['Code_article']] = $row_requete;
                    if ( $maj && ! Hook_article::est_a_jour( $row_requete ) )
                    {
                        $liste_article_pas_a_jour[$row_requete['Code_article']] = $row_requete;
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
                Hook_article::mettre_a_jour( $liste_article_pas_a_jour );
            }
        }

        foreach ($liste as $elem)
        {
            if ( $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_article', $elem['Code_article']) )
            {
                unset($liste[$elem['Code_article']]);
            }
            else
            {
                if (($autocompletion_recursive || self::$auto_completion < 1) && $autocompletion) {
                    self::$auto_completion ++;
                    Hook_article::completion($liste[$elem['Code_article']], self::$auto_completion - 1);
                    self::$auto_completion --;
                }
            }
        }

        return $liste;
    }

    public function mf_lister_2(array $liste_Code_article, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        if (count($liste_Code_article) > 0) {
            $cle = "article__mf_lister_2_".Sql_Format_Liste($liste_Code_article);

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
                if ( isset($mf_tri_defaut_table['article']) )
                {
                    $options['tris'] = $mf_tri_defaut_table['article'];
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
                        if ( strpos($argument_cond, 'article_Libelle')!==false ) { $liste_colonnes_a_indexer['article_Libelle'] = 'article_Libelle'; }
                        if ( strpos($argument_cond, 'article_Photo_Fichier')!==false ) { $liste_colonnes_a_indexer['article_Photo_Fichier'] = 'article_Photo_Fichier'; }
                        if ( strpos($argument_cond, 'article_Prix')!==false ) { $liste_colonnes_a_indexer['article_Prix'] = 'article_Prix'; }
                        if ( strpos($argument_cond, 'article_Actif')!==false ) { $liste_colonnes_a_indexer['article_Actif'] = 'article_Actif'; }
                    }
                    if (isset($options['tris'])) {
                        if ( isset($options['tris']['article_Libelle']) ) { $liste_colonnes_a_indexer['article_Libelle'] = 'article_Libelle'; }
                        if ( isset($options['tris']['article_Photo_Fichier']) ) { $liste_colonnes_a_indexer['article_Photo_Fichier'] = 'article_Photo_Fichier'; }
                        if ( isset($options['tris']['article_Prix']) ) { $liste_colonnes_a_indexer['article_Prix'] = 'article_Prix'; }
                        if ( isset($options['tris']['article_Actif']) ) { $liste_colonnes_a_indexer['article_Actif'] = 'article_Actif'; }
                    }
                    if (count($liste_colonnes_a_indexer) > 0) {
                        if (false === $mf_liste_requete_index = self::$cache_db->read('article__index')) {
                            $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('article').'`;', false);
                            $mf_liste_requete_index = array();
                            while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                                $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                            }
                            mysqli_free_result($res_requete_index);
                            self::$cache_db->write('article__index', $mf_liste_requete_index);
                        }
                        foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                            if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                        }
                        if (count($liste_colonnes_a_indexer) > 0) {
                            foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                                executer_requete_mysql('ALTER TABLE `'.inst('article').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                            }
                            self::$cache_db->clear();
                        }
                    }

                    $liste = array();
                    $liste_article_pas_a_jour = array();
                    if ($toutes_colonnes) {
                        $colonnes='Code_article, article_Libelle, article_Photo_Fichier, article_Prix, article_Actif, Code_type_produit';
                    } else {
                        $colonnes='Code_article, article_Libelle, article_Photo_Fichier, article_Prix, article_Actif, Code_type_produit';
                    }
                    $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM ' . inst('article') . " WHERE 1{$argument_cond} AND Code_article IN ".Sql_Format_Liste($liste_Code_article)."{$argument_tris}{$argument_limit};", false);
                    while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                        mf_formatage_db_type_php($row_requete);
                        $liste[$row_requete['Code_article']] = $row_requete;
                        if ($maj && ! Hook_article::est_a_jour($row_requete)) {
                            $liste_article_pas_a_jour[$row_requete['Code_article']] = $row_requete;
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
                    Hook_article::mettre_a_jour( $liste_article_pas_a_jour );
                }
            }

            foreach ($liste as $elem) {
                if ( $controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_article', $elem['Code_article']) )
                {
                    unset($liste[$elem['Code_article']]);
                }
                else
                {
                    if (($autocompletion_recursive || self::$auto_completion < 1) && $autocompletion) {
                        self::$auto_completion ++;
                        Hook_article::completion($liste[$elem['Code_article']], self::$auto_completion - 1);
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

    public function mf_get(int $Code_article, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $Code_article = round($Code_article);
        $retour = array();
        if ( ! CONTROLE_ACCES_DONNEES_DEFAUT || Hook_mf_systeme::controle_acces_donnees('Code_article', $Code_article) )
        {
            $cle = 'article__get_'.$Code_article;

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
                        $colonnes='Code_article, article_Libelle, article_Photo_Fichier, article_Prix, article_Actif, Code_type_produit';
                    } else {
                        $colonnes='Code_article, article_Libelle, article_Photo_Fichier, article_Prix, article_Actif, Code_type_produit';
                    }
                    $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM ' . inst('article') . ' WHERE Code_article = ' . $Code_article . ';', false);
                    if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
                    {
                        mf_formatage_db_type_php($row_requete);
                        $retour = $row_requete;
                        if ( $maj && ! Hook_article::est_a_jour( $row_requete ) )
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
                    Hook_article::mettre_a_jour( array( $row_requete['Code_article'] => $row_requete ) );
                }
            }
            if ( isset( $retour['Code_article'] ) )
            {
                if (($autocompletion_recursive || self::$auto_completion < 1) && $autocompletion) {
                    self::$auto_completion ++;
                    Hook_article::completion($retour, self::$auto_completion - 1);
                    self::$auto_completion --;
                }
            }
        }
        return $retour;
    }

    public function mf_get_last(?int $Code_type_produit = null, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cle = "article__get_last";
        $Code_type_produit = round($Code_type_produit);
        $cle .= '_' . $Code_type_produit;
        if (false === $retour = self::$cache_db->read($cle)) {
            $Code_article = 0;
            $res_requete = executer_requete_mysql('SELECT Code_article FROM ' . inst('article') . " WHERE 1".( $Code_type_produit!=0 ? " AND Code_type_produit=$Code_type_produit" : "" )." ORDER BY mf_date_creation DESC, Code_article DESC LIMIT 0 , 1;", false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $Code_article = $row_requete['Code_article'];
            }
            mysqli_free_result($res_requete);
            $retour = $this->mf_get($Code_article, $options);
            self::$cache_db->write($cle, $retour);
        }
        return $retour;
    }

    public function mf_get_2(int $Code_article, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $Code_article = round($Code_article);
        $retour = array();
        $cle = 'article__get_'.$Code_article;

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
                $colonnes='Code_article, article_Libelle, article_Photo_Fichier, article_Prix, article_Actif, Code_type_produit';
            } else {
                $colonnes='Code_article, article_Libelle, article_Photo_Fichier, article_Prix, article_Actif, Code_type_produit';
            }
            $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM ' . inst('article') . ' WHERE Code_article = ' . $Code_article . ';', false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                mf_formatage_db_type_php($row_requete);
                $retour = $row_requete;
            } else {
                $retour = array();
            }
            mysqli_free_result($res_requete);
            self::$cache_db->write($cle, $retour);
        }
        if (isset($retour['Code_article'])) {
            if (($autocompletion_recursive || self::$auto_completion < 1) && $autocompletion) {
                self::$auto_completion ++;
                Hook_article::completion($retour, self::$auto_completion - 1);
                self::$auto_completion --;
            }
        }
        return $retour;
    }

    public function mf_prec_et_suiv( int $Code_article, ?int $Code_type_produit = null, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $Code_article = round($Code_article);
        $liste = $this->mf_lister($Code_type_produit, $options);
        return prec_suiv($liste, $Code_article);
    }

    public function mf_compter(?int $Code_type_produit = null, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cle = 'article__compter';
        $Code_type_produit = round($Code_type_produit);
        $cle .= '_{'.$Code_type_produit.'}';

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
                if ( strpos($argument_cond, 'article_Libelle')!==false ) { $liste_colonnes_a_indexer['article_Libelle'] = 'article_Libelle'; }
                if ( strpos($argument_cond, 'article_Photo_Fichier')!==false ) { $liste_colonnes_a_indexer['article_Photo_Fichier'] = 'article_Photo_Fichier'; }
                if ( strpos($argument_cond, 'article_Prix')!==false ) { $liste_colonnes_a_indexer['article_Prix'] = 'article_Prix'; }
                if ( strpos($argument_cond, 'article_Actif')!==false ) { $liste_colonnes_a_indexer['article_Actif'] = 'article_Actif'; }
            }
            if (count($liste_colonnes_a_indexer) > 0) {
                if (false === $mf_liste_requete_index = self::$cache_db->read('article__index')) {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('article').'`;', false);
                    $mf_liste_requete_index = array();
                    while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    self::$cache_db->write('article__index', $mf_liste_requete_index);
                }
                foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if (count($liste_colonnes_a_indexer) > 0) {
                    foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                        executer_requete_mysql('ALTER TABLE `'.inst('article').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    self::$cache_db->clear();
                }
            }

            $res_requete = executer_requete_mysql('SELECT count(Code_article) as nb FROM ' . inst('article')." WHERE 1{$argument_cond}".( $Code_type_produit!=0 ? " AND Code_type_produit=$Code_type_produit" : "" ).";", false);
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
        $Code_type_produit = isset($interface['Code_type_produit']) ? round($interface['Code_type_produit']) : 0;
        return $this->mf_compter( $Code_type_produit, $options );
    }

    public function mf_liste_Code_article(?int $Code_type_produit = null, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ($options === null) {
            $options=[];
        }
        return $this->get_liste_Code_article($Code_type_produit, $options);
    }

    public function mf_convertir_Code_article_vers_Code_type_produit( int $Code_article )
    {
        return $this->Code_article_vers_Code_type_produit( $Code_article );
    }

    public function mf_liste_Code_type_produit_vers_liste_Code_article( array $liste_Code_type_produit, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ($options === null) {
            $options=[];
        }
        return $this->liste_Code_type_produit_vers_liste_Code_article( $liste_Code_type_produit, $options );
    }

    public function mf_liste_Code_article_vers_liste_Code_type_produit( array $liste_Code_article, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ($options === null) {
            $options=[];
        }
        return $this->article__liste_Code_article_vers_liste_Code_type_produit( $liste_Code_article, $options );
    }

    public function mf_get_liste_tables_enfants()
    {
        return $this->get_liste_tables_enfants( 'article' );
    }

    public function mf_get_liste_tables_parents()
    {
        return array('Code_type_produit');
    }

    public function mf_search_article_Libelle( string $article_Libelle, ?int $Code_type_produit = null )
    {
        return $this->rechercher_article_Libelle( $article_Libelle, $Code_type_produit );
    }

    public function mf_search_article_Photo_Fichier( string $article_Photo_Fichier, ?int $Code_type_produit = null )
    {
        return $this->rechercher_article_Photo_Fichier( $article_Photo_Fichier, $Code_type_produit );
    }

    public function mf_search_article_Prix( float $article_Prix, ?int $Code_type_produit = null )
    {
        return $this->rechercher_article_Prix( $article_Prix, $Code_type_produit );
    }

    public function mf_search_article_Actif( bool $article_Actif, ?int $Code_type_produit = null )
    {
        return $this->rechercher_article_Actif( $article_Actif, $Code_type_produit );
    }

    public function mf_search__colonne( string $colonne_db, $recherche, ?int $Code_type_produit = null )
    {
        switch ($colonne_db) {
            case 'article_Libelle': return $this->mf_search_article_Libelle( $recherche, $Code_type_produit ); break;
            case 'article_Photo_Fichier': return $this->mf_search_article_Photo_Fichier( $recherche, $Code_type_produit ); break;
            case 'article_Prix': return $this->mf_search_article_Prix( $recherche, $Code_type_produit ); break;
            case 'article_Actif': return $this->mf_search_article_Actif( $recherche, $Code_type_produit ); break;
        }
    }

    public function mf_get_next_id()
    {
        $res_requete = executer_requete_mysql('SELECT AUTO_INCREMENT as next_id FROM INFORMATION_SCHEMA.TABLES WHERE table_name = \'article\';', false);
        $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC);
        mysqli_free_result($res_requete);
        return round($row_requete['next_id']);
    }

    public function mf_search(array $ligne) // array('colonne1' => 'valeur1',  [...] )
    {
        global $mf_initialisation;
        $Code_type_produit = (int)(isset($ligne['Code_type_produit'])?round($ligne['Code_type_produit']):0);
        $article_Libelle = (string)(isset($ligne['article_Libelle'])?$ligne['article_Libelle']:$mf_initialisation['article_Libelle']);
        $article_Photo_Fichier = (string)(isset($ligne['article_Photo_Fichier'])?$ligne['article_Photo_Fichier']:$mf_initialisation['article_Photo_Fichier']);
        $article_Prix = (float)(isset($ligne['article_Prix'])?$ligne['article_Prix']:$mf_initialisation['article_Prix']);
        $article_Actif = (bool)(isset($ligne['article_Actif'])?$ligne['article_Actif']:$mf_initialisation['article_Actif']);
        $article_Prix = floatval(str_replace(' ','',str_replace(',','.',$article_Prix)));
        Hook_article::pre_controller($article_Libelle, $article_Photo_Fichier, $article_Prix, $article_Actif, $Code_type_produit);
        $mf_cle_unique = Hook_article::calcul_cle_unique($article_Libelle, $article_Photo_Fichier, $article_Prix, $article_Actif, $Code_type_produit);
        $res_requete = executer_requete_mysql('SELECT Code_article FROM ' . inst('article') . ' WHERE mf_cle_unique = \''.$mf_cle_unique.'\'', false);
        if ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
        {
            $r = round($row_requete['Code_article']);
        }
        else
        {
            $r = false;
        }
        mysqli_free_result($res_requete);
        return $r;
    }
}
