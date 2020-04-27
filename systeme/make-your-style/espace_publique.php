<?php declare(strict_types=1);

include __DIR__ . '/dblayer.php';

/** @var string $mf_action */

/*
 * +-------------+
 * | deconnexion |
 * +-------------+
 */

if ($mf_action == 'deconnexion') {
    $mf_connexion = new Mf_Connexion();
    if (isset($_SESSION[NOM_PROJET]['token'])) {
        $token = $_SESSION[NOM_PROJET]['token'];
        $mf_connexion->deconnexion($token);
    }
}

/*
 * +-----------------+
 * | test si connect |
 * +-----------------+
 */

if (isset($_SESSION[NOM_PROJET]['token'])) {
    $mf_connexion = new Mf_Connexion();
    if (! $mf_connexion->est_connecte($_SESSION[NOM_PROJET]['token'])) {
        unset($_SESSION[NOM_PROJET]['token']);
    }
}

session_write_close();

if (! Hook_mf_systeme::controle_acces_controller(get_nom_page_courante())) {
    http_response_code(403);
    echo recuperer_gabarit('main/page_Forbidden.html', [
        '{footer}' => recuperer_gabarit('main/footer.html', [])
    ], true);
    fermeture_connexion_db();
    exit();
}

$cache = new Cachehtml((isset($utilisateur_courant['Code_utilisateur']) ? $utilisateur_courant['Code_utilisateur'] : 0) . '-' . mf_get_trace_session());
$cache->activer_compression_html();

$menu_a_droite->set_texte_bouton_deconnexion(htmlspecialchars(get_titre_ligne_table('utilisateur', $utilisateur_courant)) . ', <i>déconnexion</i>');
