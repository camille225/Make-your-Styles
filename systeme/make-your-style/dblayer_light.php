<?php declare(strict_types=1);

if (! session_start()) {
    exit();
}

$now_microtime = microtime(true);
$mf_now = date('Y-m-d H:i:s');

/**
 * Fonction qui permet de lire microtime. Une fois initialisée, la même valeur est alors retournée
 * @return float
 */
function get_now_microtime(): float { global $now_microtime; return $now_microtime; }

/**
 * Donne le temps d'exécution depuis l'appel à get_now_microtime()
 * @param int $precision
 * @return float
 */
function get_execution_time(int $precision = 5): float
{
    return round(microtime(true) - get_now_microtime(), $precision);
}

/**
 * Donne la date courante au début du script
 * @return string
 */
function get_now(): string { global $mf_now; return $mf_now; }

if (isset($_SERVER['HTTP_HOST'])) {
    $mf_get_HTTP_HOST = strtolower(strtr($_SERVER['HTTP_HOST'], [
        '.' => '_',
        '-' => '_'
    ]));
    if (substr($mf_get_HTTP_HOST, 0, 4) == 'www_') {
        $mf_get_HTTP_HOST = substr($mf_get_HTTP_HOST, 4);
    }
} else {
    if (isset($mf_host)) {
        $mf_get_HTTP_HOST = $mf_host;
    } else {
        $mf_get_HTTP_HOST = '';
    }
}

if ($mf_get_HTTP_HOST == '') {
    echo "L'application doit être lancée depuis un navigateur." . PHP_EOL;
    echo "Seules les tâches planifiées peuvent être lancées depuis la console." . PHP_EOL;
    exit();
}

$mf_config = __DIR__ . "/config_$mf_get_HTTP_HOST.php";
if (! file_exists($mf_config)) {
    copy(__DIR__ . '/config_structure.php', $mf_config);
}
include __DIR__ . '/config_globale.php';
include $mf_config;
unset($mf_config);

include __DIR__ . '/constantes_systeme.php';

include __DIR__ . '/habillage.php';

set_error_handler(function ($niveau, $message, $fichier, $ligne) {
    $adresse_fichier_log = get_dossier_data('error_php') . 'error_php_' . substr(get_now(), 0, 10) . '.txt';

    $sql_Emplacement = '';
    $debug = debug_backtrace();
    foreach ($debug as $t) {
        if ($sql_Emplacement != '') {
            $sql_Emplacement = PHP_EOL . '              ' . $sql_Emplacement;
        }
        $sql_Emplacement = (isset($t['file']) ? $t['file'] : '-') . ' # ' . $t['function'] . ' (Ligne ' . (isset($t['line']) ? $t['line'] : '-') . ')' . $sql_Emplacement;
    }

    $txt = '';
    $txt .= 'Date        : ' . get_now() . PHP_EOL;
    $txt .= 'Erreur php  : ' . $message . PHP_EOL;
    $txt .= 'Niveau      : ' . $niveau . PHP_EOL;
    $txt .= 'Fichier     : ' . $fichier . ' à la ligne n°' . $ligne . PHP_EOL;
    $txt .= 'Emplacement : ' . $sql_Emplacement . PHP_EOL;
    $txt .= 'Adresse IP  : ' . get_ip() . (function_exists('identification_log') ? ' (' . identification_log() . ')' : '') . PHP_EOL;

    if (! MODE_PROD) {
        mf_bah_quest_ce_qui_ce_passe("Erreur PHP", $txt, '#00e7ff');
    }

    $txt .= PHP_EOL . ' ---' . PHP_EOL . PHP_EOL;

    mf_file_append($adresse_fichier_log, $txt);
    // sendemail(MAIL_ADMIN, 'Erreur php niv ' . $niveau . ' - ' . NOM_PROJET . "_$mf_get_HTTP_HOST", text_html_br($txt));
});

function mf_bah_quest_ce_qui_ce_passe($titre, $txt, $color) {
    echo '<html lang="fr">' . PHP_EOL;
    echo '<head><title>Bah, qu\'est ce qui se passe ?</title></head>' . PHP_EOL;
    echo '<body style="background-color: black; color: ' . $color . '; padding: 10px; font-family: monospace; font-size: 16px;">' . PHP_EOL;
    echo '<h1>' . htmlspecialchars($titre) . '</h1>' . PHP_EOL;
    echo str_replace('  ', '&nbsp; ', str_replace('  ', '&nbsp; ', str_replace(PHP_EOL, '<br>' . PHP_EOL, $txt))) . PHP_EOL;
    echo '</body>' . PHP_EOL;
    echo '</html>';
    exit();
}

// chargement de l'instance
$_SESSION[NOM_PROJET]['mf_instance'] = intval(isset_parametre_api('mf_instance') ? lecture_parametre_api('mf_instance') : (isset($_SESSION[NOM_PROJET]['mf_instance']) ? $_SESSION[NOM_PROJET]['mf_instance'] : 0));

function get_instance(): int
{
    return $_SESSION[NOM_PROJET]['mf_instance'];
}
$inst = [];

/**
 * @param string $table
 * @return string
 */
function inst(string $table): string
{
    if (TABLE_INSTANCE == '') {
        return $table;
    } else {
        global $inst;
        if (! isset($inst[$table])) {
            $inst[$table] = (TABLE_INSTANCE == $table ? $table : (get_instance() != 0 ? (array_search($table, LISTE_TABLES_GLOBALES) === false ? PREFIXE_DB_INSTANCE . '_' . get_instance() . '_' . $table : $table) : $table));
        }
        return $inst[$table];
    }
}

function new_instance()
{
    $db = new DB();
    $_SESSION[NOM_PROJET]['mf_instance'] = $db->mf_table(TABLE_INSTANCE)->mf_get_next_id();
    $r = $db->mf_table(TABLE_INSTANCE)->mf_creer(true);
    $_SESSION[NOM_PROJET]['mf_instance'] = $r['Code_' . strtolower(TABLE_INSTANCE)];
    if ($_SESSION[NOM_PROJET]['mf_instance'] != 0) {
        global $inst;
        $inst = [];
        generer_la_base();
    }
    db::mf_raz_instance();
}

if (isset($_SERVER['SERVER_NAME'])) {
    $secure_connection = false;
    if (isset($_SERVER['HTTPS'])) {
        if ($_SERVER['HTTPS'] == 'on') {
            $secure_connection = true;
        }
    }
    if (! $secure_connection && HTTPS_ON) {
        header('Location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        exit();
    }
}

$_mf_get_adresse_url_base = null;

function get_adresse_url_base()
{
    if (isset($_SERVER['SERVER_NAME'])) {
        global $_mf_get_adresse_url_base;
        if ($_mf_get_adresse_url_base === null) {
            $racine = (HTTPS_ON ? 'https://' : 'http://') . $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'];
            $p = 0;
            $i = 0;
            while ($i = stripos($racine, FIN_ADRESSE_RACINE . '/', $i + 1)) {
                $p = $i;
            }
            $_mf_get_adresse_url_base = substr($racine, 0, $p + strlen(FIN_ADRESSE_RACINE . '/'));
        }
        return $_mf_get_adresse_url_base;
    } else {
        return 'console';
    }
}

if (isset($_SERVER['SERVER_NAME'])) {
    if (get_adresse_url_base() != ADRESSE_SITE && get_adresse_url_base() != ADRESSE_API) {
        header('Location: ' . ADRESSE_SITE);
        exit();
    }
}

$cle_aleatoire = '' . salt(10);

function mf_cle_aleatoire()
{
    global $cle_aleatoire;
    return $cle_aleatoire;
}
if (isset($_GET['secur'])) {
    $secur = (string) $_GET['secur'];
    if ($secur != '') {
        if (! isset($_SESSION[NOM_PROJET]['valid_form'][$secur])) {
            $_SESSION[NOM_PROJET]['valid_form'][$secur] = $cle_aleatoire;
        } else {
            $cle_aleatoire = $_SESSION[NOM_PROJET]['valid_form'][$secur];
        }
    }
    if (isset($_SESSION[NOM_PROJET]['valid_form'])) {
        $i = 0;
        $n = count($_SESSION[NOM_PROJET]['valid_form']) - 5;
        foreach ($_SESSION[NOM_PROJET]['valid_form'] as $key => &$value) {
            if ($i < $n) {
                unset($_SESSION[NOM_PROJET]['valid_form'][$key]);
            }
            $i ++;
        }
        unset($value);
    }
}

/**
 * @param string $dossier
 * @param string $dossier_main
 * @return string
 */
function get_dossier_data(string $dossier, string $dossier_main = 'data'): string
{
    global $mf_get_dossier_data_personalise;
    if (! isset($mf_get_dossier_data_personalise["$dossier/$dossier_main"])) {
        // construction du dossier de base
        global $mf_get_dossier_data_base;
        if (! isset($mf_get_dossier_data_base[$dossier_main])) {
            global $mf_get_HTTP_HOST;
            $mf_get_dossier_data_base[$dossier_main] = __DIR__ . "/../../$dossier_main/";
            if (! file_exists($mf_get_dossier_data_base[$dossier_main])) {
                mkdir($mf_get_dossier_data_base[$dossier_main]);
            }
            $mf_get_dossier_data_base[$dossier_main] .= "$mf_get_HTTP_HOST/";
            if (! file_exists($mf_get_dossier_data_base[$dossier_main])) {
                mkdir($mf_get_dossier_data_base[$dossier_main]);
            }
            $mf_get_dossier_data_base[$dossier_main] .= NOM_PROJET . '/';
            if (! file_exists($mf_get_dossier_data_base[$dossier_main])) {
                mkdir($mf_get_dossier_data_base[$dossier_main]);
            }
            if (TABLE_INSTANCE != '') {
                $mf_get_dossier_data_base[$dossier_main] .= 'inst_' . get_instance();
                if (! file_exists($mf_get_dossier_data_base[$dossier_main])) {
                    mkdir($mf_get_dossier_data_base[$dossier_main]);
                }
            }
            $mf_get_dossier_data_base[$dossier_main] = realpath($mf_get_dossier_data_base[$dossier_main]) . '/';
        }
        // construction du dossier de log
        $mf_get_dossier_data_personalise["$dossier/$dossier_main"] = "{$mf_get_dossier_data_base[$dossier_main]}$dossier/";
        if (! file_exists($mf_get_dossier_data_personalise["$dossier/$dossier_main"])) {
            mkdir($mf_get_dossier_data_personalise["$dossier/$dossier_main"]);
        }
    }
    return $mf_get_dossier_data_personalise["$dossier/$dossier_main"];
}
$mf_get_dossier_data_base = [];
$mf_get_dossier_data_personalise = [];

// horloge
function get_diff_time_zone(): int
{
    return (int) 60 * round((date('U') - gmdate('U')) / 60);
}

class Autoloader
{
    /**
     * Enregistre notre autoloader
     */
    static function register()
    {
        spl_autoload_register([__CLASS__, 'autoload']);
    }

    /**
     * Inclue le fichier correspondant à notre classe
     * @param string $class Le nom de la classe à charger
     */
    static function autoload(string $class)
    {
        if (file_exists(__DIR__ . "/rows/$class.php")) {
            require __DIR__ . "/rows/$class.php";
        } elseif (file_exists(__DIR__ . "/rows/monframework/$class.php")) {
            require __DIR__ . "/rows/monframework/$class.php";
        } elseif (file_exists(__DIR__ . '/tables/' . substr($class, 6) . '.php')) {
            require __DIR__ . '/tables/' . substr($class, 6) . '.php';
        } elseif (substr($class, - 13) == '_monframework') {
            require __DIR__ . '/tables/monframework/' . substr($class, 6, strlen($class) - 19) . '.php';
        } elseif (substr($class, 0, 5) == 'Hook_') {
            require __DIR__ . "/tables/monframework/hooks/$class.php";
        } elseif (file_exists(__DIR__ . "/fonctions/$class.php")) {
            require __DIR__ . "/fonctions/$class.php";
        } elseif (file_exists(__DIR__ . "/fonctions/" . strtolower($class) . ".php")) { // A supprimer
            require __DIR__ . "/fonctions/" . strtolower($class) . ".php"; // A supprimer
        } else {
            if (! MODE_PROD) {
                $txt = "La classe $class est introuvable." . PHP_EOL . "Autoloader::register() ne parvient pas à la trouver.";
                mf_bah_quest_ce_qui_ce_passe("Erreur PHP", $txt, "#FF67F6");
            }
        }
    }
}
Autoloader::register();

class Mf_cache_volatil // cache en ram qui dure le temps de l'exécution du script
{

    private $mf_cache_volatil_var = array();
    public $variables = array();

    private $memory_limit;

    public function __construct()
    {
        $this->memory_limit = round(0.75 * return_bytes(ini_get('memory_limit')));
    }

    public function is_set($dossier, $cle)
    {
        return (isset($this->mf_cache_volatil_var[$dossier][$cle]));
    }

    public function get($dossier, $cle)
    {
        return $this->mf_cache_volatil_var[$dossier][$cle];
    }

    public function set($dossier, $cle, $contenu)
    {
        if (memory_get_usage() >= $this->memory_limit) {
            $this->mf_cache_volatil_var = array();
        }
        $this->mf_cache_volatil_var[$dossier][$cle] = $contenu;
    }

    public function clear($dossier)
    {
        if (isset($this->mf_cache_volatil_var[$dossier])) {
            unset($this->mf_cache_volatil_var[$dossier]);
        }
        if (isset($this->variables[$dossier])) {
            unset($this->variables[$dossier]);
        }
    }
}
$mf_cache_volatil = new Mf_cache_volatil();

include __DIR__ . '/cache_systeme.php';

$lang_standard = [];
$mf_titre_ligne_table = [];
$mf_tri_defaut_table = [];
$mf_initialisation = [];
$mf_droits_defaut = [];
$mf_dictionnaire_db = [];
$mf_libelle_erreur = [];
$mf_dependances = [];
$mf_type_table_enfant = [];

function read_variable_systeme()
{
    global $lang_standard, $mf_titre_ligne_table, $mf_tri_defaut_table, $mf_initialisation, $mf_dictionnaire_db, $mf_libelle_erreur, $mf_dependances, $mf_type_table_enfant;
    $cache_systeme = new Mf_Cache_systeme();
    if (($variables_systeme = $cache_systeme->read('variables_systeme')) && MODE_PROD) {
        $lang_standard = $variables_systeme['lang_standard'];
        $mf_titre_ligne_table = $variables_systeme['mf_titre_ligne_table'];
        $mf_tri_defaut_table = $variables_systeme['mf_tri_defaut_table'];
        $mf_initialisation = $variables_systeme['mf_initialisation'];
        $mf_dictionnaire_db = $variables_systeme['mf_dictionnaire_db'];
        $mf_libelle_erreur = $variables_systeme['mf_libelle_erreur'];
        $mf_dependances = $variables_systeme['mf_dependances'];
        $mf_type_table_enfant = $variables_systeme['mf_type_table_enfant'];
    } else {
        $lang_standard = [];
        $mf_titre_ligne_table = [];
        $mf_tri_defaut_table = [];
        $mf_initialisation = [];
        $mf_dictionnaire_db = [];
        $mf_libelle_erreur = [];
        $mf_dependances = [];
        $mf_type_table_enfant = [];

        include __DIR__ . '/langues/fr/systeme.php';
        include __DIR__ . '/chargement_variables_systemes.php';
        include __DIR__ . '/tables/monframework/mf_dictionnaire_db.php';

        if (MODE_PROD) {
            $cache_systeme->write('variables_systeme', array(
                'lang_standard' => $lang_standard,
                'mf_titre_ligne_table' => $mf_titre_ligne_table,
                'mf_tri_defaut_table' => $mf_tri_defaut_table,
                'mf_initialisation' => $mf_initialisation,
                'mf_dictionnaire_db' => $mf_dictionnaire_db,
                'mf_libelle_erreur' => $mf_libelle_erreur,
                'mf_dependances' => $mf_dependances,
                'mf_type_table_enfant' => $mf_type_table_enfant
            ));
        }
    }
}
read_variable_systeme();

require __DIR__ . '/constantes_systeme_auto.php';

define('OPTION_COND_MYSQL', 'cond_mysql');
define('OPTION_TRI', 'tris');
define('OPTION_LIMIT', 'limit');
define('OPTION_AUTOCOMPLETION', 'autocompletion');
define('OPTION_TOUTES_COLONNES', 'toutes_colonnes');
define('OPTION_MAJ', 'maj');

require __DIR__ . '/tables/monframework/entite.php';
require __DIR__ . '/tables/db.php';
require __DIR__ . '/tables/entite.php';

require __DIR__ . '/tables/monframework/mf_connexion.php';

function mf_get_liste_tables_enfants(string $table): array
{
    global $mf_dependances;
    $liste_tables_enfants = [];
    if (isset($mf_dependances[$table])) {
        foreach ($mf_dependances[$table] as $table_fille) {
            $liste_tables_enfants[] = $table_fille;
        }
    }
    return $liste_tables_enfants;
}

function mf_get_liste_tables_parents(string $table): array
{
    $db = new DB();
    return $db -> mf_table($table) -> mf_get_liste_tables_parents();
}

$mf_message_erreur_personalise = '';

function mf_personaliser_le_message($message_erreur)
{
    global $mf_message_erreur_personalise;
    $mf_message_erreur_personalise = $message_erreur;
}

/* Fonctions mysql */

$link = null; // connexion uniquement si besoin ...

function connexion_db(&$link)
{
    $link = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT);
    if (mysqli_connect_errno()) {
        echo '<!DOCTYPE html><html lang="fr"><head><meta charset="UTF-8"><title>Connexion à la base de données</title></head><body>Failed to connect to MySQL:' . utf8_encode(mysqli_connect_error()) . '</body></html>';
        exit();
    }
}

