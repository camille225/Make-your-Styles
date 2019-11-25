<?php

include __DIR__ . '/mf_cachedb.php';

class entite_monframework extends entite
{

    private $mf_dupliquer_table_de_conversion;
    private $mf_dupliquer_tables_a_dupliquer;

/*
    +---------------+
    |  utilisateur  |
    +---------------+
*/

    protected function mf_tester_existance_Code_utilisateur( int $Code_utilisateur )
    {
        $Code_utilisateur = round($Code_utilisateur);
        $requete_sql = "SELECT Code_utilisateur FROM ".inst('utilisateur')." WHERE Code_utilisateur = $Code_utilisateur;";
        $cache_db = new Mf_Cachedb('utilisateur');
        if (false === $r = $cache_db->read($requete_sql)) {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) $r = 'o'; else $r = 'n';
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $r);
        }
        return $r == 'o';
    }

    protected function rechercher_utilisateur_Identifiant( string $utilisateur_Identifiant )
    {
        $Code_utilisateur = 0;
        $utilisateur_Identifiant = format_sql('utilisateur_Identifiant', $utilisateur_Identifiant);
        $requete_sql = 'SELECT Code_utilisateur FROM '.inst('utilisateur').' WHERE utilisateur_Identifiant = ' . $utilisateur_Identifiant . ' LIMIT 0, 1;';
        $cache_db = new Mf_Cachedb('utilisateur');
        if (false === $Code_utilisateur = $cache_db->read($requete_sql)) {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $Code_utilisateur = (int) $row_requete['Code_utilisateur'];
            } else {
                $Code_utilisateur = 0;
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_utilisateur);
        }
        return $Code_utilisateur;
    }

    protected function rechercher_utilisateur_Password( string $utilisateur_Password )
    {
        $Code_utilisateur = 0;
        $utilisateur_Password = format_sql('utilisateur_Password', $utilisateur_Password);
        $requete_sql = 'SELECT Code_utilisateur FROM '.inst('utilisateur')." WHERE utilisateur_Password = $utilisateur_Password LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('utilisateur');
        if (false === $Code_utilisateur = $cache_db->read($requete_sql)) {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $Code_utilisateur = (int) $row_requete['Code_utilisateur'];
            } else {
                $Code_utilisateur = 0;
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_utilisateur);
        }
        return $Code_utilisateur;
    }

    protected function rechercher_utilisateur_Email( string $utilisateur_Email )
    {
        $Code_utilisateur = 0;
        $utilisateur_Email = format_sql('utilisateur_Email', $utilisateur_Email);
        $requete_sql = 'SELECT Code_utilisateur FROM '.inst('utilisateur')." WHERE utilisateur_Email = $utilisateur_Email LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('utilisateur');
        if (false === $Code_utilisateur = $cache_db->read($requete_sql)) {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $Code_utilisateur = (int) $row_requete['Code_utilisateur'];
            } else {
                $Code_utilisateur = 0;
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_utilisateur);
        }
        return $Code_utilisateur;
    }

    protected function rechercher_utilisateur_Administrateur( bool $utilisateur_Administrateur )
    {
        $Code_utilisateur = 0;
        $utilisateur_Administrateur = format_sql('utilisateur_Administrateur', $utilisateur_Administrateur);
        $requete_sql = 'SELECT Code_utilisateur FROM '.inst('utilisateur')." WHERE utilisateur_Administrateur = $utilisateur_Administrateur LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('utilisateur');
        if (false === $Code_utilisateur = $cache_db->read($requete_sql)) {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $Code_utilisateur = (int) $row_requete['Code_utilisateur'];
            } else {
                $Code_utilisateur = 0;
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_utilisateur);
        }
        return $Code_utilisateur;
    }

    protected function rechercher_utilisateur_Developpeur( bool $utilisateur_Developpeur )
    {
        $Code_utilisateur = 0;
        $utilisateur_Developpeur = format_sql('utilisateur_Developpeur', $utilisateur_Developpeur);
        $requete_sql = 'SELECT Code_utilisateur FROM '.inst('utilisateur')." WHERE utilisateur_Developpeur = $utilisateur_Developpeur LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('utilisateur');
        if (false === $Code_utilisateur = $cache_db->read($requete_sql)) {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $Code_utilisateur = (int) $row_requete['Code_utilisateur'];
            } else {
                $Code_utilisateur = 0;
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_utilisateur);
        }
        return $Code_utilisateur;
    }

    protected function __get_liste_Code_utilisateur(?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        return $this->get_liste_Code_utilisateur($options);
    }

    protected function get_liste_Code_utilisateur(?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cache_db = new Mf_Cachedb('utilisateur');
        $cle = "utilisateur__lister_cles";

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql'])) {
            foreach ($options['cond_mysql'] as &$condition) {
                $argument_cond .= ' AND (' . $condition . ')';
            }
            unset($condition);
        }
        $cle .= '_' . $argument_cond;

        // limit
        $argument_limit = '';
        if (isset($options['limit'][0]) && isset($options['limit'][1])) {
            $argument_limit = ' LIMIT ' . $options['limit'][0] . ',' . $options['limit'][1];
        }
        $cle .= '_' . $argument_limit;

        if (false === $liste = $cache_db->read($cle)) {

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
                if (false === $mf_liste_requete_index = $cache_db->read('utilisateur__index')) {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('utilisateur').'`;', false);
                    $mf_liste_requete_index = array();
                    while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('utilisateur__index', $mf_liste_requete_index);
                }
                foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if (count($liste_colonnes_a_indexer) > 0) {
                    foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                        executer_requete_mysql('ALTER TABLE `'.inst('utilisateur').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                }
            }

            $liste = array();
            $table = inst('utilisateur');
            $res_requete = executer_requete_mysql("SELECT Code_utilisateur FROM $table WHERE 1 $argument_cond ORDER BY Code_utilisateur ASC $argument_limit;", false);
            while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $liste[] = (int) $row_requete['Code_utilisateur'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste);
        }
        return $liste;
    }

    private function mf_dupliquer_utilisateur( int $Code_utilisateur )
    {
        $code_erreur = 0;
        $Code_new_utilisateur = 0;
        $Code_utilisateur = round($Code_utilisateur);
        if ( !$this->mf_tester_existance_Code_utilisateur($Code_utilisateur) ) $code_erreur = 1;
        else
        {
            $donnees_a_copier = $this->mf_get($Code_utilisateur, array('autocompletion' => false));
            $utilisateur_Identifiant = $donnees_a_copier['utilisateur_Identifiant'];
            $utilisateur_Password = $donnees_a_copier['utilisateur_Password'];
            $utilisateur_Email = $donnees_a_copier['utilisateur_Email'];
            $utilisateur_Administrateur = $donnees_a_copier['utilisateur_Administrateur'];
            $utilisateur_Developpeur = $donnees_a_copier['utilisateur_Developpeur'];
            $utilisateur_Identifiant = text_sql($utilisateur_Identifiant);
            $salt = salt(100);
            $utilisateur_Password = md5($utilisateur_Password.$salt).':'.$salt;
            $utilisateur_Email = text_sql($utilisateur_Email);
            $utilisateur_Administrateur = ($utilisateur_Administrateur==1 ? 1 : 0);
            $utilisateur_Developpeur = ($utilisateur_Developpeur==1 ? 1 : 0);
            executer_requete_mysql("INSERT INTO utilisateur ( utilisateur_Identifiant, utilisateur_Password, utilisateur_Email, utilisateur_Administrateur, utilisateur_Developpeur ) VALUES ( '$utilisateur_Identifiant', '$utilisateur_Password', '$utilisateur_Email', $utilisateur_Administrateur, $utilisateur_Developpeur );", array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            $Code_new_utilisateur = requete_mysql_insert_id();
            if ($Code_new_utilisateur==0)
            {
                $code_erreur = 999999;
            }
            else
            {
                $cache_db = new Mf_Cachedb("utilisateur");
                $cache_db->clear();
                $liste_Code_commande = $this->liste_Code_utilisateur_vers_liste_Code_commande( array($Code_utilisateur) );
                foreach ($liste_Code_commande as $Code_commande)
                {
                    $this->mf_dupliquer_tables_a_dupliquer["commande_$Code_commande"]=array('commande', $Code_commande);
                }
                $this->mf_dupliquer_table_de_conversion['Code_utilisateur'][$Code_utilisateur] = $Code_new_utilisateur;
            }
        }
        return array('code_erreur' => $code_erreur, "Code_utilisateur" => $Code_new_utilisateur);
    }

/*
    +-----------+
    |  article  |
    +-----------+
*/

    protected function mf_tester_existance_Code_article( int $Code_article )
    {
        $Code_article = round($Code_article);
        $requete_sql = "SELECT Code_article FROM ".inst('article')." WHERE Code_article = $Code_article;";
        $cache_db = new Mf_Cachedb('article');
        if (false === $r = $cache_db->read($requete_sql)) {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) $r = 'o'; else $r = 'n';
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $r);
        }
        return $r == 'o';
    }

    protected function rechercher_article_Libelle( string $article_Libelle, ?int $Code_type_produit = null )
    {
        $Code_article = 0;
        $article_Libelle = format_sql('article_Libelle', $article_Libelle);
        $Code_type_produit = round($Code_type_produit);
        $requete_sql = 'SELECT Code_article FROM '.inst('article')." WHERE article_Libelle = $article_Libelle".( $Code_type_produit!=0 ? " AND Code_type_produit=$Code_type_produit" : "" )." LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('article');
        if (false === $Code_article = $cache_db->read($requete_sql)) {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $Code_article = (int) $row_requete['Code_article'];
            } else {
                $Code_article = 0;
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_article);
        }
        return $Code_article;
    }

    protected function rechercher_article_Photo_Fichier( string $article_Photo_Fichier, ?int $Code_type_produit = null )
    {
        $Code_article = 0;
        $article_Photo_Fichier = format_sql('article_Photo_Fichier', $article_Photo_Fichier);
        $Code_type_produit = round($Code_type_produit);
        $requete_sql = 'SELECT Code_article FROM '.inst('article')." WHERE article_Photo_Fichier = $article_Photo_Fichier".( $Code_type_produit!=0 ? " AND Code_type_produit=$Code_type_produit" : "" )." LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('article');
        if (false === $Code_article = $cache_db->read($requete_sql)) {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $Code_article = (int) $row_requete['Code_article'];
            } else {
                $Code_article = 0;
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_article);
        }
        return $Code_article;
    }

    protected function rechercher_article_Prix( float $article_Prix, ?int $Code_type_produit = null )
    {
        $Code_article = 0;
        $article_Prix = format_sql('article_Prix', $article_Prix);
        $Code_type_produit = round($Code_type_produit);
        $requete_sql = 'SELECT Code_article FROM '.inst('article')." WHERE article_Prix = $article_Prix".( $Code_type_produit!=0 ? " AND Code_type_produit=$Code_type_produit" : "" )." LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('article');
        if (false === $Code_article = $cache_db->read($requete_sql)) {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $Code_article = (int) $row_requete['Code_article'];
            } else {
                $Code_article = 0;
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_article);
        }
        return $Code_article;
    }

    protected function rechercher_article_Actif( bool $article_Actif, ?int $Code_type_produit = null )
    {
        $Code_article = 0;
        $article_Actif = format_sql('article_Actif', $article_Actif);
        $Code_type_produit = round($Code_type_produit);
        $requete_sql = 'SELECT Code_article FROM '.inst('article')." WHERE article_Actif = $article_Actif".( $Code_type_produit!=0 ? " AND Code_type_produit=$Code_type_produit" : "" )." LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('article');
        if (false === $Code_article = $cache_db->read($requete_sql)) {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $Code_article = (int) $row_requete['Code_article'];
            } else {
                $Code_article = 0;
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_article);
        }
        return $Code_article;
    }

    protected function __get_liste_Code_article(?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        return $this->get_liste_Code_article(null, $options);
    }

    protected function get_liste_Code_article(?int $Code_type_produit = null, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cache_db = new Mf_Cachedb('article');
        $cle = "article__lister_cles";
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

        // limit
        $argument_limit = '';
        if (isset($options['limit'][0]) && isset($options['limit'][1])) {
            $argument_limit = ' LIMIT ' . $options['limit'][0] . ',' . $options['limit'][1];
        }
        $cle .= '_' . $argument_limit;

        if (false === $liste = $cache_db->read($cle)) {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ($argument_cond != '') {
                if ( strpos($argument_cond, 'article_Libelle')!==false ) { $liste_colonnes_a_indexer['article_Libelle'] = 'article_Libelle'; }
                if ( strpos($argument_cond, 'article_Photo_Fichier')!==false ) { $liste_colonnes_a_indexer['article_Photo_Fichier'] = 'article_Photo_Fichier'; }
                if ( strpos($argument_cond, 'article_Prix')!==false ) { $liste_colonnes_a_indexer['article_Prix'] = 'article_Prix'; }
                if ( strpos($argument_cond, 'article_Actif')!==false ) { $liste_colonnes_a_indexer['article_Actif'] = 'article_Actif'; }
            }
            if (count($liste_colonnes_a_indexer) > 0) {
                if (false === $mf_liste_requete_index = $cache_db->read('article__index')) {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('article').'`;', false);
                    $mf_liste_requete_index = array();
                    while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('article__index', $mf_liste_requete_index);
                }
                foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if (count($liste_colonnes_a_indexer) > 0) {
                    foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                        executer_requete_mysql('ALTER TABLE `'.inst('article').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                }
            }

            $liste = array();
            $table = inst('article');
            $res_requete = executer_requete_mysql("SELECT Code_article FROM $table WHERE 1 ".( $Code_type_produit!=0 ? " AND Code_type_produit=$Code_type_produit" : "" )."$argument_cond ORDER BY Code_article ASC $argument_limit;", false);
            while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $liste[] = (int) $row_requete['Code_article'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste);
        }
        return $liste;
    }

    protected function Code_article_vers_Code_type_produit( int $Code_article )
    {
        $Code_article = round($Code_article);
        if ($Code_article<0) $Code_article = 0;
        $p = floor($Code_article/100);
        $start = $p*100;
        $end = ($p+1)*100;
        $cache_db = new Mf_Cachedb('article');
        $cle = 'Code_article_vers_Code_type_produit__'.$start.'__'.$end;
        if (false === $conversion = $cache_db->read($cle)) {
            $res_requete = executer_requete_mysql('SELECT Code_article, Code_type_produit FROM '.inst('article').' WHERE '.$start.' <= Code_article AND Code_article < '.$end.';', false);
            $conversion = array();
            while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $conversion[(int) $row_requete['Code_article']] = (int) $row_requete['Code_type_produit'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $conversion);
        }
        return (isset($conversion[$Code_article]) ? $conversion[$Code_article] : 0);
    }

    protected function liste_Code_type_produit_vers_liste_Code_article( array $liste_Code_type_produit, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ($options === null) {
            $options=[];
        }
        $cache_db = new Mf_Cachedb('article');
        $cle = 'liste_Code_type_produit_vers_liste_Code_article__' . Sql_Format_Liste($liste_Code_type_produit);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql'])) {
            foreach ($options['cond_mysql'] as &$condition) {
                $argument_cond .= ' AND (' . $condition . ')';
            }
            unset($condition);
        }
        $cle .= '_' . $argument_cond;

        if (false === $liste_Code_article = $cache_db->read($cle)) {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ($argument_cond != '') {
                if ( strpos($argument_cond, 'article_Libelle')!==false ) { $liste_colonnes_a_indexer['article_Libelle'] = 'article_Libelle'; }
                if ( strpos($argument_cond, 'article_Photo_Fichier')!==false ) { $liste_colonnes_a_indexer['article_Photo_Fichier'] = 'article_Photo_Fichier'; }
                if ( strpos($argument_cond, 'article_Prix')!==false ) { $liste_colonnes_a_indexer['article_Prix'] = 'article_Prix'; }
                if ( strpos($argument_cond, 'article_Actif')!==false ) { $liste_colonnes_a_indexer['article_Actif'] = 'article_Actif'; }
            }
            if (count($liste_colonnes_a_indexer) > 0) {
                if (false === $mf_liste_requete_index = $cache_db->read('article__index')) {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('article').'`;', false);
                    $mf_liste_requete_index = array();
                    while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('article__index', $mf_liste_requete_index);
                }
                foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if (count($liste_colonnes_a_indexer) > 0) {
                    foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                        executer_requete_mysql('ALTER TABLE `'.inst('article').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                }
            }

            $liste_Code_article = array();
            $res_requete = executer_requete_mysql('SELECT Code_article FROM '.inst('article')." WHERE Code_type_produit IN ".Sql_Format_Liste($liste_Code_type_produit).$argument_cond.";", false);
            while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $liste_Code_article[] = (int) $row_requete['Code_article'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_article);
        }
        return $liste_Code_article;
    }

    protected function article__liste_Code_article_vers_liste_Code_type_produit( array $liste_Code_article, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ($options === null) {
            $options=[];
        }
        $cache_db = new Mf_Cachedb("article");
        $cle = "liste_Code_article_vers_liste_Code_type_produit__".Sql_Format_Liste($liste_Code_article);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql'])) {
            foreach ($options['cond_mysql'] as &$condition) {
                $argument_cond .= ' AND (' . $condition . ')';
            }
            unset($condition);
        }
        $cle .= '_' . $argument_cond;

        if (false === $liste_Code_type_produit = $cache_db->read($cle)) {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ($argument_cond != '') {
                if ( strpos($argument_cond, 'article_Libelle')!==false ) { $liste_colonnes_a_indexer['article_Libelle'] = 'article_Libelle'; }
                if ( strpos($argument_cond, 'article_Photo_Fichier')!==false ) { $liste_colonnes_a_indexer['article_Photo_Fichier'] = 'article_Photo_Fichier'; }
                if ( strpos($argument_cond, 'article_Prix')!==false ) { $liste_colonnes_a_indexer['article_Prix'] = 'article_Prix'; }
                if ( strpos($argument_cond, 'article_Actif')!==false ) { $liste_colonnes_a_indexer['article_Actif'] = 'article_Actif'; }
            }
            if (count($liste_colonnes_a_indexer) > 0) {
                if (false === $mf_liste_requete_index = $cache_db->read('article__index')) {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('article').'`;', false);
                    $mf_liste_requete_index = array();
                    while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('article__index', $mf_liste_requete_index);
                }
                foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if (count($liste_colonnes_a_indexer) > 0) {
                    foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                        executer_requete_mysql('ALTER TABLE `'.inst('article').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                }
            }

            $controle_doublons = array();
            $liste_Code_type_produit = array();
            $res_requete = executer_requete_mysql("SELECT Code_type_produit FROM ".inst('article')." WHERE Code_article IN ".Sql_Format_Liste($liste_Code_article).$argument_cond.";", false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                if ( ! isset($controle_doublons[(int) $row_requete['Code_type_produit']]) )
                {
                    $controle_doublons[(int) $row_requete['Code_type_produit']] = 1;
                    $liste_Code_type_produit[] = (int) $row_requete['Code_type_produit'];
                }
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_type_produit);
        }
        return $liste_Code_type_produit;
    }

    private function mf_dupliquer_article( int $Code_article )
    {
        $code_erreur = 0;
        $Code_new_article = 0;
        $Code_article = round($Code_article);
        if ( !$this->mf_tester_existance_Code_article($Code_article) ) $code_erreur = 1;
        else
        {
            $donnees_a_copier = $this->mf_get($Code_article, array('autocompletion' => false));
            $article_Libelle = $donnees_a_copier['article_Libelle'];
            $article_Photo_Fichier = $donnees_a_copier['article_Photo_Fichier'];
            $article_Prix = $donnees_a_copier['article_Prix'];
            $article_Actif = $donnees_a_copier['article_Actif'];
            $article_Libelle = text_sql($article_Libelle);
            $article_Photo_Fichier = text_sql($article_Photo_Fichier);
            $article_Prix = floatval($article_Prix);
            $article_Actif = ($article_Actif==1 ? 1 : 0);
            $Code_type_produit = round($donnees_a_copier['Code_type_produit']);
            if ( isset($this->mf_dupliquer_table_de_conversion['Code_type_produit'][$Code_type_produit]) ) $Code_type_produit = $this->mf_dupliquer_table_de_conversion['Code_type_produit'][$Code_type_produit];
            elseif ( isset($this->mf_dupliquer_table_de_conversion['Code_type_produit'][0]) ) $Code_type_produit = $this->mf_dupliquer_table_de_conversion['Code_type_produit'][0];
            executer_requete_mysql("INSERT INTO article ( article_Libelle, article_Photo_Fichier, article_Prix, article_Actif, Code_type_produit ) VALUES ( '$article_Libelle', '$article_Photo_Fichier', $article_Prix, $article_Actif, $Code_type_produit );", array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            $Code_new_article = requete_mysql_insert_id();
            if ($Code_new_article==0)
            {
                $code_erreur = 999999;
            }
            else
            {
                $cache_db = new Mf_Cachedb("article");
                $cache_db->clear();
                $this->mf_dupliquer_table_de_conversion['Code_article'][$Code_article] = $Code_new_article;
            }
        }
        return array('code_erreur' => $code_erreur, "Code_article" => $Code_new_article);
    }

/*
    +------------+
    |  commande  |
    +------------+
*/

    protected function mf_tester_existance_Code_commande( int $Code_commande )
    {
        $Code_commande = round($Code_commande);
        $requete_sql = "SELECT Code_commande FROM ".inst('commande')." WHERE Code_commande = $Code_commande;";
        $cache_db = new Mf_Cachedb('commande');
        if (false === $r = $cache_db->read($requete_sql)) {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) $r = 'o'; else $r = 'n';
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $r);
        }
        return $r == 'o';
    }

    protected function rechercher_commande_Prix_total( float $commande_Prix_total, ?int $Code_utilisateur = null )
    {
        $Code_commande = 0;
        $commande_Prix_total = format_sql('commande_Prix_total', $commande_Prix_total);
        $Code_utilisateur = round($Code_utilisateur);
        $requete_sql = 'SELECT Code_commande FROM '.inst('commande')." WHERE commande_Prix_total = $commande_Prix_total".( $Code_utilisateur!=0 ? " AND Code_utilisateur=$Code_utilisateur" : "" )." LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('commande');
        if (false === $Code_commande = $cache_db->read($requete_sql)) {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $Code_commande = (int) $row_requete['Code_commande'];
            } else {
                $Code_commande = 0;
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_commande);
        }
        return $Code_commande;
    }

    protected function rechercher_commande_Date_livraison( string $commande_Date_livraison, ?int $Code_utilisateur = null )
    {
        $Code_commande = 0;
        $commande_Date_livraison = format_sql('commande_Date_livraison', $commande_Date_livraison);
        $Code_utilisateur = round($Code_utilisateur);
        $requete_sql = 'SELECT Code_commande FROM '.inst('commande')." WHERE commande_Date_livraison = $commande_Date_livraison".( $Code_utilisateur!=0 ? " AND Code_utilisateur=$Code_utilisateur" : "" )." LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('commande');
        if (false === $Code_commande = $cache_db->read($requete_sql)) {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $Code_commande = (int) $row_requete['Code_commande'];
            } else {
                $Code_commande = 0;
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_commande);
        }
        return $Code_commande;
    }

    protected function rechercher_commande_Date_creation( string $commande_Date_creation, ?int $Code_utilisateur = null )
    {
        $Code_commande = 0;
        $commande_Date_creation = format_sql('commande_Date_creation', $commande_Date_creation);
        $Code_utilisateur = round($Code_utilisateur);
        $requete_sql = 'SELECT Code_commande FROM '.inst('commande')." WHERE commande_Date_creation = $commande_Date_creation".( $Code_utilisateur!=0 ? " AND Code_utilisateur=$Code_utilisateur" : "" )." LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('commande');
        if (false === $Code_commande = $cache_db->read($requete_sql)) {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $Code_commande = (int) $row_requete['Code_commande'];
            } else {
                $Code_commande = 0;
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_commande);
        }
        return $Code_commande;
    }

    protected function __get_liste_Code_commande(?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        return $this->get_liste_Code_commande(null, $options);
    }

    protected function get_liste_Code_commande(?int $Code_utilisateur = null, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cache_db = new Mf_Cachedb('commande');
        $cle = "commande__lister_cles";
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

        // limit
        $argument_limit = '';
        if (isset($options['limit'][0]) && isset($options['limit'][1])) {
            $argument_limit = ' LIMIT ' . $options['limit'][0] . ',' . $options['limit'][1];
        }
        $cle .= '_' . $argument_limit;

        if (false === $liste = $cache_db->read($cle)) {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ($argument_cond != '') {
                if ( strpos($argument_cond, 'commande_Prix_total')!==false ) { $liste_colonnes_a_indexer['commande_Prix_total'] = 'commande_Prix_total'; }
                if ( strpos($argument_cond, 'commande_Date_livraison')!==false ) { $liste_colonnes_a_indexer['commande_Date_livraison'] = 'commande_Date_livraison'; }
                if ( strpos($argument_cond, 'commande_Date_creation')!==false ) { $liste_colonnes_a_indexer['commande_Date_creation'] = 'commande_Date_creation'; }
            }
            if (count($liste_colonnes_a_indexer) > 0) {
                if (false === $mf_liste_requete_index = $cache_db->read('commande__index')) {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('commande').'`;', false);
                    $mf_liste_requete_index = array();
                    while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('commande__index', $mf_liste_requete_index);
                }
                foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if (count($liste_colonnes_a_indexer) > 0) {
                    foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                        executer_requete_mysql('ALTER TABLE `'.inst('commande').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                }
            }

            $liste = array();
            $table = inst('commande');
            $res_requete = executer_requete_mysql("SELECT Code_commande FROM $table WHERE 1 ".( $Code_utilisateur!=0 ? " AND Code_utilisateur=$Code_utilisateur" : "" )."$argument_cond ORDER BY Code_commande ASC $argument_limit;", false);
            while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $liste[] = (int) $row_requete['Code_commande'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste);
        }
        return $liste;
    }

    protected function Code_commande_vers_Code_utilisateur( int $Code_commande )
    {
        $Code_commande = round($Code_commande);
        if ($Code_commande<0) $Code_commande = 0;
        $p = floor($Code_commande/100);
        $start = $p*100;
        $end = ($p+1)*100;
        $cache_db = new Mf_Cachedb('commande');
        $cle = 'Code_commande_vers_Code_utilisateur__'.$start.'__'.$end;
        if (false === $conversion = $cache_db->read($cle)) {
            $res_requete = executer_requete_mysql('SELECT Code_commande, Code_utilisateur FROM '.inst('commande').' WHERE '.$start.' <= Code_commande AND Code_commande < '.$end.';', false);
            $conversion = array();
            while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $conversion[(int) $row_requete['Code_commande']] = (int) $row_requete['Code_utilisateur'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $conversion);
        }
        return (isset($conversion[$Code_commande]) ? $conversion[$Code_commande] : 0);
    }

    protected function liste_Code_utilisateur_vers_liste_Code_commande( array $liste_Code_utilisateur, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ($options === null) {
            $options=[];
        }
        $cache_db = new Mf_Cachedb('commande');
        $cle = 'liste_Code_utilisateur_vers_liste_Code_commande__' . Sql_Format_Liste($liste_Code_utilisateur);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql'])) {
            foreach ($options['cond_mysql'] as &$condition) {
                $argument_cond .= ' AND (' . $condition . ')';
            }
            unset($condition);
        }
        $cle .= '_' . $argument_cond;

        if (false === $liste_Code_commande = $cache_db->read($cle)) {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ($argument_cond != '') {
                if ( strpos($argument_cond, 'commande_Prix_total')!==false ) { $liste_colonnes_a_indexer['commande_Prix_total'] = 'commande_Prix_total'; }
                if ( strpos($argument_cond, 'commande_Date_livraison')!==false ) { $liste_colonnes_a_indexer['commande_Date_livraison'] = 'commande_Date_livraison'; }
                if ( strpos($argument_cond, 'commande_Date_creation')!==false ) { $liste_colonnes_a_indexer['commande_Date_creation'] = 'commande_Date_creation'; }
            }
            if (count($liste_colonnes_a_indexer) > 0) {
                if (false === $mf_liste_requete_index = $cache_db->read('commande__index')) {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('commande').'`;', false);
                    $mf_liste_requete_index = array();
                    while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('commande__index', $mf_liste_requete_index);
                }
                foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if (count($liste_colonnes_a_indexer) > 0) {
                    foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                        executer_requete_mysql('ALTER TABLE `'.inst('commande').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                }
            }

            $liste_Code_commande = array();
            $res_requete = executer_requete_mysql('SELECT Code_commande FROM '.inst('commande')." WHERE Code_utilisateur IN ".Sql_Format_Liste($liste_Code_utilisateur).$argument_cond.";", false);
            while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $liste_Code_commande[] = (int) $row_requete['Code_commande'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_commande);
        }
        return $liste_Code_commande;
    }

    protected function commande__liste_Code_commande_vers_liste_Code_utilisateur( array $liste_Code_commande, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ($options === null) {
            $options=[];
        }
        $cache_db = new Mf_Cachedb("commande");
        $cle = "liste_Code_commande_vers_liste_Code_utilisateur__".Sql_Format_Liste($liste_Code_commande);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql'])) {
            foreach ($options['cond_mysql'] as &$condition) {
                $argument_cond .= ' AND (' . $condition . ')';
            }
            unset($condition);
        }
        $cle .= '_' . $argument_cond;

        if (false === $liste_Code_utilisateur = $cache_db->read($cle)) {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ($argument_cond != '') {
                if ( strpos($argument_cond, 'commande_Prix_total')!==false ) { $liste_colonnes_a_indexer['commande_Prix_total'] = 'commande_Prix_total'; }
                if ( strpos($argument_cond, 'commande_Date_livraison')!==false ) { $liste_colonnes_a_indexer['commande_Date_livraison'] = 'commande_Date_livraison'; }
                if ( strpos($argument_cond, 'commande_Date_creation')!==false ) { $liste_colonnes_a_indexer['commande_Date_creation'] = 'commande_Date_creation'; }
            }
            if (count($liste_colonnes_a_indexer) > 0) {
                if (false === $mf_liste_requete_index = $cache_db->read('commande__index')) {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('commande').'`;', false);
                    $mf_liste_requete_index = array();
                    while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('commande__index', $mf_liste_requete_index);
                }
                foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if (count($liste_colonnes_a_indexer) > 0) {
                    foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                        executer_requete_mysql('ALTER TABLE `'.inst('commande').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                }
            }

            $controle_doublons = array();
            $liste_Code_utilisateur = array();
            $res_requete = executer_requete_mysql("SELECT Code_utilisateur FROM ".inst('commande')." WHERE Code_commande IN ".Sql_Format_Liste($liste_Code_commande).$argument_cond.";", false);
            while ( $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC) )
            {
                if ( ! isset($controle_doublons[(int) $row_requete['Code_utilisateur']]) )
                {
                    $controle_doublons[(int) $row_requete['Code_utilisateur']] = 1;
                    $liste_Code_utilisateur[] = (int) $row_requete['Code_utilisateur'];
                }
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_utilisateur);
        }
        return $liste_Code_utilisateur;
    }

    private function mf_dupliquer_commande( int $Code_commande )
    {
        $code_erreur = 0;
        $Code_new_commande = 0;
        $Code_commande = round($Code_commande);
        if ( !$this->mf_tester_existance_Code_commande($Code_commande) ) $code_erreur = 1;
        else
        {
            $donnees_a_copier = $this->mf_get($Code_commande, array('autocompletion' => false));
            $commande_Prix_total = $donnees_a_copier['commande_Prix_total'];
            $commande_Date_livraison = $donnees_a_copier['commande_Date_livraison'];
            $commande_Date_creation = $donnees_a_copier['commande_Date_creation'];
            $commande_Prix_total = floatval($commande_Prix_total);
            $commande_Date_livraison = format_date($commande_Date_livraison);
            $commande_Date_creation = format_date($commande_Date_creation);
            $Code_utilisateur = round($donnees_a_copier['Code_utilisateur']);
            if ( isset($this->mf_dupliquer_table_de_conversion['Code_utilisateur'][$Code_utilisateur]) ) $Code_utilisateur = $this->mf_dupliquer_table_de_conversion['Code_utilisateur'][$Code_utilisateur];
            elseif ( isset($this->mf_dupliquer_table_de_conversion['Code_utilisateur'][0]) ) $Code_utilisateur = $this->mf_dupliquer_table_de_conversion['Code_utilisateur'][0];
            executer_requete_mysql("INSERT INTO commande ( commande_Prix_total, commande_Date_livraison, commande_Date_creation, Code_utilisateur ) VALUES ( $commande_Prix_total, ".( $commande_Date_livraison!='' ? "'$commande_Date_livraison'" : 'NULL' ).", ".( $commande_Date_creation!='' ? "'$commande_Date_creation'" : 'NULL' ).", $Code_utilisateur );", array_search('commande', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            $Code_new_commande = requete_mysql_insert_id();
            if ($Code_new_commande==0)
            {
                $code_erreur = 999999;
            }
            else
            {
                $cache_db = new Mf_Cachedb("commande");
                $cache_db->clear();
                $this->mf_dupliquer_table_de_conversion['Code_commande'][$Code_commande] = $Code_new_commande;
            }
        }
        return array('code_erreur' => $code_erreur, "Code_commande" => $Code_new_commande);
    }

/*
    +----------------+
    |  type_produit  |
    +----------------+
*/

    protected function mf_tester_existance_Code_type_produit( int $Code_type_produit )
    {
        $Code_type_produit = round($Code_type_produit);
        $requete_sql = "SELECT Code_type_produit FROM ".inst('type_produit')." WHERE Code_type_produit = $Code_type_produit;";
        $cache_db = new Mf_Cachedb('type_produit');
        if (false === $r = $cache_db->read($requete_sql)) {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) $r = 'o'; else $r = 'n';
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $r);
        }
        return $r == 'o';
    }

    protected function rechercher_type_produit_Libelle( string $type_produit_Libelle )
    {
        $Code_type_produit = 0;
        $type_produit_Libelle = format_sql('type_produit_Libelle', $type_produit_Libelle);
        $requete_sql = 'SELECT Code_type_produit FROM '.inst('type_produit')." WHERE type_produit_Libelle = $type_produit_Libelle LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('type_produit');
        if (false === $Code_type_produit = $cache_db->read($requete_sql)) {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $Code_type_produit = (int) $row_requete['Code_type_produit'];
            } else {
                $Code_type_produit = 0;
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_type_produit);
        }
        return $Code_type_produit;
    }

    protected function __get_liste_Code_type_produit(?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        return $this->get_liste_Code_type_produit($options);
    }

    protected function get_liste_Code_type_produit(?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cache_db = new Mf_Cachedb('type_produit');
        $cle = "type_produit__lister_cles";

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql'])) {
            foreach ($options['cond_mysql'] as &$condition) {
                $argument_cond .= ' AND (' . $condition . ')';
            }
            unset($condition);
        }
        $cle .= '_' . $argument_cond;

        // limit
        $argument_limit = '';
        if (isset($options['limit'][0]) && isset($options['limit'][1])) {
            $argument_limit = ' LIMIT ' . $options['limit'][0] . ',' . $options['limit'][1];
        }
        $cle .= '_' . $argument_limit;

        if (false === $liste = $cache_db->read($cle)) {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ($argument_cond != '') {
                if ( strpos($argument_cond, 'type_produit_Libelle')!==false ) { $liste_colonnes_a_indexer['type_produit_Libelle'] = 'type_produit_Libelle'; }
            }
            if (count($liste_colonnes_a_indexer) > 0) {
                if (false === $mf_liste_requete_index = $cache_db->read('type_produit__index')) {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('type_produit').'`;', false);
                    $mf_liste_requete_index = array();
                    while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('type_produit__index', $mf_liste_requete_index);
                }
                foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if (count($liste_colonnes_a_indexer) > 0) {
                    foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                        executer_requete_mysql('ALTER TABLE `'.inst('type_produit').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                }
            }

            $liste = array();
            $table = inst('type_produit');
            $res_requete = executer_requete_mysql("SELECT Code_type_produit FROM $table WHERE 1 $argument_cond ORDER BY Code_type_produit ASC $argument_limit;", false);
            while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $liste[] = (int) $row_requete['Code_type_produit'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste);
        }
        return $liste;
    }

    private function mf_dupliquer_type_produit( int $Code_type_produit )
    {
        $code_erreur = 0;
        $Code_new_type_produit = 0;
        $Code_type_produit = round($Code_type_produit);
        if ( !$this->mf_tester_existance_Code_type_produit($Code_type_produit) ) $code_erreur = 1;
        else
        {
            $donnees_a_copier = $this->mf_get($Code_type_produit, array('autocompletion' => false));
            $type_produit_Libelle = $donnees_a_copier['type_produit_Libelle'];
            $type_produit_Libelle = text_sql($type_produit_Libelle);
            executer_requete_mysql("INSERT INTO type_produit ( type_produit_Libelle ) VALUES ( '$type_produit_Libelle' );", array_search('type_produit', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            $Code_new_type_produit = requete_mysql_insert_id();
            if ($Code_new_type_produit==0)
            {
                $code_erreur = 999999;
            }
            else
            {
                $cache_db = new Mf_Cachedb("type_produit");
                $cache_db->clear();
                $liste_Code_article = $this->liste_Code_type_produit_vers_liste_Code_article( array($Code_type_produit) );
                foreach ($liste_Code_article as $Code_article)
                {
                    $this->mf_dupliquer_tables_a_dupliquer["article_$Code_article"]=array('article', $Code_article);
                }
                $this->mf_dupliquer_table_de_conversion['Code_type_produit'][$Code_type_produit] = $Code_new_type_produit;
            }
        }
        return array('code_erreur' => $code_erreur, "Code_type_produit" => $Code_new_type_produit);
    }

/*
    +-------------+
    |  parametre  |
    +-------------+
*/

    protected function mf_tester_existance_Code_parametre( int $Code_parametre )
    {
        $Code_parametre = round($Code_parametre);
        $requete_sql = "SELECT Code_parametre FROM ".inst('parametre')." WHERE Code_parametre = $Code_parametre;";
        $cache_db = new Mf_Cachedb('parametre');
        if (false === $r = $cache_db->read($requete_sql)) {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) $r = 'o'; else $r = 'n';
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $r);
        }
        return $r == 'o';
    }

    protected function rechercher_parametre_Libelle( string $parametre_Libelle )
    {
        $Code_parametre = 0;
        $parametre_Libelle = format_sql('parametre_Libelle', $parametre_Libelle);
        $requete_sql = 'SELECT Code_parametre FROM '.inst('parametre')." WHERE parametre_Libelle = $parametre_Libelle LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('parametre');
        if (false === $Code_parametre = $cache_db->read($requete_sql)) {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $Code_parametre = (int) $row_requete['Code_parametre'];
            } else {
                $Code_parametre = 0;
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_parametre);
        }
        return $Code_parametre;
    }

    protected function __get_liste_Code_parametre(?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        return $this->get_liste_Code_parametre($options);
    }

    protected function get_liste_Code_parametre(?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cache_db = new Mf_Cachedb('parametre');
        $cle = "parametre__lister_cles";

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql'])) {
            foreach ($options['cond_mysql'] as &$condition) {
                $argument_cond .= ' AND (' . $condition . ')';
            }
            unset($condition);
        }
        $cle .= '_' . $argument_cond;

        // limit
        $argument_limit = '';
        if (isset($options['limit'][0]) && isset($options['limit'][1])) {
            $argument_limit = ' LIMIT ' . $options['limit'][0] . ',' . $options['limit'][1];
        }
        $cle .= '_' . $argument_limit;

        if (false === $liste = $cache_db->read($cle)) {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ($argument_cond != '') {
                if ( strpos($argument_cond, 'parametre_Libelle')!==false ) { $liste_colonnes_a_indexer['parametre_Libelle'] = 'parametre_Libelle'; }
            }
            if (count($liste_colonnes_a_indexer) > 0) {
                if (false === $mf_liste_requete_index = $cache_db->read('parametre__index')) {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('parametre').'`;', false);
                    $mf_liste_requete_index = array();
                    while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('parametre__index', $mf_liste_requete_index);
                }
                foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if (count($liste_colonnes_a_indexer) > 0) {
                    foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                        executer_requete_mysql('ALTER TABLE `'.inst('parametre').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                }
            }

            $liste = array();
            $table = inst('parametre');
            $res_requete = executer_requete_mysql("SELECT Code_parametre FROM $table WHERE 1 $argument_cond ORDER BY Code_parametre ASC $argument_limit;", false);
            while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $liste[] = (int) $row_requete['Code_parametre'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste);
        }
        return $liste;
    }

    private function mf_dupliquer_parametre( int $Code_parametre )
    {
        $code_erreur = 0;
        $Code_new_parametre = 0;
        $Code_parametre = round($Code_parametre);
        if ( !$this->mf_tester_existance_Code_parametre($Code_parametre) ) $code_erreur = 1;
        else
        {
            $donnees_a_copier = $this->mf_get($Code_parametre, array('autocompletion' => false));
            $parametre_Libelle = $donnees_a_copier['parametre_Libelle'];
            $parametre_Libelle = text_sql($parametre_Libelle);
            executer_requete_mysql("INSERT INTO parametre ( parametre_Libelle ) VALUES ( '$parametre_Libelle' );", array_search('parametre', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            $Code_new_parametre = requete_mysql_insert_id();
            if ($Code_new_parametre==0)
            {
                $code_erreur = 999999;
            }
            else
            {
                $cache_db = new Mf_Cachedb("parametre");
                $cache_db->clear();
                $this->mf_dupliquer_table_de_conversion['Code_parametre'][$Code_parametre] = $Code_new_parametre;
            }
        }
        return array('code_erreur' => $code_erreur, "Code_parametre" => $Code_new_parametre);
    }

/*
    +----------+
    |  filtre  |
    +----------+
*/

    protected function mf_tester_existance_Code_filtre( int $Code_filtre )
    {
        $Code_filtre = round($Code_filtre);
        $requete_sql = "SELECT Code_filtre FROM ".inst('filtre')." WHERE Code_filtre = $Code_filtre;";
        $cache_db = new Mf_Cachedb('filtre');
        if (false === $r = $cache_db->read($requete_sql)) {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) $r = 'o'; else $r = 'n';
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $r);
        }
        return $r == 'o';
    }

    protected function rechercher_filtre_Libelle( string $filtre_Libelle )
    {
        $Code_filtre = 0;
        $filtre_Libelle = format_sql('filtre_Libelle', $filtre_Libelle);
        $requete_sql = 'SELECT Code_filtre FROM '.inst('filtre')." WHERE filtre_Libelle = $filtre_Libelle LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('filtre');
        if (false === $Code_filtre = $cache_db->read($requete_sql)) {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $Code_filtre = (int) $row_requete['Code_filtre'];
            } else {
                $Code_filtre = 0;
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_filtre);
        }
        return $Code_filtre;
    }

    protected function __get_liste_Code_filtre(?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        return $this->get_liste_Code_filtre($options);
    }

    protected function get_liste_Code_filtre(?array $options = null /* $options = [ 'cond_mysql' => array() ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cache_db = new Mf_Cachedb('filtre');
        $cle = "filtre__lister_cles";

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql'])) {
            foreach ($options['cond_mysql'] as &$condition) {
                $argument_cond .= ' AND (' . $condition . ')';
            }
            unset($condition);
        }
        $cle .= '_' . $argument_cond;

        // limit
        $argument_limit = '';
        if (isset($options['limit'][0]) && isset($options['limit'][1])) {
            $argument_limit = ' LIMIT ' . $options['limit'][0] . ',' . $options['limit'][1];
        }
        $cle .= '_' . $argument_limit;

        if (false === $liste = $cache_db->read($cle)) {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ($argument_cond != '') {
                if ( strpos($argument_cond, 'filtre_Libelle')!==false ) { $liste_colonnes_a_indexer['filtre_Libelle'] = 'filtre_Libelle'; }
            }
            if (count($liste_colonnes_a_indexer) > 0) {
                if (false === $mf_liste_requete_index = $cache_db->read('filtre__index')) {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('filtre').'`;', false);
                    $mf_liste_requete_index = array();
                    while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('filtre__index', $mf_liste_requete_index);
                }
                foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if (count($liste_colonnes_a_indexer) > 0) {
                    foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                        executer_requete_mysql('ALTER TABLE `'.inst('filtre').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                }
            }

            $liste = array();
            $table = inst('filtre');
            $res_requete = executer_requete_mysql("SELECT Code_filtre FROM $table WHERE 1 $argument_cond ORDER BY Code_filtre ASC $argument_limit;", false);
            while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $liste[] = (int) $row_requete['Code_filtre'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste);
        }
        return $liste;
    }

    private function mf_dupliquer_filtre( int $Code_filtre )
    {
        $code_erreur = 0;
        $Code_new_filtre = 0;
        $Code_filtre = round($Code_filtre);
        if ( !$this->mf_tester_existance_Code_filtre($Code_filtre) ) $code_erreur = 1;
        else
        {
            $donnees_a_copier = $this->mf_get($Code_filtre, array('autocompletion' => false));
            $filtre_Libelle = $donnees_a_copier['filtre_Libelle'];
            $filtre_Libelle = text_sql($filtre_Libelle);
            executer_requete_mysql("INSERT INTO filtre ( filtre_Libelle ) VALUES ( '$filtre_Libelle' );", array_search('filtre', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            $Code_new_filtre = requete_mysql_insert_id();
            if ($Code_new_filtre==0)
            {
                $code_erreur = 999999;
            }
            else
            {
                $cache_db = new Mf_Cachedb("filtre");
                $cache_db->clear();
                $this->mf_dupliquer_table_de_conversion['Code_filtre'][$Code_filtre] = $Code_new_filtre;
            }
        }
        return array('code_erreur' => $code_erreur, "Code_filtre" => $Code_new_filtre);
    }

/*
    +----------------------+
    |  a_article_commande  |
    +----------------------+
*/

    protected function mf_tester_existance_a_article_commande(int $Code_commande, int $Code_article)
    {
        $Code_commande = round($Code_commande);
        $Code_article = round($Code_article);
        $requete_sql = 'SELECT * FROM ' . inst('a_article_commande') . " WHERE Code_commande=$Code_commande AND Code_article=$Code_article;";
        $cache_db = new Mf_Cachedb('a_article_commande');
        if (false === $r = $cache_db->read($requete_sql)) {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) $r = 'o'; else $r = 'n';
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $r);
        }
        return $r=='o';
    }

    private function mf_dupliquer_a_article_commande(int $Code_commande, int $Code_article)
    {
        $code_erreur = 0;
        $Code_commande = round($Code_commande);
        $Code_article = round($Code_article);
        if ( !$this->mf_tester_existance_a_article_commande( $Code_commande, $Code_article ) ) $code_erreur = 999999;
        else
        {
            if ( isset($this->mf_dupliquer_table_de_conversion['Code_commande'][$Code_commande]) ) $Code_commande = $this->mf_dupliquer_table_de_conversion['Code_commande'][$Code_commande];
            elseif ( isset($this->mf_dupliquer_table_de_conversion['Code_commande'][0]) ) $Code_commande = $this->mf_dupliquer_table_de_conversion['Code_commande'][0];
            if ( isset($this->mf_dupliquer_table_de_conversion['Code_article'][$Code_article]) ) $Code_article = $this->mf_dupliquer_table_de_conversion['Code_article'][$Code_article];
            elseif ( isset($this->mf_dupliquer_table_de_conversion['Code_article'][0]) ) $Code_article = $this->mf_dupliquer_table_de_conversion['Code_article'][0];
            executer_requete_mysql('INSERT INTO '.inst('a_article_commande')." ( Code_commande, Code_article ) VALUES ( $Code_commande, $Code_article );", array_search('a_article_commande', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            if (requete_mysqli_affected_rows() == 0) {
                $code_erreur = 999999;
            } else {
                $cache_db = new Mf_Cachedb("a_article_commande");
                $cache_db->clear();
            }
        }
        return array('code_erreur' => $code_erreur);
    }

    protected function a_article_commande_liste_Code_commande_vers_liste_Code_article(  array $liste_Code_commande, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ($options === null) {
            $options=[];
        }
        $cache_db = new Mf_Cachedb("a_article_commande");
        $cle = "liste_Code_commande_vers_liste_Code_article__".Sql_Format_Liste($liste_Code_commande);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql'])) {
            foreach ($options['cond_mysql'] as &$condition) {
                $argument_cond .= ' AND (' . $condition . ')';
            }
            unset($condition);
        }
        $cle .= '_' . $argument_cond;

        if (false === $liste_Code_article = $cache_db->read($cle)) {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ($argument_cond != '') {
            }
            if (count($liste_colonnes_a_indexer) > 0) {
                if (false === $mf_liste_requete_index = $cache_db->read('a_article_commande__index')) {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('a_article_commande').'`;', false);
                    $mf_liste_requete_index = array();
                    while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('a_article_commande__index', $mf_liste_requete_index);
                }
                foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if (count($liste_colonnes_a_indexer) > 0) {
                    foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                        executer_requete_mysql('ALTER TABLE `'.inst('a_article_commande').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                }
            }

            $liste_Code_article = array();
            $res_requete = executer_requete_mysql('SELECT Code_article FROM '.inst('a_article_commande')." WHERE Code_commande IN ".Sql_Format_Liste($liste_Code_commande).$argument_cond.';', false);
            while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $liste_Code_article[(int) $row_requete['Code_article']] = (int) $row_requete['Code_article'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_article);
        }
        return $liste_Code_article;
    }

    protected function a_article_commande_liste_Code_article_vers_liste_Code_commande(  array $liste_Code_article, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ($options === null) {
            $options=[];
        }
        $cache_db = new Mf_Cachedb("a_article_commande");
        $cle = "liste_Code_article_vers_liste_Code_commande__".Sql_Format_Liste($liste_Code_article);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql'])) {
            foreach ($options['cond_mysql'] as &$condition) {
                $argument_cond .= ' AND (' . $condition . ')';
            }
            unset($condition);
        }
        $cle .= '_' . $argument_cond;

        if (false === $liste_Code_commande = $cache_db->read($cle)) {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ($argument_cond != '') {
            }
            if (count($liste_colonnes_a_indexer) > 0) {
                if (false === $mf_liste_requete_index = $cache_db->read('a_article_commande__index')) {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('a_article_commande').'`;', false);
                    $mf_liste_requete_index = array();
                    while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('a_article_commande__index', $mf_liste_requete_index);
                }
                foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if (count($liste_colonnes_a_indexer) > 0) {
                    foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                        executer_requete_mysql('ALTER TABLE `'.inst('a_article_commande').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                }
            }

            $liste_Code_commande = array();
            $res_requete = executer_requete_mysql('SELECT Code_commande FROM '.inst('a_article_commande')." WHERE Code_article IN ".Sql_Format_Liste($liste_Code_article).$argument_cond.';', false);
            while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $liste_Code_commande[(int) $row_requete['Code_commande']] = (int) $row_requete['Code_commande'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_commande);
        }
        return $liste_Code_commande;
    }

