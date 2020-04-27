<?php declare(strict_types=1);

/*
    +------------------------------+
    |  NE PAS MODIFIER CE FICHIER  |
    +------------------------------+
*/

include __DIR__ . '/mf_cachedb.php';

class entite_monframework
{

/*
    +---------------+
    |  utilisateur  |
    +---------------+
*/

    protected function mf_tester_existance_Code_utilisateur( int $Code_utilisateur )
    {
        $Code_utilisateur = intval($Code_utilisateur);
        $requete_sql = "SELECT Code_utilisateur FROM " . inst('utilisateur') . " WHERE Code_utilisateur = $Code_utilisateur;";
        $cache_db = new Mf_Cachedb('utilisateur');
        if (false === $r = $cache_db->read($requete_sql)) {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) $r = 'o'; else $r = 'n';
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $r);
        }
        return $r == 'o';
    }

    protected function rechercher_utilisateur_Identifiant(string $utilisateur_Identifiant): int
    {
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

    protected function rechercher_utilisateur_Password(string $utilisateur_Password): int
    {
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

    protected function rechercher_utilisateur_Email(string $utilisateur_Email): int
    {
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

    protected function rechercher_utilisateur_Civilite_Type(int $utilisateur_Civilite_Type): int
    {
        $utilisateur_Civilite_Type = format_sql('utilisateur_Civilite_Type', $utilisateur_Civilite_Type);
        $requete_sql = 'SELECT Code_utilisateur FROM '.inst('utilisateur')." WHERE utilisateur_Civilite_Type = $utilisateur_Civilite_Type LIMIT 0, 1;";
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

    protected function rechercher_utilisateur_Prenom(string $utilisateur_Prenom): int
    {
        $utilisateur_Prenom = format_sql('utilisateur_Prenom', $utilisateur_Prenom);
        $requete_sql = 'SELECT Code_utilisateur FROM '.inst('utilisateur')." WHERE utilisateur_Prenom = $utilisateur_Prenom LIMIT 0, 1;";
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

    protected function rechercher_utilisateur_Nom(string $utilisateur_Nom): int
    {
        $utilisateur_Nom = format_sql('utilisateur_Nom', $utilisateur_Nom);
        $requete_sql = 'SELECT Code_utilisateur FROM '.inst('utilisateur')." WHERE utilisateur_Nom = $utilisateur_Nom LIMIT 0, 1;";
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

    protected function rechercher_utilisateur_Adresse_1(string $utilisateur_Adresse_1): int
    {
        $utilisateur_Adresse_1 = format_sql('utilisateur_Adresse_1', $utilisateur_Adresse_1);
        $requete_sql = 'SELECT Code_utilisateur FROM '.inst('utilisateur')." WHERE utilisateur_Adresse_1 = $utilisateur_Adresse_1 LIMIT 0, 1;";
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

    protected function rechercher_utilisateur_Adresse_2(string $utilisateur_Adresse_2): int
    {
        $utilisateur_Adresse_2 = format_sql('utilisateur_Adresse_2', $utilisateur_Adresse_2);
        $requete_sql = 'SELECT Code_utilisateur FROM '.inst('utilisateur')." WHERE utilisateur_Adresse_2 = $utilisateur_Adresse_2 LIMIT 0, 1;";
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

    protected function rechercher_utilisateur_Ville(string $utilisateur_Ville): int
    {
        $utilisateur_Ville = format_sql('utilisateur_Ville', $utilisateur_Ville);
        $requete_sql = 'SELECT Code_utilisateur FROM '.inst('utilisateur')." WHERE utilisateur_Ville = $utilisateur_Ville LIMIT 0, 1;";
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

    protected function rechercher_utilisateur_Code_postal(string $utilisateur_Code_postal): int
    {
        $utilisateur_Code_postal = format_sql('utilisateur_Code_postal', $utilisateur_Code_postal);
        $requete_sql = 'SELECT Code_utilisateur FROM '.inst('utilisateur')." WHERE utilisateur_Code_postal = $utilisateur_Code_postal LIMIT 0, 1;";
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

    protected function rechercher_utilisateur_Date_naissance(string $utilisateur_Date_naissance): int
    {
        $utilisateur_Date_naissance = format_sql('utilisateur_Date_naissance', $utilisateur_Date_naissance);
        $requete_sql = 'SELECT Code_utilisateur FROM '.inst('utilisateur')." WHERE utilisateur_Date_naissance = $utilisateur_Date_naissance LIMIT 0, 1;";
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

    protected function rechercher_utilisateur_Accepte_mail_publicitaire(bool $utilisateur_Accepte_mail_publicitaire): int
    {
        $utilisateur_Accepte_mail_publicitaire = format_sql('utilisateur_Accepte_mail_publicitaire', $utilisateur_Accepte_mail_publicitaire);
        $requete_sql = 'SELECT Code_utilisateur FROM '.inst('utilisateur')." WHERE utilisateur_Accepte_mail_publicitaire = $utilisateur_Accepte_mail_publicitaire LIMIT 0, 1;";
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

    protected function rechercher_utilisateur_Administrateur(bool $utilisateur_Administrateur): int
    {
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

    protected function rechercher_utilisateur_Fournisseur(bool $utilisateur_Fournisseur): int
    {
        $utilisateur_Fournisseur = format_sql('utilisateur_Fournisseur', $utilisateur_Fournisseur);
        $requete_sql = 'SELECT Code_utilisateur FROM '.inst('utilisateur')." WHERE utilisateur_Fournisseur = $utilisateur_Fournisseur LIMIT 0, 1;";
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

    protected function __get_liste_Code_utilisateur(?array $options = null /* $options = [ 'cond_mysql' => [] ] */)
    {
        return $this->get_liste_Code_utilisateur($options);
    }

    protected function get_liste_Code_utilisateur(?array $options = null /* $options = [ 'cond_mysql' => [] ] */)
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
            if (isset($mf_tri_defaut_table['utilisateur'])) {
                $options['tris'] = $mf_tri_defaut_table['utilisateur'];
            }
        }
        foreach ($options['tris'] as $colonne => $tri) {
            if ($argument_tris == '') { $argument_tris = ' ORDER BY '; } else { $argument_tris .= ', '; }
            if ($tri != 'DESC') $tri = 'ASC';
            $argument_tris .= "$colonne $tri";
        }
        if ($argument_tris == '') {
            $argument_tris = 'ORDER BY Code_utilisateur ASC';
        }
        $cle .= "_$argument_tris";

        // limit
        $argument_limit = '';
        if (isset($options['limit'][0]) && isset($options['limit'][1])) {
            $argument_limit = " LIMIT {$options['limit'][0]}, {$options['limit'][1]}";
        }
        $cle .= "_$argument_limit";

        if (false === $liste = $cache_db->read($cle)) {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ($argument_cond != '') {
                if ( strpos($argument_cond, 'utilisateur_Identifiant')!==false ) { $liste_colonnes_a_indexer['utilisateur_Identifiant'] = 'utilisateur_Identifiant'; }
                if ( strpos($argument_cond, 'utilisateur_Password')!==false ) { $liste_colonnes_a_indexer['utilisateur_Password'] = 'utilisateur_Password'; }
                if ( strpos($argument_cond, 'utilisateur_Email')!==false ) { $liste_colonnes_a_indexer['utilisateur_Email'] = 'utilisateur_Email'; }
                if ( strpos($argument_cond, 'utilisateur_Civilite_Type')!==false ) { $liste_colonnes_a_indexer['utilisateur_Civilite_Type'] = 'utilisateur_Civilite_Type'; }
                if ( strpos($argument_cond, 'utilisateur_Prenom')!==false ) { $liste_colonnes_a_indexer['utilisateur_Prenom'] = 'utilisateur_Prenom'; }
                if ( strpos($argument_cond, 'utilisateur_Nom')!==false ) { $liste_colonnes_a_indexer['utilisateur_Nom'] = 'utilisateur_Nom'; }
                if ( strpos($argument_cond, 'utilisateur_Adresse_1')!==false ) { $liste_colonnes_a_indexer['utilisateur_Adresse_1'] = 'utilisateur_Adresse_1'; }
                if ( strpos($argument_cond, 'utilisateur_Adresse_2')!==false ) { $liste_colonnes_a_indexer['utilisateur_Adresse_2'] = 'utilisateur_Adresse_2'; }
                if ( strpos($argument_cond, 'utilisateur_Ville')!==false ) { $liste_colonnes_a_indexer['utilisateur_Ville'] = 'utilisateur_Ville'; }
                if ( strpos($argument_cond, 'utilisateur_Code_postal')!==false ) { $liste_colonnes_a_indexer['utilisateur_Code_postal'] = 'utilisateur_Code_postal'; }
                if ( strpos($argument_cond, 'utilisateur_Date_naissance')!==false ) { $liste_colonnes_a_indexer['utilisateur_Date_naissance'] = 'utilisateur_Date_naissance'; }
                if ( strpos($argument_cond, 'utilisateur_Accepte_mail_publicitaire')!==false ) { $liste_colonnes_a_indexer['utilisateur_Accepte_mail_publicitaire'] = 'utilisateur_Accepte_mail_publicitaire'; }
                if ( strpos($argument_cond, 'utilisateur_Administrateur')!==false ) { $liste_colonnes_a_indexer['utilisateur_Administrateur'] = 'utilisateur_Administrateur'; }
                if ( strpos($argument_cond, 'utilisateur_Fournisseur')!==false ) { $liste_colonnes_a_indexer['utilisateur_Fournisseur'] = 'utilisateur_Fournisseur'; }
            }
            if (count($liste_colonnes_a_indexer) > 0) {
                if (false === $mf_liste_requete_index = $cache_db->read('utilisateur__index')) {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('utilisateur').'`;', false);
                    $mf_liste_requete_index = [];
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

            $liste = [];
            $table = inst('utilisateur');
            $res_requete = executer_requete_mysql("SELECT Code_utilisateur FROM $table WHERE 1 $argument_cond $argument_tris $argument_limit;", false);
            while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $liste[] = (int) $row_requete['Code_utilisateur'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste);
        }
        return $liste;
    }

/*
    +-----------+
    |  article  |
    +-----------+
*/

    protected function mf_tester_existance_Code_article( int $Code_article )
    {
        $Code_article = intval($Code_article);
        $requete_sql = "SELECT Code_article FROM " . inst('article') . " WHERE Code_article = $Code_article;";
        $cache_db = new Mf_Cachedb('article');
        if (false === $r = $cache_db->read($requete_sql)) {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) $r = 'o'; else $r = 'n';
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $r);
        }
        return $r == 'o';
    }

    protected function rechercher_article_Libelle(string $article_Libelle, ?int $Code_sous_categorie_article = null): int
    {
        $article_Libelle = format_sql('article_Libelle', $article_Libelle);
        $Code_sous_categorie_article = intval($Code_sous_categorie_article);
        $requete_sql = 'SELECT Code_article FROM '.inst('article')." WHERE article_Libelle = $article_Libelle".( $Code_sous_categorie_article!=0 ? " AND Code_sous_categorie_article=$Code_sous_categorie_article" : "" )." LIMIT 0, 1;";
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

    protected function rechercher_article_Saison_Type(int $article_Saison_Type, ?int $Code_sous_categorie_article = null): int
    {
        $article_Saison_Type = format_sql('article_Saison_Type', $article_Saison_Type);
        $Code_sous_categorie_article = intval($Code_sous_categorie_article);
        $requete_sql = 'SELECT Code_article FROM '.inst('article')." WHERE article_Saison_Type = $article_Saison_Type".( $Code_sous_categorie_article!=0 ? " AND Code_sous_categorie_article=$Code_sous_categorie_article" : "" )." LIMIT 0, 1;";
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

    protected function rechercher_article_Nom_fournisseur(string $article_Nom_fournisseur, ?int $Code_sous_categorie_article = null): int
    {
        $article_Nom_fournisseur = format_sql('article_Nom_fournisseur', $article_Nom_fournisseur);
        $Code_sous_categorie_article = intval($Code_sous_categorie_article);
        $requete_sql = 'SELECT Code_article FROM '.inst('article')." WHERE article_Nom_fournisseur = $article_Nom_fournisseur".( $Code_sous_categorie_article!=0 ? " AND Code_sous_categorie_article=$Code_sous_categorie_article" : "" )." LIMIT 0, 1;";
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

    protected function rechercher_article_Url(string $article_Url, ?int $Code_sous_categorie_article = null): int
    {
        $article_Url = format_sql('article_Url', $article_Url);
        $Code_sous_categorie_article = intval($Code_sous_categorie_article);
        $requete_sql = 'SELECT Code_article FROM '.inst('article')." WHERE article_Url = $article_Url".( $Code_sous_categorie_article!=0 ? " AND Code_sous_categorie_article=$Code_sous_categorie_article" : "" )." LIMIT 0, 1;";
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

    protected function rechercher_article_Reference(string $article_Reference, ?int $Code_sous_categorie_article = null): int
    {
        $article_Reference = format_sql('article_Reference', $article_Reference);
        $Code_sous_categorie_article = intval($Code_sous_categorie_article);
        $requete_sql = 'SELECT Code_article FROM '.inst('article')." WHERE article_Reference = $article_Reference".( $Code_sous_categorie_article!=0 ? " AND Code_sous_categorie_article=$Code_sous_categorie_article" : "" )." LIMIT 0, 1;";
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

    protected function rechercher_article_Couleur(string $article_Couleur, ?int $Code_sous_categorie_article = null): int
    {
        $article_Couleur = format_sql('article_Couleur', $article_Couleur);
        $Code_sous_categorie_article = intval($Code_sous_categorie_article);
        $requete_sql = 'SELECT Code_article FROM '.inst('article')." WHERE article_Couleur = $article_Couleur".( $Code_sous_categorie_article!=0 ? " AND Code_sous_categorie_article=$Code_sous_categorie_article" : "" )." LIMIT 0, 1;";
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

    protected function rechercher_article_Code_couleur_svg(string $article_Code_couleur_svg, ?int $Code_sous_categorie_article = null): int
    {
        $article_Code_couleur_svg = format_sql('article_Code_couleur_svg', $article_Code_couleur_svg);
        $Code_sous_categorie_article = intval($Code_sous_categorie_article);
        $requete_sql = 'SELECT Code_article FROM '.inst('article')." WHERE article_Code_couleur_svg = $article_Code_couleur_svg".( $Code_sous_categorie_article!=0 ? " AND Code_sous_categorie_article=$Code_sous_categorie_article" : "" )." LIMIT 0, 1;";
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

    protected function rechercher_article_Taille_Pays_Type(int $article_Taille_Pays_Type, ?int $Code_sous_categorie_article = null): int
    {
        $article_Taille_Pays_Type = format_sql('article_Taille_Pays_Type', $article_Taille_Pays_Type);
        $Code_sous_categorie_article = intval($Code_sous_categorie_article);
        $requete_sql = 'SELECT Code_article FROM '.inst('article')." WHERE article_Taille_Pays_Type = $article_Taille_Pays_Type".( $Code_sous_categorie_article!=0 ? " AND Code_sous_categorie_article=$Code_sous_categorie_article" : "" )." LIMIT 0, 1;";
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

    protected function rechercher_article_Taille(int $article_Taille, ?int $Code_sous_categorie_article = null): int
    {
        $article_Taille = format_sql('article_Taille', $article_Taille);
        $Code_sous_categorie_article = intval($Code_sous_categorie_article);
        $requete_sql = 'SELECT Code_article FROM '.inst('article')." WHERE article_Taille = $article_Taille".( $Code_sous_categorie_article!=0 ? " AND Code_sous_categorie_article=$Code_sous_categorie_article" : "" )." LIMIT 0, 1;";
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

    protected function rechercher_article_Matiere(string $article_Matiere, ?int $Code_sous_categorie_article = null): int
    {
        $article_Matiere = format_sql('article_Matiere', $article_Matiere);
        $Code_sous_categorie_article = intval($Code_sous_categorie_article);
        $requete_sql = 'SELECT Code_article FROM '.inst('article')." WHERE article_Matiere = $article_Matiere".( $Code_sous_categorie_article!=0 ? " AND Code_sous_categorie_article=$Code_sous_categorie_article" : "" )." LIMIT 0, 1;";
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

    protected function rechercher_article_Photo_Fichier(string $article_Photo_Fichier, ?int $Code_sous_categorie_article = null): int
    {
        $article_Photo_Fichier = format_sql('article_Photo_Fichier', $article_Photo_Fichier);
        $Code_sous_categorie_article = intval($Code_sous_categorie_article);
        $requete_sql = 'SELECT Code_article FROM '.inst('article')." WHERE article_Photo_Fichier = $article_Photo_Fichier".( $Code_sous_categorie_article!=0 ? " AND Code_sous_categorie_article=$Code_sous_categorie_article" : "" )." LIMIT 0, 1;";
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

    protected function rechercher_article_Prix(float $article_Prix, ?int $Code_sous_categorie_article = null): int
    {
        $article_Prix = format_sql('article_Prix', $article_Prix);
        $Code_sous_categorie_article = intval($Code_sous_categorie_article);
        $requete_sql = 'SELECT Code_article FROM '.inst('article')." WHERE article_Prix = $article_Prix".( $Code_sous_categorie_article!=0 ? " AND Code_sous_categorie_article=$Code_sous_categorie_article" : "" )." LIMIT 0, 1;";
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

    protected function rechercher_article_Actif(bool $article_Actif, ?int $Code_sous_categorie_article = null): int
    {
        $article_Actif = format_sql('article_Actif', $article_Actif);
        $Code_sous_categorie_article = intval($Code_sous_categorie_article);
        $requete_sql = 'SELECT Code_article FROM '.inst('article')." WHERE article_Actif = $article_Actif".( $Code_sous_categorie_article!=0 ? " AND Code_sous_categorie_article=$Code_sous_categorie_article" : "" )." LIMIT 0, 1;";
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

    protected function rechercher_article__Code_sous_categorie_article(int $Code_sous_categorie_article): int
    {
        $requete_sql = 'SELECT Code_article FROM '.inst('article')." WHERE Code_sous_categorie_article = $Code_sous_categorie_article LIMIT 0, 1;";
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

    protected function __get_liste_Code_article(?array $options = null /* $options = [ 'cond_mysql' => [] ] */)
    {
        return $this->get_liste_Code_article(null, $options);
    }

    protected function get_liste_Code_article(?int $Code_sous_categorie_article = null, ?array $options = null /* $options = [ 'cond_mysql' => [] ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cache_db = new Mf_Cachedb('article');
        $cle = "article__lister_cles";
        $Code_sous_categorie_article = intval($Code_sous_categorie_article);
        $cle .= "_{$Code_sous_categorie_article}";

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
            if (isset($mf_tri_defaut_table['article'])) {
                $options['tris'] = $mf_tri_defaut_table['article'];
            }
        }
        foreach ($options['tris'] as $colonne => $tri) {
            if ($argument_tris == '') { $argument_tris = ' ORDER BY '; } else { $argument_tris .= ', '; }
            if ($tri != 'DESC') $tri = 'ASC';
            $argument_tris .= "$colonne $tri";
        }
        if ($argument_tris == '') {
            $argument_tris = 'ORDER BY Code_article ASC';
        }
        $cle .= "_$argument_tris";

        // limit
        $argument_limit = '';
        if (isset($options['limit'][0]) && isset($options['limit'][1])) {
            $argument_limit = " LIMIT {$options['limit'][0]}, {$options['limit'][1]}";
        }
        $cle .= "_$argument_limit";

        if (false === $liste = $cache_db->read($cle)) {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ($argument_cond != '') {
                if ( strpos($argument_cond, 'article_Libelle')!==false ) { $liste_colonnes_a_indexer['article_Libelle'] = 'article_Libelle'; }
                if ( strpos($argument_cond, 'article_Saison_Type')!==false ) { $liste_colonnes_a_indexer['article_Saison_Type'] = 'article_Saison_Type'; }
                if ( strpos($argument_cond, 'article_Nom_fournisseur')!==false ) { $liste_colonnes_a_indexer['article_Nom_fournisseur'] = 'article_Nom_fournisseur'; }
                if ( strpos($argument_cond, 'article_Url')!==false ) { $liste_colonnes_a_indexer['article_Url'] = 'article_Url'; }
                if ( strpos($argument_cond, 'article_Reference')!==false ) { $liste_colonnes_a_indexer['article_Reference'] = 'article_Reference'; }
                if ( strpos($argument_cond, 'article_Couleur')!==false ) { $liste_colonnes_a_indexer['article_Couleur'] = 'article_Couleur'; }
                if ( strpos($argument_cond, 'article_Code_couleur_svg')!==false ) { $liste_colonnes_a_indexer['article_Code_couleur_svg'] = 'article_Code_couleur_svg'; }
                if ( strpos($argument_cond, 'article_Taille_Pays_Type')!==false ) { $liste_colonnes_a_indexer['article_Taille_Pays_Type'] = 'article_Taille_Pays_Type'; }
                if ( strpos($argument_cond, 'article_Taille')!==false ) { $liste_colonnes_a_indexer['article_Taille'] = 'article_Taille'; }
                if ( strpos($argument_cond, 'article_Matiere')!==false ) { $liste_colonnes_a_indexer['article_Matiere'] = 'article_Matiere'; }
                if ( strpos($argument_cond, 'article_Photo_Fichier')!==false ) { $liste_colonnes_a_indexer['article_Photo_Fichier'] = 'article_Photo_Fichier'; }
                if ( strpos($argument_cond, 'article_Prix')!==false ) { $liste_colonnes_a_indexer['article_Prix'] = 'article_Prix'; }
                if ( strpos($argument_cond, 'article_Actif')!==false ) { $liste_colonnes_a_indexer['article_Actif'] = 'article_Actif'; }
            }
            if (count($liste_colonnes_a_indexer) > 0) {
                if (false === $mf_liste_requete_index = $cache_db->read('article__index')) {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('article').'`;', false);
                    $mf_liste_requete_index = [];
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

            $liste = [];
            $table = inst('article');
            $res_requete = executer_requete_mysql("SELECT Code_article FROM $table WHERE 1 ".( $Code_sous_categorie_article!=0 ? " AND Code_sous_categorie_article=$Code_sous_categorie_article" : "" )."$argument_cond $argument_tris $argument_limit;", false);
            while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $liste[] = (int) $row_requete['Code_article'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste);
        }
        return $liste;
    }

    /**
     * @param int $Code_article
     * @return int $Code_sous_categorie_article
     */
    protected function Code_article_vers_Code_sous_categorie_article(int $Code_article): int
    {
        global $mf_cache_volatil;
        if ($Code_article < 0) $Code_article = 0;
        if (isset($mf_cache_volatil->variables['article']['Code_article_vers_Code_sous_categorie_article'][$Code_article])) {
            return $mf_cache_volatil->variables['article']['Code_article_vers_Code_sous_categorie_article'][$Code_article];
        }
        // Initialisation de la valeur de retour à 0
        $mf_cache_volatil->variables['article']['Code_article_vers_Code_sous_categorie_article'][$Code_article] = 0;
        $p = floor($Code_article/100);
        $start = $p * 100;
        $end = ($p + 1) * 100;
        $cache_db = new Mf_Cachedb('article');
        $cle = 'Code_article_vers_Code_sous_categorie_article__'.$start.'__'.$end;
        if (false === $conversion = $cache_db->read($cle)) {
            $res_requete = executer_requete_mysql('SELECT Code_article, Code_sous_categorie_article FROM '.inst('article').' WHERE '.$start.' <= Code_article AND Code_article < '.$end.';', false);
            $conversion = [];
            while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $conversion[(int) $row_requete['Code_article']] = (int) $row_requete['Code_sous_categorie_article'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $conversion, false);
        }
        foreach ($conversion as $k => $v) {
            $mf_cache_volatil->variables['article']['Code_article_vers_Code_sous_categorie_article'][$k] = $v;
        }
        return $mf_cache_volatil->variables['article']['Code_article_vers_Code_sous_categorie_article'][$Code_article];
    }

    protected function liste_Code_sous_categorie_article_vers_liste_Code_article( array $liste_Code_sous_categorie_article, ?array $options = null /* $options = [ 'cond_mysql' => [] ] */ )
    {
        if ($options === null) {
            $options = [];
        }
        $cache_db = new Mf_Cachedb('article');
        $cle = 'liste_Code_sous_categorie_article_vers_liste_Code_article__' . Sql_Format_Liste($liste_Code_sous_categorie_article);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql'])) {
            foreach ($options['cond_mysql'] as &$condition) {
                $argument_cond .= " AND ($condition)";
            }
            unset($condition);
        }
        $cle .= "_$argument_cond";

        if (false === $liste_Code_article = $cache_db->read($cle)) {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ($argument_cond != '') {
                if ( strpos($argument_cond, 'article_Libelle')!==false ) { $liste_colonnes_a_indexer['article_Libelle'] = 'article_Libelle'; }
                if ( strpos($argument_cond, 'article_Saison_Type')!==false ) { $liste_colonnes_a_indexer['article_Saison_Type'] = 'article_Saison_Type'; }
                if ( strpos($argument_cond, 'article_Nom_fournisseur')!==false ) { $liste_colonnes_a_indexer['article_Nom_fournisseur'] = 'article_Nom_fournisseur'; }
                if ( strpos($argument_cond, 'article_Url')!==false ) { $liste_colonnes_a_indexer['article_Url'] = 'article_Url'; }
                if ( strpos($argument_cond, 'article_Reference')!==false ) { $liste_colonnes_a_indexer['article_Reference'] = 'article_Reference'; }
                if ( strpos($argument_cond, 'article_Couleur')!==false ) { $liste_colonnes_a_indexer['article_Couleur'] = 'article_Couleur'; }
                if ( strpos($argument_cond, 'article_Code_couleur_svg')!==false ) { $liste_colonnes_a_indexer['article_Code_couleur_svg'] = 'article_Code_couleur_svg'; }
                if ( strpos($argument_cond, 'article_Taille_Pays_Type')!==false ) { $liste_colonnes_a_indexer['article_Taille_Pays_Type'] = 'article_Taille_Pays_Type'; }
                if ( strpos($argument_cond, 'article_Taille')!==false ) { $liste_colonnes_a_indexer['article_Taille'] = 'article_Taille'; }
                if ( strpos($argument_cond, 'article_Matiere')!==false ) { $liste_colonnes_a_indexer['article_Matiere'] = 'article_Matiere'; }
                if ( strpos($argument_cond, 'article_Photo_Fichier')!==false ) { $liste_colonnes_a_indexer['article_Photo_Fichier'] = 'article_Photo_Fichier'; }
                if ( strpos($argument_cond, 'article_Prix')!==false ) { $liste_colonnes_a_indexer['article_Prix'] = 'article_Prix'; }
                if ( strpos($argument_cond, 'article_Actif')!==false ) { $liste_colonnes_a_indexer['article_Actif'] = 'article_Actif'; }
            }
            if (count($liste_colonnes_a_indexer) > 0) {
                if (false === $mf_liste_requete_index = $cache_db->read('article__index')) {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('article').'`;', false);
                    $mf_liste_requete_index = [];
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

            $liste_Code_article = [];
            $res_requete = executer_requete_mysql('SELECT Code_article FROM '.inst('article')." WHERE Code_sous_categorie_article IN ".Sql_Format_Liste($liste_Code_sous_categorie_article).$argument_cond.";", false);
            while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $liste_Code_article[] = (int) $row_requete['Code_article'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_article);
        }
        return $liste_Code_article;
    }

    protected function article__liste_Code_article_vers_liste_Code_sous_categorie_article( array $liste_Code_article, ?array $options = null /* $options = [ 'cond_mysql' => [] ] */ )
    {
        if ($options === null) {
            $options=[];
        }
        $cache_db = new Mf_Cachedb("article");
        $cle = "liste_Code_article_vers_liste_Code_sous_categorie_article__".Sql_Format_Liste($liste_Code_article);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql'])) {
            foreach ($options['cond_mysql'] as &$condition) {
                $argument_cond .= " AND ($condition)";
            }
            unset($condition);
        }
        $cle .= "_$argument_cond";

        if (false === $liste_Code_sous_categorie_article = $cache_db->read($cle)) {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ($argument_cond != '') {
                if ( strpos($argument_cond, 'article_Libelle')!==false ) { $liste_colonnes_a_indexer['article_Libelle'] = 'article_Libelle'; }
                if ( strpos($argument_cond, 'article_Saison_Type')!==false ) { $liste_colonnes_a_indexer['article_Saison_Type'] = 'article_Saison_Type'; }
                if ( strpos($argument_cond, 'article_Nom_fournisseur')!==false ) { $liste_colonnes_a_indexer['article_Nom_fournisseur'] = 'article_Nom_fournisseur'; }
                if ( strpos($argument_cond, 'article_Url')!==false ) { $liste_colonnes_a_indexer['article_Url'] = 'article_Url'; }
                if ( strpos($argument_cond, 'article_Reference')!==false ) { $liste_colonnes_a_indexer['article_Reference'] = 'article_Reference'; }
                if ( strpos($argument_cond, 'article_Couleur')!==false ) { $liste_colonnes_a_indexer['article_Couleur'] = 'article_Couleur'; }
                if ( strpos($argument_cond, 'article_Code_couleur_svg')!==false ) { $liste_colonnes_a_indexer['article_Code_couleur_svg'] = 'article_Code_couleur_svg'; }
                if ( strpos($argument_cond, 'article_Taille_Pays_Type')!==false ) { $liste_colonnes_a_indexer['article_Taille_Pays_Type'] = 'article_Taille_Pays_Type'; }
                if ( strpos($argument_cond, 'article_Taille')!==false ) { $liste_colonnes_a_indexer['article_Taille'] = 'article_Taille'; }
                if ( strpos($argument_cond, 'article_Matiere')!==false ) { $liste_colonnes_a_indexer['article_Matiere'] = 'article_Matiere'; }
                if ( strpos($argument_cond, 'article_Photo_Fichier')!==false ) { $liste_colonnes_a_indexer['article_Photo_Fichier'] = 'article_Photo_Fichier'; }
                if ( strpos($argument_cond, 'article_Prix')!==false ) { $liste_colonnes_a_indexer['article_Prix'] = 'article_Prix'; }
                if ( strpos($argument_cond, 'article_Actif')!==false ) { $liste_colonnes_a_indexer['article_Actif'] = 'article_Actif'; }
            }
            if (count($liste_colonnes_a_indexer) > 0) {
                if (false === $mf_liste_requete_index = $cache_db->read('article__index')) {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('article').'`;', false);
                    $mf_liste_requete_index = [];
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

            $controle_doublons = [];
            $liste_Code_sous_categorie_article = [];
            $res_requete = executer_requete_mysql("SELECT Code_sous_categorie_article FROM " . inst('article') . " WHERE Code_article IN " . Sql_Format_Liste($liste_Code_article) . $argument_cond . ";", false);
            while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                if (! isset($controle_doublons[(int) $row_requete['Code_sous_categorie_article']])) {
                    $controle_doublons[(int) $row_requete['Code_sous_categorie_article']] = 1;
                    $liste_Code_sous_categorie_article[] = (int) $row_requete['Code_sous_categorie_article'];
                }
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_sous_categorie_article);
        }
        return $liste_Code_sous_categorie_article;
    }

/*
    +------------+
    |  commande  |
    +------------+
*/

    protected function mf_tester_existance_Code_commande( int $Code_commande )
    {
        $Code_commande = intval($Code_commande);
        $requete_sql = "SELECT Code_commande FROM " . inst('commande') . " WHERE Code_commande = $Code_commande;";
        $cache_db = new Mf_Cachedb('commande');
        if (false === $r = $cache_db->read($requete_sql)) {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) $r = 'o'; else $r = 'n';
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $r);
        }
        return $r == 'o';
    }

    protected function rechercher_commande_Prix_total(float $commande_Prix_total, ?int $Code_utilisateur = null): int
    {
        $commande_Prix_total = format_sql('commande_Prix_total', $commande_Prix_total);
        $Code_utilisateur = intval($Code_utilisateur);
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

    protected function rechercher_commande_Date_livraison(string $commande_Date_livraison, ?int $Code_utilisateur = null): int
    {
        $commande_Date_livraison = format_sql('commande_Date_livraison', $commande_Date_livraison);
        $Code_utilisateur = intval($Code_utilisateur);
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

    protected function rechercher_commande_Date_creation(string $commande_Date_creation, ?int $Code_utilisateur = null): int
    {
        $commande_Date_creation = format_sql('commande_Date_creation', $commande_Date_creation);
        $Code_utilisateur = intval($Code_utilisateur);
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

    protected function rechercher_commande__Code_utilisateur(int $Code_utilisateur): int
    {
        $requete_sql = 'SELECT Code_commande FROM '.inst('commande')." WHERE Code_utilisateur = $Code_utilisateur LIMIT 0, 1;";
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

    protected function __get_liste_Code_commande(?array $options = null /* $options = [ 'cond_mysql' => [] ] */)
    {
        return $this->get_liste_Code_commande(null, $options);
    }

    protected function get_liste_Code_commande(?int $Code_utilisateur = null, ?array $options = null /* $options = [ 'cond_mysql' => [] ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cache_db = new Mf_Cachedb('commande');
        $cle = "commande__lister_cles";
        $Code_utilisateur = intval($Code_utilisateur);
        $cle .= "_{$Code_utilisateur}";

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
            if (isset($mf_tri_defaut_table['commande'])) {
                $options['tris'] = $mf_tri_defaut_table['commande'];
            }
        }
        foreach ($options['tris'] as $colonne => $tri) {
            if ($argument_tris == '') { $argument_tris = ' ORDER BY '; } else { $argument_tris .= ', '; }
            if ($tri != 'DESC') $tri = 'ASC';
            $argument_tris .= "$colonne $tri";
        }
        if ($argument_tris == '') {
            $argument_tris = 'ORDER BY Code_commande ASC';
        }
        $cle .= "_$argument_tris";

        // limit
        $argument_limit = '';
        if (isset($options['limit'][0]) && isset($options['limit'][1])) {
            $argument_limit = " LIMIT {$options['limit'][0]}, {$options['limit'][1]}";
        }
        $cle .= "_$argument_limit";

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
                    $mf_liste_requete_index = [];
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

            $liste = [];
            $table = inst('commande');
            $res_requete = executer_requete_mysql("SELECT Code_commande FROM $table WHERE 1 ".( $Code_utilisateur!=0 ? " AND Code_utilisateur=$Code_utilisateur" : "" )."$argument_cond $argument_tris $argument_limit;", false);
            while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $liste[] = (int) $row_requete['Code_commande'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste);
        }
        return $liste;
    }

    /**
     * @param int $Code_commande
     * @return int $Code_utilisateur
     */
    protected function Code_commande_vers_Code_utilisateur(int $Code_commande): int
    {
        global $mf_cache_volatil;
        if ($Code_commande < 0) $Code_commande = 0;
        if (isset($mf_cache_volatil->variables['commande']['Code_commande_vers_Code_utilisateur'][$Code_commande])) {
            return $mf_cache_volatil->variables['commande']['Code_commande_vers_Code_utilisateur'][$Code_commande];
        }
        // Initialisation de la valeur de retour à 0
        $mf_cache_volatil->variables['commande']['Code_commande_vers_Code_utilisateur'][$Code_commande] = 0;
        $p = floor($Code_commande/100);
        $start = $p * 100;
        $end = ($p + 1) * 100;
        $cache_db = new Mf_Cachedb('commande');
        $cle = 'Code_commande_vers_Code_utilisateur__'.$start.'__'.$end;
        if (false === $conversion = $cache_db->read($cle)) {
            $res_requete = executer_requete_mysql('SELECT Code_commande, Code_utilisateur FROM '.inst('commande').' WHERE '.$start.' <= Code_commande AND Code_commande < '.$end.';', false);
            $conversion = [];
            while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $conversion[(int) $row_requete['Code_commande']] = (int) $row_requete['Code_utilisateur'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $conversion, false);
        }
        foreach ($conversion as $k => $v) {
            $mf_cache_volatil->variables['commande']['Code_commande_vers_Code_utilisateur'][$k] = $v;
        }
        return $mf_cache_volatil->variables['commande']['Code_commande_vers_Code_utilisateur'][$Code_commande];
    }

    protected function liste_Code_utilisateur_vers_liste_Code_commande( array $liste_Code_utilisateur, ?array $options = null /* $options = [ 'cond_mysql' => [] ] */ )
    {
        if ($options === null) {
            $options = [];
        }
        $cache_db = new Mf_Cachedb('commande');
        $cle = 'liste_Code_utilisateur_vers_liste_Code_commande__' . Sql_Format_Liste($liste_Code_utilisateur);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql'])) {
            foreach ($options['cond_mysql'] as &$condition) {
                $argument_cond .= " AND ($condition)";
            }
            unset($condition);
        }
        $cle .= "_$argument_cond";

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
                    $mf_liste_requete_index = [];
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

            $liste_Code_commande = [];
            $res_requete = executer_requete_mysql('SELECT Code_commande FROM '.inst('commande')." WHERE Code_utilisateur IN ".Sql_Format_Liste($liste_Code_utilisateur).$argument_cond.";", false);
            while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $liste_Code_commande[] = (int) $row_requete['Code_commande'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_commande);
        }
        return $liste_Code_commande;
    }

    protected function commande__liste_Code_commande_vers_liste_Code_utilisateur( array $liste_Code_commande, ?array $options = null /* $options = [ 'cond_mysql' => [] ] */ )
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
                $argument_cond .= " AND ($condition)";
            }
            unset($condition);
        }
        $cle .= "_$argument_cond";

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
                    $mf_liste_requete_index = [];
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

            $controle_doublons = [];
            $liste_Code_utilisateur = [];
            $res_requete = executer_requete_mysql("SELECT Code_utilisateur FROM " . inst('commande') . " WHERE Code_commande IN " . Sql_Format_Liste($liste_Code_commande) . $argument_cond . ";", false);
            while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                if (! isset($controle_doublons[(int) $row_requete['Code_utilisateur']])) {
                    $controle_doublons[(int) $row_requete['Code_utilisateur']] = 1;
                    $liste_Code_utilisateur[] = (int) $row_requete['Code_utilisateur'];
                }
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_utilisateur);
        }
        return $liste_Code_utilisateur;
    }

/*
    +---------------------+
    |  categorie_article  |
    +---------------------+
*/

    protected function mf_tester_existance_Code_categorie_article( int $Code_categorie_article )
    {
        $Code_categorie_article = intval($Code_categorie_article);
        $requete_sql = "SELECT Code_categorie_article FROM " . inst('categorie_article') . " WHERE Code_categorie_article = $Code_categorie_article;";
        $cache_db = new Mf_Cachedb('categorie_article');
        if (false === $r = $cache_db->read($requete_sql)) {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) $r = 'o'; else $r = 'n';
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $r);
        }
        return $r == 'o';
    }

    protected function rechercher_categorie_article_Libelle(string $categorie_article_Libelle): int
    {
        $categorie_article_Libelle = format_sql('categorie_article_Libelle', $categorie_article_Libelle);
        $requete_sql = 'SELECT Code_categorie_article FROM '.inst('categorie_article')." WHERE categorie_article_Libelle = $categorie_article_Libelle LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('categorie_article');
        if (false === $Code_categorie_article = $cache_db->read($requete_sql)) {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $Code_categorie_article = (int) $row_requete['Code_categorie_article'];
            } else {
                $Code_categorie_article = 0;
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_categorie_article);
        }
        return $Code_categorie_article;
    }

    protected function __get_liste_Code_categorie_article(?array $options = null /* $options = [ 'cond_mysql' => [] ] */)
    {
        return $this->get_liste_Code_categorie_article($options);
    }

    protected function get_liste_Code_categorie_article(?array $options = null /* $options = [ 'cond_mysql' => [] ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cache_db = new Mf_Cachedb('categorie_article');
        $cle = "categorie_article__lister_cles";

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
            if ($argument_tris == '') { $argument_tris = ' ORDER BY '; } else { $argument_tris .= ', '; }
            if ($tri != 'DESC') $tri = 'ASC';
            $argument_tris .= "$colonne $tri";
        }
        if ($argument_tris == '') {
            $argument_tris = 'ORDER BY Code_categorie_article ASC';
        }
        $cle .= "_$argument_tris";

        // limit
        $argument_limit = '';
        if (isset($options['limit'][0]) && isset($options['limit'][1])) {
            $argument_limit = " LIMIT {$options['limit'][0]}, {$options['limit'][1]}";
        }
        $cle .= "_$argument_limit";

        if (false === $liste = $cache_db->read($cle)) {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ($argument_cond != '') {
                if ( strpos($argument_cond, 'categorie_article_Libelle')!==false ) { $liste_colonnes_a_indexer['categorie_article_Libelle'] = 'categorie_article_Libelle'; }
            }
            if (count($liste_colonnes_a_indexer) > 0) {
                if (false === $mf_liste_requete_index = $cache_db->read('categorie_article__index')) {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('categorie_article').'`;', false);
                    $mf_liste_requete_index = [];
                    while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('categorie_article__index', $mf_liste_requete_index);
                }
                foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if (count($liste_colonnes_a_indexer) > 0) {
                    foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                        executer_requete_mysql('ALTER TABLE `'.inst('categorie_article').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                }
            }

            $liste = [];
            $table = inst('categorie_article');
            $res_requete = executer_requete_mysql("SELECT Code_categorie_article FROM $table WHERE 1 $argument_cond $argument_tris $argument_limit;", false);
            while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $liste[] = (int) $row_requete['Code_categorie_article'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste);
        }
        return $liste;
    }

/*
    +-------------+
    |  parametre  |
    +-------------+
*/

    protected function mf_tester_existance_Code_parametre( int $Code_parametre )
    {
        $Code_parametre = intval($Code_parametre);
        $requete_sql = "SELECT Code_parametre FROM " . inst('parametre') . " WHERE Code_parametre = $Code_parametre;";
        $cache_db = new Mf_Cachedb('parametre');
        if (false === $r = $cache_db->read($requete_sql)) {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) $r = 'o'; else $r = 'n';
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $r);
        }
        return $r == 'o';
    }

    protected function rechercher_parametre_Libelle(string $parametre_Libelle): int
    {
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

    protected function __get_liste_Code_parametre(?array $options = null /* $options = [ 'cond_mysql' => [] ] */)
    {
        return $this->get_liste_Code_parametre($options);
    }

    protected function get_liste_Code_parametre(?array $options = null /* $options = [ 'cond_mysql' => [] ] */)
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
            if (isset($mf_tri_defaut_table['parametre'])) {
                $options['tris'] = $mf_tri_defaut_table['parametre'];
            }
        }
        foreach ($options['tris'] as $colonne => $tri) {
            if ($argument_tris == '') { $argument_tris = ' ORDER BY '; } else { $argument_tris .= ', '; }
            if ($tri != 'DESC') $tri = 'ASC';
            $argument_tris .= "$colonne $tri";
        }
        if ($argument_tris == '') {
            $argument_tris = 'ORDER BY Code_parametre ASC';
        }
        $cle .= "_$argument_tris";

        // limit
        $argument_limit = '';
        if (isset($options['limit'][0]) && isset($options['limit'][1])) {
            $argument_limit = " LIMIT {$options['limit'][0]}, {$options['limit'][1]}";
        }
        $cle .= "_$argument_limit";

        if (false === $liste = $cache_db->read($cle)) {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ($argument_cond != '') {
                if ( strpos($argument_cond, 'parametre_Libelle')!==false ) { $liste_colonnes_a_indexer['parametre_Libelle'] = 'parametre_Libelle'; }
            }
            if (count($liste_colonnes_a_indexer) > 0) {
                if (false === $mf_liste_requete_index = $cache_db->read('parametre__index')) {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('parametre').'`;', false);
                    $mf_liste_requete_index = [];
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

            $liste = [];
            $table = inst('parametre');
            $res_requete = executer_requete_mysql("SELECT Code_parametre FROM $table WHERE 1 $argument_cond $argument_tris $argument_limit;", false);
            while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $liste[] = (int) $row_requete['Code_parametre'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste);
        }
        return $liste;
    }

/*
    +-------------------+
    |  vue_utilisateur  |
    +-------------------+
*/

    protected function mf_tester_existance_Code_vue_utilisateur( int $Code_vue_utilisateur )
    {
        $Code_vue_utilisateur = intval($Code_vue_utilisateur);
        $requete_sql = "SELECT Code_vue_utilisateur FROM " . inst('vue_utilisateur') . " WHERE Code_vue_utilisateur = $Code_vue_utilisateur;";
        $cache_db = new Mf_Cachedb('vue_utilisateur');
        if (false === $r = $cache_db->read($requete_sql)) {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) $r = 'o'; else $r = 'n';
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $r);
        }
        return $r == 'o';
    }

    protected function rechercher_vue_utilisateur_Recherche(string $vue_utilisateur_Recherche): int
    {
        $vue_utilisateur_Recherche = format_sql('vue_utilisateur_Recherche', $vue_utilisateur_Recherche);
        $requete_sql = 'SELECT Code_vue_utilisateur FROM '.inst('vue_utilisateur')." WHERE vue_utilisateur_Recherche = $vue_utilisateur_Recherche LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('vue_utilisateur');
        if (false === $Code_vue_utilisateur = $cache_db->read($requete_sql)) {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $Code_vue_utilisateur = (int) $row_requete['Code_vue_utilisateur'];
            } else {
                $Code_vue_utilisateur = 0;
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_vue_utilisateur);
        }
        return $Code_vue_utilisateur;
    }

    protected function rechercher_vue_utilisateur_Filtre_Saison_Type(int $vue_utilisateur_Filtre_Saison_Type): int
    {
        $vue_utilisateur_Filtre_Saison_Type = format_sql('vue_utilisateur_Filtre_Saison_Type', $vue_utilisateur_Filtre_Saison_Type);
        $requete_sql = 'SELECT Code_vue_utilisateur FROM '.inst('vue_utilisateur')." WHERE vue_utilisateur_Filtre_Saison_Type = $vue_utilisateur_Filtre_Saison_Type LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('vue_utilisateur');
        if (false === $Code_vue_utilisateur = $cache_db->read($requete_sql)) {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $Code_vue_utilisateur = (int) $row_requete['Code_vue_utilisateur'];
            } else {
                $Code_vue_utilisateur = 0;
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_vue_utilisateur);
        }
        return $Code_vue_utilisateur;
    }

    protected function rechercher_vue_utilisateur_Filtre_Couleur(string $vue_utilisateur_Filtre_Couleur): int
    {
        $vue_utilisateur_Filtre_Couleur = format_sql('vue_utilisateur_Filtre_Couleur', $vue_utilisateur_Filtre_Couleur);
        $requete_sql = 'SELECT Code_vue_utilisateur FROM '.inst('vue_utilisateur')." WHERE vue_utilisateur_Filtre_Couleur = $vue_utilisateur_Filtre_Couleur LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('vue_utilisateur');
        if (false === $Code_vue_utilisateur = $cache_db->read($requete_sql)) {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $Code_vue_utilisateur = (int) $row_requete['Code_vue_utilisateur'];
            } else {
                $Code_vue_utilisateur = 0;
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_vue_utilisateur);
        }
        return $Code_vue_utilisateur;
    }

    protected function rechercher_vue_utilisateur_Filtre_Taille_Pays_Type(int $vue_utilisateur_Filtre_Taille_Pays_Type): int
    {
        $vue_utilisateur_Filtre_Taille_Pays_Type = format_sql('vue_utilisateur_Filtre_Taille_Pays_Type', $vue_utilisateur_Filtre_Taille_Pays_Type);
        $requete_sql = 'SELECT Code_vue_utilisateur FROM '.inst('vue_utilisateur')." WHERE vue_utilisateur_Filtre_Taille_Pays_Type = $vue_utilisateur_Filtre_Taille_Pays_Type LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('vue_utilisateur');
        if (false === $Code_vue_utilisateur = $cache_db->read($requete_sql)) {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $Code_vue_utilisateur = (int) $row_requete['Code_vue_utilisateur'];
            } else {
                $Code_vue_utilisateur = 0;
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_vue_utilisateur);
        }
        return $Code_vue_utilisateur;
    }

    protected function rechercher_vue_utilisateur_Filtre_Taille_Max(int $vue_utilisateur_Filtre_Taille_Max): int
    {
        $vue_utilisateur_Filtre_Taille_Max = format_sql('vue_utilisateur_Filtre_Taille_Max', $vue_utilisateur_Filtre_Taille_Max);
        $requete_sql = 'SELECT Code_vue_utilisateur FROM '.inst('vue_utilisateur')." WHERE vue_utilisateur_Filtre_Taille_Max = $vue_utilisateur_Filtre_Taille_Max LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('vue_utilisateur');
        if (false === $Code_vue_utilisateur = $cache_db->read($requete_sql)) {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $Code_vue_utilisateur = (int) $row_requete['Code_vue_utilisateur'];
            } else {
                $Code_vue_utilisateur = 0;
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_vue_utilisateur);
        }
        return $Code_vue_utilisateur;
    }

    protected function rechercher_vue_utilisateur_Filtre_Taille_Min(int $vue_utilisateur_Filtre_Taille_Min): int
    {
        $vue_utilisateur_Filtre_Taille_Min = format_sql('vue_utilisateur_Filtre_Taille_Min', $vue_utilisateur_Filtre_Taille_Min);
        $requete_sql = 'SELECT Code_vue_utilisateur FROM '.inst('vue_utilisateur')." WHERE vue_utilisateur_Filtre_Taille_Min = $vue_utilisateur_Filtre_Taille_Min LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('vue_utilisateur');
        if (false === $Code_vue_utilisateur = $cache_db->read($requete_sql)) {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $Code_vue_utilisateur = (int) $row_requete['Code_vue_utilisateur'];
            } else {
                $Code_vue_utilisateur = 0;
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_vue_utilisateur);
        }
        return $Code_vue_utilisateur;
    }

    protected function __get_liste_Code_vue_utilisateur(?array $options = null /* $options = [ 'cond_mysql' => [] ] */)
    {
        return $this->get_liste_Code_vue_utilisateur($options);
    }

    protected function get_liste_Code_vue_utilisateur(?array $options = null /* $options = [ 'cond_mysql' => [] ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cache_db = new Mf_Cachedb('vue_utilisateur');
        $cle = "vue_utilisateur__lister_cles";

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
            if (isset($mf_tri_defaut_table['vue_utilisateur'])) {
                $options['tris'] = $mf_tri_defaut_table['vue_utilisateur'];
            }
        }
        foreach ($options['tris'] as $colonne => $tri) {
            if ($argument_tris == '') { $argument_tris = ' ORDER BY '; } else { $argument_tris .= ', '; }
            if ($tri != 'DESC') $tri = 'ASC';
            $argument_tris .= "$colonne $tri";
        }
        if ($argument_tris == '') {
            $argument_tris = 'ORDER BY Code_vue_utilisateur ASC';
        }
        $cle .= "_$argument_tris";

        // limit
        $argument_limit = '';
        if (isset($options['limit'][0]) && isset($options['limit'][1])) {
            $argument_limit = " LIMIT {$options['limit'][0]}, {$options['limit'][1]}";
        }
        $cle .= "_$argument_limit";

        if (false === $liste = $cache_db->read($cle)) {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ($argument_cond != '') {
                if ( strpos($argument_cond, 'vue_utilisateur_Recherche')!==false ) { $liste_colonnes_a_indexer['vue_utilisateur_Recherche'] = 'vue_utilisateur_Recherche'; }
                if ( strpos($argument_cond, 'vue_utilisateur_Filtre_Saison_Type')!==false ) { $liste_colonnes_a_indexer['vue_utilisateur_Filtre_Saison_Type'] = 'vue_utilisateur_Filtre_Saison_Type'; }
                if ( strpos($argument_cond, 'vue_utilisateur_Filtre_Couleur')!==false ) { $liste_colonnes_a_indexer['vue_utilisateur_Filtre_Couleur'] = 'vue_utilisateur_Filtre_Couleur'; }
                if ( strpos($argument_cond, 'vue_utilisateur_Filtre_Taille_Pays_Type')!==false ) { $liste_colonnes_a_indexer['vue_utilisateur_Filtre_Taille_Pays_Type'] = 'vue_utilisateur_Filtre_Taille_Pays_Type'; }
                if ( strpos($argument_cond, 'vue_utilisateur_Filtre_Taille_Max')!==false ) { $liste_colonnes_a_indexer['vue_utilisateur_Filtre_Taille_Max'] = 'vue_utilisateur_Filtre_Taille_Max'; }
                if ( strpos($argument_cond, 'vue_utilisateur_Filtre_Taille_Min')!==false ) { $liste_colonnes_a_indexer['vue_utilisateur_Filtre_Taille_Min'] = 'vue_utilisateur_Filtre_Taille_Min'; }
            }
            if (count($liste_colonnes_a_indexer) > 0) {
                if (false === $mf_liste_requete_index = $cache_db->read('vue_utilisateur__index')) {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('vue_utilisateur').'`;', false);
                    $mf_liste_requete_index = [];
                    while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('vue_utilisateur__index', $mf_liste_requete_index);
                }
                foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if (count($liste_colonnes_a_indexer) > 0) {
                    foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                        executer_requete_mysql('ALTER TABLE `'.inst('vue_utilisateur').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                }
            }

            $liste = [];
            $table = inst('vue_utilisateur');
            $res_requete = executer_requete_mysql("SELECT Code_vue_utilisateur FROM $table WHERE 1 $argument_cond $argument_tris $argument_limit;", false);
            while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $liste[] = (int) $row_requete['Code_vue_utilisateur'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste);
        }
        return $liste;
    }

/*
    +--------------------------+
    |  sous_categorie_article  |
    +--------------------------+
*/

    protected function mf_tester_existance_Code_sous_categorie_article( int $Code_sous_categorie_article )
    {
        $Code_sous_categorie_article = intval($Code_sous_categorie_article);
        $requete_sql = "SELECT Code_sous_categorie_article FROM " . inst('sous_categorie_article') . " WHERE Code_sous_categorie_article = $Code_sous_categorie_article;";
        $cache_db = new Mf_Cachedb('sous_categorie_article');
        if (false === $r = $cache_db->read($requete_sql)) {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) $r = 'o'; else $r = 'n';
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $r);
        }
        return $r == 'o';
    }

    protected function rechercher_sous_categorie_article_Libelle(string $sous_categorie_article_Libelle, ?int $Code_categorie_article = null): int
    {
        $sous_categorie_article_Libelle = format_sql('sous_categorie_article_Libelle', $sous_categorie_article_Libelle);
        $Code_categorie_article = intval($Code_categorie_article);
        $requete_sql = 'SELECT Code_sous_categorie_article FROM '.inst('sous_categorie_article')." WHERE sous_categorie_article_Libelle = $sous_categorie_article_Libelle".( $Code_categorie_article!=0 ? " AND Code_categorie_article=$Code_categorie_article" : "" )." LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('sous_categorie_article');
        if (false === $Code_sous_categorie_article = $cache_db->read($requete_sql)) {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $Code_sous_categorie_article = (int) $row_requete['Code_sous_categorie_article'];
            } else {
                $Code_sous_categorie_article = 0;
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_sous_categorie_article);
        }
        return $Code_sous_categorie_article;
    }

    protected function rechercher_sous_categorie_article__Code_categorie_article(int $Code_categorie_article): int
    {
        $requete_sql = 'SELECT Code_sous_categorie_article FROM '.inst('sous_categorie_article')." WHERE Code_categorie_article = $Code_categorie_article LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('sous_categorie_article');
        if (false === $Code_sous_categorie_article = $cache_db->read($requete_sql)) {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $Code_sous_categorie_article = (int) $row_requete['Code_sous_categorie_article'];
            } else {
                $Code_sous_categorie_article = 0;
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_sous_categorie_article);
        }
        return $Code_sous_categorie_article;
    }

    protected function __get_liste_Code_sous_categorie_article(?array $options = null /* $options = [ 'cond_mysql' => [] ] */)
    {
        return $this->get_liste_Code_sous_categorie_article(null, $options);
    }

    protected function get_liste_Code_sous_categorie_article(?int $Code_categorie_article = null, ?array $options = null /* $options = [ 'cond_mysql' => [] ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cache_db = new Mf_Cachedb('sous_categorie_article');
        $cle = "sous_categorie_article__lister_cles";
        $Code_categorie_article = intval($Code_categorie_article);
        $cle .= "_{$Code_categorie_article}";

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
            if (isset($mf_tri_defaut_table['sous_categorie_article'])) {
                $options['tris'] = $mf_tri_defaut_table['sous_categorie_article'];
            }
        }
        foreach ($options['tris'] as $colonne => $tri) {
            if ($argument_tris == '') { $argument_tris = ' ORDER BY '; } else { $argument_tris .= ', '; }
            if ($tri != 'DESC') $tri = 'ASC';
            $argument_tris .= "$colonne $tri";
        }
        if ($argument_tris == '') {
            $argument_tris = 'ORDER BY Code_sous_categorie_article ASC';
        }
        $cle .= "_$argument_tris";

        // limit
        $argument_limit = '';
        if (isset($options['limit'][0]) && isset($options['limit'][1])) {
            $argument_limit = " LIMIT {$options['limit'][0]}, {$options['limit'][1]}";
        }
        $cle .= "_$argument_limit";

        if (false === $liste = $cache_db->read($cle)) {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ($argument_cond != '') {
                if ( strpos($argument_cond, 'sous_categorie_article_Libelle')!==false ) { $liste_colonnes_a_indexer['sous_categorie_article_Libelle'] = 'sous_categorie_article_Libelle'; }
            }
            if (count($liste_colonnes_a_indexer) > 0) {
                if (false === $mf_liste_requete_index = $cache_db->read('sous_categorie_article__index')) {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('sous_categorie_article').'`;', false);
                    $mf_liste_requete_index = [];
                    while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('sous_categorie_article__index', $mf_liste_requete_index);
                }
                foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if (count($liste_colonnes_a_indexer) > 0) {
                    foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                        executer_requete_mysql('ALTER TABLE `'.inst('sous_categorie_article').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                }
            }

            $liste = [];
            $table = inst('sous_categorie_article');
            $res_requete = executer_requete_mysql("SELECT Code_sous_categorie_article FROM $table WHERE 1 ".( $Code_categorie_article!=0 ? " AND Code_categorie_article=$Code_categorie_article" : "" )."$argument_cond $argument_tris $argument_limit;", false);
            while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $liste[] = (int) $row_requete['Code_sous_categorie_article'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste);
        }
        return $liste;
    }

    /**
     * @param int $Code_sous_categorie_article
     * @return int $Code_categorie_article
     */
    protected function Code_sous_categorie_article_vers_Code_categorie_article(int $Code_sous_categorie_article): int
    {
        global $mf_cache_volatil;
        if ($Code_sous_categorie_article < 0) $Code_sous_categorie_article = 0;
        if (isset($mf_cache_volatil->variables['sous_categorie_article']['Code_sous_categorie_article_vers_Code_categorie_article'][$Code_sous_categorie_article])) {
            return $mf_cache_volatil->variables['sous_categorie_article']['Code_sous_categorie_article_vers_Code_categorie_article'][$Code_sous_categorie_article];
        }
        // Initialisation de la valeur de retour à 0
        $mf_cache_volatil->variables['sous_categorie_article']['Code_sous_categorie_article_vers_Code_categorie_article'][$Code_sous_categorie_article] = 0;
        $p = floor($Code_sous_categorie_article/100);
        $start = $p * 100;
        $end = ($p + 1) * 100;
        $cache_db = new Mf_Cachedb('sous_categorie_article');
        $cle = 'Code_sous_categorie_article_vers_Code_categorie_article__'.$start.'__'.$end;
        if (false === $conversion = $cache_db->read($cle)) {
            $res_requete = executer_requete_mysql('SELECT Code_sous_categorie_article, Code_categorie_article FROM '.inst('sous_categorie_article').' WHERE '.$start.' <= Code_sous_categorie_article AND Code_sous_categorie_article < '.$end.';', false);
            $conversion = [];
            while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $conversion[(int) $row_requete['Code_sous_categorie_article']] = (int) $row_requete['Code_categorie_article'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $conversion, false);
        }
        foreach ($conversion as $k => $v) {
            $mf_cache_volatil->variables['sous_categorie_article']['Code_sous_categorie_article_vers_Code_categorie_article'][$k] = $v;
        }
        return $mf_cache_volatil->variables['sous_categorie_article']['Code_sous_categorie_article_vers_Code_categorie_article'][$Code_sous_categorie_article];
    }

    protected function liste_Code_categorie_article_vers_liste_Code_sous_categorie_article( array $liste_Code_categorie_article, ?array $options = null /* $options = [ 'cond_mysql' => [] ] */ )
    {
        if ($options === null) {
            $options = [];
        }
        $cache_db = new Mf_Cachedb('sous_categorie_article');
        $cle = 'liste_Code_categorie_article_vers_liste_Code_sous_categorie_article__' . Sql_Format_Liste($liste_Code_categorie_article);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql'])) {
            foreach ($options['cond_mysql'] as &$condition) {
                $argument_cond .= " AND ($condition)";
            }
            unset($condition);
        }
        $cle .= "_$argument_cond";

        if (false === $liste_Code_sous_categorie_article = $cache_db->read($cle)) {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ($argument_cond != '') {
                if ( strpos($argument_cond, 'sous_categorie_article_Libelle')!==false ) { $liste_colonnes_a_indexer['sous_categorie_article_Libelle'] = 'sous_categorie_article_Libelle'; }
            }
            if (count($liste_colonnes_a_indexer) > 0) {
                if (false === $mf_liste_requete_index = $cache_db->read('sous_categorie_article__index')) {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('sous_categorie_article').'`;', false);
                    $mf_liste_requete_index = [];
                    while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('sous_categorie_article__index', $mf_liste_requete_index);
                }
                foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if (count($liste_colonnes_a_indexer) > 0) {
                    foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                        executer_requete_mysql('ALTER TABLE `'.inst('sous_categorie_article').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                }
            }

            $liste_Code_sous_categorie_article = [];
            $res_requete = executer_requete_mysql('SELECT Code_sous_categorie_article FROM '.inst('sous_categorie_article')." WHERE Code_categorie_article IN ".Sql_Format_Liste($liste_Code_categorie_article).$argument_cond.";", false);
            while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $liste_Code_sous_categorie_article[] = (int) $row_requete['Code_sous_categorie_article'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_sous_categorie_article);
        }
        return $liste_Code_sous_categorie_article;
    }

    protected function sous_categorie_article__liste_Code_sous_categorie_article_vers_liste_Code_categorie_article( array $liste_Code_sous_categorie_article, ?array $options = null /* $options = [ 'cond_mysql' => [] ] */ )
    {
        if ($options === null) {
            $options=[];
        }
        $cache_db = new Mf_Cachedb("sous_categorie_article");
        $cle = "liste_Code_sous_categorie_article_vers_liste_Code_categorie_article__".Sql_Format_Liste($liste_Code_sous_categorie_article);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql'])) {
            foreach ($options['cond_mysql'] as &$condition) {
                $argument_cond .= " AND ($condition)";
            }
            unset($condition);
        }
        $cle .= "_$argument_cond";

        if (false === $liste_Code_categorie_article = $cache_db->read($cle)) {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ($argument_cond != '') {
                if ( strpos($argument_cond, 'sous_categorie_article_Libelle')!==false ) { $liste_colonnes_a_indexer['sous_categorie_article_Libelle'] = 'sous_categorie_article_Libelle'; }
            }
            if (count($liste_colonnes_a_indexer) > 0) {
                if (false === $mf_liste_requete_index = $cache_db->read('sous_categorie_article__index')) {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('sous_categorie_article').'`;', false);
                    $mf_liste_requete_index = [];
                    while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('sous_categorie_article__index', $mf_liste_requete_index);
                }
                foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if (count($liste_colonnes_a_indexer) > 0) {
                    foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                        executer_requete_mysql('ALTER TABLE `'.inst('sous_categorie_article').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                }
            }

            $controle_doublons = [];
            $liste_Code_categorie_article = [];
            $res_requete = executer_requete_mysql("SELECT Code_categorie_article FROM " . inst('sous_categorie_article') . " WHERE Code_sous_categorie_article IN " . Sql_Format_Liste($liste_Code_sous_categorie_article) . $argument_cond . ";", false);
            while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                if (! isset($controle_doublons[(int) $row_requete['Code_categorie_article']])) {
                    $controle_doublons[(int) $row_requete['Code_categorie_article']] = 1;
                    $liste_Code_categorie_article[] = (int) $row_requete['Code_categorie_article'];
                }
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_categorie_article);
        }
        return $liste_Code_categorie_article;
    }

/*
    +-----------+
    |  conseil  |
    +-----------+
*/

    protected function mf_tester_existance_Code_conseil( int $Code_conseil )
    {
        $Code_conseil = intval($Code_conseil);
        $requete_sql = "SELECT Code_conseil FROM " . inst('conseil') . " WHERE Code_conseil = $Code_conseil;";
        $cache_db = new Mf_Cachedb('conseil');
        if (false === $r = $cache_db->read($requete_sql)) {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) $r = 'o'; else $r = 'n';
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $r);
        }
        return $r == 'o';
    }

    protected function rechercher_conseil_Libelle(string $conseil_Libelle): int
    {
        $conseil_Libelle = format_sql('conseil_Libelle', $conseil_Libelle);
        $requete_sql = 'SELECT Code_conseil FROM '.inst('conseil')." WHERE conseil_Libelle = $conseil_Libelle LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('conseil');
        if (false === $Code_conseil = $cache_db->read($requete_sql)) {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $Code_conseil = (int) $row_requete['Code_conseil'];
            } else {
                $Code_conseil = 0;
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_conseil);
        }
        return $Code_conseil;
    }

    protected function rechercher_conseil_Actif(bool $conseil_Actif): int
    {
        $conseil_Actif = format_sql('conseil_Actif', $conseil_Actif);
        $requete_sql = 'SELECT Code_conseil FROM '.inst('conseil')." WHERE conseil_Actif = $conseil_Actif LIMIT 0, 1;";
        $cache_db = new Mf_Cachedb('conseil');
        if (false === $Code_conseil = $cache_db->read($requete_sql)) {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $Code_conseil = (int) $row_requete['Code_conseil'];
            } else {
                $Code_conseil = 0;
            }
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $Code_conseil);
        }
        return $Code_conseil;
    }

    protected function __get_liste_Code_conseil(?array $options = null /* $options = [ 'cond_mysql' => [] ] */)
    {
        return $this->get_liste_Code_conseil($options);
    }

    protected function get_liste_Code_conseil(?array $options = null /* $options = [ 'cond_mysql' => [] ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cache_db = new Mf_Cachedb('conseil');
        $cle = "conseil__lister_cles";

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
            if (isset($mf_tri_defaut_table['conseil'])) {
                $options['tris'] = $mf_tri_defaut_table['conseil'];
            }
        }
        foreach ($options['tris'] as $colonne => $tri) {
            if ($argument_tris == '') { $argument_tris = ' ORDER BY '; } else { $argument_tris .= ', '; }
            if ($tri != 'DESC') $tri = 'ASC';
            $argument_tris .= "$colonne $tri";
        }
        if ($argument_tris == '') {
            $argument_tris = 'ORDER BY Code_conseil ASC';
        }
        $cle .= "_$argument_tris";

        // limit
        $argument_limit = '';
        if (isset($options['limit'][0]) && isset($options['limit'][1])) {
            $argument_limit = " LIMIT {$options['limit'][0]}, {$options['limit'][1]}";
        }
        $cle .= "_$argument_limit";

        if (false === $liste = $cache_db->read($cle)) {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ($argument_cond != '') {
                if ( strpos($argument_cond, 'conseil_Libelle')!==false ) { $liste_colonnes_a_indexer['conseil_Libelle'] = 'conseil_Libelle'; }
                if ( strpos($argument_cond, 'conseil_Actif')!==false ) { $liste_colonnes_a_indexer['conseil_Actif'] = 'conseil_Actif'; }
            }
            if (count($liste_colonnes_a_indexer) > 0) {
                if (false === $mf_liste_requete_index = $cache_db->read('conseil__index')) {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('conseil').'`;', false);
                    $mf_liste_requete_index = [];
                    while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('conseil__index', $mf_liste_requete_index);
                }
                foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if (count($liste_colonnes_a_indexer) > 0) {
                    foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                        executer_requete_mysql('ALTER TABLE `'.inst('conseil').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                }
            }

            $liste = [];
            $table = inst('conseil');
            $res_requete = executer_requete_mysql("SELECT Code_conseil FROM $table WHERE 1 $argument_cond $argument_tris $argument_limit;", false);
            while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $liste[] = (int) $row_requete['Code_conseil'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste);
        }
        return $liste;
    }

/*
    +----------------------+
    |  a_commande_article  |
    +----------------------+
*/

    protected function mf_tester_existance_a_commande_article(int $Code_commande, int $Code_article)
    {
        $Code_commande = intval($Code_commande);
        $Code_article = intval($Code_article);
        $requete_sql = 'SELECT * FROM ' . inst('a_commande_article') . " WHERE Code_commande=$Code_commande AND Code_article=$Code_article;";
        $cache_db = new Mf_Cachedb('a_commande_article');
        if (false === $r = $cache_db->read($requete_sql)) {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) $r = 'o'; else $r = 'n';
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $r);
        }
        return $r=='o';
    }

    protected function a_commande_article_liste_Code_commande_vers_liste_Code_article(  array $liste_Code_commande, ?array $options = null /* $options = [ 'cond_mysql' => [] ] */ )
    {
        if ($options === null) {
            $options=[];
        }
        $cache_db = new Mf_Cachedb("a_commande_article");
        $cle = "liste_Code_commande_vers_liste_Code_article__".Sql_Format_Liste($liste_Code_commande);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql'])) {
            foreach ($options['cond_mysql'] as &$condition) {
                $argument_cond .= " AND ($condition)";
            }
            unset($condition);
        }
        $cle .= "_$argument_cond";

        if (false === $liste_Code_article = $cache_db->read($cle)) {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ($argument_cond != '') {
                if ( strpos($argument_cond, 'a_commande_article_Quantite')!==false ) { $liste_colonnes_a_indexer['a_commande_article_Quantite'] = 'a_commande_article_Quantite'; }
                if ( strpos($argument_cond, 'a_commande_article_Prix_ligne')!==false ) { $liste_colonnes_a_indexer['a_commande_article_Prix_ligne'] = 'a_commande_article_Prix_ligne'; }
            }
            if (count($liste_colonnes_a_indexer) > 0) {
                if (false === $mf_liste_requete_index = $cache_db->read('a_commande_article__index')) {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('a_commande_article').'`;', false);
                    $mf_liste_requete_index = [];
                    while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('a_commande_article__index', $mf_liste_requete_index);
                }
                foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if (count($liste_colonnes_a_indexer) > 0) {
                    foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                        executer_requete_mysql('ALTER TABLE `'.inst('a_commande_article').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                }
            }

            $liste_Code_article = [];
            $res_requete = executer_requete_mysql('SELECT Code_article FROM '.inst('a_commande_article')." WHERE Code_commande IN ".Sql_Format_Liste($liste_Code_commande).$argument_cond.';', false);
            while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $liste_Code_article[(int) $row_requete['Code_article']] = (int) $row_requete['Code_article'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_article);
        }
        return $liste_Code_article;
    }

    protected function a_commande_article_liste_Code_article_vers_liste_Code_commande(  array $liste_Code_article, ?array $options = null /* $options = [ 'cond_mysql' => [] ] */ )
    {
        if ($options === null) {
            $options=[];
        }
        $cache_db = new Mf_Cachedb("a_commande_article");
        $cle = "liste_Code_article_vers_liste_Code_commande__".Sql_Format_Liste($liste_Code_article);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql'])) {
            foreach ($options['cond_mysql'] as &$condition) {
                $argument_cond .= " AND ($condition)";
            }
            unset($condition);
        }
        $cle .= "_$argument_cond";

        if (false === $liste_Code_commande = $cache_db->read($cle)) {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if ($argument_cond != '') {
                if ( strpos($argument_cond, 'a_commande_article_Quantite')!==false ) { $liste_colonnes_a_indexer['a_commande_article_Quantite'] = 'a_commande_article_Quantite'; }
                if ( strpos($argument_cond, 'a_commande_article_Prix_ligne')!==false ) { $liste_colonnes_a_indexer['a_commande_article_Prix_ligne'] = 'a_commande_article_Prix_ligne'; }
            }
            if (count($liste_colonnes_a_indexer) > 0) {
                if (false === $mf_liste_requete_index = $cache_db->read('a_commande_article__index')) {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('a_commande_article').'`;', false);
                    $mf_liste_requete_index = [];
                    while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('a_commande_article__index', $mf_liste_requete_index);
                }
                foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if (count($liste_colonnes_a_indexer) > 0) {
                    foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                        executer_requete_mysql('ALTER TABLE `'.inst('a_commande_article').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                }
            }

            $liste_Code_commande = [];
            $res_requete = executer_requete_mysql('SELECT Code_commande FROM '.inst('a_commande_article')." WHERE Code_article IN ".Sql_Format_Liste($liste_Code_article).$argument_cond.';', false);
            while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $liste_Code_commande[(int) $row_requete['Code_commande']] = (int) $row_requete['Code_commande'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_commande);
        }
        return $liste_Code_commande;
    }