function connexion_db_cache()
{
    $link_cache = @mysqli_connect(DB_CACHE_HOST, DB_CACHE_USER, DB_CACHE_PASSWORD, DB_CACHE_NAME, DB_CACHE_PORT);
    if (mysqli_connect_errno()) {
        echo '<!DOCTYPE html><html lang="fr"><head><meta charset="UTF-8"><title>Connexion à la base de données</title></head><body>Failed to connect to MySQL:' . utf8_encode(mysqli_connect_error()) . '</body></html>';
        exit();
    }
    return $link_cache;
}

/**
 *
 * @param string $filename
 * @param string $str
 * @return bool
 */
$mf_file_append_liste = [];

function mf_file_append(string $filename, string $str): void
{
    if ($str != '') {
        if (DB_CACHE_HOST != '') {
            global $mf_file_append_liste;
            $mf_file_append_liste[] = [
                'microtime' => microtime(true),
                'filename' => $filename,
                'str' => $str
            ];
        }
    }
}

function mf_file_append_flush(): void
{
    if (DB_CACHE_HOST != '') {
        global $mf_file_append_liste, $mf_get_HTTP_HOST;
        if (count($mf_file_append_liste) > 0) {
            $link = connexion_db_cache();
            $res_requete = mysqli_query($link, 'show variables like \'max_allowed_packet\';');
            $max_allowed_packet = 524288;
            while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                if ($row_requete['Variable_name'] == 'max_allowed_packet') {
                    $max_allowed_packet = (int) $row_requete['Value'];
                }
            }
            mysqli_free_result($res_requete);
            $data = '';
            $len = 1000;
            $table = str_replace('-', '_', strtolower(NOM_PROJET . "_$mf_get_HTTP_HOST")) . '_cache_' . get_instance();
            foreach ($mf_file_append_liste as $key => &$value) {
                $value['filename'] = mysqli_real_escape_string($link, $value['filename']);
                $value['str'] = mysqli_real_escape_string($link, $value['str']);
                $n = strlen((string) $value['microtime']) + strlen($value['filename']) + strlen($value['str']) + 20;
                if ($len + $n > $max_allowed_packet) {
                    mysqli_query($link, 'INSERT INTO ' . $table . ' (microtime,filename,str,synchro) VALUES ' . $data . ';');
                    $data = '';
                    $len = 1000;
                }
                $data .= ($len == 1000 ? '' : ',') . '(' . $value['microtime'] . ',\'' . $value['filename'] . '\',\'' . $value['str'] . '\',0)';
                $len += $n;
                unset($mf_file_append_liste[$key]);
            }
            mysqli_query($link, 'INSERT INTO ' . $table . ' (microtime,filename,str,synchro) VALUES ' . $data . ';');
            mysqli_close($link);
        }
    }
}

function mf_file_append_initialiser_structure(): void
{
    global $mf_get_HTTP_HOST;
    if (DB_CACHE_HOST != '') {
        $link = connexion_db_cache();
        @mysqli_query($link, 'CREATE TABLE ' . str_replace('-', '_', strtolower(NOM_PROJET . "_$mf_get_HTTP_HOST")) . '_cache_' . get_instance() . ' (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, microtime DOUBLE, filename VARCHAR(255), str TEXT, synchro BOOL, PRIMARY KEY (id), INDEX(microtime), INDEX(synchro)) ENGINE=MyISAM;');
        @mysqli_query($link, 'CREATE TABLE ' . str_replace('-', '_', strtolower(NOM_PROJET . "_$mf_get_HTTP_HOST")) . '_worker (id INT NOT NULL, microtime_exe DOUBLE, cpt BIGINT UNSIGNED, PRIMARY KEY (id)) ENGINE=MyISAM;');
        @mysqli_query($link, 'INSERT INTO ' . str_replace('-', '_', strtolower(NOM_PROJET . "_$mf_get_HTTP_HOST")) . '_worker (id,microtime_exe,cpt) VALUES (' . get_instance() . ',0,0);');
        mysqli_close($link);
    }
}

function mf_initialiser_mf_index_login(): void
{
    if (TABLE_INSTANCE != '') {
        if (! test_si_table_existe('mf_index_login')) {
            executer_requete_mysql('CREATE TABLE mf_index_login (Code_mf_index_login BIGINT UNSIGNED NOT NULL AUTO_INCREMENT, PRIMARY KEY (Code_mf_index_login)) ENGINE=MyISAM;', false);
            executer_requete_mysql('ALTER TABLE mf_index_login ADD instance BIGINT UNSIGNED;', false);
            executer_requete_mysql('ALTER TABLE mf_index_login ADD id BIGINT UNSIGNED;', false);
            executer_requete_mysql('ALTER TABLE mf_index_login ADD login VARCHAR(255);', false);
            executer_requete_mysql('ALTER TABLE mf_index_login ADD email VARCHAR(255);', false);
            executer_requete_mysql('ALTER TABLE mf_index_login ADD INDEX(instance);', false);
            executer_requete_mysql('ALTER TABLE mf_index_login ADD INDEX(id);', false);
            executer_requete_mysql('ALTER TABLE mf_index_login ADD INDEX(login);', false);
            executer_requete_mysql('ALTER TABLE mf_index_login ADD INDEX(email);', false);
        }
    }
}

function maj_mf_index_login(): void
{
    if (TABLE_INSTANCE != '') {
        // Liste des logins de la session courante
        $connexion = new Mf_Connexion();
        $liste_login = $connexion->get_liste_login();

        // Liste des login de la session courante indexé
        $liste_index = [];
        $instance = get_instance();
        $res_requete = executer_requete_mysql("SELECT * FROM mf_index_login WHERE instance = $instance", false);
        while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
            $liste_index[(int)$row_requete['id']] = $row_requete;
        }

        // Mise à jour des index existants et suppression des index en trop
        foreach ($liste_index as $id => $v) {
            if (isset($liste_login[$id])) {
                // Données déja indexé, controle de mise à jour
                $login = $liste_login[$id]['login'];
                if ($v['login'] != $login) {
                    $login = text_sql($login);
                    executer_requete_mysql("UPDATE mf_index_login SET login = '$login' WHERE id = $id AND instance = $instance;", false);
                }
                $email = $liste_login[$id]['email'];
                if ($v['email'] != $email) {
                    $email = text_sql($email);
                    executer_requete_mysql("UPDATE mf_index_login SET email = '$email' WHERE id = $id AND instance = $instance;", false);
                }
                // On retire l'indexe corrigé
                unset($liste_login[$id]);
            } else {
                // index en trop. On le supprime
                executer_requete_mysql("DELETE FROM mf_index_login WHERE id = $id AND instance = $instance;", false);
            }
        }

        // Ajout des nouveaux indexes
        foreach ($liste_login as $login_a_ajouter) {
            executer_requete_mysql("INSERT INTO mf_index_login (instance, id, login, email) VALUES ($instance, {$login_a_ajouter['id']}, '" . text_sql($login_a_ajouter['login']) . "', '" . text_sql($login_a_ajouter['email']) . "');", false);
        }
    }
}

function mf_saisie_login_vers_liste_instance($saisie): array
{
    $liste = [];
    $saisie = text_sql($saisie);
    if (ACTIVER_CONNEXION_EMAIL) {
        $requete_sql = "SELECT instance FROM mf_index_login WHERE login = '$saisie' OR email = '$saisie'";
    } else {
        $requete_sql = "SELECT instance FROM mf_index_login WHERE login = '$saisie'";
    }
    $res_requete = executer_requete_mysql($requete_sql, false);
    while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
        $liste[] = (int) $row_requete['instance'];
    }
    $db = new DB();
    return $db -> mf_table(TABLE_INSTANCE) -> mf_lister_2($liste, ['controle_acces_donnees' => false]);
}

function mf_file_append_whrite(): bool
{
    if (DB_CACHE_HOST != '') {
        global $mf_get_HTTP_HOST;
        $nb_lectures_log = 64;
        $table_cache = str_replace('-', '_', strtolower(NOM_PROJET . "_$mf_get_HTTP_HOST")) . '_cache_' . get_instance();
        $link = connexion_db_cache();

        $continuer = true;
        while ($continuer) {
            $res_requete = mysqli_query($link, "SELECT * FROM $table_cache WHERE synchro=0 ORDER BY microtime ASC LIMIT 0, $nb_lectures_log;");
            $llog = [];
            while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
                $llog[] = [
                    'id' => $row_requete['id'],
                    'filename' => $row_requete['filename'],
                    'str' => $row_requete['str']
                ];
            }
            $continuer = (count($llog) == $nb_lectures_log);
            mysqli_free_result($res_requete);
            foreach ($llog as $log) {
                mysqli_query($link, 'UPDATE ' . $table_cache . ' SET synchro=1 WHERE id=' . $log['id'] . ';');
                if (mysqli_affected_rows($link) == 1) {
                    $filename = $log['filename'];
                    $p = max([strrpos($filename, '\\'), strrpos($filename, '/')]);
                    $path = substr($filename, 0, $p+1);
                    if (! file_exists($path)) {
                        mkdir($path);
                    }
                    $str = $log['str'];
                    // open resource
                    $fp = false;
                    while ($fp === false) {
                        $fp = fopen($filename, 'a');
                        if ($fp === false) {
                            usleep(10);
                        }
                    }
                    // fwrite
                    while ($str != '' && ($l = fwrite($fp, $str))) {
                        if ($l !== false) {
                            $str = substr($str, $l);
                        } else {
                            usleep(10);
                        }
                    }
                    // flush
                    while (!fflush($fp)) {
                        usleep(10);
                    }
                    // close resource
                    while (!fclose($fp)) {
                        usleep(10);
                    }
                } else {
                    mysqli_close($link);
                    return false;
                }
                if (get_execution_time() > DELAI_EXECUTION_WORKER * 0.99) {
                    $continuer = false;
                    break;
                }
            }
            mysqli_query($link, "DELETE IGNORE FROM $table_cache WHERE synchro=1;");
        }
        mysqli_close($link);
    }
    return true;
}

$mf_nb_requetes = 0;
$mf_nb_requetes_update = 0;
$mf_last_query = '';

function executer_requete_mysql($query, $log = true)
{
    if (! MODE_PROD) {
        global $mf_last_query;
        $mf_last_query = $query;
    }

    global $link, $mf_nb_requetes, $mf_nb_requetes_update;
    $mf_nb_requetes ++;
    if ($link == null) {
        connexion_db($link);
    }

    $ln = PHP_EOL;



    $time_1 = microtime(true);
    $req = mysqli_query($link, $query);
    $time_2 = microtime(true);

    $duree = 1000 * round($time_2 - $time_1, 6);
    $erreur_sql_Num_erreur = round(mysqli_errno($link));

    $requete_update = ($log ? test_requete_update($query) : false);

    $affected_rows = 0;
    $sql_Emplacement = '';

    if ($requete_update) {
        $small_query = mf_limite_taille_log($query);
        $mf_nb_requetes_update ++;
        if ($erreur_sql_Num_erreur == 0 || test_requete_system($query)) { /* requete update */
            $affected_rows = round(mysqli_affected_rows($link));
            if ($affected_rows > 0 || test_requete_system($query)) {
                $adresse_fichier_log = get_dossier_data('update') . 'update_' . substr(get_now(), 0, 13) . '.sql';
                if (MODE_PROD) {
                    mf_file_append($adresse_fichier_log, '/*' . (function_exists('identification_log') ? identification_log() : '') . ";" . get_now() . ";{$duree}ms;{$affected_rows}r;" . get_ip() .  "*/$ln$small_query$ln");
                } else {
                    $debug = debug_backtrace();
                    foreach ($debug as $t) {
                        if ($sql_Emplacement != '') {
                            $sql_Emplacement = $ln . '                 ' . $sql_Emplacement;
                        }
                        $sql_Emplacement = (isset($t['file']) ? $t['file'] : '-') . ' # ' . $t['function'] . ' (Ligne ' . (isset($t['line']) ? $t['line'] : '-') . ')' . $sql_Emplacement;
                    }
                    mf_file_append($adresse_fichier_log, '/*' . $ln . ' ' . (function_exists('identification_log') ? identification_log() : '') . $ln . ' Date          : ' . get_now() . $ln . ' Duree         : ' . $duree . 'ms' . $ln . ' Affected rows : ' . $affected_rows . $ln . ' Emplacement   : ' . $sql_Emplacement . $ln . ' Adresse IP    : ' . get_ip() . $ln . '*/' . $ln . $small_query . $ln . $ln);
                }
            }
        }

        if ($duree >= 100 && $erreur_sql_Num_erreur == 0) { /* requete lente (au dela de 100ms) */
            if ($sql_Emplacement == '') {
                $debug = debug_backtrace();
                foreach ($debug as $t) {
                    if ($sql_Emplacement != '')
                        $sql_Emplacement = $ln . '                 ' . $sql_Emplacement;
                    $sql_Emplacement = (isset($t['file']) ? $t['file'] : '-') . ' # ' . $t['function'] . ' (Ligne ' . (isset($t['line']) ? $t['line'] : '-') . ')' . $sql_Emplacement;
                }
            }
            $adresse_fichier_log = get_dossier_data('slow_query') . 'slow_query_' . substr(get_now(), 0, 10) . '.sql';
            mf_file_append($adresse_fichier_log, '/*' . $ln . ' ' . (function_exists('identification_log') ? identification_log() : '') . $ln . ' Date          : ' . get_now() . $ln . ' Duree         : ' . $duree . 'ms' . $ln . ' Affected rows : ' . $affected_rows . $ln . ' Emplacement   : ' . $sql_Emplacement . $ln . ' Adresse IP    : ' . get_ip() . $ln . '*/' . $ln . $small_query . $ln . $ln);
        }
    }

    if ($erreur_sql_Num_erreur != 0) { /* Erreurs SQL */
        $small_query = mf_limite_taille_log($query, 16384);
        $debug = debug_backtrace();
        foreach ($debug as $t) {
            if ($sql_Emplacement != '')
                $sql_Emplacement = $ln . '                 ' . $sql_Emplacement;
            $sql_Emplacement = (isset($t['file']) ? $t['file'] : '-') . ' # ' . $t['function'] . ' (Ligne ' . (isset($t['line']) ? $t['line'] : '-') . ')' . $sql_Emplacement;
        }
        $error = mysqli_error($link);
        $adresse_fichier_log = get_dossier_data('error_mysql') . 'error_mysql_' . substr(get_now(), 0, 10) . '.sql';
        $error_str = '/*' . $ln . ' ' . (function_exists('identification_log') ? identification_log() : '') . $ln . ' Date          : ' . get_now() . $ln . ' Duree         : ' . $duree . 'ms' . $ln . ' Code erreur   : ' . $erreur_sql_Num_erreur . $ln . ' Description   : ' . $error . $ln . ' Emplacement   : ' . $sql_Emplacement . $ln . ' Adresse IP    : ' . get_ip() . $ln . '*/' . $ln . $small_query;
        if (! MODE_PROD) {
            mf_bah_quest_ce_qui_ce_passe("Erreur PHP", $error_str, "#00ffa1");
        }
        $error_str .= $ln . $ln;
        mf_file_append($adresse_fichier_log, $error_str);
        global $mf_get_HTTP_HOST;
        sendemail(MAIL_ADMIN, 'Erreur ' . $erreur_sql_Num_erreur . ' - ' . NOM_PROJET . "_$mf_get_HTTP_HOST", text_html_br($error_str));
    }

    return $req;
}

