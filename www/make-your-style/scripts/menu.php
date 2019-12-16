<?php

$pages_menu=array();

$rubrique_param = '<i class="align-middle mr-2 fas fa-fw fa-cogs"></i> Paramétrage';
$pages_menu['Mon menu'][]=array( 'adresse' => 'utilisateur.php', 'nom' => 'utilisateur' , 'icone' => 'fa fa-users fa-fw' );
$pages_menu['Mon menu'][]=array( 'adresse' => 'article.php', 'nom' => 'article' , 'icone' => 'fa fa-users fa-fw' );
$pages_menu['Mon menu'][]=array( 'adresse' => 'commande.php', 'nom' => 'commande' , 'icone' => 'fa fa-users fa-fw' );
$pages_menu['Mon menu'][]=array( 'adresse' => 'type_produit.php', 'nom' => 'type_produit' , 'icone' => 'fa fa-users fa-fw' );
$pages_menu['Mon menu'][]=array( 'adresse' => 'parametre.php', 'nom' => 'parametre' , 'icone' => 'fa fa-cogs fa-fw' );
$pages_menu['Mon menu'][]=array( 'adresse' => 'filtre.php', 'nom' => 'filtre' , 'icone' => 'fa fa-users fa-fw' );
$pages_menu['Mon menu'][]=array( 'adresse' => 'a_article_commande.php', 'nom' => 'a_article_commande' , 'icone' => 'fa fa-users fa-fw' );
$pages_menu['Mon menu'][]=array( 'adresse' => 'a_filtre_produit.php', 'nom' => 'a_filtre_produit' , 'icone' => 'fa fa-users fa-fw' );
$pages_menu['Mon menu'][]=array( 'adresse' => 'a_parametre_utilisateur.php', 'nom' => 'a_parametre_utilisateur' , 'icone' => 'fa fa-users fa-fw' );

// menu  spécial pour SB Admin 2
function generer_menu_principal_bootstrap()
{
    global $pages_menu, $fil_ariane;
    $nom_user = get_utilisateur_courant(MF_UTILISATEUR_IDENTIFIANT);
    $code_menu = '<div class="sidebar-user">';
    $code_menu .= '
                <div class="font-weight-bold">'.$nom_user.'</div>';
    if (get_utilisateur_courant(MF_UTILISATEUR_ADMINISTRATEUR) == 1) {
        $code_menu .= '
                <small>Administrateur</small>';
    }
    $code_menu .= '
            </div>
            <ul class="sidebar-nav">';
    $ctr_rubrique = 0;
    foreach ( $pages_menu as $rubrique => $liste )
    {
        if ( count($liste)>1 )
        {
            $ctr_rubrique++;
            $active = false;
            foreach ( $liste as $value )
            {
                if (get_nom_page_courante()==$value['adresse'])
                {
                    $active = true;
                }
            }
            $code_menu.= '
            <li class="sidebar-item'.( $active ? ' active' : '' ).'">
                <a href="#rubrique_'.$ctr_rubrique.'" data-toggle="collapse" class="sidebar-link collapsed">
                    '.$rubrique.'
                </a>
                <ul id="rubrique_'.$ctr_rubrique.'" class="sidebar-dropdown list-unstyled collapse" data-parent="#sidebar">';
        }
        foreach ( $liste as $value )
        {
            $code_menu.= '
                    <li class="sidebar-item'.(get_nom_page_courante()==$value['adresse'] ? ' active' : '').'">
                        <a class="sidebar-link" href="'.$value['adresse'].'">';
            if ($value['icone'] != '') {
                $code_menu.= '<i class="'.htmlspecialchars($value['icone']).'" aria-hidden="true"></i> <span class="align-middle">'.$value['nom'].'</span>';
            } else {
                $code_menu.= $value['nom'];
            }
            $code_menu.= '</a>
                    </li>';
            if ( get_nom_page_courante()==$value['adresse'] )
            {
                $fil_ariane->ajouter_titre( $value['nom'], $value['adresse'] );
            }
        }
        if ( count($liste)>1 )
        {
            $code_menu.= '
                </ul>
            </li>';
        }
    }
    $code_menu.= '</ul>';

    return $code_menu;
}

echo generer_menu_principal_bootstrap();