/*
    +--------------------+
    |  a_filtre_produit  |
    +--------------------+
*/

    protected function mf_tester_existance_a_filtre_produit(int $Code_filtre, int $Code_article)
    {
        $Code_filtre = round($Code_filtre);
        $Code_article = round($Code_article);
        $requete_sql = 'SELECT * FROM ' . inst('a_filtre_produit') . " WHERE Code_filtre=$Code_filtre AND Code_article=$Code_article;";
        $cache_db = new Mf_Cachedb('a_filtre_produit');
        if (false === $r = $cache_db->read($requete_sql)) {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) $r = 'o'; else $r = 'n';
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $r);
        }
        return $r=='o';
    }

    private function mf_dupliquer_a_filtre_produit(int $Code_filtre, int $Code_article)
    {
        $code_erreur = 0;
        $Code_filtre = round($Code_filtre);
        $Code_article = round($Code_article);
        if ( !$this->mf_tester_existance_a_filtre_produit( $Code_filtre, $Code_article ) ) $code_erreur = 999999;
        else
        {
            $donnees_a_copier = $this->mf_get($Code_filtre, $Code_article, array('autocompletion' => false));
            $a_filtre_produit_Actif = $donnees_a_copier['a_filtre_produit_Actif'];
            $a_filtre_produit_Actif = round($a_filtre_produit_Actif);
            if ( isset($this->mf_dupliquer_table_de_conversion['Code_filtre'][$Code_filtre]) ) $Code_filtre = $this->mf_dupliquer_table_de_conversion['Code_filtre'][$Code_filtre];
            elseif ( isset($this->mf_dupliquer_table_de_conversion['Code_filtre'][0]) ) $Code_filtre = $this->mf_dupliquer_table_de_conversion['Code_filtre'][0];
            if ( isset($this->mf_dupliquer_table_de_conversion['Code_article'][$Code_article]) ) $Code_article = $this->mf_dupliquer_table_de_conversion['Code_article'][$Code_article];
            elseif ( isset($this->mf_dupliquer_table_de_conversion['Code_article'][0]) ) $Code_article = $this->mf_dupliquer_table_de_conversion['Code_article'][0];
            executer_requete_mysql('INSERT INTO '.inst('a_filtre_produit')." ( a_filtre_produit_Actif, Code_filtre, Code_article ) VALUES ( $a_filtre_produit_Actif, $Code_filtre, $Code_article );", array_search('a_filtre_produit', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            if (requete_mysqli_affected_rows() == 0) {
                $code_erreur = 999999;
            } else {
                $cache_db = new Mf_Cachedb("a_filtre_produit");
                $cache_db->clear();
            }
        }
        return array('code_erreur' => $code_erreur);
    }

    protected function a_filtre_produit_liste_Code_filtre_vers_liste_Code_article(  array $liste_Code_filtre, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ($options === null) {
            $options=[];
        }
        $cache_db = new Mf_Cachedb("a_filtre_produit");
        $cle = "liste_Code_filtre_vers_liste_Code_article__".Sql_Format_Liste($liste_Code_filtre);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql'])) {
            foreach ($options['cond_mysql'] as &$condition) {
                $argument_cond .= ' AND (' . $condition . ')';
            }
            unset($condition);
        }
        $cle .= '_' . $argument_cond;

        if (false === $liste_Code_article = $cache_db->read($cle)) {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ($argument_cond != '') {
                if ( strpos($argument_cond, 'a_filtre_produit_Actif')!==false ) { $liste_colonnes_a_indexer['a_filtre_produit_Actif'] = 'a_filtre_produit_Actif'; }
            }
            if (count($liste_colonnes_a_indexer) > 0) {
                if (false === $mf_liste_requete_index = $cache_db->read('a_filtre_produit__index')) {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('a_filtre_produit').'`;', false);
                    $mf_liste_requete_index = array();
                    while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('a_filtre_produit__index', $mf_liste_requete_index);
                }
                foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if (count($liste_colonnes_a_indexer) > 0) {
                    foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                        executer_requete_mysql('ALTER TABLE `'.inst('a_filtre_produit').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                }
            }

            $liste_Code_article = array();
            $res_requete = executer_requete_mysql('SELECT Code_article FROM '.inst('a_filtre_produit')." WHERE Code_filtre IN ".Sql_Format_Liste($liste_Code_filtre).$argument_cond.';', false);
            while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $liste_Code_article[(int) $row_requete['Code_article']] = (int) $row_requete['Code_article'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_article);
        }
        return $liste_Code_article;
    }

    protected function a_filtre_produit_liste_Code_article_vers_liste_Code_filtre(  array $liste_Code_article, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ($options === null) {
            $options=[];
        }
        $cache_db = new Mf_Cachedb("a_filtre_produit");
        $cle = "liste_Code_article_vers_liste_Code_filtre__".Sql_Format_Liste($liste_Code_article);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql'])) {
            foreach ($options['cond_mysql'] as &$condition) {
                $argument_cond .= ' AND (' . $condition . ')';
            }
            unset($condition);
        }
        $cle .= '_' . $argument_cond;

        if (false === $liste_Code_filtre = $cache_db->read($cle)) {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ($argument_cond != '') {
                if ( strpos($argument_cond, 'a_filtre_produit_Actif')!==false ) { $liste_colonnes_a_indexer['a_filtre_produit_Actif'] = 'a_filtre_produit_Actif'; }
            }
            if (count($liste_colonnes_a_indexer) > 0) {
                if (false === $mf_liste_requete_index = $cache_db->read('a_filtre_produit__index')) {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('a_filtre_produit').'`;', false);
                    $mf_liste_requete_index = array();
                    while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('a_filtre_produit__index', $mf_liste_requete_index);
                }
                foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if (count($liste_colonnes_a_indexer) > 0) {
                    foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                        executer_requete_mysql('ALTER TABLE `'.inst('a_filtre_produit').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                }
            }

            $liste_Code_filtre = array();
            $res_requete = executer_requete_mysql('SELECT Code_filtre FROM '.inst('a_filtre_produit')." WHERE Code_article IN ".Sql_Format_Liste($liste_Code_article).$argument_cond.';', false);
            while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $liste_Code_filtre[(int) $row_requete['Code_filtre']] = (int) $row_requete['Code_filtre'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_filtre);
        }
        return $liste_Code_filtre;
    }