function set_log($txt)
{
    if (! MODE_PROD) {
        $adresse_fichier_log = get_dossier_data('log') . 'log_' . substr(get_now(), 0, 10) . '.txt';
        mf_file_append($adresse_fichier_log, ':' . $txt . PHP_EOL);
    }
}

function log_api($txt)
{
    $ln = PHP_EOL;
    $adresse_fichier_log = get_dossier_data('log_api') . '/log_api_' . substr(get_now(), 0, 10) . '.txt';
    mf_file_append($adresse_fichier_log, get_now() . "$ln$txt$ln");
}

/**
 * @param string $txt
 * @param int $size_max
 * @param string $indicator
 * @return string
 */
function mf_limite_taille_log(string $txt, int $size_max = 4096, string $indicator = '…') {
    if (strlen($txt) > $size_max) {
        return substr($txt, 0, $size_max) . $indicator;
    }
    return $txt;
}

function fermeture_connexion_db()
{
    global $link;
    if ($link != null) {
        mysqli_close($link);
        $link = null;
    }
    mf_file_append_flush();
}

function get_ip()
{
    if (isset($_SERVER['HTTP_HOST'])) {
        return isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
    } else {
        return 'console/cron';
    }
}

function test_requete_update($query)
{
    $query = ' ' . $query;
    $pos = stripos($query, ' UPDATE ');
    if ($pos === false) {
        $pos = stripos($query, ' INSERT ');
    }
    if ($pos === false) {
        $pos = stripos($query, ' DELETE ');
    }
    if ($pos === false) {
        $pos = stripos($query, ' REPLACE ');
    }
    if ($pos === false) {
        $pos = stripos($query, ' ADD ');
    }
    return ($pos !== false);
}

function test_requete_system($query)
{
    $query = ' ' . $query;
    $pos = stripos($query, ' CREATE TABLE ');
    if ($pos === false)
        $pos = stripos($query, ' ALTER TABLE ');
    return ($pos !== false);
}

function requete_mysql_insert_id()
{
    global $link;
    return mysqli_insert_id($link);
}

function requete_mysqli_affected_rows()
{
    global $link;
    return mysqli_affected_rows($link);
}

function db_mysqli_close()
{
    global $link;
    if ($link != null) {
        mysqli_close($link);
        $link = null;
    }
}

function test_si_table_existe($nom_table)
{
    $retour = false;
    $res_requete = executer_requete_mysql('SHOW TABLES WHERE `Tables_in_' . DB_NAME . '` = \'' . $nom_table . '\'');
    while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_NUM)) {
        if ($row_requete[0] == $nom_table) {
            $retour = true;
        }
    }
    mysqli_free_result($res_requete);
    return $retour;
}

/**
 * @param string $nom_table
 * @return array
 */
function lister_les_colonnes(string $nom_table): array
{
    $res_requete = executer_requete_mysql('SHOW COLUMNS FROM ' . inst($nom_table) . ';');
    $liste = array();
    while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
        $liste[$row_requete['Field']] = $row_requete;
    }
    mysqli_free_result($res_requete);
    return $liste; // Field, Type, Null, Key, Default, Extra
}

/**
 * @param string $nom_table
 * @return array
 */
function lister_les_colonnes_primaires(string $nom_table): array
{
    $res_requete = executer_requete_mysql('SHOW INDEX FROM ' . inst($nom_table) . ';');
    $liste = array();
    while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
        if ($row_requete['Key_name'] == 'PRIMARY') {
            $liste[$row_requete['Column_name']] = $row_requete['Column_name'];
        }
    }
    mysqli_free_result($res_requete);
    return $liste;
}

/**
 * @param string $type_mysql
 * @return string
 */
function typeMyql2Sql(string $type_mysql): string
{
    $type_sql = '';
    if (substr($type_mysql, 0, 4) == 'int(') {
        $type_sql = 'INT';
    } elseif ($type_mysql == 'time') {
        $type_sql = 'TIME';
    } elseif ($type_mysql == 'tinytext') {
        $type_sql = 'TINYTEXT';
    } elseif ($type_mysql == 'text') {
        $type_sql = 'TEXT';
    } elseif ($type_mysql == 'mediumtext') {
        $type_sql = 'MEDIUMTEXT';
    } elseif ($type_mysql == 'longtext') {
        $type_sql = 'LONGTEXT';
    } elseif (substr($type_mysql, 0, 8) == 'varchar(') {
        $type_sql = 'VARCHAR';
    } elseif ($type_mysql == 'date') {
        $type_sql = 'DATE';
    } elseif ($type_mysql == 'double') {
        $type_sql = 'DOUBLE';
    } elseif ($type_mysql == 'float') {
        $type_sql = 'FLOAT';
    } elseif ($type_mysql == 'datetime') {
        $type_sql = 'DATETIME';
    } elseif ($type_mysql == 'tinyint(1)') {
        $type_sql = 'BOOL';
    }
    return $type_sql;
}

function generer_la_base()
{
    $cache_systeme = new Mf_Cache_systeme();
    if (! $cache_systeme->read('generer_base_ok')) {
        include __DIR__ . '/tables/monframework/mf_generer_db.php';
        $cache_systeme->write('generer_base_ok', true);
        // Fichier de config
        global $lang_standard, $mf_initialisation, $mf_dictionnaire_db, $mf_type_table_enfant;
        $txt = '<?php declare(strict_types=1);' . PHP_EOL;
        foreach ($mf_dictionnaire_db as $key => &$value) {
            if (isset($lang_standard["{$key}_"]) && $value['type'] == 'INT') {
                $choice = $lang_standard["{$key}_"];
                $txt .= PHP_EOL . "// $key" . PHP_EOL;
                foreach ($choice as $code => $label) {
                    $label = strtr($label, ['(' => '', ')' => '', '%' => 'P']);
                    $label = strtoupper(mf_string_formatage_variable("{$key}_{$label}"));
                    $txt .= "define('$label', $code);" . PHP_EOL;
                }
            }
        }
        unset($value);
        if (! file_exists(__DIR__ . '/constantes_systeme_auto.php')) {
            file_put_contents(__DIR__ . '/constantes_systeme_auto.php', $txt);
        } else {
            if (file_get_contents(__DIR__ . '/constantes_systeme_auto.php') != $txt) {
                file_put_contents(__DIR__ . '/constantes_systeme_auto.php', $txt);
            }
        }
        // Génération des classes
        $doss = __DIR__ . "/rows/"; if (! file_exists($doss)) { mkdir($doss); }
        $doss = __DIR__ . "/rows/monframework/"; if (! file_exists($doss)) { mkdir($doss); }
        // Functions
        function lister_colonnes_db($entite, $type_entite) {
            $l = [];
            global $mf_dictionnaire_db;
            $i = 0;
            foreach ($mf_dictionnaire_db as $colonne => $infos) {
                if ($infos['entite'] == $entite && $infos['src'] == 'db') {
                    if ($type_entite != 'entite' || $i>0) {
                        $l[$colonne] = $infos;
                    }
                    $i++;
                }
            }
            return $l;
        }
        function lister_colonnes_compl($entite) {
            $l = [];
            global $mf_dictionnaire_db;
            foreach ($mf_dictionnaire_db as $colonne => $infos) {
                if ($infos['entite'] == $entite && $infos['src'] == 'compl') {
                    $l[$colonne] = $infos;
                }
            }
            return $l;
        }
        function declaration_colonnes_parentes_recursive($entite) {
            global $mf_type_table_enfant;
            $from = [];
            if ($mf_type_table_enfant[$entite] == 'entite') {
                $l = mf_get_liste_tables_parents($entite);
                foreach ($l as $parent_1) {
                    $l2 = mf_get_liste_tables_parents($parent_1);
                    foreach ($l2 as $parent_2) {
                        $from[$parent_2] = $parent_1;
                    }
                    $from2 = declaration_colonnes_parentes_recursive($parent_1);
                    foreach ($from2 as $b => $a) {
                        $from[$b] = $a;
                    }
                }
            }
            return $from;
        }

        // Génration
        foreach ($mf_type_table_enfant as $entite => $type_entite) {
            // Génération de la classe
            $txt = '<?php declare(strict_types=1);' . PHP_EOL;
            $txt .= PHP_EOL;
            $txt .= "/*" . PHP_EOL;
            $txt .= "    +------------------------------+" . PHP_EOL;
            $txt .= "    |  NE PAS MODIFIER CE FICHIER  |" . PHP_EOL;
            $txt .= "    +------------------------------+" . PHP_EOL;
            $txt .= " */" . PHP_EOL;
            $txt .= PHP_EOL;
            $txt .= "class monframework_{$entite}" . PHP_EOL;
            $txt .= "{" . PHP_EOL;
            $txt .= PHP_EOL;

            // Partie privée
            // Key
            $txt .= '    // Key' . PHP_EOL;
            if ($type_entite == 'entite') {
                $txt .= '    private $Code_' . $entite . ';' . PHP_EOL;
            } else {
                $l = mf_get_liste_tables_parents($entite);
                foreach ($l as $parent) {
                    $txt .= '    private $Code_' . $parent . ';' . PHP_EOL;
                }
            }
            $txt .= PHP_EOL;

            // Column
            $l = lister_colonnes_db($entite, $type_entite);
            if (count($l) > 0) {
                $txt .= '    // Column' . PHP_EOL;
                foreach ($l as $colonne => $infos) {
                    if ($infos['type'] == 'TINYTEXT' || $infos['type'] == 'TEXT' || $infos['type'] == 'MEDIUMTEXT' || $infos['type'] == 'LONGTEXT' || $infos['type'] == 'VARCHAR' || $infos['type'] == 'TIMESTAMP' || $infos['type'] == 'DATETIME' || $infos['type'] == 'DATE') {
                        $c = "'" . str_replace("'", "\'", $mf_initialisation[$colonne]) . "'";
                    } elseif ($infos['type'] == 'BOOL') {
                        $c = ($mf_initialisation[$colonne] == 1 ? 'true' : 'false');
                    } else {
                        if (isset($mf_initialisation[$colonne])) {
                            $c = ($mf_initialisation[$colonne] === null ? 'null' : $mf_initialisation[$colonne] . (is_float($mf_initialisation[$colonne]) ? '.' : ''));
                        } else {
                            $c = 'null';
                        }
                    }
                    if ($c === '') { // Si mot de passe
                        $c = "''";
                    }
                    $txt .= "    private $$colonne = $c;" . PHP_EOL;
                }
                $txt .= PHP_EOL;
            }

            // Referecences
            if ($type_entite == 'entite') {
                $l = mf_get_liste_tables_parents($entite);
                if (count($l)>0) {
                    $txt .= '    // Referecences' . PHP_EOL;
                    foreach ($l as $parent) {
                        $txt .= '    private $Code_' . $parent . ';' . PHP_EOL;
                    }
                    $txt .= PHP_EOL;
                }
            }

            // Indirect references
            $from = declaration_colonnes_parentes_recursive($entite);
            if (count($from) > 0) {
                foreach ($l as $elem) {
                    if (isset($from[$elem])) {
                        unset($from[$elem]);
                    }
                }
            }
            if (count($from) > 0) {
                $txt .= '    // Indirect references' . PHP_EOL;
                foreach ($from as $parent_2 => $parent_1) {
                    $txt .= '    private $Code_' . $parent_2 . ';' . PHP_EOL;
                }
                $txt .= PHP_EOL;
            }

            // Completion
            $l_compl = lister_colonnes_compl($entite);
            if (count($l_compl)>0) {
                $txt .= "    // Completion" . PHP_EOL;
                foreach ($l_compl as $colonne => $infos) {
                    $txt .= "    private $$colonne;" . PHP_EOL;
                }
                $txt .= PHP_EOL;
            }

            // Lecture
            $arguments = '';
            $arguments_opt = '';
            $arguments_2 = '';
            $arguments_first = '';
            $test_parametres_enseignes = '';
            if ($type_entite == 'entite') {
                $arguments = 'int $Code_' . $entite;
                $arguments_opt = '?int $Code_' . $entite . ' = null';
                $arguments_2 = '$Code_' . $entite;
                $arguments_first = 'Code_' . $entite;
                $test_parametres_enseignes = '$Code_' . $entite . ' !== null';
            } else {
                $l = mf_get_liste_tables_parents($entite);
                foreach ($l as $parent) {
                    $arguments .= ($arguments != '' ? ', ' : '') . 'int $Code_' . $parent;
                    $arguments_opt .= ($arguments_opt != '' ? ', ' : '') . '?int $Code_' . $parent . ' = null';
                    $arguments_2 .= ($arguments_2 != '' ? ', ' : '') . '$Code_' . $parent;
                    $test_parametres_enseignes .= ($test_parametres_enseignes != '' ? ' && ' : '') . '$Code_' . $parent . ' !== null';
                    if ($arguments_first == '') {
                        $arguments_first = 'Code_' . $parent;
                    }
                }
            }

            $txt .= '    /**' . PHP_EOL;
            $txt .= "     * $entite constructor." . PHP_EOL;
            if ($type_entite == 'entite') {
                $txt .= '     * @param int|null $Code_' . $entite . PHP_EOL;
            } else {
                $l = mf_get_liste_tables_parents($entite);
                foreach ($l as $parent) {
                    $txt .= '     * @param int|null $Code_' . $parent . PHP_EOL;
                }
            }
            $txt .= '     */' . PHP_EOL;
            $txt .= '    function __construct(' . $arguments_opt . ')' . PHP_EOL;
            $txt .= '    {' . PHP_EOL;
            $txt .= '        if (' . $test_parametres_enseignes . ') {' . PHP_EOL;
            $txt .= '            $this->read_from_db(' . $arguments_2 . ');' . PHP_EOL;
            $txt .= '        }' . PHP_EOL;
            $txt .= '    }' . PHP_EOL;
            $txt .= PHP_EOL;

            $txt .= '    // Read' . PHP_EOL;
            $txt .= '    public function read_from_db(' . $arguments . '): bool' . PHP_EOL;
            $txt .= '    {' . PHP_EOL;
            $txt .= '        $db = new DB();' . PHP_EOL;
            $txt .= '        $' . $entite . ' = $db->' . $entite . '()->mf_get_2(' . $arguments_2 . ');' . PHP_EOL;
            $txt .= '        if (isset($' . $entite . '[\'' . $arguments_first . '\'])) {' . PHP_EOL;
            foreach ($mf_dictionnaire_db as $colonne => $infos) {
                if ($infos['entite'] == $entite && $infos['src'] == 'db') {
                    $txt .= '            $this->' . $colonne . ' = $' . $entite . "['$colonne'];" . PHP_EOL;
                }
            }
            $l = mf_get_liste_tables_parents($entite);
            foreach ($l as $parent) {
                $txt .= '            $this->Code_' . $parent . ' = $' . $entite . "['Code_$parent'];" . PHP_EOL;
            }
            if (count($l_compl) > 0) {
                $txt .= '            $this->completion();' . PHP_EOL;
            }
            if (count($from) > 0) {
                $txt .= '            $this->genealogy();' . PHP_EOL;
            }
            $txt .= '            return true;' . PHP_EOL;
            $txt .= '        } else {' . PHP_EOL;
            $txt .= '            return false;' . PHP_EOL;
            $txt .= '        }' . PHP_EOL;
            $txt .= '    }' . PHP_EOL;
            $txt .= PHP_EOL;

            // Gettteur et setteur
            $txt .= PHP_EOL;
            $txt .= '    // Getters & setters' . PHP_EOL;
            $txt .= PHP_EOL;
            $txt .= '    // Key' . PHP_EOL;
            if ($type_entite == 'entite') {
                $txt .= '    public function get_Code_' . $entite . '(): int { return $this->Code_' . $entite . '; }' . PHP_EOL;
            } else {
                $l = mf_get_liste_tables_parents($entite);
                foreach ($l as $parent) {
                    $txt .= '    // Code_' . $parent . PHP_EOL;
                    $txt .= '    public function get_Code_' . $parent . '(): int { return $this->Code_' . $parent . '; }' . PHP_EOL;
                }
            }
            $txt .= PHP_EOL;

            $write = false;
            $l = lister_colonnes_db($entite, $type_entite);
            if (count($l)>0) {
                $txt .= '    // Columns' . PHP_EOL;
                foreach ($l  as $colonne => $infos) {
                    $colonne_synthese = substr($colonne, strlen($entite) + 1);
                    $txt .= '    // ' . $colonne . PHP_EOL;
                    $c = mf_type_sql2php($infos['type']);
                    $txt .= '    public function get_' . $colonne_synthese . '(): ' . $c . ' { return $this->' . $colonne . '; }' . PHP_EOL;
                    $txt .= '    public function set_' . $colonne_synthese . '(' . $c . ' $' . $colonne . ') ' . ' { $this->' . $colonne . ' = $' . $colonne . ';' . (count($l_compl) > 0 ? ' $this->completion();' : '' ) . ' }' . PHP_EOL;
                    $write = true;
                }
                $txt .= PHP_EOL;
            }

            if ($type_entite == 'entite') {
                $l = mf_get_liste_tables_parents($entite);
                if (count($l)>0) {
                    $txt .= '    // Referecences' . PHP_EOL;
                    foreach ($l as $parent) {
                        $txt .= '    // Code_' . $parent . PHP_EOL;
                        $txt .= '    public function get_Code_' . $parent . '(): int { return $this->Code_' . $parent . '; }' . PHP_EOL;
                        $txt .= '    public function set_Code_' . $parent . '(int $Code_' . $parent . ') { $this->Code_' . $parent . ' = $Code_' . $parent . ';' . (count($l_compl) > 0 ? ' $this->completion();' : '' ) . (count($from) > 0 ? ' $this->genealogy();' : '') . ' }' . PHP_EOL;
                        $write = true;
                    }
                    $txt .= PHP_EOL;
                }
            }

            if ($write) {
                // Ecriture
                $txt .= '    // Write in DB' . PHP_EOL;
                $txt .= '    public function write(bool $force=false): array' . PHP_EOL;
                $txt .= '    {' . PHP_EOL;
                $txt .= '        $' . $entite . ' = [];' . PHP_EOL;
                foreach ($mf_dictionnaire_db as $colonne => $infos) {
                    if ($infos['entite'] == $entite && $infos['src'] == 'db') {
                        $txt .= '        $' . $entite . "['$colonne']" . ' = $this->' . $colonne . ';' . PHP_EOL;
                    }
                }
                $l = mf_get_liste_tables_parents($entite);
                foreach ($l as $parent) {
                    $txt .= '        $' . $entite . "['Code_$parent']" . ' = $this->Code_' . $parent . ';' . PHP_EOL;
                }
                $txt .= '        $db = new DB();' . PHP_EOL;
                if ($type_entite == 'entite') {
                    $txt .= '        return $db->' . $entite . '()->mf_modifier_2([$this->Code_' . $entite . ' => $' . $entite . '], $force);' . PHP_EOL;
                } else {
                    $txt .= '        return $db->' . $entite . '()->mf_modifier_2([$' . $entite . '], $force);' . PHP_EOL;
                }
                $txt .= '    }' . PHP_EOL;
                $txt .= PHP_EOL;
            }

            if ($type_entite == 'entite') {
                // Copy
                $txt .= '    // Write as new in DB' . PHP_EOL;
                $txt .= '    public function write_as_new(bool $force=false): int' . PHP_EOL;
                $txt .= '    {' . PHP_EOL;
                $txt .= '        $' . $entite . ' = [];' . PHP_EOL;
                foreach ($mf_dictionnaire_db as $colonne => $infos) {
                    if ($infos['entite'] == $entite && $infos['src'] == 'db') {
                        if ($colonne != "Code_$entite") {
                            $txt .= '        $' . $entite . "['$colonne']" . ' = $this->' . $colonne . ';' . PHP_EOL;
                        }
                    }
                }
                $l = mf_get_liste_tables_parents($entite);
                foreach ($l as $parent) {
                    $txt .= '        $' . $entite . "['Code_$parent']" . ' = $this->Code_' . $parent . ';' . PHP_EOL;
                }
                $txt .= '        $db = new DB();' . PHP_EOL;
                $txt .= '        $r = $db->' . $entite . '()->mf_ajouter_2($' . $entite . ', $force);' . PHP_EOL;
                $txt .= '        return $r[\'Code_' . $entite . '\'];' . PHP_EOL;
                $txt .= '    }' . PHP_EOL;
                $txt .= PHP_EOL;
            }

            // Indirect references
            if (count($from) > 0) {
                $txt .= '    // Indirect references' . PHP_EOL;
                foreach ($from as $parent_2 => $parent_1) {
                    $txt .= '    // Code_' . $parent_2 . PHP_EOL;
                    $txt .= '    public function get_Code_' . $parent_2 . '(): int { return $this->Code_' . $parent_2 . '; }' . PHP_EOL;
                }
                $txt .= PHP_EOL;
            }

            // Completion
            if (count($l_compl) > 0) {
                $txt .= "    // Completion" . PHP_EOL;
                foreach ($l_compl as $colonne => $infos) {
                    $colonne_synthese = substr($colonne, strlen($entite) + 1);
                    $txt .= '    // ' . $colonne . PHP_EOL;
                    $c = mf_type_sql2php($infos['type']);
                    $txt .= '    public function get_' . $colonne_synthese . '(): ' . $c . ' { return $this->' . $colonne . '; }' . PHP_EOL;
                }
                $txt .= PHP_EOL;

                $txt .= '    private function completion()' . PHP_EOL;
                $txt .= '    {' . PHP_EOL;
                $txt .= '        $donnees = [];' . PHP_EOL;
                $l = lister_colonnes_db($entite, '');
                foreach ($l as $colonne => $infos) {
                    $txt .= '        $donnees[\'' . $colonne . '\'] = $this->' . $colonne . ';' . PHP_EOL;
                }
                $l = mf_get_liste_tables_parents($entite);
                foreach ($l as $parent) {
                    $txt .= '        $donnees[\'Code_' . $parent . '\'] = $this->Code_' . $parent . ';' . PHP_EOL;
                }
                foreach ($l_compl as $colonne => $infos) {
                    $txt .= '        $donnees[\'' . $colonne . '\'] = $this->' . $colonne . ';' . PHP_EOL;
                }
                $txt .= '        Hook_' . $entite . '::completion($donnees, 0);' . PHP_EOL;
                foreach ($l_compl as $colonne => $infos) {
                    $txt .= '        $this->' . $colonne . ' = $donnees[\'' . $colonne . '\'];' . PHP_EOL;
                }
                $txt .= '    }' . PHP_EOL;
                $txt .= PHP_EOL;
            }

            // Indirect references
            if (count($from) > 0) {
                $txt .= '    // Indirect references' . PHP_EOL;
                $txt .= '    private function genealogy()' . PHP_EOL;
                $txt .= '    {' . PHP_EOL;
                $txt .= '        $db = new DB();' . PHP_EOL;
                foreach ($from as $parent_2 => $parent_1) {
                    $txt .= '        $this->Code_' . $parent_2 . ' = $db->' . $parent_1 . '()->mf_convertir_Code_' . $parent_1 . '_vers_Code_' . $parent_2 . '($this->Code_' . $parent_1 . ');' . PHP_EOL;
                }
                $txt .= '    }' . PHP_EOL;
                $txt .= PHP_EOL;
            }

            $txt .= "}" . PHP_EOL;

            // Enregistremet
            $doss = __DIR__ . "/rows/monframework/monframework_{$entite}.php";
            if (! file_exists($doss)) {
                file_put_contents($doss, $txt);
            } else {
                if (file_get_contents($doss) != $txt) {
                    file_put_contents($doss, $txt);
                }
            }

            //
            $txt = '<?php declare(strict_types=1);' . PHP_EOL;
            $txt .= PHP_EOL;
            $txt .= "class {$entite} extends monframework_{$entite}" . PHP_EOL;
            $txt .= "{" . PHP_EOL;
            $txt .= PHP_EOL;
            $txt .= "}" . PHP_EOL;

            // Enregistremet
            $doss = __DIR__ . "/rows/$entite.php";
            if (! file_exists($doss)) {
                file_put_contents($doss, $txt);
            }
        }
    }
    // Construction du worker (un worker par domaine)
    $source = __DIR__ . "/cron/mf_cron_run_script.txt";
    global $mf_get_HTTP_HOST;
    $dest = __DIR__ . "/cron/mf_cron_run_$mf_get_HTTP_HOST.php";
    $content = @file_get_contents($source);
    $content = str_replace('{host}', $mf_get_HTTP_HOST, $content);
    if (! file_exists($dest) || file_get_contents($dest) != $content) {
        file_put_contents($dest, $content);
    }
}

