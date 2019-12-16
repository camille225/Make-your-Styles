<?php

function est_connecte(): bool
{
    $db = new DB();
    return get_utilisateur_courant(MF_UTILISATEUR__ID) != null || $db->utilisateur()->mf_compter() == 0;
}

function est_administrateur(): bool
{
    $db = new DB();
    return get_utilisateur_courant(MF_UTILISATEUR_ADMINISTRATEUR) == 1 || $db->utilisateur()->mf_compter() == 0;
}

function menu_option_user()
{

    $code = '';
    if ( isset($_SESSION[PREFIXE_SESSION]['token']) ) {
        $code = '
        <li class="nav-item dropdown ml-lg-2">
        	<a class="nav-link dropdown-toggle" href="#" id="userDropdown" data-toggle="dropdown">
                <i class="align-middle fas fa-cog"></i>
            </a>
        	<div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
            	<a class="dropdown-item" href="utilisateur.php?act=apercu_utilisateur&Code_utilisateur='.get_utilisateur_courant(MF_UTILISATEUR__ID).'"><i class="align-middle mr-1 fas fa-fw fa-user"></i> Mon compte</a>
            	<a class="dropdown-item" href="?act=vider_cache"><i class="align-middle mr-1 fas fa-fw fa-cookie"></i> Vider le cache</a>
            	<div class="dropdown-divider"></div>
            	<a class="dropdown-item" href="?act=deconnexion"><i class="align-middle mr-1 ion ion-md-log-out"></i> Déconnexion</a>
        	</div>
        </li>';
    }

    return $code;
}
