<?php declare(strict_types=1);

/*
    +------------------------------+
    |  NE PAS MODIFIER CE FICHIER  |
    +------------------------------+
*/

if ($Code_sous_categorie_article == 0 && $Code_article != 0) $Code_sous_categorie_article = $db->article()->mf_convertir_Code_article_vers_Code_sous_categorie_article($Code_article);
if ($Code_categorie_article == 0 && $Code_sous_categorie_article != 0) $Code_categorie_article = $db->sous_categorie_article()->mf_convertir_Code_sous_categorie_article_vers_Code_categorie_article($Code_sous_categorie_article);
if ($Code_utilisateur == 0 && $Code_commande != 0) $Code_utilisateur = $db->commande()->mf_convertir_Code_commande_vers_Code_utilisateur($Code_commande);

$mf_contexte = [];
$mf_contexte['Code_utilisateur'] = $Code_utilisateur;
$mf_contexte['Code_article'] = $Code_article;
$mf_contexte['Code_commande'] = $Code_commande;
$mf_contexte['Code_categorie_article'] = $Code_categorie_article;
$mf_contexte['Code_parametre'] = $Code_parametre;
$mf_contexte['Code_vue_utilisateur'] = $Code_vue_utilisateur;
$mf_contexte['Code_sous_categorie_article'] = $Code_sous_categorie_article;
$mf_contexte['Code_conseil'] = $Code_conseil;