function format_sql(string $colonne, $valeur): string
{
    if (is_null($valeur)) {
        return 'NULL';
    }
    global $mf_dictionnaire_db;
    if (isset($mf_dictionnaire_db[$colonne])) {
        switch ($mf_dictionnaire_db[$colonne]['type']) {
            case 'INT':
            case 'BIGINT':
            case 'INTEGER':
                return (string) (int) $valeur;
            case 'TINYTEXT':
            case 'TEXT':
            case 'MEDIUMTEXT':
            case 'LONGTEXT':
            case 'VARCHAR':
                $valeur = text_sql((string) $valeur);
                return "'$valeur'";
            case 'BOOL':
                return ($valeur == true ? '1' : '0');
            case 'TIMESTAMP':
            case 'DATETIME':
                $valeur = format_datetime($valeur);
                return ($valeur != '' ? "'$valeur'" : 'NULL');
            case 'DOUBLE':
                return (string) mf_significantDigit(floatval(str_replace(',', '.', $valeur)), 15);
            case 'FLOAT':
                return (string) mf_significantDigit(floatval(str_replace(',', '.', $valeur)), 6);
            case 'DATE':
                $valeur = format_date($valeur);
                return ($valeur != '' ? "'$valeur'" : 'NULL');
            case 'PASSWORD':
                $salt = salt(100);
                $valeur = md5($valeur . $salt);
                return "'$valeur:$salt'";
            case 'TIME':
                $valeur = format_time($valeur);
                return ($valeur != '' ? "'$valeur'" : 'NULL');
        }
    }
    return 'NULL';
}

function mf_type_sql2php(string $type_sql, bool $nullable = true): string
{
    switch ($type_sql) {
        case 'INT':
        case 'BIGINT':
        case 'INTEGER':
            return ($nullable ? '?' : '') . 'int';
        case 'BOOL':
            return ($nullable ? '?' : '') . 'bool';
        case 'FLOAT':
        case 'DOUBLE':
            return ($nullable ? '?' : '') . 'float';
        default:
            return "string";
    }
}

$etsl_colonne_tri = '';
$etsl_mode_colonne_tri = '';
$etsl_position_dans_langue = array();
$etsl_initialisation = false;

function effectuer_tri_suivant_langue(&$liste, $colonne, $tri)
{
    global $etsl_colonne_tri, $etsl_mode_colonne_tri, $etsl_initialisation;
    $etsl_colonne_tri = $colonne;
    $etsl_mode_colonne_tri = $tri;
    $etsl_initialisation = false;
    if (! function_exists('cmp')) {
        function cmp($a, $b) {
            global $lang_standard, $etsl_colonne_tri, $etsl_mode_colonne_tri, $etsl_position_dans_langue, $etsl_initialisation;
            if (! $etsl_initialisation) {
                $etsl_position_dans_langue = array();
                if (isset($lang_standard[$etsl_colonne_tri . '_'])) {
                    $i = 0;
                    foreach ($lang_standard[$etsl_colonne_tri . '_'] as $code => &$val) {
                        $etsl_position_dans_langue[$code] = $i;
                        $i ++;
                    }
                    unset($val);
                }
                $etsl_initialisation = true;
            }
            $v_a = isset($a[$etsl_colonne_tri]) && isset($etsl_position_dans_langue[$a[$etsl_colonne_tri]]) ? $etsl_position_dans_langue[$a[$etsl_colonne_tri]] : 0;
            $v_b = isset($b[$etsl_colonne_tri]) && isset($etsl_position_dans_langue[$b[$etsl_colonne_tri]]) ? $etsl_position_dans_langue[$b[$etsl_colonne_tri]] : 0;
            if ($v_a == $v_b) {
                return 0;
            }
            if ($etsl_mode_colonne_tri == 'ASC') {
                return ($v_a > $v_b) ? + 1 : - 1;
            } else {
                return ($v_a > $v_b) ? - 1 : + 1;
            }
        }
    }
    uasort($liste, 'cmp');
}

/* autres fonctions */

$ttsuc_colonne = '';
$ttsuc_tri = '';

function trier_tableau_suivant_une_colonne(&$liste, $colonne, $tri)
{
    global $ttsuc_colonne, $ttsuc_tri;
    $ttsuc_colonne = $colonne;
    $ttsuc_tri = $tri;
    uasort($liste, 'ttsc_cmp');
}

function ttsc_cmp($a, $b)
{
    global $ttsuc_colonne, $ttsuc_tri;
    $v_a = $a[$ttsuc_colonne];
    $v_b = $b[$ttsuc_colonne];
    if ($v_a == $v_b) {
        return 0;
    }
    if ($ttsuc_tri == 'ASC') {
        return ($v_a > $v_b) ? + 1 : - 1;
    } else {
        return ($v_a > $v_b) ? - 1 : + 1;
    }
}

$ttspc_colonnes = [];

function trier_tableau_suivant_plusieurs_colonnes(&$liste, $colonnes) // $colonnes = [ 'Colonne A' => ASC, 'Colonne B' => ASC, ... ]
{
    global $ttspc_colonnes;
    $ttspc_colonnes = $colonnes;
    uasort($liste, 'ttspc_cmp');
}

function ttspc_cmp($a, $b)
{
    global $ttspc_colonnes;
    foreach ($ttspc_colonnes as $colonne => $tri) {
        $v_a = $a[$colonne];
        $v_b = $b[$colonne];
        if ($v_a != $v_b) // si $a != $b alors, on a un résultat non null, sinon, on passe à la colonne suivante
        {
            if ($tri == 'ASC') {
                return ($v_a > $v_b) ? + 1 : - 1;
            } else {
                return ($v_a > $v_b) ? - 1 : + 1;
            }
        }
    }
    return 0;
}

function lecture_parametre_api($nom, $val_non_lue = null)
{
    return (isset($_GET[$nom]) ? $_GET[$nom] : (isset($_POST[$nom]) ? $_POST[$nom] : $val_non_lue));
}

function isset_parametre_api($nom)
{
    return (isset($_GET[$nom]) || isset($_POST[$nom]));
}

function prec_suiv(&$liste, $code_central)
{
    $prec = array();
    $suiv = array();
    $suiv_a_initialiser = false;
    $prec_initialiser = false;
    foreach ($liste as $Code_temp => &$value) {
        $trouve = ($Code_temp == $code_central);
        if ($trouve) {
            $prec_initialiser = true;
        }
        if (! $prec_initialiser) {
            $prec = $value;
        }
        if ($suiv_a_initialiser) {
            $suiv = $value;
        }
        $suiv_a_initialiser = $trouve;
    }
    return array(
        'prec' => $prec,
        'suiv' => $suiv
    );
}

function vue_api_echo(&$donnees)
{
    $vue = lecture_parametre_api('vue', 'json');
    switch ($vue) {
        case 'json':
            header('Content-Type: application/json');
            echo json_encode($donnees);
            break;
        case 'tableau':
            echo '<!DOCTYPE html><html lang="fr"><head><meta charset=\'UTF-8\'><title></title></head><body>' . vue_tableau_html($donnees) . '</body></html>';
            break;
        default:
            echo json_encode($donnees);
            break;
    }
}

function mf_matrice_droits($fonctions)
{
    global $mf_droits_defaut;
    if (! MODE_PROD) {
        $test = false;
        foreach ($fonctions as &$fonction) {
            if ($mf_droits_defaut[$fonction]) {
                $test = true;
            }
        }
        if (! $test) {
            if (strpos($_SERVER['PHP_SELF'], '/api.rest/') === false) {
                $debug = debug_backtrace();
                foreach ($debug as $t) {
                    echo $t['file'] . ' # ' . $t['function'] . ' (Ligne ' . $t['line'] . ')<br>';
                }
                foreach ($fonctions as &$fonction) {
                    echo ' > ' . $fonction . '<br>';
                }
                echo '<br>';
            }
        }
    }
    foreach ($fonctions as &$fonction) {
        if ($mf_droits_defaut[$fonction])
            return true;
    }
    unset($fonction);
    return false;
}

