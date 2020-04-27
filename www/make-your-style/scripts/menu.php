<?php declare(strict_types=1);
$pages_menu = [];

$pages_menu['<span class="fa fa-users"></span> Utilisateurs'][] = [
    'nom' => 'Utilisateurs',
    'icone' => 'fa fa-users',
    'adresse' => 'utilisateur.php'
];
$pages_menu['<span class="fa fa-box"></span> Catégories d\'articles'][] = [
    'nom' => 'Catégories d\'articles',
    'icone' => 'fa fa-box',
    'adresse' => 'categorie_article.php'
];
$categorie_menu = '<span class="fa fa-cogs"></span> Mon menu';
$pages_menu[$categorie_menu][] = [
    'nom' => 'commande',
    'icone' => '<span class="fa fa-cogs"></span>',
    'adresse' => 'commande.php'
];
$pages_menu[$categorie_menu][] = [
    'nom' => 'parametre',
    'icone' => '<span class="fa fa-cogs"></span>',
    'adresse' => 'parametre.php'
];
$pages_menu[$categorie_menu][] = [
    'nom' => 'vue_utilisateur',
    'icone' => '<span class="fa fa-cogs"></span>',
    'adresse' => 'vue_utilisateur.php'
];
$pages_menu[$categorie_menu][] = [
    'nom' => 'conseil',
    'icone' => '<span class="fa fa-cogs"></span>',
    'adresse' => 'conseil.php'
];
$pages_menu[$categorie_menu][] = [
    'nom' => 'a_commande_article',
    'icone' => '<span class="fa fa-cogs"></span>',
    'adresse' => 'a_commande_article.php'
];
$pages_menu[$categorie_menu][] = [
    'nom' => 'a_parametre_utilisateur',
    'icone' => '<span class="fa fa-cogs"></span>',
    'adresse' => 'a_parametre_utilisateur.php'
];
$pages_menu[$categorie_menu][] = [
    'nom' => 'a_filtrer',
    'icone' => '<span class="fa fa-cogs"></span>',
    'adresse' => 'a_filtrer.php'
];

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
