<?php declare(strict_types=1);

/*
    +------------------------------+
    |  NE PAS MODIFIER CE FICHIER  |
    +------------------------------+
*/

$Code_utilisateur = (isset($_GET['Code_utilisateur']) ? intval($_GET['Code_utilisateur']) : 0);
$Code_article = (isset($_GET['Code_article']) ? intval($_GET['Code_article']) : 0);
$Code_commande = (isset($_GET['Code_commande']) ? intval($_GET['Code_commande']) : 0);
$Code_categorie_article = (isset($_GET['Code_categorie_article']) ? intval($_GET['Code_categorie_article']) : 0);
$Code_parametre = (isset($_GET['Code_parametre']) ? intval($_GET['Code_parametre']) : 0);
$Code_vue_utilisateur = (isset($_GET['Code_vue_utilisateur']) ? intval($_GET['Code_vue_utilisateur']) : 0);
$Code_sous_categorie_article = (isset($_GET['Code_sous_categorie_article']) ? intval($_GET['Code_sous_categorie_article']) : 0);
$Code_conseil = (isset($_GET['Code_conseil']) ? intval($_GET['Code_conseil']) : 0);

require __DIR__ . '/genealogie.php';

function mf_Code_utilisateur(): int { global $mf_contexte; return (int) $mf_contexte['Code_utilisateur']; }
function mf_set_Code_utilisateur(int $Code_utilisateur) { global $mf_contexte; $mf_contexte['Code_utilisateur'] = $Code_utilisateur; }
function mf_Code_article(): int { global $mf_contexte; return (int) $mf_contexte['Code_article']; }
function mf_set_Code_article(int $Code_article) { global $mf_contexte; $mf_contexte['Code_article'] = $Code_article; }
function mf_Code_commande(): int { global $mf_contexte; return (int) $mf_contexte['Code_commande']; }
function mf_set_Code_commande(int $Code_commande) { global $mf_contexte; $mf_contexte['Code_commande'] = $Code_commande; }
function mf_Code_categorie_article(): int { global $mf_contexte; return (int) $mf_contexte['Code_categorie_article']; }
function mf_set_Code_categorie_article(int $Code_categorie_article) { global $mf_contexte; $mf_contexte['Code_categorie_article'] = $Code_categorie_article; }
function mf_Code_parametre(): int { global $mf_contexte; return (int) $mf_contexte['Code_parametre']; }
function mf_set_Code_parametre(int $Code_parametre) { global $mf_contexte; $mf_contexte['Code_parametre'] = $Code_parametre; }
function mf_Code_vue_utilisateur(): int { global $mf_contexte; return (int) $mf_contexte['Code_vue_utilisateur']; }
function mf_set_Code_vue_utilisateur(int $Code_vue_utilisateur) { global $mf_contexte; $mf_contexte['Code_vue_utilisateur'] = $Code_vue_utilisateur; }
function mf_Code_sous_categorie_article(): int { global $mf_contexte; return (int) $mf_contexte['Code_sous_categorie_article']; }
function mf_set_Code_sous_categorie_article(int $Code_sous_categorie_article) { global $mf_contexte; $mf_contexte['Code_sous_categorie_article'] = $Code_sous_categorie_article; }
function mf_Code_conseil(): int { global $mf_contexte; return (int) $mf_contexte['Code_conseil']; }
function mf_set_Code_conseil(int $Code_conseil) { global $mf_contexte; $mf_contexte['Code_conseil'] = $Code_conseil; }