function controle_parametre($DB_name, $valeur)
{
    global $lang_standard;
    $valeur = round($valeur);
    if (isset($lang_standard[$DB_name . '_'])) {
        foreach ($lang_standard[$DB_name . '_'] as $key => &$value) {
            if ($key == $valeur)
                return true;
        }
        unset($value);
    }
    return false;
}

/**
 * Formatage d'une chaine pour l'intégrer dans une requête SQL
 * @param string $txt
 * @return string
 */
function text_sql(string $txt): string
{
    global $link;
    if ($link == null) {
        connexion_db($link);
    }
    return mysqli_real_escape_string($link, $txt);
}

function nom_fichier_formate(string $string): string
{
    $trans = array(
        '\\' => '',
        '/' => '',
        ':' => '',
        '*' => '',
        '?' => '',
        '"' => '',
        '<' => '',
        '>' => '',
        '|' => ''
    );
    $string = strtr($string, $trans);
    while (substr($string, 0, 1) == ' ') {
        $string = substr($string, 1);
    }
    while (substr($string, strlen($string) - 1) == ' ') {
        $string = substr($string, 0, strlen($string) - 1);
    }
    $l = 0;
    while ($l != strlen($string)) {
        $l = strlen($string);
        $string = str_replace('  ', ' ', $string);
    }
    return $string;
}

/**
 * @param string $date_str
 * @return string
 */
function format_date(string $date_str): string
{
    $d = explode('-', $date_str);
    $AAAA = (isset($d[0]) ? intval($d[0]) : 0);
    $MM = (isset($d[1]) ? intval($d[1]) : 0);
    $JJ = (isset($d[2]) ? intval($d[2]) : 0);
    if (1000 <= $AAAA && $AAAA <= 9999) {
        if (checkdate($MM, $JJ, $AAAA)) {
            if ($MM < 10) { $MM = '0' . $MM; }
            if ($JJ < 10) { $JJ = '0' . $JJ; }
            return "$AAAA-$MM-$JJ";
        }
    }
    return '';
}

function Sql_Format_Liste($liste)
{
    $retour = '(-1';
    foreach ($liste as &$value) {
        $retour .= ',' . round($value);
    }
    $retour .= ')';
    return $retour;
}

function enumeration($liste, $sep = ',')
{
    $retour = '';
    foreach ($liste as &$value) {
        $retour .= ($retour != '' ? $sep : '') . $value;
    }
    return $retour;
}

function format_datetime($datetime)
{
    $p = strrpos($datetime, ' ');
    if ($p == 0)
        $p = strrpos($datetime, 'T');
    if ($p > 0) {
        $date = substr($datetime, 0, $p);
        $time = substr($datetime, $p + 1);
    } else {
        return '';
    }
    $date = format_date($date);
    $time = format_time($time);
    if ($date != '' && $time != '')
        return $date . ' ' . $time;
    else
        return '';
}

/**
 * @param string $time
 * @return string
 */
function format_time(string $time): string
{
    $time = str_replace('Z', '', $time);
    $time = substr($time, - 8);
    $d = explode(':', $time);
    $hh = (isset($d[0]) ? intval($d[0]) : 0);
    $mm = (isset($d[1]) ? intval($d[1]) : 0);
    $ss = (isset($d[2]) ? intval($d[2]) : 0);
    if (24 > $hh && $hh >= 0 && 60 > $mm && $mm >= 0 && 60 > $ss && $ss >= 0) {
        if ($hh < 10) {
            $hh = "0$hh";
        }
        if ($mm < 10) {
            $mm = "0$mm";
        }
        if ($ss < 1) {
            $ss = "0$ss";
        }
        return $hh . ':' . $mm . ':' . $ss;
    }
    return '';
}

/**
 * @param string $heure_str
 * @return float|null
 */
function conversion_heure_vers_secondes(string $heure_str): ?float
{
    $heure_str = format_time($heure_str);
    if ($heure_str != '') {
        $h = round(substr($heure_str, 0, 2));
        $m = round(substr($heure_str, 3, 2));
        $s = round(substr($heure_str, 6, 2));
        return ($h * 3600 + $m * 60 + $s);
    }
    return null;
}

/**
 * @param int $nb_secondes
 * @return string
 */
function conversion_secondes_vers_heure(int $nb_secondes): string
{
    $nb_secondes = round($nb_secondes);
    if ($nb_secondes < 0)
        $nb_secondes = 0;
    if ($nb_secondes > 86399)
        $nb_secondes = 86399;

    $ss = $nb_secondes % 60;
    $nb_secondes = ($nb_secondes - $ss) / 60;
    $mm = $nb_secondes % 60;
    $nb_secondes = ($nb_secondes - $mm) / 60;
    $hh = $nb_secondes;

    if ($hh < 10)
        $hh = '0' . $hh;
    if ($mm < 10)
        $mm = '0' . $mm;
    if ($ss < 10)
        $ss = '0' . $ss;

    return $hh . ':' . $mm . ':' . $ss;
}

/**
 * @param string $date_str
 * @return string
 */
function date_debut_annee(string $date_str): string
{
    $date_str = format_date($date_str);
    $date_str = substr($date_str, 0, 5) . '01-01';
    return format_date($date_str);
}

/**
 * @param string $date_str
 * @return string
 */
function date_fin_annee(string $date_str): string
{
    $date_str = format_date($date_str);
    $date_str = substr($date_str, 0, 5) . '12-31';
    return format_date($date_str);
}

/**
 * @param string $date_str
 * @return string
 */
function date_debut_mois(string $date_str): string
{
    $date_str = format_date($date_str);
    $date_str = substr($date_str, 0, 8) . '01'; // pour etre certain de prendre le premier jour du mois
    return $date_str;
}

/**
 * @param string $date_str
 * @return string
 */
function date_fin_mois(string $date_str): string
{
    $date_str = format_date($date_str);
    if ($date_str != '') {
        $date_str = substr($date_str, 0, 8) . '01'; // pour etre certain de prendre le premier jour du mois
        try {
            $date = new DateTime($date_str);
            $diff1Month = new DateInterval('P1M');
            $date->add($diff1Month); // on ajouter un mois
            $diff1Day = new DateInterval('P1D');
            $date->sub($diff1Day); // on retire un jour
            return $date->format('Y-m-d');
        } catch (Exception $e) {
            set_log($e->getTraceAsString());
            return '';
        }
    }
    return '';
}

/**
 * @param string $date_str
 * @return string
 */
function date_debut_semaine(string $date_str): string
{
    $date_str = format_date($date_str);
    try {
        $date = new DateTime($date_str);
        $diff1Day = new DateInterval('P1D');
        while ($date->format('w') != 1) {
            $date->sub($diff1Day);
        }
        return $date->format('Y-m-d');
    } catch (Exception $e) {
        set_log($e->getTraceAsString());
        return '';
    }
}

/**
 * @param string $date_str
 * @return string
 */
function date_fin_semaine(string $date_str): string
{
    $date_str = format_date($date_str);
    try {
        $date = new DateTime($date_str);
        $diff1Day = new DateInterval('P1D');
        while ($date->format('w') != 0) {
            $date->add($diff1Day);
        }
        return $date->format('Y-m-d');
    } catch (Exception $e) {
        set_log($e->getTraceAsString());
        return '';
    }
}

/**
 * Convertion d'une date en temps unix
 * @param string $date_str
 * @return int|null
 */

function date_vers_unix_sec(string $date_str): ?int
{
    $date_str = format_date($date_str);
    if ($date_str != '') {
        try {
            $date = new DateTime($date_str);
            return (int) $date->format('U');
        } catch (Exception $e) {
            set_log($e->getTraceAsString());
            return null;
        }
    } else {
        return null;
    }
}

/**
 * @param string $date_str
 * @param int $nb_jours
 * @return string
 */
function date_ajouter_nb_jours(string $date_str, int $nb_jours): string
{
    if ($nb_jours < 0) {
        return date_soustraire_nb_jours($date_str, -$nb_jours);
    }
    try {
        $date = new DateTime(format_date($date_str));
        $date->add(new DateInterval("P{$nb_jours}D"));
        return $date->format('Y-m-d');
    } catch (Exception $e) {
        set_log($e->getTraceAsString());
        return '';
    }
}

/**
 * @param string $date_str
 * @param int $nb_jours
 * @return string
 */
function date_soustraire_nb_jours(string $date_str, int $nb_jours): string
{
    if ($nb_jours < 0) {
        return date_ajouter_nb_jours($date_str, -$nb_jours);
    }
    try {
        $date = new DateTime(format_date($date_str));
        $date->sub(new DateInterval("P{$nb_jours}D"));
        return $date->format('Y-m-d');
    } catch (Exception $e) {
        set_log($e->getTraceAsString());
        return '';
    }
}

/**
 * @param string $datetime_str
 * @param int $nb_jours
 * @return string
 */
function datetime_ajouter_nb_jours(string $datetime_str, int $nb_jours): string
{
    if ($nb_jours < 0) {
        return datetime_soustraire_nb_jours($datetime_str, -$nb_jours);
    }
    try {
        $date = new DateTime(format_datetime($datetime_str));
        $diff1Day = new DateInterval('P1D');
        $nb_jours = round($nb_jours);
        for ($n = 0; $n < $nb_jours; $n ++) {
            $date->add($diff1Day);
        }
        return $date->format('Y-m-d H:i:s');
    } catch (Exception $e) {
        set_log($e->getTraceAsString());
        return '';
    }
}

/**
 * @param string $datetime_str
 * @param int $nb_jours
 * @return string
 */
function datetime_soustraire_nb_jours(string $datetime_str, int $nb_jours): string
{
    if ($nb_jours < 0) {
        return datetime_ajouter_nb_jours($datetime_str, - $nb_jours);
    }
    try {
        $date = new DateTime(format_datetime($datetime_str));
        $diff1Day = new DateInterval('P1D');
        $nb_jours = round($nb_jours);
        for ($n = 0; $n < $nb_jours; $n ++) {
            $date->sub($diff1Day);
        }
        return $date->format('Y-m-d H:i:s');
    } catch (Exception $e) {
        set_log($e->getTraceAsString());
        return '';
    }
}

/**
 * @param string $datetime_str
 * @return string
 */
function datetime_tronquer_a_la_minute(string $datetime_str): string
{
    $datetime_str = format_datetime($datetime_str);
    return substr($datetime_str, 0, 17) . '00';
}

/**
 * @param string $datetime_str
 * @param string $time
 * @return string
 */
function datetime_ajouter_time(string $datetime_str, string $time): string
{
    try {
        $date = new DateTime(format_datetime($datetime_str));
        $diff = new DateInterval('PT' . conversion_heure_vers_secondes($time) . 'S');
        $date->add($diff);
        return $date->format('Y-m-d H:i:s');
    } catch (Exception $e) {
        set_log($e->getTraceAsString());
        return '';
    }
}

/**
 * @param string $datetime_str
 * @param int $sec
 * @return string
 */
function datetime_ajouter_sec(string $datetime_str, int $sec): string
{
    if ($sec < 0) {
        return datetime_soustraire_sec($datetime_str, - $sec);
    }
    try {
        $date = new DateTime(format_datetime($datetime_str));
        $diff = new DateInterval('PT' . $sec . 'S');
        $date->add($diff);
        return $date->format('Y-m-d H:i:s');
    } catch (Exception $e) {
        set_log($e->getTraceAsString());
        return '';
    }
}

/**
 * @param string $datetime_str
 * @param int $sec
 * @return string
 */
function datetime_soustraire_sec(string $datetime_str, int $sec): string
{
    if ($sec < 0) {
        return datetime_ajouter_sec($datetime_str, - $sec);
    }
    try {
        $date = new DateTime(format_datetime($datetime_str));
        $diff = new DateInterval('PT' . $sec . 'S');
        $date->sub($diff);
        return $date->format('Y-m-d H:i:s');
    } catch (Exception $e) {
        set_log($e->getTraceAsString());
        return '';
    }
}

/**
 * @param string $datetime_str
 * @param string $time
 * @return string
 */
function datetime_soustraire_time(string $datetime_str, string $time): string
{
    try {
        $date = new DateTime(format_datetime($datetime_str));
        $diff = new DateInterval('PT' . conversion_heure_vers_secondes($time) . 'S');
        $date->sub($diff);
        return $date->format('Y-m-d H:i:s');
    } catch (Exception $e) {
        set_log($e->getTraceAsString());
        return '';
    }
}

/**
 * @param string $datetime_str
 * @return int|null
 */
function datetime_vers_secondes_unix(string $datetime_str): ?int
{
    try {
        $date = new DateTime(format_datetime($datetime_str));
        return (int) $date->format('U');
    } catch (Exception $e) {
        set_log($e->getTraceAsString());
        return null;
    }
}

function get_nom_valeur($DB_name, $valeur)
{
    global $lang_standard;
    if (isset($lang_standard[$DB_name . '_'][$valeur]))
        return $lang_standard[$DB_name . '_'][$valeur];
    else
        return '…';
}

function get_titre_ligne_table($libelle_table, $entite)
{
    global $mf_titre_ligne_table;
    global $lang_standard;
    if ($libelle_table == '__instance') {
        $expr = TITRE_DB_INSTANCE;
        $retour = TITRE_DB_INSTANCE;
    } else {
        $expr = $mf_titre_ligne_table[$libelle_table];
        $retour = $mf_titre_ligne_table[$libelle_table];
    }
    while (stripos($expr, '}') > 0) {
        $p1 = stripos($expr, '{');
        $p2 = stripos($expr, '}');
        $cle = substr($expr, $p1 + 1, $p2 - $p1 - 1);
        $expr = substr($expr, $p2 + 1);
        if (isset($entite[$cle])) {
            if (isset($lang_standard[$cle . '_'])) {
                $retour = str_replace('{' . $cle . '}', get_nom_valeur($cle, $entite[$cle]), $retour);
            } else {
                $retour = str_replace('{' . $cle . '}', get_valeur_formate($cle, $entite[$cle]), $retour);
            }
        }
    }
    if (str_replace(' ', '', $retour) == '')
        $retour = '…';
    return $retour;
}

function get_valeur_formate($DB_name, $valeur)
{
    global $mf_dictionnaire_db;

    switch ($mf_dictionnaire_db[$DB_name]['type']) {
        case 'DATE':
            return format_date_fr($valeur);
            break;
        case 'DATETIME':
            return format_datetime_fr($valeur);
            break;
        case 'TIME':
            return format_time_fr($valeur);
            break;
        case 'MEDIUMTEXT':
        case 'VARCHAR':
        case 'TEXT':
            return '' . $valeur;
            break;
        default:
            return htmlspecialchars((string) $valeur);
            break;
    }
}

/**
 * @param string $date
 * @return string
 */
function format_date_fr(string $date): string
{
    $date = format_date($date);
    if ($date != '') {
        $d = explode('-', $date);
        $AAAA = '' . (isset($d[0]) ? round($d[0]) : 0);
        $MM = '' . (isset($d[1]) ? round($d[1]) : 0);
        $JJ = '' . (isset($d[2]) ? round($d[2]) : 0);
        if (strlen($JJ) == 1) {
            $JJ = '0' . $JJ;
        }
        if (strlen($MM) == 1) {
            $MM = '0' . $MM;
        }
        return $JJ . '/' . $MM . '/' . $AAAA;
    } else {
        return '';
    }
}

/**
 * @param string $date
 * @param int $mode
 * @return string
 */
function format_date_fr_en_lettre(string $date, int $mode = 0): string
{
    $date = format_date($date);
    if ($date != '') {
        global $lang_standard;
        try {
            $date = new DateTime($date);
            switch ($mode) {
                case 0:
                    return $lang_standard['liste_jours'][$date->format('w')] . ' ' . $date->format('j') . ' ' . $lang_standard['liste_mois'][$date->format('n')] . ' ' . $date->format('Y');
                    break;
                case 1:
                    return $lang_standard['liste_jours_2'][$date->format('w')] . ' ' . $date->format('j') . ' ' . $lang_standard['liste_mois_2'][$date->format('n')] . ' ' . $date->format('Y');
                    break;
                case 2:
                    return $date->format('j') . ' ' . $lang_standard['liste_mois'][$date->format('n')] . ' ' . $date->format('Y');
                    break;
            }
        } catch (Exception $e) {
            set_log($e->getTraceAsString());
            return '';
        }
    }
    return '';
}