/*
    +---------------------------+
    |  a_parametre_utilisateur  |
    +---------------------------+
*/

    protected function mf_tester_existance_a_parametre_utilisateur(int $Code_utilisateur, int $Code_parametre)
    {
        $Code_utilisateur = round($Code_utilisateur);
        $Code_parametre = round($Code_parametre);
        $requete_sql = 'SELECT * FROM ' . inst('a_parametre_utilisateur') . " WHERE Code_utilisateur=$Code_utilisateur AND Code_parametre=$Code_parametre;";
        $cache_db = new Mf_Cachedb('a_parametre_utilisateur');
        if (false === $r = $cache_db->read($requete_sql)) {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) $r = 'o'; else $r = 'n';
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $r);
        }
        return $r=='o';
    }

    private function mf_dupliquer_a_parametre_utilisateur(int $Code_utilisateur, int $Code_parametre)
    {
        $code_erreur = 0;
        $Code_utilisateur = round($Code_utilisateur);
        $Code_parametre = round($Code_parametre);
        if ( !$this->mf_tester_existance_a_parametre_utilisateur( $Code_utilisateur, $Code_parametre ) ) $code_erreur = 999999;
        else
        {
            $donnees_a_copier = $this->mf_get($Code_utilisateur, $Code_parametre, array('autocompletion' => false));
            $a_parametre_utilisateur_Valeur = $donnees_a_copier['a_parametre_utilisateur_Valeur'];
            $a_parametre_utilisateur_Actif = $donnees_a_copier['a_parametre_utilisateur_Actif'];
            $a_parametre_utilisateur_Valeur = round($a_parametre_utilisateur_Valeur);
            $a_parametre_utilisateur_Actif = round($a_parametre_utilisateur_Actif);
            if ( isset($this->mf_dupliquer_table_de_conversion['Code_utilisateur'][$Code_utilisateur]) ) $Code_utilisateur = $this->mf_dupliquer_table_de_conversion['Code_utilisateur'][$Code_utilisateur];
            elseif ( isset($this->mf_dupliquer_table_de_conversion['Code_utilisateur'][0]) ) $Code_utilisateur = $this->mf_dupliquer_table_de_conversion['Code_utilisateur'][0];
            if ( isset($this->mf_dupliquer_table_de_conversion['Code_parametre'][$Code_parametre]) ) $Code_parametre = $this->mf_dupliquer_table_de_conversion['Code_parametre'][$Code_parametre];
            elseif ( isset($this->mf_dupliquer_table_de_conversion['Code_parametre'][0]) ) $Code_parametre = $this->mf_dupliquer_table_de_conversion['Code_parametre'][0];
            executer_requete_mysql('INSERT INTO '.inst('a_parametre_utilisateur')." ( a_parametre_utilisateur_Valeur, a_parametre_utilisateur_Actif, Code_utilisateur, Code_parametre ) VALUES ( $a_parametre_utilisateur_Valeur, $a_parametre_utilisateur_Actif, $Code_utilisateur, $Code_parametre );", array_search('a_parametre_utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            if (requete_mysqli_affected_rows() == 0) {
                $code_erreur = 999999;
            } else {
                $cache_db = new Mf_Cachedb("a_parametre_utilisateur");
                $cache_db->clear();
            }
        }
        return array('code_erreur' => $code_erreur);
    }

    protected function a_parametre_utilisateur_liste_Code_utilisateur_vers_liste_Code_parametre(  array $liste_Code_utilisateur, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ($options === null) {
            $options=[];
        }
        $cache_db = new Mf_Cachedb("a_parametre_utilisateur");
        $cle = "liste_Code_utilisateur_vers_liste_Code_parametre__".Sql_Format_Liste($liste_Code_utilisateur);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql'])) {
            foreach ($options['cond_mysql'] as &$condition) {
                $argument_cond .= ' AND (' . $condition . ')';
            }
            unset($condition);
        }
        $cle .= '_' . $argument_cond;

        if (false === $liste_Code_parametre = $cache_db->read($cle)) {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ($argument_cond != '') {
                if ( strpos($argument_cond, 'a_parametre_utilisateur_Valeur')!==false ) { $liste_colonnes_a_indexer['a_parametre_utilisateur_Valeur'] = 'a_parametre_utilisateur_Valeur'; }
                if ( strpos($argument_cond, 'a_parametre_utilisateur_Actif')!==false ) { $liste_colonnes_a_indexer['a_parametre_utilisateur_Actif'] = 'a_parametre_utilisateur_Actif'; }
            }
            if (count($liste_colonnes_a_indexer) > 0) {
                if (false === $mf_liste_requete_index = $cache_db->read('a_parametre_utilisateur__index')) {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('a_parametre_utilisateur').'`;', false);
                    $mf_liste_requete_index = array();
                    while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('a_parametre_utilisateur__index', $mf_liste_requete_index);
                }
                foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if (count($liste_colonnes_a_indexer) > 0) {
                    foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                        executer_requete_mysql('ALTER TABLE `'.inst('a_parametre_utilisateur').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                }
            }

            $liste_Code_parametre = array();
            $res_requete = executer_requete_mysql('SELECT Code_parametre FROM '.inst('a_parametre_utilisateur')." WHERE Code_utilisateur IN ".Sql_Format_Liste($liste_Code_utilisateur).$argument_cond.';', false);
            while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $liste_Code_parametre[(int) $row_requete['Code_parametre']] = (int) $row_requete['Code_parametre'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_parametre);
        }
        return $liste_Code_parametre;
    }

    protected function a_parametre_utilisateur_liste_Code_parametre_vers_liste_Code_utilisateur(  array $liste_Code_parametre, ?array $options = null /* $options = [ 'cond_mysql' => array() ] */ )
    {
        if ($options === null) {
            $options=[];
        }
        $cache_db = new Mf_Cachedb("a_parametre_utilisateur");
        $cle = "liste_Code_parametre_vers_liste_Code_utilisateur__".Sql_Format_Liste($liste_Code_parametre);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql'])) {
            foreach ($options['cond_mysql'] as &$condition) {
                $argument_cond .= ' AND (' . $condition . ')';
            }
            unset($condition);
        }
        $cle .= '_' . $argument_cond;

        if (false === $liste_Code_utilisateur = $cache_db->read($cle)) {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ($argument_cond != '') {
                if ( strpos($argument_cond, 'a_parametre_utilisateur_Valeur')!==false ) { $liste_colonnes_a_indexer['a_parametre_utilisateur_Valeur'] = 'a_parametre_utilisateur_Valeur'; }
                if ( strpos($argument_cond, 'a_parametre_utilisateur_Actif')!==false ) { $liste_colonnes_a_indexer['a_parametre_utilisateur_Actif'] = 'a_parametre_utilisateur_Actif'; }
            }
            if (count($liste_colonnes_a_indexer) > 0) {
                if (false === $mf_liste_requete_index = $cache_db->read('a_parametre_utilisateur__index')) {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('a_parametre_utilisateur').'`;', false);
                    $mf_liste_requete_index = array();
                    while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('a_parametre_utilisateur__index', $mf_liste_requete_index);
                }
                foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if (count($liste_colonnes_a_indexer) > 0) {
                    foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                        executer_requete_mysql('ALTER TABLE `'.inst('a_parametre_utilisateur').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                }
            }

            $liste_Code_utilisateur = array();
            $res_requete = executer_requete_mysql('SELECT Code_utilisateur FROM '.inst('a_parametre_utilisateur')." WHERE Code_parametre IN ".Sql_Format_Liste($liste_Code_parametre).$argument_cond.';', false);
            while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $liste_Code_utilisateur[(int) $row_requete['Code_utilisateur']] = (int) $row_requete['Code_utilisateur'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_utilisateur);
        }
        return $liste_Code_utilisateur;
    }

