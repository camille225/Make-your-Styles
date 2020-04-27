<?php declare(strict_types=1);

/*
    +------------------------------+
    |  NE PAS MODIFIER CE FICHIER  |
    +------------------------------+
*/

class table_article_monframework extends entite
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
            include_once __DIR__ . '/../../erreurs/erreurs__article.php';
            self::$initialisation = false;
            Hook_article::initialisation();
            self::$cache_db = new Mf_Cachedb('article');
        }
        if (! self::$actualisation_en_cours) {
            self::$actualisation_en_cours=true;
            Hook_article::actualisation();
            self::$actualisation_en_cours=false;
        }
    }

    public static function mf_raz_instance()
    {
        self::$initialisation = true;
    }

    public static function initialiser_structure()
    {
        global $mf_initialisation;

        if (! test_si_table_existe(inst('article'))) {
            executer_requete_mysql('CREATE TABLE '.inst('article').'(Code_article BIGINT UNSIGNED NOT NULL AUTO_INCREMENT, PRIMARY KEY (Code_article)) ENGINE=MyISAM;', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        $liste_colonnes = lister_les_colonnes('article');

        if (isset($liste_colonnes['article_Libelle'])) {
            if (typeMyql2Sql($liste_colonnes['article_Libelle']['Type'])!='VARCHAR') {
                executer_requete_mysql('ALTER TABLE '.inst('article').' CHANGE article_Libelle article_Libelle VARCHAR(255);', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['article_Libelle']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('article').' ADD article_Libelle VARCHAR(255);', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE '.inst('article').' SET article_Libelle=' . format_sql('article_Libelle', $mf_initialisation['article_Libelle']) . ';', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if (isset($liste_colonnes['article_Description'])) {
            if (typeMyql2Sql($liste_colonnes['article_Description']['Type'])!='TEXT') {
                executer_requete_mysql('ALTER TABLE '.inst('article').' CHANGE article_Description article_Description TEXT;', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['article_Description']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('article').' ADD article_Description TEXT;', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE '.inst('article').' SET article_Description=' . format_sql('article_Description', $mf_initialisation['article_Description']) . ';', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if (isset($liste_colonnes['article_Saison_Type'])) {
            if (typeMyql2Sql($liste_colonnes['article_Saison_Type']['Type'])!='INT') {
                executer_requete_mysql('ALTER TABLE '.inst('article').' CHANGE article_Saison_Type article_Saison_Type INT;', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['article_Saison_Type']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('article').' ADD article_Saison_Type INT;', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE '.inst('article').' SET article_Saison_Type=' . format_sql('article_Saison_Type', $mf_initialisation['article_Saison_Type']) . ';', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if (isset($liste_colonnes['article_Nom_fournisseur'])) {
            if (typeMyql2Sql($liste_colonnes['article_Nom_fournisseur']['Type'])!='VARCHAR') {
                executer_requete_mysql('ALTER TABLE '.inst('article').' CHANGE article_Nom_fournisseur article_Nom_fournisseur VARCHAR(255);', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['article_Nom_fournisseur']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('article').' ADD article_Nom_fournisseur VARCHAR(255);', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE '.inst('article').' SET article_Nom_fournisseur=' . format_sql('article_Nom_fournisseur', $mf_initialisation['article_Nom_fournisseur']) . ';', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if (isset($liste_colonnes['article_Url'])) {
            if (typeMyql2Sql($liste_colonnes['article_Url']['Type'])!='VARCHAR') {
                executer_requete_mysql('ALTER TABLE '.inst('article').' CHANGE article_Url article_Url VARCHAR(255);', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['article_Url']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('article').' ADD article_Url VARCHAR(255);', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE '.inst('article').' SET article_Url=' . format_sql('article_Url', $mf_initialisation['article_Url']) . ';', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if (isset($liste_colonnes['article_Reference'])) {
            if (typeMyql2Sql($liste_colonnes['article_Reference']['Type'])!='VARCHAR') {
                executer_requete_mysql('ALTER TABLE '.inst('article').' CHANGE article_Reference article_Reference VARCHAR(255);', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['article_Reference']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('article').' ADD article_Reference VARCHAR(255);', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE '.inst('article').' SET article_Reference=' . format_sql('article_Reference', $mf_initialisation['article_Reference']) . ';', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if (isset($liste_colonnes['article_Couleur'])) {
            if (typeMyql2Sql($liste_colonnes['article_Couleur']['Type'])!='VARCHAR') {
                executer_requete_mysql('ALTER TABLE '.inst('article').' CHANGE article_Couleur article_Couleur VARCHAR(255);', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['article_Couleur']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('article').' ADD article_Couleur VARCHAR(255);', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE '.inst('article').' SET article_Couleur=' . format_sql('article_Couleur', $mf_initialisation['article_Couleur']) . ';', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if (isset($liste_colonnes['article_Code_couleur_svg'])) {
            if (typeMyql2Sql($liste_colonnes['article_Code_couleur_svg']['Type'])!='VARCHAR') {
                executer_requete_mysql('ALTER TABLE '.inst('article').' CHANGE article_Code_couleur_svg article_Code_couleur_svg VARCHAR(255);', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['article_Code_couleur_svg']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('article').' ADD article_Code_couleur_svg VARCHAR(255);', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE '.inst('article').' SET article_Code_couleur_svg=' . format_sql('article_Code_couleur_svg', $mf_initialisation['article_Code_couleur_svg']) . ';', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if (isset($liste_colonnes['article_Taille_Pays_Type'])) {
            if (typeMyql2Sql($liste_colonnes['article_Taille_Pays_Type']['Type'])!='INT') {
                executer_requete_mysql('ALTER TABLE '.inst('article').' CHANGE article_Taille_Pays_Type article_Taille_Pays_Type INT;', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['article_Taille_Pays_Type']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('article').' ADD article_Taille_Pays_Type INT;', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE '.inst('article').' SET article_Taille_Pays_Type=' . format_sql('article_Taille_Pays_Type', $mf_initialisation['article_Taille_Pays_Type']) . ';', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if (isset($liste_colonnes['article_Taille'])) {
            if (typeMyql2Sql($liste_colonnes['article_Taille']['Type'])!='INT') {
                executer_requete_mysql('ALTER TABLE '.inst('article').' CHANGE article_Taille article_Taille INT;', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['article_Taille']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('article').' ADD article_Taille INT;', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE '.inst('article').' SET article_Taille=' . format_sql('article_Taille', $mf_initialisation['article_Taille']) . ';', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if (isset($liste_colonnes['article_Matiere'])) {
            if (typeMyql2Sql($liste_colonnes['article_Matiere']['Type'])!='VARCHAR') {
                executer_requete_mysql('ALTER TABLE '.inst('article').' CHANGE article_Matiere article_Matiere VARCHAR(255);', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['article_Matiere']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('article').' ADD article_Matiere VARCHAR(255);', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE '.inst('article').' SET article_Matiere=' . format_sql('article_Matiere', $mf_initialisation['article_Matiere']) . ';', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if (isset($liste_colonnes['article_Photo_Fichier'])) {
            if (typeMyql2Sql($liste_colonnes['article_Photo_Fichier']['Type'])!='VARCHAR') {
                executer_requete_mysql('ALTER TABLE '.inst('article').' CHANGE article_Photo_Fichier article_Photo_Fichier VARCHAR(255);', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['article_Photo_Fichier']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('article').' ADD article_Photo_Fichier VARCHAR(255);', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE '.inst('article').' SET article_Photo_Fichier=' . format_sql('article_Photo_Fichier', $mf_initialisation['article_Photo_Fichier']) . ';', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if (isset($liste_colonnes['article_Prix'])) {
            if (typeMyql2Sql($liste_colonnes['article_Prix']['Type'])!='FLOAT') {
                executer_requete_mysql('ALTER TABLE '.inst('article').' CHANGE article_Prix article_Prix FLOAT;', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['article_Prix']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('article').' ADD article_Prix FLOAT;', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE '.inst('article').' SET article_Prix=' . format_sql('article_Prix', $mf_initialisation['article_Prix']) . ';', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if (isset($liste_colonnes['article_Actif'])) {
            if (typeMyql2Sql($liste_colonnes['article_Actif']['Type'])!='BOOL') {
                executer_requete_mysql('ALTER TABLE '.inst('article').' CHANGE article_Actif article_Actif BOOL;', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['article_Actif']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('article').' ADD article_Actif BOOL;', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE '.inst('article').' SET article_Actif=' . format_sql('article_Actif', $mf_initialisation['article_Actif']) . ';', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        $liste_colonnes_a_indexer = [];

        if (isset($liste_colonnes['Code_sous_categorie_article'])) {
            unset($liste_colonnes['Code_sous_categorie_article']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('article').' ADD Code_sous_categorie_article BIGINT UNSIGNED NOT NULL;', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }
        $liste_colonnes_a_indexer['Code_sous_categorie_article'] = 'Code_sous_categorie_article';

        if (isset($liste_colonnes['mf_signature'])) {
            unset($liste_colonnes['mf_signature']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('article').' ADD mf_signature VARCHAR(255);', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }
        $liste_colonnes_a_indexer['mf_signature'] = 'mf_signature';

        if (isset($liste_colonnes['mf_cle_unique'])) {
            unset($liste_colonnes['mf_cle_unique']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('article').' ADD mf_cle_unique VARCHAR(255);', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }
        $liste_colonnes_a_indexer['mf_cle_unique'] = 'mf_cle_unique';

        if (isset($liste_colonnes['mf_date_creation'])) {
            unset($liste_colonnes['mf_date_creation']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('article').' ADD mf_date_creation DATETIME;', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }
        $liste_colonnes_a_indexer['mf_date_creation'] = 'mf_date_creation';

        if (isset($liste_colonnes['mf_date_modification'])) {
            unset($liste_colonnes['mf_date_modification']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('article').' ADD mf_date_modification DATETIME;', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }
        $liste_colonnes_a_indexer['mf_date_modification'] = 'mf_date_modification';

        unset($liste_colonnes['Code_article']);

        foreach ($liste_colonnes as $field => $value) {
            executer_requete_mysql('ALTER TABLE '.inst('article').' DROP COLUMN '.$field.';', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `' . inst('article') . '`;', false);
        $mf_liste_requete_index = [];
        while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
            $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
        }
        mysqli_free_result($res_requete_index);
        foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
            if (isset($liste_colonnes_a_indexer[$mf_colonne_indexee])) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
        }
        foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
            executer_requete_mysql('ALTER TABLE `' . inst('article') . '` ADD INDEX(`' . $colonnes_a_indexer . '`);', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }
    }

    /**
     * Retourne la tructure de la table « article » avec les valeurs initialisées par défaut.
     * @return array
     */
    public function mf_get_structure(): array
    {
        global $mf_initialisation;
        $struc = [
            'Code_article' => null, // ID
            'article_Libelle' => $mf_initialisation['article_Libelle'],
            'article_Description' => $mf_initialisation['article_Description'],
            'article_Saison_Type' => $mf_initialisation['article_Saison_Type'],
            'article_Nom_fournisseur' => $mf_initialisation['article_Nom_fournisseur'],
            'article_Url' => $mf_initialisation['article_Url'],
            'article_Reference' => $mf_initialisation['article_Reference'],
            'article_Couleur' => $mf_initialisation['article_Couleur'],
            'article_Code_couleur_svg' => $mf_initialisation['article_Code_couleur_svg'],
            'article_Taille_Pays_Type' => $mf_initialisation['article_Taille_Pays_Type'],
            'article_Taille' => $mf_initialisation['article_Taille'],
            'article_Matiere' => $mf_initialisation['article_Matiere'],
            'article_Photo_Fichier' => $mf_initialisation['article_Photo_Fichier'],
            'article_Prix' => $mf_initialisation['article_Prix'],
            'article_Actif' => $mf_initialisation['article_Actif'],
            'Code_sous_categorie_article' => 0, // REF
        ];
        mf_formatage_db_type_php($struc);
        Hook_article::pre_controller($struc['article_Libelle'], $struc['article_Description'], $struc['article_Saison_Type'], $struc['article_Nom_fournisseur'], $struc['article_Url'], $struc['article_Reference'], $struc['article_Couleur'], $struc['article_Code_couleur_svg'], $struc['article_Taille_Pays_Type'], $struc['article_Taille'], $struc['article_Matiere'], $struc['article_Photo_Fichier'], $struc['article_Prix'], $struc['article_Actif'], $struc['Code_sous_categorie_article'], $struc['Code_article']);
        return $struc;
    }

    public function mf_ajouter(string $article_Libelle, string $article_Description, ?int $article_Saison_Type, string $article_Nom_fournisseur, string $article_Url, string $article_Reference, string $article_Couleur, string $article_Code_couleur_svg, ?int $article_Taille_Pays_Type, ?int $article_Taille, string $article_Matiere, string $article_Photo_Fichier, ?float $article_Prix, bool $article_Actif, int $Code_sous_categorie_article, ?bool $force = false)
    {
        if ($force === null) {
            $force = false;
        }
        $Code_article = 0;
        $code_erreur = 0;
        // Typage
        $article_Libelle = (string) $article_Libelle;
        $article_Description = (string) $article_Description;
        $article_Saison_Type = is_null($article_Saison_Type) || $article_Saison_Type === '' ? null : (int) $article_Saison_Type;
        $article_Nom_fournisseur = (string) $article_Nom_fournisseur;
        $article_Url = (string) $article_Url;
        $article_Reference = (string) $article_Reference;
        $article_Couleur = (string) $article_Couleur;
        $article_Code_couleur_svg = (string) $article_Code_couleur_svg;
        $article_Taille_Pays_Type = is_null($article_Taille_Pays_Type) || $article_Taille_Pays_Type === '' ? null : (int) $article_Taille_Pays_Type;
        $article_Taille = is_null($article_Taille) || $article_Taille === '' ? null : (int) $article_Taille;
        $article_Matiere = (string) $article_Matiere;
        $article_Photo_Fichier = (string) $article_Photo_Fichier;
        $article_Prix = is_null($article_Prix) || $article_Prix === '' ? null : mf_significantDigit((float) str_replace(' ', '', str_replace(',', '.', $article_Prix)), 6);
        $article_Actif = ($article_Actif == true);
        // Fin typage
        Hook_article::pre_controller($article_Libelle, $article_Description, $article_Saison_Type, $article_Nom_fournisseur, $article_Url, $article_Reference, $article_Couleur, $article_Code_couleur_svg, $article_Taille_Pays_Type, $article_Taille, $article_Matiere, $article_Photo_Fichier, $article_Prix, $article_Actif, $Code_sous_categorie_article);
        if (! $force) {
            if (! self::$maj_droits_ajouter_en_cours) {
                self::$maj_droits_ajouter_en_cours = true;
                Hook_article::hook_actualiser_les_droits_ajouter($Code_sous_categorie_article);
                self::$maj_droits_ajouter_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['article__AJOUTER']) ) $code_erreur = REFUS_ARTICLE__AJOUTER;
        elseif ( !$this->mf_tester_existance_Code_sous_categorie_article($Code_sous_categorie_article) ) $code_erreur = ERR_ARTICLE__AJOUTER__CODE_SOUS_CATEGORIE_ARTICLE_INEXISTANT;
        elseif (CONTROLE_ACCES_DONNEES_DEFAUT && ! Hook_mf_systeme::controle_acces_donnees('Code_sous_categorie_article', $Code_sous_categorie_article)) $code_erreur = ACCES_CODE_SOUS_CATEGORIE_ARTICLE_REFUSE;
        elseif (! Hook_article::autorisation_ajout($article_Libelle, $article_Description, $article_Saison_Type, $article_Nom_fournisseur, $article_Url, $article_Reference, $article_Couleur, $article_Code_couleur_svg, $article_Taille_Pays_Type, $article_Taille, $article_Matiere, $article_Photo_Fichier, $article_Prix, $article_Actif, $Code_sous_categorie_article) ) $code_erreur = REFUS_ARTICLE__AJOUT_BLOQUEE;
        elseif (! controle_parametre("article_Saison_Type", $article_Saison_Type) ) $code_erreur = ERR_ARTICLE__AJOUTER__ARTICLE_SAISON_TYPE_NON_VALIDE;
        elseif (! controle_parametre("article_Taille_Pays_Type", $article_Taille_Pays_Type) ) $code_erreur = ERR_ARTICLE__AJOUTER__ARTICLE_TAILLE_PAYS_TYPE_NON_VALIDE;
        else {
            Hook_article::data_controller($article_Libelle, $article_Description, $article_Saison_Type, $article_Nom_fournisseur, $article_Url, $article_Reference, $article_Couleur, $article_Code_couleur_svg, $article_Taille_Pays_Type, $article_Taille, $article_Matiere, $article_Photo_Fichier, $article_Prix, $article_Actif, $Code_sous_categorie_article);
            $mf_signature = text_sql(Hook_article::calcul_signature($article_Libelle, $article_Description, $article_Saison_Type, $article_Nom_fournisseur, $article_Url, $article_Reference, $article_Couleur, $article_Code_couleur_svg, $article_Taille_Pays_Type, $article_Taille, $article_Matiere, $article_Photo_Fichier, $article_Prix, $article_Actif, $Code_sous_categorie_article));
            $mf_cle_unique = text_sql(Hook_article::calcul_cle_unique($article_Libelle, $article_Description, $article_Saison_Type, $article_Nom_fournisseur, $article_Url, $article_Reference, $article_Couleur, $article_Code_couleur_svg, $article_Taille_Pays_Type, $article_Taille, $article_Matiere, $article_Photo_Fichier, $article_Prix, $article_Actif, $Code_sous_categorie_article));
            $article_Libelle = text_sql($article_Libelle);
            $article_Description = text_sql($article_Description);
            $article_Saison_Type = is_null($article_Saison_Type) ? 'NULL' : (int) $article_Saison_Type;
            $article_Nom_fournisseur = text_sql($article_Nom_fournisseur);
            $article_Url = text_sql($article_Url);
            $article_Reference = text_sql($article_Reference);
            $article_Couleur = text_sql($article_Couleur);
            $article_Code_couleur_svg = text_sql($article_Code_couleur_svg);
            $article_Taille_Pays_Type = is_null($article_Taille_Pays_Type) ? 'NULL' : (int) $article_Taille_Pays_Type;
            $article_Taille = is_null($article_Taille) ? 'NULL' : (int) $article_Taille;
            $article_Matiere = text_sql($article_Matiere);
            $article_Photo_Fichier = text_sql($article_Photo_Fichier);
            $article_Prix = is_null($article_Prix) ? 'NULL' : (float) $article_Prix;
            $article_Actif = ($article_Actif == true ? 1 : 0);
            $requete = "INSERT INTO " . inst('article') . " ( mf_signature, mf_cle_unique, mf_date_creation, mf_date_modification, article_Libelle, article_Description, article_Saison_Type, article_Nom_fournisseur, article_Url, article_Reference, article_Couleur, article_Code_couleur_svg, article_Taille_Pays_Type, article_Taille, article_Matiere, article_Photo_Fichier, article_Prix, article_Actif, Code_sous_categorie_article ) VALUES ( '$mf_signature', '$mf_cle_unique', '".get_now()."', '".get_now()."', '$article_Libelle', '$article_Description', $article_Saison_Type, '$article_Nom_fournisseur', '$article_Url', '$article_Reference', '$article_Couleur', '$article_Code_couleur_svg', $article_Taille_Pays_Type, $article_Taille, '$article_Matiere', '$article_Photo_Fichier', $article_Prix, $article_Actif, $Code_sous_categorie_article );";
            executer_requete_mysql($requete, array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            $Code_article = requete_mysql_insert_id();
            if ($Code_article == 0) {
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
        return ['code_erreur' => $code_erreur, 'Code_article' => $Code_article, 'callback' => ( $code_erreur==0 ? Hook_article::callback_post($Code_article) : null )];
    }

    public function mf_creer(int $Code_sous_categorie_article, ?bool $force = null)
    {
        if ($force === null) {
            $force = false;
        }
        global $mf_initialisation;
        $article_Libelle = $mf_initialisation['article_Libelle'];
        $article_Description = $mf_initialisation['article_Description'];
        $article_Saison_Type = $mf_initialisation['article_Saison_Type'];
        $article_Nom_fournisseur = $mf_initialisation['article_Nom_fournisseur'];
        $article_Url = $mf_initialisation['article_Url'];
        $article_Reference = $mf_initialisation['article_Reference'];
        $article_Couleur = $mf_initialisation['article_Couleur'];
        $article_Code_couleur_svg = $mf_initialisation['article_Code_couleur_svg'];
        $article_Taille_Pays_Type = $mf_initialisation['article_Taille_Pays_Type'];
        $article_Taille = $mf_initialisation['article_Taille'];
        $article_Matiere = $mf_initialisation['article_Matiere'];
        $article_Photo_Fichier = $mf_initialisation['article_Photo_Fichier'];
        $article_Prix = $mf_initialisation['article_Prix'];
        $article_Actif = $mf_initialisation['article_Actif'];
        // Typage
        $Code_sous_categorie_article = (int) $Code_sous_categorie_article;
        $article_Libelle = (string) $article_Libelle;
        $article_Description = (string) $article_Description;
        $article_Saison_Type = is_null($article_Saison_Type) || $article_Saison_Type === '' ? null : (int) $article_Saison_Type;
        $article_Nom_fournisseur = (string) $article_Nom_fournisseur;
        $article_Url = (string) $article_Url;
        $article_Reference = (string) $article_Reference;
        $article_Couleur = (string) $article_Couleur;
        $article_Code_couleur_svg = (string) $article_Code_couleur_svg;
        $article_Taille_Pays_Type = is_null($article_Taille_Pays_Type) || $article_Taille_Pays_Type === '' ? null : (int) $article_Taille_Pays_Type;
        $article_Taille = is_null($article_Taille) || $article_Taille === '' ? null : (int) $article_Taille;
        $article_Matiere = (string) $article_Matiere;
        $article_Photo_Fichier = (string) $article_Photo_Fichier;
        $article_Prix = is_null($article_Prix) || $article_Prix === '' ? null : mf_significantDigit((float) str_replace(' ', '', str_replace(',', '.', $article_Prix)), 6);
        $article_Actif = ($article_Actif == true);
        // Fin typage
        return $this->mf_ajouter($article_Libelle, $article_Description, $article_Saison_Type, $article_Nom_fournisseur, $article_Url, $article_Reference, $article_Couleur, $article_Code_couleur_svg, $article_Taille_Pays_Type, $article_Taille, $article_Matiere, $article_Photo_Fichier, $article_Prix, $article_Actif, $Code_sous_categorie_article, $force);
    }

    public function mf_ajouter_2(array $ligne, bool $force = null) // array('colonne1' => 'valeur1',  [...] )
    {
        if ($force === null) {
            $force = false;
        }
        global $mf_initialisation;
        $Code_sous_categorie_article = (isset($ligne['Code_sous_categorie_article']) ? $ligne['Code_sous_categorie_article'] : 0);
        $article_Libelle = (isset($ligne['article_Libelle'])?$ligne['article_Libelle']:$mf_initialisation['article_Libelle']);
        $article_Description = (isset($ligne['article_Description'])?$ligne['article_Description']:$mf_initialisation['article_Description']);
        $article_Saison_Type = (isset($ligne['article_Saison_Type'])?$ligne['article_Saison_Type']:$mf_initialisation['article_Saison_Type']);
        $article_Nom_fournisseur = (isset($ligne['article_Nom_fournisseur'])?$ligne['article_Nom_fournisseur']:$mf_initialisation['article_Nom_fournisseur']);
        $article_Url = (isset($ligne['article_Url'])?$ligne['article_Url']:$mf_initialisation['article_Url']);
        $article_Reference = (isset($ligne['article_Reference'])?$ligne['article_Reference']:$mf_initialisation['article_Reference']);
        $article_Couleur = (isset($ligne['article_Couleur'])?$ligne['article_Couleur']:$mf_initialisation['article_Couleur']);
        $article_Code_couleur_svg = (isset($ligne['article_Code_couleur_svg'])?$ligne['article_Code_couleur_svg']:$mf_initialisation['article_Code_couleur_svg']);
        $article_Taille_Pays_Type = (isset($ligne['article_Taille_Pays_Type'])?$ligne['article_Taille_Pays_Type']:$mf_initialisation['article_Taille_Pays_Type']);
        $article_Taille = (isset($ligne['article_Taille'])?$ligne['article_Taille']:$mf_initialisation['article_Taille']);
        $article_Matiere = (isset($ligne['article_Matiere'])?$ligne['article_Matiere']:$mf_initialisation['article_Matiere']);
        $article_Photo_Fichier = (isset($ligne['article_Photo_Fichier'])?$ligne['article_Photo_Fichier']:$mf_initialisation['article_Photo_Fichier']);
        $article_Prix = (isset($ligne['article_Prix'])?$ligne['article_Prix']:$mf_initialisation['article_Prix']);
        $article_Actif = (isset($ligne['article_Actif'])?$ligne['article_Actif']:$mf_initialisation['article_Actif']);
        // Typage
        $Code_sous_categorie_article = (int) $Code_sous_categorie_article;
        $article_Libelle = (string) $article_Libelle;
        $article_Description = (string) $article_Description;
        $article_Saison_Type = is_null($article_Saison_Type) || $article_Saison_Type === '' ? null : (int) $article_Saison_Type;
        $article_Nom_fournisseur = (string) $article_Nom_fournisseur;
        $article_Url = (string) $article_Url;
        $article_Reference = (string) $article_Reference;
        $article_Couleur = (string) $article_Couleur;
        $article_Code_couleur_svg = (string) $article_Code_couleur_svg;
        $article_Taille_Pays_Type = is_null($article_Taille_Pays_Type) || $article_Taille_Pays_Type === '' ? null : (int) $article_Taille_Pays_Type;
        $article_Taille = is_null($article_Taille) || $article_Taille === '' ? null : (int) $article_Taille;
        $article_Matiere = (string) $article_Matiere;
        $article_Photo_Fichier = (string) $article_Photo_Fichier;
        $article_Prix = is_null($article_Prix) || $article_Prix === '' ? null : mf_significantDigit((float) str_replace(' ', '', str_replace(',', '.', $article_Prix)), 6);
        $article_Actif = ($article_Actif == true);
        // Fin typage
        return $this->mf_ajouter($article_Libelle, $article_Description, $article_Saison_Type, $article_Nom_fournisseur, $article_Url, $article_Reference, $article_Couleur, $article_Code_couleur_svg, $article_Taille_Pays_Type, $article_Taille, $article_Matiere, $article_Photo_Fichier, $article_Prix, $article_Actif, $Code_sous_categorie_article, $force);
    }

    public function mf_ajouter_3(array $lignes) // array( array( 'colonne1' => 'valeur1', 'colonne2' => 'valeur2',  [...] ), [...] )
    {
        global $mf_initialisation;
        $code_erreur = 0;
        $values = '';
        foreach ($lignes as $ligne) {
            $Code_sous_categorie_article = (int) (isset($ligne['Code_sous_categorie_article']) ? intval($ligne['Code_sous_categorie_article']) : 0);
            $article_Libelle = text_sql((isset($ligne['article_Libelle']) ? $ligne['article_Libelle'] : $mf_initialisation['article_Libelle']));
            $article_Description = text_sql((isset($ligne['article_Description']) ? $ligne['article_Description'] : $mf_initialisation['article_Description']));
            $article_Saison_Type = is_null((isset($ligne['article_Saison_Type']) ? $ligne['article_Saison_Type'] : $mf_initialisation['article_Saison_Type'])) ? 'NULL' : (int) (isset($ligne['article_Saison_Type']) ? $ligne['article_Saison_Type'] : $mf_initialisation['article_Saison_Type']);
            $article_Nom_fournisseur = text_sql((isset($ligne['article_Nom_fournisseur']) ? $ligne['article_Nom_fournisseur'] : $mf_initialisation['article_Nom_fournisseur']));
            $article_Url = text_sql((isset($ligne['article_Url']) ? $ligne['article_Url'] : $mf_initialisation['article_Url']));
            $article_Reference = text_sql((isset($ligne['article_Reference']) ? $ligne['article_Reference'] : $mf_initialisation['article_Reference']));
            $article_Couleur = text_sql((isset($ligne['article_Couleur']) ? $ligne['article_Couleur'] : $mf_initialisation['article_Couleur']));
            $article_Code_couleur_svg = text_sql((isset($ligne['article_Code_couleur_svg']) ? $ligne['article_Code_couleur_svg'] : $mf_initialisation['article_Code_couleur_svg']));
            $article_Taille_Pays_Type = is_null((isset($ligne['article_Taille_Pays_Type']) ? $ligne['article_Taille_Pays_Type'] : $mf_initialisation['article_Taille_Pays_Type'])) ? 'NULL' : (int) (isset($ligne['article_Taille_Pays_Type']) ? $ligne['article_Taille_Pays_Type'] : $mf_initialisation['article_Taille_Pays_Type']);
            $article_Taille = is_null((isset($ligne['article_Taille']) ? $ligne['article_Taille'] : $mf_initialisation['article_Taille'])) ? 'NULL' : (int) (isset($ligne['article_Taille']) ? $ligne['article_Taille'] : $mf_initialisation['article_Taille']);
            $article_Matiere = text_sql((isset($ligne['article_Matiere']) ? $ligne['article_Matiere'] : $mf_initialisation['article_Matiere']));
            $article_Photo_Fichier = text_sql((isset($ligne['article_Photo_Fichier']) ? $ligne['article_Photo_Fichier'] : $mf_initialisation['article_Photo_Fichier']));
            $article_Prix = is_null((isset($ligne['article_Prix']) ? $ligne['article_Prix'] : $mf_initialisation['article_Prix'])) ? 'NULL' : (float) (isset($ligne['article_Prix']) ? $ligne['article_Prix'] : $mf_initialisation['article_Prix']);
            $article_Actif = ((isset($ligne['article_Actif']) ? $ligne['article_Actif'] : $mf_initialisation['article_Actif']) == true ? 1 : 0);
            if ($Code_sous_categorie_article != 0) {
                $values .= ($values != '' ? ',' : '') . "('$article_Libelle', '$article_Description', $article_Saison_Type, '$article_Nom_fournisseur', '$article_Url', '$article_Reference', '$article_Couleur', '$article_Code_couleur_svg', $article_Taille_Pays_Type, $article_Taille, '$article_Matiere', '$article_Photo_Fichier', $article_Prix, $article_Actif, $Code_sous_categorie_article)";
            }
        }
        if ($values != '') {
            $requete = "INSERT INTO " . inst('article') . " ( article_Libelle, article_Description, article_Saison_Type, article_Nom_fournisseur, article_Url, article_Reference, article_Couleur, article_Code_couleur_svg, article_Taille_Pays_Type, article_Taille, article_Matiere, article_Photo_Fichier, article_Prix, article_Actif, Code_sous_categorie_article ) VALUES $values;";
            executer_requete_mysql( $requete , array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            $n = requete_mysqli_affected_rows();
            if ($n < count($lignes)) {
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
        return ['code_erreur' => $code_erreur];
    }

    public function mf_actualiser_signature(int $Code_article)
    {
        $article = $this->mf_get_2($Code_article, ['autocompletion' => false]);
        $mf_signature = text_sql(Hook_article::calcul_signature($article['article_Libelle'], $article['article_Description'], $article['article_Saison_Type'], $article['article_Nom_fournisseur'], $article['article_Url'], $article['article_Reference'], $article['article_Couleur'], $article['article_Code_couleur_svg'], $article['article_Taille_Pays_Type'], $article['article_Taille'], $article['article_Matiere'], $article['article_Photo_Fichier'], $article['article_Prix'], $article['article_Actif'], $article['Code_sous_categorie_article']));
        $mf_cle_unique = text_sql(Hook_article::calcul_cle_unique($article['article_Libelle'], $article['article_Description'], $article['article_Saison_Type'], $article['article_Nom_fournisseur'], $article['article_Url'], $article['article_Reference'], $article['article_Couleur'], $article['article_Code_couleur_svg'], $article['article_Taille_Pays_Type'], $article['article_Taille'], $article['article_Matiere'], $article['article_Photo_Fichier'], $article['article_Prix'], $article['article_Actif'], $article['Code_sous_categorie_article']));
        $table = inst('article');
        executer_requete_mysql("UPDATE $table SET mf_signature='$mf_signature', mf_cle_unique='$mf_cle_unique' WHERE Code_article=$Code_article;", array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        if (requete_mysqli_affected_rows() == 1) {
            self::$cache_db->clear();
        }
    }

    public function mf_modifier( int $Code_article, string $article_Libelle, string $article_Description, ?int $article_Saison_Type, string $article_Nom_fournisseur, string $article_Url, string $article_Reference, string $article_Couleur, string $article_Code_couleur_svg, ?int $article_Taille_Pays_Type, ?int $article_Taille, string $article_Matiere, string $article_Photo_Fichier, ?float $article_Prix, bool $article_Actif, int $Code_sous_categorie_article, ?bool $force = null)
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        // Typage
        $article_Libelle = (string) $article_Libelle;
        $article_Description = (string) $article_Description;
        $article_Saison_Type = is_null($article_Saison_Type) || $article_Saison_Type === '' ? null : (int) $article_Saison_Type;
        $article_Nom_fournisseur = (string) $article_Nom_fournisseur;
        $article_Url = (string) $article_Url;
        $article_Reference = (string) $article_Reference;
        $article_Couleur = (string) $article_Couleur;
        $article_Code_couleur_svg = (string) $article_Code_couleur_svg;
        $article_Taille_Pays_Type = is_null($article_Taille_Pays_Type) || $article_Taille_Pays_Type === '' ? null : (int) $article_Taille_Pays_Type;
        $article_Taille = is_null($article_Taille) || $article_Taille === '' ? null : (int) $article_Taille;
        $article_Matiere = (string) $article_Matiere;
        $article_Photo_Fichier = (string) $article_Photo_Fichier;
        $article_Prix = is_null($article_Prix) || $article_Prix === '' ? null : mf_significantDigit((float) str_replace(' ', '', str_replace(',', '.', $article_Prix)), 6);
        $article_Actif = ($article_Actif == true);
        // Fin typage
        Hook_article::pre_controller($article_Libelle, $article_Description, $article_Saison_Type, $article_Nom_fournisseur, $article_Url, $article_Reference, $article_Couleur, $article_Code_couleur_svg, $article_Taille_Pays_Type, $article_Taille, $article_Matiere, $article_Photo_Fichier, $article_Prix, $article_Actif, $Code_sous_categorie_article, $Code_article);
        if (! $force) {
            if (! self::$maj_droits_modifier_en_cours) {
                self::$maj_droits_modifier_en_cours = true;
                Hook_article::hook_actualiser_les_droits_modifier($Code_article);
                self::$maj_droits_modifier_en_cours = false;
            }
        }
        $article = $this->mf_get_2( $Code_article, ['autocompletion' => false, 'masquer_mdp' => false]);
        if ( !$force && !mf_matrice_droits(['article__MODIFIER']) ) $code_erreur = REFUS_ARTICLE__MODIFIER;
        elseif (! $this->mf_tester_existance_Code_article($Code_article)) $code_erreur = ERR_ARTICLE__MODIFIER__CODE_ARTICLE_INEXISTANT;
        elseif ($Code_sous_categorie_article != 0 && ! $this->mf_tester_existance_Code_sous_categorie_article($Code_sous_categorie_article)) $code_erreur = ERR_ARTICLE__MODIFIER__CODE_SOUS_CATEGORIE_ARTICLE_INEXISTANT;
        elseif (CONTROLE_ACCES_DONNEES_DEFAUT && ! Hook_mf_systeme::controle_acces_donnees('Code_article', $Code_article)) $code_erreur = ACCES_CODE_ARTICLE_REFUSE;
        elseif ($Code_sous_categorie_article != 0 && CONTROLE_ACCES_DONNEES_DEFAUT && ! Hook_mf_systeme::controle_acces_donnees('Code_sous_categorie_article', $Code_sous_categorie_article)) $code_erreur = ACCES_CODE_SOUS_CATEGORIE_ARTICLE_REFUSE;
        elseif ( !Hook_article::autorisation_modification($Code_article, $article_Libelle, $article_Description, $article_Saison_Type, $article_Nom_fournisseur, $article_Url, $article_Reference, $article_Couleur, $article_Code_couleur_svg, $article_Taille_Pays_Type, $article_Taille, $article_Matiere, $article_Photo_Fichier, $article_Prix, $article_Actif, $Code_sous_categorie_article) ) $code_erreur = REFUS_ARTICLE__MODIFICATION_BLOQUEE;
        elseif (! in_array($article_Saison_Type, liste_union_A_et_B([$article_Saison_Type], Hook_article::workflow__article_Saison_Type($article['article_Saison_Type'])))) $code_erreur = ERR_ARTICLE__MODIFIER__ARTICLE_SAISON_TYPE__HORS_WORKFLOW;
        elseif (! controle_parametre("article_Saison_Type", $article_Saison_Type)) $code_erreur = ERR_ARTICLE__MODIFIER__ARTICLE_SAISON_TYPE_NON_VALIDE;
        elseif (! in_array($article_Taille_Pays_Type, liste_union_A_et_B([$article_Taille_Pays_Type], Hook_article::workflow__article_Taille_Pays_Type($article['article_Taille_Pays_Type'])))) $code_erreur = ERR_ARTICLE__MODIFIER__ARTICLE_TAILLE_PAYS_TYPE__HORS_WORKFLOW;
        elseif (! controle_parametre("article_Taille_Pays_Type", $article_Taille_Pays_Type)) $code_erreur = ERR_ARTICLE__MODIFIER__ARTICLE_TAILLE_PAYS_TYPE_NON_VALIDE;
        else {
            if (! isset(self::$lock[$Code_article])) {
                self::$lock[$Code_article] = 0;
            }
            if (self::$lock[$Code_article] == 0) {
                self::$cache_db->add_lock((string) $Code_article);
            }
            self::$lock[$Code_article]++;
            Hook_article::data_controller($article_Libelle, $article_Description, $article_Saison_Type, $article_Nom_fournisseur, $article_Url, $article_Reference, $article_Couleur, $article_Code_couleur_svg, $article_Taille_Pays_Type, $article_Taille, $article_Matiere, $article_Photo_Fichier, $article_Prix, $article_Actif, $Code_sous_categorie_article, $Code_article);
            $mf_colonnes_a_modifier=[];
            $bool__article_Libelle = false; if ($article_Libelle !== $article['article_Libelle']) {Hook_article::data_controller__article_Libelle($article['article_Libelle'], $article_Libelle, $Code_article); if ( $article_Libelle !== $article['article_Libelle'] ) { $mf_colonnes_a_modifier[] = 'article_Libelle=' . format_sql('article_Libelle', $article_Libelle); $bool__article_Libelle = true;}}
            $bool__article_Description = false; if ($article_Description !== $article['article_Description']) {Hook_article::data_controller__article_Description($article['article_Description'], $article_Description, $Code_article); if ( $article_Description !== $article['article_Description'] ) { $mf_colonnes_a_modifier[] = 'article_Description=' . format_sql('article_Description', $article_Description); $bool__article_Description = true;}}
            $bool__article_Saison_Type = false; if ($article_Saison_Type !== $article['article_Saison_Type']) {Hook_article::data_controller__article_Saison_Type($article['article_Saison_Type'], $article_Saison_Type, $Code_article); if ( $article_Saison_Type !== $article['article_Saison_Type'] ) { $mf_colonnes_a_modifier[] = 'article_Saison_Type=' . format_sql('article_Saison_Type', $article_Saison_Type); $bool__article_Saison_Type = true;}}
            $bool__article_Nom_fournisseur = false; if ($article_Nom_fournisseur !== $article['article_Nom_fournisseur']) {Hook_article::data_controller__article_Nom_fournisseur($article['article_Nom_fournisseur'], $article_Nom_fournisseur, $Code_article); if ( $article_Nom_fournisseur !== $article['article_Nom_fournisseur'] ) { $mf_colonnes_a_modifier[] = 'article_Nom_fournisseur=' . format_sql('article_Nom_fournisseur', $article_Nom_fournisseur); $bool__article_Nom_fournisseur = true;}}
            $bool__article_Url = false; if ($article_Url !== $article['article_Url']) {Hook_article::data_controller__article_Url($article['article_Url'], $article_Url, $Code_article); if ( $article_Url !== $article['article_Url'] ) { $mf_colonnes_a_modifier[] = 'article_Url=' . format_sql('article_Url', $article_Url); $bool__article_Url = true;}}
            $bool__article_Reference = false; if ($article_Reference !== $article['article_Reference']) {Hook_article::data_controller__article_Reference($article['article_Reference'], $article_Reference, $Code_article); if ( $article_Reference !== $article['article_Reference'] ) { $mf_colonnes_a_modifier[] = 'article_Reference=' . format_sql('article_Reference', $article_Reference); $bool__article_Reference = true;}}
            $bool__article_Couleur = false; if ($article_Couleur !== $article['article_Couleur']) {Hook_article::data_controller__article_Couleur($article['article_Couleur'], $article_Couleur, $Code_article); if ( $article_Couleur !== $article['article_Couleur'] ) { $mf_colonnes_a_modifier[] = 'article_Couleur=' . format_sql('article_Couleur', $article_Couleur); $bool__article_Couleur = true;}}
            $bool__article_Code_couleur_svg = false; if ($article_Code_couleur_svg !== $article['article_Code_couleur_svg']) {Hook_article::data_controller__article_Code_couleur_svg($article['article_Code_couleur_svg'], $article_Code_couleur_svg, $Code_article); if ( $article_Code_couleur_svg !== $article['article_Code_couleur_svg'] ) { $mf_colonnes_a_modifier[] = 'article_Code_couleur_svg=' . format_sql('article_Code_couleur_svg', $article_Code_couleur_svg); $bool__article_Code_couleur_svg = true;}}
            $bool__article_Taille_Pays_Type = false; if ($article_Taille_Pays_Type !== $article['article_Taille_Pays_Type']) {Hook_article::data_controller__article_Taille_Pays_Type($article['article_Taille_Pays_Type'], $article_Taille_Pays_Type, $Code_article); if ( $article_Taille_Pays_Type !== $article['article_Taille_Pays_Type'] ) { $mf_colonnes_a_modifier[] = 'article_Taille_Pays_Type=' . format_sql('article_Taille_Pays_Type', $article_Taille_Pays_Type); $bool__article_Taille_Pays_Type = true;}}
            $bool__article_Taille = false; if ($article_Taille !== $article['article_Taille']) {Hook_article::data_controller__article_Taille($article['article_Taille'], $article_Taille, $Code_article); if ( $article_Taille !== $article['article_Taille'] ) { $mf_colonnes_a_modifier[] = 'article_Taille=' . format_sql('article_Taille', $article_Taille); $bool__article_Taille = true;}}
            $bool__article_Matiere = false; if ($article_Matiere !== $article['article_Matiere']) {Hook_article::data_controller__article_Matiere($article['article_Matiere'], $article_Matiere, $Code_article); if ( $article_Matiere !== $article['article_Matiere'] ) { $mf_colonnes_a_modifier[] = 'article_Matiere=' . format_sql('article_Matiere', $article_Matiere); $bool__article_Matiere = true;}}
            $bool__article_Photo_Fichier = false; if ($article_Photo_Fichier !== $article['article_Photo_Fichier']) {Hook_article::data_controller__article_Photo_Fichier($article['article_Photo_Fichier'], $article_Photo_Fichier, $Code_article); if ( $article_Photo_Fichier !== $article['article_Photo_Fichier'] ) { $mf_colonnes_a_modifier[] = 'article_Photo_Fichier=' . format_sql('article_Photo_Fichier', $article_Photo_Fichier); $bool__article_Photo_Fichier = true;}}
            $bool__article_Prix = false; if ($article_Prix !== $article['article_Prix']) {Hook_article::data_controller__article_Prix($article['article_Prix'], $article_Prix, $Code_article); if ( $article_Prix !== $article['article_Prix'] ) { $mf_colonnes_a_modifier[] = 'article_Prix=' . format_sql('article_Prix', $article_Prix); $bool__article_Prix = true;}}
            $bool__article_Actif = false; if ($article_Actif !== $article['article_Actif']) {Hook_article::data_controller__article_Actif($article['article_Actif'], $article_Actif, $Code_article); if ( $article_Actif !== $article['article_Actif'] ) { $mf_colonnes_a_modifier[] = 'article_Actif=' . format_sql('article_Actif', $article_Actif); $bool__article_Actif = true;}}
            $bool__Code_sous_categorie_article = false; if ($Code_sous_categorie_article != 0 && $Code_sous_categorie_article != $article['Code_sous_categorie_article'] ) { Hook_article::data_controller__Code_sous_categorie_article($article['Code_sous_categorie_article'], $Code_sous_categorie_article, $Code_article); if ( $Code_sous_categorie_article != 0 && $Code_sous_categorie_article != $article['Code_sous_categorie_article'] ) { $mf_colonnes_a_modifier[] = 'Code_sous_categorie_article = ' . $Code_sous_categorie_article; $bool__Code_sous_categorie_article = true; } }
            if (count($mf_colonnes_a_modifier) > 0) {
                $mf_signature = text_sql(Hook_article::calcul_signature($article_Libelle, $article_Description, $article_Saison_Type, $article_Nom_fournisseur, $article_Url, $article_Reference, $article_Couleur, $article_Code_couleur_svg, $article_Taille_Pays_Type, $article_Taille, $article_Matiere, $article_Photo_Fichier, $article_Prix, $article_Actif, $Code_sous_categorie_article));
                $mf_cle_unique = text_sql(Hook_article::calcul_cle_unique($article_Libelle, $article_Description, $article_Saison_Type, $article_Nom_fournisseur, $article_Url, $article_Reference, $article_Couleur, $article_Code_couleur_svg, $article_Taille_Pays_Type, $article_Taille, $article_Matiere, $article_Photo_Fichier, $article_Prix, $article_Actif, $Code_sous_categorie_article));
                $mf_colonnes_a_modifier[] = 'mf_signature=\'' . $mf_signature . '\'';
                $mf_colonnes_a_modifier[] = 'mf_cle_unique=\'' . $mf_cle_unique . '\'';
                $mf_colonnes_a_modifier[] = 'mf_date_modification=\'' . get_now() . '\'';
                $requete = 'UPDATE '.inst('article').' SET ' . enumeration($mf_colonnes_a_modifier) . ' WHERE Code_article = ' . $Code_article . ';';
                executer_requete_mysql($requete, array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
                if (requete_mysqli_affected_rows() == 0) {
                    $code_erreur = ERR_ARTICLE__MODIFIER__AUCUN_CHANGEMENT;
                } else {
                    self::$cache_db->clear();
                    Hook_article::modifier($Code_article, $bool__article_Libelle, $bool__article_Description, $bool__article_Saison_Type, $bool__article_Nom_fournisseur, $bool__article_Url, $bool__article_Reference, $bool__article_Couleur, $bool__article_Code_couleur_svg, $bool__article_Taille_Pays_Type, $bool__article_Taille, $bool__article_Matiere, $bool__article_Photo_Fichier, $bool__article_Prix, $bool__article_Actif, $bool__Code_sous_categorie_article);
                }
            } else {
                $code_erreur = ERR_ARTICLE__MODIFIER__AUCUN_CHANGEMENT;
            }
            self::$lock[$Code_article]--;
            if (self::$lock[$Code_article] == 0) {
                self::$cache_db->release_lock((string) $Code_article);
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
        return ['code_erreur' => $code_erreur, 'callback' => ($code_erreur == 0 ? Hook_article::callback_put($Code_article) : null)];
    }

    public function mf_modifier_2(array $lignes, ?bool $force = null) // array( $Code_article => array('colonne1' => 'valeur1',  [...] ) )
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        foreach ($lignes as $Code_article => $colonnes) {
            if ($code_erreur == 0) {
                $Code_article = intval($Code_article);
                $article = $this->mf_get_2($Code_article, ['autocompletion' => false]);
                if (! $force) {
                    if (! self::$maj_droits_modifier_en_cours) {
                        self::$maj_droits_modifier_en_cours = true;
                        Hook_article::hook_actualiser_les_droits_modifier($Code_article);
                        self::$maj_droits_modifier_en_cours = false;
                    }
                }
                $Code_sous_categorie_article = (isset($colonnes['Code_sous_categorie_article']) && ( $force || mf_matrice_droits(['api_modifier_ref__article__Code_sous_categorie_article', 'article__MODIFIER']) ) ? $colonnes['Code_sous_categorie_article'] : (isset($article['Code_sous_categorie_article']) ? $article['Code_sous_categorie_article'] : 0 ));
                $article_Libelle = (isset($colonnes['article_Libelle']) && ( $force || mf_matrice_droits(['api_modifier__article_Libelle', 'article__MODIFIER']) ) ? $colonnes['article_Libelle'] : ( isset($article['article_Libelle']) ? $article['article_Libelle'] : '' ) );
                $article_Description = (isset($colonnes['article_Description']) && ( $force || mf_matrice_droits(['api_modifier__article_Description', 'article__MODIFIER']) ) ? $colonnes['article_Description'] : ( isset($article['article_Description']) ? $article['article_Description'] : '' ) );
                $article_Saison_Type = (isset($colonnes['article_Saison_Type']) && ( $force || mf_matrice_droits(['api_modifier__article_Saison_Type', 'article__MODIFIER']) ) ? $colonnes['article_Saison_Type'] : ( isset($article['article_Saison_Type']) ? $article['article_Saison_Type'] : '' ) );
                $article_Nom_fournisseur = (isset($colonnes['article_Nom_fournisseur']) && ( $force || mf_matrice_droits(['api_modifier__article_Nom_fournisseur', 'article__MODIFIER']) ) ? $colonnes['article_Nom_fournisseur'] : ( isset($article['article_Nom_fournisseur']) ? $article['article_Nom_fournisseur'] : '' ) );
                $article_Url = (isset($colonnes['article_Url']) && ( $force || mf_matrice_droits(['api_modifier__article_Url', 'article__MODIFIER']) ) ? $colonnes['article_Url'] : ( isset($article['article_Url']) ? $article['article_Url'] : '' ) );
                $article_Reference = (isset($colonnes['article_Reference']) && ( $force || mf_matrice_droits(['api_modifier__article_Reference', 'article__MODIFIER']) ) ? $colonnes['article_Reference'] : ( isset($article['article_Reference']) ? $article['article_Reference'] : '' ) );
                $article_Couleur = (isset($colonnes['article_Couleur']) && ( $force || mf_matrice_droits(['api_modifier__article_Couleur', 'article__MODIFIER']) ) ? $colonnes['article_Couleur'] : ( isset($article['article_Couleur']) ? $article['article_Couleur'] : '' ) );
                $article_Code_couleur_svg = (isset($colonnes['article_Code_couleur_svg']) && ( $force || mf_matrice_droits(['api_modifier__article_Code_couleur_svg', 'article__MODIFIER']) ) ? $colonnes['article_Code_couleur_svg'] : ( isset($article['article_Code_couleur_svg']) ? $article['article_Code_couleur_svg'] : '' ) );
                $article_Taille_Pays_Type = (isset($colonnes['article_Taille_Pays_Type']) && ( $force || mf_matrice_droits(['api_modifier__article_Taille_Pays_Type', 'article__MODIFIER']) ) ? $colonnes['article_Taille_Pays_Type'] : ( isset($article['article_Taille_Pays_Type']) ? $article['article_Taille_Pays_Type'] : '' ) );
                $article_Taille = (isset($colonnes['article_Taille']) && ( $force || mf_matrice_droits(['api_modifier__article_Taille', 'article__MODIFIER']) ) ? $colonnes['article_Taille'] : ( isset($article['article_Taille']) ? $article['article_Taille'] : '' ) );
                $article_Matiere = (isset($colonnes['article_Matiere']) && ( $force || mf_matrice_droits(['api_modifier__article_Matiere', 'article__MODIFIER']) ) ? $colonnes['article_Matiere'] : ( isset($article['article_Matiere']) ? $article['article_Matiere'] : '' ) );
                $article_Photo_Fichier = (isset($colonnes['article_Photo_Fichier']) && ( $force || mf_matrice_droits(['api_modifier__article_Photo_Fichier', 'article__MODIFIER']) ) ? $colonnes['article_Photo_Fichier'] : ( isset($article['article_Photo_Fichier']) ? $article['article_Photo_Fichier'] : '' ) );
                $article_Prix = (isset($colonnes['article_Prix']) && ( $force || mf_matrice_droits(['api_modifier__article_Prix', 'article__MODIFIER']) ) ? $colonnes['article_Prix'] : ( isset($article['article_Prix']) ? $article['article_Prix'] : '' ) );
                $article_Actif = (isset($colonnes['article_Actif']) && ( $force || mf_matrice_droits(['api_modifier__article_Actif', 'article__MODIFIER']) ) ? $colonnes['article_Actif'] : ( isset($article['article_Actif']) ? $article['article_Actif'] : '' ) );
                // Typage
                $Code_sous_categorie_article = (int) $Code_sous_categorie_article;
                $article_Libelle = (string) $article_Libelle;
                $article_Description = (string) $article_Description;
                $article_Saison_Type = is_null($article_Saison_Type) || $article_Saison_Type === '' ? null : (int) $article_Saison_Type;
                $article_Nom_fournisseur = (string) $article_Nom_fournisseur;
                $article_Url = (string) $article_Url;
                $article_Reference = (string) $article_Reference;
                $article_Couleur = (string) $article_Couleur;
                $article_Code_couleur_svg = (string) $article_Code_couleur_svg;
                $article_Taille_Pays_Type = is_null($article_Taille_Pays_Type) || $article_Taille_Pays_Type === '' ? null : (int) $article_Taille_Pays_Type;
                $article_Taille = is_null($article_Taille) || $article_Taille === '' ? null : (int) $article_Taille;
                $article_Matiere = (string) $article_Matiere;
                $article_Photo_Fichier = (string) $article_Photo_Fichier;
                $article_Prix = is_null($article_Prix) || $article_Prix === '' ? null : mf_significantDigit((float) str_replace(' ', '', str_replace(',', '.', $article_Prix)), 6);
                $article_Actif = ($article_Actif == true);
                // Fin typage
                $retour = $this->mf_modifier($Code_article, $article_Libelle, $article_Description, $article_Saison_Type, $article_Nom_fournisseur, $article_Url, $article_Reference, $article_Couleur, $article_Code_couleur_svg, $article_Taille_Pays_Type, $article_Taille, $article_Matiere, $article_Photo_Fichier, $article_Prix, $article_Actif, $Code_sous_categorie_article, true);
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
        return ['code_erreur' => $code_erreur];
    }

    public function mf_modifier_3(array $lignes) // array( $Code_article => array('colonne1' => 'valeur1',  [...] ) )
    {
        $code_erreur = 0;
        $modifs = false;

        // transformation des lignes en colonnes
        $valeurs_en_colonnes = [];
        $indices_par_colonne = [];
        $liste_valeurs_indexees = [];
        foreach ($lignes as $Code_article => $colonnes) {
            foreach ($colonnes as $colonne => $valeur) {
                if ($colonne == 'article_Libelle' || $colonne == 'article_Description' || $colonne == 'article_Saison_Type' || $colonne == 'article_Nom_fournisseur' || $colonne == 'article_Url' || $colonne == 'article_Reference' || $colonne == 'article_Couleur' || $colonne == 'article_Code_couleur_svg' || $colonne == 'article_Taille_Pays_Type' || $colonne == 'article_Taille' || $colonne == 'article_Matiere' || $colonne == 'article_Photo_Fichier' || $colonne == 'article_Prix' || $colonne == 'article_Actif' || $colonne == 'Code_sous_categorie_article') {
                    $valeurs_en_colonnes[$colonne][$Code_article] = $valeur;
                    $indices_par_colonne[$colonne][] = $Code_article;
                    $liste_valeurs_indexees[$colonne]["$valeur"][] = $Code_article;
                }
            }
        }

        // fabrication des requetes
        foreach ($valeurs_en_colonnes as $colonne => $valeurs) {
            if (count($liste_valeurs_indexees[$colonne]) > 3) {
                $modification_sql = $colonne . ' = CASE Code_article';
                foreach ($valeurs as $Code_article => $valeur) {
                    $modification_sql .= ' WHEN ' . $Code_article . ' THEN ' . format_sql($colonne, $valeur);
                }
                $modification_sql .= ' END';
                $perimetre = Sql_Format_Liste($indices_par_colonne[$colonne]);
                executer_requete_mysql('UPDATE ' . inst('article') . ' SET ' . $modification_sql . ' WHERE Code_article IN ' . $perimetre . ';', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
                if (requete_mysqli_affected_rows() != 0) {
                    $modifs = true;
                }
            } else {
                foreach ($liste_valeurs_indexees[$colonne] as $valeur => $indices_par_valeur) {
                    $perimetre = Sql_Format_Liste($indices_par_valeur);
                    executer_requete_mysql('UPDATE ' . inst('article') . ' SET ' . $colonne . ' = ' . format_sql($colonne, $valeur) . ' WHERE Code_article IN ' . $perimetre . ';', array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
                    if (requete_mysqli_affected_rows() != 0) {
                        $modifs = true;
                    }
                }
            }
        }

        if (! $modifs && $code_erreur == 0) {
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
        return ['code_erreur' => $code_erreur];
    }

    public function mf_modifier_4( int $Code_sous_categorie_article, array $data, ?array $options = null /* $options = array( 'cond_mysql' => [], 'limit' => 0 ) */ ) // $data = array('colonne1' => 'valeur1', ... )
    {
        $code_erreur = 0;
        $Code_sous_categorie_article = intval($Code_sous_categorie_article);
        $mf_colonnes_a_modifier=[];
        if (isset($data['article_Libelle']) || array_key_exists('article_Libelle', $data)) { $mf_colonnes_a_modifier[] = 'article_Libelle = ' . format_sql('article_Libelle', $data['article_Libelle']); }
        if (isset($data['article_Description']) || array_key_exists('article_Description', $data)) { $mf_colonnes_a_modifier[] = 'article_Description = ' . format_sql('article_Description', $data['article_Description']); }
        if (isset($data['article_Saison_Type']) || array_key_exists('article_Saison_Type', $data)) { $mf_colonnes_a_modifier[] = 'article_Saison_Type = ' . format_sql('article_Saison_Type', $data['article_Saison_Type']); }
        if (isset($data['article_Nom_fournisseur']) || array_key_exists('article_Nom_fournisseur', $data)) { $mf_colonnes_a_modifier[] = 'article_Nom_fournisseur = ' . format_sql('article_Nom_fournisseur', $data['article_Nom_fournisseur']); }
        if (isset($data['article_Url']) || array_key_exists('article_Url', $data)) { $mf_colonnes_a_modifier[] = 'article_Url = ' . format_sql('article_Url', $data['article_Url']); }
        if (isset($data['article_Reference']) || array_key_exists('article_Reference', $data)) { $mf_colonnes_a_modifier[] = 'article_Reference = ' . format_sql('article_Reference', $data['article_Reference']); }
        if (isset($data['article_Couleur']) || array_key_exists('article_Couleur', $data)) { $mf_colonnes_a_modifier[] = 'article_Couleur = ' . format_sql('article_Couleur', $data['article_Couleur']); }
        if (isset($data['article_Code_couleur_svg']) || array_key_exists('article_Code_couleur_svg', $data)) { $mf_colonnes_a_modifier[] = 'article_Code_couleur_svg = ' . format_sql('article_Code_couleur_svg', $data['article_Code_couleur_svg']); }
        if (isset($data['article_Taille_Pays_Type']) || array_key_exists('article_Taille_Pays_Type', $data)) { $mf_colonnes_a_modifier[] = 'article_Taille_Pays_Type = ' . format_sql('article_Taille_Pays_Type', $data['article_Taille_Pays_Type']); }
        if (isset($data['article_Taille']) || array_key_exists('article_Taille', $data)) { $mf_colonnes_a_modifier[] = 'article_Taille = ' . format_sql('article_Taille', $data['article_Taille']); }
        if (isset($data['article_Matiere']) || array_key_exists('article_Matiere', $data)) { $mf_colonnes_a_modifier[] = 'article_Matiere = ' . format_sql('article_Matiere', $data['article_Matiere']); }
        if (isset($data['article_Photo_Fichier']) || array_key_exists('article_Photo_Fichier', $data)) { $mf_colonnes_a_modifier[] = 'article_Photo_Fichier = ' . format_sql('article_Photo_Fichier', $data['article_Photo_Fichier']); }
        if (isset($data['article_Prix']) || array_key_exists('article_Prix', $data)) { $mf_colonnes_a_modifier[] = 'article_Prix = ' . format_sql('article_Prix', $data['article_Prix']); }
        if (isset($data['article_Actif']) || array_key_exists('article_Actif', $data)) { $mf_colonnes_a_modifier[] = 'article_Actif = ' . format_sql('article_Actif', $data['article_Actif']); }
        if (isset($data['Code_sous_categorie_article'])) { $mf_colonnes_a_modifier[] = 'Code_sous_categorie_article = ' . round($data['Code_sous_categorie_article']); }
        if (count($mf_colonnes_a_modifier) > 0) {
            // cond_mysql
            $argument_cond = '';
            if (isset($options['cond_mysql'])) {
                foreach ($options['cond_mysql'] as &$condition) {
                    $argument_cond .= ' AND ('.$condition.')';
                }
                unset($condition);
            }

            // limit
            $limit = 0;
            if (isset($options['limit'])) {
                $limit = intval($options['limit']);
            }

            $requete = 'UPDATE ' . inst('article') . ' SET ' . enumeration($mf_colonnes_a_modifier) . " WHERE 1".( $Code_sous_categorie_article!=0 ? " AND Code_sous_categorie_article=$Code_sous_categorie_article" : "" )."$argument_cond" . ( $limit>0 ? ' LIMIT ' . $limit : '' ) . ";";
            executer_requete_mysql( $requete , array_search('article', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            if (requete_mysqli_affected_rows() == 0) {
                $code_erreur = ERR_ARTICLE__MODIFIER_4__AUCUN_CHANGEMENT;
            } else {
                self::$cache_db->clear();
            }
        }
        return ['code_erreur' => $code_erreur];
    }

    public function mf_supprimer(int $Code_article, ?bool $force = null)
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        $Code_article = intval($Code_article);
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
            $copie__article = $this->mf_get($Code_article, ['autocompletion' => false]);
            $this->supprimer_donnes_en_cascade("article", [$Code_article]);
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
        return ['code_erreur' => $code_erreur];
    }

    public function mf_supprimer_2(array $liste_Code_article, ?bool $force = null)
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        $copie__liste_article = $this->mf_lister_2($liste_Code_article, ['autocompletion' => false]);
        $liste_Code_article=[];
        foreach ( $copie__liste_article as $copie__article )
        {
            $Code_article = $copie__article['Code_article'];
            if (! $force) {
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
        if ($code_erreur == 0 && count($liste_Code_article) > 0) {
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
        return ['code_erreur' => $code_erreur];
    }

    public function mf_supprimer_3(array $liste_Code_article)
    {
        $code_erreur = 0;
        if (count($liste_Code_article) > 0) {
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
        return ['code_erreur' => $code_erreur];
    }

    public function mf_lister_contexte(?bool $contexte_parent = null, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'liste_colonnes_a_selectionner' => [], 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
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
            return [$article['Code_article'] => $article];
        } else {
            return $this->mf_lister(isset($est_charge['sous_categorie_article']) ? $mf_contexte['Code_sous_categorie_article'] : 0, $options);
        }
    }

    public function mf_lister(?int $Code_sous_categorie_article = null, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'liste_colonnes_a_selectionner' => [], 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cle = "article__lister";
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
            if ($colonne != 'article_Description') {
                if ( $argument_tris=='' ) { $argument_tris = ' ORDER BY '; } else { $argument_tris .= ', '; }
                if ( $tri!='DESC' ) $tri = 'ASC';
                $argument_tris .= $colonne.' '.$tri;
            }
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

        // liste_colonnes_a_selectionner
        $liste_colonnes_a_selectionner = [];
        if (isset($options['liste_colonnes_a_selectionner'])) {
            $liste_colonnes_a_selectionner = $options['liste_colonnes_a_selectionner'];
        }
        $cle .= '_' . enumeration($liste_colonnes_a_selectionner);

        // afficher toutes les colonnes
        $toutes_colonnes = TOUTES_COLONNES_DEFAUT;
        if (count($liste_colonnes_a_selectionner) == 0) {
            if (isset($options['toutes_colonnes'])) {
                $toutes_colonnes = ($options['toutes_colonnes'] == true);
            }
            $cle .= '_' . ($toutes_colonnes ? '1' : '0');
        }

        // maj
        $maj = true;
        if (isset($options['maj'])) {
            $maj = ($options['maj'] == true);
        }
        $cle .= '_'.( $maj ? '1' : '0' );

        $nouvelle_lecture = true;
        $liste = [];
        while ($nouvelle_lecture) {
            $nouvelle_lecture = false;
            $liste_article_pas_a_jour = [];
            if (false === $liste = self::$cache_db->read($cle)) {

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
                if (isset($options['tris'])) {
                    if ( isset($options['tris']['article_Libelle']) ) { $liste_colonnes_a_indexer['article_Libelle'] = 'article_Libelle'; }
                    if ( isset($options['tris']['article_Saison_Type']) ) { $liste_colonnes_a_indexer['article_Saison_Type'] = 'article_Saison_Type'; }
                    if ( isset($options['tris']['article_Nom_fournisseur']) ) { $liste_colonnes_a_indexer['article_Nom_fournisseur'] = 'article_Nom_fournisseur'; }
                    if ( isset($options['tris']['article_Url']) ) { $liste_colonnes_a_indexer['article_Url'] = 'article_Url'; }
                    if ( isset($options['tris']['article_Reference']) ) { $liste_colonnes_a_indexer['article_Reference'] = 'article_Reference'; }
                    if ( isset($options['tris']['article_Couleur']) ) { $liste_colonnes_a_indexer['article_Couleur'] = 'article_Couleur'; }
                    if ( isset($options['tris']['article_Code_couleur_svg']) ) { $liste_colonnes_a_indexer['article_Code_couleur_svg'] = 'article_Code_couleur_svg'; }
                    if ( isset($options['tris']['article_Taille_Pays_Type']) ) { $liste_colonnes_a_indexer['article_Taille_Pays_Type'] = 'article_Taille_Pays_Type'; }
                    if ( isset($options['tris']['article_Taille']) ) { $liste_colonnes_a_indexer['article_Taille'] = 'article_Taille'; }
                    if ( isset($options['tris']['article_Matiere']) ) { $liste_colonnes_a_indexer['article_Matiere'] = 'article_Matiere'; }
                    if ( isset($options['tris']['article_Photo_Fichier']) ) { $liste_colonnes_a_indexer['article_Photo_Fichier'] = 'article_Photo_Fichier'; }
                    if ( isset($options['tris']['article_Prix']) ) { $liste_colonnes_a_indexer['article_Prix'] = 'article_Prix'; }
                    if ( isset($options['tris']['article_Actif']) ) { $liste_colonnes_a_indexer['article_Actif'] = 'article_Actif'; }
                }
                if (count($liste_colonnes_a_indexer) > 0) {
                    if (false === $mf_liste_requete_index = self::$cache_db->read('article__index')) {
                        $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('article').'`;', false);
                        $mf_liste_requete_index = [];
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

                if (count($liste_colonnes_a_selectionner) == 0) {
                    if ($toutes_colonnes) {
                        $colonnes = 'Code_article, article_Libelle, article_Description, article_Saison_Type, article_Nom_fournisseur, article_Url, article_Reference, article_Couleur, article_Code_couleur_svg, article_Taille_Pays_Type, article_Taille, article_Matiere, article_Photo_Fichier, article_Prix, article_Actif, Code_sous_categorie_article';
                    } else {
                        $colonnes = 'Code_article, article_Libelle, article_Saison_Type, article_Nom_fournisseur, article_Url, article_Reference, article_Couleur, article_Code_couleur_svg, article_Taille_Pays_Type, article_Taille, article_Matiere, article_Photo_Fichier, article_Prix, article_Actif, Code_sous_categorie_article';
                    }
                } else {
                    $liste_colonnes_a_selectionner[] = 'Code_article';
                    $colonnes = enumeration($liste_colonnes_a_selectionner, ',');
                }

                $liste = [];
                $liste_article_pas_a_jour = [];
                $res_requete = executer_requete_mysql("SELECT $colonnes FROM " . inst('article') . " WHERE 1{$argument_cond}".( $Code_sous_categorie_article!=0 ? " AND Code_sous_categorie_article=$Code_sous_categorie_article" : "" )."{$argument_tris}{$argument_limit};", false);
                while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                    mf_formatage_db_type_php($row_requete);
                    $liste[$row_requete['Code_article']] = $row_requete;
                    if ($maj && ! Hook_article::est_a_jour($row_requete)) {
                        $liste_article_pas_a_jour[$row_requete['Code_article']] = $row_requete;
                        $nouvelle_lecture = true;
                    }
                }
                mysqli_free_result($res_requete);
                if (count($options['tris'])==1 && ! $nouvelle_lecture) {
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
            if ($controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_article', $elem['Code_article'])) {
                unset($liste[$elem['Code_article']]);
            } else {
                if (($autocompletion_recursive || self::$auto_completion < 1) && $autocompletion) {
                    self::$auto_completion ++;
                    Hook_article::completion($liste[$elem['Code_article']], self::$auto_completion - 1);
                    self::$auto_completion --;
                }
            }
        }

        return $liste;
    }

    public function mf_lister_2(array $liste_Code_article, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'liste_colonnes_a_selectionner' => [], 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
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
                if ($colonne != 'article_Description') {
                    if ( $argument_tris=='' ) { $argument_tris = ' ORDER BY '; } else { $argument_tris .= ', '; }
                    if ( $tri!='DESC' ) $tri = 'ASC';
                    $argument_tris .= $colonne.' '.$tri;
                }
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

            // liste_colonnes_a_selectionner
            $liste_colonnes_a_selectionner = [];
            if (isset($options['liste_colonnes_a_selectionner'])) {
                $liste_colonnes_a_selectionner = $options['liste_colonnes_a_selectionner'];
            }
            $cle .= '_' . enumeration($liste_colonnes_a_selectionner);

            // afficher toutes les colonnes
            $toutes_colonnes = TOUTES_COLONNES_DEFAUT;
            if (count($liste_colonnes_a_selectionner) == 0) {
                if (isset($options['toutes_colonnes'])) {
                    $toutes_colonnes = ($options['toutes_colonnes'] == true);
                }
                $cle .= '_' . ($toutes_colonnes ? '1' : '0');
            }

            // maj
            $maj = true;
            if (isset($options['maj'])) {
                $maj = ($options['maj'] == true);
            }
            $cle .= '_'.( $maj ? '1' : '0' );

            $nouvelle_lecture = true;
            $liste = [];
            while ($nouvelle_lecture) {
                $nouvelle_lecture = false;
                $liste_article_pas_a_jour = [];
                if (false === $liste = self::$cache_db->read($cle)) {

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
                    if (isset($options['tris'])) {
                        if ( isset($options['tris']['article_Libelle']) ) { $liste_colonnes_a_indexer['article_Libelle'] = 'article_Libelle'; }
                        if ( isset($options['tris']['article_Saison_Type']) ) { $liste_colonnes_a_indexer['article_Saison_Type'] = 'article_Saison_Type'; }
                        if ( isset($options['tris']['article_Nom_fournisseur']) ) { $liste_colonnes_a_indexer['article_Nom_fournisseur'] = 'article_Nom_fournisseur'; }
                        if ( isset($options['tris']['article_Url']) ) { $liste_colonnes_a_indexer['article_Url'] = 'article_Url'; }
                        if ( isset($options['tris']['article_Reference']) ) { $liste_colonnes_a_indexer['article_Reference'] = 'article_Reference'; }
                        if ( isset($options['tris']['article_Couleur']) ) { $liste_colonnes_a_indexer['article_Couleur'] = 'article_Couleur'; }
                        if ( isset($options['tris']['article_Code_couleur_svg']) ) { $liste_colonnes_a_indexer['article_Code_couleur_svg'] = 'article_Code_couleur_svg'; }
                        if ( isset($options['tris']['article_Taille_Pays_Type']) ) { $liste_colonnes_a_indexer['article_Taille_Pays_Type'] = 'article_Taille_Pays_Type'; }
                        if ( isset($options['tris']['article_Taille']) ) { $liste_colonnes_a_indexer['article_Taille'] = 'article_Taille'; }
                        if ( isset($options['tris']['article_Matiere']) ) { $liste_colonnes_a_indexer['article_Matiere'] = 'article_Matiere'; }
                        if ( isset($options['tris']['article_Photo_Fichier']) ) { $liste_colonnes_a_indexer['article_Photo_Fichier'] = 'article_Photo_Fichier'; }
                        if ( isset($options['tris']['article_Prix']) ) { $liste_colonnes_a_indexer['article_Prix'] = 'article_Prix'; }
                        if ( isset($options['tris']['article_Actif']) ) { $liste_colonnes_a_indexer['article_Actif'] = 'article_Actif'; }
                    }
                    if (count($liste_colonnes_a_indexer) > 0) {
                        if (false === $mf_liste_requete_index = self::$cache_db->read('article__index')) {
                            $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('article').'`;', false);
                            $mf_liste_requete_index = [];
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

                    if (count($liste_colonnes_a_selectionner) == 0) {
                        if ($toutes_colonnes) {
                            $colonnes = 'Code_article, article_Libelle, article_Description, article_Saison_Type, article_Nom_fournisseur, article_Url, article_Reference, article_Couleur, article_Code_couleur_svg, article_Taille_Pays_Type, article_Taille, article_Matiere, article_Photo_Fichier, article_Prix, article_Actif, Code_sous_categorie_article';
                        } else {
                            $colonnes = 'Code_article, article_Libelle, article_Saison_Type, article_Nom_fournisseur, article_Url, article_Reference, article_Couleur, article_Code_couleur_svg, article_Taille_Pays_Type, article_Taille, article_Matiere, article_Photo_Fichier, article_Prix, article_Actif, Code_sous_categorie_article';
                        }
                    } else {
                        $liste_colonnes_a_selectionner[] = 'Code_article';
                        $colonnes = enumeration($liste_colonnes_a_selectionner, ',');
                    }

                    $liste = [];
                    $liste_article_pas_a_jour = [];
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
                if ($controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_article', $elem['Code_article'])) {
                    unset($liste[$elem['Code_article']]);
                } else {
                    if (($autocompletion_recursive || self::$auto_completion < 1) && $autocompletion) {
                        self::$auto_completion ++;
                        Hook_article::completion($liste[$elem['Code_article']], self::$auto_completion - 1);
                        self::$auto_completion --;
                    }
                }
            }

            return $liste;
        } else {
            return [];
        }
    }

    public function mf_lister_3(?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'liste_colonnes_a_selectionner' => [], 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        return $this->mf_lister(null, $options);
    }

    public function mf_get(int $Code_article, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $Code_article = intval($Code_article);
        $retour = [];
        if ( ! CONTROLE_ACCES_DONNEES_DEFAUT || Hook_mf_systeme::controle_acces_donnees('Code_article', $Code_article) ) {
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
            while ($nouvelle_lecture) {
                $nouvelle_lecture = false;
                if (false === $retour = self::$cache_db->read($cle)) {
                    if ($toutes_colonnes) {
                        $colonnes='Code_article, article_Libelle, article_Description, article_Saison_Type, article_Nom_fournisseur, article_Url, article_Reference, article_Couleur, article_Code_couleur_svg, article_Taille_Pays_Type, article_Taille, article_Matiere, article_Photo_Fichier, article_Prix, article_Actif, Code_sous_categorie_article';
                    } else {
                        $colonnes='Code_article, article_Libelle, article_Saison_Type, article_Nom_fournisseur, article_Url, article_Reference, article_Couleur, article_Code_couleur_svg, article_Taille_Pays_Type, article_Taille, article_Matiere, article_Photo_Fichier, article_Prix, article_Actif, Code_sous_categorie_article';
                    }
                    $res_requete = executer_requete_mysql("SELECT $colonnes FROM " . inst('article') . ' WHERE Code_article = ' . $Code_article . ';', false);
                    if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                        mf_formatage_db_type_php($row_requete);
                        $retour = $row_requete;
                        if ($maj && ! Hook_article::est_a_jour($row_requete)) {
                            $nouvelle_lecture = true;
                        }
                    } else {
                        $retour = [];
                    }
                    mysqli_free_result($res_requete);
                    if (! $nouvelle_lecture) {
                        self::$cache_db->write($cle, $retour);
                    } else {
                        Hook_article::mettre_a_jour([$row_requete['Code_article'] => $row_requete]);
                    }
                }
            }
            if (isset($retour['Code_article'])) {
                if (($autocompletion_recursive || self::$auto_completion < 1) && $autocompletion) {
                    self::$auto_completion ++;
                    Hook_article::completion($retour, self::$auto_completion - 1);
                    self::$auto_completion --;
                }
            }
        }
        return $retour;
    }

    public function mf_get_last(?int $Code_sous_categorie_article = null, ?array $options = null /* $options = [ 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'toutes_colonnes' => true, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cle = "article__get_last";
        $Code_sous_categorie_article = intval($Code_sous_categorie_article);
        $cle .= '_' . $Code_sous_categorie_article;
        if (false === $retour = self::$cache_db->read($cle)) {
            $Code_article = 0;
            $res_requete = executer_requete_mysql('SELECT Code_article FROM ' . inst('article') . " WHERE 1".( $Code_sous_categorie_article!=0 ? " AND Code_sous_categorie_article=$Code_sous_categorie_article" : "" )." ORDER BY mf_date_creation DESC, Code_article DESC LIMIT 0 , 1;", false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $Code_article = intval($row_requete['Code_article']);
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
        $cle = "article__get_$Code_article";

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
                $colonnes='Code_article, article_Libelle, article_Description, article_Saison_Type, article_Nom_fournisseur, article_Url, article_Reference, article_Couleur, article_Code_couleur_svg, article_Taille_Pays_Type, article_Taille, article_Matiere, article_Photo_Fichier, article_Prix, article_Actif, Code_sous_categorie_article';
            } else {
                $colonnes='Code_article, article_Libelle, article_Saison_Type, article_Nom_fournisseur, article_Url, article_Reference, article_Couleur, article_Code_couleur_svg, article_Taille_Pays_Type, article_Taille, article_Matiere, article_Photo_Fichier, article_Prix, article_Actif, Code_sous_categorie_article';
            }
            $res_requete = executer_requete_mysql("SELECT $colonnes FROM " . inst('article') . " WHERE Code_article = $Code_article;", false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                mf_formatage_db_type_php($row_requete);
                $retour = $row_requete;
            } else {
                $retour = [];
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

    public function mf_prec_et_suiv( int $Code_article, ?int $Code_sous_categorie_article = null, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'liste_colonnes_a_selectionner' => [], 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $Code_article = intval($Code_article);
        $liste = $this->mf_lister($Code_sous_categorie_article, $options);
        return prec_suiv($liste, $Code_article);
    }

    public function mf_compter(?int $Code_sous_categorie_article = null, ?array $options = null /* $options = [ 'cond_mysql' => [] ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cle = 'article__compter';
        $Code_sous_categorie_article = intval($Code_sous_categorie_article);
        $cle .= '_{'.$Code_sous_categorie_article.'}';

        // cond_mysql
        $argument_cond = '';
        if (isset($options['cond_mysql'])) {
            foreach ($options['cond_mysql'] as &$condition) {
                $argument_cond .= " AND ($condition)";
            }
            unset($condition);
        }
        $cle .= "_$argument_cond";

        if (false === $nb = self::$cache_db->read($cle)) {

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
                if (false === $mf_liste_requete_index = self::$cache_db->read('article__index')) {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('article').'`;', false);
                    $mf_liste_requete_index = [];
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

            $res_requete = executer_requete_mysql('SELECT count(Code_article) as nb FROM ' . inst('article')." WHERE 1{$argument_cond}".( $Code_sous_categorie_article!=0 ? " AND Code_sous_categorie_article=$Code_sous_categorie_article" : "" ).";", false);
            $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC);
            mysqli_free_result($res_requete);
            $nb = (int) $row_requete['nb'];
            self::$cache_db->write($cle, $nb);
        }
        return $nb;
    }

    public function mfi_compter( array $interface, ?array $options = null /* $options = [ 'cond_mysql' => [] ] */ )
    {
        if ($options === null) {
            $options=[];
        }
        $Code_sous_categorie_article = isset($interface['Code_sous_categorie_article']) ? intval($interface['Code_sous_categorie_article']) : 0;
        return $this->mf_compter( $Code_sous_categorie_article, $options );
    }

    public function mf_liste_Code_article(?int $Code_sous_categorie_article = null, ?array $options = null /* $options = [ 'cond_mysql' => [] ] */)
    {
        if ($options === null) {
            $options=[];
        }
        return $this->get_liste_Code_article($Code_sous_categorie_article, $options);
    }

    public function mf_convertir_Code_article_vers_Code_sous_categorie_article( int $Code_article )
    {
        return $this->Code_article_vers_Code_sous_categorie_article( $Code_article );
    }

    public function mf_liste_Code_sous_categorie_article_vers_liste_Code_article( array $liste_Code_sous_categorie_article, ?array $options = null /* $options = [ 'cond_mysql' => [] ] */ )
    {
        if ($options === null) {
            $options=[];
        }
        return $this->liste_Code_sous_categorie_article_vers_liste_Code_article( $liste_Code_sous_categorie_article, $options );
    }

    public function mf_liste_Code_article_vers_liste_Code_sous_categorie_article( array $liste_Code_article, ?array $options = null /* $options = [ 'cond_mysql' => [] ] */ )
    {
        if ($options === null) {
            $options=[];
        }
        return $this->article__liste_Code_article_vers_liste_Code_sous_categorie_article( $liste_Code_article, $options );
    }

    public function mf_get_liste_tables_parents()
    {
        return ['sous_categorie_article'];
    }

    public function mf_search_article_Libelle(string $article_Libelle, ?int $Code_sous_categorie_article = null): int
    {
        return $this->rechercher_article_Libelle($article_Libelle, $Code_sous_categorie_article);
    }

    public function mf_search_article_Saison_Type(int $article_Saison_Type, ?int $Code_sous_categorie_article = null): int
    {
        return $this->rechercher_article_Saison_Type($article_Saison_Type, $Code_sous_categorie_article);
    }

    public function mf_search_article_Nom_fournisseur(string $article_Nom_fournisseur, ?int $Code_sous_categorie_article = null): int
    {
        return $this->rechercher_article_Nom_fournisseur($article_Nom_fournisseur, $Code_sous_categorie_article);
    }

    public function mf_search_article_Url(string $article_Url, ?int $Code_sous_categorie_article = null): int
    {
        return $this->rechercher_article_Url($article_Url, $Code_sous_categorie_article);
    }

    public function mf_search_article_Reference(string $article_Reference, ?int $Code_sous_categorie_article = null): int
    {
        return $this->rechercher_article_Reference($article_Reference, $Code_sous_categorie_article);
    }

    public function mf_search_article_Couleur(string $article_Couleur, ?int $Code_sous_categorie_article = null): int
    {
        return $this->rechercher_article_Couleur($article_Couleur, $Code_sous_categorie_article);
    }

    public function mf_search_article_Code_couleur_svg(string $article_Code_couleur_svg, ?int $Code_sous_categorie_article = null): int
    {
        return $this->rechercher_article_Code_couleur_svg($article_Code_couleur_svg, $Code_sous_categorie_article);
    }

    public function mf_search_article_Taille_Pays_Type(int $article_Taille_Pays_Type, ?int $Code_sous_categorie_article = null): int
    {
        return $this->rechercher_article_Taille_Pays_Type($article_Taille_Pays_Type, $Code_sous_categorie_article);
    }

    public function mf_search_article_Taille(int $article_Taille, ?int $Code_sous_categorie_article = null): int
    {
        return $this->rechercher_article_Taille($article_Taille, $Code_sous_categorie_article);
    }

    public function mf_search_article_Matiere(string $article_Matiere, ?int $Code_sous_categorie_article = null): int
    {
        return $this->rechercher_article_Matiere($article_Matiere, $Code_sous_categorie_article);
    }

    public function mf_search_article_Photo_Fichier(string $article_Photo_Fichier, ?int $Code_sous_categorie_article = null): int
    {
        return $this->rechercher_article_Photo_Fichier($article_Photo_Fichier, $Code_sous_categorie_article);
    }

    public function mf_search_article_Prix(float $article_Prix, ?int $Code_sous_categorie_article = null): int
    {
        return $this->rechercher_article_Prix($article_Prix, $Code_sous_categorie_article);
    }

    public function mf_search_article_Actif(bool $article_Actif, ?int $Code_sous_categorie_article = null): int
    {
        return $this->rechercher_article_Actif($article_Actif, $Code_sous_categorie_article);
    }

    /**
     * Trouve le premier "Code_article" rattaché à "Code_sous_categorie_article"
     * Si pas de résultat, 0 sera retourné
     * @param int $Code_sous_categorie_article
     * @return int $Code_article
     */
    public function mf_search_Code_sous_categorie_article(int $Code_sous_categorie_article): int
    {
        return $this->rechercher_article__Code_sous_categorie_article($Code_sous_categorie_article);
    }

    public function mf_search__colonne(string $colonne_db, $recherche, ?int $Code_sous_categorie_article = null): int
    {
        switch ($colonne_db) {
            case 'article_Libelle': return $this->mf_search_article_Libelle($recherche, $Code_sous_categorie_article); break;
            case 'article_Saison_Type': return $this->mf_search_article_Saison_Type($recherche, $Code_sous_categorie_article); break;
            case 'article_Nom_fournisseur': return $this->mf_search_article_Nom_fournisseur($recherche, $Code_sous_categorie_article); break;
            case 'article_Url': return $this->mf_search_article_Url($recherche, $Code_sous_categorie_article); break;
            case 'article_Reference': return $this->mf_search_article_Reference($recherche, $Code_sous_categorie_article); break;
            case 'article_Couleur': return $this->mf_search_article_Couleur($recherche, $Code_sous_categorie_article); break;
            case 'article_Code_couleur_svg': return $this->mf_search_article_Code_couleur_svg($recherche, $Code_sous_categorie_article); break;
            case 'article_Taille_Pays_Type': return $this->mf_search_article_Taille_Pays_Type($recherche, $Code_sous_categorie_article); break;
            case 'article_Taille': return $this->mf_search_article_Taille($recherche, $Code_sous_categorie_article); break;
            case 'article_Matiere': return $this->mf_search_article_Matiere($recherche, $Code_sous_categorie_article); break;
            case 'article_Photo_Fichier': return $this->mf_search_article_Photo_Fichier($recherche, $Code_sous_categorie_article); break;
            case 'article_Prix': return $this->mf_search_article_Prix($recherche, $Code_sous_categorie_article); break;
            case 'article_Actif': return $this->mf_search_article_Actif($recherche, $Code_sous_categorie_article); break;
            default: return 0;
        }
    }

    public function mf_get_next_id(): int
    {
        $res_requete = executer_requete_mysql('SELECT AUTO_INCREMENT as next_id FROM INFORMATION_SCHEMA.TABLES WHERE table_name = \'' . inst('article') . '\';', false);
        $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC);
        mysqli_free_result($res_requete);
        return intval($row_requete['next_id']);
    }

    public function mf_search(array $ligne): int // array('colonne1' => 'valeur1',  [...] )
    {
        global $mf_initialisation;
        $Code_sous_categorie_article = (isset($ligne['Code_sous_categorie_article']) ? intval($ligne['Code_sous_categorie_article']) : 0);
        $article_Libelle = (isset($ligne['article_Libelle']) ? $ligne['article_Libelle'] : $mf_initialisation['article_Libelle']);
        $article_Description = (isset($ligne['article_Description']) ? $ligne['article_Description'] : $mf_initialisation['article_Description']);
        $article_Saison_Type = (isset($ligne['article_Saison_Type']) ? $ligne['article_Saison_Type'] : $mf_initialisation['article_Saison_Type']);
        $article_Nom_fournisseur = (isset($ligne['article_Nom_fournisseur']) ? $ligne['article_Nom_fournisseur'] : $mf_initialisation['article_Nom_fournisseur']);
        $article_Url = (isset($ligne['article_Url']) ? $ligne['article_Url'] : $mf_initialisation['article_Url']);
        $article_Reference = (isset($ligne['article_Reference']) ? $ligne['article_Reference'] : $mf_initialisation['article_Reference']);
        $article_Couleur = (isset($ligne['article_Couleur']) ? $ligne['article_Couleur'] : $mf_initialisation['article_Couleur']);
        $article_Code_couleur_svg = (isset($ligne['article_Code_couleur_svg']) ? $ligne['article_Code_couleur_svg'] : $mf_initialisation['article_Code_couleur_svg']);
        $article_Taille_Pays_Type = (isset($ligne['article_Taille_Pays_Type']) ? $ligne['article_Taille_Pays_Type'] : $mf_initialisation['article_Taille_Pays_Type']);
        $article_Taille = (isset($ligne['article_Taille']) ? $ligne['article_Taille'] : $mf_initialisation['article_Taille']);
        $article_Matiere = (isset($ligne['article_Matiere']) ? $ligne['article_Matiere'] : $mf_initialisation['article_Matiere']);
        $article_Photo_Fichier = (isset($ligne['article_Photo_Fichier']) ? $ligne['article_Photo_Fichier'] : $mf_initialisation['article_Photo_Fichier']);
        $article_Prix = (isset($ligne['article_Prix']) ? $ligne['article_Prix'] : $mf_initialisation['article_Prix']);
        $article_Actif = (isset($ligne['article_Actif']) ? $ligne['article_Actif'] : $mf_initialisation['article_Actif']);
        // Typage
        $Code_sous_categorie_article = (int) $Code_sous_categorie_article;
        $article_Libelle = (string) $article_Libelle;
        $article_Description = (string) $article_Description;
        $article_Saison_Type = is_null($article_Saison_Type) || $article_Saison_Type === '' ? null : (int) $article_Saison_Type;
        $article_Nom_fournisseur = (string) $article_Nom_fournisseur;
        $article_Url = (string) $article_Url;
        $article_Reference = (string) $article_Reference;
        $article_Couleur = (string) $article_Couleur;
        $article_Code_couleur_svg = (string) $article_Code_couleur_svg;
        $article_Taille_Pays_Type = is_null($article_Taille_Pays_Type) || $article_Taille_Pays_Type === '' ? null : (int) $article_Taille_Pays_Type;
        $article_Taille = is_null($article_Taille) || $article_Taille === '' ? null : (int) $article_Taille;
        $article_Matiere = (string) $article_Matiere;
        $article_Photo_Fichier = (string) $article_Photo_Fichier;
        $article_Prix = is_null($article_Prix) || $article_Prix === '' ? null : mf_significantDigit((float) str_replace(' ', '', str_replace(',', '.', $article_Prix)), 6);
        $article_Actif = ($article_Actif == true);
        // Fin typage
        Hook_article::pre_controller($article_Libelle, $article_Description, $article_Saison_Type, $article_Nom_fournisseur, $article_Url, $article_Reference, $article_Couleur, $article_Code_couleur_svg, $article_Taille_Pays_Type, $article_Taille, $article_Matiere, $article_Photo_Fichier, $article_Prix, $article_Actif, $Code_sous_categorie_article);
        $mf_cle_unique = Hook_article::calcul_cle_unique($article_Libelle, $article_Description, $article_Saison_Type, $article_Nom_fournisseur, $article_Url, $article_Reference, $article_Couleur, $article_Code_couleur_svg, $article_Taille_Pays_Type, $article_Taille, $article_Matiere, $article_Photo_Fichier, $article_Prix, $article_Actif, $Code_sous_categorie_article);
        $res_requete = executer_requete_mysql('SELECT Code_article FROM ' . inst('article') . ' WHERE mf_cle_unique = \'' . $mf_cle_unique . '\'', false);
        if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
            $r = intval($row_requete['Code_article']);
        } else {
            $r = 0;
        }
        mysqli_free_result($res_requete);
        return $r;
    }
}