/**
 * @param string $datetime
 * @param bool $aff_secondes
 * @return string
 */
function format_datetime_fr(string $datetime, bool $aff_secondes = true): string
{
    $p = strrpos($datetime, ' ');
    if ($p == 0)
        $p = strrpos($datetime, 'T');
    if ($p > 0) {
        $date = substr($datetime, 0, $p);
        $time = substr($datetime, $p + 1);
    } else {
        return '';
    }
    $date = format_date_fr($date);
    if (! $aff_secondes || substr(format_time($time), 5) == ':00')
        $time = substr(format_time($time), 0, 5);
    if ($date != '' && $time != '')
        return $date . ' à ' . $time;
    else
        return '';
}

function get_valeur_auto($DB_name, $valeur)
{
    global $lang_standard;
    if (isset($lang_standard[$DB_name . '_'])) {
        return get_nom_valeur($DB_name, $valeur);
    } else {
        return get_valeur_formate($DB_name, $valeur);
    }
}

function get_nom_colonne($DB_name)
{
    global $lang_standard;
    if (isset($lang_standard[$DB_name]))
        return $lang_standard[$DB_name];
    else
        return $DB_name;
}

function text_html_br(string $txt): string
{
    return strtr(htmlspecialchars($txt), array(
        "\r\n" => '<br>',
        chr(13) => '<br>',
        "\n" => '<br>'
    ));
}

function salt(int $len): string
{
    $list = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $l = strlen($list);
    mt_srand((int) (10000000 * (double) microtime()));
    $salt = '';
    for ($i = 0; $i < $len; $i ++) {
        $salt .= $list[mt_rand(0, $l - 1)];
    }
    return $salt;
}

function salt_minuscules(int $len): string
{
    $list = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $l = strlen($list);
    mt_srand((int) (10000000 * (double) microtime()));
    $salt = '';
    while (strlen($salt) < $len) {
        $salt_temp = '';
        for ($i = 0; $i < 10000; $i ++)
            $salt_temp .= $list[mt_rand(0, $l - 1)];
        $salt .= md5($salt_temp);
    }
    return substr($salt, 0, $len);
}

/**
 * @param $donnees
 * @param string $prefixe
 * @return string
 */
function vue_tableau_html($donnees, string $prefixe = ''): string
{
    $txt = '';
    if (is_array($donnees)) {
        $txt .= '<table style="border-collapse: collapse; border: 1px solid gray;">';
        foreach ($donnees as $key => $value) {
            $txt .= '<tr><td>' . $key . '</td><td>' . vue_tableau_html($value, $prefixe) . '</td></tr>';
        }
        $txt .= '</table>';
    } else {
        $txt .= $prefixe . htmlspecialchars((string) $donnees);
    }
    return $txt;
}

function mf_verification_avant_conversion_json(&$donnees)
{
    if (is_array($donnees)) {
        foreach ($donnees as &$value) {
            mf_verification_avant_conversion_json($value);
        }
    } elseif (is_string($donnees)) {
        $donnees = htmlspecialchars_decode(htmlspecialchars($donnees));
    }
}

function definir_colonne_completion($ratachement_table, $nom_colonne, $db_type, $libelle_langue)
{
    global $lang_standard, $mf_dictionnaire_db;
    if (! MODE_PROD) {
        global $mf_titre_ligne_table;
        if (! isset($mf_titre_ligne_table[$ratachement_table])) {
            echo '<b><i>ATTENTION : l\'entité "<u>' . $ratachement_table . '</u>" n\'existe pas !</i></b>';
        }
        if (isset($mf_dictionnaire_db[$nom_colonne])) {
            $txt = "La colonne $nom_colonne est déjà existante.";
            mf_bah_quest_ce_qui_ce_passe("Erreur conflit", $txt, '#FF0A27');
        }
    }
    $lang_standard[$nom_colonne] = $libelle_langue;
    $mf_dictionnaire_db[$nom_colonne]['type'] = $db_type;
    $mf_dictionnaire_db[$nom_colonne]['entite'] = $ratachement_table;
    $mf_dictionnaire_db[$nom_colonne]['src'] = 'compl';
}

function hex2rgb($color)
{
    if (strlen($color) > 1 && $color[0] == '#') {
        $color = substr($color, 1);
    }
    if (strlen($color) == 6) {
        list ($r, $g, $b) = array(
            $color[0] . $color[1],
            $color[2] . $color[3],
            $color[4] . $color[5]
        );
    } elseif (strlen($color) == 3) {
        list ($r, $g, $b) = array(
            $color[0] . $color[0],
            $color[1] . $color[1],
            $color[2] . $color[2]
        );
    } else {
        return false;
    }
    return array(
        'r' => hexdec($r),
        'g' => hexdec($g),
        'b' => hexdec($b)
    );
}

function luminosite_rgb($r, $g, $b)
{
    return (0.212671 * $r + 0.715160 * $g + 0.072169 * $b) / 255;
}

function luminosite_hex($color)
{
    if ($rgb = hex2rgb($color)) {
        return luminosite_rgb($rgb['r'], $rgb['g'], $rgb['b']);
    }
    return 0;
}

/**
 * Définir la luminosité
 * @param int $r
 * @param int $g
 * @param int $b
 * @param float $new_lum
 * @return array
 */
function set_luminosite_rgb(int $r, int $g, int $b, float $new_lum)
{
    if ($r == 0) {
        $r = 1;
    }
    if ($g == 0) {
        $g = 1;
    }
    if ($b == 0) {
        $b = 1;
    }
    $r_old = - 1;
    $g_old = - 1;
    $b_old = - 1;
    while ($r_old != $r || $g_old != $g || $b_old != $b) {
        $r_old = $r;
        $g_old = $g;
        $b_old = $b;
        $lum = luminosite_rgb($r, $g, $b);
        $r = min([round($r * $new_lum / $lum, 2), 255]);
        $g = min([round($g * $new_lum / $lum, 2), 255]);
        $b = min([round($b * $new_lum / $lum, 2), 255]);
    }
    return array(
        'r' => round($r),
        'g' => round($g),
        'b' => round($b)
    );
}

function maj_plage_horaire(&$debut_new, &$fin_new, &$duree_new, $debut_old, $fin_old, $duree_old)
{
    $debut_new = arrondir_date_minute($debut_new);
    $fin_new = arrondir_date_minute($fin_new);
    if ($debut_new == '') {
        $debut_new = $debut_old;
    }
    if ($fin_new == '') {
        $fin_new = $fin_old;
    }
    if ($duree_new <= 0) {
        $duree_new = $duree_old;
    }
    try {
        if ($duree_new != $duree_old || $debut_new != $debut_old) {
            $date = new DateTime($debut_new);
            $date->add(new DateInterval('PT' . round(3600 * $duree_new) . 'S'));
            $fin_new = $date->format('Y-m-d H:i:s');
        } elseif ($fin_new != $fin_old) {
            if ($fin_new > $debut_new) {
                $datetime1 = new DateTime($debut_new);
                $datetime2 = new DateTime($fin_new);
                $secondes = $datetime2->getTimestamp() - $datetime1->getTimestamp();
                $duree_new = round($secondes / 3600, 2);
            } else {
                $fin_new = $debut_old;
            }
        }
    } catch (Exception $e) {
        set_log($e->getTraceAsString());
    }
    $debut_new = arrondir_date_minute($debut_new);
    $fin_new = arrondir_date_minute($fin_new);
}

function arrondir_date_minute($date_str)
{
    return format_datetime(substr($date_str, 0, 16) . ':00');
}

function lister_cles($liste)
{
    $liste_key = array();
    foreach ($liste as $code => &$value) {
        $liste_key[] = $code;
    }
    unset($value);
    return $liste_key;
}

function liste_A_moins_B($liste_cle_A, $liste_cle_B)
{
    $a_inxex = array();
    foreach ($liste_cle_A as $akey) {
        $a_inxex[$akey] = $akey;
    }
    foreach ($liste_cle_B as $bkey) {
        if (isset($a_inxex[$bkey])) {
            unset($a_inxex[$bkey]);
        }
    }
    $retour = array();
    foreach ($a_inxex as $key) {
        $retour[] = $key;
    }
    return $retour;
}

function liste_intersection_A_et_B($liste_cle_A, $liste_cle_B)
{
    $a_inxex = array();
    foreach ($liste_cle_A as $akey) {
        $a_inxex[$akey] = $akey;
    }
    $retour = array();
    foreach ($liste_cle_B as $bkey) {
        if (isset($a_inxex[$bkey])) {
            $retour[] = $bkey;
        }
    }
    return $retour;
}

function liste_union_A_et_B($liste_cle_A, $liste_cle_B)
{
    $index = array();
    foreach ($liste_cle_A as $akey) {
        $index[$akey] = $akey;
    }
    foreach ($liste_cle_B as $bkey) {
        $index[$bkey] = $bkey;
    }
    $retour = array();
    foreach ($index as $i) {
        $retour[] = $i;
    }
    return $retour;
}

function get_image($valeur, $width = IMAGES_LARGEUR_MAXI, $height = IMAGES_HAUTEUR_MAXI, $mode_remplissage = true, $alt = '', $format_png = false, $style = '', $class = '', $rotate = 0): string
{
    if ($valeur != '') {
        return '<img class="' . $class . '" alt="' . htmlspecialchars($alt) . '" title="' . htmlspecialchars($alt) . '" src="' . mf_get_image_src($valeur, (MODE_RETINA ? 2 * $width : $width), (MODE_RETINA ? 2 * $height : $height), $mode_remplissage, $format_png, $rotate) . '" class="fichier_photo" style="max-width: ' . $width . 'px; max-height: ' . $height . 'px; ' . $style . '">';
    } else {
        return '…';
    }
}

function mf_get_image_src(string $valeur, int $width = IMAGES_LARGEUR_MAXI, int $height = IMAGES_HAUTEUR_MAXI, bool $mode_remplissage = true, bool $format_png = false, int $rotate = 0): string
{
    return 'mf_fichier.php?n=' . $valeur . ($format_png ? '&format_png=1' : '&format_png=0') . '&width=' . $width . '&height=' . $height . ($mode_remplissage ? '&troncage=1' : '') . '&rotate=' . $rotate;
}

$num_sendemail = 1;

function sendemail($to, $title, $content, $from = MAIL_NOREPLY, $attachement_str = '', $replyto = MAIL_NOREPLY, $gabarit = 'main.html')
{
    $verif_email = false;

    $rn = PHP_EOL;

    $caracteres_parasites = [
        "\n" => '',
        "\r" => '',
        "\t" => ' '
    ];

    $trans = [
        '<br>' => '<br>' . $rn,
        '<br />' => '<br />' . $rn,
        '<hr>' => $rn . '<hr>' . $rn
    ];

    $trans_html = $trans;

    $autres_balises = [
        'p',
        'ul',
        'li',
        'tr',
        'td',
        'div',
        'head',
        'style',
        'body',
        'table',
        'a',
        'img'
    ];

    foreach ($autres_balises as $balise) {
        $trans_html['<' . $balise . '>'] = $rn . '<' . $balise . '>';
        $trans_html['<' . $balise . ' '] = $rn . '<' . $balise . ' ';
        $trans_html['</' . $balise . '>'] = '</' . $balise . '>' . $rn;
    }

    // Contenu du mail (version text et HTML)
    $title = strtr($title, $caracteres_parasites);
    $content = strtr($content, $caracteres_parasites);
    // html
    $content_html = strtr(get_gabarit('gabarits-e-mail/' . $gabarit, [
        '{title}' => $title,
        '{content}' => $content,
        '{website_adress}' => ADRESSE_SITE
    ]), $caracteres_parasites);
    $d = 0;
    while ($d != strlen($content_html)) {
        $d = strlen($content_html);
        $content_html = str_replace('  ', ' ', $content_html);
    }
    // Importance de couper régulièrement les lignes pour éviter des lignes trop longue. Sinon, risque de lignes coupées en plein milieu !
    $content_html = strtr($content_html, $trans_html);
    $content_html = str_replace($rn . ' </', $rn . '</', $content_html);
    $content_html = str_replace($rn . ' ' . $rn, $rn, $content_html);
    $d = 0;
    while ($d != strlen($content_html)) {
        $d = strlen($content_html);
        $content_html = str_replace($rn . $rn, $rn, $content_html);
    }
    $lignes = explode($rn, $content_html);
    $content_html = '';
    foreach ($lignes as $ligne) {
        if (strlen($ligne) < 195) {
            $content_html .= $ligne . $rn;
        } else {
            $mots = explode(' ', $ligne);
            foreach ($mots as $mot) {
                $content_html .= $mot . $rn;
            }
        }
    }
    // text
    $message_txt = strip_tags(strtr($content, $trans));
    $title = strip_tags($title);

    global $mf_get_HTTP_HOST;
    if ($mf_get_HTTP_HOST != 'localhost') {

        if ($attachement_str == '') {
            // Création du boundary
            $boundary = md5(uniqid(microtime(), TRUE));

            // Header le l'email
            $header = 'From: ' . $from . $rn;
            $header .= 'Reply-to: ' . $replyto . $rn;
            $header .= 'MIME-Version: 1.0' . $rn;
            $header .= 'Content-Type: multipart/alternative;boundary="' . $boundary . '"' . $rn;

            // Message format texte
            $message = $rn . '--' . $boundary . $rn;
            $message .= 'Content-Type: text/plain; charset="utf-8"' . $rn;
            $message .= 'Content-Transfer-Encoding: 8bit' . $rn;
            $message .= $message_txt . $rn;

            // Message en HTML
            $message .= $rn . '--' . $boundary . $rn;
            $message .= 'Content-Type: text/html; charset="utf-8"' . $rn;
            $message .= 'Content-Transfer-Encoding: 8bit' . $rn;
            $message .= $content_html . $rn;

            // Fin
            $message .= $rn . '--' . $boundary . '--' . $rn;

            // Envoi de l'email
            $verif_email = @mail($to, $title, $message, $header);
        } else {

            if (! file_exists($attachement_str)) {
                global $mf_get_HTTP_HOST;
                $attachement_folder = __DIR__ . "/../../fichiers/$mf_get_HTTP_HOST/" . NOM_PROJET . "/";
                if (TABLE_INSTANCE != '') {
                    $instance = 'inst_' . get_instance();
                    $attachement_folder .= $instance . '/';
                }
                $attachement_str = $attachement_folder . $attachement_str;
            }

            $file = new Fichier();
            $ext = $file->get_extention($attachement_str);
            $mine_type = $file->get_mine_type($ext);
            if ($mine_type != '') {

                // Lecture de la pièce jointe
                $fichier = fopen($attachement_str, 'r');
                $attachement = fread($fichier, filesize($attachement_str));
                $attachement = chunk_split(base64_encode($attachement));
                fclose($fichier);

                // Génération des boundarys
                $boundary = md5(uniqid(microtime(), TRUE));
                $boundary_content = md5(uniqid(microtime(), TRUE));

                // Header
                $header = 'From: ' . $from . $rn;
                $header .= 'Reply-to: ' . $replyto . $rn;
                $header .= 'MIME-Version: 1.0' . $rn;
                $header .= 'Content-Type: multipart/mixed;boundary="' . $boundary . '"' . $rn;

                // Début message
                $message = $rn . '--' . $boundary . $rn;
                $message .= 'Content-Type: multipart/alternative;boundary="' . $boundary_content . '"' . $rn;

                // Message texte
                $message .= $rn . '--' . $boundary_content . $rn;
                $message .= 'Content-Type: text/plain; charset="utf-8"' . $rn;
                $message .= 'Content-Transfer-Encoding: 8bit' . $rn;
                $message .= $message_txt . $rn;

                // Message HTML
                $message .= $rn . '--' . $boundary_content . $rn;
                $message .= 'Content-Type: text/html; charset="utf-8"' . $rn;
                $message .= 'Content-Transfer-Encoding: 8bit' . $rn;
                $message .= $content_html . $rn;

                // Fin content
                $message .= $rn . '--' . $boundary_content . '--' . $rn;

                // Pièce jointe
                $message .= $rn . '--' . $boundary . $rn;
                $message .= 'Content-Type: ' . $mine_type . '; name="piece-jointe.' . $ext . '"' . $rn;
                $message .= 'Content-Transfer-Encoding: base64' . $rn;
                $message .= 'Content-Disposition: attachment; filename="piece-jointe.' . $ext . '"' . $rn;
                $message .= $attachement . $rn;

                // Fin
                $message .= $rn . '--' . $boundary . '--' . $rn;

                // Envoi de l'email
                $verif_email = @mail($to, $title, $message, $header);
            }
        }
    } else {
        $verif_email = true;
    }

    if ($verif_email) {
        global $num_sendemail, $cle_aleatoire;

        $dossier_sauvegarde = get_dossier_data('email');
        if (! file_exists($dossier_sauvegarde)) {
            mkdir($dossier_sauvegarde);
        }
        $fichier = $dossier_sauvegarde . 'email_' . str_replace(':', '-', get_now()) . ' ' . $num_sendemail . ' ' . $cle_aleatoire . '.html';
        $fichier_html_local = '__email_' . str_replace(':', '-', get_now()) . ' ' . $num_sendemail . ' ' . $cle_aleatoire . '.html';
        $fichier_html = $dossier_sauvegarde . $fichier_html_local;
        $num_sendemail ++;

        $message_html = '<html lang="fr"><head><meta charset="utf-8"><title>' . htmlspecialchars('Message envoyé le ' . format_datetime_fr(get_now()) . ' à ' . $to) . '</title></head><body>';
        $tyle_contenant = ' style="float:none;clear:both"';
        $tyle_label = ' style="float:left; padding: 11px 0;"';
        $tyle_div = ' style="float:right; width: 75%; border: 1px solid #aaa; padding: 10px; margin-bottom: 10px;"';
        $message_html .= '<div' . $tyle_contenant . '><label' . $tyle_label . '>Destinataire :</label><div' . $tyle_div . '>' . htmlspecialchars($to) . '</div></div>';
        $message_html .= '<div' . $tyle_contenant . '><label' . $tyle_label . '>Email d\'envoi :</label><div' . $tyle_div . '>' . htmlspecialchars($from) . '</div></div>';
        $message_html .= '<div' . $tyle_contenant . '><label' . $tyle_label . '>Email de retour :</label><div' . $tyle_div . '>' . htmlspecialchars($replyto) . '</div></div>';
        $message_html .= '<div' . $tyle_contenant . '><label' . $tyle_label . '>Titre :</label><div' . $tyle_div . '>' . htmlspecialchars($title) . '</div></div>';
        $message_html .= '<div' . $tyle_contenant . '><label' . $tyle_label . '>Message :</label><div' . $tyle_div . '><iframe style="width: 100%; height: 600px; border: none;" src="' . $fichier_html_local . '"></iframe></div></div>';
        $message_html .= '<div' . $tyle_contenant . '><label' . $tyle_label . '>Texte :</label><div' . $tyle_div . '><textarea style="width:100%; height:300px; border:none; resize:vertical;">' . $message_txt . '</textarea></div></div>';

        // statistiques longueur de ligne
        $lignes = explode($rn, $content_html);
        $l_max_ligne = 0;
        foreach ($lignes as $string) {
            $l = strlen($string);
            if ($l > $l_max_ligne) {
                $l_max_ligne = $l;
            }
        }
        $message_html .= '<div' . $tyle_contenant . '><label' . $tyle_label . '>Statistiques :</label><div' . $tyle_div . '><textarea style="width:100%; height:300px; border:none; resize:vertical;">';
        $message_html .= 'Longueur de la ligne la plus longue : ' . $l_max_ligne . ' caractères' . $rn;
        $message_html .= 'Nombre de lignes : ' . count($lignes) . $rn;
        $message_html .= '</textarea></div></div>';

        $message_html .= '</body></html>';

        file_put_contents($fichier, $message_html);
        file_put_contents($fichier_html, $content_html);
    }

    return $verif_email;
}

