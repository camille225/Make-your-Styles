<?php

/*
    +------------------------------+
    |  NE PAS MODIFIER CE FICHIER  |
    +------------------------------+
*/

$Code_utilisateur = ( isset($_GET['Code_utilisateur']) ? round($_GET['Code_utilisateur']) : 0 );
$Code_article = ( isset($_GET['Code_article']) ? round($_GET['Code_article']) : 0 );
$Code_commande = ( isset($_GET['Code_commande']) ? round($_GET['Code_commande']) : 0 );
$Code_type_produit = ( isset($_GET['Code_type_produit']) ? round($_GET['Code_type_produit']) : 0 );
$Code_parametre = ( isset($_GET['Code_parametre']) ? round($_GET['Code_parametre']) : 0 );
$Code_filtre = ( isset($_GET['Code_filtre']) ? round($_GET['Code_filtre']) : 0 );

require __DIR__ . '/genealogie.php';

function mf_Code_utilisateur() { global $mf_contexte; return $mf_contexte['Code_utilisateur']; }
function mf_Code_article() { global $mf_contexte; return $mf_contexte['Code_article']; }
function mf_Code_commande() { global $mf_contexte; return $mf_contexte['Code_commande']; }
function mf_Code_type_produit() { global $mf_contexte; return $mf_contexte['Code_type_produit']; }
function mf_Code_parametre() { global $mf_contexte; return $mf_contexte['Code_parametre']; }
function mf_Code_filtre() { global $mf_contexte; return $mf_contexte['Code_filtre']; }
