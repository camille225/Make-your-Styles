<?php

include __DIR__ . '/../../systeme/make-your-style/espace_privee.php';

if ( !$cache->start() )
{

    /* Chargement des tables */
        $table_article = new article();

    require __DIR__ . '/scripts/lecture_parametres.php';

    /* Chargement des actions */
        include __DIR__ . '/code/_article_actions.php';

    require __DIR__ . '/scripts/genealogie.php';

    ob_start(); include __DIR__ . '/scripts/css.php'; $css = ob_get_clean();
    ob_start(); include __DIR__ . '/scripts/js.php'; $js = ob_get_clean();
    ob_start(); include __DIR__ . '/scripts/menu.php'; $menu = ob_get_clean();

    $mess = ( (isset($retour) && $retour['code_erreur']>0) ? (isset($mf_libelle_erreur[$retour['code_erreur']]) ? $mf_libelle_erreur[$retour['code_erreur']] : 'ERREUR N_'.$retour['code_erreur'] ) : '' );

    $code_html = '';
    /* Chargement des forms */
        include __DIR__ . '/code/_article_form.php';

    $menu_a_droite->ajouter_bouton_deconnexion();
    
    $msg = '';
if(isset($_POST["envoie"])){
                    
                
                
                $header= "MIME-Version: 1.0\r\n";
                $header.='from:$_POST["email"]';
                $header.='Content-Type:text/html; charset="utf8"'."\n";
                $header.='Content-Transfer-Encoding: 8bit';
    
//$r = sendemail("makeyourstyleee@gmail.com", $_POST["motif"], $_POST["message"]);
    
//    var_dump($r);
                
                $r=mail("makeyourstyleee@gmail.com",$_POST["motif"], $_POST["message"]);
    var_dump($r);
                    
                echo "votre message avec le support make your style a été envoyé et sera traité dans les plus brefs délais"
                ;

}

    echo recuperer_gabarit('lewis_contact_utilisateur/contactutilsateur.php', array(
        '{titre_page}' => 'article',
        '{msg-retour}' => $msg,
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
