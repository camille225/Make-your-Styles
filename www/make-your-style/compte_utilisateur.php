<?php

include __DIR__ . '/../../systeme/make-your-style/espace_privee.php';

if ( !$cache->start() )
{

    /* Chargement des tables */
        $table_utilisateur = new utilisateur();

    require __DIR__ . '/scripts/lecture_parametres.php';

    /* Chargement des actions */
        include __DIR__ . '/code/_utilisateur_actions.php';

    require __DIR__ . '/scripts/genealogie.php';

    ob_start(); include __DIR__ . '/scripts/css.php'; $css = ob_get_clean();
    ob_start(); include __DIR__ . '/scripts/js.php'; $js = ob_get_clean();
    ob_start(); include __DIR__ . '/scripts/menu.php'; $menu = ob_get_clean();

    $mess = ( (isset($retour) && $retour['code_erreur']>0) ? (isset($mf_libelle_erreur[$retour['code_erreur']]) ? $mf_libelle_erreur[$retour['code_erreur']] : 'ERREUR N_'.$retour['code_erreur'] ) : '' );
    
    $code_html = '';
    /* Chargement des forms */
    $Code_utilisateur = $_GET['Code_utilisateur'];
    $utilisateur = $table_utilisateur -> mf_get($Code_utilisateur);
        include __DIR__ . '/code/_utilisateur_get.php';

    /* utilisateur_Email */
        if ( $mf_droits_defaut['api_modifier__utilisateur_Email'] )
            $trans['{utilisateur_Email}'] = ajouter_champ_modifiable_interface([ 'liste_valeurs_cle_table' => array('Code_utilisateur' => $utilisateur['Code_utilisateur']) , 'DB_name' => 'utilisateur_Email' , 'valeur_initiale' => $utilisateur['utilisateur_Email'] , 'class' => 'infos', 'titre' => false , 'attributs' => [ 'placeholder' => 'Email' ] ]);
        /* PASSWOOOOOOOOOOOORD */
        $trans['{utilisateur_Password}'] = get_valeur_html_maj_auto_interface([ 'liste_valeurs_cle_table' => array('Code_utilisateur' => $utilisateur['Code_utilisateur']) , 'DB_name' => 'utilisateur_Password' , 'valeur_initiale' => $trans['{bouton_modpwd_utilisateur}'] , 'class' => 'html' , 'maj_auto' => false ]);


    $menu_a_droite->ajouter_bouton_deconnexion();
    
    echo recuperer_gabarit('compte/page_compte_utilisateur.php', $trans, true);
    
    // echo recuperer_gabarit('compte/page_compte_utilisateur.php', array(
    //     '{titre_page}' => 'Accueil',
    //     '{css}' => $css,
    //     '{js}' => $js,
    //     '{menu_principal}' => $menu,
    //     '{menu_option}' => menu_option_user(),
    //     '{fil_ariane}' => $fil_ariane->generer_code_template(),
    //     '{sections}' => $code_html,
    //     '{menu_secondaire}' => $menu_a_droite->generer_code(),
    //     '{script_end}' => generer_script_maj_auto(),
    //     '{header}' => recuperer_gabarit('main/header.html',array()),
    //     '{footer}' => recuperer_gabarit('main/footer.html',array()),
    //     '{logo}' => '<p class="text-white mb-0" style="width: 230px;"><img src="images/logo.png" style="max-width: 250px; max-height: 50px;"> CRM Montessori 21</p>',
    // ), true);
    
    $cache->end();

}

fermeture_connexion_db();
