<?php declare(strict_types=1);

/*
    +------------------------------+
    |  NE PAS MODIFIER CE FICHIER  |
    +------------------------------+
*/

class table_utilisateur_monframework extends entite
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
        if (self::$initialisation) {
            include_once __DIR__ . '/../../erreurs/erreurs__utilisateur.php';
            self::$initialisation = false;
            Hook_utilisateur::initialisation();
            self::$cache_db = new Mf_Cachedb('utilisateur');
        }
        if (! self::$actualisation_en_cours) {
            self::$actualisation_en_cours=true;
            Hook_utilisateur::actualisation();
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

        if (! test_si_table_existe(inst('utilisateur'))) {
            executer_requete_mysql('CREATE TABLE '.inst('utilisateur').'(Code_utilisateur BIGINT UNSIGNED NOT NULL AUTO_INCREMENT, PRIMARY KEY (Code_utilisateur)) ENGINE=MyISAM;', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        $liste_colonnes = lister_les_colonnes('utilisateur');

        if (isset($liste_colonnes['utilisateur_Identifiant'])) {
            if (typeMyql2Sql($liste_colonnes['utilisateur_Identifiant']['Type'])!='VARCHAR') {
                executer_requete_mysql('ALTER TABLE '.inst('utilisateur').' CHANGE utilisateur_Identifiant utilisateur_Identifiant VARCHAR(255);', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['utilisateur_Identifiant']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('utilisateur').' ADD utilisateur_Identifiant VARCHAR(255);', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE '.inst('utilisateur').' SET utilisateur_Identifiant=' . format_sql('utilisateur_Identifiant', $mf_initialisation['utilisateur_Identifiant']) . ';', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if (isset($liste_colonnes['utilisateur_Password'])) {
            if (typeMyql2Sql($liste_colonnes['utilisateur_Password']['Type'])!='VARCHAR') {
                executer_requete_mysql('ALTER TABLE '.inst('utilisateur').' CHANGE utilisateur_Password utilisateur_Password VARCHAR(255);', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['utilisateur_Password']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('utilisateur').' ADD utilisateur_Password VARCHAR(255);', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE '.inst('utilisateur').' SET utilisateur_Password=' . format_sql('utilisateur_Password', $mf_initialisation['utilisateur_Password']) . ';', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if (isset($liste_colonnes['utilisateur_Email'])) {
            if (typeMyql2Sql($liste_colonnes['utilisateur_Email']['Type'])!='VARCHAR') {
                executer_requete_mysql('ALTER TABLE '.inst('utilisateur').' CHANGE utilisateur_Email utilisateur_Email VARCHAR(255);', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['utilisateur_Email']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('utilisateur').' ADD utilisateur_Email VARCHAR(255);', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE '.inst('utilisateur').' SET utilisateur_Email=' . format_sql('utilisateur_Email', $mf_initialisation['utilisateur_Email']) . ';', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if (isset($liste_colonnes['utilisateur_Civilite_Type'])) {
            if (typeMyql2Sql($liste_colonnes['utilisateur_Civilite_Type']['Type'])!='INT') {
                executer_requete_mysql('ALTER TABLE '.inst('utilisateur').' CHANGE utilisateur_Civilite_Type utilisateur_Civilite_Type INT;', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['utilisateur_Civilite_Type']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('utilisateur').' ADD utilisateur_Civilite_Type INT;', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE '.inst('utilisateur').' SET utilisateur_Civilite_Type=' . format_sql('utilisateur_Civilite_Type', $mf_initialisation['utilisateur_Civilite_Type']) . ';', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if (isset($liste_colonnes['utilisateur_Prenom'])) {
            if (typeMyql2Sql($liste_colonnes['utilisateur_Prenom']['Type'])!='VARCHAR') {
                executer_requete_mysql('ALTER TABLE '.inst('utilisateur').' CHANGE utilisateur_Prenom utilisateur_Prenom VARCHAR(255);', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['utilisateur_Prenom']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('utilisateur').' ADD utilisateur_Prenom VARCHAR(255);', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE '.inst('utilisateur').' SET utilisateur_Prenom=' . format_sql('utilisateur_Prenom', $mf_initialisation['utilisateur_Prenom']) . ';', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if (isset($liste_colonnes['utilisateur_Nom'])) {
            if (typeMyql2Sql($liste_colonnes['utilisateur_Nom']['Type'])!='VARCHAR') {
                executer_requete_mysql('ALTER TABLE '.inst('utilisateur').' CHANGE utilisateur_Nom utilisateur_Nom VARCHAR(255);', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['utilisateur_Nom']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('utilisateur').' ADD utilisateur_Nom VARCHAR(255);', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE '.inst('utilisateur').' SET utilisateur_Nom=' . format_sql('utilisateur_Nom', $mf_initialisation['utilisateur_Nom']) . ';', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if (isset($liste_colonnes['utilisateur_Adresse_1'])) {
            if (typeMyql2Sql($liste_colonnes['utilisateur_Adresse_1']['Type'])!='VARCHAR') {
                executer_requete_mysql('ALTER TABLE '.inst('utilisateur').' CHANGE utilisateur_Adresse_1 utilisateur_Adresse_1 VARCHAR(255);', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['utilisateur_Adresse_1']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('utilisateur').' ADD utilisateur_Adresse_1 VARCHAR(255);', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE '.inst('utilisateur').' SET utilisateur_Adresse_1=' . format_sql('utilisateur_Adresse_1', $mf_initialisation['utilisateur_Adresse_1']) . ';', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if (isset($liste_colonnes['utilisateur_Adresse_2'])) {
            if (typeMyql2Sql($liste_colonnes['utilisateur_Adresse_2']['Type'])!='VARCHAR') {
                executer_requete_mysql('ALTER TABLE '.inst('utilisateur').' CHANGE utilisateur_Adresse_2 utilisateur_Adresse_2 VARCHAR(255);', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['utilisateur_Adresse_2']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('utilisateur').' ADD utilisateur_Adresse_2 VARCHAR(255);', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE '.inst('utilisateur').' SET utilisateur_Adresse_2=' . format_sql('utilisateur_Adresse_2', $mf_initialisation['utilisateur_Adresse_2']) . ';', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if (isset($liste_colonnes['utilisateur_Ville'])) {
            if (typeMyql2Sql($liste_colonnes['utilisateur_Ville']['Type'])!='VARCHAR') {
                executer_requete_mysql('ALTER TABLE '.inst('utilisateur').' CHANGE utilisateur_Ville utilisateur_Ville VARCHAR(255);', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['utilisateur_Ville']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('utilisateur').' ADD utilisateur_Ville VARCHAR(255);', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE '.inst('utilisateur').' SET utilisateur_Ville=' . format_sql('utilisateur_Ville', $mf_initialisation['utilisateur_Ville']) . ';', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if (isset($liste_colonnes['utilisateur_Code_postal'])) {
            if (typeMyql2Sql($liste_colonnes['utilisateur_Code_postal']['Type'])!='VARCHAR') {
                executer_requete_mysql('ALTER TABLE '.inst('utilisateur').' CHANGE utilisateur_Code_postal utilisateur_Code_postal VARCHAR(255);', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['utilisateur_Code_postal']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('utilisateur').' ADD utilisateur_Code_postal VARCHAR(255);', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE '.inst('utilisateur').' SET utilisateur_Code_postal=' . format_sql('utilisateur_Code_postal', $mf_initialisation['utilisateur_Code_postal']) . ';', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if (isset($liste_colonnes['utilisateur_Date_naissance'])) {
            if (typeMyql2Sql($liste_colonnes['utilisateur_Date_naissance']['Type'])!='DATE') {
                executer_requete_mysql('ALTER TABLE '.inst('utilisateur').' CHANGE utilisateur_Date_naissance utilisateur_Date_naissance DATE;', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['utilisateur_Date_naissance']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('utilisateur').' ADD utilisateur_Date_naissance DATE;', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE '.inst('utilisateur').' SET utilisateur_Date_naissance=' . format_sql('utilisateur_Date_naissance', $mf_initialisation['utilisateur_Date_naissance']) . ';', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if (isset($liste_colonnes['utilisateur_Accepte_mail_publicitaire'])) {
            if (typeMyql2Sql($liste_colonnes['utilisateur_Accepte_mail_publicitaire']['Type'])!='BOOL') {
                executer_requete_mysql('ALTER TABLE '.inst('utilisateur').' CHANGE utilisateur_Accepte_mail_publicitaire utilisateur_Accepte_mail_publicitaire BOOL;', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['utilisateur_Accepte_mail_publicitaire']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('utilisateur').' ADD utilisateur_Accepte_mail_publicitaire BOOL;', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE '.inst('utilisateur').' SET utilisateur_Accepte_mail_publicitaire=' . format_sql('utilisateur_Accepte_mail_publicitaire', $mf_initialisation['utilisateur_Accepte_mail_publicitaire']) . ';', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if (isset($liste_colonnes['utilisateur_Administrateur'])) {
            if (typeMyql2Sql($liste_colonnes['utilisateur_Administrateur']['Type'])!='BOOL') {
                executer_requete_mysql('ALTER TABLE '.inst('utilisateur').' CHANGE utilisateur_Administrateur utilisateur_Administrateur BOOL;', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['utilisateur_Administrateur']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('utilisateur').' ADD utilisateur_Administrateur BOOL;', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE '.inst('utilisateur').' SET utilisateur_Administrateur=' . format_sql('utilisateur_Administrateur', $mf_initialisation['utilisateur_Administrateur']) . ';', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        if (isset($liste_colonnes['utilisateur_Fournisseur'])) {
            if (typeMyql2Sql($liste_colonnes['utilisateur_Fournisseur']['Type'])!='BOOL') {
                executer_requete_mysql('ALTER TABLE '.inst('utilisateur').' CHANGE utilisateur_Fournisseur utilisateur_Fournisseur BOOL;', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            }
            unset($liste_colonnes['utilisateur_Fournisseur']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('utilisateur').' ADD utilisateur_Fournisseur BOOL;', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            executer_requete_mysql('UPDATE '.inst('utilisateur').' SET utilisateur_Fournisseur=' . format_sql('utilisateur_Fournisseur', $mf_initialisation['utilisateur_Fournisseur']) . ';', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        $liste_colonnes_a_indexer = [];

        if (isset($liste_colonnes['mf_signature'])) {
            unset($liste_colonnes['mf_signature']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('utilisateur').' ADD mf_signature VARCHAR(255);', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }
        $liste_colonnes_a_indexer['mf_signature'] = 'mf_signature';

        if (isset($liste_colonnes['mf_cle_unique'])) {
            unset($liste_colonnes['mf_cle_unique']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('utilisateur').' ADD mf_cle_unique VARCHAR(255);', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }
        $liste_colonnes_a_indexer['mf_cle_unique'] = 'mf_cle_unique';

        if (isset($liste_colonnes['mf_date_creation'])) {
            unset($liste_colonnes['mf_date_creation']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('utilisateur').' ADD mf_date_creation DATETIME;', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }
        $liste_colonnes_a_indexer['mf_date_creation'] = 'mf_date_creation';

        if (isset($liste_colonnes['mf_date_modification'])) {
            unset($liste_colonnes['mf_date_modification']);
        } else {
            executer_requete_mysql('ALTER TABLE '.inst('utilisateur').' ADD mf_date_modification DATETIME;', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }
        $liste_colonnes_a_indexer['mf_date_modification'] = 'mf_date_modification';

        unset($liste_colonnes['Code_utilisateur']);

        foreach ($liste_colonnes as $field => $value) {
            executer_requete_mysql('ALTER TABLE '.inst('utilisateur').' DROP COLUMN '.$field.';', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }

        $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `' . inst('utilisateur') . '`;', false);
        $mf_liste_requete_index = [];
        while ($row_requete_index = mysqli_fetch_array($res_requete_index, MYSQLI_ASSOC)) {
            $mf_liste_requete_index[$row_requete_index['Column_name']] = $row_requete_index['Column_name'];
        }
        mysqli_free_result($res_requete_index);
        foreach ($mf_liste_requete_index as $mf_colonne_indexee) {
            if (isset($liste_colonnes_a_indexer[$mf_colonne_indexee])) unset($liste_colonnes_a_indexer[$mf_colonne_indexee]);
        }
        foreach ($liste_colonnes_a_indexer as $colonnes_a_indexer) {
            executer_requete_mysql('ALTER TABLE `' . inst('utilisateur') . '` ADD INDEX(`' . $colonnes_a_indexer . '`);', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        }
    }

    /**
     * Retourne la tructure de la table « utilisateur » avec les valeurs initialisées par défaut.
     * @return array
     */
    public function mf_get_structure(): array
    {
        global $mf_initialisation;
        $struc = [
            'Code_utilisateur' => null, // ID
            'utilisateur_Identifiant' => $mf_initialisation['utilisateur_Identifiant'],
            'utilisateur_Password' => $mf_initialisation['utilisateur_Password'],
            'utilisateur_Email' => $mf_initialisation['utilisateur_Email'],
            'utilisateur_Civilite_Type' => $mf_initialisation['utilisateur_Civilite_Type'],
            'utilisateur_Prenom' => $mf_initialisation['utilisateur_Prenom'],
            'utilisateur_Nom' => $mf_initialisation['utilisateur_Nom'],
            'utilisateur_Adresse_1' => $mf_initialisation['utilisateur_Adresse_1'],
            'utilisateur_Adresse_2' => $mf_initialisation['utilisateur_Adresse_2'],
            'utilisateur_Ville' => $mf_initialisation['utilisateur_Ville'],
            'utilisateur_Code_postal' => $mf_initialisation['utilisateur_Code_postal'],
            'utilisateur_Date_naissance' => $mf_initialisation['utilisateur_Date_naissance'],
            'utilisateur_Accepte_mail_publicitaire' => $mf_initialisation['utilisateur_Accepte_mail_publicitaire'],
            'utilisateur_Administrateur' => $mf_initialisation['utilisateur_Administrateur'],
            'utilisateur_Fournisseur' => $mf_initialisation['utilisateur_Fournisseur'],
        ];
        mf_formatage_db_type_php($struc);
        Hook_utilisateur::pre_controller($struc['utilisateur_Identifiant'], $struc['utilisateur_Password'], $struc['utilisateur_Email'], $struc['utilisateur_Civilite_Type'], $struc['utilisateur_Prenom'], $struc['utilisateur_Nom'], $struc['utilisateur_Adresse_1'], $struc['utilisateur_Adresse_2'], $struc['utilisateur_Ville'], $struc['utilisateur_Code_postal'], $struc['utilisateur_Date_naissance'], $struc['utilisateur_Accepte_mail_publicitaire'], $struc['utilisateur_Administrateur'], $struc['utilisateur_Fournisseur'], $struc['Code_utilisateur']);
        return $struc;
    }

    public function mf_ajouter(string $utilisateur_Identifiant, string $utilisateur_Password, string $utilisateur_Email, ?int $utilisateur_Civilite_Type, string $utilisateur_Prenom, string $utilisateur_Nom, string $utilisateur_Adresse_1, string $utilisateur_Adresse_2, string $utilisateur_Ville, string $utilisateur_Code_postal, string $utilisateur_Date_naissance, bool $utilisateur_Accepte_mail_publicitaire, bool $utilisateur_Administrateur, bool $utilisateur_Fournisseur, ?bool $force = false)
    {
        if ($force === null) {
            $force = false;
        }
        $Code_utilisateur = 0;
        $code_erreur = 0;
        // Typage
        $utilisateur_Identifiant = (string) $utilisateur_Identifiant;
        $utilisateur_Password = (string) $utilisateur_Password;
        $utilisateur_Email = (string) $utilisateur_Email;
        $utilisateur_Civilite_Type = is_null($utilisateur_Civilite_Type) || $utilisateur_Civilite_Type === '' ? null : (int) $utilisateur_Civilite_Type;
        $utilisateur_Prenom = (string) $utilisateur_Prenom;
        $utilisateur_Nom = (string) $utilisateur_Nom;
        $utilisateur_Adresse_1 = (string) $utilisateur_Adresse_1;
        $utilisateur_Adresse_2 = (string) $utilisateur_Adresse_2;
        $utilisateur_Ville = (string) $utilisateur_Ville;
        $utilisateur_Code_postal = (string) $utilisateur_Code_postal;
        $utilisateur_Date_naissance = format_date($utilisateur_Date_naissance);
        $utilisateur_Accepte_mail_publicitaire = ($utilisateur_Accepte_mail_publicitaire == true);
        $utilisateur_Administrateur = ($utilisateur_Administrateur == true);
        $utilisateur_Fournisseur = ($utilisateur_Fournisseur == true);
        // Fin typage
        Hook_utilisateur::pre_controller($utilisateur_Identifiant, $utilisateur_Password, $utilisateur_Email, $utilisateur_Civilite_Type, $utilisateur_Prenom, $utilisateur_Nom, $utilisateur_Adresse_1, $utilisateur_Adresse_2, $utilisateur_Ville, $utilisateur_Code_postal, $utilisateur_Date_naissance, $utilisateur_Accepte_mail_publicitaire, $utilisateur_Administrateur, $utilisateur_Fournisseur);
        if (! $force) {
            if (! self::$maj_droits_ajouter_en_cours) {
                self::$maj_droits_ajouter_en_cours = true;
                Hook_utilisateur::hook_actualiser_les_droits_ajouter();
                self::$maj_droits_ajouter_en_cours = false;
            }
        }
        if ( !$force && !mf_matrice_droits(['utilisateur__AJOUTER']) ) $code_erreur = REFUS_UTILISATEUR__AJOUTER;
        elseif (! Hook_utilisateur::autorisation_ajout($utilisateur_Identifiant, $utilisateur_Password, $utilisateur_Email, $utilisateur_Civilite_Type, $utilisateur_Prenom, $utilisateur_Nom, $utilisateur_Adresse_1, $utilisateur_Adresse_2, $utilisateur_Ville, $utilisateur_Code_postal, $utilisateur_Date_naissance, $utilisateur_Accepte_mail_publicitaire, $utilisateur_Administrateur, $utilisateur_Fournisseur) ) $code_erreur = REFUS_UTILISATEUR__AJOUT_BLOQUEE;
        elseif ( $this->rechercher_utilisateur_Identifiant($utilisateur_Identifiant)!=0 ) $code_erreur = ERR_UTILISATEUR__AJOUTER__UTILISATEUR_IDENTIFIANT_DOUBLON;
        elseif ( ACTIVER_CONNEXION_EMAIL && $this->rechercher_utilisateur_Email($utilisateur_Email)!=0 ) $code_erreur = ERR_UTILISATEUR__AJOUTER__UTILISATEUR_EMAIL_DOUBLON;
        elseif (! controle_parametre("utilisateur_Civilite_Type", $utilisateur_Civilite_Type) ) $code_erreur = ERR_UTILISATEUR__AJOUTER__UTILISATEUR_CIVILITE_TYPE_NON_VALIDE;
        else {
            Hook_utilisateur::data_controller($utilisateur_Identifiant, $utilisateur_Password, $utilisateur_Email, $utilisateur_Civilite_Type, $utilisateur_Prenom, $utilisateur_Nom, $utilisateur_Adresse_1, $utilisateur_Adresse_2, $utilisateur_Ville, $utilisateur_Code_postal, $utilisateur_Date_naissance, $utilisateur_Accepte_mail_publicitaire, $utilisateur_Administrateur, $utilisateur_Fournisseur);
            $mf_signature = text_sql(Hook_utilisateur::calcul_signature($utilisateur_Identifiant, $utilisateur_Email, $utilisateur_Civilite_Type, $utilisateur_Prenom, $utilisateur_Nom, $utilisateur_Adresse_1, $utilisateur_Adresse_2, $utilisateur_Ville, $utilisateur_Code_postal, $utilisateur_Date_naissance, $utilisateur_Accepte_mail_publicitaire, $utilisateur_Administrateur, $utilisateur_Fournisseur));
            $mf_cle_unique = text_sql(Hook_utilisateur::calcul_cle_unique($utilisateur_Identifiant, $utilisateur_Email, $utilisateur_Civilite_Type, $utilisateur_Prenom, $utilisateur_Nom, $utilisateur_Adresse_1, $utilisateur_Adresse_2, $utilisateur_Ville, $utilisateur_Code_postal, $utilisateur_Date_naissance, $utilisateur_Accepte_mail_publicitaire, $utilisateur_Administrateur, $utilisateur_Fournisseur));
            $utilisateur_Identifiant = text_sql($utilisateur_Identifiant);
            $salt = salt(100);
            $utilisateur_Password = md5($utilisateur_Password.$salt).':'.$salt;
            $utilisateur_Email = text_sql($utilisateur_Email);
            $utilisateur_Civilite_Type = is_null($utilisateur_Civilite_Type) ? 'NULL' : (int) $utilisateur_Civilite_Type;
            $utilisateur_Prenom = text_sql($utilisateur_Prenom);
            $utilisateur_Nom = text_sql($utilisateur_Nom);
            $utilisateur_Adresse_1 = text_sql($utilisateur_Adresse_1);
            $utilisateur_Adresse_2 = text_sql($utilisateur_Adresse_2);
            $utilisateur_Ville = text_sql($utilisateur_Ville);
            $utilisateur_Code_postal = text_sql($utilisateur_Code_postal);
            $utilisateur_Date_naissance = format_date($utilisateur_Date_naissance);
            $utilisateur_Accepte_mail_publicitaire = ($utilisateur_Accepte_mail_publicitaire == true ? 1 : 0);
            $utilisateur_Administrateur = ($utilisateur_Administrateur == true ? 1 : 0);
            $utilisateur_Fournisseur = ($utilisateur_Fournisseur == true ? 1 : 0);
            $requete = "INSERT INTO " . inst('utilisateur') . " ( mf_signature, mf_cle_unique, mf_date_creation, mf_date_modification, utilisateur_Identifiant, utilisateur_Password, utilisateur_Email, utilisateur_Civilite_Type, utilisateur_Prenom, utilisateur_Nom, utilisateur_Adresse_1, utilisateur_Adresse_2, utilisateur_Ville, utilisateur_Code_postal, utilisateur_Date_naissance, utilisateur_Accepte_mail_publicitaire, utilisateur_Administrateur, utilisateur_Fournisseur ) VALUES ( '$mf_signature', '$mf_cle_unique', '".get_now()."', '".get_now()."', '$utilisateur_Identifiant', '$utilisateur_Password', '$utilisateur_Email', $utilisateur_Civilite_Type, '$utilisateur_Prenom', '$utilisateur_Nom', '$utilisateur_Adresse_1', '$utilisateur_Adresse_2', '$utilisateur_Ville', '$utilisateur_Code_postal', ".( $utilisateur_Date_naissance!='' ? "'$utilisateur_Date_naissance'" : 'NULL' ).", $utilisateur_Accepte_mail_publicitaire, $utilisateur_Administrateur, $utilisateur_Fournisseur );";
            executer_requete_mysql($requete, array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            $Code_utilisateur = requete_mysql_insert_id();
            if ($Code_utilisateur == 0) {
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
        return ['code_erreur' => $code_erreur, 'Code_utilisateur' => $Code_utilisateur, 'callback' => ( $code_erreur==0 ? Hook_utilisateur::callback_post($Code_utilisateur) : null )];
    }

    public function mf_ajouter_2(array $ligne, bool $force = null) // array('colonne1' => 'valeur1',  [...] )
    {
        if ($force === null) {
            $force = false;
        }
        global $mf_initialisation;
        $utilisateur_Identifiant = (isset($ligne['utilisateur_Identifiant'])?$ligne['utilisateur_Identifiant']:$mf_initialisation['utilisateur_Identifiant']);
        $utilisateur_Password = (isset($ligne['utilisateur_Password'])?$ligne['utilisateur_Password']:$mf_initialisation['utilisateur_Password']);
        $utilisateur_Email = (isset($ligne['utilisateur_Email'])?$ligne['utilisateur_Email']:$mf_initialisation['utilisateur_Email']);
        $utilisateur_Civilite_Type = (isset($ligne['utilisateur_Civilite_Type'])?$ligne['utilisateur_Civilite_Type']:$mf_initialisation['utilisateur_Civilite_Type']);
        $utilisateur_Prenom = (isset($ligne['utilisateur_Prenom'])?$ligne['utilisateur_Prenom']:$mf_initialisation['utilisateur_Prenom']);
        $utilisateur_Nom = (isset($ligne['utilisateur_Nom'])?$ligne['utilisateur_Nom']:$mf_initialisation['utilisateur_Nom']);
        $utilisateur_Adresse_1 = (isset($ligne['utilisateur_Adresse_1'])?$ligne['utilisateur_Adresse_1']:$mf_initialisation['utilisateur_Adresse_1']);
        $utilisateur_Adresse_2 = (isset($ligne['utilisateur_Adresse_2'])?$ligne['utilisateur_Adresse_2']:$mf_initialisation['utilisateur_Adresse_2']);
        $utilisateur_Ville = (isset($ligne['utilisateur_Ville'])?$ligne['utilisateur_Ville']:$mf_initialisation['utilisateur_Ville']);
        $utilisateur_Code_postal = (isset($ligne['utilisateur_Code_postal'])?$ligne['utilisateur_Code_postal']:$mf_initialisation['utilisateur_Code_postal']);
        $utilisateur_Date_naissance = (isset($ligne['utilisateur_Date_naissance'])?$ligne['utilisateur_Date_naissance']:$mf_initialisation['utilisateur_Date_naissance']);
        $utilisateur_Accepte_mail_publicitaire = (isset($ligne['utilisateur_Accepte_mail_publicitaire'])?$ligne['utilisateur_Accepte_mail_publicitaire']:$mf_initialisation['utilisateur_Accepte_mail_publicitaire']);
        $utilisateur_Administrateur = (isset($ligne['utilisateur_Administrateur'])?$ligne['utilisateur_Administrateur']:$mf_initialisation['utilisateur_Administrateur']);
        $utilisateur_Fournisseur = (isset($ligne['utilisateur_Fournisseur'])?$ligne['utilisateur_Fournisseur']:$mf_initialisation['utilisateur_Fournisseur']);
        // Typage
        $utilisateur_Identifiant = (string) $utilisateur_Identifiant;
        $utilisateur_Password = (string) $utilisateur_Password;
        $utilisateur_Email = (string) $utilisateur_Email;
        $utilisateur_Civilite_Type = is_null($utilisateur_Civilite_Type) || $utilisateur_Civilite_Type === '' ? null : (int) $utilisateur_Civilite_Type;
        $utilisateur_Prenom = (string) $utilisateur_Prenom;
        $utilisateur_Nom = (string) $utilisateur_Nom;
        $utilisateur_Adresse_1 = (string) $utilisateur_Adresse_1;
        $utilisateur_Adresse_2 = (string) $utilisateur_Adresse_2;
        $utilisateur_Ville = (string) $utilisateur_Ville;
        $utilisateur_Code_postal = (string) $utilisateur_Code_postal;
        $utilisateur_Date_naissance = format_date($utilisateur_Date_naissance);
        $utilisateur_Accepte_mail_publicitaire = ($utilisateur_Accepte_mail_publicitaire == true);
        $utilisateur_Administrateur = ($utilisateur_Administrateur == true);
        $utilisateur_Fournisseur = ($utilisateur_Fournisseur == true);
        // Fin typage
        return $this->mf_ajouter($utilisateur_Identifiant, $utilisateur_Password, $utilisateur_Email, $utilisateur_Civilite_Type, $utilisateur_Prenom, $utilisateur_Nom, $utilisateur_Adresse_1, $utilisateur_Adresse_2, $utilisateur_Ville, $utilisateur_Code_postal, $utilisateur_Date_naissance, $utilisateur_Accepte_mail_publicitaire, $utilisateur_Administrateur, $utilisateur_Fournisseur, $force);
    }

    public function mf_ajouter_3(array $lignes) // array( array( 'colonne1' => 'valeur1', 'colonne2' => 'valeur2',  [...] ), [...] )
    {
        global $mf_initialisation;
        $code_erreur = 0;
        $values = '';
        foreach ($lignes as $ligne) {
            $utilisateur_Identifiant = text_sql((isset($ligne['utilisateur_Identifiant']) ? $ligne['utilisateur_Identifiant'] : $mf_initialisation['utilisateur_Identifiant']));
            $salt = salt(100);
            $utilisateur_Password = md5((isset($ligne['utilisateur_Password']) ? $ligne['utilisateur_Password'] : $mf_initialisation['utilisateur_Password']).$salt).':'.$salt;
            $utilisateur_Email = text_sql((isset($ligne['utilisateur_Email']) ? $ligne['utilisateur_Email'] : $mf_initialisation['utilisateur_Email']));
            $utilisateur_Civilite_Type = is_null((isset($ligne['utilisateur_Civilite_Type']) ? $ligne['utilisateur_Civilite_Type'] : $mf_initialisation['utilisateur_Civilite_Type'])) ? 'NULL' : (int) (isset($ligne['utilisateur_Civilite_Type']) ? $ligne['utilisateur_Civilite_Type'] : $mf_initialisation['utilisateur_Civilite_Type']);
            $utilisateur_Prenom = text_sql((isset($ligne['utilisateur_Prenom']) ? $ligne['utilisateur_Prenom'] : $mf_initialisation['utilisateur_Prenom']));
            $utilisateur_Nom = text_sql((isset($ligne['utilisateur_Nom']) ? $ligne['utilisateur_Nom'] : $mf_initialisation['utilisateur_Nom']));
            $utilisateur_Adresse_1 = text_sql((isset($ligne['utilisateur_Adresse_1']) ? $ligne['utilisateur_Adresse_1'] : $mf_initialisation['utilisateur_Adresse_1']));
            $utilisateur_Adresse_2 = text_sql((isset($ligne['utilisateur_Adresse_2']) ? $ligne['utilisateur_Adresse_2'] : $mf_initialisation['utilisateur_Adresse_2']));
            $utilisateur_Ville = text_sql((isset($ligne['utilisateur_Ville']) ? $ligne['utilisateur_Ville'] : $mf_initialisation['utilisateur_Ville']));
            $utilisateur_Code_postal = text_sql((isset($ligne['utilisateur_Code_postal']) ? $ligne['utilisateur_Code_postal'] : $mf_initialisation['utilisateur_Code_postal']));
            $utilisateur_Date_naissance = format_date((isset($ligne['utilisateur_Date_naissance']) ? $ligne['utilisateur_Date_naissance'] : $mf_initialisation['utilisateur_Date_naissance']));
            $utilisateur_Accepte_mail_publicitaire = ((isset($ligne['utilisateur_Accepte_mail_publicitaire']) ? $ligne['utilisateur_Accepte_mail_publicitaire'] : $mf_initialisation['utilisateur_Accepte_mail_publicitaire']) == true ? 1 : 0);
            $utilisateur_Administrateur = ((isset($ligne['utilisateur_Administrateur']) ? $ligne['utilisateur_Administrateur'] : $mf_initialisation['utilisateur_Administrateur']) == true ? 1 : 0);
            $utilisateur_Fournisseur = ((isset($ligne['utilisateur_Fournisseur']) ? $ligne['utilisateur_Fournisseur'] : $mf_initialisation['utilisateur_Fournisseur']) == true ? 1 : 0);
            $values .= ($values != '' ? ',' : '') . "('$utilisateur_Identifiant', '$utilisateur_Password', '$utilisateur_Email', $utilisateur_Civilite_Type, '$utilisateur_Prenom', '$utilisateur_Nom', '$utilisateur_Adresse_1', '$utilisateur_Adresse_2', '$utilisateur_Ville', '$utilisateur_Code_postal', ".( $utilisateur_Date_naissance!='' ? "'$utilisateur_Date_naissance'" : 'NULL' ).", $utilisateur_Accepte_mail_publicitaire, $utilisateur_Administrateur, $utilisateur_Fournisseur)";
        }
        if ($values != '') {
            $requete = "INSERT INTO " . inst('utilisateur') . " ( utilisateur_Identifiant, utilisateur_Password, utilisateur_Email, utilisateur_Civilite_Type, utilisateur_Prenom, utilisateur_Nom, utilisateur_Adresse_1, utilisateur_Adresse_2, utilisateur_Ville, utilisateur_Code_postal, utilisateur_Date_naissance, utilisateur_Accepte_mail_publicitaire, utilisateur_Administrateur, utilisateur_Fournisseur ) VALUES $values;";
            executer_requete_mysql( $requete , array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            $n = requete_mysqli_affected_rows();
            if ($n < count($lignes)) {
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
        return ['code_erreur' => $code_erreur];
    }

    public function mf_actualiser_signature(int $Code_utilisateur)
    {
        $utilisateur = $this->mf_get_2($Code_utilisateur, ['autocompletion' => false]);
        $mf_signature = text_sql(Hook_utilisateur::calcul_signature($utilisateur['utilisateur_Identifiant'], $utilisateur['utilisateur_Email'], $utilisateur['utilisateur_Civilite_Type'], $utilisateur['utilisateur_Prenom'], $utilisateur['utilisateur_Nom'], $utilisateur['utilisateur_Adresse_1'], $utilisateur['utilisateur_Adresse_2'], $utilisateur['utilisateur_Ville'], $utilisateur['utilisateur_Code_postal'], $utilisateur['utilisateur_Date_naissance'], $utilisateur['utilisateur_Accepte_mail_publicitaire'], $utilisateur['utilisateur_Administrateur'], $utilisateur['utilisateur_Fournisseur']));
        $mf_cle_unique = text_sql(Hook_utilisateur::calcul_cle_unique($utilisateur['utilisateur_Identifiant'], $utilisateur['utilisateur_Email'], $utilisateur['utilisateur_Civilite_Type'], $utilisateur['utilisateur_Prenom'], $utilisateur['utilisateur_Nom'], $utilisateur['utilisateur_Adresse_1'], $utilisateur['utilisateur_Adresse_2'], $utilisateur['utilisateur_Ville'], $utilisateur['utilisateur_Code_postal'], $utilisateur['utilisateur_Date_naissance'], $utilisateur['utilisateur_Accepte_mail_publicitaire'], $utilisateur['utilisateur_Administrateur'], $utilisateur['utilisateur_Fournisseur']));
        $table = inst('utilisateur');
        executer_requete_mysql("UPDATE $table SET mf_signature='$mf_signature', mf_cle_unique='$mf_cle_unique' WHERE Code_utilisateur=$Code_utilisateur;", array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
        if (requete_mysqli_affected_rows() == 1) {
            self::$cache_db->clear();
        }
    }

    public function mf_modifier( int $Code_utilisateur, string $utilisateur_Identifiant, string $utilisateur_Password, string $utilisateur_Email, ?int $utilisateur_Civilite_Type, string $utilisateur_Prenom, string $utilisateur_Nom, string $utilisateur_Adresse_1, string $utilisateur_Adresse_2, string $utilisateur_Ville, string $utilisateur_Code_postal, string $utilisateur_Date_naissance, bool $utilisateur_Accepte_mail_publicitaire, bool $utilisateur_Administrateur, bool $utilisateur_Fournisseur, ?bool $force = null)
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        // Typage
        $utilisateur_Identifiant = (string) $utilisateur_Identifiant;
        $utilisateur_Password = (string) $utilisateur_Password;
        $utilisateur_Email = (string) $utilisateur_Email;
        $utilisateur_Civilite_Type = is_null($utilisateur_Civilite_Type) || $utilisateur_Civilite_Type === '' ? null : (int) $utilisateur_Civilite_Type;
        $utilisateur_Prenom = (string) $utilisateur_Prenom;
        $utilisateur_Nom = (string) $utilisateur_Nom;
        $utilisateur_Adresse_1 = (string) $utilisateur_Adresse_1;
        $utilisateur_Adresse_2 = (string) $utilisateur_Adresse_2;
        $utilisateur_Ville = (string) $utilisateur_Ville;
        $utilisateur_Code_postal = (string) $utilisateur_Code_postal;
        $utilisateur_Date_naissance = format_date($utilisateur_Date_naissance);
        $utilisateur_Accepte_mail_publicitaire = ($utilisateur_Accepte_mail_publicitaire == true);
        $utilisateur_Administrateur = ($utilisateur_Administrateur == true);
        $utilisateur_Fournisseur = ($utilisateur_Fournisseur == true);
        // Fin typage
        Hook_utilisateur::pre_controller($utilisateur_Identifiant, $utilisateur_Password, $utilisateur_Email, $utilisateur_Civilite_Type, $utilisateur_Prenom, $utilisateur_Nom, $utilisateur_Adresse_1, $utilisateur_Adresse_2, $utilisateur_Ville, $utilisateur_Code_postal, $utilisateur_Date_naissance, $utilisateur_Accepte_mail_publicitaire, $utilisateur_Administrateur, $utilisateur_Fournisseur, $Code_utilisateur);
        if (! $force) {
            if (! self::$maj_droits_modifier_en_cours) {
                self::$maj_droits_modifier_en_cours = true;
                Hook_utilisateur::hook_actualiser_les_droits_modifier($Code_utilisateur);
                self::$maj_droits_modifier_en_cours = false;
            }
        }
        $utilisateur = $this->mf_get_2( $Code_utilisateur, ['autocompletion' => false, 'masquer_mdp' => false]);
        if ( !$force && !mf_matrice_droits(['utilisateur__MODIFIER']) ) $code_erreur = REFUS_UTILISATEUR__MODIFIER;
        elseif (! $this->mf_tester_existance_Code_utilisateur($Code_utilisateur)) $code_erreur = ERR_UTILISATEUR__MODIFIER__CODE_UTILISATEUR_INEXISTANT;
        elseif (CONTROLE_ACCES_DONNEES_DEFAUT && ! Hook_mf_systeme::controle_acces_donnees('Code_utilisateur', $Code_utilisateur)) $code_erreur = ACCES_CODE_UTILISATEUR_REFUSE;
        elseif ( !Hook_utilisateur::autorisation_modification($Code_utilisateur, $utilisateur_Identifiant, $utilisateur_Password, $utilisateur_Email, $utilisateur_Civilite_Type, $utilisateur_Prenom, $utilisateur_Nom, $utilisateur_Adresse_1, $utilisateur_Adresse_2, $utilisateur_Ville, $utilisateur_Code_postal, $utilisateur_Date_naissance, $utilisateur_Accepte_mail_publicitaire, $utilisateur_Administrateur, $utilisateur_Fournisseur) ) $code_erreur = REFUS_UTILISATEUR__MODIFICATION_BLOQUEE;
        elseif ($this->rechercher_utilisateur_Identifiant($utilisateur_Identifiant) != 0 && $this->rechercher_utilisateur_Identifiant($utilisateur_Identifiant)!=$Code_utilisateur) $code_erreur = ERR_UTILISATEUR__AJOUTER__UTILISATEUR_IDENTIFIANT_DOUBLON;
        elseif (! in_array($utilisateur_Civilite_Type, liste_union_A_et_B([$utilisateur_Civilite_Type], Hook_utilisateur::workflow__utilisateur_Civilite_Type($utilisateur['utilisateur_Civilite_Type'])))) $code_erreur = ERR_UTILISATEUR__MODIFIER__UTILISATEUR_CIVILITE_TYPE__HORS_WORKFLOW;
        elseif (! controle_parametre("utilisateur_Civilite_Type", $utilisateur_Civilite_Type)) $code_erreur = ERR_UTILISATEUR__MODIFIER__UTILISATEUR_CIVILITE_TYPE_NON_VALIDE;
        else {
            if (! isset(self::$lock[$Code_utilisateur])) {
                self::$lock[$Code_utilisateur] = 0;
            }
            if (self::$lock[$Code_utilisateur] == 0) {
                self::$cache_db->add_lock((string) $Code_utilisateur);
            }
            self::$lock[$Code_utilisateur]++;
            Hook_utilisateur::data_controller($utilisateur_Identifiant, $utilisateur_Password, $utilisateur_Email, $utilisateur_Civilite_Type, $utilisateur_Prenom, $utilisateur_Nom, $utilisateur_Adresse_1, $utilisateur_Adresse_2, $utilisateur_Ville, $utilisateur_Code_postal, $utilisateur_Date_naissance, $utilisateur_Accepte_mail_publicitaire, $utilisateur_Administrateur, $utilisateur_Fournisseur, $Code_utilisateur);
            $mf_colonnes_a_modifier=[];
            $bool__utilisateur_Identifiant = false; if ($utilisateur_Identifiant !== $utilisateur['utilisateur_Identifiant']) {Hook_utilisateur::data_controller__utilisateur_Identifiant($utilisateur['utilisateur_Identifiant'], $utilisateur_Identifiant, $Code_utilisateur); if ( $utilisateur_Identifiant !== $utilisateur['utilisateur_Identifiant'] ) { $mf_colonnes_a_modifier[] = 'utilisateur_Identifiant=' . format_sql('utilisateur_Identifiant', $utilisateur_Identifiant); $bool__utilisateur_Identifiant = true;}}
            $bool__utilisateur_Password = false; if ($utilisateur_Password !== '') {$mf_colonnes_a_modifier[] = 'utilisateur_Password = ' . format_sql('utilisateur_Password', $utilisateur_Password); $bool__utilisateur_Password = true;}
            $bool__utilisateur_Email = false; if ($utilisateur_Email !== $utilisateur['utilisateur_Email']) {Hook_utilisateur::data_controller__utilisateur_Email($utilisateur['utilisateur_Email'], $utilisateur_Email, $Code_utilisateur); if ( $utilisateur_Email !== $utilisateur['utilisateur_Email'] ) { $mf_colonnes_a_modifier[] = 'utilisateur_Email=' . format_sql('utilisateur_Email', $utilisateur_Email); $bool__utilisateur_Email = true;}}
            $bool__utilisateur_Civilite_Type = false; if ($utilisateur_Civilite_Type !== $utilisateur['utilisateur_Civilite_Type']) {Hook_utilisateur::data_controller__utilisateur_Civilite_Type($utilisateur['utilisateur_Civilite_Type'], $utilisateur_Civilite_Type, $Code_utilisateur); if ( $utilisateur_Civilite_Type !== $utilisateur['utilisateur_Civilite_Type'] ) { $mf_colonnes_a_modifier[] = 'utilisateur_Civilite_Type=' . format_sql('utilisateur_Civilite_Type', $utilisateur_Civilite_Type); $bool__utilisateur_Civilite_Type = true;}}
            $bool__utilisateur_Prenom = false; if ($utilisateur_Prenom !== $utilisateur['utilisateur_Prenom']) {Hook_utilisateur::data_controller__utilisateur_Prenom($utilisateur['utilisateur_Prenom'], $utilisateur_Prenom, $Code_utilisateur); if ( $utilisateur_Prenom !== $utilisateur['utilisateur_Prenom'] ) { $mf_colonnes_a_modifier[] = 'utilisateur_Prenom=' . format_sql('utilisateur_Prenom', $utilisateur_Prenom); $bool__utilisateur_Prenom = true;}}
            $bool__utilisateur_Nom = false; if ($utilisateur_Nom !== $utilisateur['utilisateur_Nom']) {Hook_utilisateur::data_controller__utilisateur_Nom($utilisateur['utilisateur_Nom'], $utilisateur_Nom, $Code_utilisateur); if ( $utilisateur_Nom !== $utilisateur['utilisateur_Nom'] ) { $mf_colonnes_a_modifier[] = 'utilisateur_Nom=' . format_sql('utilisateur_Nom', $utilisateur_Nom); $bool__utilisateur_Nom = true;}}
            $bool__utilisateur_Adresse_1 = false; if ($utilisateur_Adresse_1 !== $utilisateur['utilisateur_Adresse_1']) {Hook_utilisateur::data_controller__utilisateur_Adresse_1($utilisateur['utilisateur_Adresse_1'], $utilisateur_Adresse_1, $Code_utilisateur); if ( $utilisateur_Adresse_1 !== $utilisateur['utilisateur_Adresse_1'] ) { $mf_colonnes_a_modifier[] = 'utilisateur_Adresse_1=' . format_sql('utilisateur_Adresse_1', $utilisateur_Adresse_1); $bool__utilisateur_Adresse_1 = true;}}
            $bool__utilisateur_Adresse_2 = false; if ($utilisateur_Adresse_2 !== $utilisateur['utilisateur_Adresse_2']) {Hook_utilisateur::data_controller__utilisateur_Adresse_2($utilisateur['utilisateur_Adresse_2'], $utilisateur_Adresse_2, $Code_utilisateur); if ( $utilisateur_Adresse_2 !== $utilisateur['utilisateur_Adresse_2'] ) { $mf_colonnes_a_modifier[] = 'utilisateur_Adresse_2=' . format_sql('utilisateur_Adresse_2', $utilisateur_Adresse_2); $bool__utilisateur_Adresse_2 = true;}}
            $bool__utilisateur_Ville = false; if ($utilisateur_Ville !== $utilisateur['utilisateur_Ville']) {Hook_utilisateur::data_controller__utilisateur_Ville($utilisateur['utilisateur_Ville'], $utilisateur_Ville, $Code_utilisateur); if ( $utilisateur_Ville !== $utilisateur['utilisateur_Ville'] ) { $mf_colonnes_a_modifier[] = 'utilisateur_Ville=' . format_sql('utilisateur_Ville', $utilisateur_Ville); $bool__utilisateur_Ville = true;}}
            $bool__utilisateur_Code_postal = false; if ($utilisateur_Code_postal !== $utilisateur['utilisateur_Code_postal']) {Hook_utilisateur::data_controller__utilisateur_Code_postal($utilisateur['utilisateur_Code_postal'], $utilisateur_Code_postal, $Code_utilisateur); if ( $utilisateur_Code_postal !== $utilisateur['utilisateur_Code_postal'] ) { $mf_colonnes_a_modifier[] = 'utilisateur_Code_postal=' . format_sql('utilisateur_Code_postal', $utilisateur_Code_postal); $bool__utilisateur_Code_postal = true;}}
            $bool__utilisateur_Date_naissance = false; if ($utilisateur_Date_naissance !== $utilisateur['utilisateur_Date_naissance']) {Hook_utilisateur::data_controller__utilisateur_Date_naissance($utilisateur['utilisateur_Date_naissance'], $utilisateur_Date_naissance, $Code_utilisateur); if ( $utilisateur_Date_naissance !== $utilisateur['utilisateur_Date_naissance'] ) { $mf_colonnes_a_modifier[] = 'utilisateur_Date_naissance=' . format_sql('utilisateur_Date_naissance', $utilisateur_Date_naissance); $bool__utilisateur_Date_naissance = true;}}
            $bool__utilisateur_Accepte_mail_publicitaire = false; if ($utilisateur_Accepte_mail_publicitaire !== $utilisateur['utilisateur_Accepte_mail_publicitaire']) {Hook_utilisateur::data_controller__utilisateur_Accepte_mail_publicitaire($utilisateur['utilisateur_Accepte_mail_publicitaire'], $utilisateur_Accepte_mail_publicitaire, $Code_utilisateur); if ( $utilisateur_Accepte_mail_publicitaire !== $utilisateur['utilisateur_Accepte_mail_publicitaire'] ) { $mf_colonnes_a_modifier[] = 'utilisateur_Accepte_mail_publicitaire=' . format_sql('utilisateur_Accepte_mail_publicitaire', $utilisateur_Accepte_mail_publicitaire); $bool__utilisateur_Accepte_mail_publicitaire = true;}}
            $bool__utilisateur_Administrateur = false; if ($utilisateur_Administrateur !== $utilisateur['utilisateur_Administrateur']) {Hook_utilisateur::data_controller__utilisateur_Administrateur($utilisateur['utilisateur_Administrateur'], $utilisateur_Administrateur, $Code_utilisateur); if ( $utilisateur_Administrateur !== $utilisateur['utilisateur_Administrateur'] ) { $mf_colonnes_a_modifier[] = 'utilisateur_Administrateur=' . format_sql('utilisateur_Administrateur', $utilisateur_Administrateur); $bool__utilisateur_Administrateur = true;}}
            $bool__utilisateur_Fournisseur = false; if ($utilisateur_Fournisseur !== $utilisateur['utilisateur_Fournisseur']) {Hook_utilisateur::data_controller__utilisateur_Fournisseur($utilisateur['utilisateur_Fournisseur'], $utilisateur_Fournisseur, $Code_utilisateur); if ( $utilisateur_Fournisseur !== $utilisateur['utilisateur_Fournisseur'] ) { $mf_colonnes_a_modifier[] = 'utilisateur_Fournisseur=' . format_sql('utilisateur_Fournisseur', $utilisateur_Fournisseur); $bool__utilisateur_Fournisseur = true;}}
            if (count($mf_colonnes_a_modifier) > 0) {
                $mf_signature = text_sql(Hook_utilisateur::calcul_signature($utilisateur_Identifiant, $utilisateur_Email, $utilisateur_Civilite_Type, $utilisateur_Prenom, $utilisateur_Nom, $utilisateur_Adresse_1, $utilisateur_Adresse_2, $utilisateur_Ville, $utilisateur_Code_postal, $utilisateur_Date_naissance, $utilisateur_Accepte_mail_publicitaire, $utilisateur_Administrateur, $utilisateur_Fournisseur));
                $mf_cle_unique = text_sql(Hook_utilisateur::calcul_cle_unique($utilisateur_Identifiant, $utilisateur_Email, $utilisateur_Civilite_Type, $utilisateur_Prenom, $utilisateur_Nom, $utilisateur_Adresse_1, $utilisateur_Adresse_2, $utilisateur_Ville, $utilisateur_Code_postal, $utilisateur_Date_naissance, $utilisateur_Accepte_mail_publicitaire, $utilisateur_Administrateur, $utilisateur_Fournisseur));
                $mf_colonnes_a_modifier[] = 'mf_signature=\'' . $mf_signature . '\'';
                $mf_colonnes_a_modifier[] = 'mf_cle_unique=\'' . $mf_cle_unique . '\'';
                $mf_colonnes_a_modifier[] = 'mf_date_modification=\'' . get_now() . '\'';
                $requete = 'UPDATE '.inst('utilisateur').' SET ' . enumeration($mf_colonnes_a_modifier) . ' WHERE Code_utilisateur = ' . $Code_utilisateur . ';';
                executer_requete_mysql($requete, array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
                if (requete_mysqli_affected_rows() == 0) {
                    $code_erreur = ERR_UTILISATEUR__MODIFIER__AUCUN_CHANGEMENT;
                } else {
                    self::$cache_db->clear();
                    Hook_utilisateur::modifier($Code_utilisateur, $bool__utilisateur_Identifiant, $bool__utilisateur_Password, $bool__utilisateur_Email, $bool__utilisateur_Civilite_Type, $bool__utilisateur_Prenom, $bool__utilisateur_Nom, $bool__utilisateur_Adresse_1, $bool__utilisateur_Adresse_2, $bool__utilisateur_Ville, $bool__utilisateur_Code_postal, $bool__utilisateur_Date_naissance, $bool__utilisateur_Accepte_mail_publicitaire, $bool__utilisateur_Administrateur, $bool__utilisateur_Fournisseur);
                }
            } else {
                $code_erreur = ERR_UTILISATEUR__MODIFIER__AUCUN_CHANGEMENT;
            }
            self::$lock[$Code_utilisateur]--;
            if (self::$lock[$Code_utilisateur] == 0) {
                self::$cache_db->release_lock((string) $Code_utilisateur);
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
        return ['code_erreur' => $code_erreur, 'callback' => ($code_erreur == 0 ? Hook_utilisateur::callback_put($Code_utilisateur) : null)];
    }

    public function mf_modifier_2(array $lignes, ?bool $force = null) // array( $Code_utilisateur => array('colonne1' => 'valeur1',  [...] ) )
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        foreach ($lignes as $Code_utilisateur => $colonnes) {
            if ($code_erreur == 0) {
                $Code_utilisateur = intval($Code_utilisateur);
                $utilisateur = $this->mf_get_2($Code_utilisateur, ['autocompletion' => false]);
                if (! $force) {
                    if (! self::$maj_droits_modifier_en_cours) {
                        self::$maj_droits_modifier_en_cours = true;
                        Hook_utilisateur::hook_actualiser_les_droits_modifier($Code_utilisateur);
                        self::$maj_droits_modifier_en_cours = false;
                    }
                }
                $utilisateur_Identifiant = (isset($colonnes['utilisateur_Identifiant']) && ( $force || mf_matrice_droits(['api_modifier__utilisateur_Identifiant', 'utilisateur__MODIFIER']) ) ? $colonnes['utilisateur_Identifiant'] : ( isset($utilisateur['utilisateur_Identifiant']) ? $utilisateur['utilisateur_Identifiant'] : '' ) );
                $utilisateur_Password = (isset($colonnes['utilisateur_Password']) && ( $force || mf_matrice_droits(['api_modifier__utilisateur_Password', 'utilisateur__MODIFIER']) ) ? $colonnes['utilisateur_Password'] : '' );
                $utilisateur_Email = (isset($colonnes['utilisateur_Email']) && ( $force || mf_matrice_droits(['api_modifier__utilisateur_Email', 'utilisateur__MODIFIER']) ) ? $colonnes['utilisateur_Email'] : ( isset($utilisateur['utilisateur_Email']) ? $utilisateur['utilisateur_Email'] : '' ) );
                $utilisateur_Civilite_Type = (isset($colonnes['utilisateur_Civilite_Type']) && ( $force || mf_matrice_droits(['api_modifier__utilisateur_Civilite_Type', 'utilisateur__MODIFIER']) ) ? $colonnes['utilisateur_Civilite_Type'] : ( isset($utilisateur['utilisateur_Civilite_Type']) ? $utilisateur['utilisateur_Civilite_Type'] : '' ) );
                $utilisateur_Prenom = (isset($colonnes['utilisateur_Prenom']) && ( $force || mf_matrice_droits(['api_modifier__utilisateur_Prenom', 'utilisateur__MODIFIER']) ) ? $colonnes['utilisateur_Prenom'] : ( isset($utilisateur['utilisateur_Prenom']) ? $utilisateur['utilisateur_Prenom'] : '' ) );
                $utilisateur_Nom = (isset($colonnes['utilisateur_Nom']) && ( $force || mf_matrice_droits(['api_modifier__utilisateur_Nom', 'utilisateur__MODIFIER']) ) ? $colonnes['utilisateur_Nom'] : ( isset($utilisateur['utilisateur_Nom']) ? $utilisateur['utilisateur_Nom'] : '' ) );
                $utilisateur_Adresse_1 = (isset($colonnes['utilisateur_Adresse_1']) && ( $force || mf_matrice_droits(['api_modifier__utilisateur_Adresse_1', 'utilisateur__MODIFIER']) ) ? $colonnes['utilisateur_Adresse_1'] : ( isset($utilisateur['utilisateur_Adresse_1']) ? $utilisateur['utilisateur_Adresse_1'] : '' ) );
                $utilisateur_Adresse_2 = (isset($colonnes['utilisateur_Adresse_2']) && ( $force || mf_matrice_droits(['api_modifier__utilisateur_Adresse_2', 'utilisateur__MODIFIER']) ) ? $colonnes['utilisateur_Adresse_2'] : ( isset($utilisateur['utilisateur_Adresse_2']) ? $utilisateur['utilisateur_Adresse_2'] : '' ) );
                $utilisateur_Ville = (isset($colonnes['utilisateur_Ville']) && ( $force || mf_matrice_droits(['api_modifier__utilisateur_Ville', 'utilisateur__MODIFIER']) ) ? $colonnes['utilisateur_Ville'] : ( isset($utilisateur['utilisateur_Ville']) ? $utilisateur['utilisateur_Ville'] : '' ) );
                $utilisateur_Code_postal = (isset($colonnes['utilisateur_Code_postal']) && ( $force || mf_matrice_droits(['api_modifier__utilisateur_Code_postal', 'utilisateur__MODIFIER']) ) ? $colonnes['utilisateur_Code_postal'] : ( isset($utilisateur['utilisateur_Code_postal']) ? $utilisateur['utilisateur_Code_postal'] : '' ) );
                $utilisateur_Date_naissance = (isset($colonnes['utilisateur_Date_naissance']) && ( $force || mf_matrice_droits(['api_modifier__utilisateur_Date_naissance', 'utilisateur__MODIFIER']) ) ? $colonnes['utilisateur_Date_naissance'] : ( isset($utilisateur['utilisateur_Date_naissance']) ? $utilisateur['utilisateur_Date_naissance'] : '' ) );
                $utilisateur_Accepte_mail_publicitaire = (isset($colonnes['utilisateur_Accepte_mail_publicitaire']) && ( $force || mf_matrice_droits(['api_modifier__utilisateur_Accepte_mail_publicitaire', 'utilisateur__MODIFIER']) ) ? $colonnes['utilisateur_Accepte_mail_publicitaire'] : ( isset($utilisateur['utilisateur_Accepte_mail_publicitaire']) ? $utilisateur['utilisateur_Accepte_mail_publicitaire'] : '' ) );
                $utilisateur_Administrateur = (isset($colonnes['utilisateur_Administrateur']) && ( $force || mf_matrice_droits(['api_modifier__utilisateur_Administrateur', 'utilisateur__MODIFIER']) ) ? $colonnes['utilisateur_Administrateur'] : ( isset($utilisateur['utilisateur_Administrateur']) ? $utilisateur['utilisateur_Administrateur'] : '' ) );
                $utilisateur_Fournisseur = (isset($colonnes['utilisateur_Fournisseur']) && ( $force || mf_matrice_droits(['api_modifier__utilisateur_Fournisseur', 'utilisateur__MODIFIER']) ) ? $colonnes['utilisateur_Fournisseur'] : ( isset($utilisateur['utilisateur_Fournisseur']) ? $utilisateur['utilisateur_Fournisseur'] : '' ) );
                // Typage
                $utilisateur_Identifiant = (string) $utilisateur_Identifiant;
                $utilisateur_Password = (string) $utilisateur_Password;
                $utilisateur_Email = (string) $utilisateur_Email;
                $utilisateur_Civilite_Type = is_null($utilisateur_Civilite_Type) || $utilisateur_Civilite_Type === '' ? null : (int) $utilisateur_Civilite_Type;
                $utilisateur_Prenom = (string) $utilisateur_Prenom;
                $utilisateur_Nom = (string) $utilisateur_Nom;
                $utilisateur_Adresse_1 = (string) $utilisateur_Adresse_1;
                $utilisateur_Adresse_2 = (string) $utilisateur_Adresse_2;
                $utilisateur_Ville = (string) $utilisateur_Ville;
                $utilisateur_Code_postal = (string) $utilisateur_Code_postal;
                $utilisateur_Date_naissance = format_date($utilisateur_Date_naissance);
                $utilisateur_Accepte_mail_publicitaire = ($utilisateur_Accepte_mail_publicitaire == true);
                $utilisateur_Administrateur = ($utilisateur_Administrateur == true);
                $utilisateur_Fournisseur = ($utilisateur_Fournisseur == true);
                // Fin typage
                $retour = $this->mf_modifier($Code_utilisateur, $utilisateur_Identifiant, $utilisateur_Password, $utilisateur_Email, $utilisateur_Civilite_Type, $utilisateur_Prenom, $utilisateur_Nom, $utilisateur_Adresse_1, $utilisateur_Adresse_2, $utilisateur_Ville, $utilisateur_Code_postal, $utilisateur_Date_naissance, $utilisateur_Accepte_mail_publicitaire, $utilisateur_Administrateur, $utilisateur_Fournisseur, true);
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
        return ['code_erreur' => $code_erreur];
    }

    public function mf_modifier_3(array $lignes) // array( $Code_utilisateur => array('colonne1' => 'valeur1',  [...] ) )
    {
        $code_erreur = 0;
        $modifs = false;

        // transformation des lignes en colonnes
        $valeurs_en_colonnes = [];
        $indices_par_colonne = [];
        $liste_valeurs_indexees = [];
        foreach ($lignes as $Code_utilisateur => $colonnes) {
            foreach ($colonnes as $colonne => $valeur) {
                if ($colonne == 'utilisateur_Identifiant' || $colonne == 'utilisateur_Password' || $colonne == 'utilisateur_Email' || $colonne == 'utilisateur_Civilite_Type' || $colonne == 'utilisateur_Prenom' || $colonne == 'utilisateur_Nom' || $colonne == 'utilisateur_Adresse_1' || $colonne == 'utilisateur_Adresse_2' || $colonne == 'utilisateur_Ville' || $colonne == 'utilisateur_Code_postal' || $colonne == 'utilisateur_Date_naissance' || $colonne == 'utilisateur_Accepte_mail_publicitaire' || $colonne == 'utilisateur_Administrateur' || $colonne == 'utilisateur_Fournisseur') {
                    $valeurs_en_colonnes[$colonne][$Code_utilisateur] = $valeur;
                    $indices_par_colonne[$colonne][] = $Code_utilisateur;
                    $liste_valeurs_indexees[$colonne]["$valeur"][] = $Code_utilisateur;
                }
            }
        }

        // fabrication des requetes
        foreach ($valeurs_en_colonnes as $colonne => $valeurs) {
            if (count($liste_valeurs_indexees[$colonne]) > 3) {
                $modification_sql = $colonne . ' = CASE Code_utilisateur';
                foreach ($valeurs as $Code_utilisateur => $valeur) {
                    $modification_sql .= ' WHEN ' . $Code_utilisateur . ' THEN ' . format_sql($colonne, $valeur);
                }
                $modification_sql .= ' END';
                $perimetre = Sql_Format_Liste($indices_par_colonne[$colonne]);
                executer_requete_mysql('UPDATE ' . inst('utilisateur') . ' SET ' . $modification_sql . ' WHERE Code_utilisateur IN ' . $perimetre . ';', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
                if (requete_mysqli_affected_rows() != 0) {
                    $modifs = true;
                }
            } else {
                foreach ($liste_valeurs_indexees[$colonne] as $valeur => $indices_par_valeur) {
                    $perimetre = Sql_Format_Liste($indices_par_valeur);
                    executer_requete_mysql('UPDATE ' . inst('utilisateur') . ' SET ' . $colonne . ' = ' . format_sql($colonne, $valeur) . ' WHERE Code_utilisateur IN ' . $perimetre . ';', array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
                    if (requete_mysqli_affected_rows() != 0) {
                        $modifs = true;
                    }
                }
            }
        }

        if (! $modifs && $code_erreur == 0) {
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
        return ['code_erreur' => $code_erreur];
    }

    public function mf_modifier_4( array $data, ?array $options = null /* $options = array( 'cond_mysql' => [], 'limit' => 0 ) */ ) // $data = array('colonne1' => 'valeur1', ... )
    {
        $code_erreur = 0;
        $mf_colonnes_a_modifier=[];
        if (isset($data['utilisateur_Identifiant']) || array_key_exists('utilisateur_Identifiant', $data)) { $mf_colonnes_a_modifier[] = 'utilisateur_Identifiant = ' . format_sql('utilisateur_Identifiant', $data['utilisateur_Identifiant']); }
        if (isset($data['utilisateur_Password']) || array_key_exists('utilisateur_Password', $data)) { $mf_colonnes_a_modifier[] = 'utilisateur_Password = ' . format_sql('utilisateur_Password', $data['utilisateur_Password']); }
        if (isset($data['utilisateur_Email']) || array_key_exists('utilisateur_Email', $data)) { $mf_colonnes_a_modifier[] = 'utilisateur_Email = ' . format_sql('utilisateur_Email', $data['utilisateur_Email']); }
        if (isset($data['utilisateur_Civilite_Type']) || array_key_exists('utilisateur_Civilite_Type', $data)) { $mf_colonnes_a_modifier[] = 'utilisateur_Civilite_Type = ' . format_sql('utilisateur_Civilite_Type', $data['utilisateur_Civilite_Type']); }
        if (isset($data['utilisateur_Prenom']) || array_key_exists('utilisateur_Prenom', $data)) { $mf_colonnes_a_modifier[] = 'utilisateur_Prenom = ' . format_sql('utilisateur_Prenom', $data['utilisateur_Prenom']); }
        if (isset($data['utilisateur_Nom']) || array_key_exists('utilisateur_Nom', $data)) { $mf_colonnes_a_modifier[] = 'utilisateur_Nom = ' . format_sql('utilisateur_Nom', $data['utilisateur_Nom']); }
        if (isset($data['utilisateur_Adresse_1']) || array_key_exists('utilisateur_Adresse_1', $data)) { $mf_colonnes_a_modifier[] = 'utilisateur_Adresse_1 = ' . format_sql('utilisateur_Adresse_1', $data['utilisateur_Adresse_1']); }
        if (isset($data['utilisateur_Adresse_2']) || array_key_exists('utilisateur_Adresse_2', $data)) { $mf_colonnes_a_modifier[] = 'utilisateur_Adresse_2 = ' . format_sql('utilisateur_Adresse_2', $data['utilisateur_Adresse_2']); }
        if (isset($data['utilisateur_Ville']) || array_key_exists('utilisateur_Ville', $data)) { $mf_colonnes_a_modifier[] = 'utilisateur_Ville = ' . format_sql('utilisateur_Ville', $data['utilisateur_Ville']); }
        if (isset($data['utilisateur_Code_postal']) || array_key_exists('utilisateur_Code_postal', $data)) { $mf_colonnes_a_modifier[] = 'utilisateur_Code_postal = ' . format_sql('utilisateur_Code_postal', $data['utilisateur_Code_postal']); }
        if (isset($data['utilisateur_Date_naissance']) || array_key_exists('utilisateur_Date_naissance', $data)) { $mf_colonnes_a_modifier[] = 'utilisateur_Date_naissance = ' . format_sql('utilisateur_Date_naissance', $data['utilisateur_Date_naissance']); }
        if (isset($data['utilisateur_Accepte_mail_publicitaire']) || array_key_exists('utilisateur_Accepte_mail_publicitaire', $data)) { $mf_colonnes_a_modifier[] = 'utilisateur_Accepte_mail_publicitaire = ' . format_sql('utilisateur_Accepte_mail_publicitaire', $data['utilisateur_Accepte_mail_publicitaire']); }
        if (isset($data['utilisateur_Administrateur']) || array_key_exists('utilisateur_Administrateur', $data)) { $mf_colonnes_a_modifier[] = 'utilisateur_Administrateur = ' . format_sql('utilisateur_Administrateur', $data['utilisateur_Administrateur']); }
        if (isset($data['utilisateur_Fournisseur']) || array_key_exists('utilisateur_Fournisseur', $data)) { $mf_colonnes_a_modifier[] = 'utilisateur_Fournisseur = ' . format_sql('utilisateur_Fournisseur', $data['utilisateur_Fournisseur']); }
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

            $requete = 'UPDATE ' . inst('utilisateur') . ' SET ' . enumeration($mf_colonnes_a_modifier) . " WHERE 1$argument_cond" . ( $limit>0 ? ' LIMIT ' . $limit : '' ) . ";";
            executer_requete_mysql( $requete , array_search('utilisateur', LISTE_TABLES_HISTORIQUE_DESACTIVE) === false);
            if (requete_mysqli_affected_rows() == 0) {
                $code_erreur = ERR_UTILISATEUR__MODIFIER_4__AUCUN_CHANGEMENT;
            } else {
                self::$cache_db->clear();
            }
        }
        return ['code_erreur' => $code_erreur];
    }

    public function mf_supprimer(int $Code_utilisateur, ?bool $force = null)
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        $Code_utilisateur = intval($Code_utilisateur);
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
            $copie__utilisateur = $this->mf_get($Code_utilisateur, ['autocompletion' => false]);
            $this->supprimer_donnes_en_cascade("utilisateur", [$Code_utilisateur]);
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
        return ['code_erreur' => $code_erreur];
    }

    public function mf_supprimer_2(array $liste_Code_utilisateur, ?bool $force = null)
    {
        if ($force === null) {
            $force = false;
        }
        $code_erreur = 0;
        $copie__liste_utilisateur = $this->mf_lister_2($liste_Code_utilisateur, ['autocompletion' => false]);
        $liste_Code_utilisateur=[];
        foreach ( $copie__liste_utilisateur as $copie__utilisateur )
        {
            $Code_utilisateur = $copie__utilisateur['Code_utilisateur'];
            if (! $force) {
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
        if ($code_erreur == 0 && count($liste_Code_utilisateur) > 0) {
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
        return ['code_erreur' => $code_erreur];
    }

    public function mf_supprimer_3(array $liste_Code_utilisateur)
    {
        $code_erreur = 0;
        if (count($liste_Code_utilisateur) > 0) {
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
        global $mf_contexte;
        if (! $contexte_parent && $mf_contexte['Code_utilisateur'] != 0) {
            $utilisateur = $this->mf_get( $mf_contexte['Code_utilisateur'], $options);
            return [$utilisateur['Code_utilisateur'] => $utilisateur];
        } else {
            return $this->mf_lister($options);
        }
    }

    public function mf_lister(?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'liste_colonnes_a_selectionner' => [], 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cle = "utilisateur__lister";

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
            $liste_utilisateur_pas_a_jour = [];
            if (false === $liste = self::$cache_db->read($cle)) {

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
                if (isset($options['tris'])) {
                    if ( isset($options['tris']['utilisateur_Identifiant']) ) { $liste_colonnes_a_indexer['utilisateur_Identifiant'] = 'utilisateur_Identifiant'; }
                    if ( isset($options['tris']['utilisateur_Password']) ) { $liste_colonnes_a_indexer['utilisateur_Password'] = 'utilisateur_Password'; }
                    if ( isset($options['tris']['utilisateur_Email']) ) { $liste_colonnes_a_indexer['utilisateur_Email'] = 'utilisateur_Email'; }
                    if ( isset($options['tris']['utilisateur_Civilite_Type']) ) { $liste_colonnes_a_indexer['utilisateur_Civilite_Type'] = 'utilisateur_Civilite_Type'; }
                    if ( isset($options['tris']['utilisateur_Prenom']) ) { $liste_colonnes_a_indexer['utilisateur_Prenom'] = 'utilisateur_Prenom'; }
                    if ( isset($options['tris']['utilisateur_Nom']) ) { $liste_colonnes_a_indexer['utilisateur_Nom'] = 'utilisateur_Nom'; }
                    if ( isset($options['tris']['utilisateur_Adresse_1']) ) { $liste_colonnes_a_indexer['utilisateur_Adresse_1'] = 'utilisateur_Adresse_1'; }
                    if ( isset($options['tris']['utilisateur_Adresse_2']) ) { $liste_colonnes_a_indexer['utilisateur_Adresse_2'] = 'utilisateur_Adresse_2'; }
                    if ( isset($options['tris']['utilisateur_Ville']) ) { $liste_colonnes_a_indexer['utilisateur_Ville'] = 'utilisateur_Ville'; }
                    if ( isset($options['tris']['utilisateur_Code_postal']) ) { $liste_colonnes_a_indexer['utilisateur_Code_postal'] = 'utilisateur_Code_postal'; }
                    if ( isset($options['tris']['utilisateur_Date_naissance']) ) { $liste_colonnes_a_indexer['utilisateur_Date_naissance'] = 'utilisateur_Date_naissance'; }
                    if ( isset($options['tris']['utilisateur_Accepte_mail_publicitaire']) ) { $liste_colonnes_a_indexer['utilisateur_Accepte_mail_publicitaire'] = 'utilisateur_Accepte_mail_publicitaire'; }
                    if ( isset($options['tris']['utilisateur_Administrateur']) ) { $liste_colonnes_a_indexer['utilisateur_Administrateur'] = 'utilisateur_Administrateur'; }
                    if ( isset($options['tris']['utilisateur_Fournisseur']) ) { $liste_colonnes_a_indexer['utilisateur_Fournisseur'] = 'utilisateur_Fournisseur'; }
                }
                if (count($liste_colonnes_a_indexer) > 0) {
                    if (false === $mf_liste_requete_index = self::$cache_db->read('utilisateur__index')) {
                        $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('utilisateur').'`;', false);
                        $mf_liste_requete_index = [];
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

                if (count($liste_colonnes_a_selectionner) == 0) {
                    if ($toutes_colonnes) {
                        $colonnes = 'Code_utilisateur, utilisateur_Identifiant, utilisateur_Password, utilisateur_Email, utilisateur_Civilite_Type, utilisateur_Prenom, utilisateur_Nom, utilisateur_Adresse_1, utilisateur_Adresse_2, utilisateur_Ville, utilisateur_Code_postal, utilisateur_Date_naissance, utilisateur_Accepte_mail_publicitaire, utilisateur_Administrateur, utilisateur_Fournisseur';
                    } else {
                        $colonnes = 'Code_utilisateur, utilisateur_Identifiant, utilisateur_Password, utilisateur_Email, utilisateur_Civilite_Type, utilisateur_Prenom, utilisateur_Nom, utilisateur_Adresse_1, utilisateur_Adresse_2, utilisateur_Ville, utilisateur_Code_postal, utilisateur_Date_naissance, utilisateur_Accepte_mail_publicitaire, utilisateur_Administrateur, utilisateur_Fournisseur';
                    }
                } else {
                    $liste_colonnes_a_selectionner[] = 'Code_utilisateur';
                    $colonnes = enumeration($liste_colonnes_a_selectionner, ',');
                }

                $liste = [];
                $liste_utilisateur_pas_a_jour = [];
                $res_requete = executer_requete_mysql("SELECT $colonnes FROM " . inst('utilisateur') . " WHERE 1{$argument_cond}{$argument_tris}{$argument_limit};", false);
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
                Hook_utilisateur::mettre_a_jour( $liste_utilisateur_pas_a_jour );
            }
        }

        foreach ($liste as $elem) {
            if ($controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_utilisateur', $elem['Code_utilisateur'])) {
                unset($liste[$elem['Code_utilisateur']]);
            } else {
                if (($autocompletion_recursive || self::$auto_completion < 1) && $autocompletion) {
                    self::$auto_completion ++;
                    Hook_utilisateur::completion($liste[$elem['Code_utilisateur']], self::$auto_completion - 1);
                    self::$auto_completion --;
                }
            }
        }

        return $liste;
    }

    public function mf_lister_2(array $liste_Code_utilisateur, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'liste_colonnes_a_selectionner' => [], 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
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
                $liste_utilisateur_pas_a_jour = [];
                if (false === $liste = self::$cache_db->read($cle)) {

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
                    if (isset($options['tris'])) {
                        if ( isset($options['tris']['utilisateur_Identifiant']) ) { $liste_colonnes_a_indexer['utilisateur_Identifiant'] = 'utilisateur_Identifiant'; }
                        if ( isset($options['tris']['utilisateur_Password']) ) { $liste_colonnes_a_indexer['utilisateur_Password'] = 'utilisateur_Password'; }
                        if ( isset($options['tris']['utilisateur_Email']) ) { $liste_colonnes_a_indexer['utilisateur_Email'] = 'utilisateur_Email'; }
                        if ( isset($options['tris']['utilisateur_Civilite_Type']) ) { $liste_colonnes_a_indexer['utilisateur_Civilite_Type'] = 'utilisateur_Civilite_Type'; }
                        if ( isset($options['tris']['utilisateur_Prenom']) ) { $liste_colonnes_a_indexer['utilisateur_Prenom'] = 'utilisateur_Prenom'; }
                        if ( isset($options['tris']['utilisateur_Nom']) ) { $liste_colonnes_a_indexer['utilisateur_Nom'] = 'utilisateur_Nom'; }
                        if ( isset($options['tris']['utilisateur_Adresse_1']) ) { $liste_colonnes_a_indexer['utilisateur_Adresse_1'] = 'utilisateur_Adresse_1'; }
                        if ( isset($options['tris']['utilisateur_Adresse_2']) ) { $liste_colonnes_a_indexer['utilisateur_Adresse_2'] = 'utilisateur_Adresse_2'; }
                        if ( isset($options['tris']['utilisateur_Ville']) ) { $liste_colonnes_a_indexer['utilisateur_Ville'] = 'utilisateur_Ville'; }
                        if ( isset($options['tris']['utilisateur_Code_postal']) ) { $liste_colonnes_a_indexer['utilisateur_Code_postal'] = 'utilisateur_Code_postal'; }
                        if ( isset($options['tris']['utilisateur_Date_naissance']) ) { $liste_colonnes_a_indexer['utilisateur_Date_naissance'] = 'utilisateur_Date_naissance'; }
                        if ( isset($options['tris']['utilisateur_Accepte_mail_publicitaire']) ) { $liste_colonnes_a_indexer['utilisateur_Accepte_mail_publicitaire'] = 'utilisateur_Accepte_mail_publicitaire'; }
                        if ( isset($options['tris']['utilisateur_Administrateur']) ) { $liste_colonnes_a_indexer['utilisateur_Administrateur'] = 'utilisateur_Administrateur'; }
                        if ( isset($options['tris']['utilisateur_Fournisseur']) ) { $liste_colonnes_a_indexer['utilisateur_Fournisseur'] = 'utilisateur_Fournisseur'; }
                    }
                    if (count($liste_colonnes_a_indexer) > 0) {
                        if (false === $mf_liste_requete_index = self::$cache_db->read('utilisateur__index')) {
                            $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('utilisateur').'`;', false);
                            $mf_liste_requete_index = [];
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

                    if (count($liste_colonnes_a_selectionner) == 0) {
                        if ($toutes_colonnes) {
                            $colonnes = 'Code_utilisateur, utilisateur_Identifiant, utilisateur_Password, utilisateur_Email, utilisateur_Civilite_Type, utilisateur_Prenom, utilisateur_Nom, utilisateur_Adresse_1, utilisateur_Adresse_2, utilisateur_Ville, utilisateur_Code_postal, utilisateur_Date_naissance, utilisateur_Accepte_mail_publicitaire, utilisateur_Administrateur, utilisateur_Fournisseur';
                        } else {
                            $colonnes = 'Code_utilisateur, utilisateur_Identifiant, utilisateur_Password, utilisateur_Email, utilisateur_Civilite_Type, utilisateur_Prenom, utilisateur_Nom, utilisateur_Adresse_1, utilisateur_Adresse_2, utilisateur_Ville, utilisateur_Code_postal, utilisateur_Date_naissance, utilisateur_Accepte_mail_publicitaire, utilisateur_Administrateur, utilisateur_Fournisseur';
                        }
                    } else {
                        $liste_colonnes_a_selectionner[] = 'Code_utilisateur';
                        $colonnes = enumeration($liste_colonnes_a_selectionner, ',');
                    }

                    $liste = [];
                    $liste_utilisateur_pas_a_jour = [];
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
                if ($controle_acces_donnees && !Hook_mf_systeme::controle_acces_donnees('Code_utilisateur', $elem['Code_utilisateur'])) {
                    unset($liste[$elem['Code_utilisateur']]);
                } else {
                    if (($autocompletion_recursive || self::$auto_completion < 1) && $autocompletion) {
                        self::$auto_completion ++;
                        Hook_utilisateur::completion($liste[$elem['Code_utilisateur']], self::$auto_completion - 1);
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
        $Code_utilisateur = intval($Code_utilisateur);
        $retour = [];
        if ( ! CONTROLE_ACCES_DONNEES_DEFAUT || Hook_mf_systeme::controle_acces_donnees('Code_utilisateur', $Code_utilisateur) ) {
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
            while ($nouvelle_lecture) {
                $nouvelle_lecture = false;
                if (false === $retour = self::$cache_db->read($cle)) {
                    if ($toutes_colonnes) {
                        $colonnes='Code_utilisateur, utilisateur_Identifiant, utilisateur_Password, utilisateur_Email, utilisateur_Civilite_Type, utilisateur_Prenom, utilisateur_Nom, utilisateur_Adresse_1, utilisateur_Adresse_2, utilisateur_Ville, utilisateur_Code_postal, utilisateur_Date_naissance, utilisateur_Accepte_mail_publicitaire, utilisateur_Administrateur, utilisateur_Fournisseur';
                    } else {
                        $colonnes='Code_utilisateur, utilisateur_Identifiant, utilisateur_Password, utilisateur_Email, utilisateur_Civilite_Type, utilisateur_Prenom, utilisateur_Nom, utilisateur_Adresse_1, utilisateur_Adresse_2, utilisateur_Ville, utilisateur_Code_postal, utilisateur_Date_naissance, utilisateur_Accepte_mail_publicitaire, utilisateur_Administrateur, utilisateur_Fournisseur';
                    }
                    $res_requete = executer_requete_mysql("SELECT $colonnes FROM " . inst('utilisateur') . ' WHERE Code_utilisateur = ' . $Code_utilisateur . ';', false);
                    if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                        if ($masquer_mdp) {
                            unset($row_requete['utilisateur_Password']);
                        }
                        mf_formatage_db_type_php($row_requete);
                        $retour = $row_requete;
                        if ($maj && ! Hook_utilisateur::est_a_jour($row_requete)) {
                            $nouvelle_lecture = true;
                        }
                    } else {
                        $retour = [];
                    }
                    mysqli_free_result($res_requete);
                    if (! $nouvelle_lecture) {
                        self::$cache_db->write($cle, $retour);
                    } else {
                        Hook_utilisateur::mettre_a_jour([$row_requete['Code_utilisateur'] => $row_requete]);
                    }
                }
            }
            if (isset($retour['Code_utilisateur'])) {
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
                $Code_utilisateur = intval($row_requete['Code_utilisateur']);
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
        $Code_utilisateur = intval($Code_utilisateur);
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
                $colonnes='Code_utilisateur, utilisateur_Identifiant, utilisateur_Password, utilisateur_Email, utilisateur_Civilite_Type, utilisateur_Prenom, utilisateur_Nom, utilisateur_Adresse_1, utilisateur_Adresse_2, utilisateur_Ville, utilisateur_Code_postal, utilisateur_Date_naissance, utilisateur_Accepte_mail_publicitaire, utilisateur_Administrateur, utilisateur_Fournisseur';
            } else {
                $colonnes='Code_utilisateur, utilisateur_Identifiant, utilisateur_Password, utilisateur_Email, utilisateur_Civilite_Type, utilisateur_Prenom, utilisateur_Nom, utilisateur_Adresse_1, utilisateur_Adresse_2, utilisateur_Ville, utilisateur_Code_postal, utilisateur_Date_naissance, utilisateur_Accepte_mail_publicitaire, utilisateur_Administrateur, utilisateur_Fournisseur';
            }
            $res_requete = executer_requete_mysql('SELECT ' . $colonnes . ' FROM ' . inst('utilisateur') . ' WHERE Code_utilisateur = ' . $Code_utilisateur . ';', false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                mf_formatage_db_type_php($row_requete);
                $retour = $row_requete;
            } else {
                $retour = [];
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
        if (isset($options['masquer_mdp'])) {
            $masquer_mdp = ($options['masquer_mdp'] == true);
        }
        $cle = "utilisateur__get_{$Code_utilisateur}_" . ($masquer_mdp ? 'masquer=1' : 'masquer=0');

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
                $colonnes='Code_utilisateur, utilisateur_Identifiant, utilisateur_Password, utilisateur_Email, utilisateur_Civilite_Type, utilisateur_Prenom, utilisateur_Nom, utilisateur_Adresse_1, utilisateur_Adresse_2, utilisateur_Ville, utilisateur_Code_postal, utilisateur_Date_naissance, utilisateur_Accepte_mail_publicitaire, utilisateur_Administrateur, utilisateur_Fournisseur';
            } else {
                $colonnes='Code_utilisateur, utilisateur_Identifiant, utilisateur_Password, utilisateur_Email, utilisateur_Civilite_Type, utilisateur_Prenom, utilisateur_Nom, utilisateur_Adresse_1, utilisateur_Adresse_2, utilisateur_Ville, utilisateur_Code_postal, utilisateur_Date_naissance, utilisateur_Accepte_mail_publicitaire, utilisateur_Administrateur, utilisateur_Fournisseur';
            }
            $res_requete = executer_requete_mysql("SELECT $colonnes FROM " . inst('utilisateur') . " WHERE Code_utilisateur = $Code_utilisateur;", false);
            if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                if ($masquer_mdp) {
                    unset($row_requete['utilisateur_Password']);
                }
                mf_formatage_db_type_php($row_requete);
                $retour = $row_requete;
            } else {
                $retour = [];
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

    public function mf_prec_et_suiv( int $Code_utilisateur, ?array $options = null /* $options = [ 'cond_mysql' => [], 'tris' => [], 'limit' => [], 'toutes_colonnes' => TOUTES_COLONNES_DEFAUT, 'liste_colonnes_a_selectionner' => [], 'autocompletion' => AUTOCOMPLETION_DEFAUT, 'autocompletion_recursive' => AUTOCOMPLETION_RECURSIVE_DEFAUT, 'controle_acces_donnees' => CONTROLE_ACCES_DONNEES_DEFAUT, 'maj' => true ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $Code_utilisateur = intval($Code_utilisateur);
        $liste = $this->mf_lister($options);
        return prec_suiv($liste, $Code_utilisateur);
    }

    public function mf_compter(?array $options = null /* $options = [ 'cond_mysql' => [] ] */)
    {
        if ($options === null) {
            $options=[];
        }
        $cle = 'utilisateur__compter';

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
                if (false === $mf_liste_requete_index = self::$cache_db->read('utilisateur__index')) {
                    $res_requete_index = executer_requete_mysql('SHOW INDEX FROM `'.inst('utilisateur').'`;', false);
                    $mf_liste_requete_index = [];
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

    public function mfi_compter( array $interface, ?array $options = null /* $options = [ 'cond_mysql' => [] ] */ )
    {
        if ($options === null) {
            $options=[];
        }
        return $this->mf_compter( $options );
    }

    public function mf_liste_Code_utilisateur(?array $options = null /* $options = [ 'cond_mysql' => [] ] */)
    {
        if ($options === null) {
            $options=[];
        }
        return $this->get_liste_Code_utilisateur($options);
    }

    public function mf_get_liste_tables_parents()
    {
        return [];
    }

    public function mf_search_utilisateur_Identifiant(string $utilisateur_Identifiant): int
    {
        return $this->rechercher_utilisateur_Identifiant($utilisateur_Identifiant);
    }

    public function mf_search_utilisateur_Password(string $utilisateur_Password): int
    {
        return $this->rechercher_utilisateur_Password($utilisateur_Password);
    }

    public function mf_search_utilisateur_Email(string $utilisateur_Email): int
    {
        return $this->rechercher_utilisateur_Email($utilisateur_Email);
    }

    public function mf_search_utilisateur_Civilite_Type(int $utilisateur_Civilite_Type): int
    {
        return $this->rechercher_utilisateur_Civilite_Type($utilisateur_Civilite_Type);
    }

    public function mf_search_utilisateur_Prenom(string $utilisateur_Prenom): int
    {
        return $this->rechercher_utilisateur_Prenom($utilisateur_Prenom);
    }

    public function mf_search_utilisateur_Nom(string $utilisateur_Nom): int
    {
        return $this->rechercher_utilisateur_Nom($utilisateur_Nom);
    }

    public function mf_search_utilisateur_Adresse_1(string $utilisateur_Adresse_1): int
    {
        return $this->rechercher_utilisateur_Adresse_1($utilisateur_Adresse_1);
    }

    public function mf_search_utilisateur_Adresse_2(string $utilisateur_Adresse_2): int
    {
        return $this->rechercher_utilisateur_Adresse_2($utilisateur_Adresse_2);
    }

    public function mf_search_utilisateur_Ville(string $utilisateur_Ville): int
    {
        return $this->rechercher_utilisateur_Ville($utilisateur_Ville);
    }

    public function mf_search_utilisateur_Code_postal(string $utilisateur_Code_postal): int
    {
        return $this->rechercher_utilisateur_Code_postal($utilisateur_Code_postal);
    }

    public function mf_search_utilisateur_Date_naissance(string $utilisateur_Date_naissance): int
    {
        return $this->rechercher_utilisateur_Date_naissance($utilisateur_Date_naissance);
    }

    public function mf_search_utilisateur_Accepte_mail_publicitaire(bool $utilisateur_Accepte_mail_publicitaire): int
    {
        return $this->rechercher_utilisateur_Accepte_mail_publicitaire($utilisateur_Accepte_mail_publicitaire);
    }

    public function mf_search_utilisateur_Administrateur(bool $utilisateur_Administrateur): int
    {
        return $this->rechercher_utilisateur_Administrateur($utilisateur_Administrateur);
    }

    public function mf_search_utilisateur_Fournisseur(bool $utilisateur_Fournisseur): int
    {
        return $this->rechercher_utilisateur_Fournisseur($utilisateur_Fournisseur);
    }

    public function mf_search__colonne(string $colonne_db, $recherche): int
    {
        switch ($colonne_db) {
            case 'utilisateur_Identifiant': return $this->mf_search_utilisateur_Identifiant($recherche); break;
            case 'utilisateur_Password': return $this->mf_search_utilisateur_Password($recherche); break;
            case 'utilisateur_Email': return $this->mf_search_utilisateur_Email($recherche); break;
            case 'utilisateur_Civilite_Type': return $this->mf_search_utilisateur_Civilite_Type($recherche); break;
            case 'utilisateur_Prenom': return $this->mf_search_utilisateur_Prenom($recherche); break;
            case 'utilisateur_Nom': return $this->mf_search_utilisateur_Nom($recherche); break;
            case 'utilisateur_Adresse_1': return $this->mf_search_utilisateur_Adresse_1($recherche); break;
            case 'utilisateur_Adresse_2': return $this->mf_search_utilisateur_Adresse_2($recherche); break;
            case 'utilisateur_Ville': return $this->mf_search_utilisateur_Ville($recherche); break;
            case 'utilisateur_Code_postal': return $this->mf_search_utilisateur_Code_postal($recherche); break;
            case 'utilisateur_Date_naissance': return $this->mf_search_utilisateur_Date_naissance($recherche); break;
            case 'utilisateur_Accepte_mail_publicitaire': return $this->mf_search_utilisateur_Accepte_mail_publicitaire($recherche); break;
            case 'utilisateur_Administrateur': return $this->mf_search_utilisateur_Administrateur($recherche); break;
            case 'utilisateur_Fournisseur': return $this->mf_search_utilisateur_Fournisseur($recherche); break;
            default: return 0;
        }
    }

    public function mf_get_next_id(): int
    {
        $res_requete = executer_requete_mysql('SELECT AUTO_INCREMENT as next_id FROM INFORMATION_SCHEMA.TABLES WHERE table_name = \'' . inst('utilisateur') . '\';', false);
        $row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC);
        mysqli_free_result($res_requete);
        return intval($row_requete['next_id']);
    }

    public function mf_search(array $ligne): int // array('colonne1' => 'valeur1',  [...] )
    {
        global $mf_initialisation;
        $utilisateur_Identifiant = (isset($ligne['utilisateur_Identifiant']) ? $ligne['utilisateur_Identifiant'] : $mf_initialisation['utilisateur_Identifiant']);
        $utilisateur_Password = (isset($ligne['utilisateur_Password']) ? $ligne['utilisateur_Password'] : $mf_initialisation['utilisateur_Password']);
        $utilisateur_Email = (isset($ligne['utilisateur_Email']) ? $ligne['utilisateur_Email'] : $mf_initialisation['utilisateur_Email']);
        $utilisateur_Civilite_Type = (isset($ligne['utilisateur_Civilite_Type']) ? $ligne['utilisateur_Civilite_Type'] : $mf_initialisation['utilisateur_Civilite_Type']);
        $utilisateur_Prenom = (isset($ligne['utilisateur_Prenom']) ? $ligne['utilisateur_Prenom'] : $mf_initialisation['utilisateur_Prenom']);
        $utilisateur_Nom = (isset($ligne['utilisateur_Nom']) ? $ligne['utilisateur_Nom'] : $mf_initialisation['utilisateur_Nom']);
        $utilisateur_Adresse_1 = (isset($ligne['utilisateur_Adresse_1']) ? $ligne['utilisateur_Adresse_1'] : $mf_initialisation['utilisateur_Adresse_1']);
        $utilisateur_Adresse_2 = (isset($ligne['utilisateur_Adresse_2']) ? $ligne['utilisateur_Adresse_2'] : $mf_initialisation['utilisateur_Adresse_2']);
        $utilisateur_Ville = (isset($ligne['utilisateur_Ville']) ? $ligne['utilisateur_Ville'] : $mf_initialisation['utilisateur_Ville']);
        $utilisateur_Code_postal = (isset($ligne['utilisateur_Code_postal']) ? $ligne['utilisateur_Code_postal'] : $mf_initialisation['utilisateur_Code_postal']);
        $utilisateur_Date_naissance = (isset($ligne['utilisateur_Date_naissance']) ? $ligne['utilisateur_Date_naissance'] : $mf_initialisation['utilisateur_Date_naissance']);
        $utilisateur_Accepte_mail_publicitaire = (isset($ligne['utilisateur_Accepte_mail_publicitaire']) ? $ligne['utilisateur_Accepte_mail_publicitaire'] : $mf_initialisation['utilisateur_Accepte_mail_publicitaire']);
        $utilisateur_Administrateur = (isset($ligne['utilisateur_Administrateur']) ? $ligne['utilisateur_Administrateur'] : $mf_initialisation['utilisateur_Administrateur']);
        $utilisateur_Fournisseur = (isset($ligne['utilisateur_Fournisseur']) ? $ligne['utilisateur_Fournisseur'] : $mf_initialisation['utilisateur_Fournisseur']);
        // Typage
        $utilisateur_Identifiant = (string) $utilisateur_Identifiant;
        $utilisateur_Password = (string) $utilisateur_Password;
        $utilisateur_Email = (string) $utilisateur_Email;
        $utilisateur_Civilite_Type = is_null($utilisateur_Civilite_Type) || $utilisateur_Civilite_Type === '' ? null : (int) $utilisateur_Civilite_Type;
        $utilisateur_Prenom = (string) $utilisateur_Prenom;
        $utilisateur_Nom = (string) $utilisateur_Nom;
        $utilisateur_Adresse_1 = (string) $utilisateur_Adresse_1;
        $utilisateur_Adresse_2 = (string) $utilisateur_Adresse_2;
        $utilisateur_Ville = (string) $utilisateur_Ville;
        $utilisateur_Code_postal = (string) $utilisateur_Code_postal;
        $utilisateur_Date_naissance = format_date($utilisateur_Date_naissance);
        $utilisateur_Accepte_mail_publicitaire = ($utilisateur_Accepte_mail_publicitaire == true);
        $utilisateur_Administrateur = ($utilisateur_Administrateur == true);
        $utilisateur_Fournisseur = ($utilisateur_Fournisseur == true);
        // Fin typage
        Hook_utilisateur::pre_controller($utilisateur_Identifiant, $utilisateur_Password, $utilisateur_Email, $utilisateur_Civilite_Type, $utilisateur_Prenom, $utilisateur_Nom, $utilisateur_Adresse_1, $utilisateur_Adresse_2, $utilisateur_Ville, $utilisateur_Code_postal, $utilisateur_Date_naissance, $utilisateur_Accepte_mail_publicitaire, $utilisateur_Administrateur, $utilisateur_Fournisseur);
        $mf_cle_unique = Hook_utilisateur::calcul_cle_unique($utilisateur_Identifiant, $utilisateur_Email, $utilisateur_Civilite_Type, $utilisateur_Prenom, $utilisateur_Nom, $utilisateur_Adresse_1, $utilisateur_Adresse_2, $utilisateur_Ville, $utilisateur_Code_postal, $utilisateur_Date_naissance, $utilisateur_Accepte_mail_publicitaire, $utilisateur_Administrateur, $utilisateur_Fournisseur);
        $res_requete = executer_requete_mysql('SELECT Code_utilisateur FROM ' . inst('utilisateur') . ' WHERE mf_cle_unique = \'' . $mf_cle_unique . '\'', false);
        if ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
            $r = intval($row_requete['Code_utilisateur']);
        } else {
            $r = 0;
        }
        mysqli_free_result($res_requete);
        return $r;
    }
}
