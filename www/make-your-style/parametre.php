<?php

include __DIR__ . '/../../systeme/make-your-style/espace_privee.php';

if ( !$cache->start() )
{

    /* Chargement des tables */
        $table_parametre = new parametre();

    require __DIR__ . '/scripts/lecture_parametres.php';

    /* Chargement des actions */
        include __DIR__ . '/code/_parametre_actions.php';

    require __DIR__ . '/scripts/genealogie.php';

    ob_start(); include __DIR__ . '/scripts/css.php'; $css = ob_get_clean();
    ob_start(); include __DIR__ . '/scripts/js.php'; $js = ob_get_clean();
    ob_start(); include __DIR__ . '/scripts/menu.php'; $menu = ob_get_clean();

    $mess = ( (isset($retour) && $retour['code_erreur']>0) ? (isset($mf_libelle_erreur[$retour['code_erreur']]) ? $mf_libelle_erreur[$retour['code_erreur']] : 'ERREUR N_'.$retour['code_erreur'] ) : '' );

    $code_html = '';
    /* Chargement des forms */
        include __DIR__ . '/code/_parametre_form.php';

    $menu_a_droite->ajouter_bouton_deconnexion();

    echo recuperer_gabarit('main/page.html', array(
        '{titre_page}' => 'parametre',
        '{css}' => $css,
        '{js}' => $js,
        '{menu_principal}' => $menu,
        '{menu_option}' => menu_option_user(),
        '{fil_ariane}' => $fil_ariane->generer_code_template(),
        '{sections}' => $code_html,
        '{menu_secondaire}' => $menu_a_droite->generer_code(),
        '{script_end}' => generer_script_maj_auto(),
        '{header}' => recuperer_gabarit('main/header.html',array()),
        '{footer}' => recuperer_gabarit('main/footer.html',array()),
        '{logo}' => '<p class="text-white mb-0" style="width: 230px;"><img src="images/logo.png" style="max-width: 250px; max-height: 50px;"> CRM Montessori 21</p>',
    ), true);

    $cache->end();

}

fermeture_connexion_db();