/*
    +---------------------------+
    |  a_parametre_utilisateur  |
    +---------------------------+
*/

    protected function mf_tester_existance_a_parametre_utilisateur(int $Code_utilisateur, int $Code_parametre)
    {
        $Code_utilisateur = intval($Code_utilisateur);
        $Code_parametre = intval($Code_parametre);
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

    protected function a_parametre_utilisateur_liste_Code_utilisateur_vers_liste_Code_parametre(  array $liste_Code_utilisateur, ?array $options = null /* $options = [ 'cond_mysql' => [] ] */ )
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
                $argument_cond .= " AND ($condition)";
            }
            unset($condition);
        }
        $cle .= "_$argument_cond";

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
                    $mf_liste_requete_index = [];
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

            $liste_Code_parametre = [];
            $res_requete = executer_requete_mysql('SELECT Code_parametre FROM '.inst('a_parametre_utilisateur')." WHERE Code_utilisateur IN ".Sql_Format_Liste($liste_Code_utilisateur).$argument_cond.';', false);
            while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $liste_Code_parametre[(int) $row_requete['Code_parametre']] = (int) $row_requete['Code_parametre'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_parametre);
        }
        return $liste_Code_parametre;
    }

    protected function a_parametre_utilisateur_liste_Code_parametre_vers_liste_Code_utilisateur(  array $liste_Code_parametre, ?array $options = null /* $options = [ 'cond_mysql' => [] ] */ )
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
                $argument_cond .= " AND ($condition)";
            }
            unset($condition);
        }
        $cle .= "_$argument_cond";

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
                    $mf_liste_requete_index = [];
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

            $liste_Code_utilisateur = [];
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
    +-------------+
    |  a_filtrer  |
    +-------------+