/*
    +-------+
    |  ###  |
    +-------+
*/

    private $mf_dependances = null;
    private $mf_type_table_enfant;

    private function initialisation_dependances()
    {
        $this->mf_dependances=array();
        $this->mf_dependances['type_produit'][]='article';
        $this->mf_dependances['utilisateur'][]='commande';
        $this->mf_dependances['commande'][]='a_article_commande';
        $this->mf_dependances['article'][]='a_article_commande';
        $this->mf_dependances['filtre'][]='a_filtre_produit';
        $this->mf_dependances['article'][]='a_filtre_produit';
        $this->mf_dependances['utilisateur'][]='a_parametre_utilisateur';
        $this->mf_dependances['parametre'][]='a_parametre_utilisateur';

        $this->mf_type_table_enfant=array();
        $this->mf_type_table_enfant['article']='entite';
        $this->mf_type_table_enfant['commande']='entite';
        $this->mf_type_table_enfant['a_article_commande']='association';
        $this->mf_type_table_enfant['a_filtre_produit']='association';
        $this->mf_type_table_enfant['a_parametre_utilisateur']='association';
    }

    protected function get_liste_tables_enfants( string $table )
    {
        $liste_tables_enfants = array();
        if ( isset($this->mf_dependances[$table]) )
        {
            foreach ($this->mf_dependances[$table] as $table_fille)
            {
                $liste_tables_enfants[] = $table_fille;
            }
        }
        return $liste_tables_enfants;
    }

    private function get_liste_tables_parents( string $table )
    {
        $liste_tables_parents = array();
        foreach ( $this->mf_dependances as $table_parent => $tables_enfants )
        {
            foreach ( $tables_enfants as $table_enfant )
            {
                if ( $table==$table_enfant )
                {
                    $liste_tables_parents[$table_parent] = $table_parent;
                }
            }
        }
        return $liste_tables_parents;
    }

    private function test_table_ancetre( string $table_enfant, string $table_ancetre )
    {
        $liste_table=array();
        $liste_table[$table_ancetre]=$table_ancetre;
        do
        {
            $liste_table_2 = array();
            foreach ( $liste_table as $table )
            {
                if ( $table==$table_enfant )
                {
                    return true;
                }
                $liste_table_t = $this->get_liste_tables_enfants($table);
                foreach ( $liste_table_t as $table )
                {
                    $liste_table_2[$table]=$table;
                }
            }
            $liste_table = $liste_table_2;
        } while ( count($liste_table)>0 );
    }

    protected function supprimer_donnes_en_cascade(string $nom_table, array $liste_codes)
    {
        if ($this->mf_dependances == null) {
            $this->initialisation_dependances();
        }
        $liste_tables_enfants = $this->get_liste_tables_enfants($nom_table);
        foreach ($liste_tables_enfants as $table_enfant) {
            if ($this->mf_type_table_enfant[$table_enfant] == 'entite') {
                $liste_codes_enfants=array();
                $res_requete = executer_requete_mysql('SELECT Code_'.$table_enfant . ' FROM ' . inst($table_enfant) . ' WHERE Code_' . $nom_table . ' IN ' . Sql_Format_Liste($liste_codes) . ';', false);
                while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                    $liste_codes_enfants[]=$row_requete['Code_' . $table_enfant];
                }
                mysqli_free_result($res_requete);
                if (count($liste_codes_enfants) > 0) {
                    $this->supprimer_donnes_en_cascade($table_enfant, $liste_codes_enfants);
                    executer_requete_mysql('DELETE IGNORE FROM '.inst($table_enfant).' WHERE Code_'.$table_enfant.' IN '.Sql_Format_Liste($liste_codes_enfants).';', array_search($table_enfant, LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
                    $cache_db = new Mf_Cachedb($table_enfant);
                    $cache_db->clear();
                }
            } else {
                executer_requete_mysql('DELETE IGNORE FROM '.inst($table_enfant).' WHERE Code_'.$nom_table.' IN '.Sql_Format_Liste($liste_codes).';', array_search($table_enfant, LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
                if (requete_mysqli_affected_rows() > 0) {
                    $cache_db = new Mf_Cachedb($table_enfant);
                    $cache_db->clear();
                }
            }
        }
    }

    private $liste_cles_dupliques;

    private function mf_dupliquer_table($libelle_table, $code_table, $liste_Codes_parents)
    {
        $this->mf_dupliquer_table_de_conversion = array();
        $this->mf_dupliquer_tables_a_dupliquer = array();
        $this->liste_cles_dupliques = array();
        foreach ($liste_Codes_parents as $Table)
        {
            $code_table_parent = $Table[0];
            $valeur_code_table_parent = $Table[1];
            $this->mf_dupliquer_table_de_conversion[$code_table_parent][0] = $valeur_code_table_parent;
        }
        $this->mf_dupliquer_tables_a_dupliquer["{$libelle_table}_{$code_table}"] = array($libelle_table, $code_table);

        $this->mf_type_table_enfant[$libelle_table]=='entite';

        while ( count($this->mf_dupliquer_tables_a_dupliquer)>count($this->liste_cles_dupliques) )
        {
            foreach ( $this->mf_dupliquer_tables_a_dupliquer as $cle => $tables_a_dupliquer_passe )
            {
                if ( ! isset($this->liste_cles_dupliques[$cle]) )
                {
                    $libelle_table_a_dupliquer = $tables_a_dupliquer_passe[0];
                    $code_table_a_dupliquer = $tables_a_dupliquer_passe[1];
                    $this->mf_dupliquer_table_($libelle_table_a_dupliquer, $code_table_a_dupliquer);
                    $this->liste_cles_dupliques[$cle]=1;
                }
            }
        }















































        $this->mf_dupliquer_table_($libelle_table, $code_table, $liste_Codes_parents);
        foreach ( $this->tables_a_dupliquer as $table_libelle )
        {
            
            
            
            
            
            
            
            
            $liste_tables_parents = $this->get_liste_tables_parents($table);
            foreach ( $this->tables_a_dupliquer as $table )
            {
                $liste_tables_parents = $this->get_liste_tables_parents($table);
                $integrite_codes_parents = true;
                foreach ( $liste_tables_parents as $table_parent )
                {
                    if ( ! isset($this->mf_dupliquer_table_de_conversion[$table_parent]) )
                    {
                        $integrite_codes_parents = false;
                    }
                }
                if ( $integrite_codes_parents )
                {
                }
            }
        }
    }

    private function mf_dupliquer_table_($libelle_table, $code_table)
    {
        switch ($libelle_table)
        {
            case "utilisateur": $this->mf_dupliquer_utilisateur($code_table); break;
            case "article": $this->mf_dupliquer_article($code_table); break;
            case "commande": $this->mf_dupliquer_commande($code_table); break;
            case "type_produit": $this->mf_dupliquer_type_produit($code_table); break;
            case "parametre": $this->mf_dupliquer_parametre($code_table); break;
            case "filtre": $this->mf_dupliquer_filtre($code_table); break;
        }
    }
}
