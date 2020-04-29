<?php declare(strict_types=1);

include __DIR__ . '/../../systeme/make-your-style/espace_privee.php';

if (! $cache->start()) {

    require __DIR__ . '/scripts/lecture_parametres.php';

    /* Chargement des actions */
    include __DIR__ . '/code/_utilisateur_actions.php';

    require __DIR__ . '/scripts/genealogie.php';

    ob_start(); include __DIR__ . '/scripts/css.php'; $css = ob_get_clean();
    ob_start(); include __DIR__ . '/scripts/js.php'; $js = ob_get_clean();
    ob_start(); include __DIR__ . '/scripts/menu.php'; $menu = ob_get_clean();

    $mess = ((isset($retour) && $retour['code_erreur']>0) ? (isset($mf_libelle_erreur[$retour['code_erreur']]) ? $mf_libelle_erreur[$retour['code_erreur']] : 'ERREUR N_'.$retour['code_erreur'] ) : '');

    $code_html = '';

    $Code_utilisateur = get_utilisateur_courant(MF_UTILISATEUR__ID);
    $utilisateur = $db -> utilisateur() -> mf_get($Code_utilisateur);

    /* Chargement des forms */
    include __DIR__ . '/code/_utilisateur_get.php';

    $menu_a_droite->ajouter_bouton_deconnexion();

    echo recuperer_gabarit('compte/page_compte_utilisateur.html', $trans, true);

    $cache->end();

}

fermeture_connexion_db();
