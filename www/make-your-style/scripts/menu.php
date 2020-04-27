<?php declare(strict_types=1);
$pages_menu = [];

if (est_connecte()) {
    /* pages B1 */
    $pages_menu['<span class="fa fa-user"></span> Compte utilisateur'][] = [
        'nom' => 'Compte utilisateur',
        'icone' => 'fa fa-user',
        'adresse' => 'page_compte_utilisateur.php'
    ];
}
if (est_administrateur() || $db->utilisateur()->mf_compter() == 0) {
    $categorie_administrateur = '<span class="fa fa-cogs"></span> Paramétrage administrateur';
    $pages_menu[$categorie_administrateur][] = [
        'nom' => 'Utilisateurs',
        'icone' => 'fa fa-users',
        'adresse' => 'utilisateur.php'
    ];
    $pages_menu[$categorie_administrateur][] = [
        'nom' => 'Catégories d\'articles',
        'icone' => 'fa fa-box',
        'adresse' => 'categorie_article.php'
    ];
    $pages_menu[$categorie_administrateur][] = [
        'nom' => 'Conseils',
        'icone' => 'fa fa-comment',
        'adresse' => 'conseil.php'
    ];
    $pages_menu[$categorie_administrateur][] = [
        'nom' => 'Paramètres',
        'icone' => 'fa fa-cogs',
        'adresse' => 'parametre.php'
    ];
    $categorie_menu = '<span class="fa fa-cogs"></span> A paramétrer puis supprimer';
    $pages_menu[$categorie_menu][] = [
        'nom' => 'vue_utilisateur',
        'icone' => 'fa fa-cogs',
        'adresse' => 'vue_utilisateur.php'
    ];
    $pages_menu[$categorie_menu][] = [
        'nom' => 'a_filtrer',
        'icone' => 'fa fa-cogs',
        'adresse' => 'a_filtrer.php'
    ];
}

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
