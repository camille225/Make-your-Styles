<?php
include __DIR__ . '/dblayer.php';

$mf_connexion = new Mf_Connexion();
$menu_a_droite = new Menu_a_droite();
$fil_ariane = new Fil_Ariane("Accueil", "");
$trans = array();

if (isset($_GET['act'])) {
    $mf_action = $_GET['act'];
} else {
    $mf_action = '';
}

/*
 * +-------------+
 * | deconnexion |
 * +-------------+
 */

if ($mf_action == 'deconnexion') {
    $mf_connexion = new Mf_Connexion();
    if (isset($_SESSION[PREFIXE_SESSION]['token'])) {
        $token = $_SESSION[PREFIXE_SESSION]['token'];
        $mf_connexion->deconnexion($token);
    }
}

/*
 * +-----------------+
 * | test si connect |
 * +-----------------+
 */

if (isset($_SESSION[PREFIXE_SESSION]['token'])) {
    $mf_connexion = new Mf_Connexion();
    if (! $mf_connexion->est_connecte($_SESSION[PREFIXE_SESSION]['token'])) {
        unset($_SESSION[PREFIXE_SESSION]['token']);
    }
}

session_write_close();

$cache = new Cachehtml((isset($utilisateur_courant['Code_utilisateur']) ? $utilisateur_courant['Code_utilisateur'] : 0) . '-' . mf_get_trace_session());
$cache->activer_compression_html();

$menu_a_droite->set_texte_bouton_deconnexion(htmlspecialchars(get_titre_ligne_table('utilisateur', $utilisateur_courant)) . ', <i>déconnexion</i>');
