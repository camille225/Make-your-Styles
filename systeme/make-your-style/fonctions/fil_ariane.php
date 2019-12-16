<?php

class Fil_Ariane {

    // partie privee

    private $liste_titres;
    private $racine;
    private $nb_titres;

    //partie publique

    function __construct($titre_accueil, $lien) {

        $racine = ( HTTPS_ON ? 'https://' : 'http://' ).$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'];
        $p=0;$i=0;
        while ($i = stripos($racine, FIN_ADRESSE_RACINE.'/', $i+1)) { $p = $i; }
        $this->racine = substr($racine, 0, $p+strlen(FIN_ADRESSE_RACINE.'/'));

        $this->liste_titres = array();
        $this->liste_titres[] = array( 'text' => htmlspecialchars($titre_accueil), 'link' => $this->racine.$lien );

        $this->nb_titres = 1;

    }

    function ajouter_titre( $titre, $lien ) {
        $titre = strip_tags(htmlspecialchars_decode($titre), '');
        if ($titre=='')
            $titre='&nbsp;';
        $this->liste_titres[] = array( 'text' => $titre, 'link' => $this->racine.$lien );
        $this->nb_titres++;
    }

    function generer_code() {
        if (USE_BOOTSTRAP)
        {
            return $this->generer_bootstrap_code();
        }
        $cmpt = 0;
        $code='<div class="fil_ariane masquer_pour_impression"><div class="boutons"><div id="logo_fil_ariane_gauche"></div>';
        foreach ($this->liste_titres as $key => $titre) {
            $cmpt++;
            if ( $key!=0 )
                $code.='<span class="sep"> > </span>';
            if ( $cmpt!=$this->nb_titres )
                $code.='<a href="'.$titre['link'].'">'.$titre['text'].'</a>';
            else
                $code.='<span class="current">'.$titre['text'].'</span>';
        }
        $code.='</div></div>';
        return $code;
    }

    function generer_code_template() {
        $cmpt = 0;
        $add = '';
        $code = '
            <nav aria-label="breadcrumb">
				<ol class="breadcrumb">';
        foreach ($this->liste_titres as $key => $titre) {
            $cmpt++;
            if ( $cmpt!=$this->nb_titres ) {
                $code.='
                    <li class="breadcrumb-item"><a href="'.$titre['link'].'">'.$titre['text'].'</a></li>';
            } else {
                $code.='
                    <li class="breadcrumb-item active" aria-current="page">'.$titre['text'].'</li>';
                $add = '<h1 class="header-title">'.$titre['text'].'</h1>';
            }
        }
        $code.='
                </ol>
            </nav>';
        return $add.$code;
    }

    private function generer_bootstrap_code() {
        $code = '';
        $code.= '<ul class="breadcrumb">';
        $cmpt = 0;
        foreach ($this->liste_titres as $key => $titre)
        {
            $cmpt++;
            if ( $cmpt!=$this->nb_titres )
            {
                $code.='<li><a href="'.$titre['link'].'">'.$titre['text'].'</a></li>';
            }
            else
            {
                $code.='<li class="active">'.$titre['text'].'</li>';
            }
        }
        $code.= '</ul>';
        return $code;
    }

    function generer_titre() {
        $code='<div class="fil_ariane">';
        foreach ($this->liste_titres as $key => $titre) {
            if ( $key!=0 ) $code.=' > ';
            $code.='<span>'.$titre['text'].'</span>';
        }
        $code.='</div>';
        return $code;
    }

    function get_last_lien() {
        return $this->liste_titres[count($this->liste_titres)-1]['link'];// . ( isset($_GET['secur']) ? '&secur=' . $_GET['secur'] : '' );
    }

}