*/

    protected function mf_tester_existance_a_filtrer(int $Code_utilisateur, int $Code_vue_utilisateur)
    {
        $Code_utilisateur = intval($Code_utilisateur);
        $Code_vue_utilisateur = intval($Code_vue_utilisateur);
        $requete_sql = 'SELECT * FROM ' . inst('a_filtrer') . " WHERE Code_utilisateur=$Code_utilisateur AND Code_vue_utilisateur=$Code_vue_utilisateur;";
        $cache_db = new Mf_Cachedb('a_filtrer');
        if (false === $r = $cache_db->read($requete_sql)) {
            $res_requete = executer_requete_mysql($requete_sql, false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) $r = 'o'; else $r = 'n';
            mysqli_free_result($res_requete);
            $cache_db->write($requete_sql, $r);
        }
        return $r=='o';
    }

    protected function a_filtrer_liste_Code_utilisateur_vers_liste_Code_vue_utilisateur(  array $liste_Code_utilisateur, ?array $options = null /* $options = [ 'cond_mysql' => [] ] */ )
    {
        if ($options === null) {
            $options=[];
        }
        $cache_db = new Mf_Cachedb("a_filtrer");
        $cle = "liste_Code_utilisateur_vers_liste_Code_vue_utilisateur__".Sql_Format_Liste($liste_Code_utilisateur);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql'])) {
            foreach ($options['cond_mysql'] as &$condition) {
                $argument_cond .= " AND ($condition)";
            }
            unset($condition);
        }
        $cle .= "_$argument_cond";

        if (false === $liste_Code_vue_utilisateur = $cache_db->read($cle)) {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if (count($liste_colonnes_a_indexer) > 0) {
                if (false === $mf_liste_requete_index = $cache_db->read('a_filtrer__index')) {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('a_filtrer').'`;', false);
                    $mf_liste_requete_index = [];
                    while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('a_filtrer__index', $mf_liste_requete_index);
                }
                foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if (count($liste_colonnes_a_indexer) > 0) {
                    foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                        executer_requete_mysql('ALTER TABLE `'.inst('a_filtrer').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                }
            }

            $liste_Code_vue_utilisateur = [];
            $res_requete = executer_requete_mysql('SELECT Code_vue_utilisateur FROM '.inst('a_filtrer')." WHERE Code_utilisateur IN ".Sql_Format_Liste($liste_Code_utilisateur).$argument_cond.';', false);
            while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $liste_Code_vue_utilisateur[(int) $row_requete['Code_vue_utilisateur']] = (int) $row_requete['Code_vue_utilisateur'];
            }
            mysqli_free_result($res_requete);
            $cache_db->write($cle, $liste_Code_vue_utilisateur);
        }
        return $liste_Code_vue_utilisateur;
    }

    protected function a_filtrer_liste_Code_vue_utilisateur_vers_liste_Code_utilisateur(  array $liste_Code_vue_utilisateur, ?array $options = null /* $options = [ 'cond_mysql' => [] ] */ )
    {
        if ($options === null) {
            $options=[];
        }
        $cache_db = new Mf_Cachedb("a_filtrer");
        $cle = "liste_Code_vue_utilisateur_vers_liste_Code_utilisateur__".Sql_Format_Liste($liste_Code_vue_utilisateur);

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql'])) {
            foreach ($options['cond_mysql'] as &$condition) {
                $argument_cond .= " AND ($condition)";
            }
            unset($condition);
        }
        $cle .= "_$argument_cond";

        if (false === $liste_Code_utilisateur = $cache_db->read($cle)) {

            // Indexes
            $liste_colonnes_a_indexer = [];
            if (count($liste_colonnes_a_indexer) > 0) {
                if (false === $mf_liste_requete_index = $cache_db->read('a_filtrer__index')) {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('a_filtrer').'`;', false);
                    $mf_liste_requete_index = [];
                    while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
                        $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
                    }
                    mysqli_free_result($res_requete_index);
                    $cache_db->write('a_filtrer__index', $mf_liste_requete_index);
                }
                foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
                    if ( isset($liste_colonnes_a_indexer[$mf_colonne_indexee]) ) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
                }
                if (count($liste_colonnes_a_indexer) > 0) {
                    foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
                        executer_requete_mysql('ALTER TABLE `'.inst('a_filtrer').'` ADD INDEX(`' . $colonnes_a_indexer . '`);');
                    }
                    $cache_db->clear();
                }
            }

            $liste_Code_utilisateur = [];
            $res_requete = executer_requete_mysql('SELECT Code_utilisateur FROM '.inst('a_filtrer')." WHERE Code_vue_utilisateur IN ".Sql_Format_Liste($liste_Code_vue_utilisateur).$argument_cond.';', false);
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

    protected function supprimer_donnes_en_cascade(string $nom_table, array $liste_codes)
    {
        global $mf_type_table_enfant;
        $liste_tables_enfants = mf_get_liste_tables_enfants($nom_table);
        foreach ($liste_tables_enfants as $table_enfant) {
            if ($mf_type_table_enfant[$table_enfant] == 'entite') {
                $liste_codes_enfants=[];
                $res_requete = executer_requete_mysql('SELECT Code_'.$table_enfant . ' FROM ' . inst($table_enfant) . ' WHERE Code_' . $nom_table . ' IN ' . Sql_Format_Liste($liste_codes) . ';', false);
                while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                    $liste_codes_enfants[]=$row_requete['Code_' . $table_enfant];
                }
                mysqli_free_result($res_requete);
                if (count($liste_codes_enfants) > 0) {
                    $liste_codes_enfants = array_chunk($liste_codes_enfants, 32768);
                    $d = count($liste_codes_enfants);
                    for ($i=0; $i<$d; $i++) {
                        $this->supprimer_donnes_en_cascade($table_enfant, $liste_codes_enfants[$i]);
                        executer_requete_mysql('DELETE IGNORE FROM ' . inst($table_enfant) . ' WHERE Code_' . $table_enfant . ' IN ' . Sql_Format_Liste($liste_codes_enfants[$i]) . ';', array_search($table_enfant, LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
                        $cache_db = new Mf_Cachedb($table_enfant);
                        $cache_db->clear();
                    }
                }
            } else {
                executer_requete_mysql('DELETE IGNORE FROM ' . inst($table_enfant) . ' WHERE Code_' . $nom_table . ' IN ' . Sql_Format_Liste($liste_codes) . ';', array_search($table_enfant, LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
                if (requete_mysqli_affected_rows() > 0) {
                    $cache_db = new Mf_Cachedb($table_enfant);
                    $cache_db->clear();
                }
            }
        }
    }

}
