<?php
$desactivation_actualisation_outils_developpeur = true;

include __DIR__ . '/../../systeme/make-your-style/dblayer_light.php';

session_write_close();

$nom_fichier = (isset($_GET['n']) ? $_GET['n'] : '');

if (! Hook_mf_systeme::est_fichier_public($nom_fichier)) {
    if (isset($_GET['mf_token'])) {
        $token = $_GET['mf_token'];
        $mf_connexion = new Mf_Connexion(true);
    } else {
        $token = (isset($_SESSION[PREFIXE_SESSION]['token']) ? $_SESSION[PREFIXE_SESSION]['token'] : '');
        $mf_connexion = new Mf_Connexion();
    }
    if (! $mf_connexion->est_connecte($token)) {
        header('HTTP/1.0 404 Not Found');
        exit();
    }
}

if (! Hook_mf_systeme::controle_acces_fichier($nom_fichier)) {
    header('HTTP/1.0 404 Not Found');
    exit();
}

$libelle = nom_fichier_formate(isset($_GET['l']) ? $_GET['l'] : 'fichier');

$fichier = new Fichier();
$ext = $fichier->get_extention($nom_fichier);

if ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg' || $f = $fichier->get($nom_fichier)) {
    if ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg') // application/image
    {
        $format_png = (isset($_GET['format_png']) ? round($_GET['format_png']) == 1 : $ext == 'png');
        // cache client sur une journée
        header('Pragma: public');
        header('Cache-Control: max-age=' . (DUREE_CACHE_NAV_CLIENT_EN_JOURS * 86400));
        // image
        header('Content-Type: image;');
        if (! $format_png) {
            header('Content-Disposition: inline; filename="' . $libelle . '.jpeg"'); // conversion systématique en jpeg car moins de place
        } else {
            header('Content-Disposition: inline; filename="' . $libelle . '.png"');
        }
        $cache = new Cachehtml('', 'images');
        if (! $cache->start('', 525600)) // cache sur 365 jours
        {
            $width = (isset($_GET['width']) ? round($_GET['width']) : IMAGES_LARGEUR_MAXI);
            $height = (isset($_GET['height']) ? round($_GET['height']) : IMAGES_HAUTEUR_MAXI);
            $troncage = (isset($_GET['troncage']) ? $_GET['troncage'] == 1 : false);
            $rotate = (isset($_GET['rotate']) ? round($_GET['rotate']) % 360 : 0);
            $zoom = (isset($_GET['zoom']) ? round($_GET['zoom']) : 100);
            $xpos = (isset($_GET['xpos']) ? round($_GET['xpos']) : 50);
            $ypos = (isset($_GET['ypos']) ? round($_GET['ypos']) : 50);
            $quality = 75;
            $erase_image = false;
            $pourcentage_color = (isset($_GET['pourcentage_color']) ? round($_GET['pourcentage_color']) : 100);

            transformer_image($nom_fichier, $format_png, $width, $height, $troncage, $rotate, $zoom, $xpos, $ypos, $quality, $erase_image, $pourcentage_color);

            $cache->end();
        }
    }
    if ($ext == 'pdf') {
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . $libelle . '.pdf"');
        echo $f;
    }
    if ($ext == 'doc') {
        header('Content-Type: application/msword');
        header('Content-Disposition: attachment; filename="' . $libelle . '.doc"');
        echo $f;
    }
    if ($ext == 'docx') {
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Disposition: attachment; filename="' . $libelle . '.docx"');
        echo $f;
    }
    if ($ext == 'xls') {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="' . $libelle . '.xls"');
        echo $f;
    }
    if ($ext == 'xlsx') {
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $libelle . '.xlsx"');
        echo $f;
    }
    if ($ext == 'xml') {
        header('Content-Type: application/xml');
        header('Content-Disposition: attachment; filename="' . $libelle . '.xml"');
        echo $f;
    }
    if ($ext == 'rtf') {
        header('Content-Type: application/rtf');
        header('Content-Disposition: attachment; filename="' . $libelle . '.rtf"');
        echo $f;
    }
    if ($ext == 'csv') {
        header('Content-type: application/vnd.ms-excel');
        header('Content-disposition: attachment; filename="' . $libelle . '.csv"');
        echo $f;
    }
    if ($ext == 'xlsm') {
        header('Content-type: application/vnd.ms-excel.sheet.macroEnabled.12');
        header('Content-disposition: attachment; filename="' . $libelle . '.xlsm"');
        echo $f;
    }
    if ($ext == 'exe') {
        header('Content-type: application/octet-stream');
        header('Content-disposition: attachment; filename="' . $libelle . '.exe"');
        echo $f;
    }
    if ($ext == 'zip') {
        header('Content-type: application/zip');
        header('Content-disposition: attachment; filename="' . $libelle . '.zip"');
        echo $f;
    }
    if ($ext == 'pptx') {
        header('Content-type: application/vnd.openxmlformats-officedocument.presentationml.presentation');
        header('Content-disposition: attachment; filename="' . $libelle . '.pptx"');
        echo $f;
    }
    if ($ext == 'pptm') {
        header('Content-type: application/vnd.ms-powerpoint.presentation.macroEnabled.12');
        header('Content-disposition: attachment; filename="' . $libelle . '.pptm"');
        echo $f;
    }
} else {
    header('HTTP/1.0 404 Not Found');
}

fermeture_connexion_db();