function get_gabarit($filename, $trans)
{
    $adress = __DIR__ . '/../../' . REPERTOIRE_WWW . '/' . NOM_PROJET . '/gabarits/' . $filename;
    if (! file_exists($adress)) {
        file_put_contents($adress, '');
    }
    $trans['{ADRESSE_SITE}'] = ADRESSE_SITE;
    $trans['{ADRESSE_API}'] = ADRESSE_API;
    $trans['{NUMERO_INSTANCE}'] = get_instance();
    return strtr(file_get_contents($adress), $trans);
}

function format_nombre(float $nombre, bool $html = false, int $nb_apres_virgule = 2, bool $no_zero = false)
{
    if ($no_zero && round($nombre, $nb_apres_virgule) == 0) {
        return ($html ? '&nbsp;' : ' ');
    } else {
        return number_format($nombre, $nb_apres_virgule, ',', ($html ? '&nbsp;' : ' '));
    }
}

function format_nombre_euro($nombre, $html = false, $nb_apres_virgule = 2)
{
    return number_format($nombre, $nb_apres_virgule, ',', ($html ? '&nbsp;' : ' ')) . ($html ? '&nbsp;' : ' ') . ($html ? '&euro;' : '€');
}

function format_caractere_csv($txt)
{
    $trans = array(
        chr(92) => ' ',
        "\n" => ' ',
        ';' => ' ',
        '<br>' => ''
    );
    return utf8_decode(strtr($txt, $trans));
}

function text_html($txt)
{
    return strtr(htmlspecialchars($txt), array(
        ' ' => '&nbsp;'
    ));
}

function formatage_MAJUSCULE($txt)
{
    return strtoupper($txt);
}

function formatage_Majmots($txt)
{
    return ucwords($txt);
}

function suppr_accents($str, $encoding = 'utf-8')
{
    $str = htmlentities($str, ENT_NOQUOTES, $encoding);
    $str = preg_replace('#&([A-za-z])(?:acute|grave|cedil|circ|orn|ring|slash|th|tilde|uml);#', '\1', $str);
    $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str);
    $str = preg_replace('#&[^;]+;#', '', $str);
    return $str;
}

function formatage_telephone(string $tel): string
{
    $d = strlen($tel);
    $temp = '';
    for ($i = 0; $i < $d; $i ++) {
        $o = ord($tel[$i]);
        if ($o == 43 || (48 <= $o && $o <= 57)) {
            $temp .= $tel[$i];
        }
    }

    $d = strlen($temp);
    $res = '';
    for ($i = $d - 1; $i >= 0; $i --) {
        $res = $temp[$i] . ($res != '' && ((($d - $i - 1) % 2) == 0) ? ' ' : '') . $res;
    }

    return $res;
}

function mf_string_formatage_variable(string $str): string
{
    $str = suppr_accents($str);
    $d = strlen($str);
    for ($i = 0; $i < $d; $i ++) {
        $o = ord($str[$i]);
        if (! ((48 <= $o && $o <= 57) || (65 <= $o && $o <= 90) || (97 <= $o && $o <= 122))) {
            $str[$i] = '_';
        }
    }
    $d = 0;
    while ($d != strlen($str)) {
        $d = strlen($str);
        $str = str_replace("__", "_", $str);
    }
    return $str;
}

/**
 * @param string $str
 * @return string
 */
function conserver_uniquement_chiffres(string $str): string
{
    $d = strlen($str);
    $temp = '';
    for ($i = 0; $i < $d; $i ++) {
        $o = ord($str[$i]);
        if (48 <= $o && $o <= 57) {
            $temp .= $str[$i];
        }
    }
    return $temp;
}

function Sql_StdDev_Pond(string $X, string $W): string
{
    return "SQRT(ABS(SUM($W*POW($X,2))/SUM($W)-POW(SUM($X*$W)/SUM($W),2)))";
}

function Sql_StdDev_Stat(string $X, string $S, string $N): string
{ // $X : moyenne[i], $S : sigma[i], $N : nb[i]
    return "SQRT(ABS(SUM($N*(POW($S,2)+POW($X,2)))/SUM($N)-POW(SUM($N*$X)/SUM($N),2)))";
}

/**
 * @param string $email
 * @return bool
 */
function test_email_valide(string $email): bool
{
    return strlen($email) < 256 && filter_var($email, FILTER_VALIDATE_EMAIL);
}

function test_mot_de_passe_valide(string $mdp): bool
{
    return preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])#', $mdp) && strlen($mdp) > 7;
}

/**
 * @param string $date_str
 * @param bool $abrege
 * @return string
 */
function format_date_fr_en_lettre_reduit(string $date_str, bool $abrege = false): string
{
    $date_str = format_date($date_str);
    if ($date_str != '') {
        global $lang_standard;
        try {
            $date = new DateTime($date_str);
            if ($abrege) {
                return $lang_standard['liste_jours_2'][$date->format('w')] . ' ' . $date->format('j') . ' ' . $lang_standard['liste_mois_2'][$date->format('n')];
            } else {
                return $lang_standard['liste_jours'][$date->format('w')] . ' ' . $date->format('j') . ' ' . $lang_standard['liste_mois'][$date->format('n')];
            }
        } catch (Exception $e) {
            set_log($e->getTraceAsString());
            return '';
        }
    } else {
        return '';
    }
}

/**
 * @param string $date_str
 * @return string
 */
function format_date_fr_get_libelle_mois(string $date_str): string
{
    $date_str = format_date($date_str);
    if ($date_str != '') {
        global $lang_standard;
        try {
            $date = new DateTime($date_str);
            return $lang_standard['liste_mois'][$date->format('n')] . ' ' . $date->format('Y');
        } catch (Exception $e) {
            set_log($e->getTraceAsString());
            return '';
        }
    } else {
        return '';
    }
}

/**
 * @param string $time
 * @return string
 */
function format_time_fr(string $time): string
{
    return str_replace(':', 'h', substr(format_time($time), 0, 5));
}

function rrmdir($dir) // https://secure.php.net/manual/en/function.rmdir.php
{
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (filetype($dir . "/" . $object) == "dir")
                    rrmdir($dir . "/" . $object);
                else
                    unlink($dir . "/" . $object);
            }
        }
        reset($objects);
        rmdir($dir);
    }
}

function return_bytes($size_str)
{
    switch (substr($size_str, - 1)) {
        case 'M':
        case 'm':
            return (int) $size_str * 1048576;
        case 'K':
        case 'k':
            return (int) $size_str * 1024;
        case 'G':
        case 'g':
            return (int) $size_str * 1073741824;
        default:
            return $size_str;
    }
}

// http://www.php.net/manual/en/function.fopen.php
// "UTF-8", "ASCII", "Windows-1252", "ISO-8859-15", "ISO-8859-1", "ISO-8859-6", "CP1256"
function utf8_fopen_read($fileName, $in_charset = 'Windows-1252')
{
    $fc = iconv($in_charset, 'UTF-8//IGNORE', file_get_contents($fileName));
    $handle = fopen("php://memory", "rw");
    fwrite($handle, $fc);
    fseek($handle, 0);
    return $handle;
}

// Transformer image
/**
 * @param string $nom_fichier_image
 * @param bool $format_png
 * @param int $width
 * @param int $height
 * @param bool $troncage
 * @param int $rotate
 * @param int $zoom
 * @param int $xpos
 * @param int $ypos
 * @param int $qualite
 * @param bool $ecraser_fichier
 * @param int $pourcentage_color
 * @return bool
 */
function transformer_image(string $nom_fichier_image, bool $format_png = false, int $width = IMAGES_LARGEUR_MAXI, int $height = IMAGES_HAUTEUR_MAXI, bool $troncage = false, int $rotate = 0, int $zoom = 100, $xpos = 50, $ypos = 50, int $qualite = 75, $ecraser_fichier = false, $pourcentage_color = 100): bool
{
    $fichier = new Fichier();
    $ext = $fichier->get_extention($nom_fichier_image);
    // adresse de l'image
    $filename = $fichier->get_adresse($nom_fichier_image);
    // chargement de l'image
    switch ($ext) {
        case 'png':
            $image = imagecreatefrompng($filename);
            imageAlphaBlending($image, true);
            imageSaveAlpha($image, true);
            break;
        case 'jpeg':
        case 'jpg':
            $image = imagecreatefromjpeg($filename);
            break;
        default:
            return false;
            break;
    }
    // dimentions de l'image
    if ($width < 1) {
        $width = 1;
    }
    if ($height < 1) {
        $height = 1;
    }
    if ($width > IMAGES_LARGEUR_MAXI) {
        $width = IMAGES_LARGEUR_MAXI;
    }
    if ($height > IMAGES_HAUTEUR_MAXI) {
        $height = IMAGES_HAUTEUR_MAXI;
    }
    // Rotation éventuelle
    if ($rotate != 0) {
        $old_width = imagesx($image);
        $old_height = imagesy($image);
        $image_p = imagecreatetruecolor($old_width, $old_height);
        imageAlphaBlending($image_p, false);
        imageSaveAlpha($image_p, true);
        $transparent = imagecolorallocatealpha($image_p, 255, 255, 255, 127);
        $image = imagerotate($image, $rotate, $transparent);
        imagedestroy($image_p);
    }
    // dimentions actuelles
    $old_width = imagesx($image);
    $old_height = imagesy($image);
    // en noir et blanc
    if ($pourcentage_color >= 0 && $pourcentage_color < 100) {
        imagecopymergegray($image, $image, 0, 0, 0, 0, $old_width, $old_height, $pourcentage_color);
    }
    // choix du zoom
    if ($troncage) {
        if ($width / $old_width > $height / $old_height) {
            $r = $width / $old_width;
        } else {
            $r = $height / $old_height;
        }
    } else {
        if ($width / $old_width < $height / $old_height) {
            $r = $width / $old_width;
        } else {
            $r = $height / $old_height;
        }
    }
    //
    $dst_x = 0;
    $dst_y = 0;
    $src_x = 0;
    $src_y = 0;
    if ($troncage) {
        // troncage
        if ($width / $old_width < $height / $old_height) {
            $largeur_origine_calcule = (int) round($width / $r);
            $distance_a_tronquer = $old_width - $largeur_origine_calcule;
            $src_x = (int) round($distance_a_tronquer / 2);
            $old_width = $largeur_origine_calcule;
        } elseif ($width / $old_width > $height / $old_height) {
            $hauteur_origine_calcule = (int) round($height / $r);
            $distance_a_tronquer = $old_height - $hauteur_origine_calcule;
            $src_y = (int) round($distance_a_tronquer / 2);
            $old_height = $hauteur_origine_calcule;
        }
    } else {
        // redimentionnement (sans troncage)
        $width = (int) round($old_width * $r);
        $height = (int) round($old_height * $r);
    }
    // Zoom
    if ($zoom < 100) {
        $zoom = 100;
    }
    if ($zoom > 1000) {
        $zoom = 1000;
    }
    $coef_zoom = 100 / $zoom;
    $old_width_2 = (int) round($old_width * $coef_zoom);
    $old_height_2 = (int) round($old_height * $coef_zoom);
    $src_x = (int) round($src_x + ($old_width - $old_width_2) / 2);
    $src_y = (int) round($src_y + ($old_height - $old_height_2) / 2);
    // déplacement du cadre
    if ($xpos < 0) {
        $xpos = 0;
    }
    if ($xpos > 100) {
        $xpos = 100;
    }
    if ($ypos < 0) {
        $ypos = 0;
    }
    if ($ypos > 100) {
        $ypos = 100;
    }
    $src_x = (int) round($src_x * $xpos / 50);
    $src_y = (int) round($src_y * $ypos / 50);
    // redimentionnement
    $image_p = imagecreatetruecolor($width, $height);
    if ($format_png) {
        // affichage en png
        imageAlphaBlending($image_p, false);
        imageSaveAlpha($image_p, true);
        $transparent = imagecolorallocatealpha($image_p, 255, 255, 255, 127);
        imagefilledrectangle($image_p, 0, 0, $width, $height, $transparent);
        imagecopyresampled($image_p, $image, $dst_x, $dst_y, $src_x, $src_y, $width, $height, $old_width_2, $old_height_2);
        if ($ecraser_fichier) {
            imagepng($image_p, $filename);
        } else {
            imagepng($image_p);
        }
    } else {
        // affichage en jpeg quelque soit le fichier d'origine
        imagecopyresampled($image_p, $image, $dst_x, $dst_y, $src_x, $src_y, $width, $height, $old_width_2, $old_height_2);
        if ($ecraser_fichier) {
            imagejpeg($image_p, $filename);
        } else {
            imagejpeg($image_p);
        }
    }
    imagedestroy($image_p);
    imagedestroy($image);
    return true;
}

// Paramétrage de l'appel du worker
$mf_worker_get_adress_run = null;

function mf_worker_get_adress_run()
{
    global $mf_worker_get_adress_run;
    if ($mf_worker_get_adress_run === null) {
        $mf_worker_adress_cache = __DIR__ . '/cache_worker/';
        if (! file_exists($mf_worker_adress_cache)) {
            @mkdir($mf_worker_adress_cache);
        }
        if (TABLE_INSTANCE != '') {
            $mf_worker_adress_cache .= 'inst_' . get_instance() . '/';
            if (! file_exists($mf_worker_adress_cache)) {
                @mkdir($mf_worker_adress_cache);
            }
        }
        $mf_worker_get_adress_run = $mf_worker_adress_cache . 'execution_en_cours';
    }
    return $mf_worker_get_adress_run;
}

function mf_worker_run(): string
{
    global $mf_nb_requetes, $mf_nb_requetes_update;
    $log = '-';
    global $mf_get_HTTP_HOST;
    $link = connexion_db_cache();
    $now = microtime(true);
    $limit = $now - DELAI_EXECUTION_WORKER;
    $res_requete = mysqli_query($link, 'SELECT * FROM ' . str_replace('-', '_', strtolower(NOM_PROJET . "_$mf_get_HTTP_HOST")) . '_worker WHERE id = ' . get_instance() . " AND microtime_exe<$limit;");
    while ($row_requete = mysqli_fetch_array($res_requete, MYSQLI_ASSOC)) {
        $id = $row_requete['id'];
        $i = $row_requete['cpt'] + 1;
        mysqli_query($link, 'UPDATE ' . str_replace('-', '_', strtolower(NOM_PROJET . "_$mf_get_HTTP_HOST")) . "_worker SET microtime_exe=$now, cpt=$i WHERE id=$id AND microtime_exe<$limit;");
        if (mysqli_affected_rows($link) == 1) {
            $time_start = microtime(true);
            Hook_mf_systeme::worker($i);
            $time_end = microtime(true);
            $execution_time = round($time_end - $time_start, 3);
            $adresse_fichier_log = get_dossier_data('log_worker') . 'log_' . NOM_PROJET . '_' . substr(get_now(), 0, 10) . '.txt';
            $log = "Worker n°$i at " . get_now() . " in {$execution_time}s ($mf_nb_requetes requête(s), $mf_nb_requetes_update modification(s), " . Mf_Cachedb::$nb_lectures_disque . " lecture(s) disque)" . PHP_EOL;
            mf_file_append($adresse_fichier_log, $log);
        }
    }
    mysqli_free_result($res_requete);
    mysqli_close($link);
    return $log;
}

$mf_worker_get_adress_lock = null;

function mf_worker_get_adress_lock(): string
{
    global $mf_worker_get_adress_lock;
    if ($mf_worker_get_adress_lock === null) {
        $mf_worker_get_adress_lock = __DIR__ . '/cache_lock/';
        if (! file_exists($mf_worker_get_adress_lock)) {
            @mkdir($mf_worker_get_adress_lock);
        }
        if (TABLE_INSTANCE != '') {
            $mf_worker_get_adress_lock .= 'inst_' . get_instance() . '/';
            if (! file_exists($mf_worker_get_adress_lock)) {
                @mkdir($mf_worker_get_adress_lock);
            }
        }
    }
    return $mf_worker_get_adress_lock;
}

function mf_get_value_session(string $name, $undifundefined_value = null)
{
    $cache = new Cache('mf_session', session_id());
    return $cache->read($name, $undifundefined_value);
}

function mf_set_value_session($name, $value)
{
    $cache = new Cache('mf_session', session_id());
    $cache->write($name, $value);
}

function mf_get_trace_session()
{
    $liste_sessions = mf_get_list_session_values();
    $trace = '';
    foreach ($liste_sessions as &$value) {
        $trace .= "-$value";
    }
    return md5($trace);
}

function mf_get_list_session_values()
{
    $cache = new Cache('mf_session', session_id());
    return $cache->read_all();
}

function mf_formatage_db_type_php(array &$donnees): void
{
    global $mf_dictionnaire_db;
    foreach ($donnees as $colonne => &$value) {
        if (isset($mf_dictionnaire_db[$colonne])) {
            switch ($mf_dictionnaire_db[$colonne]['type']) {
                case 'BOOL':
                    $value = (bool) $value;
                    break;
                case 'INT':
                case 'BIGINT':
                case 'INTEGER':
                    if (is_null($value)) {
                        $value = null;
                    } else {
                        $value = (int) $value;
                    }
                    break;
                case 'DOUBLE':
                case 'FLOAT':
                    if (is_null($value)) {
                        $value = null;
                    } else {
                        $value = (float)$value;
                    }
                    break;
                default:
                    $value = (string) $value;
                    break;
            }
        }
    }
}

function get_nom_page_courante()
{
    global $mf_get_nom_page_courante;
    if (! isset($mf_get_nom_page_courante)) {
        $php_self = str_replace("\\", "/", $_SERVER['PHP_SELF']);
        $mf_get_nom_page_courante = substr($php_self, strlen($php_self) - stripos(strrev($php_self), '/'));
    }
    return $mf_get_nom_page_courante;
}

function appli_mobile()
{
    return (stripos(' ' . $_SERVER['HTTP_USER_AGENT'], 'mobile') && ! stripos(' ' . $_SERVER['HTTP_USER_AGENT'], 'iPad'));
}

function test_action_formulaire()
{
    return isset($_GET['secur']);
//    return (isset($mf_action) && (substr($mf_action, 0, 7) == 'ajouter' || substr($mf_action, 0, 8) == 'modifier' || substr($mf_action, 0, 9) == 'supprimer' || $mf_action == 'modpwd'));
}

/**
 * Conservation d'un nombre de chiffres significatifs données
 * @param float $value
 * @param int $digits
 * @return float
 */
function mf_significantDigit(float $value, int $digits): float
{
    if ($value == 0) {
        $decimalPlaces = $digits - 1;
    } else {
        $decimalPlaces = $digits - floor(log10(abs($value))) - 1;
    }
    return round($value, (int) $decimalPlaces);
}

/**
 * Nombre de chiffres composants la partie entière
 * @param float $value
 * @return int
 */
function mf_get_nb_digits_floor(float $value): int
{
    if ($value == 0) {
        return 0;
    } else {
        $nb = (int) floor(log10(abs($value))) + 1;
        return ($nb > 0 ? $nb : 0);
    }
}

/**
 * Permet de retrouver la TVA à partir d'un prix TTC
 * @param float $prix_ttc
 * @param float $taux
 * @return float
 */
function mf_extraire_tva(float $prix_ttc, float $taux): float
{
    $prix_ht = round($prix_ttc / (1 + $taux), 2);
    return $prix_ttc - $prix_ht;
}

function mf_liste_colonnes_titre(string $table): array
{
    global $mf_dictionnaire_db, $mf_titre_ligne_table;
    $liste_colonnes = [];
    foreach ($mf_dictionnaire_db as $key => &$mf_colonne) {
        if ($mf_colonne['src'] == 'db' && stripos($mf_titre_ligne_table[$table], "{{$key}}") !== false) {
            $liste_colonnes[] = $key;
        }
    }
    unset($mf_colonne);
    return $liste_colonnes;
}

/*
 * Permet d'avoir le message correspondant au http_response_code
 */
function mf_message_http_response_code(string $code): string
{
    switch ($code) {
        case 100:
            $text = 'Continue';
            break;
        case 101:
            $text = 'Switching Protocols';
            break;
        case 200:
            $text = 'OK';
            break;
        case 201:
            $text = 'Created';
            break;
        case 202:
            $text = 'Accepted';
            break;
        case 203:
            $text = 'Non-Authoritative Information';
            break;
        case 204:
            $text = 'No Content';
            break;
        case 205:
            $text = 'Reset Content';
            break;
        case 206:
            $text = 'Partial Content';
            break;
        case 300:
            $text = 'Multiple Choices';
            break;
        case 301:
            $text = 'Moved Permanently';
            break;
        case 302:
            $text = 'Moved Temporarily';
            break;
        case 303:
            $text = 'See Other';
            break;
        case 304:
            $text = 'Not Modified';
            break;
        case 305:
            $text = 'Use Proxy';
            break;
        case 400:
            $text = 'Bad Request';
            break;
        case 401:
            $text = 'Unauthorized';
            break;
        case 402:
            $text = 'Payment Required';
            break;
        case 403:
            $text = 'Forbidden';
            break;
        case 404:
            $text = 'Not Found';
            break;
        case 405:
            $text = 'Method Not Allowed';
            break;
        case 406:
            $text = 'Not Acceptable';
            break;
        case 407:
            $text = 'Proxy Authentication Required';
            break;
        case 408:
            $text = 'Request Time-out';
            break;
        case 409:
            $text = 'Conflict';
            break;
        case 410:
            $text = 'Gone';
            break;
        case 411:
            $text = 'Length Required';
            break;
        case 412:
            $text = 'Precondition Failed';
            break;
        case 413:
            $text = 'Request Entity Too Large';
            break;
        case 414:
            $text = 'Request-URI Too Large';
            break;
        case 415:
            $text = 'Unsupported Media Type';
            break;
        case 500:
            $text = 'Internal Server Error';
            break;
        case 501:
            $text = 'Not Implemented';
            break;
        case 502:
            $text = 'Bad Gateway';
            break;
        case 503:
            $text = 'Service Unavailable';
            break;
        case 504:
            $text = 'Gateway Time-out';
            break;
        case 505:
            $text = 'HTTP Version not supported';
            break;
        default:
            $text = 'Unknown http status code "' . htmlentities($code) . '"';
            break;
    }
    return $text;
}

/* Colonnes de la base de données */

// UTILISATEUR
define('MF_UTILISATEUR__ID', 'Code_utilisateur');
define('MF_UTILISATEUR_IDENTIFIANT', 'utilisateur_Identifiant');
define('MF_UTILISATEUR_PASSWORD', 'utilisateur_Password');
define('MF_UTILISATEUR_EMAIL', 'utilisateur_Email');
define('MF_UTILISATEUR_CIVILITE_TYPE', 'utilisateur_Civilite_Type');
define('MF_UTILISATEUR_PRENOM', 'utilisateur_Prenom');
define('MF_UTILISATEUR_NOM', 'utilisateur_Nom');
define('MF_UTILISATEUR_ADRESSE_1', 'utilisateur_Adresse_1');
define('MF_UTILISATEUR_ADRESSE_2', 'utilisateur_Adresse_2');
define('MF_UTILISATEUR_VILLE', 'utilisateur_Ville');
define('MF_UTILISATEUR_CODE_POSTAL', 'utilisateur_Code_postal');
define('MF_UTILISATEUR_DATE_NAISSANCE', 'utilisateur_Date_naissance');
define('MF_UTILISATEUR_ACCEPTE_MAIL_PUBLICITAIRE', 'utilisateur_Accepte_mail_publicitaire');
define('MF_UTILISATEUR_ADMINISTRATEUR', 'utilisateur_Administrateur');
define('MF_UTILISATEUR_FOURNISSEUR', 'utilisateur_Fournisseur');

// ARTICLE
define('MF_ARTICLE__ID', 'Code_article');
define('MF_ARTICLE_LIBELLE', 'article_Libelle');
define('MF_ARTICLE_DESCRIPTION', 'article_Description');
define('MF_ARTICLE_SAISON_TYPE', 'article_Saison_Type');
define('MF_ARTICLE_NOM_FOURNISSEUR', 'article_Nom_fournisseur');
define('MF_ARTICLE_URL', 'article_Url');
define('MF_ARTICLE_REFERENCE', 'article_Reference');
define('MF_ARTICLE_COULEUR', 'article_Couleur');
define('MF_ARTICLE_CODE_COULEUR_SVG', 'article_Code_couleur_svg');
define('MF_ARTICLE_TAILLE_PAYS_TYPE', 'article_Taille_Pays_Type');
define('MF_ARTICLE_TAILLE', 'article_Taille');
define('MF_ARTICLE_MATIERE', 'article_Matiere');
define('MF_ARTICLE_PHOTO_FICHIER', 'article_Photo_Fichier');
define('MF_ARTICLE_PRIX', 'article_Prix');
define('MF_ARTICLE_ACTIF', 'article_Actif');
define('MF_ARTICLE_CODE_SOUS_CATEGORIE_ARTICLE', 'Code_sous_categorie_article');

// COMMANDE
define('MF_COMMANDE__ID', 'Code_commande');
define('MF_COMMANDE_PRIX_TOTAL', 'commande_Prix_total');
define('MF_COMMANDE_DATE_LIVRAISON', 'commande_Date_livraison');
define('MF_COMMANDE_DATE_CREATION', 'commande_Date_creation');
define('MF_COMMANDE_CODE_UTILISATEUR', 'Code_utilisateur');

// CATEGORIE_ARTICLE
define('MF_CATEGORIE_ARTICLE__ID', 'Code_categorie_article');
define('MF_CATEGORIE_ARTICLE_LIBELLE', 'categorie_article_Libelle');

// PARAMETRE
define('MF_PARAMETRE__ID', 'Code_parametre');
define('MF_PARAMETRE_LIBELLE', 'parametre_Libelle');

// VUE_UTILISATEUR
define('MF_VUE_UTILISATEUR__ID', 'Code_vue_utilisateur');
define('MF_VUE_UTILISATEUR_RECHERCHE', 'vue_utilisateur_Recherche');
define('MF_VUE_UTILISATEUR_FILTRE_SAISON_TYPE', 'vue_utilisateur_Filtre_Saison_Type');
define('MF_VUE_UTILISATEUR_FILTRE_COULEUR', 'vue_utilisateur_Filtre_Couleur');
define('MF_VUE_UTILISATEUR_FILTRE_TAILLE_PAYS_TYPE', 'vue_utilisateur_Filtre_Taille_Pays_Type');
define('MF_VUE_UTILISATEUR_FILTRE_TAILLE_MAX', 'vue_utilisateur_Filtre_Taille_Max');
define('MF_VUE_UTILISATEUR_FILTRE_TAILLE_MIN', 'vue_utilisateur_Filtre_Taille_Min');

// SOUS_CATEGORIE_ARTICLE
define('MF_SOUS_CATEGORIE_ARTICLE__ID', 'Code_sous_categorie_article');
define('MF_SOUS_CATEGORIE_ARTICLE_LIBELLE', 'sous_categorie_article_Libelle');
define('MF_SOUS_CATEGORIE_ARTICLE_CODE_CATEGORIE_ARTICLE', 'Code_categorie_article');

// CONSEIL
define('MF_CONSEIL__ID', 'Code_conseil');
define('MF_CONSEIL_LIBELLE', 'conseil_Libelle');
define('MF_CONSEIL_DESCRIPTION', 'conseil_Description');
define('MF_CONSEIL_ACTIF', 'conseil_Actif');

// A_COMMANDE_ARTICLE
define('MF_A_COMMANDE_ARTICLE_CODE_COMMANDE', 'Code_commande');
define('MF_A_COMMANDE_ARTICLE_CODE_ARTICLE', 'Code_article');
define('MF_A_COMMANDE_ARTICLE_QUANTITE', 'a_commande_article_Quantite');
define('MF_A_COMMANDE_ARTICLE_PRIX_LIGNE', 'a_commande_article_Prix_ligne');

// A_PARAMETRE_UTILISATEUR
define('MF_A_PARAMETRE_UTILISATEUR_CODE_UTILISATEUR', 'Code_utilisateur');
define('MF_A_PARAMETRE_UTILISATEUR_CODE_PARAMETRE', 'Code_parametre');
define('MF_A_PARAMETRE_UTILISATEUR_VALEUR', 'a_parametre_utilisateur_Valeur');
define('MF_A_PARAMETRE_UTILISATEUR_ACTIF', 'a_parametre_utilisateur_Actif');

// A_FILTRER
define('MF_A_FILTRER_CODE_UTILISATEUR', 'Code_utilisateur');
define('MF_A_FILTRER_CODE_VUE_UTILISATEUR', 'Code_vue_utilisateur');

include __DIR__ . '/fonctions_additionnelles.php';

function get_liste_dump()
{
    return inst('utilisateur') . ' ' . inst('article') . ' ' . inst('commande') . ' ' . inst('categorie_article') . ' ' . inst('parametre') . ' ' . inst('vue_utilisateur') . ' ' . inst('sous_categorie_article') . ' ' . inst('conseil') . ' ' . inst('a_commande_article') . ' ' . inst('a_parametre_utilisateur') . ' ' . inst('a_filtrer');
}

generer_la_base();

Hook_mf_systeme::initialisation();
